<?php

namespace App\Http\Controllers;

use App\Models\LancementProjet;
use App\Models\ProjetDemare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LancementProjetController extends Controller
{
    public function index(Request $request)
    {
        // 1. Requête de base - TOUS les lancements
        $query = LancementProjet::orderBy('date_debu', 'desc')
                            ->orderBy('id', 'desc');
        
        // 2. FILTRE par projet (optionnel)
        if ($request->filled('projet_id')) {
            $query->where('id_projet_demare', $request->projet_id);
        }
        
        // 3. FILTRE par statut (optionnel)
        if ($request->filled('status')) {
            $now = now();
            
            switch ($request->status) {
                case 'en_cours':
                    $query->where('date_debu', '<=', $now)
                        ->where('date_fin', '>=', $now);
                    break;
                case 'termine':
                    $query->where('date_fin', '<', $now);
                    break;
                case 'a_venir':
                    $query->where('date_debu', '>', $now);
                    break;
            }
        }
        
        // 4. RECHERCHE (optionnel)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'ILIKE', "%{$search}%")
                ->orWhere('description', 'ILIKE', "%{$search}%");
            });
        }
        
        // 5. Pagination
        $lancements = $query->paginate(15);

        Log::info('Lancements récupérés', [
            'count' => $lancements->count(),
            'total' => $lancements->total(),
            'current_page' => $lancements->currentPage(),
        ]);
        
        // 6. Tous les projets pour le select
        $tousLesProjets = ProjetDemare::with('typeProjet')
                                    ->orderBy('non_de_projet', 'asc')
                                    ->get();
        
        // 7. Statistiques
        $stats = $this->calculerStats();
        
        // 8. Retourne la vue
        return view('lancement.index', compact('lancements', 'tousLesProjets', 'stats'));
    }

    private function calculerStats()
    {
        $now = now();
        
        return [
            'total' => LancementProjet::count(),
            'en_cours' => LancementProjet::where('date_debu', '<=', $now)
                                        ->where('date_fin', '>=', $now)
                                        ->count(),
            'termine' => LancementProjet::where('date_fin', '<', $now)->count(),
            'a_venir' => LancementProjet::where('date_debu', '>', $now)->count(),
            'budget_total' => LancementProjet::sum('budget'),
            'projets_distincts' => LancementProjet::distinct('id_projet_demare')->count('id_projet_demare'),
        ];
    }


    /**
     * Formulaire de création
     */
    public function create($projetDemareId)
    {
        $projet = ProjetDemare::findOrFail($projetDemareId);
        return view('lancement.create', compact('projet'));
    }

    /**
     * Enregistrement
     */

   public function store(Request $request, $projetDemareId)
    {
        // 1. DÉCOMMENTEZ la validation
        $validated = $request->validate(LancementProjet::$rules);
        
        // 2. Remplacer les champs qui viennent de la route/session
        $validated['id_projet_demare'] = $projetDemareId;
        $validated['id_utilisateur'] = Session::get('user.id');
        
        // 3. Debug log (optionnel)
        Log::info('Création lancement projet', [
            'projet_id' => $projetDemareId,
            'utilisateur_id' => $validated['id_utilisateur'],
            'donnees_formulaire' => $request->only(['nom', 'description', 'date_debu', 'date_fin', 'budget'])
        ]);
        
        // 4. Créer le lancement
        try {
            $lancement = LancementProjet::createLancement($validated);
            
            return redirect()->route('lancement.index', $projetDemareId)
                        ->with('success', 'Lancement créé avec succès!');
                        
        } catch (\Exception $e) {
            Log::error('Erreur création lancement', [
                'error' => $e->getMessage(),
                'projet_id' => $projetDemareId,
                'donnees' => $validated
            ]);
            
            return redirect()->back()
                        ->withInput()
                        ->with('error', 'Erreur lors de la création: ' . $e->getMessage());
        }
    }

    /**
     * Affichage détaillé
     */
    public function show($projetDemareId, $id)
    {
        $projet = ProjetDemare::findOrFail($projetDemareId);
        $lancement = LancementProjet::with(['projetDemare', 'details'])
                                   ->findOrFail($id);
        
        return view('lancement.show', compact('projet', 'lancement'));
    }

    /**
     * Formulaire d'édition
     */
    public function edit($projetDemareId, $id)
    {
        $projet = ProjetDemare::findOrFail($projetDemareId);
        $lancement = LancementProjet::findOrFail($id);
        
        return view('lancement.edit', compact('projet', 'lancement'));
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, $projetDemareId, $id)
    {
        $lancement = LancementProjet::findOrFail($id);
        $validated = $request->validate(LancementProjet::$rules);
        
        try {
            $lancement->update($validated);
            
            return redirect()->route('lancement.show', [$projetDemareId, $id])
                           ->with('success', 'Lancement mis à jour avec succès');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Suppression
     */
    public function destroy($projetDemareId, $id)
    {
        try {
            $lancement = LancementProjet::findOrFail($id);
            $lancement->delete();
            
            return redirect()->route('lancement.index', $projetDemareId)
                           ->with('success', 'Lancement supprimé avec succès');
                           
        } catch (\Exception $e) {
            return redirect()->route('lancement.index', $projetDemareId)
                           ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }
}