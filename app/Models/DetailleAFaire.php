<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailleAFaire extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detaille_a_faire';

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
        'fichier',
        'url',
        'id_preparation'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id_preparation' => 'integer'
    ];

    /**
     * Règles de validation
     *
     * @var array
     */
    public static $rules = [
        'nom' => 'nullable|string|max:250',
        'description' => 'nullable|string',
        'fichier' => 'nullable|string|max:250',
        'url' => 'nullable|string|max:500|url',
        'id_preparation' => 'required|integer|exists:preparation,id'
    ];

    /**
     * Messages de validation personnalisés
     *
     * @var array
     */
    public static $messages = [
        'nom.max' => 'Le nom ne doit pas dépasser 250 caractères.',
        'fichier.max' => 'Le nom du fichier ne doit pas dépasser 250 caractères.',
        'url.max' => 'L\'URL ne doit pas dépasser 500 caractères.',
        'url.url' => 'L\'URL doit être une URL valide.',
        'id_preparation.required' => 'La préparation est obligatoire.',
        'id_preparation.exists' => 'La préparation sélectionnée est invalide.'
    ];

    /**
     * Relation avec la préparation
     */
    public function preparation()
    {
        return $this->belongsTo(Preparation::class, 'id_preparation');
    }

    /**
     * Scope pour les détails d'une préparation
     */
    public function scopeByPreparation($query, $preparationId)
    {
        return $query->where('id_preparation', $preparationId);
    }

    /**
     * Vérifier si le détail a un fichier
     */
    public function hasFile()
    {
        return !empty($this->fichier);
    }

    /**
     * Vérifier si le détail a une URL
     */
    public function hasUrl()
    {
        return !empty($this->url);
    }

    /**
     * Obtenir l'extension du fichier
     */
    public function getFileExtension()
    {
        if ($this->hasFile()) {
            return pathinfo($this->fichier, PATHINFO_EXTENSION);
        }
        return null;
    }

    /**
     * Obtenir le nom du fichier sans extension
     */
    public function getFileNameWithoutExtension()
    {
        if ($this->hasFile()) {
            return pathinfo($this->fichier, PATHINFO_FILENAME);
        }
        return null;
    }
}