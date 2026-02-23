<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VuePreparationsProjetComplete extends Model
{
    /**
     * Le nom de la vue (pas de table)
     */
    protected $table = 'vue_preparations_projet_complete';

    /**
     * Pas de timestamps dans une vue
     */
    public $timestamps = false;

    /**
     * Les colonnes qui sont mass assignable
     */
    protected $fillable = [
        'projet_id',
        'non_de_projet',
        'statut_projet',
        'description_projet',
        'date_debut_projet',
        'date_fin_projet',
        'calendrier_id',
        'titre_calendrier',
        'date_debut_calendrier',
        'date_fin_calendrier',
        'description_calendrier',
        'couleur_calendrier',
        'createur_calendrier',
        'utilisateur_concerner_id',
        'description_tache',
        'id_utilisateur_assignee',
        'preparation_id',
        'description_preparation',
        'date_preparation',
        'id_createur_preparation',
        'a_faire_id',
        'type_tache',
        'nombre_details',
        'details_json'
    ];

    /**
     * Casts pour les colonnes
     */
    protected $casts = [
        'date_debut_projet' => 'date',
        'date_fin_projet' => 'date',
        'date_debut_calendrier' => 'datetime',
        'date_fin_calendrier' => 'datetime',
        'date_preparation' => 'date',
        'nombre_details' => 'integer',
        'details_json' => 'array'
    ];

    /**
     * Récupérer les détails décodés
     */
    // public function getDetailsAttribute()
    // {
    //     if ($this->details_json && is_string($this->details_json)) {
    //         return json_decode($this->details_json, true);
    //     }
    //     return $this->details_json ?? [];
    // }


    public function getDetailsAttribute()
    {
        // Si c'est déjà un tableau (grâce au cast), retournez-le directement
        if (is_array($this->details_json)) {
            return $this->details_json;
        }
        
        // Sinon, essayez de le décoder
        if (is_string($this->details_json)) {
            $decoded = json_decode($this->details_json, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        return [];
    }

    /**
     * Vérifier si la ligne a des préparations
     */
    public function hasPreparations()
    {
        return !empty($this->preparation_id);
    }

    /**
     * Vérifier s'il y a des fichiers
     */
    public function hasFiles()
    {
        if (empty($this->details)) {
            return false;
        }

        foreach ($this->details as $detail) {
            if (!empty($detail['has_file']) && $detail['has_file'] === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Obtenir tous les fichiers
     */
    public function getFilesAttribute()
    {
        $files = [];

        if (!empty($this->details)) {
            foreach ($this->details as $detail) {
                if (!empty($detail['has_file']) && $detail['has_file'] === true && !empty($detail['fichier'])) {
                    $files[] = [
                        'detail_id' => $detail['detail_id'] ?? null,
                        'nom' => $detail['nom'] ?? null,
                        'fichier' => $detail['fichier'],
                        'file_type' => $detail['file_type'] ?? 'Autre',
                        'description' => $detail['description'] ?? null
                    ];
                }
            }
        }

        return $files;
    }

    /**
     * Obtenir le nombre de fichiers
     */
    public function getNombreFichiersAttribute()
    {
        return count($this->files);
    }

    /**
     * Scope pour filtrer par projet
     */
    public function scopeByProjet($query, $projetId)
    {
        return $query->where('projet_id', $projetId);
    }

    /**
     * Scope pour filtrer par calendrier
     */
    public function scopeByCalendrier($query, $calendrierId)
    {
        return $query->where('calendrier_id', $calendrierId);
    }

    /**
     * Scope pour filtrer par utilisateur assigné
     */
    public function scopeByUtilisateurAssignee($query, $userId)
    {
        return $query->where('id_utilisateur_assignee', $userId);
    }

    /**
     * Scope pour filtrer par type de tâche
     */
    public function scopeByTypeTache($query, $typeTache)
    {
        return $query->where('type_tache', 'ilike', "%{$typeTache}%");
    }

    /**
     * Scope pour filtrer par date de préparation
     */
    public function scopeByDatePreparation($query, $date)
    {
        return $query->whereDate('date_preparation', $date);
    }

    /**
     * Scope pour filtrer par période
     */
    public function scopeByPeriode($query, $dateDebut, $dateFin)
    {
        return $query->whereBetween('date_preparation', [$dateDebut, $dateFin]);
    }

    /**
     * Scope pour les lignes avec préparations
     */
    public function scopeWithPreparations($query)
    {
        return $query->whereNotNull('preparation_id');
    }

    /**
     * Scope pour les lignes avec fichiers
     */

    public function scopeWithFiles($query)
    {
        return $query->whereNotNull('details_json')
                     ->whereRaw("details_json::text != '[]'")
                     ->whereRaw("details_json::text != 'null'");
    }

    /**
     * Recherche multi-critères
     */
    public function scopeSearch($query, $searchParams)
    {
        if (!empty($searchParams['projet'])) {
            $query->where('non_de_projet', 'ilike', "%{$searchParams['projet']}%");
        }

        if (!empty($searchParams['calendrier'])) {
            $query->where('titre_calendrier', 'ilike', "%{$searchParams['calendrier']}%");
        }

        if (!empty($searchParams['tache'])) {
            $query->where('description_tache', 'ilike', "%{$searchParams['tache']}%");
        }

        if (!empty($searchParams['type_tache'])) {
            $query->where('type_tache', 'ilike', "%{$searchParams['type_tache']}%");
        }

        if (!empty($searchParams['utilisateur'])) {
            $query->where('id_utilisateur_assignee', $searchParams['utilisateur']);
        }

        if (!empty($searchParams['date_debut']) && !empty($searchParams['date_fin'])) {
            $query->whereBetween('date_preparation', [
                $searchParams['date_debut'],
                $searchParams['date_fin']
            ]);
        } elseif (!empty($searchParams['date_debut'])) {
            $query->whereDate('date_preparation', '>=', $searchParams['date_debut']);
        } elseif (!empty($searchParams['date_fin'])) {
            $query->whereDate('date_preparation', '<=', $searchParams['date_fin']);
        }

        if (!empty($searchParams['avec_fichiers']) && $searchParams['avec_fichiers'] == '1') {
            $query->whereNotNull('details_json')
                  ->whereRaw("details_json::text != '[]'")
                  ->whereRaw("details_json::text != 'null'");
        }

        return $query;
    }

    /**
     * Récupérer les statistiques par projet
     */
    public static function getStatsByProjet($projetId)
    {
        return DB::table('vue_preparations_projet_complete')
            ->selectRaw('
                COUNT(DISTINCT calendrier_id) as total_calendriers,
                COUNT(DISTINCT preparation_id) as total_preparations,
                SUM(nombre_details) as total_details,
                SUM(CASE WHEN details_json IS NOT NULL AND details_json != \'[]\' THEN 1 ELSE 0 END) as lignes_avec_details,
                COUNT(DISTINCT id_utilisateur_assignee) as total_utilisateurs_assignes,
                COUNT(DISTINCT type_tache) as types_taches_differents
            ')
            ->where('projet_id', $projetId)
            ->whereNotNull('preparation_id')
            ->first();
    }

    /**
     * Récupérer les types de tâches par projet
     */
    public static function getTypesTacheByProjet($projetId)
    {
        return DB::table('vue_preparations_projet_complete')
            ->select('type_tache', DB::raw('COUNT(*) as total'))
            ->where('projet_id', $projetId)
            ->whereNotNull('preparation_id')
            ->groupBy('type_tache')
            ->orderBy('total', 'desc')
            ->get();
    }

    /**
     * Récupérer la répartition par mois
     */
    public static function getRepartitionParMois($projetId)
    {
        return DB::table('vue_preparations_projet_complete')
            ->selectRaw("
                TO_CHAR(date_preparation, 'YYYY-MM') as mois,
                COUNT(*) as total_preparations,
                SUM(nombre_details) as total_details
            ")
            ->where('projet_id', $projetId)
            ->whereNotNull('preparation_id')
            ->groupBy(DB::raw("TO_CHAR(date_preparation, 'YYYY-MM')"))
            ->orderBy('mois', 'desc')
            ->get();
    }
}