<?php

namespace App\Http\Controllers;

use App\Models\LancementProjet;
use App\Models\LancementProjetDetail;
use App\Models\ProjetDemare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LancementProjetDetailController extends Controller
{
    /**
     * Liste des détails d'un lancement
     */
    public function index($projetDemareId, $lancementId)
    {
        $projet = ProjetDemare::findOrFail($projetDemareId);
        $lancement = LancementProjet::findOrFail($lancementId);
        $details = LancementProjetDetail::getByLancement($lancementId);
        
        return view('lancement.details.index', compact('projet', 'lancement', 'details'));
    }

    /**
     * Formulaire d'ajout de détail
     */
    public function create($projetDemareId, $lancementId)
    {
        $projet = ProjetDemare::findOrFail($projetDemareId);
        $lancement = LancementProjet::findOrFail($lancementId);
        
        return view('lancement.details.create', compact('projet', 'lancement'));
    }

    /**
     * Enregistrement d'un détail
     */
    public function store(Request $request, $projetDemareId, $lancementId)
    {
        $validated = $request->validate(LancementProjetDetail::$rules);
        
        try {
            $filePath = null;
            
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('lancement_details', $fileName, 'public');
            }
            
            LancementProjetDetail::create([
                'nom' => $validated['nom'],
                'description' => $validated['description'] ?? null,
                'file' => $filePath,
                'id_lancement_projet' => $lancementId
            ]);
            
            return redirect()->route('lancement.details.index', [$projetDemareId, $lancementId])
                           ->with('success', 'Détail ajouté avec succès');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Téléchargement de fichier
     */
    public function download($projetDemareId, $lancementId, $id)
    {
        $detail = LancementProjetDetail::findOrFail($id);
        
        if (!$detail->file || !Storage::disk('public')->exists($detail->file)) {
            return redirect()->back()
                           ->with('error', 'Fichier non trouvé');
        }
        
        return Storage::disk('public')->download($detail->file, $detail->nom . '.' . pathinfo($detail->file, PATHINFO_EXTENSION));
    }

    /**
     * Suppression d'un détail
     */
    public function destroy($projetDemareId, $lancementId, $id)
    {
        try {
            $detail = LancementProjetDetail::findOrFail($id);
            
            if ($detail->file && Storage::disk('public')->exists($detail->file)) {
                Storage::disk('public')->delete($detail->file);
            }
            
            $detail->delete();
            
            return redirect()->route('lancement.details.index', [$projetDemareId, $lancementId])
                           ->with('success', 'Détail supprimé avec succès');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }
}