<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeIntervention extends Model
{
    use HasFactory;

    /**
     * Nom de la table
     */
    protected $table = 'type_intervention';

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
        'nom' => 'required|string|max:250|unique:type_intervention,nom',
        'description' => 'nullable|string'
    ];

    /**
     * Messages de validation personnalisés
     */
    public static $messages = [
        'nom.required' => 'Le nom du type d\'intervention est obligatoire.',
        'nom.max' => 'Le nom du type d\'intervention ne peut pas dépasser 250 caractères.',
        'nom.unique' => 'Ce type d\'intervention existe déjà.'
    ];

    /**
     * Récupérer tous les types d'intervention
     */
    public static function getAll()
    {
        return self::orderBy('nom')->get();
    }

    /**
     * Récupérer un type d'intervention par son ID
     */
    public static function getById($id)
    {
        return self::find($id);
    }

    /**
     * Récupérer un type d'intervention par son nom
     */
    public static function getByName($nom)
    {
        return self::where('nom', $nom)->first();
    }

    /**
     * Créer un nouveau type d'intervention
     */
    public static function createTypeIntervention($data)
    {
        return self::create([
            'nom' => $data['nom'],
            'description' => $data['description'] ?? null
        ]);
    }

    /**
     * Mettre à jour un type d'intervention
     */
    public static function updateTypeIntervention($id, $data)
    {
        $typeIntervention = self::find($id);
        
        if ($typeIntervention) {
            $typeIntervention->update($data);
            return $typeIntervention;
        }
        
        return null;
    }

    /**
     * Supprimer un type d'intervention
     */
    public static function deleteTypeIntervention($id)
    {
        $typeIntervention = self::find($id);
        
        if ($typeIntervention) {
            return $typeIntervention->delete();
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
     * Compter le nombre total de types d'intervention
     */
    public static function countTypes()
    {
        return self::count();
    }

    /**
     * Rechercher des types d'intervention par terme
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
     * Récupérer les types d'intervention paginés
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
     * Accesseur pour le nom formaté
     */
    public function getNomFormateAttribute()
    {
        return ucwords(strtolower($this->nom));
    }

    /**
     * Accesseur pour la description tronquée
     */
    public function getDescriptionResumeAttribute()
    {
        if (!$this->description) {
            return 'Aucune description';
        }
        
        return strlen($this->description) > 80 
            ? substr($this->description, 0, 80) . '...' 
            : $this->description;
    }


    /**
     * Relation avec les projets (si nécessaire)
     */
    public function projets()
    {
        // Si vous avez une relation avec la table projets
        // return $this->hasMany(Projet::class, 'type_intervention_id');
    }
}