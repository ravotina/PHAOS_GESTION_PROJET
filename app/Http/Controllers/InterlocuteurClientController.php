<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InterlocuteurClientController extends Controller
{
    /**
     * Récupérer les interlocuteurs d'un client selon les permissions de l'utilisateur
     */
    public function getByClient(Request $request, $clientId)
    {
        try {
            // Récupérer l'ID utilisateur depuis la requête
            $userId = $request->query('user_id');
            
            if (!$userId) {
                // Si pas d'ID utilisateur, vérifier dans la session
                $userId = session('user.id');
            }
            
            Log::info('Récupération interlocuteurs', [
                'client_id' => $clientId,
                'user_id' => $userId
            ]);
            
            // 1. Récupérer TOUS les interlocuteurs de ce client
            $interlocuteurs = DB::table('interlocuteur')
                ->where('id_client', $clientId)
                ->orderBy('nom_interlocuteur')
                ->get();
            
            Log::info('Interlocuteurs trouvés pour ce client', [
                'total' => $interlocuteurs->count(),
                'client_id' => $clientId
            ]);
            
            // 2. Filtrer : garder seulement ceux que l'utilisateur peut voir
            $interlocuteursFiltres = [];
            $permissionsService = app('permission');
            $hasApiPermission = $permissionsService->hasModule('api');
            
            Log::info('Permissions utilisateur', [
                'has_api_permission' => $hasApiPermission
            ]);
            
            foreach ($interlocuteurs as $interlocuteur) {
                // Vérifier si l'utilisateur a la permission API
                if ($hasApiPermission) {
                    // Avec permission API : voir tout
                    $interlocuteursFiltres[] = [
                        'id' => $interlocuteur->id,
                        'id_client' => $interlocuteur->id_client,
                        'nom_interlocuteur' => $interlocuteur->nom_interlocuteur,
                        'fonction' => $interlocuteur->fonction,
                        'numero' => $interlocuteur->numero,
                        'utilisateur_ids' => DB::table('interlocateur_utilisateur')
                            ->where('id_interlocuteur', $interlocuteur->id)
                            ->pluck('id_utilisateur')
                            ->toArray()
                    ];
                    Log::debug('Accès API - interlocuteur autorisé', [
                        'interlocuteur_id' => $interlocuteur->id,
                        'nom' => $interlocuteur->nom_interlocuteur
                    ]);
                } else {
                    // Sans permission API : vérifier la table pivot
                    $peutVoir = DB::table('interlocateur_utilisateur')
                        ->where('id_interlocuteur', $interlocuteur->id)
                        ->where('id_utilisateur', $userId)
                        ->exists();
                    
                    Log::debug('Vérification accès table pivot', [
                        'interlocuteur_id' => $interlocuteur->id,
                        'user_id' => $userId,
                        'peut_voir' => $peutVoir
                    ]);
                    
                    if ($peutVoir) {
                        $interlocuteursFiltres[] = [
                            'id' => $interlocuteur->id,
                            'id_client' => $interlocuteur->id_client,
                            'nom_interlocuteur' => $interlocuteur->nom_interlocuteur,
                            'fonction' => $interlocuteur->fonction,
                            'numero' => $interlocuteur->numero,
                            'utilisateur_ids' => DB::table('interlocateur_utilisateur')
                                ->where('id_interlocuteur', $interlocuteur->id)
                                ->pluck('id_utilisateur')
                                ->toArray()
                        ];
                    }
                }
            }
            
            Log::info('Interlocuteurs filtrés', [
                'client_id' => $clientId,
                'user_id' => $userId,
                'count' => count($interlocuteursFiltres),
                'has_api' => $hasApiPermission
            ]);
            
            return response()->json([
                'success' => true,
                'client_id' => $clientId,
                'user_id' => $userId,
                'interlocuteurs' => $interlocuteursFiltres,
                'count' => count($interlocuteursFiltres),
                'has_api_permission' => $hasApiPermission,
                'message' => count($interlocuteursFiltres) > 0 ? 
                    'Interlocuteurs récupérés avec succès' : 
                    'Aucun interlocuteur accessible'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur dans getByClient', [
                'client_id' => $clientId,
                'user_id' => $request->query('user_id'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des interlocuteurs',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }




    // public function getByClientSimple(Request $request, $clientId)
    // {
    //     try {
    //         $userId = $request->query('user_id') ?: session('user.id');
            
    //         // 1. Récupérer les interlocuteurs du client
    //         $interlocuteurs = DB::table('interlocuteur')
    //             ->where('id_client', $clientId)
    //             ->select('id', 'id_client', 'nom_interlocuteur','fonction', ' email' , 'lieu_operation')
    //             ->orderBy('nom_interlocuteur')
    //             ->get();
            
    //         // 2. TOUJOURS vérifier la table pivot (même pour les admins)
    //         $resultats = [];
            
    //         foreach ($interlocuteurs as $interlocuteur) {
    //             $exists = DB::table('interlocateur_utilisateur')
    //                 ->where('id_interlocuteur', $interlocuteur->id)
    //                 ->where('id_utilisateur', $userId)
    //                 ->exists();
                
    //             if ($exists) {
    //                 $resultats[] = $interlocuteur;
    //             }
    //         }
            
    //         return response()->json([
    //             'success' => true,
    //             'client_id' => (int)$clientId,
    //             'user_id' => (int)$userId,
    //             'interlocuteurs' => $resultats,
    //             'count' => count($resultats),
    //             'note' => 'Filtrage strict par table pivot uniquement'
    //         ]);
            
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Erreur: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }




    public function getByClientSimple(Request $request, $clientId)
    {
        try {
            $userId = $request->query('user_id') ?: session('user.id');
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non identifié'
                ], 401);
            }
            
            \Log::info('getByClientSimple appelé', [
                'client_id' => $clientId,
                'user_id' => $userId
            ]);
            
            // 1. Récupérer les interlocuteurs du client avec leurs numéros
            $interlocuteurs = DB::table('interlocuteur')
                ->where('id_client', $clientId)
                ->select('id', 'id_client', 'nom_interlocuteur', 'fonction', 'email', 'lieu_operation')
                ->orderBy('nom_interlocuteur')
                ->get();
            
            \Log::info('Interlocuteurs trouvés:', ['count' => $interlocuteurs->count()]);
            
            // 2. TOUJOURS vérifier la table pivot (même pour les admins)
            $resultats = [];
            
            foreach ($interlocuteurs as $interlocuteur) {
                $exists = DB::table('interlocateur_utilisateur')
                    ->where('id_interlocuteur', $interlocuteur->id)
                    ->where('id_utilisateur', $userId)
                    ->exists();
                
                \Log::debug('Vérification pivot', [
                    'interlocuteur_id' => $interlocuteur->id,
                    'user_id' => $userId,
                    'exists' => $exists
                ]);
                
                if ($exists) {
                    // Récupérer les numéros de téléphone depuis la table interlocuteur_numeros
                    $numeros = DB::table('interlocuteur_numeros')
                        ->where('id_interlocuteur', $interlocuteur->id)
                        ->pluck('numero')
                        ->toArray();
                    
                    // Récupérer les utilisateurs associés
                    $utilisateurs = DB::table('interlocateur_utilisateur')
                        ->where('id_interlocuteur', $interlocuteur->id)
                        ->pluck('id_utilisateur')
                        ->toArray();
                    
                    $resultats[] = [
                        'id' => $interlocuteur->id,
                        'id_client' => $interlocuteur->id_client,
                        'nom_interlocuteur' => $interlocuteur->nom_interlocuteur,
                        'fonction' => $interlocuteur->fonction,
                        'email' => $interlocuteur->email,
                        'lieu_operation' => $interlocuteur->lieu_operation,
                        'numeros' => $numeros, // Tableau de numéros
                        'utilisateur_ids' => $utilisateurs
                    ];
                }
            }
            
            \Log::info('Interlocuteurs filtrés:', ['count' => count($resultats)]);
            
            return response()->json([
                'success' => true,
                'client_id' => (int)$clientId,
                'user_id' => (int)$userId,
                'interlocuteurs' => $resultats,
                'count' => count($resultats),
                'message' => count($resultats) > 0 
                    ? 'Interlocuteurs récupérés avec succès' 
                    : 'Aucun interlocuteur accessible pour cet utilisateur',
                'note' => 'Filtrage strict par table pivot uniquement'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Erreur dans getByClientSimple', [
                'client_id' => $clientId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }





}