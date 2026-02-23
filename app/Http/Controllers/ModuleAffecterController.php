<?php

namespace App\Http\Controllers;

use App\Models\ModuleAffecter;
use Illuminate\Http\Request;

class ModuleAffecterController extends Controller
{
    /**
     * Liste des modules affecter
     */
    public function index()
    {
        $modules = ModuleAffecter::getAll();
        return view('modules-affecter.index', compact('modules'));
    }

    /**
     * Créer un nouveau module
     */
    public function store(Request $request)
    {
        $validated = $request->validate(ModuleAffecter::$rules);
        
        try {
            ModuleAffecter::create($validated);
            
            return redirect()->back()
                           ->with('success', 'Module créé avec succès');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Mettre à jour un module
     */
    public function update(Request $request, $id)
    {
        $module = ModuleAffecter::findOrFail($id);
        
        $rules = ModuleAffecter::$rules;
        $rules['nom'] = 'required|string|max:100|unique:module_affecter,nom,' . $id;
        
        $validated = $request->validate($rules);
        
        try {
            $module->update($validated);
            
            return redirect()->back()
                           ->with('success', 'Module modifié avec succès');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Supprimer un module
     */
    public function destroy($id)
    {
        try {
            $module = ModuleAffecter::findOrFail($id);
            
            // Vérifier s'il est utilisé dans des emplois du temps
            if ($module->emploisDuTemps()->count() > 0) {
                return redirect()->back()
                               ->with('error', 'Impossible de supprimer ce module car il est utilisé dans des emplois du temps');
            }
            
            $module->delete();
            
            return redirect()->back()
                           ->with('success', 'Module supprimé avec succès');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }
}