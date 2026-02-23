<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LancementProjetDetail extends Model
{
    use HasFactory;

    protected $table = 'lancement_projet_detaille';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'description',
        'file',
        'id_lancement_projet'
    ];

    protected $casts = [
        'id_lancement_projet' => 'integer'
    ];

    public static $rules = [
        'nom' => 'required|string|max:50',
        'description' => 'nullable|string',
        'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif|max:2048',
    ];

    /**
     * Relation avec le lancement de projet
     */
    public function lancementProjet(): BelongsTo
    {
        return $this->belongsTo(LancementProjet::class, 'id_lancement_projet');
    }

    /**
     * Accesseurs
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

    public static function getByLancement($lancementId)
    {
        return self::with('lancementProjet')
                  ->where('id_lancement_projet', $lancementId)
                  ->orderBy('id', 'desc')
                  ->get();
    }
}