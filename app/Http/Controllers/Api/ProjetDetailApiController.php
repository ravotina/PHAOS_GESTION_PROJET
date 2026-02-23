<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjetDemare;
use App\Models\ProjetDemareDetaille;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProjetDetailApiController extends Controller
{
    /**
     * Get all details for a project
     * GET /api/v1/projets/{projetId}/details
     */
    public function index($projetId)
    {
        try {
            // Vérifier que le projet existe
            $projet = ProjetDemare::find($projetId);
            
            if (!$projet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Projet non trouvé',
                    'data' => null
                ], 404);
            }

            // Récupérer les détails avec pagination
            $details = ProjetDemareDetaille::where('id_projet_demare', $projetId)
                ->orderBy('id', 'desc')
                ->paginate(request('per_page', 15));

            return response()->json([
                'success' => true,
                'message' => 'Détails du projet récupérés avec succès',
                'data' => [
                    'projet' => $projet,
                    'details' => $details->items(),
                    'pagination' => [
                        'current_page' => $details->currentPage(),
                        'last_page' => $details->lastPage(),
                        'per_page' => $details->perPage(),
                        'total' => $details->total(),
                        'from' => $details->firstItem(),
                        'to' => $details->lastItem()
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des détails',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific detail
     * GET /api/v1/projets/{projetId}/details/{id}
     */
    public function show($projetId, $id)
    {
        try {
            // Vérifier que le projet existe
            $projet = ProjetDemare::find($projetId);
            
            if (!$projet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Projet non trouvé',
                    'data' => null
                ], 404);
            }

            $detail = ProjetDemareDetaille::where('id_projet_demare', $projetId)
                ->find($id);

            if (!$detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Détail non trouvé',
                    'data' => null
                ], 404);
            }

            // Ajouter l'URL complète pour le fichier
            if ($detail->file) {
                $detail->file_url = Storage::disk('public')->url($detail->file);
            }

            return response()->json([
                'success' => true,
                'message' => 'Détail récupéré avec succès',
                'data' => [
                    'projet' => $projet,
                    'detail' => $detail
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du détail',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new detail
     * POST /api/v1/projets/{projetId}/details
     */
    public function store(Request $request, $projetId)
    {
        try {
            // Vérifier que le projet existe
            $projet = ProjetDemare::find($projetId);
            
            if (!$projet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Projet non trouvé',
                    'data' => null
                ], 404);
            }

            // Validation des données
            $validator = Validator::make($request->all(), ProjetDemareDetaille::$rulesCreate);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Vérifier si le nom existe déjà pour ce projet
            if (ProjetDemareDetaille::nomExistsForProject($request->nom, $projetId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce nom existe déjà pour ce projet',
                    'field' => 'nom'
                ], 422);
            }

            $filePath = null;
            
            // Gestion du fichier uploadé
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('projet_details', $fileName, 'public');
            }

            // Création du détail
            $detail = ProjetDemareDetaille::createDetail([
                'nom' => $request->nom,
                'description' => $request->description,
                'file' => $filePath,
                'url' => $request->url,
                'id_projet_demare' => $projetId
            ]);

            // Ajouter l'URL complète pour le fichier
            if ($detail->file) {
                $detail->file_url = Storage::disk('public')->url($detail->file);
            }

            return response()->json([
                'success' => true,
                'message' => 'Détail créé avec succès',
                'data' => $detail
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du détail',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a detail
     * PUT /api/v1/projets/{projetId}/details/{id}
     */
    public function update(Request $request, $projetId, $id)
    {
        try {
            // Vérifier que le projet existe
            $projet = ProjetDemare::find($projetId);
            
            if (!$projet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Projet non trouvé',
                    'data' => null
                ], 404);
            }

            // Récupérer le détail
            $detail = ProjetDemareDetaille::where('id_projet_demare', $projetId)
                ->find($id);

            if (!$detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Détail non trouvé',
                    'data' => null
                ], 404);
            }

            // Règles de validation
            $rules = [
                'nom' => 'required|string|max:50',
                'description' => 'nullable|string',
                'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif|max:10240',
                'url' => 'nullable|url'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Vérifier si le nom existe déjà pour ce projet (exclure l'actuel)
            $existant = ProjetDemareDetaille::where('id_projet_demare', $projetId)
                ->where('nom', $request->nom)
                ->where('id', '!=', $id)
                ->exists();

            if ($existant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce nom existe déjà pour ce projet',
                    'field' => 'nom'
                ], 422);
            }

            // Préparer les données de mise à jour
            $updateData = [
                'nom' => $request->nom,
                'description' => $request->description,
                'url' => $request->url
            ];

            // Gestion du fichier uploadé
            if ($request->hasFile('file')) {
                // Supprimer l'ancien fichier s'il existe
                if ($detail->file && Storage::disk('public')->exists($detail->file)) {
                    Storage::disk('public')->delete($detail->file);
                }

                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('projet_details', $fileName, 'public');
                $updateData['file'] = $filePath;
            }

            // Mise à jour du détail
            $detail->update($updateData);

            // Ajouter l'URL complète pour le fichier
            if ($detail->file) {
                $detail->file_url = Storage::disk('public')->url($detail->file);
            }

            return response()->json([
                'success' => true,
                'message' => 'Détail mis à jour avec succès',
                'data' => $detail
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du détail',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a detail
     * DELETE /api/v1/projets/{projetId}/details/{id}
     */
    public function destroy($projetId, $id)
    {
        try {
            // Vérifier que le projet existe
            $projet = ProjetDemare::find($projetId);
            
            if (!$projet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Projet non trouvé',
                    'data' => null
                ], 404);
            }

            // Récupérer le détail
            $detail = ProjetDemareDetaille::where('id_projet_demare', $projetId)
                ->find($id);

            if (!$detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Détail non trouvé',
                    'data' => null
                ], 404);
            }

            // Supprimer le fichier associé s'il existe
            if ($detail->file && Storage::disk('public')->exists($detail->file)) {
                Storage::disk('public')->delete($detail->file);
            }

            // Supprimer le détail
            $detail->delete();

            return response()->json([
                'success' => true,
                'message' => 'Détail supprimé avec succès',
                'data' => null
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du détail',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download file
     * GET /api/v1/projets/{projetId}/details/{id}/download
     */
    // public function download($projetId, $id)
    // {
    //     try {
    //         // Vérifier que le projet existe
    //         $projet = ProjetDemare::find($projetId);
            
    //         if (!$projet) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Projet non trouvé',
    //                 'data' => null
    //             ], 404);
    //         }

    //         $detail = ProjetDemareDetaille::where('id_projet_demare', $projetId)
    //             ->find($id);

    //         if (!$detail) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Détail non trouvé',
    //                 'data' => null
    //             ], 404);
    //         }

    //         if (!$detail->file || !Storage::disk('public')->exists($detail->file)) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Fichier non trouvé',
    //                 'data' => null
    //             ], 404);
    //         }

    //         // Retourner les informations pour le téléchargement
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Fichier disponible pour téléchargement',
    //             'data' => [
    //                 'download_url' => Storage::disk('public')->url($detail->file),
    //                 'filename' => $detail->nom . '.' . pathinfo($detail->file, PATHINFO_EXTENSION),
    //                 'mime_type' => Storage::disk('public')->mimeType($detail->file),
    //                 'size' => Storage::disk('public')->size($detail->file)
    //             ]
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Erreur lors de la récupération du fichier',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function download($projetId, $id)
    // {
    //     try {
    //         // Vérifier que le projet existe
    //         $projet = ProjetDemare::find($projetId);
            
    //         if (!$projet) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Projet non trouvé',
    //                 'data' => null
    //             ], 404);
    //         }

    //         $detail = ProjetDemareDetaille::where('id_projet_demare', $projetId)
    //             ->find($id);

    //         if (!$detail) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Détail non trouvé',
    //                 'data' => null
    //             ], 404);
    //         }

    //         if (!$detail->file || !Storage::disk('public')->exists($detail->file)) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Fichier non trouvé',
    //                 'data' => null
    //             ], 404);
    //         }

    //         // Retourner le fichier directement pour téléchargement
    //         $filePath = Storage::disk('public')->path($detail->file);
    //         $fileName = $detail->nom . '.' . pathinfo($detail->file, PATHINFO_EXTENSION);
            
    //         return response()->download($filePath, $fileName, [
    //             'Content-Type' => Storage::disk('public')->mimeType($detail->file),
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Erreur lors de la récupération du fichier',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }


    /**
     * Récupérer les informations du fichier (JSON)
     */
    public function getFileInfo($projetId, $id)
    {
        try {
            // Vérifier que le projet existe
            $projet = ProjetDemare::find($projetId);
            
            if (!$projet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Projet non trouvé',
                    'data' => null
                ], 404);
            }

            $detail = ProjetDemareDetaille::where('id_projet_demare', $projetId)
                ->find($id);

            if (!$detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Détail non trouvé',
                    'data' => null
                ], 404);
            }

            if (!$detail->file || !Storage::disk('public')->exists($detail->file)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fichier non trouvé',
                    'data' => null
                ], 404);
            }

            // Retourner les informations pour le téléchargement
            return response()->json([
                'success' => true,
                'message' => 'Fichier disponible pour téléchargement',
                'data' => [
                    'download_url' => route('file.download', ['projetId' => $projetId, 'id' => $id]),
                    'filename' => $detail->nom . '.' . pathinfo($detail->file, PATHINFO_EXTENSION),
                    'mime_type' => Storage::disk('public')->mimeType($detail->file),
                    'size' => Storage::disk('public')->size($detail->file),
                    'original_filename' => basename($detail->file)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du fichier',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Télécharger le fichier directement (binaire)
     */
    public function download($projetId, $id)
    {
        try {
            // Vérifier que le projet existe
            $projet = ProjetDemare::find($projetId);
            
            if (!$projet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Projet non trouvé'
                ], 404);
            }

            $detail = ProjetDemareDetaille::where('id_projet_demare', $projetId)
                ->find($id);

            if (!$detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Détail non trouvé'
                ], 404);
            }

            if (!$detail->file) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun fichier attaché'
                ], 404);
            }

            // Vérifier si le fichier existe
            if (!Storage::disk('public')->exists($detail->file)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fichier introuvable sur le serveur'
                ], 404);
            }

            // Déterminer le nom du fichier pour téléchargement
            $extension = pathinfo($detail->file, PATHINFO_EXTENSION);
            $downloadName = $detail->nom . '.' . $extension;
            
            // Ajouter des headers pour un meilleur contrôle
            $headers = [
                'Content-Type' => Storage::disk('public')->mimeType($detail->file),
                'Content-Disposition' => 'attachment; filename="' . $downloadName . '"',
            ];

            // Retourner le fichier
            return Storage::disk('public')->download($detail->file, $downloadName, $headers);

        } catch (\Exception $e) {
           // \Log::error('Erreur téléchargement fichier: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur lors du téléchargement'
            ], 500);
        }
    }







    /**
     * View file (get file content info)
     * GET /api/v1/projets/{projetId}/details/{id}/view
     */
    public function view($projetId, $id)
    {
        try {
            // Vérifier que le projet existe
            $projet = ProjetDemare::find($projetId);
            
            if (!$projet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Projet non trouvé',
                    'data' => null
                ], 404);
            }

            $detail = ProjetDemareDetaille::where('id_projet_demare', $projetId)
                ->find($id);

            if (!$detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Détail non trouvé',
                    'data' => null
                ], 404);
            }

            if (!$detail->file || !Storage::disk('public')->exists($detail->file)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fichier non trouvé',
                    'data' => null
                ], 404);
            }

            // Informations sur le fichier
            $fileInfo = [
                'url' => Storage::disk('public')->url($detail->file),
                'filename' => basename($detail->file),
                'original_name' => $detail->nom,
                'mime_type' => Storage::disk('public')->mimeType($detail->file),
                'size' => Storage::disk('public')->size($detail->file),
                'size_human' => $this->formatBytes(Storage::disk('public')->size($detail->file)),
                'created_at' => $detail->created_at,
                'updated_at' => $detail->updated_at
            ];

            return response()->json([
                'success' => true,
                'message' => 'Informations sur le fichier',
                'data' => $fileInfo
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des informations du fichier',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper function to format bytes
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Search details within a project
     * GET /api/v1/projets/{projetId}/details/search/{term}
     */
    public function search($projetId, $term)
    {
        try {
            // Vérifier que le projet existe
            $projet = ProjetDemare::find($projetId);
            
            if (!$projet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Projet non trouvé',
                    'data' => null
                ], 404);
            }

            $details = ProjetDemareDetaille::where('id_projet_demare', $projetId)
                ->where(function ($query) use ($term) {
                    $query->where('nom', 'like', '%' . $term . '%')
                          ->orWhere('description', 'like', '%' . $term . '%');
                })
                ->orderBy('id', 'desc')
                ->paginate(request('per_page', 15));

            return response()->json([
                'success' => true,
                'message' => 'Recherche effectuée avec succès',
                'data' => [
                    'projet' => $projet,
                    'details' => $details->items(),
                    'pagination' => [
                        'current_page' => $details->currentPage(),
                        'last_page' => $details->lastPage(),
                        'per_page' => $details->perPage(),
                        'total' => $details->total(),
                        'from' => $details->firstItem(),
                        'to' => $details->lastItem()
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}