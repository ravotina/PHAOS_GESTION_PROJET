<?php

namespace App\Http\Controllers;

use App\Models\WorkflowValidation;
use App\Models\ProjectTravailler;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UtilisateurConcernerWorkflow;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\EtapeValidationController;


class WorkflowValidationController extends Controller
{
    /**
     * Affiche le formulaire de création
     */

    private $users;

    public function __construct()
    {
        $this->users = new User();
    }

    public function create()
    {
        $projects = ProjectTravailler::orderBy('created_at', 'desc')->get();

        $utilisateurs =   $utilisateurs = $this->users->getAllUsers();
        
        return view('valideProject.formulaire-workflow-validation', compact('projects' , 'utilisateurs'));
    }


    /**
     * Récupère les étapes d'un projet pour le formulaire (AJAX)
     */
    public function getProjectSteps($projectId)
    {
        try {
            // Vérifier si le projet existe
            $project = ProjectTravailler::find($projectId);
            
            if (!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'Projet non trouvé',
                    'project' => null,
                    'steps' => [],
                    'is_first_step' => true,
                    'step_count' => 0
                ], 404);
            }
            
            // Récupérer toutes les étapes de ce projet
            $steps = WorkflowValidation::where('id_projects_travailler', $projectId)
                ->orderBy('created_at', 'asc') // Par ordre chronologique
                ->get(['id', 'nom_etape', 'date_arriver', 'status', 'created_at']);
            
            $isFirstStep = $steps->isEmpty();
            
            return response()->json([
                'success' => true,
                'message' => 'Étapes récupérées avec succès',
                'project' => [
                    'id' => $project->id,
                    'numero_projet' => $project->numero_projet,
                    'titre' => $project->titre,
                    'description' => $project->description
                ],
                'steps' => $steps,
                'is_first_step' => $isFirstStep,
                'step_count' => $steps->count()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage(),
                'project' => null,
                'steps' => [],
                'is_first_step' => true,
                'step_count' => 0
            ], 500);
        }
    }
    
    /**
     * Enregistre une nouvelle étape
     */
    public function store(Request $request)
    {
        // Validation de base
        
        $validatedData = $request->validate([
            'id_projects_travailler' => 'required|exists:projects_travailler,id',
            'nom_etape' => 'required|string|max:50',
            'date_arriver' => 'required|date',
            'date_fin_de_validation' => 'nullable|date|after_or_equal:date_arriver',
            'commentaires' => 'nullable|string',
            'status' => 'required|integer|in:0,1,2',
            'id_parent' => 'nullable|exists:workflow_validation,id',
            'utilisateurs' => 'nullable|string' // Champ caché JSON avec commentaires
        ]);
        
        try {
            // Vérifier si c'est la première étape pour ce projet
            $existingStepsCount = WorkflowValidation::where('id_projects_travailler', $validatedData['id_projects_travailler'])
                ->count();
            
            // Logique pour id_parent
            if ($existingStepsCount === 0) {
                // Première étape → id_parent doit être null
                $validatedData['id_parent'] = null;
            } else {
                // Ce n'est pas la première étape → id_parent est obligatoire
                if (empty($validatedData['id_parent'])) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['id_parent' => 'Veuillez sélectionner une étape parente pour ce projet.']);
                }
                
                // Vérifier que l'étape parente appartient au même projet
                $parentStep = WorkflowValidation::find($validatedData['id_parent']);
                if (!$parentStep || $parentStep->id_projects_travailler != $validatedData['id_projects_travailler']) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['id_parent' => 'L\'étape parente sélectionnée n\'appartient pas à ce projet.']);
                }
            }
            
            // Démarrer une transaction pour assurer l'intégrité des données
            \DB::beginTransaction();
            
            // 1. Créer l'étape de workflow
            $workflow = WorkflowValidation::create($validatedData);
            
            // 2. Gérer les utilisateurs concernés AVEC COMMENTAIRES
            $utilisateursAjoutes = 0;
            $utilisateursAvecCommentaires = 0;
            
            if (!empty($validatedData['utilisateurs'])) {
                try {
                    // Décoder le JSON des utilisateurs (maintenant avec commentaires)
                    $utilisateursData = json_decode($validatedData['utilisateurs'], true);
                    
                    \Log::info('Données utilisateurs reçues:', ['data' => $utilisateursData]);
                    
                    if (is_array($utilisateursData) && count($utilisateursData) > 0) {
                        foreach ($utilisateursData as $utilisateurData) {
                            // Vérifier la structure des données
                            if (!isset($utilisateurData['id'])) {
                                \Log::warning('Données utilisateur incomplètes:', $utilisateurData);
                                continue;
                            }
                            
                            // Valider que l'ID est bien un nombre
                            $utilisateurId = intval($utilisateurData['id']);
                            
                            if ($utilisateurId > 0) {
                                // Récupérer le commentaire (peut être vide ou absent)
                                $commentaire = isset($utilisateurData['commentaire']) 
                                    ? trim($utilisateurData['commentaire']) 
                                    : null;
                                
                                // Créer l'entrée dans utilisateur_concerner_workflow avec commentaire
                                UtilisateurConcernerWorkflow::create([
                                    'id_utilisateur' => $utilisateurId,
                                    'id_workflow_validation' => $workflow->id,
                                    'commentaires' => $commentaire, // Sauvegarde du commentaire spécifique
                                    'status_validation' => 0, // En attente par défaut
                                    'date_validation' => null
                                ]);
                                
                                $utilisateursAjoutes++;
                                
                                // Compter les utilisateurs avec commentaires
                                if (!empty($commentaire)) {
                                    $utilisateursAvecCommentaires++;
                                }
                                
                                \Log::info('Utilisateur ajouté à l\'étape:', [
                                    'user_id' => $utilisateurId,
                                    'workflow_id' => $workflow->id,
                                    'has_comment' => !empty($commentaire)
                                ]);
                            }
                        }
                    } else {
                        \Log::warning('Tableau utilisateurs vide ou invalide:', ['data' => $utilisateursData]);
                    }
                } catch (\Exception $e) {
                    // En cas d'erreur avec le JSON, on continue sans les utilisateurs
                    \Log::error('Erreur décodage JSON utilisateurs: ' . $e->getMessage());
                    \Log::error('Données utilisateurs brutes:', ['utilisateurs' => $validatedData['utilisateurs']]);
                }
            }

            // Créer les étapes de validation pour chaque utilisateur
            EtapeValidationController::creerValidationsPourEtape($workflow);
            
            // Valider la transaction
            \DB::commit();
            
            // Message de succès personnalisé
            $message = ($existingStepsCount === 0) 
                ? 'Première étape créée avec succès !' 
                : 'Nouvelle étape ajoutée avec succès !';
            
            if ($utilisateursAjoutes > 0) {
                $message .= " $utilisateursAjoutes utilisateur(s) associé(s) à cette étape.";
                
                if ($utilisateursAvecCommentaires > 0) {
                    $message .= " $utilisateursAvecCommentaires avec commentaire(s) spécifique(s).";
                }
            }
            
            \Log::info('Étape de workflow créée avec succès:', [
                'workflow_id' => $workflow->id,
                'project_id' => $workflow->id_projects_travailler,
                'users_added' => $utilisateursAjoutes,
                'users_with_comments' => $utilisateursAvecCommentaires
            ]);
            
            return redirect()->route('workflow-validation.form')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            // Annuler la transaction en cas d'erreur
            \DB::rollBack();
            
            // Journaliser l'erreur
            \Log::error('Erreur création workflow: ' . $e->getMessage());
            \Log::error('Données reçues: ', $request->all());
            \Log::error('Trace: ', $e->getTrace());
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Erreur lors de la création : ' . $e->getMessage()]);
        }
    }

    public function organigramme()
    {
        // Récupérer tous les projets pour le select
        $projects = ProjectTravailler::orderBy('titre')->get();
        
        $projectId = request('project_id');
        $workflowHtml = '';
        
        if ($projectId) {
            // Récupérer toutes les étapes du projet avec eager loading
            $etapes = WorkflowValidation::with('utilisateursConcernes')
                ->where('id_projects_travailler', $projectId)
                ->orderBy('date_arriver')
                ->get();
            
            if ($etapes->count() > 0) {
                // Construire la structure hiérarchique
                $workflowData = $this->buildWorkflowTree($etapes);
                
                // Générer le HTML pour chaque étape racine
                foreach ($workflowData as $etape) {
                    $workflowHtml .= $this->renderEtape($etape, 0);
                }
            }
        }
        
        return view('valideProject.organigramme', compact('projects', 'workflowHtml', 'projectId'));
    }

    private function buildWorkflowTree($etapes)
    {
        $tree = [];
        $etapesById = [];
        
        // Convertir les étapes en tableaux
        foreach ($etapes as $etape) {
            $etapeArray = [
                'id' => $etape->id,
                'nom_etape' => $etape->nom_etape,
                'date_arriver' => $etape->date_arriver,
                'date_fin_de_validation' => $etape->date_fin_de_validation,
                'commentaires' => $etape->commentaires,
                'status' => $etape->status,
                'id_parent' => $etape->id_parent,
                'id_projects_travailler' => $etape->id_projects_travailler,
                'enfants' => [],
                'utilisateursConcernes' => $etape->utilisateursConcernes
            ];
            
            $etapesById[$etape->id] = $etapeArray;
        }
        
        // Construire l'arbre hiérarchique
        foreach ($etapesById as $etapeId => &$etape) {
            if ($etape['id_parent'] && isset($etapesById[$etape['id_parent']])) {
                $etapesById[$etape['id_parent']]['enfants'][] = &$etape;
            } else {
                $tree[] = &$etape;
            }
        }
        
        unset($etape); // Déréférencer
        
        return $tree;
    }

    public function etapeDetails($id)
    {
        try {
            // Récupérer l'étape avec ses relations
            $etape = WorkflowValidation::find($id);
            
            if (!$etape) {
                return response()->json([
                    'success' => false,
                    'message' => 'Étape non trouvée'
                ], 404);
            }
            
            // Récupérer l'étape parente si elle existe
            $parent = null;
            if ($etape->id_parent) {
                $parent = WorkflowValidation::select('id', 'nom_etape')
                    ->find($etape->id_parent);
            }
            
            // Récupérer les utilisateurs concernés
            $utilisateurs = UtilisateurConcernerWorkflow::where('id_workflow_validation', $id)
                ->select('id_utilisateur', 'commentaires', 'status_validation', 'date_validation')
                ->get();
            
            return response()->json([
                'success' => true,
                'etape' => [
                    'id' => $etape->id,
                    'nom_etape' => $etape->nom_etape,
                    'date_arriver' => $etape->date_arriver,
                    'date_fin_de_validation' => $etape->date_fin_de_validation,
                    'commentaires' => $etape->commentaires,
                    'status' => $etape->status,
                    'parent' => $parent ? [
                        'id' => $parent->id,
                        'nom_etape' => $parent->nom_etape
                    ] : null,
                    'utilisateurs' => $utilisateurs->map(function($user) {
                        return [
                            'id_utilisateur' => $user->id_utilisateur,
                            'commentaires' => $user->commentaires,
                            'status_validation' => $user->status_validation,
                            'date_validation' => $user->date_validation
                        ];
                    })
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Erreur etapeDetails: ' . $e->getMessage());
            \Log::error('Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Méthode pour récupérer les noms d'utilisateurs depuis votre service
     */
    private function getUserNamesFromService()
    {
        static $userNamesCache = null;
        
        if ($userNamesCache === null) {
            $userNamesCache = [];
            
            try {
                // Utiliser votre service existant pour récupérer les utilisateurs
                $usersData = $this->users->getAllUsers();
                
                if (isset($usersData['formatted']['users'])) {
                    foreach ($usersData['formatted']['users'] as $user) {
                        // Construire le nom complet
                        $firstName = $user['firstname'] ?? '';
                        $lastName = $user['lastname'] ?? '';
                        $fullName = trim($firstName . ' ' . $lastName);
                        
                        // Utiliser le nom complet ou le login comme fallback
                        $displayName = !empty($fullName) ? $fullName : ($user['login'] ?? '');
                        
                        if (!empty($displayName)) {
                            $userNamesCache[$user['id']] = $displayName;
                        }
                    }
                }
            } catch (\Exception $e) {
                // En cas d'erreur, retourner un tableau vide
                \Log::error('Erreur récupération noms utilisateurs: ' . $e->getMessage());
            }
        }
        
        return $userNamesCache;
    }

    private function renderEtape($etape, $level = 0)
    {
        $statusTexts = [
            0 => '⏳ En attente',
            1 => '✅ Validé',
            2 => '❌ Rejeté'
        ];
        
        $statusText = $statusTexts[$etape['status']] ?? 'Inconnu';
        
        // Formater les dates
        $dateDebut = \Carbon\Carbon::parse($etape['date_arriver'])->format('d/m/Y H:i');
        $dateFin = $etape['date_fin_de_validation'] 
            ? \Carbon\Carbon::parse($etape['date_fin_de_validation'])->format('d/m/Y H:i')
            : 'Non définie';
        
        // Construire le HTML
        $html = '<div class="etape-wrapper" style="position: relative;">';
        
        // Ligne de connexion
        if ($level > 0) {
            $html .= '<div class="connection-line" style="height: 20px; top: -20px;"></div>';
        }
        
        // Carte de l'étape
        $html .= '<div class="etape-card ' . ($level === 0 ? 'root' : '') . '" onclick="showEtapeDetails(' . $etape['id'] . ')">';
        
        // En-tête
        $html .= '<div class="etape-header">';
        $html .= '<h6 class="etape-title">' . e($etape['nom_etape']) . '</h6>';
        $html .= '<span class="etape-status status-' . $etape['status'] . '">' . $statusText . '</span>';
        $html .= '</div>';
        
        // Dates
        $html .= '<div class="etape-dates">';
        $html .= '<div><small><strong>Début:</strong> ' . $dateDebut . '</small></div>';
        $html .= '<div><small><strong>Fin:</strong> ' . $dateFin . '</small></div>';
        $html .= '</div>';
        
        // Commentaire court
        if ($etape['commentaires']) {
            $commentaireCourt = $etape['commentaires'];
            $html .= '<div class="etape-commentaire mb-2">';
            $html .= '<small class="text-muted">' . e($commentaireCourt) . '</small>';
            $html .= '</div>';
        }
        
        // Utilisateurs concernés - CORRECTION : utiliser 'utilisateursConcernes' au lieu de 'utilisateurs'
        if (isset($etape['utilisateursConcernes']) && $etape['utilisateursConcernes']->count() > 0) {
            $html .= '<div class="etape-users">';
            $html .= '<small><strong>Utilisateurs:</strong></small> ';

            $userNames = $this->getUserNamesFromService();
        
            foreach ($etape['utilisateursConcernes'] as $user) {
                // Récupérer le nom depuis votre service
                $userName = $userNames[$user->id_utilisateur] ?? 'Utilisateur #' . $user->id_utilisateur;
                
                // Statut de validation
                $userStatus = $statusTexts[$user->status_validation] ?? 'Inconnu';
                $statusClass = $user->status_validation == 1 ? 'text-success' : 
                            ($user->status_validation == 2 ? 'text-danger' : 'text-warning');
                
                $html .= '<div class="d-inline-block me-2 mb-1">';
                $html .= '<span class="badge bg-light text-dark border">';
                $html .= '<i class="bi bi-person me-1"></i>';
                $html .= e($userName);
                
                // Afficher le commentaire si présent

                
                \Log::error('commentaire asa user : ' . $user->commentaires);

                $commentaire = $user->commentaires;
                // Commentaire en dessous (si existe)
                if (!empty($commentaire)) {
                    $html .= '<div class="mt-2 p-2 bg-light rounded">';
                    $html .= '<small>';
                    $html .= '<i class="bi bi-chat-left-text me-1 text-muted"></i>';
                    $html .= '<strong>Commentaire :</strong> ' . e($commentaire);
                    $html .= '</small>';
                    $html .= '</div>';
                }
                
                $html .= ' <span class="ms-1 ' . $statusClass . '">(' . $userStatus . ')</span>';
                $html .= '</span>';
                $html .= '</div>';
            }

            $html .= '</div>';
        }
        
        // Actions
        $html .= '<div class="etape-actions">';
        $html .= '<button class="btn btn-sm btn-outline-primary" onclick="event.stopPropagation(); showEtapeDetails(' . $etape['id'] . ')">';
        $html .= '<i class="fas fa-info-circle me-1"></i> Détails';
        $html .= '</button>';
        $html .= '</div>';
        
        $html .= '</div>'; // Fin etape-card
        
        // Afficher les étapes enfants
        if (!empty($etape['enfants'])) {
            $html .= '<div class="etape-enfants">';
            foreach ($etape['enfants'] as $enfant) {
                $html .= $this->renderEtape($enfant, $level + 1);
            }
            $html .= '</div>';
        }
        
        $html .= '</div>'; // Fin etape-wrapper
        
        return $html;
    }
    
    /**
     * Liste des workflows
     */
    public function index()
    {
        $workflows = WorkflowValidation::with(['project', 'parent'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('valideProject.formulaire-workflow-validation', compact('workflows'));
    }
}