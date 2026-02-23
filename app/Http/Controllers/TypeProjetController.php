<?php

namespace App\Http\Controllers;

use App\Models\TypeProjet;
use Illuminate\Http\Request;

class TypeProjetController extends Controller
{
    public function index()
    {
        $typesProjet = TypeProjet::orderBy('nom')->get();
        return response()->json($typesProjet);
    }
    
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:250',
                'description' => 'nullable|string'
            ]);
            
            $typeProjet = TypeProjet::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Type de projet créé avec succès',
                'data' => $typeProjet
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $typeProjet = TypeProjet::findOrFail($id);
            
            $validated = $request->validate([
                'nom' => 'required|string|max:250',
                'description' => 'nullable|string'
            ]);
            
            $typeProjet->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Type de projet mis à jour avec succès',
                'data' => $typeProjet
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function destroy($id)
    {
        try {
            $typeProjet = TypeProjet::findOrFail($id);
            $typeProjet->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Type de projet supprimé avec succès'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function show($id)
    {
        try {
            $typeProjet = TypeProjet::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $typeProjet
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Type de projet non trouvé'
            ], 404);
        }
    }
    
    public function search(Request $request)
    {
        try {
            $term = $request->input('q', '');
            $types = TypeProjet::where('nom', 'LIKE', "%{$term}%")
                             ->orWhere('description', 'LIKE', "%{$term}%")
                             ->orderBy('nom')
                             ->get();
            
            return response()->json([
                'success' => true,
                'data' => $types
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche'
            ], 500);
        }
    }
    
    public function apiAll()
    {
        try {
            $types = TypeProjet::orderBy('nom')->get();
            return response()->json([
                'success' => true,
                'data' => $types
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement'
            ], 500);
        }
    }
}