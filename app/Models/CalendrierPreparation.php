<?php
// app/Models/CalendrierPreparation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Projet;

class CalendrierPreparation extends Model
{
    use HasFactory;

    protected $table = 'calandrier_preparation';
    protected $primaryKey = 'id';

    public $timestamps = false;
    
    protected $fillable = [
        'title',
        'date_debut',
        'date_fin',
        'decription',
        'color',
        'utilisateur_id',
        'id_projet'
    ];

     protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    /**
     * Relation avec le projet
     */
    public function projet()
    {
        return $this->belongsTo(Projet::class, 'id_projet');
    }

    /**
     * Accessor pour FullCalendar
     */
    public function getStartAttribute()
    {
        return $this->date_debut;
    }

    public function getEndAttribute()
    {
        return $this->date_fin;
    }
}