<?php

namespace App\Http\Controllers;

use App\Models\TypeProjet;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use App\Models\Projet;

class DashboardController extends Controller
{
    private $dolibarrClient;

    public function __construct()
    {
        $this->dolibarrClient = new Client();
    }

    public function index()
    {
        // Statistiques
        $totalProjets = Projet::countProjets();
        $projetsEnCours = Projet::getProjetsEnCours()->count();
        $projetsValides = Projet::getProjetsTermines()->count();
        $projetsEnAttente = Projet::getProjetsAVenir()->count();

        // Projets récents
        $projetsRecents = Projet::with('typeProjet')
                                    ->orderBy('id', 'desc')
                                    ->limit(6)
                                    ->get();

        // Types de projet pour les graphiques
        $typesProjet = TypeProjet::getAll();

        return view('dashboard', compact(
            'totalProjets',
            'projetsEnCours', 
            'projetsValides',
            'projetsEnAttente',
            'projetsRecents',
            'typesProjet'
        ));
    }

    /**
     * API pour les données du dashboard
     */
    public function apiStats()
    {
        try {
            $stats = [
                'total_projets' => Projet::countProjets(),
                'projets_en_cours' => Projet::getProjetsEnCours()->count(),
                'projets_valides' => Projet::getProjetsTermines()->count(),
                'projets_en_attente' => Projet::getProjetsAVenir()->count(),
                'projets_par_type' => $this->getProjetsParType(),
                'projets_recents' => Projet::with('typeProjet')
                                               ->orderBy('id', 'desc')
                                               ->limit(5)
                                               ->get()
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des statistiques',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupérer le nombre de projets par type
     */
    private function getProjetsParType()
    {
        $types = TypeProjet::getAll();
        $data = [];

        foreach ($types as $type) {
            $count = Projet::where('id', $type->id_projet)->count();
            $data[] = [
                'type' => $type->nom,
                'count' => $count
            ];
        }

        return $data;
    }
}