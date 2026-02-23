<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AFaire;
use App\Models\TypeProjet;
use Illuminate\Support\Facades\DB;

class AdminControlleur extends Controller
{
    //
    public function index()
    {
        $aFaires = AFaire::getAllWithTypeProjet();
        $typeProjets = TypeProjet::getAll();
        $activePage = 'users'; // Page active pour workflow
        return view('administration.index', compact('aFaires', 'typeProjets' , 'activePage'));
    }

    public function workflowProjet()
    {
        $aFaires = AFaire::getAllWithTypeProjet();
        $typeProjets = TypeProjet::getAll();
        $activePage = 'workflow'; // Page active pour workflow
        return view('administration.workflow.projet_demarrage' , compact('aFaires', 'typeProjets' ,'activePage'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(AFaire::$rules, AFaire::$messages);

        try {
            DB::beginTransaction();

            $aFaire = AFaire::create($validated);

            DB::commit();

            return redirect()->route('administration.workflow.projet_demarrage')
                           ->with('success', 'Tâche créée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur lors de la création de la tâche: ' . $e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        $aFaire = AFaire::findOrFail($id);

        $validated = $request->validate(AFaire::rulesForUpdate($id), AFaire::$messages);

        try {
            DB::beginTransaction();

            $aFaire->update($validated);

            DB::commit();

            return redirect()->route('administration.workflowdemarrage')
                           ->with('success', 'Tâche modifiée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur lors de la modification de la tâche: ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        $aFaire = AFaire::findOrFail($id);
        $typeProjets = TypeProjet::getAll();
         $activePage = 'workflow'; // Page active pour workflow
        return view('administration.workflow.edite_projet_demarage', compact('aFaire', 'typeProjets' , 'activePage'));
    }

    /**
     * Update the specified resource in storage.
     */
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $aFaire = AFaire::findOrFail($id);

        try {
            DB::beginTransaction();

            $aFaire->delete();

            DB::commit();
            
            return redirect()->route('administration.liste_a_faire')
                           ->with('success', 'Tâche supprimée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                           ->with('error', 'Erreur lors de la suppression de la tâche: ' . $e->getMessage());
        }
    }


    public function liste_a_faire()
    {
        $aFaires = AFaire::getAllWithTypeProjet();
        $typeProjets = TypeProjet::getAll();
        $activePage = 'workflow'; // Page active pour workflow
        
        return view('administration.workflow.index_projet_demarrage', compact('aFaires', 'typeProjets', 'activePage'));
    }


    public function search(Request $request)
    {
        $search = $request->get('search');
        $typeProjetId = $request->get('type_projet_id');
        
        $query = AFaire::with('typeProjet');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        if ($typeProjetId) {
            $query->where('id_type_projet', $typeProjetId);
        }
        
        $aFaires = $query->orderBy('id', 'desc')->get();
        $typeProjets = TypeProjet::getAll();

        $activePage = 'workflow';
        
        return view('administration.workflow.index_projet_demarrage', compact('aFaires', 'typeProjets', 'search', 'typeProjetId' , 'activePage'));
    }


    
}





