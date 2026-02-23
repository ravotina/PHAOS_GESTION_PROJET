<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Token;

class User
{
    private $dolibarrUrl;
    private $tokenModel;

    public function __construct()
    {
        $this->dolibarrUrl = env('DOLIBARR_URL') . 'index.php';
       
    }
    
    /**
     * Authentifier l'utilisateur
    */
    public function authenticate($login, $password)
    {
        try {
            $response = Http::timeout(30)->post($this->dolibarrUrl . '/login', [
                'login' => $login,
                'password' => $password
            ]);

            Log::info('Réponse authentification Dolibarr:', [
                'status' => $response->status(),
                'login' => $login,
                'body' => $response->body() // Ajout pour debug
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Debug: Voir ce qui est retourné
                Log::info('Données reçues de Dolibarr:', ['data' => $data]);
                
                // Vérifier la structure de la réponse
                if (isset($data['success'])) {
                    // Si c'est une chaîne (token)
                    if (is_string($data['success'])) {
                        return $data['success'];
                    } 
                    // Si c'est un tableau (avec token et autres infos)
                    elseif (is_array($data['success']) && isset($data['success']['token'])) {
                        return $data['success']['token'];
                    }
                    // Si c'est un booléen
                    elseif (is_bool($data['success']) && $data['success'] === true) {
                        // Si Dolibarr retourne juste true, on doit récupérer le token autrement
                        // Peut-être dans les headers ou une autre propriété
                        Log::info('Dolibarr a retourné success=true');
                        
                        // Essayer de récupérer le token depuis une autre propriété
                        if (isset($data['token'])) {
                            return $data['token'];
                        }
                        
                        // Retourner une valeur par défaut pour tester
                        return 'dolibarr_token_' . $login;
                    }
                }
                
                // Autres formats possibles
                if (isset($data['token'])) {
                    return $data['token'];
                }
                
                Log::warning('Format de réponse non reconnu', ['data' => $data]);
                return null;
            } else {
                Log::error('Erreur authentification - Statut: ' . $response->status());
                return null;
            }

        } catch (\Exception $e) {
            Log::error('Erreur authentification Dolibarr: ' . $e->getMessage());
            return null;
        }
    }


    public function getAllUsers()
    {
        try {
            //$token_utilisateur = $token;
             $this->tokenModel = new Token();
            Log::info('Tentative de récupération de tous les utilisateurs');

            $response = Http::timeout(30)->withHeaders([
                'DOLAPIKEY' => $this->tokenModel->getAdminToken(),
                'Content-Type' => 'application/json'
            ])->get($this->dolibarrUrl . '/users', [
                'sortorder' => 'ASC'
            ]);

            if ($response->successful()) {
                $users = $response->json();
                Log::info('Utilisateurs récupérés avec succès: ' . count($users) . ' trouvés');
                
                return $this->formatUsers($users);
            } else {
                Log::warning('Erreur récupération utilisateurs - Statut: ' . $response->status());
                return $this->getEmptyUsersResponse();
            }

        } catch (\Exception $e) {
            Log::error('Erreur récupération utilisateurs: ' . $e->getMessage());
            return $this->getEmptyUsersResponse();
        }
    }



    public function getById($id)
    {
        try {
            $this->tokenModel = new Token();
            Log::info('Tentative de récupération de l\'utilisateur avec ID: ' . $id);

            $response = Http::timeout(30)->withHeaders([
                'DOLAPIKEY' => $this->tokenModel->getAdminToken(),
                'Content-Type' => 'application/json'
            ])->get($this->dolibarrUrl . '/users/' . $id);

            if ($response->successful()) {
                $user = $response->json();
                Log::info('Utilisateur récupéré avec succès', ['id' => $id, 'login' => $user['login'] ?? 'N/A']);
                return $user;
            } else {
                Log::warning('Erreur récupération utilisateur - Statut: ' . $response->status() . ', ID: ' . $id);
                return null;
            }

        } catch (\Exception $e) {
            Log::error('Erreur récupération utilisateur par ID: ' . $e->getMessage(), ['id' => $id]);
            return null;
        }
    }



        /**
     * Formater les données utilisateurs
     */
    private function formatUsers($usersData)
    {
        $users = $usersData;

        $formatted = [
            'raw_data' => $usersData,
            'formatted' => [
                'users' => [],
                'summary' => [
                    'total_users' => count($users),
                    'active_users' => 0,
                    'admin_users' => 0
                ]
            ]
        ];

        foreach ($users as $user) {
            $formattedUser = [
                'id' => $user['id'] ?? null,
                'login' => $user['login'] ?? 'N/A',
                'lastname' => $user['lastname'] ?? null,
                'firstname' => $user['firstname'] ?? null,
                'email' => $user['email'] ?? null,
                'phone' => $user['phone'] ?? null,
                'admin' => $user['admin'] ?? '0',
                'active' => $user['statut'] ?? '0',
                'photo' => $user['photo'] ?? null,
                'date_creation' => $user['date_creation'] ?? null,
                'date_creation_formatted' => $this->formatTimestamp($user['date_creation'] ?? null)
            ];

            $formatted['formatted']['users'][] = $formattedUser;

            // Statistiques
            if ($formattedUser['active'] == '1') {
                $formatted['formatted']['summary']['active_users']++;
            }
            if ($formattedUser['admin'] == '1') {
                $formatted['formatted']['summary']['admin_users']++;
            }
        }

        return $formatted;
    }

    /**
     * Formater le timestamp
     */
    private function formatTimestamp($timestamp)
    {
        if (!$timestamp) {
            return null;
        }

        return date('d/m/Y H:i', $timestamp);
    }

    /**
     * Retourne une structure vide pour les utilisateurs
     */
    private function getEmptyUsersResponse()
    {
        return [
            'raw_data' => [],
            'formatted' => [
                'users' => [],
                'summary' => [
                    'total_users' => 0,
                    'active_users' => 0,
                    'admin_users' => 0
                ]
            ]
        ];
    }





    public function getUserByLoginFromList($login)
    {
        try {
            Log::info('Recherche utilisateur par login via liste complète', ['login' => $login]);
            
            // Initialiser le modèle Token
            $this->tokenModel = new Token();
            
            // Récupérer le token admin
            $adminToken = $this->tokenModel->getAdminToken();
            
            if (!$adminToken) {
                // Log::error('Token admin non disponible');
                return null;
            }
            
            $response = Http::timeout(30)->withHeaders([
                'DOLAPIKEY' => $adminToken,
                'Content-Type' => 'application/json'
            ])->get($this->dolibarrUrl . '/users', [
                'sortfield' => 'login',
                'sortorder' => 'ASC',
                'limit' => 1000 // Limite raisonnable
            ]);
            
            if (!$response->successful()) {
                return null;
            }
            
            $users = $response->json();
            // Log::info('Nombre total d\'utilisateurs récupérés', ['count' => count($users)]);
            
            // 2. Rechercher dans la liste l'utilisateur avec le login correspondant
            $foundUser = null;
            
            foreach ($users as $user) {
                // Comparaison insensible à la casse pour plus de robustesse
                if (isset($user['login']) && strtolower($user['login']) === strtolower($login)) {
                    $foundUser = $user;
                    break;
                }
            }
            
            // 3. Si trouvé, retourner l'utilisateur formaté
            if ($foundUser) {
                return $this->formatSingleUser($foundUser);
            }
        
            return null;
            
        } catch (\Exception $e) {
        
            return null;
        }
    }



    private function formatSingleUser($user)
    {
        return [
            'id' => $user['id'] ?? null,
            'login' => $user['login'] ?? 'N/A',
            'lastname' => $user['lastname'] ?? '',
            'firstname' => $user['firstname'] ?? '',
            'fullname' => trim(($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? '')),
            'email' => $user['email'] ?? '',
            'phone' => $user['phone'] ?? '',
            'mobile' => $user['mobile'] ?? '',
            'admin' => $user['admin'] ?? '0',
            'active' => $user['statut'] ?? '0',
            'photo' => $user['photo'] ?? null,
            'job' => $user['job'] ?? '',
            'date_creation' => $user['date_creation'] ?? null,
            'date_creation_formatted' => $this->formatTimestamp($user['date_creation'] ?? null)
        ];
    }




    /**
     * Récupérer l'ID utilisateur par login - Version améliorée
     */
    public function getUserIdByLogin($token, $login)
    {
        try {
            Log::info('Tentative de récupération ID pour: ' . $login);

            $response = Http::timeout(30)->withHeaders([
                'DOLAPIKEY' => $token
            ])->get($this->dolibarrUrl . '/users', [
                'login' => $login,
                'limit' => 1
            ]);

            if ($response->successful()) {
                $users = $response->json();
                Log::info('Utilisateurs trouvés:', ['count' => count($users), 'data' => $users]);

                if (!empty($users) && isset($users[0]['id'])) {
                    $userId = $users[0]['id'];
                    Log::info('ID utilisateur trouvé: ' . $userId);
                    return $userId;
                } else {
                    Log::warning('Aucun utilisateur trouvé pour le login: ' . $login);
                    return null;
                }
            } else {
                Log::error('Erreur récupération ID utilisateur - Statut: ' . $response->status());
                return null;
            }

        } catch (\Exception $e) {
            Log::error('Erreur récupération ID utilisateur: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Vérifier si l'utilisateur a une permission spécifique
     */
    public static function hasPermission($module, $permission)
    {
        $userPermissions = Session::get('user_permissions');
        
        if (!$userPermissions || !isset($userPermissions['formatted']['by_module'][$module])) {
            return false;
        }

        return $userPermissions['formatted']['by_module'][$module][$permission] ?? false;
    }

    /**
     * Vérifier si l'utilisateur a au moins une permission dans un module
     */
    public static function hasModulePermission($module)
    {
        $userPermissions = Session::get('user_permissions');
        
        if (!$userPermissions || !isset($userPermissions['formatted']['by_module'][$module])) {
            return false;
        }

        foreach ($userPermissions['formatted']['by_module'][$module] as $perm => $enabled) {
            if ($enabled) {
                return true;
            }
        }

        return false;
    }

    /**
     * Récupérer toutes les permissions de l'utilisateur
     */
    public static function getPermissions()
    {
        return Session::get('user_permissions');
    }

    /**
     * Vérifier si l'utilisateur est connecté
     */
    public static function isAuthenticated()
    {
        return Session::get('user.authenticated', false);
    }

    /**
     * Déconnecter l'utilisateur
     */
    public static function logout()
    {
        Session::flush();
    }
}