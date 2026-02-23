<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;


    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'notification';

    public $timestamps = false;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'id_utilisateur',
        'gmail_utilisateur',
        'table_source',
        'date_heur_notification',
        'titre',
        'date_debu',
        'date_fin',
        'description',
        'etat',
        'id_table_source'
    ];

    /**
     * Les attributs qui doivent être convertis en types natifs.
     *
     * @var array
     */
    protected $casts = [
        'date_heur_notification' => 'datetime',
        'date_debu' => 'date',
        'date_fin' => 'date',
        'etat' => 'integer',
        'id_table_source' => 'integer'
    ];

    /**
     * Les attributs qui doivent être cachés lors de la sérialisation.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Les attributs par défaut.
     *
     * @var array
     */
    protected $attributes = [
        'etat' => 0 // 0 = non lu, 1 = lu
    ];
    

}
