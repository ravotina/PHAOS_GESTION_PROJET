<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etape extends Model
{
    use HasFactory;

    protected $table = 'etape';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nom'
    ];

    // Relation avec les validations d'étape
    public function validations()
    {
        return $this->hasMany(EtapeValidation::class, 'id_etape');
    }

    /**
     * Récupérer toutes les étapes
     */
    public static function getAllEtapes()
    {
        return self::orderBy('nom')->get();
    }

    /**
     * Récupérer une étape par son nom
     */
    public static function getByName($name)
    {
        return self::where('nom', $name)->first();
    }
}