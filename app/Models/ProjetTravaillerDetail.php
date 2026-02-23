<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjetTravaillerDetail extends Model
{
    use HasFactory;

    protected $table = 'projet_travailler_detaille';
    protected $primaryKey = 'id';
    
    // Si tu as des timestamps dans la table, sinon mets à false
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'description',
        'file',
        'id_projects_travailler'
    ];

    protected $casts = [
        'id_projects_travailler' => 'integer'
    ];

    public static $rules = [
        'nom' => 'required|string|max:50',
        'description' => 'nullable|string',
        'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,txt|max:5120', // 5MB
    ];

    /**
     * Relation avec le projet travaillé
     */

     public function projetTravailler()
    {
        return $this->belongsTo(ProjectTravailler::class, 'id_projects_travailler');
    }

    /**
     * Accesseurs pour les fichiers
     */
    public function getFileUrlAttribute()
    {
        if ($this->file) {
            return asset('storage/' . $this->file);
        }
        return null;
    }

    public function getFileNameAttribute()
    {
        if ($this->file) {
            return basename($this->file);
        }
        return null;
    }

    public function getFileExtensionAttribute()
    {
        if ($this->file) {
            return pathinfo($this->file, PATHINFO_EXTENSION);
        }
        return null;
    }

    public function getFileIconAttribute()
    {
        if (!$this->file) return 'bi-file-earmark';
        
        $extension = strtolower($this->file_extension);
        
        $icons = [
            'pdf' => 'bi-file-earmark-pdf',
            'doc' => 'bi-file-earmark-word',
            'docx' => 'bi-file-earmark-word',
            'xls' => 'bi-file-earmark-excel',
            'xlsx' => 'bi-file-earmark-excel',
            'jpg' => 'bi-file-earmark-image',
            'jpeg' => 'bi-file-earmark-image',
            'png' => 'bi-file-earmark-image',
            'gif' => 'bi-file-earmark-image',
            'txt' => 'bi-file-earmark-text',
        ];
        
        return $icons[$extension] ?? 'bi-file-earmark';
    }

    /**
     * Récupérer les détails d'un projet
     */
    public static function getByProjet($projetId)
    {
        return self::with('projetTravailler')
                  ->where('id_projects_travailler', $projetId)
                  ->orderBy('id', 'desc')
                  ->get();
    }
}