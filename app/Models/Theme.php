<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'couleur_principale',
        'couleur_secondaire',
        'couleur_sidebar',
        'couleur_main',
        'couleur_section',
        'couleur_header',
        'couleur_footer',
        'actif'
    ];

    protected $casts = [
        'actif' => 'boolean'
    ];

    /**
     * Récupérer le thème actif
     */
    public static function getCurrentTheme()
    {
        return self::where('actif', true)->first();
    }

    /**
     * Vérifier si le thème est actif
     */
    public function isActive()
    {
        return $this->actif === true;
    }

    /**
     * Récupérer tous les thèmes actifs
     */
    public static function getActiveThemes()
    {
        return self::where('actif', true)->get();
    }

    /**
     * Formater le thème pour l'API
     */
    public function toApiFormat()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'description' => $this->description,
            'couleur_principale' => $this->couleur_principale,
            'couleur_secondaire' => $this->couleur_secondaire,
            'couleur_sidebar' => $this->couleur_sidebar,
            'couleur_main' => $this->couleur_main,
            'couleur_section' => $this->couleur_section,
            'couleur_header' => $this->couleur_header,
            'couleur_footer' => $this->couleur_footer,
            'actif' => $this->actif,
            'est_actif' => $this->isActive(),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Rechercher des thèmes
     */
    public static function search($term)
    {
        return self::where(function($query) use ($term) {
            $query->where('nom', 'LIKE', "%{$term}%")
                  ->orWhere('description', 'LIKE', "%{$term}%");
        })
        ->orderBy('nom')
        ->get();
    }

    /**
     * Récupérer tous les thèmes
     */
    public static function getAll()
    {
        return self::orderBy('nom')->get();
    }

    /**
     * Obtenir les variables CSS du thème
     */
    public function getCssVariables()
    {
        return [
            '--primary-color' => $this->couleur_principale ?? '#b15d15',
            '--secondary-color' => $this->couleur_secondaire ?? '#000000',
            '--sidebar-color' => $this->couleur_sidebar ?? '#b15d15',
            '--main-color' => $this->couleur_main ?? '#3ca57b',
            '--section-color' => $this->couleur_section ?? '#ffffff',
            '--header-color' => $this->couleur_header ?? '#b15d15',
            '--footer-color' => $this->couleur_footer ?? '#343a40',
            '--primary-gradient' => $this->getGradient(),
            '--theme-name' => $this->nom ?? 'Default'
        ];
    }

    /**
     * Obtenir un dégradé basé sur les couleurs
     */
    public function getGradient()
    {
        return 'linear-gradient(135deg, ' . 
            ($this->couleur_secondaire ?? '#000000') . ', ' . 
            ($this->couleur_principale ?? '#b15d15') . ')';
    }

    /**
     * Assombrir une couleur
     */
    public function darkenColor($color, $percent)
    {
        $color = ltrim($color, '#');
        if (strlen($color) == 3) {
            $color = $color[0].$color[0].$color[1].$color[1].$color[2].$color[2];
        }
        
        list($r, $g, $b) = array_map('hexdec', str_split($color, 2));
        
        $r = max(0, min(255, $r - ($r * $percent / 100)));
        $g = max(0, min(255, $g - ($g * $percent / 100)));
        $b = max(0, min(255, $b - ($b * $percent / 100)));
        
        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }

    /**
     * Éclaircir une couleur
     */
    public function lightenColor($color, $percent)
    {
        $color = ltrim($color, '#');
        if (strlen($color) == 3) {
            $color = $color[0].$color[0].$color[1].$color[1].$color[2].$color[2];
        }
        
        list($r, $g, $b) = array_map('hexdec', str_split($color, 2));
        
        $r = max(0, min(255, $r + ((255 - $r) * $percent / 100)));
        $g = max(0, min(255, $g + ((255 - $g) * $percent / 100)));
        $b = max(0, min(255, $b + ((255 - $b) * $percent / 100)));
        
        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }


    // Dans app/Models/Theme.php
    public function getNomAttribute($value)
    {
        // Table de conversion pour les caractères problématiques
        $conversion = [
            'Š' => 'è',
            '‚' => 'é',
            '┼á' => 'è',
            'ÔÇÜ' => 'é',
            'Th┼áme' => 'Thème',
            'dÔÇÜfaut' => 'défaut',
        ];
        
        return strtr($value, $conversion);
    }

    public function getDescriptionAttribute($value)
    {
        $conversion = [
            'Š' => 'è',
            '‚' => 'é',
            '┼á' => 'è',
            'ÔÇÜ' => 'é',
        ];
        
        return strtr($value, $conversion);
    }
    
}

