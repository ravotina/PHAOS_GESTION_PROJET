<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjetDemareDetaille extends Model
{
    use HasFactory;

    /**
     * Nom de la table
     */
    protected $table = 'projet_detaille';

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
        'description',
        'file',
        'url', // Ajout du champ url
        'id_projet'
    ];

    /**
     * Cast des champs
     */
    protected $casts = [
        'id_projet' => 'integer',
    ];

    /**
     * Règles de validation
     */
    public static $rules = [
        'nom' => 'required|string|max:50',
        'description' => 'nullable|string',
        'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif|max:2048',
        'url' => 'nullable|url|max:500', // Règles pour l'URL
        'id_projet' => 'required|integer|exists:projet_demare,id'
    ];

    public static $rulesCreate = [
        'nom' => 'required|string|max:50',
        'description' => 'nullable|string',
        'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif|max:2048',
        'url' => 'nullable|url|max:500',
    ];

    /**
     * Règles de validation pour la mise à jour
     */
    public static $rulesUpdate = [
        'nom' => 'required|string|max:50',
        'description' => 'nullable|string',
        'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif|max:2048',
        'url' => 'nullable|url|max:500',
    ];

    /**
     * Relations
     */
    
    /**
     * Relation avec le projet démaré
     */
    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class, 'id_projet', 'id');
    }

    /**
     * Récupérer tous les détails de projet
     */
    public static function getAll()
    {
        return self::with('projet')
                  ->orderBy('id', 'desc')
                  ->get();
    }

    /**
     * Récupérer un détail de projet par son ID
     */
    public static function getById($id)
    {
        return self::with('projet')->find($id);
    }

    /**
     * Récupérer les détails par projet démaré
     */
    public static function getByProjet($projetDemareId)
    {
        return self::with('projet')
                  ->where('id_projet', $projetDemareId)
                  ->orderBy('id', 'desc')
                  ->get();
    }

    /**
     * Créer un nouveau détail de projet
     */
    public static function createDetail($data)
    {
        return self::create([
            'nom' => $data['nom'],
            'description' => $data['description'] ?? null,
            'file' => $data['file'] ?? null,
            'url' => $data['url'] ?? null, // Ajout de l'URL
            'id_projet' => $data['id_projet']
        ]);
    }

    /**
     * Mettre à jour un détail de projet
     */
    public static function updateDetail($id, $data)
    {
        $detail = self::find($id);
        
        if ($detail) {
            $detail->update($data);
            return $detail;
        }
        
        return null;
    }

    /**
     * Supprimer un détail de projet
     */
    public static function deleteDetail($id)
    {
        $detail = self::find($id);
        
        if ($detail) {
            return $detail->delete();
        }
        
        return false;
    }

    /**
     * Compter le nombre total de détails
     */
    public static function countDetails()
    {
        return self::count();
    }

    /**
     * Compter les détails par projet démaré
     */
    public static function countByProjet($projetDemareId)
    {
        return self::where('id_projet', $projetDemareId)->count();
    }

    /**
     * Rechercher des détails par terme
     */
    public static function search($term)
    {
        return self::with('projet')
                  ->where('nom', 'ILIKE', "%{$term}%")
                  ->orWhere('description', 'ILIKE', "%{$term}%")
                  ->orWhere('url', 'ILIKE', "%{$term}%") // Recherche aussi dans l'URL
                  ->orderBy('id', 'desc')
                  ->get();
    }

    /**
     * Récupérer les détails avec fichier
     */
    public static function getWithFiles()
    {
        return self::with('projet')
                  ->whereNotNull('file')
                  ->where('file', '!=', '')
                  ->orderBy('id', 'desc')
                  ->get();
    }

    /**
     * Récupérer les détails avec URL
     */
    public static function getWithUrls()
    {
        return self::with('projet')
                  ->whereNotNull('url')
                  ->where('url', '!=', '')
                  ->orderBy('id', 'desc')
                  ->get();
    }

    /**
     * Vérifier si un nom de détail existe déjà pour un projet donné
     */
    public static function nomExistsForProject($nom, $projetDemareId, $excludeId = null)
    {
        $query = self::where('nom', $nom)
                    ->where('id_projet', $projetDemareId);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }

    /**
     * Get the full URL for the file (accessor)
     */
    public function getFileUrlAttribute()
    {
        if ($this->file) {
            return asset('storage/' . $this->file);
        }
        return null;
    }

    /**
     * Get the file name only (accessor)
     */
    public function getFileNameAttribute()
    {
        if ($this->file) {
            return basename($this->file);
        }
        return null;
    }

    /**
     * Vérifier si le détail a une URL
     */
    public function hasUrl()
    {
        return !empty($this->url);
    }

    /**
     * Vérifier si le détail a un fichier
     */
    public function hasFile()
    {
        return !empty($this->file);
    }
}