<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterlocuteurNumero extends Model
{
    use HasFactory;

    /**
     * Nom de la table
     */
    protected $table = 'interlocuteur_numeros';

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
     * Champs assignables en masse
     */
    protected $fillable = [
        'id_interlocuteur',
        'numero'
    ];

    /**
     * Relation avec l'interlocuteur
     */
    public function interlocuteur()
    {
        return $this->belongsTo(Interlocuteur::class, 'id_interlocuteur');
    }
}