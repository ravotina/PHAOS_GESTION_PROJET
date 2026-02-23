<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProduitController; // Import du contrôleur
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjetControlleur;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\TypeProjetController;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\AdminControlleur;

use App\Http\Controllers\ProjetDetailController;

use App\Http\Controllers\AFaireController;

use App\Http\Controllers\CalendrierPreparationController;

use App\Http\Controllers\UtilisateurConcernerController;

use App\Http\Controllers\NotificationController;

use App\Http\Controllers\TachePreparationController;

use App\Http\Controllers\PreparationController;

use App\Http\Controllers\VuePreparationsController;

use App\Http\Controllers\LancementProjetController;
use App\Http\Controllers\LancementProjetDetailController;

use App\Http\Controllers\EmploiDuTempsController;
use App\Http\Controllers\ModuleAffecterController;

use App\Http\Controllers\ProjectTravaillerController;

use App\Http\Controllers\WorkflowValidationController;

use App\Http\Controllers\ProjetTravaillerDetailController;

use App\Http\Controllers\EtapeValidationController;

use App\Http\Controllers\CategorieController;   

use App\Http\Controllers\TypeInterventionController;

use App\Http\Controllers\ParametreController;

use App\Http\Controllers\InterlocuteurClientController;

use App\Http\Controllers\ThemeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('/test-api', [AuthController::class, 'testApi']);
Route::get('/tableau_de_bord', [ProjetController::class, 'indexdashboard']);
Route::get('/projet/creation', [ProjetControlleur::class, 'insert']);
Route::get('/projet/detaille', [ProjetControlleur::class, 'detaille']);


// Routes pour les projets
Route::get('/projets', [ProjetController::class, 'index'])->name('projets.index');
Route::get('/projet/create', [ProjetController::class, 'create'])->name('projets.create');
Route::post('/projet/store', [ProjetController::class, 'store'])->name('projets.store');
Route::get('/projet/{id}', [ProjetController::class, 'show'])->name('projets.show');
Route::get('/projet/{id}/edit', [ProjetController::class, 'edit'])->name('projets.edit');
Route::put('/projet/{id}', [ProjetController::class, 'update'])->name('projets.update');
Route::delete('/projet/{id}', [ProjetController::class, 'destroy'])->name('projets.destroy');
Route::post('/projet/{id}/toggle-active', [ProjetController::class, 'toggleActive'])->name('projets.toggle-active');


// Projets
Route::resource('projets', ProjetController::class);
Route::get('projets/user/{userId}', [ProjetController::class, 'byUser'])->name('projets.by-user');
Route::get('projets/client/{clientId}', [ProjetController::class, 'byClient'])->name('projets.by-client');
Route::get('projets/search', [ProjetController::class, 'search'])->name('projets.search');

// Types de projet
Route::resource('type-projets', TypeProjetController::class)->except(['show']);

// API
Route::get('/api/types-projet', [TypeProjetController::class, 'apiIndex'])->name('api.types-projet');
Route::get('/api/clients', [ProjetController::class, 'apiClients'])->name('api.clients');


// Routes pour les détails des projets
Route::prefix('projets/{projet}/details')->name('projet.details.')->group(function () {
    Route::get('/', [ProjetDetailController::class, 'index'])->name('index');
    Route::get('/create', [ProjetDetailController::class, 'create'])->name('create');
    Route::post('/', [ProjetDetailController::class, 'store'])->name('store');
    Route::get('/{detail}/edit', [ProjetDetailController::class, 'edit'])->name('edit');
    Route::put('/{detail}', [ProjetDetailController::class, 'update'])->name('update');
    Route::delete('/{detail}', [ProjetDetailController::class, 'destroy'])->name('destroy');
    Route::get('/{detail}/download', [ProjetDetailController::class, 'download'])->name('download');
});


Route::resource('a_faire', AFaireController::class);
Route::get('/a_faire/search', [AFaireController::class, 'search'])->name('a_faire.search');

// Routes pour les détails des projets
Route::prefix('Administration')->name('administration.')->group(function () {
    Route::get('/', [AdminControlleur::class, 'index'])->name('index');
    Route::get('/workflow/Projet', [AdminControlleur::class, 'workflowProjet'])->name('workflowdemarrage');
    Route::post('/workflow/Projet', [AdminControlleur::class, 'store'])->name('workflowdemarrage');
    Route::get('/workflow/Projet/Affaire/config/liste', [AdminControlleur::class, 'liste_a_faire'])->name('liste_a_faire');
    Route::put('/workflow/Projet/Affaire/config/search', [AdminControlleur::class, 'search'])->name('liste_a_faire.search'); 
    Route::put('/workflow/Projet/Affaire/config/{id}/update', [AdminControlleur::class, 'update'])->name('workflowdemarrage.update');
    Route::get('/workflow/Projet/Affaire/config/{id}/edit', [AdminControlleur::class, 'edit'])->name('workflowdemarrage.edit');
    Route::delete('/workflow/Projet/Affaire/config/{id}/delete', [AdminControlleur::class, 'destroy'])->name('workflowdemarrage.destroy');
});


// routes/web.php
// Route::prefix('calendrier')->group(function () {
//     Route::get('/{id}' , [CalendrierPreparationController::class, 'showcalandrierpreparationProjet'])->name('calendrier.projet');
//     Route::get('/', [CalendrierPreparationController::class, 'index'])->name('calendrier.index');
//     Route::get('/events', [CalendrierPreparationController::class, 'getEvents'])->name('calendrier.events');
//     Route::post('/events', [CalendrierPreparationController::class, 'store'])->name('calendrier.store');
//     Route::put('/events/{id}', [CalendrierPreparationController::class, 'update'])->name('calendrier.update');
//     Route::delete('/events/{id}', [CalendrierPreparationController::class, 'destroy'])->name('calendrier.destroy');
// });




// routes/web.php
Route::prefix('calendrier')->group(function () {
    Route::get('/events', [CalendrierPreparationController::class, 'getEvents'])->name('calendrier.events');
    Route::post('/events', [CalendrierPreparationController::class, 'store'])->name('calendrier.store');
    Route::put('/events/{id}', [CalendrierPreparationController::class, 'update'])->name('calendrier.update');
    Route::delete('/events/{id}', [CalendrierPreparationController::class, 'destroy'])->name('calendrier.destroy');
    Route::get('/{id}', [CalendrierPreparationController::class, 'showcalandrierpreparationProjet'])->name('calendrier.projet');
    Route::get('/', [CalendrierPreparationController::class, 'index'])->name('calendrier.index');
    Route::post('/notifier/{id}', [CalendrierPreparationController::class, 'notifierUtilisateurs'])->name('calendrier.notifier');
});


// Ajouter ces routes dans votre fichier web.php

// Routes pour les utilisateurs concernés
Route::prefix('utilisateurs-concerner')->group(function () {
    Route::get('/disponibles', [UtilisateurConcernerController::class, 'getUtilisateursDisponibles']);
    Route::get('/calendrier/{calendrierId}', [UtilisateurConcernerController::class, 'getByCalendrier']);
    Route::post('/', [UtilisateurConcernerController::class, 'store']);
    Route::put('/{id}', [UtilisateurConcernerController::class, 'update']);
    Route::delete('/{id}', [UtilisateurConcernerController::class, 'destroy']);
});


// Routes pour les notifications
Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::get('/count', [NotificationController::class, 'count'])->name('notifications.count');
});


// Routes pour les préparations
Route::prefix('preparations')->name('preparations.')->group(function () {
    Route::get('/', [PreparationController::class, 'index'])->name('index');
    Route::get('/create', [PreparationController::class, 'create'])->name('create');
    Route::post('/', [PreparationController::class, 'store'])->name('store');
    Route::get('/{id}', [PreparationController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [PreparationController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PreparationController::class, 'update'])->name('update');
    Route::delete('/{id}', [PreparationController::class, 'destroy'])->name('destroy');
    
    // Routes pour les détails
    // Route::get('/{id}/details', [PreparationController::class, 'getDetails'])->name('details');
    // Route::post('/details', [PreparationController::class, 'addDetail'])->name('details.store');
    // Route::delete('/details/{id}', [PreparationController::class, 'deleteDetail'])->name('details.destroy');

    // Routes pour les détails
    Route::get('/{id}/details', [PreparationController::class, 'getDetails'])->name('details');
    Route::post('/details', [PreparationController::class, 'addDetail'])->name('details.store');
    Route::get('/details/{id}/edit', [PreparationController::class, 'editDetail'])->name('details.edit');
    Route::put('/details/{id}', [PreparationController::class, 'updateDetail'])->name('details.update');
    Route::delete('/details/{id}', [PreparationController::class, 'deleteDetail'])->name('details.destroy');
    
    // Route pour obtenir les calendriers
    Route::get('/calendriers/{utilisateurConcernerId}', [PreparationController::class, 'getCalendriers'])->name('calendriers');
});

// Routes pour la vue des préparations
Route::prefix('vue-preparations')->name('vue-preparations.')->group(function () {
    Route::get('/', [VuePreparationsController::class, 'index'])->name('index');
    Route::get('/projet/{projetId}', [VuePreparationsController::class, 'byProjet'])->name('by-projet');
    Route::post('/search', [VuePreparationsController::class, 'search'])->name('search');
    Route::get('/download-file/{detailId}', [VuePreparationsController::class, 'downloadFile'])->name('download-file');
    Route::get('/export-csv', [VuePreparationsController::class, 'exportCsv'])->name('export-csv');
});

Route::get('/lancements', [LancementProjetController::class, 'index'])->name('lancement.all');

// Routes pour les lancements de projets
Route::prefix('projets/{projetDemareId}/lancements')->name('lancement.')->group(function () {
    Route::get('/', [LancementProjetController::class, 'index'])->name('index');
    Route::get('/create', [LancementProjetController::class, 'create'])->name('create');
    Route::post('/', [LancementProjetController::class, 'store'])->name('store');
    Route::get('/{id}', [LancementProjetController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [LancementProjetController::class, 'edit'])->name('edit');
    Route::put('/{id}', [LancementProjetController::class, 'update'])->name('update');
    Route::delete('/{id}', [LancementProjetController::class, 'destroy'])->name('destroy');
    
    // Routes pour les détails des lancements
    Route::prefix('/{lancementId}/details')->name('details.')->group(function () {
        Route::get('/', [LancementProjetDetailController::class, 'index'])->name('index');
        Route::get('/create', [LancementProjetDetailController::class, 'create'])->name('create');
        Route::post('/', [LancementProjetDetailController::class, 'store'])->name('store');
        Route::get('/{id}/download', [LancementProjetDetailController::class, 'download'])->name('download');
        Route::delete('/{id}', [LancementProjetDetailController::class, 'destroy'])->name('destroy');
    });
});



// Routes pour les emplois du temps
Route::prefix('projets/{projetDemareId}/lancements/{lancementId}/emplois-du-temps')->name('emploi-du-temps.')->group(function () {
    // Calendrier
    Route::get('/calendrier', [EmploiDuTempsController::class, 'show'])->name('calendrier');
    Route::get('/events', [EmploiDuTempsController::class, 'getEvents'])->name('events');
    
    // CRUD
    Route::get('/', [EmploiDuTempsController::class, 'index'])->name('index');
    Route::post('/', [EmploiDuTempsController::class, 'store'])->name('store');
    Route::put('/{id}', [EmploiDuTempsController::class, 'update'])->name('update');
    Route::delete('/{id}', [EmploiDuTempsController::class, 'destroy'])->name('destroy');
    // Dans le groupe emploi-du-temps
    Route::get('/{id}/edit', [EmploiDuTempsController::class, 'edit'])->name('edit');
});


// Route pour la vue globale des emplois du temps
Route::get('/emplois-du-temps/global', [EmploiDuTempsController::class, 'global'])->name('emploi-du-temps.global');

// Route pour les emplois d'un utilisateur
Route::get('/mes-emplois-du-temps', [EmploiDuTempsController::class, 'mesEmplois'])->name('emploi-du-temps.mes-emplois');

// Route pour voir les lancements d'un projet avec leurs emplois
Route::get('/projets/{projetDemareId}/lancements-avec-emplois', [EmploiDuTempsController::class, 'lancementsAvecEmplois'])->name('emploi-du-temps.projet');


// Routes pour les modules affecter (admin)
Route::prefix('modules-affecter')->name('modules-affecter.')->group(function () {
    Route::get('/', [ModuleAffecterController::class, 'index'])->name('index');
    Route::post('/', [ModuleAffecterController::class, 'store'])->name('store');
    Route::put('/{id}', [ModuleAffecterController::class, 'update'])->name('update');
    Route::delete('/{id}', [ModuleAffecterController::class, 'destroy'])->name('destroy');
});


Route::prefix('workflow-validation')->name('workflow-validation.')->group(function () {
    Route::get('/formulaire-workflow', [WorkflowValidationController::class, 'create'])->name('form');
    Route::post('/insertion-workflow', [WorkflowValidationController::class, 'store'])->name('create');
    // Route AJAX pour récupérer les étapes d'un projet
    Route::get('/project-steps/{projectId}', [WorkflowValidationController::class, 'getProjectSteps'])->name('project-steps');

    // Routes pour les préparations depuis une notification
    Route::get('/preparations/create/from-notification/{notificationId}', [PreparationController::class, 'createFromNotification'])->name('from-notification');

    Route::get('/formulaire-projet', [ProjectTravaillerController::class, 'create'])->name('tache.insert');
    Route::post('/insertion-projet', [ProjectTravaillerController::class, 'store'])->name('tache.store');

    Route::get('/organigramme', [WorkflowValidationController::class, 'organigramme'])->name('organigramme');
});

// Route pour ajouter un détail à une préparation
Route::get('/preparations/{id}/details/create', [PreparationController::class, 'createDetail'])->name('preparations.details.create');

// Routes pour les projets travaillés
Route::prefix('projet-travailler')->name('projet.travailler.')->group(function () {
    Route::get('/create', [ProjectTravaillerController::class, 'create'])->name('create');
    Route::post('/store', [ProjectTravaillerController::class, 'store'])->name('store');
    Route::get('/', [ProjectTravaillerController::class, 'index'])->name('index');
    Route::get('/{id}', [ProjectTravaillerController::class, 'show'])->name('show');

    // AJOUTEZ CETTE ROUTE POUR TÉLÉCHARGER LES FICHIERS
    Route::get('/{projectId}/details/{detailId}/download', [ProjectTravaillerController::class, 'downloadDetail'])->name('details.download');
});

// Routes pour les détails de fichiers
Route::prefix('projet-travailler-detail')->name('projet.travailler.detail.')->group(function () {
    Route::get('/{projetId}', [ProjetTravaillerDetailController::class, 'index'])->name('index');
    Route::get('/{projetId}/create', [ProjetTravaillerDetailController::class, 'create'])->name('create');
    Route::post('/{projetId}/store', [ProjetTravaillerDetailController::class, 'store'])->name('store');
    Route::get('/{projetId}/{id}/download', [ProjetTravaillerDetailController::class, 'download'])->name('download');
    Route::delete('/{projetId}/{id}', [ProjetTravaillerDetailController::class, 'destroy'])->name('destroy');
});


// Routes pour les validations d'étape
Route::prefix('validation')->name('validation.')->group(function () {
    Route::get('/', [EtapeValidationController::class, 'index'])->name('index');
    Route::get('/{id}', [EtapeValidationController::class, 'show'])->name('show');
    Route::post('/traiter/{id}', [EtapeValidationController::class, 'traiter'])->name('traiter');
    Route::post('/{id}/valider', [EtapeValidationController::class, 'valider'])->name('valider');
    Route::post('/{id}/rejeter', [EtapeValidationController::class, 'rejeter'])->name('rejeter');
    Route::get('/projet/{projectId}/historique', [EtapeValidationController::class, 'historiqueProjet'])->name('historique');
    Route::get('/{validationId}/download/{fileId}', [EtapeValidationController::class, 'downloadFile'])->name('download');
    Route::get('/projet/{id}', [EtapeValidationController::class, 'showProjet'])->name('show-projet');
    Route::post('/creer-premiere-etape/{project}', [EtapeValidationController::class, 'creerPremiereEtape'])->name('creer-premiere-etape');
    // Dans web.php
    Route::get('/projet-rejete/{id}', [EtapeValidationController::class, 'showProjetRejete'])->name('projet-rejete');
});


Route::resource('type-projet', TypeProjetController::class)->except(['show']);
Route::post('type-projet/search', [TypeProjetController::class, 'search'])->name('type-projet.search');
Route::get('type-projet/api/all', [TypeProjetController::class, 'apiAll'])->name('type-projet.api.all');

// Routes CRUD pour TypeIntervention
Route::resource('type-intervention', TypeInterventionController::class)->except(['show']);
Route::post('type-intervention/search', [TypeInterventionController::class, 'search'])->name('type-intervention.search');
Route::get('type-intervention/api/all', [TypeInterventionController::class, 'apiAll'])->name('type-intervention.api.all');

// Routes CRUD pour Categorie
Route::resource('categorie', CategorieController::class)->except(['show']);
Route::post('categorie/search', [CategorieController::class, 'search'])->name('categorie.search');
Route::get('categorie/api/all', [CategorieController::class, 'apiAll'])->name('categorie.api.all');

// Routes API pour un élément
Route::get('api/type-projet/{id}', [TypeProjetController::class, 'apiShow'])->name('api.type-projet.show');
Route::get('api/type-intervention/{id}', [TypeInterventionController::class, 'apiShow'])->name('api.type-intervention.show');
Route::get('api/categorie/{id}', [CategorieController::class, 'apiShow'])->name('api.categorie.show');



// Routes pour le paramétrage
Route::prefix('parametre')->group(function () {
    Route::get('/', [ParametreController::class, 'index'])->name('parametre.index');
    Route::get('/statistiques', [ParametreController::class, 'statistiques'])->name('parametre.statistiques');
    Route::get('/export', [ParametreController::class, 'export'])->name('parametre.export');
    Route::post('/import', [ParametreController::class, 'import'])->name('parametre.import');
    Route::post('/config/save', [ParametreController::class, 'saveConfig'])->name('parametre.config.save');
    Route::get('/config', [ParametreController::class, 'getConfig'])->name('parametre.config');
    
    // Routes API pour AJAX
    Route::get('/api/types-projet', [ParametreController::class, 'apiTypeProjet'])->name('parametre.api.types-projet');
    Route::get('/api/types-intervention', [ParametreController::class, 'apiTypeIntervention'])->name('parametre.api.types-intervention');
    Route::get('/api/categories', [ParametreController::class, 'apiCategorie'])->name('parametre.api.categories');
    Route::get('/search/types-projet', [ParametreController::class, 'searchTypeProjet'])->name('parametre.search.types-projet');
    Route::get('/search/types-intervention', [ParametreController::class, 'searchTypeIntervention'])->name('parametre.search.types-intervention');
    Route::get('/search/categories', [ParametreController::class, 'searchCategorie'])->name('parametre.search.categories');

    Route::get('/api/interlocuteurs', [ParametreController::class, 'apiInterlocuteurs'])->name('parametre.api.interlocuteurs');
    Route::get('/search/interlocuteurs', [ParametreController::class, 'searchInterlocuteurs'])->name('parametre.search.interlocuteurs');
    Route::post('/interlocuteur/save', [ParametreController::class, 'saveInterlocuteur'])->name('parametre.interlocuteur.save');
    Route::delete('/interlocuteur/{id}', [ParametreController::class, 'deleteInterlocuteur'])->name('parametre.interlocuteur.delete');

    // Nouvelle route pour la liste des projets
    Route::get('/api/projets/list', [ParametreController::class, 'apiProjetsList'])
        ->name('parametre.api.projets.list'); // ->middleware('permission:api.apikey');
    
    // Routes pour gérer les projets des interlocuteurs
    Route::post('/interlocuteur/{id}/projets/add', [ParametreController::class, 'addProjetToInterlocuteur'])
        ->name('parametre.interlocuteur.projets.add')->middleware('permission:api.apikey');
        
    Route::delete('/interlocuteur/{id}/projets/remove', [ParametreController::class, 'removeProjetFromInterlocuteur'])
        ->name('parametre.interlocuteur.projets.remove')->middleware('permission:api.apikey');
        
    // Route pour récupérer les projets d'un interlocuteur spécifique
    Route::get('/interlocuteur/{id}/projets', function($id) {
        try {
            $interlocuteur = \App\Models\Interlocuteur::with('projets')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $interlocuteur->projets
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de chargement'
            ], 500);
        }
    })->name('parametre.interlocuteur.projets.list')->middleware('permission:api.apikey');

})->middleware('permission:api.apikey');


// Dans web.php
Route::prefix('interlocuteurs')->group(function () {
    // // Route simple
    // Route::get('/client/{clientId}/simple', [InterlocuteurClientController::class, 'getByClientSimple'])
    //     ->name('interlocuteurs.client.simple');
    Route::get('/{id}/projets', [ParametreController::class, 'apiInterlocuteurProjets'])
        ->name('parametre.interlocuteur.projets');
    
    Route::post('/{id}/projets/add', [ParametreController::class, 'addProjetToInterlocuteur'])
        ->name('parametre.interlocuteur.projets.add');
    
    Route::post('/{id}/projets/remove', [ParametreController::class, 'removeProjetFromInterlocuteur'])
        ->name('parametre.interlocuteur.projets.remove');
    
    Route::post('/{id}/projets/sync', [ParametreController::class, 'syncInterlocuteurProjets'])
        ->name('parametre.interlocuteur.projets.sync');
    
    // Ou remplacez l'ancienne route
    Route::get('/client/{clientId}', [InterlocuteurClientController::class, 'getByClientSimple'])
        ->name('interlocuteurs.client');
});


// Routes pour les thèmes
Route::prefix('themes')->group(function () {
    Route::get('/', [ThemeController::class, 'index'])->name('themes.index');
    Route::get('/create', [ThemeController::class, 'create'])->name('themes.create');
    Route::post('/', [ThemeController::class, 'store'])->name('themes.store');
    Route::get('/{theme}', [ThemeController::class, 'show'])->name('themes.show');
    Route::get('/{theme}/edit', [ThemeController::class, 'edit'])->name('themes.edit');
    Route::put('/{theme}', [ThemeController::class, 'update'])->name('themes.update');
    Route::delete('/{theme}', [ThemeController::class, 'destroy'])->name('themes.destroy');
    
    Route::post('/{theme}/toggle', [ThemeController::class, 'toggle'])->name('themes.toggle');
});




// Routes pour les tâches
Route::prefix('taches')->group(function () {
    Route::get('/', [NotificationController::class, 'getTasks'])->name('taches.index');
    // Ajoutez cette route
    Route::get('/{id}', [TachePreparationController::class, 'show'])->name('tache.show');
});

// Pour la page HTML
Route::get('/mes-taches', function () {
    return view('TachePreparation.index');
})->name('taches.page');


// Routes API pour le chargement des données
// Route::get('/api/types-projet', [TypeProjetController::class, 'apiIndex'])->name('api.types-projet');
// Route::get('/api/clients', [ProjetController::class, 'apiClients'])->name('api.clients');

Route::get('/page_default', function () {
    return redirect('/tableau_de_bord');
});


// Page pour les mineurs
Route::get('/', function () {
    return redirect('/tableau_de_bord');
});

// Page pour les mineurs
Route::get('/too-young', function () {
    return "<h1>Désolé, tu es trop jeune pour accéder au club !</h1>";
});

// Page club (protégée par le middleware)
Route::get('/club', function () {
    return "<h1>Bienvenue au Club ! 🎉</h1>";
})->middleware('check.age');