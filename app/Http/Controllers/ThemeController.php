<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class ThemeController extends Controller
{
    /**
     * Afficher la liste des thèmes
     */
    public function index()
    {
        $themes = Theme::orderBy('nom')->get();
        
        $currentTheme = Theme::getCurrentTheme();


        Log::info('Thème actuel récupéré', [
            'theme' => $currentTheme ? $currentTheme->nom : null,
        ]);
        
        // Statistiques détaillées
        $stats = [
            'total' => $themes->count(),
            'actifs' => $themes->where('actif', true)->count(),
            'inactifs' => $themes->where('actif', false)->count(),
            'actifs_aujourdhui' => $themes->filter(function($theme) {
                return $theme->isActive();
            })->count(),
            
            // Statistiques sur les couleurs principales (optionnel)
            'couleurs_uniques' => [
                'principale' => $themes->pluck('couleur_principale')->unique()->count(),
                'secondaire' => $themes->pluck('couleur_secondaire')->unique()->count(),
                'sidebar' => $themes->pluck('couleur_sidebar')->unique()->count(),
            ],
            
            // Couleur la plus utilisée (optionnel)
            'couleur_plus_utilisee' => $themes->count() > 0 ? 
                $themes->groupBy('couleur_principale')
                    ->map->count()
                    ->sortDesc()
                    ->keys()
                    ->first() : '#b15d15',
        ];

        // Forcer l'en-tête UTF-8
        header('Content-Type: text/html; charset=utf-8');

        return view('themes.index', compact('themes', 'currentTheme', 'stats'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('themes.create');
    }

    /**
     * Enregistrer un nouveau thème
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'couleur_principale' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'couleur_secondaire' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'couleur_sidebar' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'couleur_main' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'couleur_section' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'couleur_header' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'couleur_footer' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'actif' => 'sometimes|boolean'
        ]);

        $theme = Theme::create($validated);

        return redirect()->route('themes.index')
            ->with('success', 'Thème créé avec succès');
    }

    public function show($id)
    {
        $theme = Theme::findOrFail($id);
        return view('themes.show', compact('theme'));
    }
    
    /**
     * Afficher le formulaire d'édition
     */
    public function edit($id)
    {
        $theme = Theme::findOrFail($id);
        return view('themes.edit', compact('theme'));
    }

    /**
     * Mettre à jour un thème
     */
    /**
     * Mettre à jour un thème
     */
    public function update(Request $request, $id)
    {
        $theme = Theme::findOrFail($id);
        
        $validated = $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'couleur_principale' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'couleur_secondaire' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'couleur_sidebar' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'couleur_main' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'couleur_section' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'couleur_header' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'couleur_footer' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'actif' => 'sometimes|boolean'
        ]);
        
        $validated['actif'] = $request->has('actif');
        
        $theme->update($validated);
        
        return redirect()->route('themes.index')
            ->with('success', 'Thème mis à jour avec succès.');
    }


    /**
     * Supprimer un thème
     */
      public function destroy($id)
        {
            $theme = Theme::findOrFail($id);
            
            // Empêcher la suppression du thème actif
            if ($theme->isActive()) {
                return redirect()->route('themes.index')
                    ->with('error', 'Impossible de supprimer le thème actif.');
            }
            
            $theme->delete();
            
            return redirect()->route('themes.index')
                ->with('success', 'Thème supprimé avec succès.');
        }

    /**
     * Activer/Désactiver un thème
     */
    public function toggle($id)
    {
        $theme = Theme::findOrFail($id);
        
        if (!$theme->actif) {
            // Si on active ce thème, on désactive tous les autres d'abord
            Theme::where('actif', true)->update(['actif' => false]);
            
            // Puis on active celui-ci
            $theme->update(['actif' => true]);
            
            $message = 'Thème activé avec succès';
        } else {
            // Si on désactive ce thème, on le désactive simplement
            $theme->update(['actif' => false]);
            $message = 'Thème désactivé';
        }

        return redirect()->route('themes.index')
            ->with('success', $message);
    }
}