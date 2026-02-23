<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProjetDemare;
use App\Models\ProjetDemareDetaille;
use Illuminate\Support\Facades\Storage;
use App\Models\Projet;
use App\Models\Client;
use App\Models\User;

class ProjetDetailController extends Controller
{

    private $dolibarrClient;
    private $users;

    public function __construct()
    {
        $this->dolibarrClient = new Client();
        $this->users = new User();
    }

    //
    /**
     * Display a listing of the resource.
     */
    public function index($projetId)
    {
        // Récupérer le projet parent
        $projet = Projet::findOrFail($projetId);
        
        // Récupérer les détails du projet
        $details = ProjetDemareDetaille::where('id_projet', $projetId)
                                      ->orderBy('id', 'desc')
                                      ->get();

        $clientsData = $this->dolibarrClient->getAllClients(100);
        $clients = $clientsData['formatted']['clients'] ?? [];
        $utilisateurs = $this->users->getAllUsers();

        // Créer un mapping des ID clients vers leurs noms pour un accès rapide
        $clientsMap = [];
        foreach ($clients as $client) {
            $clientsMap[$client['id']] = $client['name'] ?? 'Client inconnu';
        }
        
        return view('projet.details.index', compact('projet', 'details' , 'clientsMap' , 'utilisateurs' , 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($projetId)
    {
        $projet = Projet::findOrFail($projetId);
        return view('projet.details.create', compact('projet'));
    }


    public function store(Request $request, $projetId)
    {
        // Validation des données avec les règles de création
        $validated = $request->validate(ProjetDemareDetaille::$rulesCreate);
        
        // Vérifier si le nom existe déjà pour ce projet
        if (ProjetDemareDetaille::nomExistsForProject($validated['nom'], $projetId)) {
            return redirect()->back()
                        ->withInput()
                        ->withErrors(['nom' => 'Ce nom existe déjà pour ce projet.']);
        }

        try {
            $filePath = null;
            
            // Gestion du fichier uploadé
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('projet_details', $fileName, 'public');
            }

            // Création du détail
           ProjetDemareDetaille::createDetail([
                'nom' => $validated['nom'],
                'description' => $validated['description'] ?? null,
                'file' => $filePath, // Stocke le chemin relatif du fichier
                'url' => $validated['url'] ?? null, // Stocke l'URL
                'id_projet' => $projetId
            ]);

            //dd($pro_demare);
            return redirect()->route('projet.details.index', $projetId)
                        ->with('success', 'Détail ajouté avec succès.');

        } catch (\Exception $e) {
            return redirect()->back()
                        ->withInput()
                        ->with('error', 'Erreur lors de l\'ajout du détail: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($projetId, $id)
    {
        $projet = ProjetDemare::findOrFail($projetId);
        $detail = ProjetDemareDetaille::where('id_projet', $projetId)
                                     ->findOrFail($id);

        return view('projet.details.edit', compact('projet', 'detail'));
    }



    public function update(Request $request, $projetId, $id)
    {
        // Récupérer le détail
        $detail = ProjetDemareDetaille::where('id_projet', $projetId)
                                    ->findOrFail($id);

        // Validation des données
        $rules = [
            'nom' => 'required|string|max:50',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif|max:10240'
        ];

        $validated = $request->validate($rules);

        // Vérifier si le nom existe déjà pour ce projet (exclure l'actuel)
        $existant = ProjetDemareDetaille::where('id_projet', $projetId)
                                    ->where('nom', $validated['nom'])
                                    ->where('id', '!=', $id)
                                    ->exists();

        if ($existant) {
            return redirect()->back()
                        ->withInput()
                        ->withErrors(['nom' => 'Ce nom existe déjà pour ce projet.']);
        }

        try {
            // Gestion du fichier uploadé
            if ($request->hasFile('file')) {
                // Supprimer l'ancien fichier s'il existe
                if ($detail->file && Storage::disk('public')->exists($detail->file)) {
                    Storage::disk('public')->delete($detail->file);
                }

                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('projet_details', $fileName, 'public');
                $validated['file'] = $filePath;
            } else {
                // Si aucun nouveau fichier, garder l'ancien
                $validated['file'] = $detail->file;
            }

            // Mise à jour du détail
            $detail->update([
                'nom' => $validated['nom'],
                'description' => $validated['description'],
                'file' => $validated['file']
            ]);
                            
            return redirect()->route('projet.details.index', $projetId)
                        ->with('success', 'Détail modifié avec succès.');

        } catch (\Exception $e) {
            return redirect()->back()
                        ->withInput()
                        ->with('error', 'Erreur lors de la modification du détail: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($projetId, $id)
    {
        try {
            $detail = ProjetDemareDetaille::where('id_projet', $projetId)
                                         ->findOrFail($id);

            // Supprimer le fichier associé s'il existe
            if ($detail->file && Storage::disk('public')->exists($detail->file)) {
                Storage::disk('public')->delete($detail->file);
            }

            // Supprimer le détail
            ProjetDemareDetaille::deleteDetail($id);

            return redirect()->route('projet.details.index', $projetId)
                           ->with('success', 'Détail supprimé avec succès.');

        } catch (\Exception $e) {
            return redirect()->route('projet.details.index', $projetId)
                           ->with('error', 'Erreur lors de la suppression du détail: ' . $e->getMessage());
        }
    }

    /**
     * Télécharger le fichier associé à un détail
     */
    public function download($projetId, $id)
    {
        $detail = ProjetDemareDetaille::where('id_projet', $projetId)
                                     ->findOrFail($id);

        if (!$detail->file || !Storage::disk('public')->exists($detail->file)) {
            return redirect()->back()
                           ->with('error', 'Fichier non trouvé.');
        }

        return Storage::disk('public')->download($detail->file, $detail->nom . '.' . pathinfo($detail->file, PATHINFO_EXTENSION));
    }

    /**
     * Afficher le fichier associé à un détail
     */
    public function view($projetId, $id)
    {
        $detail = ProjetDemareDetaille::where('id_projet', $projetId)
                                     ->findOrFail($id);

        if (!$detail->file || !Storage::disk('public')->exists($detail->file)) {
            return redirect()->back()
                           ->with('error', 'Fichier non trouvé.');
        }

        return response()->file(Storage::disk('public')->path($detail->file));
    }
}
