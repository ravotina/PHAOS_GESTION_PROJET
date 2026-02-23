<?php

namespace App\Http\Controllers;

use App\Models\AFaire;
use App\Models\TypeProjet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AFaireController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index()
    // {
    //     $aFaires = AFaire::getAllWithTypeProjet();
    //     $typeProjets = TypeProjet::getAll();
        
    //     return view('a_faire.index', compact('aFaires', 'typeProjets'));
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     $typeProjets = TypeProjet::getAll();
        
    //     return view('a_faire.create', compact('typeProjets'));
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     $validated = $request->validate(AFaire::$rules, AFaire::$messages);

    //     try {
    //         DB::beginTransaction();

    //         $aFaire = AFaire::create($validated);

    //         DB::commit();

    //         return redirect()->route('a_faire.index')
    //                        ->with('success', 'Tâche créée avec succès.');

    //     } catch (\Exception $e) {
    //         DB::rollBack();
            
    //         return redirect()->back()
    //                        ->withInput()
    //                        ->with('error', 'Erreur lors de la création de la tâche: ' . $e->getMessage());
    //     }
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show($id)
    // {
    //     $aFaire = AFaire::findWithTypeProjet($id);
        
    //     return view('a_faire.show', compact('aFaire'));
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit($id)
    // {
    //     $aFaire = AFaire::findOrFail($id);
    //     $typeProjets = TypeProjet::getAll();
        
    //     return view('a_faire.edit', compact('aFaire', 'typeProjets'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
   

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy($id)
    // {
    //     $aFaire = AFaire::findOrFail($id);

    //     try {
    //         DB::beginTransaction();

    //         $aFaire->delete();

    //         DB::commit();

    //         return redirect()->route('a_faire.index')
    //                        ->with('success', 'Tâche supprimée avec succès.');

    //     } catch (\Exception $e) {
    //         DB::rollBack();
            
    //         return redirect()->back()
    //                        ->with('error', 'Erreur lors de la suppression de la tâche: ' . $e->getMessage());
    //     }
    // }

    // /**
    //  * Recherche des tâches
    //  */
    // public function search(Request $request)
    // {
    //     $search = $request->get('search');
    //     $typeProjetId = $request->get('type_projet_id');
        
    //     $query = AFaire::with('typeProjet');
        
    //     if ($search) {
    //         $query->where(function($q) use ($search) {
    //             $q->where('nom', 'like', '%' . $search . '%')
    //               ->orWhere('description', 'like', '%' . $search . '%');
    //         });
    //     }
        
    //     if ($typeProjetId) {
    //         $query->where('id_type_projet', $typeProjetId);
    //     }
        
    //     $aFaires = $query->orderBy('id', 'desc')->get();
    //     $typeProjets = TypeProjet::getAll();
        
    //     return view('a_faire.index', compact('aFaires', 'typeProjets', 'search', 'typeProjetId'));
    // }

    // /**
    //  * Filtrer par type de projet
    //  */
    // public function filterByType($typeProjetId)
    // {
    //     $aFaires = AFaire::with('typeProjet')
    //                     ->where('id_type_projet', $typeProjetId)
    //                     ->orderBy('id', 'desc')
    //                     ->get();
    //     $typeProjets = TypeProjet::getAll();
    //     $selectedType = TypeProjet::find($typeProjetId);
        
    //     return view('a_faire.index', compact('aFaires', 'typeProjets', 'selectedType'));
    // }
}