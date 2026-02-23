<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preparation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     
     * @var string
     */
    protected $table = 'preparation';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'daty',
        'id_utilisateur_concerner',
        'id_utilisateur',
        'id_a_faire'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'daty' => 'date',
        'id_utilisateur_concerner' => 'integer',
        'id_utilisateur' => 'integer',
        'id_a_faire' => 'integer'
    ];

    /**
     * Règles de validation
     *
     * @var array
     */
    public static $rules = [
        'description' => 'required|string',
        'daty' => 'required|date',
        'id_utilisateur_concerner' => 'required|integer|exists:utilisateur_concerner,id',
        'id_utilisateur' => 'required|integer|exists:users,id',
        'id_a_faire' => 'required|integer|exists:a_faire,id'
    ];

    /**
     * Messages de validation personnalisés
     *
     * @var array
     */
    public static $messages = [
        'description.required' => 'La description est obligatoire.',
        'daty.required' => 'La date est obligatoire.',
        'daty.date' => 'La date doit être une date valide.',
        'id_utilisateur_concerner.required' => 'L\'utilisateur concerné est obligatoire.',
        'id_utilisateur_concerner.exists' => 'L\'utilisateur concerné sélectionné est invalide.',
        'id_utilisateur.required' => 'L\'utilisateur est obligatoire.',
        'id_utilisateur.exists' => 'L\'utilisateur sélectionné est invalide.',
        'id_a_faire.required' => 'La tâche à faire est obligatoire.',
        'id_a_faire.exists' => 'La tâche à faire sélectionnée est invalide.'
    ];

    /**
     * Relation avec utilisateur_concerner
     */
    public function utilisateurConcerner()
    {
        return $this->belongsTo(UtilisateurConcerner::class, 'id_utilisateur_concerner');
    }
    /**
     * Relation avec a_faire
     */
    public function aFaire()
    {
        return $this->belongsTo(AFaire::class, 'id_a_faire');
    }

    /**
     * Relation avec les détails
     */
    public function details()
    {
        return $this->hasMany(DetailleAFaire::class, 'id_preparation');
    }

    /**
     * Scope pour les préparations d'une tâche à faire
     */
    public function scopeByAFaire($query, $aFaireId)
    {
        return $query->where('id_a_faire', $aFaireId);
    }

    /**
     * Récupérer toutes les préparations avec relations
     */
    public static function getAllWithRelations()
    {
        return self::with(['utilisateurConcerner', 'aFaire', 'details'])
            ->orderBy('daty', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * Récupérer une préparation avec relations
     */
    public static function findWithRelations($id)
    {
        return self::with(['utilisateurConcerner', 'aFaire', 'details'])
            ->findOrFail($id);
    }

    /**
     * Récupérer les préparations d'un utilisateur
     */
    public static function getByUser($userId)
    {
        return self::with(['utilisateurConcerner', 'aFaire', 'details'])
            ->where('id_utilisateur', $userId)
            ->orderBy('daty', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * Formatter la date pour l'affichage
     */
    public function getDatyFormattedAttribute()
    {
        return $this->daty ? $this->daty->format('d/m/Y') : 'Non définie';
    }

    /**
     * Compter les détails
     */
    public function getNombreDetailsAttribute()
    {
        return $this->details()->count();
    }

}