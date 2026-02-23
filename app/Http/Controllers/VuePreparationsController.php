<?php

namespace App\Http\Controllers;

use App\Models\VuePreparationsProjetComplete;
use App\Models\ProjetDemare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;

class VuePreparationsController extends Controller
{
    /**
     * Afficher la vue des préparations
     */
    public function index(Request $request)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }

        // Récupérer TOUS les projets (pas seulement ceux de l'utilisateur)
        $projets = ProjetDemare::orderBy('non_de_projet')->get();
        
        // Récupérer les projets de l'utilisateur
        $projets = ProjetDemare::orderBy('non_de_projet')->get();
        
        // Initialiser la requête
        $query = VuePreparationsProjetComplete::query();

        // Récupérer tous les utilisateurs
        $tousUtilisateurs = $this->getAllUsersWithDetails();
        
        // Appliquer les filtres
        $searchParams = $request->all();
        
        if (!empty($searchParams['projet_id'])) {
            $query->where('projet_id', $searchParams['projet_id']);
        }
        
        if (!empty($searchParams['calendrier'])) {
            $query->where('titre_calendrier', 'like', '%' . $searchParams['calendrier'] . '%');
        }
        
        if (!empty($searchParams['type_tache'])) {
            $query->where('type_tache', 'like', '%' . $searchParams['type_tache'] . '%');
        }
        
        if (!empty($searchParams['date_debut'])) {
            $query->whereDate('date_preparation', '>=', $searchParams['date_debut']);
        }
        
        if (!empty($searchParams['date_fin'])) {
            $query->whereDate('date_preparation', '<=', $searchParams['date_fin']);
        }
        
        if (!empty($searchParams['avec_fichiers']) && $searchParams['avec_fichiers'] == '1') {
            $query->where('nombre_details', '>', 0)
                  ->whereNotNull('details_json')
                  ->whereRaw("details_json != '[]'")
                  ->whereRaw("details_json != 'null'");
        }
        
        // Filtrer seulement les lignes avec des préparations
        $query->whereNotNull('preparation_id');
        
        // Pagination
        $preparations = $query->orderBy('date_preparation', 'desc')
            ->orderBy('projet_id')
            ->paginate(20)
            ->appends($searchParams);
        
        // Calculer les statistiques
        $stats = $this->calculateStats($query);

        // Créer un tableau de mapping projet_id => projet_demare
        $projetDetails = [];
        foreach ($projets as $projet) {
            $projetDetails[$projet->id] = $projet;
        }
        
        return view('preparation.index', compact(
            'preparations', 
            'projets', 
            'projetDetails',
            'searchParams',
            'stats',
            'tousUtilisateurs'
        ));
    }


    // Ajouter une méthode helper pour récupérer le nom d'utilisateur
    private function getNomUtilisateur($userId, $users)
    {
        if (isset($users[$userId])) {
            $nom = $users[$userId]['nom_complet'];
            // Si le nom est vide, utiliser le login
            return !empty($nom) ? $nom : $users[$userId]['login'];
        }
        return 'Utilisateur ' . $userId;
    }
    
    /**
     * Calculer les statistiques
     */
    private function calculateStats($query)
    {
        // Cloner la requête pour les stats
        $statsQuery = clone $query;
        
        $stats = [
            'total_preparations' => $statsQuery->count(),
            'total_details' => $statsQuery->sum('nombre_details'),
            'total_calendriers' => $statsQuery->distinct('calendrier_id')->count('calendrier_id'),
            'avec_fichiers' => $statsQuery->where('nombre_details', '>', 0)->count()
        ];
        
        return $stats;
    }
    
    /**
     * Recherche avancée
     */
    public function search(Request $request)
    {
        return $this->index($request);
    }
    
    /**
     * Afficher par projet
     */
    public function byProjet($projetId)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }
        
        // Vérifier que l'utilisateur a accès au projet
        $projet = ProjetDemare::where('id', $projetId)
            ->where('id_utilisateur', $userId)
            ->firstOrFail();
        
        $preparations = VuePreparationsProjetComplete::where('projet_id', $projetId)
            ->whereNotNull('preparation_id')
            ->orderBy('date_preparation', 'desc')
            ->paginate(20);
        
        $projets = ProjetDemare::where('id_utilisateur', $userId)
            ->orderBy('non_de_projet')
            ->get();
        
        // Calculer les stats pour ce projet
        $stats = [
            'total_preparations' => $preparations->total(),
            'total_details' => $preparations->sum('nombre_details'),
            'total_calendriers' => VuePreparationsProjetComplete::where('projet_id', $projetId)
                ->whereNotNull('preparation_id')
                ->distinct('calendrier_id')
                ->count('calendrier_id'),
            'avec_fichiers' => VuePreparationsProjetComplete::where('projet_id', $projetId)
                ->whereNotNull('preparation_id')
                ->where('nombre_details', '>', 0)
                ->count()
        ];
        
        return view('preparation.index', compact(
            'preparations',
            'projets',
            'stats'
        ));
    }
    
    /**
     * Télécharger un fichier
     */


    // public function downloadFile($detailId)
    // {
    //     try {
    //         // Récupérer toutes les lignes qui contiennent ce détail
    //         $preparations = VuePreparationsProjetComplete::whereNotNull('details_json')
    //             ->whereRaw("details_json::text like '%\"detail_id\" : {$detailId}%'")
    //             ->get();
            
    //         if ($preparations->isEmpty()) {
    //             abort(404, 'Fichier non trouvé');
    //         }
            
    //         // Trouver le détail spécifique
    //         foreach ($preparations as $prep) {
    //             $details = json_decode($prep->details_json, true);
    //             if (!is_array($details)) {
    //                 continue;
    //             }
                
    //             foreach ($details as $detail) {
    //                 if (isset($detail['detail_id']) && $detail['detail_id'] == $detailId) {
    //                     $fileName = $detail['fichier'] ?? null;
    //                     $detailNom = $detail['nom'] ?? 'fichier';
                        
    //                     if ($fileName) {
    //                         $filePath = public_path('uploads/detaille_a_faire/' . $fileName);
                            
    //                         if (file_exists($filePath)) {
    //                             return response()->download($filePath, $detailNom . '.' . pathinfo($fileName, PATHINFO_EXTENSION));
    //                         }
    //                     }
    //                 }
    //             }
    //         }
            
    //         abort(404, 'Fichier non trouvé sur le serveur');
            
    //     } catch (\Exception $e) {
    //         Log::error('Erreur téléchargement fichier:', [
    //             'detail_id' => $detailId,
    //             'message' => $e->getMessage()
    //         ]);
            
    //         abort(500, 'Erreur lors du téléchargement');
    //     }
    // }





    public function downloadFile($detailId)
    {
        try {
            // Récupérer toutes les lignes qui contiennent ce détail
            $preparations = VuePreparationsProjetComplete::whereNotNull('details_json')
                ->get();
            
            if ($preparations->isEmpty()) {
                abort(404, 'Fichier non trouvé');
            }
            
            // Trouver le détail spécifique
            foreach ($preparations as $prep) {
                // Le cast dans le modèle retourne déjà un tableau
                // Pas besoin de json_decode()
                $details = $prep->details; // Utilisez l'accessor qui gère déjà le parsing
                
                if (!is_array($details) || empty($details)) {
                    continue;
                }
                
                foreach ($details as $detail) {
                    if (isset($detail['detail_id']) && $detail['detail_id'] == $detailId) {
                        $fileName = $detail['fichier'] ?? null;
                        $detailNom = $detail['nom'] ?? 'fichier';
                        
                        if ($fileName) {
                            $filePath = public_path('uploads/detaille_a_faire/' . $fileName);
                            
                            if (file_exists($filePath)) {
                                return response()->download($filePath, $detailNom . '.' . pathinfo($fileName, PATHINFO_EXTENSION));
                            }
                        }
                    }
                }
            }
            
            abort(404, 'Fichier non trouvé sur le serveur');
            
        } catch (\Exception $e) {
            Log::error('Erreur téléchargement fichier:', [
                'detail_id' => $detailId,
                'message' => $e->getMessage()
            ]);
            
            abort(500, 'Erreur lors du téléchargement');
        }
    }
    
    /**
     * Exporter en CSV
     */
    public function exportCsv(Request $request)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            abort(401, 'Non autorisé');
        }
        
        // Appliquer les mêmes filtres que pour l'affichage
        $query = VuePreparationsProjetComplete::query()
            ->whereNotNull('preparation_id');
        
        if ($request->has('projet_id') && $request->projet_id) {
            $query->where('projet_id', $request->projet_id);
        }
        
        if ($request->has('calendrier') && $request->calendrier) {
            $query->where('titre_calendrier', 'like', '%' . $request->calendrier . '%');
        }
        
        if ($request->has('type_tache') && $request->type_tache) {
            $query->where('type_tache', 'like', '%' . $request->type_tache . '%');
        }
        
        if ($request->has('date_debut') && $request->date_debut) {
            $query->whereDate('date_preparation', '>=', $request->date_debut);
        }
        
        if ($request->has('date_fin') && $request->date_fin) {
            $query->whereDate('date_preparation', '<=', $request->date_fin);
        }
        
        $preparations = $query->orderBy('date_preparation', 'desc')
            ->orderBy('projet_id')
            ->get();
        
        $filename = 'preparations_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($preparations) {
            $file = fopen('php://output', 'w');
            
            // En-têtes en français
            fputcsv($file, [
                'Projet ID',
                'Nom Projet',
                'Statut Projet',
                'Calendrier',
                'Tâche assignée',
                'Type Tâche',
                'Description Préparation',
                'Date Préparation',
                'Nombre Détails',
                'Fichiers joints'
            ], ';');
            
            foreach ($preparations as $prep) {
                $fichiers = '';
                if ($prep->hasFiles()) {
                    $fichierNoms = [];
                    foreach ($prep->files as $file) {
                        $fichierNoms[] = $file['nom'] . '.' . pathinfo($file['fichier'], PATHINFO_EXTENSION);
                    }
                    $fichiers = implode(', ', $fichierNoms);
                }
                
                fputcsv($file, [
                    $prep->projet_id,
                    $prep->non_de_projet,
                    $prep->statut_projet,
                    $prep->titre_calendrier,
                    $prep->description_tache,
                    $prep->type_tache,
                    $prep->description_preparation,
                    $prep->date_preparation ? $prep->date_preparation->format('d/m/Y') : '',
                    $prep->nombre_details,
                    $fichiers
                ], ';');
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }


    // Remplacer la méthode getFilesAttribute() par :
    public function getFilesAttribute()
    {
        $files = [];

        try {
            if (!empty($this->details_json)) {
                $details = is_string($this->details_json) 
                    ? json_decode($this->details_json, true) 
                    : $this->details_json;
                
                if (is_array($details)) {
                    foreach ($details as $detail) {
                        if (isset($detail['fichier']) && !empty($detail['fichier'])) {
                            $files[] = [
                                'detail_id' => $detail['detail_id'] ?? null,
                                'nom' => $detail['nom'] ?? 'Sans nom',
                                'fichier' => $detail['fichier'],
                                'file_type' => $detail['file_type'] ?? $this->getFileType($detail['fichier']),
                                'description' => $detail['description'] ?? null,
                                'has_file' => true
                            ];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error('Erreur parsing details_json:', [
                'preparation_id' => $this->preparation_id,
                'details_json' => $this->details_json,
                'error' => $e->getMessage()
            ]);
        }

        return $files;
    }

    // Ajouter cette méthode helper :
    private function getFileType($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        $types = [
            'pdf' => 'PDF',
            'doc' => 'Word',
            'docx' => 'Word',
            'xls' => 'Excel',
            'xlsx' => 'Excel',
            'jpg' => 'Image',
            'jpeg' => 'Image',
            'png' => 'Image',
            'txt' => 'Texte'
        ];
        
        return $types[$extension] ?? 'Autre';
    }

    // Remplacer hasFiles() par :
    public function hasFiles()
    {
        return count($this->files) > 0;
    }


    private function getAllUsersWithDetails()
    {
        try {
            $userModel = new \App\Models\User();
            $usersData = $userModel->getAllUsers();
            
            // Créer un tableau simple id => nom complet
            $users = [];
            if (isset($usersData['formatted']['users'])) {
                foreach ($usersData['formatted']['users'] as $user) {
                    if ($user['id']) {
                        $users[$user['id']] = [
                            'id' => $user['id'],
                            'nom_complet' => trim($user['firstname'] . ' ' . $user['lastname']),
                            'login' => $user['login'],
                            'email' => $user['email'],
                            'is_admin' => $user['admin'] == '1'
                        ];
                    }
                }
            }
            
            return $users;
        } catch (\Exception $e) {
            Log::error('Erreur récupération utilisateurs: ' . $e->getMessage());
            return [];
        }
    }

    // Méthode pour récupérer les projets par créateur
    public function byCreateur($createurId)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }
        
        $projets = ProjetDemare::orderBy('non_de_projet')->get();
        $tousUtilisateurs = $this->getAllUsersWithDetails();
        
        $preparations = VuePreparationsProjetComplete::where('id_createur_preparation', $createurId)
            ->whereNotNull('preparation_id')
            ->orderBy('date_preparation', 'desc')
            ->paginate(20);
        
        $stats = [
            'total_preparations' => $preparations->total(),
            'total_details' => $preparations->sum('nombre_details'),
            'total_calendriers' => VuePreparationsProjetComplete::where('id_createur_preparation', $createurId)
                ->whereNotNull('preparation_id')
                ->distinct('calendrier_id')
                ->count('calendrier_id'),
            'avec_fichiers' => VuePreparationsProjetComplete::where('id_createur_preparation', $createurId)
                ->whereNotNull('preparation_id')
                ->where('nombre_details', '>', 0)
                ->count()
        ];
        
        $projetDetails = [];
        foreach ($projets as $projet) {
            $projetDetails[$projet->id] = $projet;
        }
        
        return view('vue_preparations.index', compact(
            'preparations',
            'projets',
            'projetDetails',
            'stats',
            'tousUtilisateurs'
        ));
    }

}