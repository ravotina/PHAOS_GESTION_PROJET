<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'email_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_utilisateur',
        'email_destinataire',
        'sujet',
        'contenu_html',
        'donnees_envoyees',
        'type_email',
        'statut',
        'erreur_message',
        'modele_source',
        'id_source',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'donnees_envoyees' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }

    /**
     * Scope pour les emails par type
     */
    public function scopeParType($query, $type)
    {
        return $query->where('type_email', $type);
    }

    /**
     * Scope pour les emails par statut
     */
    public function scopeParStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }

    /**
     * Scope pour les emails par destinataire
     */
    public function scopeParDestinataire($query, $email)
    {
        return $query->where('email_destinataire', $email);
    }

    /**
     * Scope pour les emails par source
     */
    public function scopeParSource($query, $modele, $id)
    {
        return $query->where('modele_source', $modele)
                     ->where('id_source', $id);
    }

    /**
     * Marquer l'email comme envoyé avec succès
     */
    public function marquerEnvoye()
    {
        $this->update([
            'statut' => 'envoye',
            'erreur_message' => null,
        ]);
    }

    /**
     * Marquer l'email comme en erreur
     */
    public function marquerErreur($messageErreur)
    {
        $this->update([
            'statut' => 'erreur',
            'erreur_message' => $messageErreur,
        ]);
    }
}