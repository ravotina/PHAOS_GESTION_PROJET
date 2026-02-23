<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilisateurConcerner extends Model
{
    use HasFactory;

    protected $table = 'utilisateur_concerner';
    protected $primaryKey = 'id';

    public $timestamps = false;
    
    protected $fillable = [
        'description_tache',
        'id_utilsateur',
        'id_calandrier'
    ];

    /**
     * Relation avec le calendrier
     */
    public function calendrier()
    {
        return $this->belongsTo(CalendrierPreparation::class, 'id_calandrier');
    }

    public function findByIdCalendrierAndUtilisateur($idCalendrier, $idUtilisateur)
    {
        return self::where('id_calandrier', $idCalendrier)
                    ->where('id_utilsateur', $idUtilisateur)
                    ->first();
    }
}