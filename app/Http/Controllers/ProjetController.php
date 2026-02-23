<?php

namespace App\Http\Controllers;

use App\Models\ProjetDemare;
use App\Models\TypeProjet;
use App\Models\TypeIntervention;
use App\Models\Categorie;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Models\Projet;
use Illuminate\Support\Facades\Session;

class ProjetController extends Controller
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
        // Vérifier si l'utilisateur a la permission
        $hasApiPermission = app('permission')->hasModule('api');
        $userId = Session::get('user.id');
        
        // Récupérer les projets selon la permission
        if ($hasApiPermission) {
            // Avec permission : voir tous les projets
            $projets = Projet::with(['typeProjet', 'typeIntervention', 'categorie'])
                            ->orderBy('id', 'desc')
                            ->get();
        } else {
            // Sans permission : voir seulement les projets actifs
            $userId = Session::get('user.id');
            $projets = Projet::with(['typeProjet', 'typeIntervention', 'categorie'])
                            ->where('actif', true)  // <-- Seulement les actifs
                            ->Where('id_utilisateur_chef_de_projet', $userId)
                            ->orderBy('id', 'desc')
                            ->get();
        }

        $clientsData = $this->dolibarrClient->getAllClients(100);
        $clients = $clientsData['formatted']['clients'] ?? [];
        $utilisateurs = $this->users->getAllUsers();

        // Créer un mapping des ID clients vers leurs noms pour un accès rapide
        $clientsMap = [];
        foreach ($clients as $client) {
            $clientsMap[$client['id']] = $client['name'] ?? 'Client inconnu';
        }
        
        // Passez également l'information de permission à la vue
        return view('projet.index', compact('projets', 'clients', 'utilisateurs', 'clientsMap', 'hasApiPermission'));
    }


    // Dans ProjetController.php
    public function toggleActive($id)
    {
        $projet = Projet::findOrFail($id);
        
        // Vérifier les permissions si nécessaire
        if (!app('permission')->hasPermission('projet', 'creer')) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'avez pas la permission de modifier ce projet'
            ], 403);
        }
        
        // Basculer le statut actif
        $projet->actif = !$projet->actif;
        $projet->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour avec succès',
            'actif' => $projet->actif
        ]);
    }


    public function indexdashboard()
    {

        // Vérifier si l'utilisateur a la permission
        $hasApiPermission = app('permission')->hasModule('api');
        $userId = Session::get('user.id');

        if ($userId == null) {
            return redirect('/login');
        }


        if ($hasApiPermission) {
            // Avec permission admin : voir tous les projets
            $projets = Projet::with('typeProjet')
                            ->orderBy('id', 'desc')
                            ->get();
             $statsProjets = [
                'brouillon' => Projet::where('status', 'brouillon')->count(),
                'en_attente' => Projet::where('status', 'en_attente')->count(),
                'en_cours' => Projet::where('status', 'en_cours')->count(),
                'termine' => Projet::where('status', 'termine')->count(),
                'annule' => Projet::where('status', 'annule')->count(),
            ];

            $statsProjets = [
                'brouillon' => Projet::where('status', 'brouillon')->count(),
                'en_attente' => Projet::where('status', 'en_attente')->count(),
                'en_cours' => Projet::where('status', 'en_cours')->count(),
                'termine' => Projet::where('status', 'termine')->count(),
                'annule' => Projet::where('status', 'annule')->count(),
            ];
            $statsProjets['total'] = array_sum($statsProjets);

        } else {

            // Sans permission et non responsable : voir seulement les projets actifs
            $projets = Projet::with('typeProjet')
                            ->where('actif', true)
                            ->where('id_utilisateur_chef_de_projet', $userId)
                            ->orderBy('id', 'desc')
                            ->get();

            $statsProjets = [
                'brouillon' => Projet::where('status', 'brouillon')->where('actif', true)->where('id_utilisateur_chef_de_projet', $userId)->count(),
                'en_attente' => Projet::where('status', 'en_attente')->where('actif', true)->where('id_utilisateur_chef_de_projet', $userId)->count(),
                'en_cours' => Projet::where('status', 'en_cours')->where('actif', true)->where('id_utilisateur_chef_de_projet', $userId)->count(),
                'termine' => Projet::where('status', 'termine')->where('actif', true)->where('id_utilisateur_chef_de_projet', $userId)->count(),
                'annule' => Projet::where('status', 'annule')->where('actif', true)->where('id_utilisateur_chef_de_projet', $userId)->count(),
            ];
            $statsProjets['total'] = array_sum($statsProjets);
        
            
        } 
        
        return view('Tableau_de_board.index', compact('projets', 'statsProjets'));
            
        //    return view('projet.index', compact('projets'));
    }


    public function create()
    {


        $typesProjet = TypeProjet::orderBy('nom')->get();
        $typesIntervention = TypeIntervention::orderBy('nom')->get();
        $categories = Categorie::orderBy('nom')->get();

        $typesProjet = TypeProjet::orderBy('nom')->get();
        $clientsData = $this->dolibarrClient->getAllClients(100);
        $clients = $clientsData['formatted']['clients'] ?? [];
        $utilisateurs = $this->users->getAllUsers();
        
        // Debug: voir la structure réelle
        //dd($utilisateurs);
        // return view('demarage.create', compact('typesProjet', 'clients', 'utilisateurs'));

        return view('projet.create', compact(
            'typesProjet', 
            'typesIntervention',
            'categories',
            'clients', 
            'utilisateurs'
        ));
        
    }

    public function store(Request $request)
    {
        try {
            // Utiliser les règles de validation du modèle Projet
            $validated = $request->validate(Projet::$rules, Projet::$messages);

            // Ajouter l'utilisateur connecté si non spécifié
            if (empty($validated['id_utilisateur_chef_de_projet'])) {
                $validated['id_utilisateur_chef_de_projet'] = auth()->id() ?? 1;
            }

            $id_utilisateur_creer = Session::get('user.id');
            $validated['id_utilisateur_creer'] = $id_utilisateur_creer;


            $projet = Projet::createProjet($validated);
            
            return redirect()->route('projets.index')
                           ->with('success', 'Projet créé avec succès!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                           ->withErrors($e->errors())
                           ->withInput();
            
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Erreur lors de la création du projet: ' . $e->getMessage())
                           ->withInput();
        }
    }



    public function show($id)
    {
        $projet = Projet::with(['typeProjet', 'typeIntervention', 'categorie'])->find($id);  // Changé ici
        
        if (!$projet) {
            return redirect()->route('projets.index')
                           ->with('error', 'Projet non trouvé');
        }
        
        return view('projets.show', compact('projet'));
    }


    public function edit($id)
    {
        $projet = Projet::with(['typeProjet', 'typeIntervention', 'categorie'])->find($id);  // Changé ici
        $typesProjet = TypeProjet::orderBy('nom')->get();
        $typesIntervention = TypeIntervention::orderBy('nom')->get();
        $categories = Categorie::orderBy('nom')->get();
        $clientsData = $this->dolibarrClient->getAllClients(100);
        $clients = $clientsData['formatted']['clients'] ?? [];

        $utilisateurs = $this->users->getAllUsers();
        
        if (!$projet) {
            return redirect()->route('projets.index')
                           ->with('error', 'Projet non trouvé');
        }
        
        return view('projet.modification', compact('projet', 'typesProjet', 'typesIntervention', 'categories', 'clients' , 'utilisateurs'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Utiliser les règles de validation du modèle avec exclusion pour l'update
            $rules = Projet::$rules;
            
            // Pour l'update, on ne vérifie pas l'unicité du nom sur lui-même
            // Si vous avez besoin de vérifier l'unicité, ajustez ici
            
            $validated = $request->validate($rules, Projet::$messages);

            $projet = Projet::updateProjet($id, $validated);
            
            if ($projet) {
                return redirect()->route('projets.index')
                               ->with('success', 'Projet mis à jour avec succès!');
            } else {
                return redirect()->route('projets.index')
                               ->with('error', 'Projet non trouvé');
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                           ->withErrors($e->errors())
                           ->withInput();
            
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Erreur lors de la mise à jour du projet: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $deleted = Projet::deleteProjet($id);  // Changé ici
            
            if ($deleted) {
                return redirect()->route('projets.index')
                               ->with('success', 'Projet supprimé avec succès!');
            } else {
                return redirect()->route('projets.index')
                               ->with('error', 'Projet non trouvé');
            }
            
        } catch (\Exception $e) {
            return redirect()->route('projets.index')
                           ->with('error', 'Erreur lors de la suppression du projet: ' . $e->getMessage());
        }
    }

    public function apiClients(): JsonResponse
    {
        try {
            $clients = $this->dolibarrClient->getAllClients(100);
            
            return response()->json([
                'success' => true,
                'data' => $clients
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des clients',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function byUser($userId)
    {
        $projets = Projet::getByUtilisateur($userId);  // Changé ici
        return view('projets.index', compact('projets'));
    }

    /**
     * Récupérer les projets par client
     */
    public function byClient($clientId)
    {
        $projets = Projet::getByClient($clientId);  // Changé ici
        return view('projets.index', compact('projets'));
    }

    /**
     * Rechercher des projets
     */
    public function search(Request $request)
    {
        $term = $request->get('q', '');
        
        if (empty($term)) {
            return redirect()->route('projets.index');
        }

        $projets = Projet::search($term);  // Changé ici
        return view('projets.index', compact('projets', 'term'));
    }

    public function ajouter_detaille($projetId)
    {
        $projet = Projet::getById($projetId);  // Changé ici
        
        return view('projets.ajouter-details', compact('projet'));
    }

    /**
     * Méthode pour récupérer les statistiques des projets
     */
    public function statistiques()
    {
        $statistiques = Projet::getStatistiques();  // Changé ici
        return response()->json($statistiques);
    }

}