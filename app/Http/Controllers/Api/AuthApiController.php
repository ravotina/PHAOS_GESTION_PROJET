<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Permission;
use App\Models\Token;
use Illuminate\Support\Facades\Http;

class AuthApiController extends Controller
{
    private $userModel;
    private $permissionModel;
    private $tokenModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->permissionModel = new Permission();
        $this->tokenModel = new Token();
    }

    /**
     * API Login
    */
    public function login(Request $request)
    {
        Log::info('API Login attempt', ['login' => $request->login]);

        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            // Authentification avec ton modèle existant
            $dolibarrToken = $this->userModel->authenticate($request->login, $request->password);

            // Debug
            Log::info('Résultat authentification:', [
                'token' => $dolibarrToken,
                'type' => gettype($dolibarrToken)
            ]);

            if (!$dolibarrToken) {
                Log::warning('Authentification échouée', ['login' => $request->login]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Identifiants incorrects'
                ], 401);
            }

            // S'assurer que c'est une chaîne
            if (!is_string($dolibarrToken)) {
                Log::error('Token invalide - type: ' . gettype($dolibarrToken), [
                    'token' => $dolibarrToken
                ]);
                
                // Essayer de convertir en chaîne si c'est un tableau
                if (is_array($dolibarrToken)) {
                    $dolibarrToken = json_encode($dolibarrToken);
                } else {
                    $dolibarrToken = (string) $dolibarrToken;
                }
            }

            Log::info('Token obtenu (premiers 20 caractères):', [
                'token' => substr($dolibarrToken, 0, 20) . '...'
            ]);

            // Récupérer l'ID utilisateur via la classe Token
            $userId = $this->tokenModel->getUserIdByToken($dolibarrToken);

            if (!$userId) {
                Log::error('Impossible de récupérer l\'ID utilisateur', [
                    'login' => $request->login,
                    'token' => substr($dolibarrToken, 0, 20) . '...'
                ]);
                
                // Pour debug, essaie d'appeler directement l'API Dolibarr
                $users = $this->getUserFromDolibarr($dolibarrToken, $request->login);
                
                if ($users && isset($users[0]['id'])) {
                    $userId = $users[0]['id'];
                    Log::info('ID utilisateur récupéré directement', ['user_id' => $userId]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Impossible de récupérer l\'ID utilisateur'
                    ], 500);
                }
            }

            Log::info('ID utilisateur trouvé:', ['user_id' => $userId]);

            // Récupérer les permissions
            $permissions = $this->permissionModel->getUserPermissions($userId);

            // Récupérer les données complètes avec token admin
            $userData = $this->tokenModel->getUserWithAdminToken($userId, $dolibarrToken);

            // Vérifier si on a bien récupéré les données
            if (!$userData || !isset($userData['user'])) {
                Log::error('Données utilisateur non récupérées', ['user_id' => $userId]);
                
                // Essayer de récupérer directement depuis l'API
                $directUserData = $this->getUserDataDirectly($dolibarrToken, $userId);
                
                if ($directUserData) {
                    $userData = ['user' => $directUserData];
                } else {
                    // Données minimales
                    $userData = [
                        'user' => [
                            'id' => $userId,
                            'login' => $request->login,
                            'firstname' => '',
                            'lastname' => '',
                            'email' => '',
                            'photo' => null,
                            'job' => 'Commercial'
                        ]
                    ];
                }
            }

            Log::info('API Login successful', [
                'user_id' => $userId,
                'login' => $request->login
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie',
                'data' => [
                    'user' => [
                        'id' => $userId,
                        'login' => $request->login,
                        'full_name' => ($userData['user']['firstname'] ?? '') . ' ' . ($userData['user']['lastname'] ?? ''),
                        'firstname' => $userData['user']['firstname'] ?? '',
                        'lastname' => $userData['user']['lastname'] ?? '',
                        'email' => $userData['user']['email'] ?? '',
                        'photo' => $userData['user']['photo'] ?? null,
                        'role' => $userData['user']['job'] ?? 'Commercial'
                    ],
                    'dolibarr_token' => $dolibarrToken,
                    'permissions' => $permissions
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('API Login error', [
                'login' => $request->login,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur de connexion: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Méthode helper pour récupérer directement un utilisateur depuis Dolibarr
     */
    // private function getUserFromDolibarr($token, $login)
    // {
    //     try {
    //         $dolibarrUrl = env('DOLIBARR_URL') . 'index.php';
            
    //         $response = Http::timeout(30)->withHeaders([
    //             'DOLAPIKEY' => $token
    //         ])->get($dolibarrUrl . '/users', [
    //             'login' => $login,
    //             'limit' => 1
    //         ]);

    //         if ($response->successful()) {
    //             return $response->json();
    //         }
            
    //         return null;
            
    //     } catch (\Exception $e) {
    //         Log::error('Erreur récupération directe utilisateur: ' . $e->getMessage());
    //         return null;
    //     }
    // }

    /**
     * Méthode helper pour récupérer les données utilisateur directement
     */
    // private function getUserDataDirectly($token, $userId)
    // {
    //     try {
    //         $dolibarrUrl = env('DOLIBARR_URL') . 'index.php';
            
    //         $response = Http::timeout(30)->withHeaders([
    //             'DOLAPIKEY' => $token
    //         ])->get($dolibarrUrl . '/users/' . $userId);

    //         if ($response->successful()) {
    //             return $response->json();
    //         }
            
    //         return null;
            
    //     } catch (\Exception $e) {
    //         Log::error('Erreur récupération données utilisateur: ' . $e->getMessage());
    //         return null;
    //     }
    // }


    /**
     * Méthode de test pour voir la réponse de Dolibarr
    */
    // public function testDolibarrLogin(Request $request)
    // {
    //     $request->validate([
    //         'login' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     try {
    //         $dolibarrUrl = env('DOLIBARR_URL') . 'index.php';
            
    //         $response = Http::timeout(30)->post($dolibarrUrl . '/login', [
    //             'login' => $request->login,
    //             'password' => $request->password
    //         ]);

    //         return response()->json([
    //             'status' => $response->status(),
    //             'headers' => $response->headers(),
    //             'body' => $response->body(),
    //             'json' => $response->json(),
    //             'successful' => $response->successful(),
    //             'failed' => $response->failed()
    //         ]);
            
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ], 500);
    //     }
    // }

}