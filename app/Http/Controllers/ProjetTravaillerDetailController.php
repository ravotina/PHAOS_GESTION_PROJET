<?php

namespace App\Http\Controllers;

use App\Models\ProjectTravailler;
use App\Models\ProjetTravaillerDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProjetTravaillerDetailController extends Controller
{
    /**
     * Affiche la liste des détails d'un projet
     */
    public function index($projetId)
    {
        $projet = ProjectTravailler::findOrFail($projetId);
        $details = ProjetTravaillerDetail::getByProjet($projetId);
        
        return view('projet_travailler.details.index', compact('projet', 'details'));
    }

    /**
     * Affiche le formulaire d'ajout de détail
     */
    public function create($projetId)
    {
        $projet = ProjectTravailler::findOrFail($projetId);
        
        return view('projet_travailler.details.create', compact('projet'));
    }

    /**
     * Enregistre un nouveau détail
     */
    public function store(Request $request, $projetId)
    {
        // Valider le projet existe
        $projet = ProjectTravailler::findOrFail($projetId);
        
        // Valider les données
        $validated = $request->validate(ProjetTravaillerDetail::$rules);
        
        try {
            $filePath = null;
            
            // Gestion du fichier
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('projet_travailler_details', $fileName, 'public');
                
                Log::info('Fichier uploadé', [
                    'projet_id' => $projetId,
                    'file_name' => $fileName,
                    'file_path' => $filePath
                ]);
            }
            
            // Créer le détail
            ProjetTravaillerDetail::create([
                'nom' => $validated['nom'],
                'description' => $validated['description'] ?? null,
                'file' => $filePath,
                'id_projects_travailler' => $projetId
            ]);
            
            Log::info('Détail de projet créé', [
                'projet_id' => $projetId,
                'nom' => $validated['nom']
            ]);
            
            return redirect()->route('projet.travailler.details.index', $projetId)
                           ->with('success', 'Détail ajouté avec succès');
                           
        } catch (\Exception $e) {
            Log::error('Erreur création détail projet', [
                'projet_id' => $projetId,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Télécharge un fichier
     */
    public function download($projetId, $id)
    {
        $detail = ProjetTravaillerDetail::findOrFail($id);
        
        // Vérifier que le détail appartient au projet
        if ($detail->id_projects_travailler != $projetId) {
            abort(403, 'Accès non autorisé');
        }
        
        if (!$detail->file || !Storage::disk('public')->exists($detail->file)) {
            return redirect()->back()
                           ->with('error', 'Fichier non trouvé');
        }
        
        return Storage::disk('public')->download(
            $detail->file, 
            $detail->nom . '.' . $detail->file_extension
        );
    }

    /**
     * Supprime un détail
     */
    public function destroy($projetId, $id)
    {
        try {
            $detail = ProjetTravaillerDetail::findOrFail($id);
            
            // Vérifier que le détail appartient au projet
            if ($detail->id_projects_travailler != $projetId) {
                abort(403, 'Accès non autorisé');
            }
            
            // Supprimer le fichier si existant
            if ($detail->file && Storage::disk('public')->exists($detail->file)) {
                Storage::disk('public')->delete($detail->file);
            }
            
            $detail->delete();
            
            Log::info('Détail de projet supprimé', [
                'projet_id' => $projetId,
                'detail_id' => $id
            ]);
            
            return redirect()->route('projet.travailler.details.index', $projetId)
                           ->with('success', 'Détail supprimé avec succès');
                           
        } catch (\Exception $e) {
            Log::error('Erreur suppression détail projet', [
                'projet_id' => $projetId,
                'detail_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()
                           ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Affiche un détail
     */
    public function show($projetId, $id)
    {
        $projet = ProjectTravailler::findOrFail($projetId);
        $detail = ProjetTravaillerDetail::findOrFail($id);
        
        // Vérifier que le détail appartient au projet
        if ($detail->id_projects_travailler != $projetId) {
            abort(403, 'Accès non autorisé');
        }
        
        return view('projet_travailler.details.show', compact('projet', 'detail'));
    }
}