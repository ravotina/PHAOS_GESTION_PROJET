<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Models\UtilisateurConcerner;
use App\Models\CalendrierPreparation;

class UtilisateurConcernerController extends Controller
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }
    //
    /**
     * Récupérer les utilisateurs concernés par un événement
     */

    public function getUtilisateursDisponibles(): JsonResponse
    {
        try {
            $usersData = $this->userModel->getAllUsers();
            
            if (isset($usersData['formatted']['users'])) {
                $users = collect($usersData['formatted']['users'])
                    ->map(function ($user) {
                        return [
                            'id' => $user['id'],
                            'nom_complet' => trim(($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? '')),
                            'login' => $user['login'],
                            'email' => $user['email'],
                            'admin' => $user['admin'] == '1',
                            'actif' => $user['active'] == '1'
                        ];
                    })
                    ->where('actif', true)
                    ->values();
                    
                return response()->json([
                    'success' => true,
                    'users' => $users
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Aucun utilisateur trouvé'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }


    public function getByCalendrier($calendrierId): JsonResponse
    {
        $utilisateurs = UtilisateurConcerner::where('id_calandrier', $calendrierId)
            ->get()
            ->map(function ($item) {
                $userInfo = $this->getUserInfo($item->id_utilsateur);
                
                return [
                    'id' => $item->id,
                    'utilisateur_id' => $item->id_utilsateur,
                    'description_tache' => $item->description_tache,
                    'utilisateur_info' => $userInfo
                ];
            });
            
        return response()->json($utilisateurs);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'id_utilsateur' => 'required|integer',
            'id_calandrier' => 'required|exists:calandrier_preparation,id',
            'description_tache' => 'nullable|string'
        ]);

        try {
            $existe = UtilisateurConcerner::where('id_utilsateur', $request->id_utilsateur)
                ->where('id_calandrier', $request->id_calandrier)
                ->exists();
                
            if ($existe) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cet utilisateur est déjà affecté à cet événement'
                ], 400);
            }

            $utilisateurConcerner = UtilisateurConcerner::create([
                'id_utilsateur' => $request->id_utilsateur,
                'id_calandrier' => $request->id_calandrier,
                'description_tache' => $request->description_tache
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Utilisateur ajouté à l\'événement',
                'data' => $utilisateurConcerner
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'description_tache' => 'nullable|string'
        ]);

        try {
            $utilisateurConcerner = UtilisateurConcerner::findOrFail($id);
            
            $utilisateurConcerner->update([
                'description_tache' => $request->description_tache
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tâche mise à jour',
                'data' => $utilisateurConcerner
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un utilisateur d'un événement
     */
    public function destroy($id): JsonResponse
    {
        try {
            $utilisateurConcerner = UtilisateurConcerner::findOrFail($id);
            $utilisateurConcerner->delete();

            return response()->json([
                'success' => true,
                'message' => 'Utilisateur retiré de l\'événement'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupérer les événements d'un utilisateur
     */
    public function getEventsByUtilisateur($utilisateurId): JsonResponse
    {
        $evenements = UtilisateurConcerner::with(['calendrier', 'calendrier.projet'])
            ->where('id_utilsateur', $utilisateurId)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->calendrier->id,
                    'title' => $item->calendrier->title,
                    'start' => $item->calendrier->date_debut,
                    'end' => $item->calendrier->date_fin,
                    'description' => $item->calendrier->decription,
                    'color' => $item->calendrier->color,
                    'ma_tache' => $item->description_tache
                ];
            });
            
        return response()->json($evenements);
    }

    /**
     * Récupérer les informations d'un utilisateur depuis Dolibarr
     */
    private function getUserInfo($userId)
    {
        try {
            $usersData = $this->userModel->getAllUsers();
            
            if (isset($usersData['formatted']['users'])) {
                $user = collect($usersData['formatted']['users'])
                    ->firstWhere('id', $userId);
                    
                if ($user) {
                    return [
                        'nom_complet' => trim(($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? '')),
                        'login' => $user['login'],
                        'email' => $user['email'],
                        'telephone' => $user['phone']
                    ];
                }
            }
            
            return [
                'nom_complet' => 'Utilisateur inconnu',
                'login' => 'N/A',
                'email' => 'N/A',
                'telephone' => 'N/A'
            ];
            
        } catch (\Exception $e) {
            return [
                'nom_complet' => 'Erreur récupération',
                'login' => 'N/A',
                'email' => 'N/A',
                'telephone' => 'N/A'
            ];
        }
    }

}
