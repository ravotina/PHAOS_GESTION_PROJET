<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class Permission
{
    private $dolibarrUrl;

    public function __construct()
    {
        $this->dolibarrUrl = env('DOLIBARR_URL') . 'index.php';
    }

    /**
     * Récupérer les permissions d'un utilisateur - Version robuste
     */

     private function getAdminToken()
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

    public function getUserPermissions($userId) // $token,
    {
        try {

            $token = $this->getAdminToken();
            Log::info('Tentative de récupération des permissions pour user ID: ' . $userId);

            $response = Http::timeout(30)->withHeaders([
                'DOLAPIKEY' => $token
            ])->get($this->dolibarrUrl . "/mymodule/users/{$userId}/permissions");

            if ($response->successful()) {
                $permissionData = $response->json();
                Log::info('Permissions récupérées avec succès pour user ID: ' . $userId);
                
                return $this->formatPermissions($permissionData);
            } else {
                Log::warning('Erreur récupération permissions - Statut: ' . $response->status() . ' pour user ID: ' . $userId);
                
                // Retourner des permissions vides plutôt que null
                return $this->getEmptyPermissions($userId);
            }

        } catch (\Exception $e) {
            Log::error('Erreur récupération permissions pour user ID ' . $userId . ': ' . $e->getMessage());
            
            // Retourner des permissions vides en cas d'erreur
            return $this->getEmptyPermissions($userId);
        }
    }

    /**
     * Retourne une structure de permissions vide
     */
    private function getEmptyPermissions($userId)
    {
        return [
            'raw_data' => [
                'user_id' => $userId,
                'user_login' => 'unknown',
                'user_name' => 'Unknown User',
                'permissions' => [],
                'count' => 0
            ],
            'formatted' => [
                'by_module' => [],
                'by_permission' => [],
                'all_permissions' => [],
                'user_info' => [
                    'user_id' => $userId,
                    'user_login' => 'unknown',
                    'user_name' => 'Unknown User'
                ]
            ]
        ];
    }

    /**
     * Formater les permissions pour un accès plus facile
     */
    private function formatPermissions($permissionData)
    {
        $formatted = [
            'by_module' => [],
            'by_permission' => [],
            'all_permissions' => [],
            'user_info' => [
                'user_id' => $permissionData['user_id'] ?? null,
                'user_login' => $permissionData['user_login'] ?? null,
                'user_name' => $permissionData['user_name'] ?? null
            ]
        ];

        if (isset($permissionData['permissions']) && is_array($permissionData['permissions'])) {
            foreach ($permissionData['permissions'] as $permission) {
                $module = $permission['module'] ?? 'unknown';
                $perm = $permission['permission'] ?? 'unknown';
                $enabled = $permission['enabled'] ?? false;

                // N'inclure que les permissions activées
                if (!$enabled) {
                    continue;
                }

                // Permissions par module
                if (!isset($formatted['by_module'][$module])) {
                    $formatted['by_module'][$module] = [];
                }
                $formatted['by_module'][$module][$perm] = true;

                // Permissions par type
                if (!isset($formatted['by_permission'][$perm])) {
                    $formatted['by_permission'][$perm] = [];
                }
                $formatted['by_permission'][$perm][] = $module;

                // Liste complète
                $formatted['all_permissions'][] = [
                    'module' => $module,
                    'permission' => $perm,
                    'subpermission' => $permission['subpermission'] ?? '',
                    'label' => $permission['label'] ?? '',
                    'enabled' => $enabled
                ];
            }
        }

        Log::info('Permissions formatées:', [
            'modules' => array_keys($formatted['by_module']),
            'total_permissions' => count($formatted['all_permissions'])
        ]);

        return $formatted;
    }

    /**
     * Vérifier une permission spécifique depuis des données formatées
     */
    public static function checkPermission($permissionsData, $module, $permission)
    {
        if (!$permissionsData || !isset($permissionsData['formatted']['by_module'][$module])) {
            return false;
        }

        return $permissionsData['formatted']['by_module'][$module][$permission] ?? false;
    }
}