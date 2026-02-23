<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterlocuteurProjet extends Model
{
    use HasFactory;

    /**
     * Nom de la table
     */
    protected $table = 'interlocuteur_projet';

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
     * Champs assignables en masse
     */
    protected $fillable = [
        'id_interlocuteur',
        'id_projet'
    ];

    /**
     * Timestamps
     */
    public $timestamps = true;

    /**
     * Relation avec l'interlocuteur
     */
    public function interlocuteur()
    {
        return $this->belongsTo(Interlocuteur::class, 'id_interlocuteur');
    }

    /**
     * Relation avec le projet
     */
    public function projet()
    {
        return $this->belongsTo(Projet::class, 'id_projet');
    }

    /**
     * Vérifier si une relation existe déjà
     */
    public static function exists($interlocuteurId, $projetId)
    {
        return self::where('id_interlocuteur', $interlocuteurId)
            ->where('id_projet', $projetId)
            ->exists();
    }
}