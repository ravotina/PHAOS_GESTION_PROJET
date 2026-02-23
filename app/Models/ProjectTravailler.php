<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectTravailler extends Model
{
    use HasFactory;

    protected $table = 'projects_travailler';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'numero_projet',
        'titre',
        'description',
        'objectif',
        'date_debu',
        'date_fin',
        'id_lancement_projet',
        'id_utilisateur'
    ];

    // Relation avec le lancement de projet
    public function lancementProjet()
    {
        return $this->belongsTo(LancementProjet::class, 'id_lancement_projet');
    }
    
    // Relation avec les détails (fichiers)
    public function details()
    {
        return $this->hasMany(ProjetTravaillerDetail::class, 'id_projects_travailler');
    }
    /**
     * Ajouter un détail au projet
     */
    public function addDetail($data)
    {
        return $this->details()->create($data);
    }

    // Dans ProjectTravailler.php
    public function workflows()
    {
        return $this->hasMany(WorkflowValidation::class, 'id_projects_travailler');
    }

    public function etapesValidation()
    {
        return $this->hasManyThrough(
            EtapeValidation::class,
            WorkflowValidation::class,
            'id_projects_travailler', // Clé étrangère sur workflow_validation
            'id_workflow_validation', // Clé étrangère sur etapes_validation
            'id', // Clé locale sur projects_travailler
            'id' // Clé locale sur workflow_validation
        );
    }


    public function hasEtapeValidation()
    {
        return $this->etapesValidation()->exists();
    }

    /**
     * Vérifier si le projet a un workflow de première étape
     */
    public function getPremiereEtapeWorkflow()
    {
        return $this->workflows()->whereNull('id_parent')->first();
    }

    // public function etapesValidation()
    // {
    //     return $this->hasMany(EtapeValidation::class, 'id_workflow_validation');
    // }
}