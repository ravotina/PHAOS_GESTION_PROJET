<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ProjetApiController;
use App\Http\Controllers\Api\ProjetDetailApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    // Routes API d'authentification
    Route::post('/debug-login', [AuthApiController::class, 'testDolibarrLogin']);
    Route::post('/login', [AuthApiController::class, 'login']);
    // Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/user', [AuthApiController::class, 'getUser']);
    // Route::get('/test', [AuthApiController::class, 'test']);
    // Route::get('/health', [AuthApiController::class, 'health']);
    // Route::post('/validate-token', [AuthApiController::class, 'validateToken']);
    
    // Route pour tester l'authentification avec token
    Route::middleware('api.auth')->group(function () {
        Route::get('/protected', function () {
            return response()->json([
                'success' => true,
                'message' => 'Route protégée accessible'
            ]);
        });
    });


    // Routes pour les projets
    Route::prefix('projets')->group(function () {
        // Récupérer tous les projets
        Route::get('/', [ProjetApiController::class, 'index']);
        
        // Créer un projet
        Route::post('/', [ProjetApiController::class, 'store']);
        
        // Récupérer un projet spécifique
        Route::get('/{id}', [ProjetApiController::class, 'show']);
        
        // Mettre à jour un projet
        Route::put('/{id}', [ProjetApiController::class, 'update']);
        
        // Supprimer un projet
        Route::delete('/{id}', [ProjetApiController::class, 'destroy']);
        
        // Routes pour les données nécessaires au formulaire
        Route::get('/form-data', [ProjetApiController::class, 'getFormData']);
        
        // Rechercher des projets
        Route::get('/search/{term}', [ProjetApiController::class, 'search']);

         Route::prefix('{projetId}/details')->group(function () {
            Route::get('/', [ProjetDetailApiController::class, 'index']);
            Route::post('/', [ProjetDetailApiController::class, 'store']);
            Route::get('/{id}', [ProjetDetailApiController::class, 'show']);
            Route::put('/{id}', [ProjetDetailApiController::class, 'update']);
            Route::delete('/{id}', [ProjetDetailApiController::class, 'destroy']);
            // Info du fichier (JSON)
            Route::get('/{id}/file-info', [ProjetDetailApiController::class, 'getFileInfo']);
            Route::get('/{id}/download', [ProjetDetailApiController::class, 'download']);
            Route::get('/{id}/view', [ProjetDetailApiController::class, 'view']); 
            Route::get('/search/{term}', [ProjetDetailApiController::class, 'search']);
            Route::get('/search1/{term}', [ProjetDetailApiController::class, 'search']);
        });
        
    });
    
    // Routes pour les types de projet
    Route::get('/types-projet', [ProjetApiController::class, 'getTypesProjet']);
    
    // Routes pour les clients
    Route::get('/clients', [ProjetApiController::class, 'getClients']);
    
    // Routes pour les utilisateurs
    Route::get('/utilisateurs', [ProjetApiController::class, 'getUtilisateurs']);

});

// Route fallback pour API
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Route API non trouvée'
    ], 404);
});
