<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectTravailler;
use App\Models\ProjetTravaillerDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\LancementProjet;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Etape;
use App\Models\WorkflowValidation;
use App\Models\UtilisateurConcernerWorkflow;
use App\Models\User;
use App\Models\EtapeValidation;

class ProjectTravaillerController extends Controller
{


    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $lancements = LancementProjet::orderBy('date_debu', 'desc')
                            ->orderBy('id', 'desc')
                            ->get();

        Log::info('Lancements pour création de projet récupérés', [
            'count' => $lancements->count(),
        ]);
        
        return view('valideProject.formulaire-projet', compact('lancements'));
    }


    // public function create()
    // {
    //     $lancements = LancementProjet::orderBy('date_debu', 'desc')
    //                         ->orderBy('id', 'desc')
    //                         ->get();

    //     // RÉCUPÉRER LES UTILISATEURS DIRECTEMENT DEPUIS DOLIBARR
    //     $userService = new User();
    //     $usersResponse = $userService->getAllUsers();
        
    //     $utilisateurs = [];
    //     if (isset($usersResponse['formatted']['users'])) {
    //         $utilisateurs = $usersResponse['formatted']['users'];
    //     }
        
    //     Log::info('Formulaire création projet chargé', [
    //         'lancements_count' => $lancements->count(),
    //         'utilisateurs_count' => count($utilisateurs)
    //     ]);
        
    //     return view('valideProject.formulaire-projet', compact('lancements', 'utilisateurs'));
    // }



    /**
     * Enregistre un nouveau projet avec ses fichiers
     */
    // public function store(Request $request)
    // {
    //     $userId = Session::get('user.id');
        
    //     // Validation du projet principal
    //     $validated = $request->validate([
    //         'numero_projet' => 'required|string|max:50|unique:projects_travailler',
    //         'titre' => 'required|string|max:50',
    //         'description' => 'nullable|string',
    //         'objectif' => 'nullable|string',
    //         'date_debu' => 'nullable|date',
    //         'date_fin' => 'nullable|date|after_or_equal:date_debu',
    //         'id_lancement_projet' => 'required|integer',
    //     ]);

    //     $validated['id_utilisateur'] = $userId;

    //     if (!$userId) {
    //         return redirect('/login')->with('error', 'Veuillez vous connecter.');
    //     }

    //     try {
    //         // Démarrer une transaction
    //         DB::beginTransaction();
            
    //         // 1. Créer le projet principal
    //         $project = ProjectTravailler::create($validated);
            
    //         Log::info('Projet créé avec succès', [
    //             'project_id' => $project->id,
    //             'numero_projet' => $project->numero_projet
    //         ]);

    //         Log::info($request);
            
    //         // 2. Gérer les fichiers s'il y en a
    //         if ($request->hasFile('files')) {
    //             $files = $request->file('files');
    //             $fileNames = $request->input('file_names', []);
    //             $fileDescriptions = $request->input('file_descriptions', []);
                
    //             Log::info('Fichiers reçus', [
    //                 'count' => count($files),
    //                 'file_names_count' => count($fileNames)
    //             ]);
                
    //             foreach ($files as $index => $file) {
    //                 if ($file && $file->isValid()) {
    //                     // Vérifier si un nom a été fourni pour ce fichier
    //                     $displayName = isset($fileNames[$index]) && !empty($fileNames[$index]) 
    //                         ? $fileNames[$index] 
    //                         : $file->getClientOriginalName();
                        
    //                     // Générer un nom de fichier unique
    //                     $fileName = time() . '_' . $file->getClientOriginalName();
                        
    //                     // Stocker le fichier
    //                     $filePath = $file->storeAs('projet_travailler_details', $fileName, 'public');
                        
    //                     // Récupérer la description si elle existe
    //                     $description = isset($fileDescriptions[$index]) ? $fileDescriptions[$index] : null;
                        
    //                     // Créer l'entrée dans la table des détails
    //                     ProjetTravaillerDetail::create([
    //                         'nom' => $displayName,
    //                         'description' => $description,
    //                         'file' => $filePath,
    //                         'id_projects_travailler' => $project->id
    //                     ]);
                        
    //                     Log::info('Fichier associé au projet créé', [
    //                         'project_id' => $project->id,
    //                         'file_name' => $fileName,
    //                         'display_name' => $displayName
    //                     ]);
    //                 } else {
    //                     Log::warning('Fichier invalide ou manquant à l\'index', ['index' => $index]);
    //                 }
    //             }
                
    //             Log::info(count($files) . ' fichier(s) associé(s) au projet', ['project_id' => $project->id]);
    //         } else {
    //             Log::info('Aucun fichier reçu avec le projet', ['project_id' => $project->id]);
    //         }
            
    //         // Valider la transaction
    //         DB::commit();
            
    //         // Redirection avec message de succès
    //         $successMessage = 'Projet créé avec succès!';
    //         if ($request->hasFile('files')) {
    //             $fileCount = count($request->file('files'));
    //             $successMessage .= " $fileCount fichier(s) ajouté(s).";
    //         }
            
    //         return redirect()
    //             ->route('workflow-validation.tache.insert')
    //             ->with('success', $successMessage);

    //     } catch (\Exception $e) {
    //         // Annuler la transaction en cas d'erreur
    //         DB::rollBack();
            
    //         Log::error('Erreur création projet', [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //             'user_id' => $userId
    //         ]);
            
    //         // En cas d'erreur, retour au formulaire avec erreur
    //         return back()
    //             ->withInput()
    //             ->withErrors(['error' => 'Une erreur est survenue: ' . $e->getMessage()]);
    //     }
    // }

    /**
     * Télécharger un fichier de détail
     */
    public function downloadDetail($projectId, $detailId)
    {
        $detail = ProjetTravaillerDetail::where('id_projects_travailler', $projectId)
            ->findOrFail($detailId);
        
        if (!Storage::disk('public')->exists($detail->file)) {
            abort(404, 'Fichier non trouvé');
        }
        
        return Storage::disk('public')->download($detail->file, $detail->nom);
    }


    public function store(Request $request)
    {
        $userId = Session::get('user.id');
        
        // DEBUG
        Log::info('=== DEBUG FICHIERS ===');
        Log::info('All files keys:', array_keys($request->allFiles()));
        Log::info('Request all:', $request->all());
        Log::info('=== FIN DEBUG ===');

        // Validation du projet principal
        $validated = $request->validate([
            'numero_projet' => 'required|string|max:50|unique:projects_travailler',
            'titre' => 'required|string|max:50',
            'description' => 'nullable|string',
            'objectif' => 'nullable|string',
            'date_debu' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debu',
            'id_lancement_projet' => 'required|integer',
        ]);

        $validated['id_utilisateur'] = $userId;

        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }

        try {
            // Démarrer une transaction
            DB::beginTransaction();
            
            // 1. Créer le projet principal
            $project = ProjectTravailler::create($validated);
            
            Log::info('Projet créé avec succès', [
                'project_id' => $project->id,
                'numero_projet' => $project->numero_projet
            ]);
            
            // 2. Gérer les fichiers s'il y en a
            // Vérifier SI DES FICHIERS SONT PRÉSENTS (peu importe le nom du champ)
            $allFiles = $request->allFiles();
            
            if (!empty($allFiles)) {
                Log::info('Fichiers détectés:', ['keys' => array_keys($allFiles)]);
                
                // Prendre le premier tableau de fichiers trouvé
                $filesKey = array_key_first($allFiles);
                $files = $allFiles[$filesKey];
                
                // Si ce n'est pas un tableau, le mettre dans un tableau
                if (!is_array($files)) {
                    $files = [$files];
                }
                
                $fileNames = $request->input('file_names', []);
                $fileDescriptions = $request->input('file_descriptions', []);
                
                Log::info('Traitement des fichiers:', [
                    'count' => count($files),
                    'file_names' => $fileNames,
                    'descriptions' => $fileDescriptions
                ]);
                
                foreach ($files as $index => $file) {
                    if ($file && $file->isValid()) {
                        // Vérifier si un nom a été fourni pour ce fichier
                        $displayName = isset($fileNames[$index]) && !empty($fileNames[$index]) 
                            ? $fileNames[$index] 
                            : $file->getClientOriginalName();
                        
                        // Générer un nom de fichier unique
                        $fileName = time() . '_' . $index . '_' . $file->getClientOriginalName();
                        
                        // Stocker le fichier
                        $filePath = $file->storeAs('projet_travailler_details', $fileName, 'public');
                        
                        // Récupérer la description si elle existe
                        $description = isset($fileDescriptions[$index]) ? $fileDescriptions[$index] : null;
                        
                        // Créer l'entrée dans la table des détails
                        ProjetTravaillerDetail::create([
                            'nom' => $displayName,
                            'description' => $description,
                            'file' => $filePath,
                            'id_projects_travailler' => $project->id
                        ]);
                        
                        Log::info('Fichier associé au projet créé', [
                            'project_id' => $project->id,
                            'file_name' => $fileName,
                            'display_name' => $displayName,
                            'path' => $filePath
                        ]);
                    } else {
                        Log::warning('Fichier invalide ou manquant à l\'index', [
                            'index' => $index,
                            'is_valid' => $file ? $file->isValid() : 'null'
                        ]);
                    }
                }

                //$this->creerPremiereEtapeWorkflow($project , $allFiles);
                
                Log::info(count($files) . ' fichier(s) associé(s) au projet', ['project_id' => $project->id]);
            } else {
                Log::info('Aucun fichier reçu avec le projet', ['project_id' => $project->id]);
            }
            
            // Valider la transaction
            DB::commit();
            
            // Redirection avec message de succès
            $successMessage = 'Projet créé avec succès!';
            if (!empty($allFiles)) {
                $fileCount = count($files);
                $successMessage .= " $fileCount fichier(s) ajouté(s).";
            }
            
            return redirect()
                ->route('workflow-validation.tache.insert')
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            // Annuler la transaction en cas d'erreur
            DB::rollBack();
            
            Log::error('Erreur création projet', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $userId,
                'request_data' => $request->except(['_token', 'files'])
            ]);
            
            // En cas d'erreur, retour au formulaire avec erreur
            return back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue: ' . $e->getMessage()]);
        }
    }


    /**
     * Méthode pour créer la première étape du workflow (donner tache au premier utilisateur)
     */
    // private function creerPremiereEtapeWorkflow(ProjectTravailler $project, array $data)
    // {
    //     try {
    //         // 1. Créer l'étape dans la table etap
            
    //         // 4. Ajouter les utilisateurs concernés et créer leurs validations
    //         foreach ($utilisateursValides as $dolibarrId) {
                
    //             // Créer l'étape de validation pour l'utilisateur
    //             EtapeValidation::create([
    //                 'type_etape' => 'validation',
    //                 'commentaire' => null,
    //                 'date_creation' => now(),
    //                 'status' => 'en attente',
    //                 'etape' => $data['premiere_etape_nom'],
    //                 'id_workflow_validation' => $workflow->id,
    //                 'id_utilisateur' => $dolibarrId, // ID Dolibarr
    //                 'id_projects_travailler' => $project->id,
    //                 'id_etape' => $etape->id
    //             ]);

    //             // Insert aussi son étape etape_validation_detaille
                
    //             Log::info('Validation créée pour utilisateur Dolibarr', [
    //                 'dolibarr_id' => $dolibarrId,
    //                 'workflow_id' => $workflow->id,
    //                 'project_id' => $project->id
    //             ]);
    //         }
            
    //         Log::info('Première étape créée avec succès', [
    //             'project_id' => $project->id,
    //             'utilisateurs_demandes' => count($utilisateursIds),
    //             'utilisateurs_valides' => count($utilisateursValides),
    //             'etape_nom' => $data['premiere_etape_nom']
    //         ]);
            
    //         return $workflow;
            
    //     } catch (\Exception $e) {
    //         Log::error('Erreur création première étape', [
    //             'project_id' => $project->id,
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);
    //         throw $e;
    //     }
    // }



    // private function creerPremiereEtapeWorkflow(ProjectTravailler $project , $data) // array $data
    // {
    //     try {
                
    //             // Créer l'étape de validation pour l'utilisateur
    //             EtapeValidation::create([
    //                 'type_etape' => 'validation',
    //                 'commentaire' => null,
    //                 'date_creation' => now(),
    //                 'status' => 'en attente',
    //                 'etape' => $data['premiere_etape_nom'],
    //                 'id_workflow_validation' => $workflow->id,
    //                 'id_utilisateur' => $utilisateurId,
    //                 'id_projects_travailler' => $project->id,
    //                 'id_etape' => $etape->id
    //             ]);
                
    //             Log::info('Validation créée pour utilisateur', [
    //                 'user_id' => $utilisateurId,
    //                 'workflow_id' => $workflow->id
    //             ]);
    //         }
            
    //         Log::info('Première étape créée avec succès', [
    //             'project_id' => $project->id,
    //             'utilisateurs_count' => count($utilisateursIds),
    //             'etape_nom' => $data['premiere_etape_nom']
    //         ]);
            
    //         return $workflow;
            
    //     } catch (\Exception $e) {
    //         Log::error('Erreur création première étape', [
    //             'project_id' => $project->id,
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);
    //         throw $e;
    //     }
    // }

    

    /**
     * Affiche la liste des projets
     */
    public function index()
    {
        $projects = ProjectTravailler::with('details')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('projet_ravo.liste-projets', compact('projects'));
    }

    /**
     * Affiche un projet spécifique avec ses fichiers
     */
    public function show($id)
    {
        $project = ProjectTravailler::with('details')->findOrFail($id);
        
        return view('projet_ravo.detail-projet', compact('project'));
    }

}