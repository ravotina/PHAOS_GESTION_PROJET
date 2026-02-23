<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkflowValidation extends Model
{
    /**
     * Nom de la table
     */
    protected $table = 'workflow_validation';

    /**
     * Les attributs qui sont assignables en masse
     */
    protected $fillable = [
        'nom_etape',
        'date_arriver', //date_depart_travail
        'date_fin_de_validation',
        'commentaires',
        'status',
        'id_parent',
        'id_projects_travailler'
    ];

    /**
     * Les attributs qui doivent être convertis
     */
    protected $casts = [
        'date_arriver' => 'datetime',
        'date_fin_de_validation' => 'datetime',
        'status' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relation avec les utilisateurs concernés
    public function utilisateursConcernes()
    {
        return $this->hasMany(UtilisateurConcernerWorkflow::class, 'id_workflow_validation');
    }

     /**
     * Relation avec les étapes de validation
     */
    public function etapesValidation()
    {
        return $this->hasMany(EtapeValidation::class, 'id_workflow_validation');
    }

    /**
     * Relation avec le projet
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(ProjectTravailler::class, 'id_projects_travailler');
    }

    /**
     * Relation avec l'étape parente
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(WorkflowValidation::class, 'id_parent');
    }

    /**
     * Relation avec les étapes enfants
     */
    public function children(): HasMany
    {
        return $this->hasMany(WorkflowValidation::class, 'id_parent');
    }

    /**
     * Accesseur pour le statut texte
     */
    public function getStatusTexteAttribute()
    {
        $statuses = [
            0 => 'En attente',
            1 => 'Validé',
            2 => 'Rejeté'
        ];
        
        return $statuses[$this->status] ?? 'Inconnu';
    }

    /**
     * Accesseur pour savoir si c'est la première étape
     */
    public function getIsFirstStepAttribute()
    {
        return $this->id_parent === null;
    }

    /**
     * Vérifie si cette étape peut avoir des enfants
     */
    public function canHaveChildren()
    {
        // Vous pouvez ajouter une logique ici pour limiter le nombre d'enfants
        return true;
    }
}