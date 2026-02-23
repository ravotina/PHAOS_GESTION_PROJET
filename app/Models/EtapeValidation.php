<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EtapeValidation extends Model
{
    use HasFactory;

    protected $table = 'etapes_validation';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'type_etape',
        'commentaire',
        'date_decision',
        'date_creation',
        'status',
        'etape',
        'id_workflow_validation',
        'id_utilisateur',
        'id_projects_travailler',
        'id_etape'
    ];

    protected $casts = [
        'date_decision' => 'date',
        'date_creation' => 'date',
        'id_workflow_validation' => 'integer',
        'id_utilisateur' => 'integer',
        'id_projects_travailler' => 'integer',
        'id_etape' => 'integer'
    ];

    // Relation avec l'utilisateur
    // public function utilisateur(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'id_utilisateur');
    // }

    public function getUtilisateurInfoAttribute()
    {
        $userId = $this->id_utilisateur;
        
        // Solution temporaire : retourner un tableau simple
        return [
            'id' => $userId,
            'name' => 'Utilisateur #' . $userId,
            'dolibarr_id' => $userId
        ];
    }

    // Relation avec le projet
    public function projet(): BelongsTo
    {
        return $this->belongsTo(ProjectTravailler::class, 'id_projects_travailler');
    }

    // Relation avec l'étape
    public function etapeDefinition(): BelongsTo
    {
        return $this->belongsTo(Etape::class, 'id_etape');
    }

    // Relation avec le workflow
    public function workflow(): BelongsTo
    {
        return $this->belongsTo(WorkflowValidation::class, 'id_workflow_validation');
    }

    // Relation avec les détails
    public function details(): HasMany
    {
        return $this->hasMany(EtapeValidationDetail::class, 'id_etapes_validation');
    }

    /**
     * Vérifier si l'étape est terminée
     */
    public function isCompleted(): bool
    {
        return in_array($this->status, ['validé', 'rejeté', 'terminé']);
    }

    /**
     * Vérifier si l'étape est en attente
     */
    public function isPending(): bool
    {
        return $this->status === 'en attente';
    }

    /**
     * Vérifier si l'étape est validée
     */
    public function isApproved(): bool
    {
        return $this->status === 'validé';
    }

    /**
     * Vérifier si l'étape est rejetée
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejeté';
    }

    /**
     * Marquer comme validé
     */
    public function markAsApproved($comment = null)
    {
        $this->update([
            'status' => 'validé',
            'date_decision' => now(),
            'commentaire' => $comment
        ]);
    }

    /**
     * Marquer comme rejeté
     */
    public function markAsRejected($comment = null)
    {
        $this->update([
            'status' => 'rejeté',
            'date_decision' => now(),
            'commentaire' => $comment
        ]);
    }

    /**
     * Récupérer les validations par projet
     */
    public static function getByProject($projectId)
    {
        return self::with(['utilisateur', 'etapeDefinition', 'details'])
                  ->where('id_projects_travailler', $projectId)
                  ->orderBy('date_creation')
                  ->orderBy('id')
                  ->get();
    }

    /**
     * Récupérer les validations par utilisateur
     */
    public static function getByUser($userId)
    {
        return self::with(['projet', 'etapeDefinition'])
                  ->where('id_utilisateur', $userId)
                  ->where('status', 'en attente')
                  ->orderBy('date_creation')
                  ->get();
    }
}