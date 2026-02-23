<?php

namespace App\Http\Controllers;

use App\Models\TypeProjet;
use App\Models\TypeIntervention;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
Use App\Models\Interlocuteur;
use App\Models\InterlocuteurUtilisateur;

class ParametreController extends Controller
{

    private $dolibarrClient;
    private $users;

    public function __construct()
    {
        $this->dolibarrClient = new Client();
        $this->users = new User();
    }

    public function index()
    {
        // Vérifier les permissions si nécessaire
        if (!app('permission')->hasModule('api') || !app('permission')->hasPermission('api', 'apikey')) {
            abort(403, 'Accès non autorisé');
        }

        // Récupérer toutes les données pour préchargement
        $typesProjet = TypeProjet::orderBy('nom')->get();
        $typesIntervention = TypeIntervention::orderBy('nom')->get();
        $categories = Categorie::orderBy('nom')->get();

        // Récupérer les clients et utilisateurs pour la section interlocuteurs
        $clientsData = $this->dolibarrClient->getAllClients(100);
        $clients = $clientsData['formatted']['clients'] ?? [];
        
        $utilisateurs = $this->users->getAllUsers();


        // Récupérer les interlocuteurs avec leurs utilisateurs
        $interlocuteursData = Interlocuteur::getWithUtilisateurs();
        
        // Formater les interlocuteurs
        $interlocuteursFormatted = [];
        foreach ($interlocuteursData as $interlocuteur) {
            $interlocuteursFormatted[] = $interlocuteur->toApiFormat($clients, $utilisateurs);
        }

        // Statistiques (méthodes corrigées)
        $stats = [
            'typesProjet' => [
                'total' => $typesProjet->count(),
                'with_description' => $typesProjet->whereNotNull('description')->count(),
            ],
            'typesIntervention' => [
                'total' => $typesIntervention->count(),
                'with_description' => $typesIntervention->whereNotNull('description')->count(),
            ],
            'categories' => [
                'total' => $categories->count(),
                'with_description' => $categories->whereNotNull('description')->count(),
            ],
            'interlocuteurs' => [
                'total' => Interlocuteur::count(),
                'with_numero' => Interlocuteur::countWithNumero(), // Utilisez la nouvelle méthode
                'without_numero' => Interlocuteur::countWithoutNumero(), // Utilisez la nouvelle méthode
            ]

        ];

        return view('parametrage.index', compact(
            'typesProjet', 
            'typesIntervention', 
            'categories',
            'clients',
            'utilisateurs',
            'interlocuteursFormatted',
            'stats'
        ));
    }

    /**
     * API pour récupérer les types de projet (AJAX)
     */
    public function apiTypeProjet()
    {
        try {
            $types = TypeProjet::getAll();
            return response()->json([
                'success' => true,
                'data' => $types,
                'total' => count($types)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des types de projet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API pour rechercher des types de projet
     */
    public function searchTypeProjet(Request $request)
    {
        try {
            $term = $request->input('q', '');
            $types = TypeProjet::search($term);
            
            return response()->json([
                'success' => true,
                'data' => $types,
                'total' => count($types)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API pour récupérer les types d'intervention (AJAX)
     */
    public function apiTypeIntervention()
    {
        try {
            $types = TypeIntervention::getAll();
            return response()->json([
                'success' => true,
                'data' => $types,
                'total' => count($types)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des types d\'intervention',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Mettre à jour la méthode apiInterlocuteurs
    public function apiInterlocuteurs()
    {
        try {
            // Récupérer les interlocuteurs
            $interlocuteurs = Interlocuteur::orderBy('nom_interlocuteur')->get();
            
            // Récupérer les clients depuis Dolibarr pour les noms
            $clientsData = $this->dolibarrClient->getAllClients(100);
            $clients = $clientsData['formatted']['clients'] ?? [];
            
            // Récupérer les utilisateurs depuis Dolibarr
            $utilisateurs = $this->users->getAllUsers();
            
            // Formater les données
            $formattedData = $interlocuteurs->map(function($interlocuteur) use ($clients, $utilisateurs) {
                // Charger les relations utilisateurs
                $interlocuteur->load('interlocateurUtilisateurs');
                
                // Formater selon la nouvelle méthode
                return $interlocuteur->toApiFormat($clients, $utilisateurs);
            });
            
            return response()->json([
                'success' => true,
                'data' => $formattedData,
                'total' => $formattedData->count()
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur apiInterlocuteurs: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des interlocuteurs',
                'error' => env('APP_DEBUG') ? $e->getMessage() : 'Erreur interne'
            ], 500);
        }
    }



    /**
     * API pour rechercher des types d'intervention
     */
    public function searchTypeIntervention(Request $request)
    {
        try {
            $term = $request->input('q', '');
            $types = TypeIntervention::search($term);
            
            return response()->json([
                'success' => true,
                'data' => $types,
                'total' => count($types)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function searchInterlocuteurs(Request $request)
    {
        try {
            $term = $request->input('q', '');
            $interlocuteurs = Interlocuteur::search($term)->load('utilisateurs');
            
            $formattedData = $interlocuteurs->map(function($interlocuteur) {
                return [
                    'id' => $interlocuteur->id,
                    'id_client' => $interlocuteur->id_client,
                    'nom_interlocuteur' => $interlocuteur->nom_interlocuteur,
                    'fonction' => $interlocuteur->fonction,
                    'numero' => $interlocuteur->numero,
                    'utilisateurs' => $interlocuteur->utilisateurs->map(function($user) {
                        return [
                            'id' => $user->id,
                            'nom' => $user->firstname . ' ' . $user->lastname,
                            'login' => $user->login ?? ''
                        ];
                    })
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $formattedData,
                'total' => $formattedData->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * API pour récupérer les catégories (AJAX)
     */
    public function apiCategorie()
    {
        try {
            $categories = Categorie::getAll();
            return response()->json([
                'success' => true,
                'data' => $categories,
                'total' => count($categories)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des catégories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API pour rechercher des catégories
     */
    public function searchCategorie(Request $request)
    {
        try {
            $term = $request->input('q', '');
            $categories = Categorie::search($term);
            
            return response()->json([
                'success' => true,
                'data' => $categories,
                'total' => count($categories)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exporter les paramètres (PDF, CSV, Excel)
     */
    public function export(Request $request)
    {
        $type = $request->input('type', 'pdf');
        $format = $request->input('format', 'all');
        
        switch ($type) {
            case 'csv':
                return $this->exportCsv($format);
            case 'excel':
                return $this->exportExcel($format);
            case 'pdf':
            default:
                return $this->exportPdf($format);
        }
    }

    /**
     * Exporter en CSV
     */
    private function exportCsv($format)
    {
        $filename = 'parametres_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($format) {
            $file = fopen('php://output', 'w');
            
            if ($format === 'all' || $format === 'types-projet') {
                fputcsv($file, ['=== TYPES DE PROJET ===']);
                fputcsv($file, ['ID', 'Nom', 'Description']);
                $types = TypeProjet::getAll();
                foreach ($types as $type) {
                    fputcsv($file, [
                        $type->id,
                        $type->nom,
                        $type->description ?? ''
                    ]);
                }
                fputcsv($file, []); // Ligne vide
            }
            
            if ($format === 'all' || $format === 'types-intervention') {
                fputcsv($file, ['=== TYPES D\'INTERVENTION ===']);
                fputcsv($file, ['ID', 'Nom', 'Description']);
                $types = TypeIntervention::getAll();
                foreach ($types as $type) {
                    fputcsv($file, [
                        $type->id,
                        $type->nom,
                        $type->description ?? ''
                    ]);
                }
                fputcsv($file, []);
            }
            
            if ($format === 'all' || $format === 'categories') {
                fputcsv($file, ['=== CATÉGORIES ===']);
                fputcsv($file, ['ID', 'Nom', 'Description']);
                $categories = Categorie::getAll();
                foreach ($categories as $categorie) {
                    fputcsv($file, [
                        $categorie->id,
                        $categorie->nom,
                        $categorie->description ?? ''
                    ]);
                }
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Exporter en Excel (utiliser un package comme Maatwebsite/Laravel-Excel)
     */
    private function exportExcel($format)
    {
        // À implémenter avec un package Excel
        return response()->json([
            'success' => false,
            'message' => 'Export Excel non implémenté'
        ], 501);
    }


    /**
     * Exporter en PDF
     */
    private function exportPdf($format)
    {
        // À implémenter avec un package PDF (dompdf, barryvdh/laravel-dompdf)
        return response()->json([
            'success' => false,
            'message' => 'Export PDF non implémenté'
        ], 501);
    }


    /**
     * Importer des paramètres depuis un fichier
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
            'type' => 'required|in:types-projet,types-intervention,categories'
        ]);

        try {
            $file = $request->file('file');
            $type = $request->input('type');
            $imported = 0;
            $errors = [];

            $handle = fopen($file->getPathname(), 'r');
            $header = fgetcsv($handle); // Lire l'en-tête
            
            while (($row = fgetcsv($handle)) !== false) {
                try {
                    $data = [
                        'nom' => $row[0] ?? '',
                        'description' => $row[1] ?? null
                    ];

                    switch ($type) {
                        case 'types-projet':
                            TypeProjet::createTypeProjet($data);
                            break;
                        case 'types-intervention':
                            TypeIntervention::createTypeIntervention($data);
                            break;
                        case 'categories':
                            Categorie::createCategorie($data);
                            break;
                    }
                    
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Ligne " . ($imported + count($errors) + 1) . ": " . $e->getMessage();
                }
            }
            
            fclose($handle);

            return response()->json([
                'success' => true,
                'message' => "Importation réussie : $imported éléments importés",
                'imported' => $imported,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'importation',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Afficher les statistiques des paramètres
     */
    public function statistiques()
    {
        $stats = [
            'typesProjet' => [
                'total' => TypeProjet::countTypes(),
                'avec_description' => TypeProjet::withDescription()->count(),
                'sans_description' => TypeProjet::countTypes() - TypeProjet::withDescription()->count(),
                'recentes' => TypeProjet::where('created_at', '>=', now()->subDays(30))->count()
            ],
            'typesIntervention' => [
                'total' => TypeIntervention::countTypes(),
                'avec_description' => TypeIntervention::withDescription()->count(),
                'sans_description' => TypeIntervention::countTypes() - TypeIntervention::withDescription()->count(),
                'recentes' => TypeIntervention::where('created_at', '>=', now()->subDays(30))->count()
            ],
            'categories' => [
                'total' => Categorie::countCategories(),
                'avec_description' => Categorie::withDescription()->count(),
                'sans_description' => Categorie::countCategories() - Categorie::withDescription()->count(),
                'recentes' => Categorie::where('created_at', '>=', now()->subDays(30))->count()
            ]
        ];

        return view('parametre.statistiques', compact('stats'));
    }

    /**
     * Sauvegarder la configuration des paramètres
     */
    public function saveConfig(Request $request)
    {
        $validated = $request->validate([
            'config.*' => 'nullable|string',
            'notifications' => 'nullable|boolean',
            'auto_save' => 'nullable|boolean',
            'export_format' => 'nullable|in:csv,excel,pdf'
        ]);

        // Sauvegarder la configuration dans la session ou base de données
        session(['parametre_config' => $validated]);

        return response()->json([
            'success' => true,
            'message' => 'Configuration sauvegardée',
            'config' => $validated
        ]);
    }



    public function saveInterlocuteur(Request $request)
    {
        try {
            // Valider les données
            $validated = $request->validate([
                'id' => 'nullable|integer',
                'id_client' => 'required|integer',
                'nom_interlocuteur' => 'required|string|max:150',
                'fonction' => 'required|string|max:150',
                'email' => 'nullable|email|max:250',
                'lieu_operation' => 'nullable|string|max:250',
                'numeros' => 'nullable|array', // Accepte un tableau
                'numeros.*' => 'string|max:10|regex:/^[0-9]{10}$/',
                'selected_utilisateurs' => 'nullable|string'
            ]);

            // Si les numéros viennent en JSON
            if ($request->has('numeros_json')) {
                $numerosJson = json_decode($request->input('numeros_json'), true);
                if (is_array($numerosJson)) {
                    $validated['numeros'] = $numerosJson;
                }
            }

            // Convertir les utilisateurs en tableau
            $utilisateurIds = [];
            if (!empty($validated['selected_utilisateurs'])) {
                $ids = explode(',', $validated['selected_utilisateurs']);
                $utilisateurIds = array_filter($ids, function($id) {
                    return is_numeric($id) && $id > 0;
                });
            }

            // Nettoyer les numéros (supprimer les espaces et caractères non numériques)
            if (isset($validated['numeros']) && is_array($validated['numeros'])) {
                $cleanNumeros = [];
                foreach ($validated['numeros'] as $numero) {
                    // Nettoyer le numéro
                    $cleanNum = preg_replace('/\D/', '', trim($numero));
                    
                    // Valider le format
                    if (!preg_match('/^[0-9]{10}$/', $cleanNum)) {
                        return response()->json([
                            'success' => false,
                            'message' => "Le numéro '$numero' doit contenir exactement 10 chiffres après nettoyage"
                        ], 422);
                    }
                    
                    $cleanNumeros[] = $cleanNum;
                }
                $validated['numeros'] = $cleanNumeros;
            }

            // Logique de création/mise à jour
            if (isset($validated['id']) && $validated['id']) {
                // Mise à jour
                $interlocuteur = Interlocuteur::find($validated['id']);
                
                if (!$interlocuteur) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Interlocuteur non trouvé'
                    ], 404);
                }
                
                $interlocuteur->update([
                    'id_client' => $validated['id_client'],
                    'nom_interlocuteur' => $validated['nom_interlocuteur'],
                    'fonction' => $validated['fonction'],
                    'email' => $validated['email'] ?? null,
                    'lieu_operation' => $validated['lieu_operation'] ?? null
                ]);
                
                // Synchroniser les numéros
                $interlocuteur->syncNumeros($validated['numeros'] ?? []);
                
                // Synchroniser les utilisateurs
                $interlocuteur->syncUtilisateurs($utilisateurIds);
                
                $message = 'Interlocuteur mis à jour avec succès';
            } else {
                // Création
                $interlocuteur = Interlocuteur::create([
                    'id_client' => $validated['id_client'],
                    'nom_interlocuteur' => $validated['nom_interlocuteur'],
                    'fonction' => $validated['fonction'],
                    'email' => $validated['email'] ?? null,
                    'lieu_operation' => $validated['lieu_operation'] ?? null
                ]);
                
                // Ajouter les numéros
                if (isset($validated['numeros']) && is_array($validated['numeros'])) {
                    foreach ($validated['numeros'] as $numero) {
                        if (!empty(trim($numero))) {
                            $interlocuteur->numerosTelephone()->create([
                                'numero' => trim($numero)
                            ]);
                        }
                    }
                }
                
                // Ajouter les utilisateurs
                foreach ($utilisateurIds as $utilisateurId) {
                    InterlocuteurUtilisateur::create([
                        'id_interlocuteur' => $interlocuteur->id,
                        'id_utilisateur' => $utilisateurId
                    ]);
                }
                
                $message = 'Interlocuteur créé avec succès';
            }

            // Recharger les relations
            $interlocuteur->load(['numerosTelephone', 'interlocateurUtilisateurs']);
            
            // Récupérer les données pour le formatage
            $clientsData = $this->dolibarrClient->getAllClients(100);
            $clients = $clientsData['formatted']['clients'] ?? [];
            $utilisateursData = $this->users->getAllUsers();

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $interlocuteur->toApiFormat($clients, $utilisateursData)
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            \Log::error('Erreur saveInterlocuteur: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement',
                'error' => env('APP_DEBUG') ? $e->getMessage() : 'Erreur interne'
            ], 500);
        }
    }




    /**
     * Récupérer la configuration
     */
    public function getConfig()
    {
        $config = session('parametre_config', [
            'notifications' => true,
            'auto_save' => false,
            'export_format' => 'csv'
        ]);

        return response()->json([
            'success' => true,
            'config' => $config
        ]);
    }


    public function deleteInterlocuteur($id)
    {
        try {
            $success = Interlocuteur::deleteInterlocuteur($id);
            
            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Interlocuteur supprimé avec succès'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Interlocuteur non trouvé'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * API pour récupérer les projets d'un interlocuteur
     */
    public function apiInterlocuteurProjets($interlocuteurId)
    {
        try {
            $interlocuteur = Interlocuteur::findOrFail($interlocuteurId);
            $projets = $interlocuteur->projets()->get();
            
            return response()->json([
                'success' => true,
                'data' => $projets,
                'total' => $projets->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des projets',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    /**
     * API pour ajouter un projet à un interlocuteur
     */
    public function addProjetToInterlocuteur(Request $request, $interlocuteurId)
    {
        try {
            $request->validate([
                'id_projet' => 'required|integer|exists:projet,id'
            ]);
            
            $interlocuteur = Interlocuteur::findOrFail($interlocuteurId);
            $projetId = $request->input('id_projet');
            
            // Vérifier si la relation existe déjà
            $exists = \App\Models\InterlocuteurProjet::where('id_interlocuteur', $interlocuteurId)
                ->where('id_projet', $projetId)
                ->exists();
            
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce projet est déjà associé à cet interlocuteur'
                ], 400);
            }
            
            // Créer la relation
            \App\Models\InterlocuteurProjet::create([
                'id_interlocuteur' => $interlocuteurId,
                'id_projet' => $projetId
            ]);
            
            // Récupérer les données mises à jour
            $interlocuteur->load('projets');
            
            return response()->json([
                'success' => true,
                'message' => 'Projet ajouté avec succès',
                'data' => $interlocuteur->projets
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Erreur addProjetToInterlocuteur: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout du projet',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }





    /**
     * API pour retirer un projet d'un interlocuteur
     */
    public function removeProjetFromInterlocuteur(Request $request, $interlocuteurId)
    {
        try {
            $request->validate([
                'id_projet' => 'required|integer|exists:projet,id'
            ]);
            
            $projetId = $request->input('id_projet');
            
            // Supprimer la relation
            $deleted = \App\Models\InterlocuteurProjet::where('id_interlocuteur', $interlocuteurId)
                ->where('id_projet', $projetId)
                ->delete();
            
            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Projet retiré avec succès'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Relation non trouvée'
                ], 404);
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Erreur removeProjetFromInterlocuteur: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du retrait du projet',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }


    
    public function syncInterlocuteurProjets(Request $request, $interlocuteurId)
    {
        try {
            $request->validate([
                'projets' => 'nullable|array',
                'projets.*' => 'integer|exists:projet,id'
            ]);
            
            $interlocuteur = Interlocuteur::findOrFail($interlocuteurId);
            $projets = $request->input('projets', []);
            
            $interlocuteur->syncProjets($projets);
            
            return response()->json([
                'success' => true,
                'message' => 'Projets synchronisés avec succès',
                'data' => $interlocuteur->projets()->get()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la synchronisation',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function apiProjetsList()
    {
        try {
            $projets = \App\Models\Projet::select('id', 'non_de_projet', 'id_client', 'date_debu', 'date_fin')
                ->orderBy('non_de_projet')
                ->get()
                ->map(function($projet) {
                    return [
                        'id' => $projet->id,
                        'nom' => $projet->non_de_projet,
                        'client_id' => $projet->id_client,
                        'date_debut' => $projet->date_debu,
                        'date_fin' => $projet->date_fin
                    ];
                });
                
            return response()->json([
                'success' => true,
                'data' => $projets
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur chargement projets: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur de chargement des projets'
            ], 500);
        }
    }





}


