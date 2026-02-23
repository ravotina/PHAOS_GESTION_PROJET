<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interlocuteur extends Model
{
    use HasFactory;

    protected $table = 'interlocuteur';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    
    protected $fillable = [
        'id_client',
        'nom_interlocuteur',
        'fonction',
        'email',
        'lieu_operation'
    ];

    protected $hidden = [];
    protected $casts = [];

    /**
     * Règles de validation
     */
    public static $rules = [
        'id_client' => 'required|integer',
        'nom_interlocuteur' => 'required|string|max:150',
        'fonction' => 'required|string|max:150',
        'email' => 'nullable|email|max:250',
        'lieu_operation' => 'nullable|string|max:250',
        'numeros' => 'nullable|array',
        'numeros.*' => 'string|max:10|regex:/^[0-9]{10}$/'
    ];

    /**
     * Messages de validation personnalisés
     */
    public static $messages = [
        'id_client.required' => 'Le client est obligatoire.',
        'nom_interlocuteur.required' => 'Le nom de l\'interlocuteur est obligatoire.',
        'fonction.required' => 'La fonction est obligatoire.',
        'email.email' => 'L\'email doit être valide.',
        'numeros.*.regex' => 'Chaque numéro doit contenir exactement 10 chiffres.',
        'numeros.*.max' => 'Chaque numéro ne peut pas dépasser 10 chiffres.'
    ];

    /**
     * Relation avec les numéros de téléphone (one-to-many)
     */
    public function numerosTelephone()
    {
        return $this->hasMany(InterlocuteurNumero::class, 'id_interlocuteur');
    }

    /**
     * Relation avec la table pivot interlocateur_utilisateur
     */
    public function interlocateurUtilisateurs()
    {
        return $this->hasMany(InterlocuteurUtilisateur::class, 'id_interlocuteur');
    }

    /**
     * Accesseur pour obtenir la liste des numéros
     */
    public function getNumerosAttribute()
    {
        return $this->numerosTelephone->pluck('numero')->toArray();
    }

    /**
     * Accesseur pour obtenir la liste des IDs utilisateurs
     */
    public function getUtilisateurIdsAttribute()
    {
        return $this->interlocateurUtilisateurs->pluck('id_utilisateur')->toArray();
    }

    /**
     * Accesseur pour obtenir le nom du client
     */
    public function getClientNomAttribute()
    {
        return $this->attributes['client_nom'] ?? "Client #{$this->id_client}";
    }

    /**
     * Récupérer tous les interlocuteurs avec leurs numéros
     */
    public static function getAll()
    {
        return self::with('numerosTelephone')
            ->orderBy('nom_interlocuteur')
            ->get();
    }

    /**
     * Créer un nouvel interlocuteur avec ses numéros
     */
    public static function createInterlocuteur($data)
    {
        $numeros = $data['numeros'] ?? [];
        unset($data['numeros']);
        
        $interlocuteur = self::create($data);
        
        // Ajouter les numéros
        foreach ($numeros as $numero) {
            $interlocuteur->numerosTelephone()->create([
                'numero' => $numero
            ]);
        }
        
        return $interlocuteur;
    }

    /**
     * Mettre à jour un interlocuteur avec ses numéros
     */
    public static function updateInterlocuteur($id, $data)
    {
        $interlocuteur = self::find($id);
        
        if ($interlocuteur) {
            $numeros = $data['numeros'] ?? [];
            unset($data['numeros']);
            
            $interlocuteur->update($data);
            
            // Synchroniser les numéros
            $interlocuteur->syncNumeros($numeros);
            
            return $interlocuteur;
        }
        
        return null;
    }

    /**
     * Supprimer un interlocuteur
     */
    public static function deleteInterlocuteur($id)
    {
        $interlocuteur = self::find($id);
        
        if ($interlocuteur) {
            // Supprimer les relations
            $interlocuteur->numerosTelephone()->delete();
            $interlocuteur->interlocateurUtilisateurs()->delete();
            return $interlocuteur->delete();
        }
        
        return false;
    }

    /**
     * Synchroniser les numéros
     */
    public function syncNumeros(array $numeros)
    {
        // Supprimer tous les anciens numéros
        $this->numerosTelephone()->delete();
        
        // Ajouter les nouveaux numéros
        foreach ($numeros as $numero) {
            if (!empty(trim($numero))) {
                $this->numerosTelephone()->create([
                    'numero' => trim($numero)
                ]);
            }
        }
        
        return true;
    }

    /**
     * Synchroniser les utilisateurs
     */
    public function syncUtilisateurs(array $utilisateurIds)
    {
        $this->interlocateurUtilisateurs()->delete();
        
        foreach ($utilisateurIds as $utilisateurId) {
            InterlocuteurUtilisateur::create([
                'id_interlocuteur' => $this->id,
                'id_utilisateur' => $utilisateurId
            ]);
        }
        
        return true;
    }

    /**
     * Formater pour l'API
     */
    public function toApiFormat($clientsData = [], $utilisateursData = [] ) // , $projets = null
    {
        // Trouver le nom du client
        $clientNom = "Client #{$this->id_client}";
        foreach ($clientsData as $client) {
            if ($client['id'] == $this->id_client) {
                $clientNom = $client['name'];
                break;
            }
        }
        
        // Trouver les utilisateurs associés
        $utilisateursAssocies = [];
        $utilisateurIds = $this->utilisateur_ids ?? [];
        
        if (!empty($utilisateursData['formatted']['users'])) {
            foreach ($utilisateursData['formatted']['users'] as $user) {
                $userId = $user['id'] ?? $user['rowid'] ?? null;
                if ($userId && in_array($userId, $utilisateurIds)) {
                    $utilisateursAssocies[] = [
                        'id' => $userId,
                        'nom' => ($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? ''),
                        'login' => $user['login'] ?? ''
                    ];
                }
            }
        }
        
        // Récupérer les numéros
        $numerosListe = $this->numerosTelephone->pluck('numero')->toArray();


        // $projetsAssocies = [];
        // if ($projets !== null) {
        //     // Si les projets sont passés en paramètre
        //     $projetsAssocies = $projets;
        // } else {
        //     // Sinon, charger depuis la relation
        //     $projetsAssocies = $this->projets->map(function($projet) {
        //         return [
        //             'id' => $projet->id,
        //             'nom' => $projet->nom ?? $projet->titre ?? 'Projet #' . $projet->id,
        //             'reference' => $projet->reference ?? '',
        //             'date_debut' => $projet->date_debut ?? null,
        //             'date_fin' => $projet->date_fin ?? null
        //         ];
        //     })->toArray();
        // }


        $projetsAssocies = $this->projets->map(function($projet) {
            return [
                'id' => $projet->id,
                'nom' => $projet->non_de_projet,
                'client_id' => $projet->id_client,
                'date_debut' => $projet->date_debu,
                'date_fin' => $projet->date_fin
            ];
        })->toArray();

        
        return [
            'id' => $this->id,
            'id_client' => $this->id_client,
            'client_nom' => $clientNom,
            'nom_interlocuteur' => $this->nom_interlocuteur,
            'fonction' => $this->fonction,
            'email' => $this->email,
            'lieu_operation' => $this->lieu_operation,
            'numeros' => $numerosListe,
            'utilisateurs' => $utilisateursAssocies,
            'projets' => $projetsAssocies,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    /**
     * Rechercher des interlocuteurs
     */
    public static function search($term)
    {
        return self::where(function($query) use ($term) {
                $query->where('nom_interlocuteur', 'ILIKE', "%{$term}%")
                      ->orWhere('email', 'ILIKE', "%{$term}%")
                      ->orWhere('fonction', 'ILIKE', "%{$term}%")
                      ->orWhere('lieu_operation', 'ILIKE', "%{$term}%")
                      ->orWhereHas('numerosTelephone', function($q) use ($term) {
                          $q->where('numero', 'ILIKE', "%{$term}%");
                      });
            })
            ->with('numerosTelephone')
            ->orderBy('nom_interlocuteur')
            ->get();
    }

    /**
     * Ajouter un utilisateur à l'interlocuteur
     */
    public function addUtilisateur($utilisateurId)
    {
        return InterlocuteurUtilisateur::create([
            'id_interlocuteur' => $this->id,
            'id_utilisateur' => $utilisateurId
        ]);
    }

    /**
     * Scope pour filtrer par client
     */
    public function scopeByClient($query, $clientId)
    {
        return $query->where('id_client', $clientId);
    }

    /**
     * Scope pour les interlocuteurs avec numéro (CORRIGÉ)
     * Utilise whereHas() au lieu de whereNotNull()
     */
    public function scopeWithNumero($query)
    {
        return $query->whereHas('numerosTelephone');
    }

    /**
     * Scope pour les interlocuteurs sans numéro (CORRIGÉ)
     */
    public function scopeWithoutNumero($query)
    {
        return $query->whereDoesntHave('numerosTelephone');
    }

    /**
     * Compter le nombre d'interlocuteurs avec numéro (CORRIGÉ)
     */
    public static function countWithNumero()
    {
        return self::whereHas('numerosTelephone')->count();
    }

    /**
     * Compter le nombre d'interlocuteurs sans numéro (CORRIGÉ)
     */
    public static function countWithoutNumero()
    {
        return self::whereDoesntHave('numerosTelephone')->count();
    }

    /**
     * Accesseur pour le nom formaté
     */
    public function getNomFormateAttribute()
    {
        return mb_convert_case($this->nom_interlocuteur, MB_CASE_TITLE, "UTF-8");
    }

    /**
     * Récupérer les interlocuteurs avec leurs relations utilisateurs
     */
    public static function getWithUtilisateurs()
    {
        $interlocuteurs = self::orderBy('nom_interlocuteur')->get();
        
        foreach ($interlocuteurs as $interlocuteur) {
            $interlocuteur->load('interlocateurUtilisateurs');
        }
        
        return $interlocuteurs;
    }


    // Dans App\Models\Interlocuteur

    /**
     * Relation many-to-many avec les projets
     */
    public function projets()
    {
        return $this->belongsToMany(
            Projet::class,
            'interlocuteur_projet',
            'id_interlocuteur',
            'id_projet'
        )->withTimestamps();
    }

    /**
     * Ajouter un projet à l'interlocuteur
     */
    public function addProjet($projetId)
    {
        if (!$this->projets()->where('id_projet', $projetId)->exists()) {
            $this->projets()->attach($projetId);
            return true;
        }
        return false;
    }

    /**
     * Retirer un projet de l'interlocuteur
     */
    public function removeProjet($projetId)
    {
        $this->projets()->detach($projetId);
        return true;
    }

    /**
     * Synchroniser les projets
     */
    public function syncProjets(array $projetIds)
    {
        $this->projets()->sync($projetIds);
        return true;
    }

    /**
     * Obtenir la liste des IDs de projets
     */
    public function getProjetIdsAttribute()
    {
        return $this->projets->pluck('id')->toArray();
    }



}