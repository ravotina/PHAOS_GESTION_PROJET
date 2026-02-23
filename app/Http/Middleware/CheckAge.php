<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupère l'âge depuis l'URL (ex: /club?age=20)
        $age = $request->query('age');
        
        // Si l'âge n'est pas fourni ou < 18
        if (!$age || $age < 18) {
            return redirect('/too-young');
        }
        
        // Si OK, continue vers le controller
        return $next($request);
    }
}
