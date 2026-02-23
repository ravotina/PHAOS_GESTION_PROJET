<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Token;

class ApiAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Récupérer le token de l'header
        $token = $request->header('X-Dolibarr-Token') ?? $request->bearerToken();
        
        if (!$token) {
            Log::warning('API Auth: Token manquant', [
                'ip' => $request->ip(),
                'url' => $request->url()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Token d\'authentification manquant'
            ], 401);
        }

        // Valider le token avec ton modèle Token
        $tokenModel = new Token();
        $userId = $tokenModel->getUserIdByToken($token);
        
        if (!$userId) {
            Log::warning('API Auth: Token invalide', [
                'ip' => $request->ip(),
                'token' => substr($token, 0, 20) . '...'
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Token invalide ou expiré'
            ], 401);
        }

        // Ajouter l'ID utilisateur à la requête pour y accéder dans les contrôleurs
        $request->merge(['api_user_id' => $userId]);
        
        Log::info('API Auth: Token validé', [
            'user_id' => $userId,
            'url' => $request->url()
        ]);

        return $next($request);
    }
}