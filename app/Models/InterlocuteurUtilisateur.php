<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Interlocuteur;

class InterlocuteurUtilisateur extends Model
{
    use HasFactory;

    /**
     * Nom de la table
     */
    protected $table = 'interlocateur_utilisateur';

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
        'id_utilisateur',
        'id_interlocuteur'
    ];

    /**
     * Relation avec l'interlocuteur
     */
    public function interlocuteur()
    {
        return $this->belongsTo(Interlocuteur::class, 'id_interlocuteur');
    }

    /**
     * Vérifier si une relation existe déjà
     */
    public static function exists($interlocuteurId, $utilisateurId)
    {
        return self::where('id_interlocuteur', $interlocuteurId)
            ->where('id_utilisateur', $utilisateurId)
            ->exists();
    }

    /**
     * Supprimer une relation spécifique
     */
    public static function remove($interlocuteurId, $utilisateurId)
    {
        return self::where('id_interlocuteur', $interlocuteurId)
            ->where('id_utilisateur', $utilisateurId)
            ->delete();
    }
}