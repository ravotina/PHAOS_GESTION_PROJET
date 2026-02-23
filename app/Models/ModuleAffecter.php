<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModuleAffecter extends Model
{
    use HasFactory;

    protected $table = 'module_affecter';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nom'
    ];

    public static $rules = [
        'nom' => 'required|string|max:100|unique:module_affecter,nom'
    ];

    /**
     * Relation avec les emplois du temps
     */
    public function emploisDuTemps(): HasMany
    {
        return $this->hasMany(EmploiDuTemps::class, 'id_module_affecter');
    }

    /**
     * Méthodes utilitaires
     */
    public static function getAll()
    {
        return self::orderBy('nom', 'asc')->get();
    }

    public static function getForSelect()
    {
        return self::orderBy('nom', 'asc')->pluck('nom', 'id')->toArray();
    }

    public function getEmploisByLancement($lancementId)
    {
        return $this->emploisDuTemps()
                   ->where('id_lancement_du_projet', $lancementId)
                   ->orderBy('date_debut', 'asc')
                   ->get();
    }
}