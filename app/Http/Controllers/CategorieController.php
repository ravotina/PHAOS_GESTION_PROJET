<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategorieController extends Controller
{

   public function index()
    {
        $typesProjet = Categorie::orderBy('nom')->get();
        return response()->json($typesProjet);
    }
    
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:250',
                'description' => 'nullable|string'
            ]);
            
            $Categorie = Categorie::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Type de projet créé avec succès',
                'data' => $Categorie
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
            $Categorie = Categorie::findOrFail($id);
            
            $validated = $request->validate([
                'nom' => 'required|string|max:250',
                'description' => 'nullable|string'
            ]);
            
            $Categorie->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Type de projet mis à jour avec succès',
                'data' => $Categorie
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
            $Categorie = Categorie::findOrFail($id);
            $Categorie->delete();
            
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
            $Categorie = Categorie::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $Categorie
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
            $types = Categorie::where('nom', 'LIKE', "%{$term}%")
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
            $types = Categorie::orderBy('nom')->get();
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