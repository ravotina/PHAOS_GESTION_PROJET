<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('permission', function () {
            return new \App\Services\PermissionService();
        });
    }

    public function boot(): void
    {
        // Directives Blade pour les permissions
        Blade::directive('permission', function ($expression) {
            return "<?php if (app('permission')->can({$expression})): ?>";
        });

        Blade::directive('endpermission', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('permissionall', function ($expression) {
            return "<?php if (app('permission')->canAll({$expression})): ?>";
        });

        Blade::directive('endpermissionall', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('permissionany', function ($expression) {
            return "<?php if (app('permission')->canAny({$expression})): ?>";
        });

        Blade::directive('endpermissionany', function () {
            return "<?php endif; ?>";
        });

        // Partage des données avec toutes les vues
        view()->composer('*', function ($view) {
            $permissionService = app('permission');
            
            $view->with([
                'userRole' => $permissionService->getRole(),
                'userName' => $permissionService->getUserName(),
                'accessibleModules' => $permissionService->getAccessibleModules(),
                'permissionService' => $permissionService
            ]);
        });
    }
}