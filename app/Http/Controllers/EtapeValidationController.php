<?php

namespace App\Http\Controllers;

use App\Models\EtapeValidation;
use App\Models\ProjectTravailler;
use App\Models\Etape;
use App\Models\WorkflowValidation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\EtapeValidationDetail;

class EtapeValidationController extends Controller
{


    /**
     * Traiter une validation (valider ou rejeter)
     */
    public function traiter(Request $request, $id)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }

        $validation = EtapeValidation::findOrFail($id);

        // Vérifications
        if ($validation->id_utilisateur != $userId) {
            return back()->with('error', 'Vous n\'êtes pas autorisé.');
        }

        if ($validation->status != 'en attente') {
            return back()->with('info', 'Déjà traitée.');
        }

        $request->validate([
            'action' => 'required|in:valider,rejeter',
            'commentaire' => 'nullable|string|max:500',
            'fichiers.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,txt|max:5120',
        ]);

        try {
            DB::beginTransaction();

            // Déterminer le statut
            $status = ($request->action == 'valider') ? 'validé' : 'rejeté';

            // Mettre à jour
            $validation->update([
                'status' => $status,
                'date_decision' => now(),
                'commentaire' => $request->commentaire
            ]);

            // Gérer les fichiers
            if ($request->hasFile('fichiers')) {
                foreach ($request->file('fichiers') as $file) {
                    if ($file->isValid()) {
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $filePath = $file->storeAs('etape_validation_details', $fileName, 'public');

                        $validation->details()->create([
                            'nom' => $file->getClientOriginalName(),
                            'description' => 'Fichier joint',
                            'file' => $filePath,
                            'id_etapes_validation' => $validation->id
                        ]);
                    }
                }
            }

            DB::commit();

            $message = ($request->action == 'valider') 
                ? 'Étape validée avec succès !' 
                : 'Étape rejetée avec succès.';

            return redirect()->route('validation.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur : ' . $e->getMessage());
        }
    }



    public function getProjetsRejetesPourEtapePrecedente($userId)
    {
        $projets = DB::select("
            SELECT DISTINCT 
                pt.*,
                ev.commentaire as commentaire_rejet,
                ev.date_decision as date_rejet,
                wv_rejet.nom_etape as etape_rejetee,
                ev.id_utilisateur as utilisateur_rejet
            FROM projects_travailler pt
            INNER JOIN workflow_validation wv_rejet ON pt.id = wv_rejet.id_projects_travailler
            INNER JOIN workflow_validation wv_parent ON wv_rejet.id_parent = wv_parent.id
            INNER JOIN utilisateur_concerner_workflow ucw ON wv_parent.id = ucw.id_workflow_validation
            INNER JOIN etapes_validation ev ON wv_rejet.id = ev.id_workflow_validation
            WHERE ucw.id_utilisateur = ?
            AND (ev.status = 'rejeté' OR ev.status LIKE 'rejet%')
            AND ev.date_decision = (
                SELECT MAX(ev2.date_decision)
                FROM etapes_validation ev2
                WHERE ev2.id_workflow_validation = wv_rejet.id
                AND (ev2.status = 'rejeté' OR ev2.status LIKE 'rejet%')
            )
            ORDER BY ev.date_decision DESC
        ", [$userId]);

        // Transformer en objets avec rejet_info
        return collect($projets)->map(function($projet) {
            $projet->rejet_info = [
                'commentaire' => $projet->commentaire_rejet,
                'date_rejet' => $projet->date_rejet,
                'etape_rejetee' => $projet->etape_rejetee,
                'utilisateur_rejet' => $projet->utilisateur_rejet
            ];
            return $projet;
        })->unique('id');
    }


    public function index()
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }

        // Récupérer toutes les validations en attente pour cet utilisateur
        $validationsEnAttente = EtapeValidation::with(['projet', 'workflow'])
            ->where('id_utilisateur', $userId)
            ->where('status', 'en attente')
            ->orderBy('date_creation', 'desc')
            ->paginate(10);

        // Récupérer l'historique des validations traitées
        $validationsTraitees = EtapeValidation::with(['projet', 'workflow'])
            ->where('id_utilisateur', $userId)
            ->where('status', '!=', 'en attente')
            ->orderBy('date_decision', 'desc')
            ->paginate(10);

        // Récupérer les projets où l'utilisateur est en première étape
        $projetsPremiereEtape = $this->getProjetsPremiereEtape($userId);
        
        // Récupérer les projets rejetés aux étapes suivantes (où l'utilisateur était à l'étape précédente)
        $projetsRejetes = $this->getProjetsRejetesPourEtapePrecedente($userId);
        
        return view('validation.index', compact(
            'validationsEnAttente', 
            'validationsTraitees',
            'projetsPremiereEtape',
            'projetsRejetes',
            'userId'
        ));
    }


    // Nouvelle méthode pour récupérer les projets rejetés où l'utilisateur était à l'étape précédente
    private function getProjetsRejetesPourUtilisateurPrecedent($userId)
    {
        try {
            // Récupérer les workflows où cet utilisateur était concerné
            $workflowsUtilisateur = WorkflowValidation::whereHas('utilisateursConcernes', function($query) use ($userId) {
                $query->where('id_utilisateur', $userId);
            })->get();
            
            $projetsRejetes = collect();
            
            foreach ($workflowsUtilisateur as $workflow) {
                // Trouver l'étape suivante de ce workflow
                $etapeSuivante = WorkflowValidation::where('id_projects_travailler', $workflow->id_projects_travailler)
                    ->where('id_parent', $workflow->id)
                    ->first();
                    
                if ($etapeSuivante) {
                    // Vérifier si cette étape suivante a été rejetée
                    $validationsRejetees = EtapeValidation::where('id_workflow_validation', $etapeSuivante->id)
                        ->where('status', 'rejeté')
                        ->exists();
                        
                    if ($validationsRejetees) {
                        // Récupérer les détails du projet
                        $projet = ProjectTravailler::with(['workflows' => function($query) use ($etapeSuivante) {
                            $query->where('id', $etapeSuivante->id);
                        }])
                        ->find($workflow->id_projects_travailler);
                        
                        if ($projet) {
                            // Récupérer le commentaire de rejet le plus récent
                            $rejet = EtapeValidation::where('id_workflow_validation', $etapeSuivante->id)
                                ->where('status', 'rejeté')
                                ->orderBy('date_decision', 'desc')
                                ->first();
                                
                            $projet->rejet_commentaire = $rejet ? $rejet->commentaire : null;
                            $projet->etape_rejetee = $etapeSuivante->nom_etape;
                            $projet->workflow_rejet = $etapeSuivante;
                            
                            $projetsRejetes->push($projet);
                        }
                    }
                }
            }
            
            return $projetsRejetes->unique('id');
            
        } catch (\Exception $e) {
            Log::error('Erreur récupération projets rejetés', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            return collect();
        }
    }





    // Ajoutez cette méthode
    public function getAllEtapes()
    {
        $etapes = Etape::orderBy('nom')->get();
        
        return response()->json([
            'success' => true,
            'etapes' => $etapes
        ]);
    }

    private function getProjetsPremiereEtape($userId)
    {
        try {
            // Version correspondant exactement à votre requête SQL
            $projets = ProjectTravailler::whereHas('workflows', function($query) use ($userId) {
                $query->whereNull('id_parent') // Première étape
                    ->whereHas('utilisateursConcernes', function($q) use ($userId) {
                        $q->where('id_utilisateur', $userId);
                    });
                // NOTE: La condition sur etapesValidation a été retirée comme dans votre SQL
            })
            ->with(['workflows' => function($query) use ($userId) {
                $query->whereNull('id_parent')
                    ->with(['utilisateursConcernes' => function($q) use ($userId) {
                        $q->where('id_utilisateur', $userId);
                    }]);
            }])
            ->orderBy('created_at', 'desc')
            ->get();
            
            Log::info('Projets première étape récupérés', [
                'user_id' => $userId,
                'projets_count' => $projets->count()
            ]);
            
            return $projets;
            
        } catch (\Exception $e) {
            Log::error('Erreur récupération projets première étape', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return collect();
        }
    }

    /**
     * Créer la première étape de validation pour un projet existant
     */
    public function creerPremiereEtape(Request $request, $projectId)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }

        // Validation des données
        $request->validate([
            'type_etape' => 'required|in:validation,revision,approbation,consultation',
            'commentaire_initial' => 'nullable|string|max:500'
        ]);

        try {
            // Récupérer le projet avec ses détails
            $projet = ProjectTravailler::with(['details', 'workflows'])
                ->findOrFail($projectId);

            // Vérifier si l'utilisateur est concerné par le workflow
            $workflow = $projet->getPremiereEtapeWorkflow();
            
            if (!$workflow) {
                return redirect()->route('validation.index')
                    ->with('error', 'Aucun workflow de première étape trouvé pour ce projet.');
            }

            // Vérifier si l'utilisateur est dans les utilisateurs concernés
            $estUtilisateurConcerned = $workflow->utilisateursConcernes()
                ->where('id_utilisateur', $userId)
                ->exists();
                
            if (!$estUtilisateurConcerned) {
                return redirect()->route('validation.index')
                    ->with('error', 'Vous n\'êtes pas concerné par ce projet.');
            }

            // Vérifier si l'étape de validation existe déjà
            $existeDeja = EtapeValidation::where('id_projects_travailler', $projectId)
                ->where('id_utilisateur', $userId)
                ->where('id_workflow_validation', $workflow->id)
                ->exists();
                
            if ($existeDeja) {
                return redirect()->route('validation.index')
                    ->with('info', 'L\'étape de validation existe déjà pour ce projet.');
            }

            DB::beginTransaction();

            // 1. Créer ou récupérer l'étape dans la table etape
            $etape = Etape::firstOrCreate([
                'nom' => $workflow->nom_etape
            ]);

            // 2. Créer l'étape de validation avec le type choisi
            $etapeValidation = EtapeValidation::create([
                'type_etape' => $request->type_etape,
                'commentaire' => $request->commentaire_initial,
                'date_creation' => now(),
                'status' => 'en attente',
                'etape' => $workflow->nom_etape,
                'id_workflow_validation' => $workflow->id,
                'id_utilisateur' => $userId,
                'id_projects_travailler' => $projectId,
                'id_etape' => $etape->id
            ]);

            // 3. Copier les fichiers du projet vers l'étape de validation détaillée
            $fichiersCopies = 0;
            foreach ($projet->details as $detail) {
                EtapeValidationDetail::create([
                    'nom' => $detail->nom,
                    'description' => $detail->description ?? 'Fichier du projet',
                    'file' => $detail->file,
                    'id_etapes_validation' => $etapeValidation->id
                ]);
                $fichiersCopies++;
            }

            DB::commit();

            // Message de succès personnalisé selon le type
            $messagesTypes = [
                'validation' => 'Étape de validation créée',
                'revision' => 'Étape de révision créée',
                'approbation' => 'Étape d\'approbation créée',
                'consultation' => 'Étape de consultation créée'
            ];

            $message = ($messagesTypes[$request->type_etape] ?? 'Étape créée') . ' avec succès !';
            if ($fichiersCopies > 0) {
                $message .= " $fichiersCopies fichier(s) associé(s).";
            }

            return redirect()->route('validation.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur création première étape', [
                'project_id' => $projectId,
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('validation.index')
                ->with('error', 'Erreur lors de la création de l\'étape: ' . $e->getMessage());
        }
    }



    public function showProjet($projectId)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }

        // Récupérer le projet avec ses détails
        $projet = ProjectTravailler::with([
            'details',
            'workflows' => function($query) use ($userId) {
                $query->whereNull('id_parent')
                    ->whereHas('utilisateursConcernes', function($q) use ($userId) {
                        $q->where('id_utilisateur', $userId);
                    });
            }
        ])->findOrFail($projectId);

        // Vérifier que l'utilisateur est concerné par ce projet en première étape
        $isFirstStepUser = $projet->workflows->contains(function($workflow) use ($userId) {
            return $workflow->utilisateursConcernes->contains('id_utilisateur', $userId);
        });

        if (!$isFirstStepUser) {
            return redirect()->route('validation.index')
                ->with('error', 'Vous n\'êtes pas autorisé à voir ce projet.');
        }

        // Récupérer l'étape de validation en attente pour cet utilisateur
        $validationEnAttente = EtapeValidation::where('id_projects_travailler', $projectId)
            ->where('id_utilisateur', $userId)
            ->where('status', 'en attente')
            ->first();

        return view('validation.show-projet', compact('projet', 'validationEnAttente'));
    }

    /**
     * Affiche le formulaire de validation d'une étape
     */
    public function show($id)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }

        // Récupérer l'étape de validation
        $validation = EtapeValidation::with([
            'projet', 
            'etapeDefinition', 
            'details',
            'workflow.utilisateursConcernes'
        ])->findOrFail($id);

        // Vérifier que l'utilisateur est bien concerné
        if ($validation->id_utilisateur != $userId) {
            return redirect()->route('validation.index')
                ->with('error', 'Vous n\'êtes pas autorisé à valider cette étape.');
        }

        // Vérifier que l'étape est en attente
        if ($validation->status != 'en attente') {
            return redirect()->route('validation.index')
                ->with('info', 'Cette étape a déjà été traitée.');
        }

        // Récupérer l'étape suivante si elle existe
        $etapeSuivante = null;
        if ($validation->workflow) {
            $etapeSuivante = WorkflowValidation::where('id_projects_travailler', $validation->id_projects_travailler)
                ->where('id_parent', $validation->id_workflow_validation)
                ->first();
        }

        return view('validation.show', compact('validation', 'etapeSuivante'));
    }


    // Dans EtapeValidationController
    public function showProjetPourValidation($validationId)
    {
        $userId = Session::get('user.id');
        
        $validation = EtapeValidation::with(['projet.details', 'workflow'])
            ->findOrFail($validationId);
        
        // Vérifier que l'utilisateur est concerné
        if ($validation->id_utilisateur != $userId) {
            abort(403, 'Accès non autorisé');
        }
        
        $projet = $validation->projet;
        
        return view('validation.projet_detail', compact('projet', 'validation'));
    }

    /**
     * Valider une étape
     */
    public function valider(Request $request, $id)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }

        $validation = EtapeValidation::findOrFail($id);

        // Vérifier que l'utilisateur est bien concerné
        if ($validation->id_utilisateur != $userId) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à valider cette étape.');
        }

        // Vérifier que l'étape est en attente
        if ($validation->status != 'en attente') {
            return back()->with('info', 'Cette étape a déjà été traitée.');
        }

        // Validation des données
        $request->validate([
            'commentaire' => 'nullable|string|max:500',
            'fichiers.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,txt|max:5120',
        ]);

        try {
            DB::beginTransaction();

            // 1. Mettre à jour l'étape de validation
            $validation->update([
                'status' => 'validé',
                'date_decision' => now(),
                'commentaire' => $request->commentaire
            ]);

            // 2. Gérer les fichiers uploadés
            if ($request->hasFile('fichiers')) {
                foreach ($request->file('fichiers') as $file) {
                    if ($file->isValid()) {
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $filePath = $file->storeAs('etape_validation_details', $fileName, 'public');

                        $validation->details()->create([
                            'nom' => $file->getClientOriginalName(),
                            'description' => 'Fichier joint lors de la validation',
                            'file' => $filePath
                        ]);
                    }
                }
            }

            // 3. Vérifier si c'est la dernière étape du workflow
            $workflow = $validation->workflow;
            if ($workflow) {
                // Vérifier si tous les utilisateurs ont validé cette étape
                $tousValides = true;
                $utilisateursConcernes = $workflow->utilisateursConcernes;
                
                foreach ($utilisateursConcernes as $utilisateur) {
                    $etapeUtilisateur = EtapeValidation::where('id_workflow_validation', $workflow->id)
                        ->where('id_utilisateur', $utilisateur->id_utilisateur)
                        ->first();
                    
                    if (!$etapeUtilisateur || $etapeUtilisateur->status != 'validé') {
                        $tousValides = false;
                        break;
                    }
                }

                // Si tous ont validé, on peut passer à l'étape suivante
                if ($tousValides) {
                    // Marquer l'étape du workflow comme complétée
                    $workflow->update(['status' => 1]); // 1 = validé

                    Log::info('Étape de workflow complétée', [
                        'workflow_id' => $workflow->id,
                        'project_id' => $workflow->id_projects_travailler,
                        'etape' => $workflow->nom_etape
                    ]);

                    // Vérifier s'il y a une étape suivante
                    $etapeSuivante = WorkflowValidation::where('id_projects_travailler', $workflow->id_projects_travailler)
                        ->where('id_parent', $workflow->id)
                        ->first();

                    if ($etapeSuivante) {
                        // Créer les étapes de validation pour l'étape suivante
                        $this->creerValidationsPourEtape($etapeSuivante);
                        
                        Log::info('Étape suivante créée', [
                            'etape_suivante_id' => $etapeSuivante->id,
                            'project_id' => $etapeSuivante->id_projects_travailler
                        ]);
                    } else {
                        // C'était la dernière étape, le projet est terminé
                        Log::info('Projet terminé - Dernière étape validée', [
                            'project_id' => $workflow->id_projects_travailler
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('validation.index')
                ->with('success', 'Étape validée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur validation étape', [
                'validation_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->withInput()
                ->with('error', 'Erreur lors de la validation : ' . $e->getMessage());
        }
    }

    /**
     * Rejeter une étape
     */
    // public function rejeter(Request $request, $id)
    // {
    //     $userId = Session::get('user.id');
        
    //     if (!$userId) {
    //         return redirect('/login')->with('error', 'Veuillez vous connecter.');
    //     }

    //     $validation = EtapeValidation::findOrFail($id);

    //     // Vérifier que l'utilisateur est bien concerné
    //     if ($validation->id_utilisateur != $userId) {
    //         return back()->with('error', 'Vous n\'êtes pas autorisé à rejeter cette étape.');
    //     }

    //     // Vérifier que l'étape est en attente
    //     if ($validation->status != 'en attente') {
    //         return back()->with('info', 'Cette étape a déjà été traitée.');
    //     }

    //     // Validation des données
    //     $request->validate([
    //         'commentaire' => 'required|string|max:500',
    //         'fichiers.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,txt|max:5120',
    //     ]);

    //     try {
    //         DB::beginTransaction();

    //         // 1. Mettre à jour l'étape de validation
    //         $validation->update([
    //             'status' => 'rejeté',
    //             'date_decision' => now(),
    //             'commentaire' => $request->commentaire
    //         ]);

    //         // 2. Gérer les fichiers uploadés
    //         if ($request->hasFile('fichiers')) {
    //             foreach ($request->file('fichiers') as $file) {
    //                 if ($file->isValid()) {
    //                     $fileName = time() . '_' . $file->getClientOriginalName();
    //                     $filePath = $file->storeAs('etape_validation_details', $fileName, 'public');

    //                     $validation->details()->create([
    //                         'nom' => $file->getClientOriginalName(),
    //                         'description' => 'Fichier joint lors du rejet',
    //                         'file' => $filePath
    //                     ]);
    //                 }
    //             }
    //         }

    //         // 3. Marquer l'étape du workflow comme rejetée
    //         $workflow = $validation->workflow;
    //         if ($workflow) {
    //             $workflow->update(['status' => 2]); // 2 = rejeté
                
    //             // Optionnel : Notifier tous les participants
    //             Log::info('Étape de workflow rejetée', [
    //                 'workflow_id' => $workflow->id,
    //                 'project_id' => $workflow->id_projects_travailler,
    //                 'user_id' => $userId
    //             ]);
    //         }

    //         DB::commit();

    //         return redirect()->route('validation.index')
    //             ->with('success', 'Étape rejetée avec succès.');

    //     } catch (\Exception $e) {
    //         DB::rollBack();
            
    //         Log::error('Erreur rejet étape', [
    //             'validation_id' => $id,
    //             'error' => $e->getMessage()
    //         ]);

    //         return back()->withInput()
    //             ->with('error', 'Erreur lors du rejet : ' . $e->getMessage());
    //     }
    // }


    public function rejeter(Request $request, $id)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }

        $validation = EtapeValidation::findOrFail($id);

        // Vérifier que l'utilisateur est bien concerné
        if ($validation->id_utilisateur != $userId) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à rejeter cette étape.');
        }

        // Vérifier que l'étape est en attente
        if ($validation->status != 'en attente') {
            return back()->with('info', 'Cette étape a déjà été traitée.');
        }

        // Validation des données
        $request->validate([
            'commentaire' => 'required|string|max:500',
            'fichiers.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,txt|max:5120',
        ]);

        try {
            DB::beginTransaction();

            // 1. Mettre à jour l'étape de validation
            $validation->update([
                'status' => 'rejeté',
                'date_decision' => now(),
                'commentaire' => $request->commentaire
            ]);

            // 2. Gérer les fichiers uploadés
            if ($request->hasFile('fichiers')) {
                foreach ($request->file('fichiers') as $file) {
                    if ($file->isValid()) {
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $filePath = $file->storeAs('etape_validation_details', $fileName, 'public');

                        $validation->details()->create([
                            'nom' => $file->getClientOriginalName(),
                            'description' => 'Fichier joint lors du rejet',
                            'file' => $filePath
                        ]);
                    }
                }
            }

            // 3. Marquer l'étape du workflow comme rejetée
            $workflow = $validation->workflow;
            if ($workflow) {
                $workflow->update(['status' => 2]); // 2 = rejeté
                
                // 4. Trouver l'étape précédente pour notifier ses utilisateurs
                $etapePrecedente = WorkflowValidation::where('id_projects_travailler', $workflow->id_projects_travailler)
                    ->where('id', $workflow->id_parent)
                    ->first();
                    
                if ($etapePrecedente) {
                    // Log pour suivre qui doit être notifié
                    Log::info('Projet rejeté - notification étape précédente', [
                        'workflow_id_rejet' => $workflow->id,
                        'etape_precedente_id' => $etapePrecedente->id,
                        'project_id' => $workflow->id_projects_travailler,
                        'user_rejet' => $userId,
                        'commentaire' => $request->commentaire
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('validation.index')
                ->with('success', 'Étape rejetée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur rejet étape', [
                'validation_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->withInput()
                ->with('error', 'Erreur lors du rejet : ' . $e->getMessage());
        }
    }



    /**
     * Récupérer les détails d'un projet rejeté avec le commentaire
     */
    public function showProjetRejete($projectId)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }

        // Récupérer le projet
        $projet = ProjectTravailler::with([
            'details',
            'etapesValidations' => function($query) {
                $query->where('status', 'rejeté')
                    ->orderBy('date_decision', 'desc');
            }
        ])->findOrFail($projectId);

        // Vérifier que l'utilisateur était concerné à une étape précédente
        $estUtilisateurPrecedent = $this->verifierUtilisateurEtapePrecedente($projet, $userId);
        
        if (!$estUtilisateurPrecedent) {
            return redirect()->route('validation.index')
                ->with('error', 'Vous n\'êtes pas concerné par ce projet rejeté.');
        }

        // Récupérer le dernier rejet
        $dernierRejet = $projet->etapesValidations->first();

        return view('validation.projet-rejete', compact('projet', 'dernierRejet'));
    }

    /**
     * Vérifier si l'utilisateur était concerné à l'étape précédente du rejet
     */
    private function verifierUtilisateurEtapePrecedente($projet, $userId)
    {
        // Trouver toutes les étapes rejetées de ce projet
        $workflowsRejetes = WorkflowValidation::where('id_projects_travailler', $projet->id)
            ->whereHas('etapesValidation', function($query) {
                $query->where('status', 'rejeté');
            })
            ->get();
        
        foreach ($workflowsRejetes as $workflowRejete) {
            // Trouver l'étape précédente
            $etapePrecedente = WorkflowValidation::where('id_projects_travailler', $projet->id)
                ->where('id', $workflowRejete->id_parent)
                ->first();
                
            if ($etapePrecedente) {
                // Vérifier si l'utilisateur était concerné à cette étape
                $estConcerned = $etapePrecedente->utilisateursConcernes()
                    ->where('id_utilisateur', $userId)
                    ->exists();
                    
                if ($estConcerned) {
                    return true;
                }
            }
        }
        
        return false;
    }



    /**
     * Méthode pour créer les validations d'étape (à appeler lors de la création d'un workflow)
     */
    public static function creerValidationsPourEtape(WorkflowValidation $workflow)
    {
        $etape = Etape::firstOrCreate(['nom' => $workflow->nom_etape]);

        // Pour chaque utilisateur concerné par le workflow
        foreach ($workflow->utilisateursConcernes as $utilisateurConcerned) {
            EtapeValidation::create([
                'type_etape' => 'validation',
                'commentaire' => null,
                'date_creation' => now(),
                'status' => 'en attente',
                'etape' => $workflow->nom_etape,
                'id_workflow_validation' => $workflow->id,
                'id_utilisateur' => $utilisateurConcerned->id_utilisateur,
                'id_projects_travailler' => $workflow->id_projects_travailler,
                'id_etape' => $etape->id
            ]);
        }

        Log::info('Validations créées pour l\'étape', [
            'workflow_id' => $workflow->id,
            'etape_nom' => $workflow->nom_etape,
            'users_count' => $workflow->utilisateursConcernes->count()
        ]);
    }

    /**
     * Afficher l'historique complet d'un projet
     */
    public function historiqueProjet($projectId)
    {
        $validations = EtapeValidation::with(['utilisateur', 'etapeDefinition', 'details'])
            ->where('id_projects_travailler', $projectId)
            ->orderBy('date_creation', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $projet = ProjectTravailler::findOrFail($projectId);

        return view('validation.historique', compact('validations', 'projet'));
    }

    /**
     * Télécharger un fichier joint
     */
    public function downloadFile($validationId, $fileId)
    {
        $validation = EtapeValidation::findOrFail($validationId);
        $detail = $validation->details()->findOrFail($fileId);

        if (!$detail->file || !Storage::disk('public')->exists($detail->file)) {
            return back()->with('error', 'Fichier non trouvé.');
        }

        return Storage::disk('public')->download($detail->file, $detail->nom);
    }
}