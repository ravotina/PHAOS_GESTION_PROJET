<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmploiDuTemps extends Model
{
    use HasFactory;

    protected $table = 'emploi_du_temps';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'date_debut',
        'date_fin',
        'description',
        'id_module_affecter', // CHANGÉ
        'id_lancement_du_projet'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date'
    ];

    public static $rules = [
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after_or_equal:date_debut',
        'description' => 'nullable|string',
        'id_module_affecter' => 'required|integer|exists:module_affecter,id', // CHANGÉ
        'id_lancement_du_projet' => 'required|integer|exists:lancement_du_projet,id'
    ];

    /**
     * Relation avec le module affecter
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(ModuleAffecter::class, 'id_module_affecter'); // CHANGÉ
    }

    /**
     * Relation avec le lancement de projet
     */
    public function lancement(): BelongsTo
    {
        return $this->belongsTo(LancementProjet::class, 'id_lancement_du_projet');
    }

    /**
     * Méthodes utilitaires
     */
    public static function getByLancement($lancementId)
    {
        return self::with('module')
                  ->where('id_lancement_du_projet', $lancementId)
                  ->orderBy('date_debut', 'asc')
                  ->get();
    }

    public function getDureeAttribute()
    {
        if ($this->date_debut && $this->date_fin) {
            return $this->date_debut->diffInDays($this->date_fin);
        }
        return null;
    }

    public function getDatesFormattedAttribute()
    {
        $debut = $this->date_debut ? $this->date_debut->format('d/m/Y') : 'N/D';
        $fin = $this->date_fin ? $this->date_fin->format('d/m/Y') : 'N/D';
        
        return "$debut - $fin";
    }
}