<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    /**
     * Nom de la table
     */
    protected $table = 'categorie';

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
        'nom' => 'required|string|max:250|unique:categorie,nom',
        'description' => 'nullable|string'
    ];

    /**
     * Messages de validation personnalisés
     */
    public static $messages = [
        'nom.required' => 'Le nom de la catégorie est obligatoire.',
        'nom.max' => 'Le nom de la catégorie ne peut pas dépasser 250 caractères.',
        'nom.unique' => 'Cette catégorie existe déjà.'
    ];

    /**
     * Récupérer toutes les catégories
     */
    public static function getAll()
    {
        return self::orderBy('nom')->get();
    }

    /**
     * Récupérer une catégorie par son ID
     */
    public static function getById($id)
    {
        return self::find($id);
    }

    /**
     * Récupérer une catégorie par son nom
     */
    public static function getByName($nom)
    {
        return self::where('nom', $nom)->first();
    }

    /**
     * Créer une nouvelle catégorie
     */
    public static function createCategorie($data)
    {
        return self::create([
            'nom' => $data['nom'],
            'description' => $data['description'] ?? null
        ]);
    }

    /**
     * Mettre à jour une catégorie
     */
    public static function updateCategorie($id, $data)
    {
        $categorie = self::find($id);
        
        if ($categorie) {
            $categorie->update($data);
            return $categorie;
        }
        
        return null;
    }

    /**
     * Supprimer une catégorie
     */
    public static function deleteCategorie($id)
    {
        $categorie = self::find($id);
        
        if ($categorie) {
            return $categorie->delete();
        }
        
        return false;
    }

    /**
     * Vérifier si un nom existe déjà
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
     * Compter le nombre total de catégories
     */
    public static function countCategories()
    {
        return self::count();
    }

    /**
     * Rechercher des catégories par terme
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
     * Récupérer les catégories paginées
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
     * Scope pour les catégories avec description
     */
    public function scopeWithDescription($query)
    {
        return $query->whereNotNull('description');
    }

    /**
     * Accesseur pour le nom formaté
     */
    public function getNomFormateAttribute()
    {
        return mb_convert_case($this->nom, MB_CASE_TITLE, "UTF-8");
    }

    /**
     * Accesseur pour la description tronquée
     */
    public function getDescriptionAbregeeAttribute()
    {
        if (!$this->description) {
            return null;
        }
        
        return strlen($this->description) > 120 
            ? substr($this->description, 0, 120) . '...' 
            : $this->description;
    }

    /**
     * Relation avec les projets (si nécessaire)
     */
    public function projets()
    {
        // Si vous avez une relation avec la table projets
        // return $this->hasMany(Projet::class, 'categorie_id');
    }

    /**
     * Récupérer les catégories avec le nombre de projets (si relation)
     */
    public static function getWithProjectCount()
    {
        return self::withCount('projets')
            ->orderBy('nom')
            ->get();
    }
}