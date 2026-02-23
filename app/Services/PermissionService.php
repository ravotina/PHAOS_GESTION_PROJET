<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class PermissionService
{

    public function hasModule(string $module): bool
    {
        $userPermissions = Session::get('user_permissions');
        
        if (!$userPermissions || !Session::get('user.authenticated')) {
            return false;
        }

        $userModules = $userPermissions['by_module'] ?? [];
        return isset($userModules[$module]) && count(array_filter($userModules[$module])) > 0;
    }

    /**
     * Vérifie si l'utilisateur a une permission spécifique dans un module
     */
    public function hasPermission(string $module, string $permission): bool
    {
        $userPermissions = Session::get('user_permissions');
        
        if (!$userPermissions || !Session::get('user.authenticated')) {
            return false;
        }

        $userModules = $userPermissions['by_module'] ?? [];
        return $userModules[$module][$permission] ?? false;
    }

    /**
     * Récupère tous les modules de l'utilisateur
     */
    public function getUserModules(): array
    {
        $userPermissions = Session::get('user_permissions');
        $modules = [];
        
        if ($userPermissions && isset($userPermissions['by_module'])) {
            foreach ($userPermissions['by_module'] as $module => $permissions) {
                if (count(array_filter($permissions)) > 0) {
                    $modules[] = $module;
                }
            }
        }
        
        return $modules;
    }

    /**
     * Récupère le nom d'utilisateur
     */
    public function getUserName(): string
    {
        $user = Session::get('user');
        return $user['login'] ?? 'Utilisateur';
    }

    /**
     * Récupère l'ID utilisateur
     */
    public function getUserId(): int
    {
        $user = Session::get('user');
        return $user['id'] ?? 0;
    }

    /**
     * Méthode can pour compatibilité (toujours false pour désactiver l'ancien système)
     */
    public function can(string $permissionKey): bool
    {
        return false; // Désactive l'ancien système de mapping
    }

    /**
     * Méthode canAny pour compatibilité
     */
    public function canAny(array $permissions): bool
    {
        return false; // Désactive l'ancien système
    }

    /**
     * Récupère le rôle basé sur les modules réels
     */
    public function getRole(): string
    {
        $modules = $this->getUserModules();
        
        if (empty($modules)) {
            return 'invite';
        }

        // Rôle basé sur les modules présents
        if (in_array('projet', $modules) && in_array('propale', $modules)) {
            return 'chef_projet';
        }

        if (in_array('projet', $modules)) {
            return 'utilisateur_projet';
        }

        if (in_array('propale', $modules)) {
            return 'technique';
        }

        return 'utilisateur';
    }

    /**
     * Récupère les modules accessibles
    */
    public function getAccessibleModules(): array
    {
        $userPermissions = Session::get('user_permissions');
        $modules = [];
        
        if ($userPermissions && isset($userPermissions['by_module'])) {
            foreach ($userPermissions['by_module'] as $module => $permissions) {
                if (count(array_filter($permissions)) > 0) {
                    $modules[] = $module;
                }
            }
        }
        
        return $modules;
    }

}