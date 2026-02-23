<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Models\Theme;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Partager le thème actuel avec toutes les vues
        view()->composer('*', function ($view) {
            $theme = Theme::getCurrentTheme();
            $view->with('currentTheme', $theme);
        });

        // Ajouter les variables CSS du thème
        view()->composer('*', function ($view) {
            $theme = Theme::getCurrentTheme();
            
            if ($theme) {
                $cssVariables = $theme->getCssVariables();
            } else {
                // Thème par défaut si aucun thème n'est actif
                $cssVariables = [
                    '--primary-color' => '#b15d15',
                    '--secondary-color' => '#000000',
                    '--sidebar-color' => '#fcfbfa',
                    '--main-color' => '#19ac5b',
                    '--section-color' => '#ffffff',
                    '--header-color' => '#f7f6f5',
                    '--footer-color' => '#f8f9fa',
                    '--primary-gradient' => 'linear-gradient(135deg, #000000, #b15d15)',
                    '--theme-name' => 'Thèmes PHAOS'
                ];
            }

            $view->with('themeCss', $cssVariables);
        });
    }
}