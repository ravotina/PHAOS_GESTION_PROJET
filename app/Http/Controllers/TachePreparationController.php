<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UtilisateurConcernerController;
use App\Models\UtilisateurConcerner;
use App\Models\Preparation;

class TachePreparationController extends Controller
{
    // public function show($id)
    // {
    //     $userId = session('user.id');
        
    //     // Récupérer la tâche/notification
    //     $notification = Notification::where('id', $id)
    //         ->where('id_utilisateur', $userId)
    //         ->first();

    //    // selectionner la tâche spécifique d' utilisateur concerner

    //    // ⭐⭐ RÉCUPÉRER LA TÂCHE SPÉCIFIQUE DE utilisateur_concerner AVEC id_table_source ⭐⭐
    //     $tacheConcerner = null;
        
    //     if ($notification->id_table_source && $notification->table_source === 'calendrier_preparation') {  // id_table_source
    //         $tacheConcerner = UtilisateurConcerner::where('id_calandrier', $notification->id_table_source)
    //             ->where('id_utilsateur', $userId)
    //             ->first();
    //     }
        
    //     if (!$notification) {
    //         abort(404, 'Tâche non trouvée');
    //     }
        
    //     return view('TachePreparation.index', [
    //         'tache' => $notification,
    //         'tacheConcerner' => $tacheConcerner
    //     ]);
    // }


    public function show($id)
    {
        $userId = session('user.id');
        
        // Récupérer la notification
        $notification = Notification::where('id', $id)
            ->where('id_utilisateur', $userId)
            ->first();

        if (!$notification) {
            abort(404, 'Tâche non trouvée');
        }
        
        // Récupérer la tâche spécifique de utilisateur_concerner
        $tacheConcerner = null;
        
        if ($notification->id_table_source && $notification->table_source === 'calendrier_preparation') {
            $tacheConcerner = UtilisateurConcerner::where('id_calandrier', $notification->id_table_source)
                ->where('id_utilsateur', $userId)
                ->first();
        }
        
        // Vérifier si une préparation existe déjà pour cette tâche
        $preparation = null;
        if ($tacheConcerner) {
            $preparation = Preparation::where('id_utilisateur_concerner', $tacheConcerner->id)
                ->where('id_utilisateur', $userId)
                ->first();
        }
        
        return view('TachePreparation.index', [
            'tache' => $notification,
            'tacheConcerner' => $tacheConcerner,
            'preparation' => $preparation // ⭐⭐ AJOUTEZ CECI ⭐⭐
        ]);
    }
}

