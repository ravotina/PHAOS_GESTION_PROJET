<?php

namespace App\Http\Controllers;

use App\Models\Preparation;
use App\Models\DetailleAFaire;
use App\Models\UtilisateurConcerner;
use App\Models\AFaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PreparationController extends Controller
{
    /**
     * Afficher la liste des préparations
     */
    public function index()
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }
        
        $preparations = Preparation::with(['utilisateurConcerner', 'aFaire', 'details'])
            ->where('id_utilisateur', $userId)
            ->orderBy('daty', 'desc')
            ->orderBy('id', 'desc')
            ->get();
        
        return view('preparation.index', compact('preparations'));
    }

    /**
     * Afficher le formulaire de création
     */
    // public function create($notificationId = null)
    // {
    //     $userId = Session::get('user.id');
        
    //     if (!$userId) {
    //         return redirect('/login')->with('error', 'Veuillez vous connecter.');
    //     }
        
    //     // Récupérer les tâches à faire
    //     $aFaireList = AFaire::orderBy('nom')->get();
    

    //     $notification = Notification::where('id', $notificationId)
    //         ->where('id_utilisateur', $userId)
    //         ->first();
        
    //     return view('preparation.create', compact('aFaireList','notification'));
    // }

    public function create(Request $request)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }
        
        // Récupérer les tâches à faire
        $aFaireList = AFaire::orderBy('nom')->get();
        
        // Récupérer la notification depuis le paramètre GET
        $notificationId = $request->query('notification_id');
        $tacheConcernerId = $request->query('tache_concerner_id');
        $notification = null;

        return view('preparation.create', compact('aFaireList', 'tacheConcernerId'));
    }

    public function store(Request $request)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non connecté'
            ], 401);
        }
        
        // ⭐⭐ DEBUG : Afficher les données reçues ⭐⭐
        \Log::info('Données reçues pour création préparation:', [
            'user_id' => $userId,
            'request_data' => $request->all(),
            'headers' => $request->headers->all()
        ]);
        
        // $validator = Validator::make($request->all(), Preparation::$rules, Preparation::$messages);
        
        // if ($validator->fails()) {
        //     \Log::error('Erreurs de validation:', ['errors' => $validator->errors()->toArray()]);
        //     return response()->json([
        //         'success' => false,
        //         'errors' => $validator->errors(),
        //         'message' => 'Erreurs de validation'
        //     ], 422);
        // }
        
        try {
            // Récupérer id_utilisateur_concerner depuis le formulaire
            $idUtilisateurConcerner = $request->input('id_utilisateur_concerner');
            
            \Log::info('ID utilisateur concerné:', ['id' => $idUtilisateurConcerner]);
            
            // Vérifier que l'utilisateur concerné appartient bien à l'utilisateur
            if ($idUtilisateurConcerner) {
                $utilisateurConcerner = UtilisateurConcerner::where('id', $idUtilisateurConcerner)
                    ->where('id_utilsateur', $userId)
                    ->first();
                
                if (!$utilisateurConcerner) {
                    \Log::warning('Utilisateur concerné non trouvé:', [
                        'id' => $idUtilisateurConcerner,
                        'user_id' => $userId
                    ]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Tâche concernée non trouvée ou accès non autorisé'
                    ], 403);
                }
                
                \Log::info('Utilisateur concerné trouvé:', [
                    'id' => $utilisateurConcerner->id,
                    'description' => $utilisateurConcerner->description_tache
                ]);
            } else {
                \Log::warning('ID utilisateur concerné manquant');
                return response()->json([
                    'success' => false,
                    'message' => 'ID utilisateur concerné manquant'
                ], 422);
            }
            
            // Créer la préparation
            $preparation = Preparation::create([
                'description' => $request->description,
                'daty' => $request->daty,
                'id_utilisateur_concerner' => $idUtilisateurConcerner,
                'id_utilisateur' => $userId,
                'id_a_faire' => $request->id_a_faire
            ]);
            
            \Log::info('Préparation créée:', ['id' => $preparation->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Préparation créée avec succès',
                'preparation_id' => $preparation->id
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Erreur création préparation:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $userId,
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher les détails d'une préparation
     */
    public function show($id)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }
        
        $preparation = Preparation::with(['utilisateurConcerner', 'aFaire', 'details'])
            ->where('id', $id)
            ->where('id_utilisateur', $userId)
            ->firstOrFail();
        
        return view('preparation.show', compact('preparation'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit($id)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }
        
        $preparation = Preparation::where('id', $id)
            ->where('id_utilisateur', $userId)
            ->firstOrFail();
        
        $aFaireList = AFaire::orderBy('nom')->get();
        $utilisateursConcerner = UtilisateurConcerner::where('id_utilsateur', $userId)
            ->with('calendrier')
            ->get();
        
        return view('preparation.edit', compact('preparation', 'aFaireList', 'utilisateursConcerner'));
    }


    /**
     * Éditer un détail (retourne les données JSON)
     */
    public function editDetail($id)
    {
        try {
            $userId = Session::get('user.id');
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non connecté'
                ], 401);
            }
            
            // Récupérer le détail avec la préparation associée
            $detail = DetailleAFaire::with('preparation')
                ->where('id', $id)
                ->first();
            
            if (!$detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Détail non trouvé'
                ], 404);
            }
            
            // Vérifier que la préparation appartient à l'utilisateur
            if (!$detail->preparation || $detail->preparation->id_utilisateur != $userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Accès non autorisé'
                ], 403);
            }
            
            return response()->json([
                'success' => true,
                'detail' => [
                    'id' => $detail->id,
                    'nom' => $detail->nom,
                    'description' => $detail->description,
                    'fichier' => $detail->fichier,
                    'url' => $detail->url,
                    'id_preparation' => $detail->id_preparation
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Erreur dans editDetail:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Mettre à jour un détail
     */
    public function updateDetail(Request $request, $id)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non connecté'
            ], 401);
        }
        
        $detail = DetailleAFaire::with('preparation')
            ->where('id', $id)
            ->first();
        
        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Détail non trouvé'
            ], 404);
        }
        
        // Vérifier que la préparation appartient à l'utilisateur
        if (!$detail->preparation || $detail->preparation->id_utilisateur != $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé'
            ], 403);
        }
        
        try {
            $fileName = $detail->fichier; // Conserver le nom actuel par défaut
            
            // Gérer l'upload d'un nouveau fichier
            if ($request->hasFile('fichier_file') && $request->file('fichier_file')->isValid()) {
                $file = $request->file('fichier_file');
                
                // Valider le fichier
                $allowedMimes = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'txt'];
                $maxSize = 10240; // 10MB
                
                if (!in_array($file->getClientOriginalExtension(), $allowedMimes)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Type de fichier non autorisé'
                    ], 422);
                }
                
                if ($file->getSize() > $maxSize * 1024) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Le fichier est trop volumineux (max 10MB)'
                    ], 422);
                }
                
                // Supprimer l'ancien fichier s'il existe
                if ($detail->fichier && preg_match('/^\d+_\w+\.\w+$/', $detail->fichier)) {
                    $oldFilePath = public_path('uploads/detaille_a_faire/' . $detail->fichier);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                
                // Générer un nouveau nom
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '_' . uniqid() . '.' . $extension;
                
                // Créer le dossier d'upload s'il n'existe pas
                $uploadPath = public_path('uploads/detaille_a_faire');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Déplacer le nouveau fichier
                $file->move($uploadPath, $fileName);
            } else if ($request->has('fichier') && $request->fichier) {
                // Utiliser le nom manuel saisi
                $fileName = $request->fichier;
            }
            
            // Mettre à jour le détail
            $detail->update([
                'nom' => $request->nom,
                'description' => $request->description,
                'fichier' => $fileName,
                'url' => $request->url
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Détail modifié avec succès',
                'detail' => $detail
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Erreur modification détail:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour une préparation
     */
    public function update(Request $request, $id)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non connecté'
            ], 401);
        }
        
        $preparation = Preparation::where('id', $id)
            ->where('id_utilisateur', $userId)
            ->firstOrFail();
        
        $validator = Validator::make($request->all(), Preparation::$rules, Preparation::$messages);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $preparation->update([
                'description' => $request->description,
                'daty' => $request->daty,
                'id_utilisateur_concerner' => $request->id_utilisateur_concerner,
                'id_a_faire' => $request->id_a_faire
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Préparation mise à jour avec succès'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer une préparation
     */
    public function destroy($id)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non connecté'
            ], 401);
        }
        
        $preparation = Preparation::where('id', $id)
            ->where('id_utilisateur', $userId)
            ->firstOrFail();
        
        try {
            // Supprimer d'abord les détails
            DetailleAFaire::where('id_preparation', $id)->delete();
            
            // Puis supprimer la préparation
            $preparation->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Préparation supprimée avec succès'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtenir les détails d'une préparation pour AJAX
     */
    public function getDetails($id)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non connecté'
            ], 401);
        }
        
        $preparation = Preparation::with('details')
            ->where('id', $id)
            ->where('id_utilisateur', $userId)
            ->firstOrFail();
        
        return response()->json([
            'success' => true,
            'preparation' => $preparation,
            'details' => $preparation->details
        ]);
    }


    public function addDetail(Request $request)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non connecté'
            ], 401);
        }
        
        // Vérifier que la préparation appartient à l'utilisateur
        $preparation = Preparation::where('id', $request->id_preparation)
            ->where('id_utilisateur', $userId)
            ->first();
        
        if (!$preparation) {
            return response()->json([
                'success' => false,
                'message' => 'Préparation non trouvée ou accès non autorisé'
            ], 403);
        }
        
        // Valider les données
        $validator = Validator::make($request->all(), DetailleAFaire::$rules, DetailleAFaire::$messages);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Erreurs de validation'
            ], 422);
        }
        
        try {
            $fileName = null;
            
            // Gérer l'upload du fichier s'il y en a un
            if ($request->hasFile('fichier_file')) {
                $file = $request->file('fichier_file');
                
                // Valider le fichier
                $fileValidator = Validator::make(['fichier_file' => $file], [
                    'fichier_file' => 'file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,txt'
                ], [
                    'fichier_file.file' => 'Le fichier doit être un fichier valide',
                    'fichier_file.max' => 'Le fichier ne doit pas dépasser 10 Mo',
                    'fichier_file.mimes' => 'Formats acceptés: PDF, Word, Excel, Images, TXT'
                ]);
                
                if ($fileValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $fileValidator->errors(),
                        'message' => 'Erreur de fichier'
                    ], 422);
                }
                
                // Générer un nom unique pour le fichier
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '_' . uniqid() . '.' . $extension;
                
                // Créer le dossier d'upload s'il n'existe pas
                $uploadPath = public_path('uploads/detaille_a_faire');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Déplacer le fichier
                $file->move($uploadPath, $fileName);
            }
            
            // Si c'est un chemin manuel (input texte)
            $manualFileName = $request->input('fichier');
            
            // Décider quel nom de fichier utiliser
            $finalFileName = $fileName ?: $manualFileName;
            
            // Créer le détail
            $detail = DetailleAFaire::create([
                'nom' => $request->nom,
                'description' => $request->description,
                'fichier' => $finalFileName,
                'url' => $request->url,
                'id_preparation' => $request->id_preparation
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Détail ajouté avec succès',
                'detail' => $detail
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Erreur ajout détail:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout: ' . $e->getMessage()
            ], 500);
        }
    }



    /**
     * Supprimer un détail
     */
    public function deleteDetail($id)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non connecté'
            ], 401);
        }
        
        // Trouver le détail et vérifier qu'il appartient à une préparation de l'utilisateur
        $detail = DetailleAFaire::where('detaille_a_faire.id', $id)
            ->join('preparation', 'detaille_a_faire.id_preparation', '=', 'preparation.id')
            ->where('preparation.id_utilisateur', $userId)
            ->select('detaille_a_faire.*')
            ->first();
        
        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Détail non trouvé'
            ], 404);
        }
        
        try {
            $detail->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Détail supprimé avec succès'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtenir les calendriers disponibles pour un utilisateur concerné
     */
    public function getCalendriers($utilisateurConcernerId)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non connecté'
            ], 401);
        }
        
        $utilisateurConcerner = UtilisateurConcerner::where('id', $utilisateurConcernerId)
            ->where('id_utilsateur', $userId)
            ->with('calendrier')
            ->first();
        
        if (!$utilisateurConcerner) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur concerné non trouvé'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'calendrier' => $utilisateurConcerner->calendrier
        ]);
    }


    /**
     * Créer une préparation à partir d'une notification
     */
    public function createFromNotification($notificationId)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }
        
        // Récupérer la notification
        $notification = Notification::where('id', $notificationId)
            ->where('id_utilisateur', $userId)
            ->first();
        
        if (!$notification) {
            abort(404, 'Notification non trouvée');
        }
        
        // Pré-remplir les données si possible
        $preSelectedData = [];
        
        if ($notification->id_table_source && $notification->table_source === 'calendrier_preparation') {
            // Trouver l'utilisateur concerné
            $tacheConcerner = UtilisateurConcerner::where('id_calandrier', $notification->id_table_source)
                ->where('id_utilsateur', $userId)
                ->first();
            
            if ($tacheConcerner) {
                $preSelectedData = [
                    'utilisateur_concerner_id' => $tacheConcerner->id,
                    'calendrier_id' => $notification->id_table_source,
                    'titre' => $notification->titre
                ];
            }
        }
        
        $aFaireList = AFaire::orderBy('nom')->get();
        $utilisateursConcerner = UtilisateurConcerner::where('id_utilsateur', $userId)
            ->with('calendrier')
            ->get();
        
        return view('preparation.create', compact('aFaireList', 'utilisateursConcerner', 'preSelectedData', 'notificationId'));
    }

    /**
     * Afficher le formulaire pour ajouter un détail
     */
    public function createDetail($id)
    {
        $userId = Session::get('user.id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }
        
        $preparation = Preparation::where('id', $id)
            ->where('id_utilisateur', $userId)
            ->firstOrFail();
        
        return view('preparation.detail.create', compact('preparation'));
    }
}