<?php
// app/Http/Controllers/CalendrierController.php

namespace App\Http\Controllers;

use App\Models\CalendrierPreparation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\UtilisateurConcerner;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;
use App\Models\Projet;
use App\Services\EmailLoggerService;

use App\Models\User;


class CalendrierPreparationController extends Controller
{

    ///private $dolibarrClient;
    private $users;
    private $projets;
    private $utilisateursconcerner;
    protected $emailLogger;

    public function __construct()
    {

        //$this->dolibarrClient = new Client();
        $this->users = new User();
        $this->projets = new Projet();
        $this->utilisateursconcerner = new UtilisateurConcerner();
        $this->emailLogger = new EmailLoggerService();

    }

    /**
 * Récupérer les événements pour FullCalendar
 */
    public function getEvents(Request $request): JsonResponse
    {
        $start = $request->input('start');
        $end = $request->input('end');
        
        // Récupérer l'ID du projet depuis la requête
        $projetId = $request->input('projet_id');

        $query = CalendrierPreparation::with('projet');

        // Filtrer par projet spécifique si fourni
        if ($projetId) {
            $query->where('id_projet', $projetId);
        }

        // Filtrer par période si fournie
        if ($start && $end) {
            $query->where(function($q) use ($start, $end) {
                $q->whereBetween('date_debut', [$start, $end])
                ->orWhereBetween('date_fin', [$start, $end])
                ->orWhere(function($subQ) use ($start, $end) {
                    $subQ->where('date_debut', '<=', $start)
                        ->where('date_fin', '>=', $end);
                });
            });
        }

        $events = $query->get()
            ->map(function ($event) {

                // FORMAT DATETIME pour FullCalendar
                $start = $event->date_debut->toIso8601String(); // Format ISO avec timezone
                
                // Pour la date de fin, on utilise le format datetime
                $end = $event->date_fin 
                    ? $event->date_fin->toIso8601String() 
                    : null;
                    

                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $start,
                    'end' => $end,
                    'color' => $event->color,
                    'description' => $event->decription,
                    'extendedProps' => [
                        'description' => $event->decription,
                        'projet' => $event->projet->nom ?? 'N/A'
                    ]
                ];
            });

        // \Log::info('Événements retournés:', [
        //     'count' => $events->count(),
        //     'events' => $events->toArray()
        // ]);

        return response()->json($events);
    }


    /**
     * Créer un nouvel événement
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:250',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'decription' => 'nullable|string',
            'color' => 'nullable|string|max:50',
            'id_projet' => 'required|exists:projet,id'
        ]);

        try {

            $id_user = null;
            if(Session::get('user.id')){
               $id_user = Session::get('user.id');

            } else{
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié.'
                ], 401);
            }

            // Convertir les dates en datetime si nécessaire
            $dateDebut = $request->date_debut;
            $dateFin = $request->date_fin;

            // Si ce sont des dates simples, ajouter l'heure
            if (strlen($dateDebut) === 10) { // Format YYYY-MM-DD
                $dateDebut .= ' 00:00:00';
            }
            if ($dateFin && strlen($dateFin) === 10) {
                $dateFin .= ' 23:59:59';
            }

            $event = CalendrierPreparation::create([
                'title' => $request->title,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'decription' => $request->decription,
                'color' => $request->color ?? $this->getRandomColor(),
                'utilisateur_id' =>  $id_user,
                'id_projet' => $request->id_projet
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Événement créé avec succès',
                'event' => $event
            ]);

        } catch (\Exception $e) {

            \Log::info($e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour un événement
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:250',
            'date_debut' => 'sometimes|required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'decription' => 'nullable|string',
            'color' => 'nullable|string|max:50'
        ]);

        try {
            $event = CalendrierPreparation::findOrFail($id);
            
            $event->update($request->only([
                'title', 'date_debut', 'date_fin', 'decription', 'color'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Événement mis à jour avec succès',
                'event' => $event
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un événement
     */

    public function destroy($id): JsonResponse
    {
        try {
            $event = CalendrierPreparation::findOrFail($id);
            $event->delete();

            return response()->json([
                'success' => true,
                'message' => 'Événement supprimé avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Générer une couleur aléatoire
     */
    private function getRandomColor(): string
    {
        $colors = [
            '#3788d8', '#28a745', '#dc3545', '#ffc107', 
            '#6f42c1', '#fd7e14', '#20c997', '#e83e8c'
        ];
        
        return $colors[array_rand($colors)];
    }







    public function notifierUtilisateurs(Request $request, $id): JsonResponse
    {
        try {
            $event = CalendrierPreparation::findOrFail($id);
            $message = $request->input('message');

            $id_projet = $request->input('projetId');
            $projet = $this->projets->getById((int) $id_projet);
            
            // Récupérer les utilisateurs concernés
            $utilisateurs = UtilisateurConcerner::where('id_calandrier', $id)->get();
            
            $notifiedCount = 0;
            $emailSentCount = 0;
            $emailLogs = [];

            // AFFICHER TOUTES LES DONNÉES DANS LES LOGS
            foreach ($utilisateurs as $affectation) {
                // Créer la notification dans la table

                $detaille_user = $this->users->getById($affectation->id_utilsateur);

                $utilisateurs_concerner = $this->utilisateursconcerner->findByIdCalendrierAndUtilisateur($id, $affectation->id_utilsateur);


                Notification::create([
                    'id_utilisateur' => $affectation->id_utilsateur,
                    'gmail_utilisateur' => $detaille_user['email'] ?? null,
                    'table_source' => 'calendrier_preparation',
                    'date_heur_notification' => now(),
                    'titre' => 'Nouvelle tâche : ' . substr($event->title, 0, 45),
                    'date_debu' => $event->date_debut ? Carbon::parse($event->date_debut)->toDateString() : null,
                    'date_fin' => $event->date_fin ? Carbon::parse($event->date_fin)->toDateString() : null,
                    'description' => substr($event->decription, 0, 47),
                    'etat' => 0,
                    'id_table_source' => $id,
                ]);


                    // ENVOYER L'EMAIL VIA GMAIL (version avec Mailable)
                if ( $detaille_user['email'] != null && filter_var($detaille_user['email'], FILTER_VALIDATE_EMAIL)) {

                    \Log::info('Envoi email à : ' . $detaille_user['email']);
                    \Log::info('Détails utilisateur: ' . json_encode($detaille_user));


                    try {

                        $mailInstance = new \App\Mail\NotificationMail(
                            $detaille_user,
                            $event,
                            $message, 
                            $projet,
                            $utilisateurs_concerner
                        );

                        Mail::to($detaille_user['email'])
                            ->send(new \App\Mail\NotificationMail(
                                $detaille_user,
                                $event,
                                $message, 
                                $projet,
                                $utilisateurs_concerner
                            ));

                        // Enregistrer dans email_logs si la table existe
                        //if (\Schema::hasTable('email_logs')) {
                            $emailLog = \App\Models\EmailLog::create([
                                'id_utilisateur' => $affectation->id_utilsateur,
                                'email_destinataire' => $detaille_user['email'],
                                'sujet' => '[PHAOS] ' . ($projet->non_de_projet ?? 'Nouvelle tâche'),
                                'contenu_html' => $mailInstance->render(),
                                'donnees_envoyees' => json_encode([
                                    'utilisateur_id' => $affectation->id_utilsateur,
                                    'event_id' => $event->id,
                                    'event_title' => $event->title,
                                    'projet_id' => $projet->id ?? null,
                                    'projet_nom' => $projet->non_de_projet ?? null,
                                    'message_personnalise' => $message,
                                    'tache_description' => $utilisateurs_concerner ? $utilisateurs_concerner->description_tache : null,
                                    'date_envoi' => now()->toDateTimeString(),
                                ]),
                                'type_email' => 'notification_tache',
                                'statut' => 'en_attente',
                                'modele_source' => 'calendrier_preparation',
                                'id_source' => $id,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                            
                            $logId = $emailLog->id;
                        //} else {
                           // $logId = null;
                           // \Log::info('Table email_logs non trouvée, création de la table recommandée');
                        //}
                        
                        $emailSentCount++;
                        
                    } catch (\Exception $emailException) {
                        \Log::error('Erreur envoi email', [
                            'email' => $detaille_user['email'],
                            'error' => $emailException->getMessage()
                        ]);
                    }
                }

                $notifiedCount++;
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Notifications envoyées',
                'notifications_crees' => $notifiedCount,
                'emails_envoyes' => $emailSentCount,
                'event' => $event->title
            ]);
            
        } catch (\Exception $e) {

            \Log::error('Erreur dans notifierUtilisateurs: ' . $e->getMessage());

            \Log::error('Erreur lors de la notification des utilisateurs', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }






    /**
     * Récupérer les logs d'emails pour un événement
     */
    public function getEmailLogsByEvent($eventId): JsonResponse
    {
        try {
            $logs = $this->emailLogger->getLogsBySource('calendrier_preparation', $eventId);
            
            return response()->json([
                'success' => true,
                'logs' => $logs,
                'total' => $logs->count()
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Erreur récupération logs emails: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Statistiques des emails
     */
    public function getEmailStats(): JsonResponse
    {
        try {
            $stats = $this->emailLogger->getStats();
            
            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Erreur récupération stats emails: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }

}
