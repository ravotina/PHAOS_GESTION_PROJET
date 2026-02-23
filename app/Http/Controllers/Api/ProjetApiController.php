<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjetDemare;
use App\Models\TypeProjet;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProjetApiController extends Controller
{
    private $dolibarrClient;
    private $users;

    public function __construct()
    {
        $this->dolibarrClient = new Client();
        $this->users = new User();
        
        // Middleware d'authentification pour toutes les routes
        //$this->middleware('auth:sanctum')->except(['login']);
    }

    /**
     * Récupérer les données nécessaires pour le formulaire
     */
    public function getFormData(): JsonResponse
    {
        try {
            // Récupérer les types de projet
            $typesProjet = TypeProjet::select('id as id', 'nom as label')
                ->orderBy('nom')
                ->get();
            
            // Récupérer les clients depuis Dolibarr
            $clientsData = $this->dolibarrClient->getAllClients(100);
            $clients = array_map(function($client) {
                return [
                    'id' => $client['id'] ?? $client['rowid'] ?? null,
                    'name' => $client['name'] ?? $client['nom'] ?? 'N/A',
                    'code_client' => $client['code_client'] ?? $client['code'] ?? '',
                    'email' => $client['email'] ?? '',
                    'phone' => $client['phone'] ?? $client['phone_pro'] ?? '',
                ];
            }, $clientsData['formatted']['clients'] ?? []);
            
            // Récupérer les utilisateurs
            $utilisateursData = $this->users->getAllUsers();
            $utilisateurs = array_map(function($user) {
                return [
                    'id' => $user['id'] ?? $user['rowid'] ?? null,
                    'firstname' => $user['firstname'] ?? '',
                    'lastname' => $user['lastname'] ?? '',
                    'login' => $user['login'] ?? '',
                    'email' => $user['email'] ?? '',
                    'full_name' => trim(($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? '')),
                ];
            }, $utilisateursData['formatted']['users'] ?? []);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'types_projet' => $typesProjet,
                    'clients' => $clients,
                    'utilisateurs' => $utilisateurs,
                ],
                'message' => 'Données du formulaire récupérées avec succès'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur getFormData: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des données',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Créer un nouveau projet
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Validation des données
            $validator = Validator::make($request->all(), [
                'non_de_projet' => 'required|string|max:250|unique:projet_demare,non_de_projet',
                'date_debu' => 'nullable|date',
                'date_fin' => 'nullable|date|after_or_equal:date_debu',
                'dedlinne' => 'nullable|integer|min:0',
                'description' => 'nullable|string',
                'id_utilisateur' => 'required|integer',
                'id_client' => 'required|integer',
                'id_projet' => 'required|integer|exists:type_projet,id_projet'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Création du projet
            $projetData = $request->all();
            
            // Ajouter le statut par défaut
            $projetData['status'] = 'brouillon';
            
            // Si l'utilisateur n'est pas spécifié, utiliser l'utilisateur connecté
            if (empty($projetData['id_utilisateur']) && auth()->check()) {
                $projetData['id_utilisateur'] = auth()->id();
            }

            $projet = ProjetDemare::createProjet($projetData);
            
            return response()->json([
                'success' => true,
                'data' => $projet,
                'message' => 'Projet créé avec succès'
            ], 201);
            
        } catch (\Exception $e) {
            Log::error('Erreur store projet: ' . $e->getMessage(), [
                'data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du projet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupérer tous les projets
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = ProjetDemare::with('typeProjet');
            
            // Filtrage par statut
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
            
            // Filtrage par utilisateur
            if ($request->has('utilisateur_id')) {
                $query->where('id_utilisateur', $request->utilisateur_id);
            }
            
            // Filtrage par client
            if ($request->has('client_id')) {
                $query->where('id_client', $request->client_id);
            }
            
            // Pagination
            $perPage = $request->get('per_page', 15);
            $projets = $query->orderBy('id', 'desc')->paginate($perPage);
            
            return response()->json([
                'success' => true,
                'data' => $projets,
                'message' => 'Projets récupérés avec succès'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur index projets: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des projets',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupérer un projet spécifique
     */
    public function show($id): JsonResponse
    {
        try {
            $projet = ProjetDemare::with('typeProjet')->find($id);
            
            if (!$projet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Projet non trouvé'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => $projet,
                'message' => 'Projet récupéré avec succès'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur show projet: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du projet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour un projet
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $projet = ProjetDemare::find($id);
            
            if (!$projet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Projet non trouvé'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'non_de_projet' => 'required|string|max:250|unique:projet_demare,non_de_projet,' . $id . ',id',
                'date_debu' => 'nullable|date',
                'date_fin' => 'nullable|date|after_or_equal:date_debu',
                'dedlinne' => 'nullable|integer|min:0',
                'description' => 'nullable|string',
                'id_utilisateur' => 'required|integer',
                'id_client' => 'required|integer',
                'id_projet' => 'required|integer|exists:type_projet,id_projet',
                'status' => 'nullable|in:brouillon,en_attente,en_cours,termine,annule'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $projet->updateProjet($id, $request->all());
            
            return response()->json([
                'success' => true,
                'data' => $projet->fresh(),
                'message' => 'Projet mis à jour avec succès'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur update projet: ' . $e->getMessage(), [
                'id' => $id,
                'data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du projet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un projet
     */
    public function destroy($id): JsonResponse
    {
        try {
            $projet = ProjetDemare::find($id);
            
            if (!$projet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Projet non trouvé'
                ], 404);
            }

            $projet->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Projet supprimé avec succès'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur destroy projet: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du projet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupérer uniquement les types de projet
     */
    public function getTypesProjet(): JsonResponse
    {
        try {
            $types = TypeProjet::select('id as id', 'nom as label')
                ->orderBy('nom')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $types,
                'message' => 'Types de projet récupérés avec succès'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur getTypesProjet: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des types de projet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupérer uniquement les clients
     */
    public function getClients(): JsonResponse
    {
        try {
            $clientsData = $this->dolibarrClient->getAllClients(100);
            $clients = array_map(function($client) {
                return [
                    'id' => $client['id'] ?? $client['rowid'] ?? null,
                    'name' => $client['name'] ?? $client['nom'] ?? 'N/A',
                    'code_client' => $client['code_client'] ?? $client['code'] ?? '',
                    'email' => $client['email'] ?? '',
                    'phone' => $client['phone'] ?? $client['phone_pro'] ?? '',
                    'address' => $client['address'] ?? $client['address1'] ?? '',
                    'zip' => $client['zip'] ?? '',
                    'town' => $client['town'] ?? '',
                ];
            }, $clientsData['formatted']['clients'] ?? []);
            
            return response()->json([
                'success' => true,
                'data' => $clients,
                'message' => 'Clients récupérés avec succès'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur getClients: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des clients',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupérer uniquement les utilisateurs
     */
    public function getUtilisateurs(): JsonResponse
    {
        try {
            $utilisateursData = $this->users->getAllUsers();
            $utilisateurs = array_map(function($user) {
                return [
                    'id' => $user['id'] ?? $user['rowid'] ?? null,
                    'firstname' => $user['firstname'] ?? '',
                    'lastname' => $user['lastname'] ?? '',
                    'login' => $user['login'] ?? '',
                    'email' => $user['email'] ?? '',
                    'phone' => $user['phone'] ?? '',
                    'full_name' => trim(($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? '')),
                ];
            }, $utilisateursData['formatted']['users'] ?? []);
            
            return response()->json([
                'success' => true,
                'data' => $utilisateurs,
                'message' => 'Utilisateurs récupérés avec succès'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur getUtilisateurs: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des utilisateurs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rechercher des projets
     */
    public function search($term): JsonResponse
    {
        try {
            $projets = ProjetDemare::search($term)
                ->with('typeProjet')
                ->orderBy('id', 'desc')
                ->limit(20)
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $projets,
                'message' => 'Recherche effectuée avec succès'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur search projets: ' . $e->getMessage(), [
                'term' => $term,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}