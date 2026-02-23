<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AFaire extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'a_faire';

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
        'nom',
        'description',
        'id_type_projet'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id_type_projet' => 'integer'
    ];

    /**
     * Règles de validation pour le modèle
     *
     * @var array
     */
    public static $rules = [
        'nom' => 'required|string|max:50|unique:a_faire,nom',
        'description' => 'nullable|string',
        'id_type_projet' => 'required|integer|exists:type_projet,id_projet'
    ];

    /**
     * Messages personnalisés pour les règles de validation
     *
     * @var array
     */
    public static $messages = [
        'nom.required' => 'Le nom est obligatoire.',
        'nom.max' => 'Le nom ne doit pas dépasser 50 caractères.',
        'nom.unique' => 'Ce nom existe déjà.',
        'id_type_projet.required' => 'Le type de projet est obligatoire.',
        'id_type_projet.exists' => 'Le type de projet sélectionné est invalide.'
    ];

    /**
     * Règles de validation pour la mise à jour
     *
     * @param int $id
     * @return array
     */
    public static function rulesForUpdate($id)
    {
        return [
            'nom' => 'required|string|max:50|unique:a_faire,nom,' . $id,
            'description' => 'nullable|string',
            'id_type_projet' => 'required|integer|exists:type_projet,id_projet'
        ];
    }

    /**
     * Relation avec le type de projet
     */
    public function typeProjet()
    {
        return $this->belongsTo(TypeProjet::class, 'id_type_projet', 'id');
    }

    /**
     * Récupérer le nom du type de projet
     */
    public function getNomTypeProjetAttribute()
    {
        return $this->typeProjet ? $this->typeProjet->nom : 'Non défini';
    }

    /**
     * Scope pour filtrer par type de projet
     */
    public function scopeByTypeProjet($query, $typeProjetId)
    {
        return $query->where('id_type_projet', $typeProjetId);
    }

    /**
     * Récupérer les tâches avec les types de projet
     */
    public static function getAllWithTypeProjet()
    {
        return self::with('typeProjet')->orderBy('id', 'desc')->get();
    }

    /**
     * Récupérer une tâche avec son type de projet
     */
    public static function findWithTypeProjet($id)
    {
        return self::with('typeProjet')->findOrFail($id);
    }
}