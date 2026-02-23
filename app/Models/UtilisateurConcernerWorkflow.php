<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UtilisateurConcernerWorkflow extends Model
{
    protected $table = 'utilisateur_concerner_workflow';
    
    protected $fillable = [
        'commentaires',
        'id_utilisateur',
        'id_workflow_validation',
        'status_validation',
        'date_validation'
    ];
    
    protected $casts = [
        'date_validation' => 'datetime',
    ];
    
    protected $attributes = [
        'status_validation' => 0,
    ];
    
    // Relation avec le workflow
    public function workflow()
    {
        return $this->belongsTo(WorkflowValidation::class, 'id_workflow_validation');
    }
    
    // Accesseurs pour le statut
    public function getStatusTexteAttribute()
    {
        return match($this->status_validation) {
            0 => 'En attente',
            1 => 'Validé',
            2 => 'Rejeté',
            default => 'Inconnu'
        };
    }
    
    public function getStatusCouleurAttribute()
    {
        return match($this->status_validation) {
            0 => 'warning',
            1 => 'success',
            2 => 'danger',
            default => 'secondary'
        };
    }
    
    public function getStatusIconeAttribute()
    {
        return match($this->status_validation) {
            0 => '⏳',
            1 => '✅',
            2 => '❌',
            default => '❓'
        };
    }
    
    // Méthodes pratiques
    public function estEnAttente()
    {
        return $this->status_validation === 0;
    }
    
    public function estValide()
    {
        return $this->status_validation === 1;
    }
    
    public function estRejete()
    {
        return $this->status_validation === 2;
    }
}