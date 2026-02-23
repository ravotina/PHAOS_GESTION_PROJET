<?php

namespace App\Http\Controllers;

use App\Models\EmploiDuTemps;
use App\Models\LancementProjet;
use App\Models\ModuleAffecter; // CHANGÉ
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class EmploiDuTempsController extends Controller
{
    /**
     * Afficher le calendrier pour un lancement
     */
    public function show($projetDemareId ,  $lancementId)
    {
        $lancement = LancementProjet::with('projetDemare')->findOrFail($lancementId);
        $modules = ModuleAffecter::getAll(); // CHANGÉ
        
        return view('edb.calendrier', compact('lancement', 'modules'));
    }

    /**
     * Récupérer les événements pour FullCalendar
     */
    public function getEvents(Request $request, $projetDemareId, $lancementId): JsonResponse
    {
        $start = $request->input('start');
        $end = $request->input('end');
        
        $query = EmploiDuTemps::with('module')
                            ->where('id_lancement_du_projet', $lancementId);
        
        if ($start && $end) {
            $query->where(function($q) use ($start, $end) {
                $q->whereBetween('date_debut', [$start, $end])
                ->orWhereBetween('date_fin', [$start, $end])
                ->orWhere(function($subQ) use ($start, $end) {
                    $subQ->where('date_debut', '<=', $start)
                        ->where('date_fin', '>=', $end);
                });
            });
        }
        
        $events = $query->get()->map(function ($event) {
            // MÊME tableau de couleurs que dans le JavaScript
            $moduleColors = [
                1 => '#3788d8', // Mission
                2 => '#28a745', // Achat
                3 => '#dc3545', // Projet
                4 => '#ffc107', // Finance
                5 => '#6f42c1', // Ressources Humaines
                6 => '#fd7e14', // Inventaire
                7 => '#20c997', // Vente
                8 => '#e83e8c'  // Support Client
            ];
            
            $color = $moduleColors[$event->id_module_affecter] ?? '#3788d8';
            
            return [
                'id' => $event->id,
                'title' => $event->module->nom,
                'start' => $event->date_debut->toDateString(),
                'end' => $event->date_fin ? $event->date_fin->toDateString() : null,
                'color' => $color, // ← Couleur basée sur l'ID du module
                'extendedProps' => [
                    'description' => $event->description,
                    'module_id' => $event->id_module_affecter,
                    'module_nom' => $event->module->nom,
                    'lancement_id' => $event->id_lancement_du_projet
                ]
            ];
        });
        
        return response()->json($events);
    }

    

    /**
     * Créer un nouvel emploi du temps
     */
    public function store(Request $request, $projetDemareId , $lancementId): JsonResponse
    {
        $validated = $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'description' => 'nullable|string',
            'id_module_affecter' => 'required|integer|exists:module_affecter,id' // CHANGÉ
        ]);
        
        $validated['id_lancement_du_projet'] = $lancementId;
        
        try {
            $emploi = EmploiDuTemps::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Emploi du temps créé avec succès',
                'data' => $emploi
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur création emploi du temps', [
                'error' => $e->getMessage(),
                'lancement_id' => $lancementId,
                'data' => $validated
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour un emploi du temps
     */
    public function update(Request $request, $lancementId, $id): JsonResponse
    {
        $emploi = EmploiDuTemps::where('id_lancement_du_projet', $lancementId)
                              ->findOrFail($id);
        
        $validated = $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'description' => 'nullable|string',
            'id_module_affecter' => 'required|integer|exists:module_affecter,id' // CHANGÉ
        ]);
        
        try {
            $emploi->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Emploi du temps modifié avec succès',
                'data' => $emploi
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur modification emploi du temps', [
                'error' => $e->getMessage(),
                'emploi_id' => $id,
                'data' => $validated
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un emploi du temps
     */
    public function destroy($lancementId, $id): JsonResponse
    {
        try {
            $emploi = EmploiDuTemps::where('id_lancement_du_projet', $lancementId)
                                  ->findOrFail($id);
            $emploi->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Emploi du temps supprimé avec succès'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur suppression emploi du temps', [
                'error' => $e->getMessage(),
                'emploi_id' => $id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Liste des emplois du temps (vue tableau)
     */
    public function index($projetDemareId, $lancementId)
    {
        $lancement = LancementProjet::with('projetDemare')->findOrFail($lancementId);
        $emplois = EmploiDuTemps::getByLancement($lancementId);
        $modules = ModuleAffecter::getAll(); // CHANGÉ
        
        return view('edb.index', compact('lancement', 'emplois', 'modules'));
    }

    public function edit($projetDemareId, $lancementId, $id)
    {
        $emploi = EmploiDuTemps::where('id_lancement_du_projet', $lancementId)
                            ->with('module')
                            ->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $emploi
        ]);
    }
}