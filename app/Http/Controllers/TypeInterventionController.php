<?php

namespace App\Http\Controllers;

use App\Models\TypeIntervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeInterventionController extends Controller
{

    public function index()
    {
        $typesProjet = TypeIntervention::orderBy('nom')->get();
        return response()->json($typesProjet);
    }
    
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:250',
                'description' => 'nullable|string'
            ]);
            
            $TypeIntervention = TypeIntervention::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Type de projet créé avec succès',
                'data' => $TypeIntervention
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
            $TypeIntervention = TypeIntervention::findOrFail($id);
            
            $validated = $request->validate([
                'nom' => 'required|string|max:250',
                'description' => 'nullable|string'
            ]);
            
            $TypeIntervention->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Type de projet mis à jour avec succès',
                'data' => $TypeIntervention
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
            $TypeIntervention = TypeIntervention::findOrFail($id);
            $TypeIntervention->delete();
            
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
            $TypeIntervention = TypeIntervention::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $TypeIntervention
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
            $types = TypeIntervention::where('nom', 'LIKE', "%{$term}%")
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
            $types = TypeIntervention::orderBy('nom')->get();
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