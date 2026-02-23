<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjetDemare extends Model
{
    use HasFactory;

    /**
     * Nom de la table
     */
    protected $table = 'projet_demare';

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
        'non_de_projet',
        'date_debu',
        'date_fin',
        'dedlinne',
        'description',
        'id_utilisateur',
        'id_client',
        'id_projet',
        'status'
    ];

    /**
     * Cast des champs
     */
    protected $casts = [
        'date_debu' => 'date',
        'date_fin' => 'date',
        'dedlinne' => 'integer',
        'id_utilisateur' => 'integer',
        'id_client' => 'integer',
        'id_projet' => 'integer',
        
    ];

    /**
     * Règles de validation
     */
    public static $rules = [
        'non_de_projet' => 'required|string|max:250',
        'date_debu' => 'nullable|date',
        'date_fin' => 'nullable|date|after_or_equal:date_debu',
        'dedlinne' => 'nullable|integer|min:0',
        'description' => 'nullable|string',
        'id_utilisateur' => 'required|integer',
        'id_client' => 'required|integer',
        'id_projet' => 'required|integer|exists:type_projet,id_projet',
        'status' => 'nullable|string|max:50'
    ];

    /**
     * Relations
     */
    
    /**
     * Relation avec le type de projet
     */
    public function typeProjet(): BelongsTo
    {
        return $this->belongsTo(TypeProjet::class, 'id_projet', 'id');
    }

    /**
     * Récupérer tous les projets
     */
    public static function getAll()
    {
        return self::with('typeProjet')
                  ->orderBy('id', 'desc')
                  ->get();
    }

    /**
     * Récupérer un projet par son ID
     */
    public static function getById($id)
    {
        return self::with('typeProjet')->find($id);
    }

    /**
     * Récupérer les projets par utilisateur
     */
    public static function getByUser($userId)
    {
        return self::with('typeProjet')
                  ->where('id_utilisateur', $userId)
                  ->orderBy('id', 'desc')
                  ->get();
    }

    /**
     * Récupérer les projets par client
     */
    public static function getByClient($clientId)
    {
        return self::with('typeProjet')
                  ->where('id_client', $clientId)
                  ->orderBy('id', 'desc')
                  ->get();
    }

    /**
     * Récupérer les projets par type
     */
    public static function getByType($typeId)
    {
        return self::with('typeProjet')
                  ->where('id_projet', $typeId)
                  ->orderBy('id', 'desc')
                  ->get();
    }

    /**
     * Créer un nouveau projet
     */
    public static function createProjet($data)
    {
        return self::create([
            'non_de_projet' => $data['non_de_projet'],
            'date_debu' => $data['date_debu'] ?? null,
            'date_fin' => $data['date_fin'] ?? null,
            'dedlinne' => $data['dedlinne'] ?? null,
            'description' => $data['description'] ?? null,
            'id_utilisateur' => $data['id_utilisateur'],
            'id_client' => $data['id_client'],
            'id_projet' => $data['id_projet']
        ]);
    }

    /**
     * Mettre à jour un projet
     */
    public static function updateProjet($id, $data)
    {
        $projet = self::find($id);
        
        if ($projet) {
            $projet->update($data);
            return $projet;
        }
        
        return null;
    }

    /**
     * Supprimer un projet
     */
    public static function deleteProjet($id)
    {
        $projet = self::find($id);
        
        if ($projet) {
            return $projet->delete();
        }
        
        return false;
    }

    /**
     * Compter le nombre total de projets
     */
    public static function countProjets()
    {
        return self::count();
    }

    /**
     * Compter les projets par utilisateur
     */
    public static function countByUser($userId)
    {
        return self::where('id_utilisateur', $userId)->count();
    }

    /**
     * Compter les projets par client
     */
    public static function countByClient($clientId)
    {
        return self::where('id_client', $clientId)->count();
    }

    /**
     * Rechercher des projets par terme
     */
    public static function search($term)
    {
        return self::with('typeProjet')
                  ->where('non_de_projet', 'ILIKE', "%{$term}%")
                  ->orWhere('description', 'ILIKE', "%{$term}%")
                  ->orderBy('id', 'desc')
                  ->get();
    }

    /**
     * Récupérer les projets en cours (date actuelle entre date_debu et date_fin)
     */
    public static function getProjetsEnCours()
    {
        $now = now()->format('Y-m-d');
        
        return self::with('typeProjet')
                  ->where('date_debu', '<=', $now)
                  ->where('date_fin', '>=', $now)
                  ->orderBy('date_fin', 'asc')
                  ->get();
    }

    /**
     * Récupérer les projets à venir (date_debu > maintenant)
     */
    public static function getProjetsAVenir()
    {
        $now = now()->format('Y-m-d');
        
        return self::with('typeProjet')
                  ->where('date_debu', '>', $now)
                  ->orderBy('date_debu', 'asc')
                  ->get();
    }

    /**
     * Récupérer les projets terminés (date_fin < maintenant)
     */
    public static function getProjetsTermines()
    {
        $now = now()->format('Y-m-d');
        
        return self::with('typeProjet')
                  ->where('date_fin', '<', $now)
                  ->orderBy('date_fin', 'desc')
                  ->get();
    }

    /**
     * Vérifier si un nom de projet existe déjà
     */
    public static function nomExists($nom, $excludeId = null)
    {
        $query = self::where('non_de_projet', $nom);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }
}