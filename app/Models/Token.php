<?php
// app/Models/Token.php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class Token
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('DOLIBARR_URL') . 'index.php';
    }

    /**
     * Récupérer l'ID utilisateur à partir du token
     */
    public function getUserIdByToken($token)
    {
        try {
            Log::info('Recherche de l\'ID utilisateur pour le token: ' . substr($token, 0, 10) . '...');

            // D'abord essayer avec le token lui-même
            $userId = $this->findUserIdInDatabase($token);
            
            if ($userId) {
                Log::info('ID utilisateur trouvé dans la base: ' . $userId);
                return $userId;
            }

            Log::warning('Token non trouvé dans la base, utilisation du token admin');
            
            // Si pas trouvé, utiliser le token admin pour chercher
            return $this->getUserIdWithAdminToken($token);

        } catch (Exception $e) {
            Log::error('Erreur getUserIdByToken: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Chercher l'ID utilisateur dans la base de données
     */
    private function findUserIdInDatabase($token)
    {
        try {
            // Requête directe PostgreSQL
            $result = \DB::connection('pgsql')->select("
                SELECT id_user 
                FROM token_user 
                WHERE token = ?
            ", [$token]);

            return $result ? $result[0]->id_user : null;

        } catch (Exception $e) {
            Log::error('Erreur findUserIdInDatabase: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Utiliser le token admin pour récupérer l'ID utilisateur
     */
    private function getUserIdWithAdminToken($userToken)
    {
        try {
            // Récupérer le token admin
            $adminToken = $this->getAdminToken();
            
            if (!$adminToken) {
                throw new Exception('Token admin non disponible');
            }

            Log::info('Utilisation du token admin pour rechercher l\'utilisateur');

            // Chercher l'utilisateur par son token via l'API avec le token admin
            $user = $this->findUserByTokenViaAPI($adminToken, $userToken);
            
            if ($user && isset($user['id'])) {
                Log::info('Utilisateur trouvé via API admin: ID ' . $user['id']);
                return $user['id'];
            }

            return null;

        } catch (Exception $e) {
            Log::error('Erreur getUserIdWithAdminToken: ' . $e->getMessage());
            return null;
        }
    }


    
    /**
     * Récupérer le token admin depuis la base
     */
    function getAdminToken()
    {
        try {
            $result = \DB::connection('pgsql')->select("
                SELECT token 
                FROM token_user 
                WHERE id_user = 1 
                LIMIT 1
            ");

            return $result ? $result[0]->token : null;

        } catch (Exception $e) {
            Log::error('Erreur getAdminToken: ' . $e->getMessage());
            return null;
        }
    }



    /**
     * Chercher un utilisateur par token via l'API avec token admin
     */
    private function findUserByTokenViaAPI($adminToken, $userToken)
    {
        try {
            // Lister tous les utilisateurs avec le token admin
            $response = Http::withHeaders([
                'DOLAPIKEY' => $adminToken
            ])->get($this->baseUrl . '/users?limit=1000');

            if ($response->successful()) {
                $users = $response->json();
                
                // Chercher l'utilisateur qui a ce token
                // Note: Cette partie dépend de comment Dolibarr stocke le token côté API
                foreach ($users as $user) {
                    // Si l'API retourne les tokens, on peut comparer
                    // Sinon, on peut essayer d'autres méthodes
                    if (isset($user['api_key']) && $user['api_key'] === $userToken) {
                        return $user;
                    }
                }
            }

            return null;

        } catch (Exception $e) {
            Log::error('Erreur findUserByTokenViaAPI: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Récupérer les informations complètes de l'utilisateur avec token admin
     */
    public function getUserWithAdminToken($userId, $userToken)
    {
        try {
            $adminToken = $this->getAdminToken();
            
            if (!$adminToken) {
                throw new Exception('Token admin non disponible');
            }

            // Récupérer les infos utilisateur avec token admin
            $response = Http::withHeaders([
                'DOLAPIKEY' => $adminToken
            ])->get($this->baseUrl . '/users/' . $userId);

            if ($response->successful()) {
                $userData = $response->json();
                
                // Récupérer les permissions avec token admin
                $permissions = $this->getUserPermissionsWithAdminToken($adminToken, $userId);
                
                return [
                    'user' => $userData,
                    'permissions' => $permissions,
                    'token' => $userToken // On retourne le token de l'utilisateur pour les prochaines requêtes
                ];
            }

            return null;

        } catch (Exception $e) {
            Log::error('Erreur getUserWithAdminToken: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Récupérer les permissions avec token admin
     */
    private function getUserPermissionsWithAdminToken($adminToken, $userId)
    {
        try {
            // Essayer de récupérer les droits utilisateur
            $response = Http::withHeaders([
                'DOLAPIKEY' => $adminToken
            ])->get($this->baseUrl . '/users/' . $userId . '/rights');

            if ($response->successful()) {
                return $response->json();
            }

            return [];

        } catch (Exception $e) {
            Log::error('Erreur getUserPermissionsWithAdminToken: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Insérer un token utilisateur en base
     */
    public function insertUserToken($userId, $token)
    {
        try {
            // Vérifier si l'utilisateur a déjà un token
            $existing = \DB::connection('pgsql')->select("
                SELECT id FROM token_user WHERE id_user = ?
            ", [$userId]);

            if (!empty($existing)) {
                // Mettre à jour le token existant
                \DB::connection('pgsql')->update("
                    UPDATE token_user 
                    SET token = ?
                    WHERE id_user = ?
                ", [$token, $userId]);
                
                Log::info('Token mis à jour pour l\'utilisateur', ['user_id' => $userId]);
                return true;
            } else {
                // Insérer un nouveau token
                \DB::connection('pgsql')->insert("
                    INSERT INTO token_user (id_user, token)
                    VALUES (?, ?)
                ", [$userId, $token]);

                Log::info('Nouveau token inséré', ['user_id' => $userId]);
                return true;
            }
            
        } catch (\Exception $e) {
            Log::error('Erreur insertUserToken: ' . $e->getMessage(), [
                'user_id' => $userId,
                'token' => substr($token, 0, 10) . '...'
            ]);
            return false;
        }
    }

    
}