<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LancementProjet extends Model
{
    use HasFactory;

    protected $table = 'lancement_du_projet';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'description',
        'date_debu',
        'date_fin',
        'budget',
        'id_projet_demare',
        'id_utilisateur'
    ];

    protected $casts = [
        'date_debu' => 'date',
        'date_fin' => 'date',
        'budget' => 'decimal:2',
        'id_projet_demare' => 'integer',
        'id_utilisateur' => 'integer'
    ];

    public static $rules = [
        'nom' => 'required|string|max:250',
        'description' => 'nullable|string',
        'date_debu' => 'nullable|date',
        'date_fin' => 'nullable|date|after_or_equal:date_debu',
        'budget' => 'nullable|numeric|min:0',
    ];

    /**
     * Relation avec le projet démarré
     */
    public function projetDemare(): BelongsTo
    {
        return $this->belongsTo(ProjetDemare::class, 'id_projet_demare');
    }

    /**
     * Relation avec les détails
     */
    public function details(): HasMany
    {
        return $this->hasMany(LancementProjetDetail::class, 'id_lancement_projet', 'id');
    }

    /**
     * Méthodes utilitaires
     */
    public static function getByProjetDemare($projetDemareId)
    {
        return self::with(['projetDemare', 'details'])
                  ->where('id_projet_demare', $projetDemareId)
                  ->orderBy('date_debu', 'desc')
                  ->get();
    }

    public static function createLancement($data)
    {
        return self::create([
            'nom' => $data['nom'],
            'description' => $data['description'] ?? null,
            'date_debu' => $data['date_debu'] ?? null,
            'date_fin' => $data['date_fin'] ?? null,
            'budget' => $data['budget'] ?? 0,
            'id_projet_demare' => $data['id_projet_demare'],
            'id_utilisateur' => $data['id_utilisateur'] ?? auth()->id()
        ]);
    }

    public function getDureeAttribute()
    {
        if ($this->date_debu && $this->date_fin) {
            return $this->date_debu->diffInDays($this->date_fin);
        }
        return null;
    }

    public function getBudgetFormattedAttribute()
    {
        return number_format($this->budget, 2, ',', ' ') . ' €';
    }
}