<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EtapeValidationDetail extends Model
{
    use HasFactory;

    protected $table = 'etape_validation_detaille';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'description',
        'file',
        'id_etapes_validation'
    ];

    // Relation avec l'étape de validation
    public function etapeValidation(): BelongsTo
    {
        return $this->belongsTo(EtapeValidation::class, 'id_etapes_validation');
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
}