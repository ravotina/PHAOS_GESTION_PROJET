<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeProjet extends Model
{
    use HasFactory;

    /**
     * Nom de la table
     */
    protected $table = 'type_projet';

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
        'nom',
        'description'
    ];

    /**
     * Champs cachés lors de la sérialisation
     */
    protected $hidden = [];

    /**
     * Règles de validation pour la création
     */
    public static $rules = [
        'nom' => 'required|string|max:250|unique:type_projet,nom',
        'description' => 'nullable|string'
    ];

    /**
     * Messages de validation personnalisés
     */
    public static $messages = [
        'nom.required' => 'Le nom du type de projet est obligatoire.',
        'nom.max' => 'Le nom du type de projet ne peut pas dépasser 250 caractères.',
        'nom.unique' => 'Ce type de projet existe déjà.'
    ];

    /**
     * Récupérer tous les types de projet
     */
    public static function getAll()
    {
        return self::orderBy('nom')->get();
    }

    /**
     * Récupérer un type de projet par son ID
     */
    public static function getById($id)
    {
        return self::find($id);
    }

    /**
     * Récupérer un type de projet par son nom
     */
    public static function getByName($nom)
    {
        return self::where('nom', $nom)->first();
    }

    /**
     * Créer un nouveau type de projet
     */
    public static function createTypeProjet($data)
    {
        return self::create([
            'nom' => $data['nom'],
            'description' => $data['description'] ?? null
        ]);
    }

    /**
     * Mettre à jour un type de projet
     */
    public static function updateTypeProjet($id, $data)
    {
        $typeProjet = self::find($id);
        
        if ($typeProjet) {
            $typeProjet->update($data);
            return $typeProjet;
        }
        
        return null;
    }

    /**
     * Supprimer un type de projet
     */
    public static function deleteTypeProjet($id)
    {
        $typeProjet = self::find($id);
        
        if ($typeProjet) {
            return $typeProjet->delete();
        }
        
        return false;
    }

    /**
     * Vérifier si un nom existe déjà (pour la validation)
     */
    public static function nameExists($nom, $excludeId = null)
    {
        $query = self::where('nom', $nom);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }

    /**
     * Compter le nombre total de types de projet
     */
    public static function countTypes()
    {
        return self::count();
    }

    /**
     * Rechercher des types de projet par terme
     */
    public static function search($term)
    {
        return self::where(function($query) use ($term) {
                    $query->where('nom', 'ILIKE', "%{$term}%")
                          ->orWhere('description', 'ILIKE', "%{$term}%");
                })
                ->orderBy('nom')
                ->get();
    }

    /**
     * Récupérer les types de projet paginés
     */
    public static function getPaginated($perPage = 10)
    {
        return self::orderBy('nom')->paginate($perPage);
    }

    /**
     * Scope pour filtrer par nom
     */
    public function scopeByName($query, $name)
    {
        return $query->where('nom', $name);
    }

    /**
     * Scope pour les types avec description
     */
    public function scopeWithDescription($query)
    {
        return $query->whereNotNull('description');
    }

    /**
     * Accesseur pour le nom en majuscules
     */
    public function getNomUpperCaseAttribute()
    {
        return strtoupper($this->nom);
    }

    /**
     * Accesseur pour la description tronquée
     */
    public function getDescriptionCourteAttribute()
    {
        if (!$this->description) {
            return null;
        }
        
        return strlen($this->description) > 100 
            ? substr($this->description, 0, 100) . '...' 
            : $this->description;
    }
}