<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Projet extends Model
{
    use HasFactory;

    /**
     * Nom de la table
     */
    protected $table = 'projet';

    /**
     * Clé primaire
     */
    protected $primaryKey = 'id';

    /**
     * Indique si la clé primaire est un auto-increment
     */
    public $incrementing = true;

    /**
     * Type de la clé primaire
     */
    protected $keyType = 'int';

    /**
     * Indique si le modèle doit être timestampé
     */
    public $timestamps = false;

    /**
     * Les attributs qui sont assignables en masse.
     */
    protected $fillable = [
        'non_de_projet',
        'date_debu',
        'date_fin',
        'dedlinne',
        'description',
        'id_utilisateur_chef_de_projet',
        'id_client',
        'id_categorie',
        'id_type_intervention',
        'id_type_projet',
        'actif',
        'id_utilisateur_creer'
    ];

    /**
     * Les attributs qui devraient être cachés pour les tableaux.
     */
    protected $hidden = [];

    /**
     * Les attributs qui devraient être convertis.
     */
    protected $casts = [
        'date_debu' => 'date',
        'date_fin' => 'date',
        'dedlinne' => 'integer',
        'id_utilisateur_chef_de_projet' => 'integer',
        'id_categorie' => 'integer',
        'id_type_intervention' => 'integer',
        'id_type_projet' => 'integer',
        'actif' => 'boolean',
        
    ];

    /**
     * Règles de validation pour la création
     */
    public static $rules = [
        'non_de_projet' => 'required|string|max:250',
        'date_debu' => 'nullable|date',
        'date_fin' => 'nullable|date|after_or_equal:date_debu',
        'dedlinne' => 'nullable|integer|min:0',
        'description' => 'nullable|string',
        'id_utilisateur_chef_de_projet' => 'required|integer',
        'id_client' => 'required|string|max:50',
        'id_categorie' => 'required|integer|exists:categorie,id',
        'id_type_intervention' => 'required|integer|exists:type_intervention,id',
        'id_type_projet' => 'required|integer|exists:type_projet,id',
       
    ];

    /**
     * Messages de validation personnalisés
     */
    public static $messages = [
        'non_de_projet.required' => 'Le nom du projet est obligatoire.',
        'non_de_projet.max' => 'Le nom du projet ne peut pas dépasser 250 caractères.',
        'date_fin.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
        'id_categorie.exists' => 'La catégorie sélectionnée n\'existe pas.',
        'id_type_intervention.exists' => 'Le type d\'intervention sélectionné n\'existe pas.',
        'id_type_projet.exists' => 'Le type de projet sélectionné n\'existe pas.'
    ];

    /**
     * Récupérer tous les projets
     */
    public static function getAll()
    {
        return self::with(['categorie', 'typeIntervention', 'typeProjet'])
                  ->orderBy('date_debu', 'desc')
                  ->get();
    }

    /**
     * Récupérer un projet par son ID
     */
    public static function getById($id)
    {
        return self::with(['categorie', 'typeIntervention', 'typeProjet'])
                  ->find($id);
    }

    /**
     * Récupérer les projets par utilisateur
     */
    public static function getByUtilisateur($userId)
    {
        return self::where('id_utilisateur_chef_de_projet', $userId)
                  ->with(['categorie', 'typeIntervention', 'typeProjet'])
                  ->orderBy('date_debu', 'desc')
                  ->get();
    }

    /**
     * Récupérer les projets par client
     */
    public static function getByClient($clientId)
    {
        return self::where('id_client', $clientId)
                  ->with(['categorie', 'typeIntervention', 'typeProjet'])
                  ->orderBy('date_debu', 'desc')
                  ->get();
    }

    /**
     * Créer un nouveau projet
     */
    public static function createProjet($data)
    {
        return self::create([
            'non_de_projet' => $data['non_de_projet'],
            'date_debu' => isset($data['date_debu']) ? $data['date_debu'] : null,
            'date_fin' => isset($data['date_fin']) ? $data['date_fin'] : null,
            'dedlinne' => isset($data['dedlinne']) ? $data['dedlinne'] : null,
            'description' => isset($data['description']) ? $data['description'] : null,
            'id_utilisateur_chef_de_projet' => $data['id_utilisateur_chef_de_projet'],
            'id_client' => $data['id_client'],
            'id_categorie' => $data['id_categorie'],
            'id_type_intervention' => $data['id_type_intervention'],
            'id_type_projet' => $data['id_type_projet'],
            'id_utilisateur_creer' => $data['id_utilisateur_creer']
        ]);
    }

    /**
     * Mettre à jour un projet
     */
    public static function updateProjet($id, $data)
    {
        $projet = self::find($id);
        
        if ($projet) {
            $projet->update($data);
            return $projet;
        }
        
        return null;
    }

    /**
     * Supprimer un projet
     */
    public static function deleteProjet($id)
    {
        $projet = self::find($id);
        
        if ($projet) {
            return $projet->delete();
        }
        
        return false;
    }

    /**
     * Rechercher des projets par terme
     */
    public static function search($term)
    {
        return self::where(function($query) use ($term) {
                    $query->where('non_de_projet', 'ILIKE', "%{$term}%")
                          ->orWhere('description', 'ILIKE', "%{$term}%")
                          ->orWhere('id_client', 'ILIKE', "%{$term}%");
                })
                ->with(['categorie', 'typeIntervention', 'typeProjet'])
                ->orderBy('date_debu', 'desc')
                ->get();
    }

    /**
     * Récupérer les projets paginés
     */
    public static function getPaginated($perPage = 10)
    {
        return self::with(['categorie', 'typeIntervention', 'typeProjet'])
                  ->orderBy('date_debu', 'desc')
                  ->paginate($perPage);
    }

    /**
     * Compter le nombre total de projets
     */
    public static function countProjets()
    {
        return self::count();
    }

    /**
     * Récupérer les projets en retard
     */
    public static function getProjetsEnRetard()
    {
        return self::where('date_fin', '<', Carbon::now())
                  ->whereNotNull('date_fin')
                  ->with(['categorie', 'typeIntervention', 'typeProjet'])
                  ->orderBy('date_fin', 'asc')
                  ->get();
    }

    /**
     * Récupérer les projets en cours
     */
    public static function getProjetsEnCours()
    {
        return self::where(function($query) {
                    $query->whereNull('date_fin')
                          ->orWhere('date_fin', '>=', Carbon::now());
                })
                ->whereNotNull('date_debu')
                ->where('date_debu', '<=', Carbon::now())
                ->with(['categorie', 'typeIntervention', 'typeProjet'])
                ->orderBy('date_debu', 'desc')
                ->get();
    }

    /**
     * Récupérer les projets à venir
     */
    public static function getProjetsAVenir()
    {
        return self::where('date_debu', '>', Carbon::now())
                  ->with(['categorie', 'typeIntervention', 'typeProjet'])
                  ->orderBy('date_debu', 'asc')
                  ->get();
    }

    /**
     * Relation avec la catégorie
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie', 'id');
    }

    /**
     * Relation avec le type d'intervention
     */
    public function typeIntervention()
    {
        return $this->belongsTo(TypeIntervention::class, 'id_type_intervention', 'id');
    }

    /**
     * Relation avec le type de projet
     */
    public function typeProjet()
    {
        return $this->belongsTo(TypeProjet::class, 'id_type_projet', 'id');
    }

    /**
     * Scope pour filtrer par catégorie
     */
    public function scopeByCategorie($query, $categorieId)
    {
        return $query->where('id_categorie', $categorieId);
    }

    /**
     * Scope pour filtrer par type d'intervention
     */
    public function scopeByTypeIntervention($query, $typeInterventionId)
    {
        return $query->where('id_type_intervention', $typeInterventionId);
    }

    /**
     * Scope pour filtrer par type de projet
     */
    public function scopeByTypeProjet($query, $typeProjetId)
    {
        return $query->where('id_type_projet', $typeProjetId);
    }

    /**
     * Scope pour les projets avec description
     */
    public function scopeWithDescription($query)
    {
        return $query->whereNotNull('description');
    }

    /**
     * Scope pour les projets par période
     */
    public function scopeByPeriode($query, $startDate, $endDate = null)
    {
        $query->where('date_debu', '>=', $startDate);
        
        if ($endDate) {
            $query->where('date_debu', '<=', $endDate);
        }
        
        return $query;
    }

    /**
     * Accesseur pour le statut du projet
     */
    public function getStatutAttribute()
    {
        if (!$this->date_debu) {
            return 'planifié';
        }
        
        $now = Carbon::now();
        $debut = Carbon::parse($this->date_debu);
        $fin = $this->date_fin ? Carbon::parse($this->date_fin) : null;
        
        if ($debut->isFuture()) {
            return 'à venir';
        } elseif ($fin && $fin->isPast()) {
            return 'terminé';
        } elseif ($fin && $now->between($debut, $fin)) {
            return 'en cours';
        } elseif (!$fin && $debut->isPast()) {
            return 'en cours (sans date de fin)';
        }
        
        return 'indéfini';
    }

    /**
     * Accesseur pour la durée estimée
     */
    public function getDureeEstimeeAttribute()
    {
        if (!$this->date_debu || !$this->date_fin) {
            return null;
        }
        
        $debut = Carbon::parse($this->date_debu);
        $fin = Carbon::parse($this->date_fin);
        
        return $debut->diffInDays($fin) . ' jours';
    }

    /**
     * Accesseur pour les jours restants
     */
    public function getJoursRestantsAttribute()
    {
        if (!$this->date_fin) {
            return null;
        }
        
        $fin = Carbon::parse($this->date_fin);
        $now = Carbon::now();
        
        if ($fin->isPast()) {
            return 0;
        }
        
        return $now->diffInDays($fin);
    }

    /**
     * Accesseur pour la description tronquée
     */
    public function getDescriptionCourteAttribute()
    {
        if (!$this->description) {
            return null;
        }
        
        return strlen($this->description) > 150 
            ? substr($this->description, 0, 150) . '...' 
            : $this->description;
    }

    /**
     * Accesseur pour les dates formatées
     */
    public function getDateDebutFormateeAttribute()
    {
        return $this->date_debu 
            ? Carbon::parse($this->date_debu)->format('d/m/Y') 
            : 'Non définie';
    }

    public function getDateFinFormateeAttribute()
    {
        return $this->date_fin 
            ? Carbon::parse($this->date_fin)->format('d/m/Y') 
            : 'Non définie';
    }

    /**
     * Vérifier si le projet est en retard
     */
    public function isEnRetard()
    {
        if (!$this->date_fin) {
            return false;
        }
        
        return Carbon::parse($this->date_fin)->isPast();
    }

    /**
     * Vérifier si le projet est en cours
     */
    public function isEnCours()
    {
        if (!$this->date_debu) {
            return false;
        }
        
        $now = Carbon::now();
        $debut = Carbon::parse($this->date_debu);
        $fin = $this->date_fin ? Carbon::parse($this->date_fin) : null;
        
        if ($debut->isFuture()) {
            return false;
        }
        
        if (!$fin) {
            return true;
        }
        
        return $now->between($debut, $fin);
    }

    public static function getStatistiques()
    {
        return [
            'total' => self::count(),
            'en_cours' => self::getProjetsEnCours()->count(),
            'termines' => self::whereNotNull('date_fin')
                              ->where('date_fin', '<', Carbon::now())
                              ->count(),
            'a_venir' => self::getProjetsAVenir()->count(),
            'en_retard' => self::getProjetsEnRetard()->count()
        ];
    }
   
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }
    
    public function scopeArchived($query)
    {
        return $query->where('actif', false);
    }


    /**
     * Relation many-to-many avec les interlocuteurs
     */
    // public function interlocuteurs()
    // {
    //     return $this->belongsToMany(
    //         Interlocuteur::class,
    //         'interlocuteur_projet',
    //         'id_projet',
    //         'id_interlocuteur'
    //     )->withTimestamps();
    // }

    

    /**
     * Obtenir la liste des IDs d'interlocuteurs
     */
    // public function getInterlocuteurIdsAttribute()
    // {
    //     return $this->interlocuteurs->pluck('id')->toArray();
    // }

    
}