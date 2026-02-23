<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\CalendrierPreparation;
use App\Models\UtilisateurConcerner;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $utilisateur;
    public $event;
    public $messagePersonnalise;
    public $projet;
    public $utilisateurs_concerner;

    /**
     * Create a new message instance.
     */
    public function __construct($utilisateur, $event, $messagePersonnalise = null , $projet, $utilisateurs_concerner)
    {
        $this->utilisateur = $utilisateur;
        $this->event = $event;
        $this->messagePersonnalise = $messagePersonnalise;
        $this->projet = $projet;
        $this->utilisateurs_concerner = $utilisateurs_concerner;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        \log::info('Envoi de l\'email de notification pour l\'utilisateur : ' .$this->utilisateurs_concerner);
       
        return $this->subject('[PHAOS]' . $this->projet->non_de_projet) // $this->event->title
                    ->view('emails.notification')
                    ->with([
                        'utilisateur' => $this->utilisateur,
                        'event' => $this->event,
                        'messagePersonnalise' => $this->messagePersonnalise,
                        'utilisateurs_concerner' => $this->utilisateurs_concerner,

                    ]);
    }

    public function render()
    {
        return view('emails.notification', [
            'utilisateur' => $this->utilisateur,
            'event' => $this->event,
            'messagePersonnalise' => $this->messagePersonnalise,
            'projet' => $this->projet,
            'utilisateurs_concerner' => $this->utilisateurs_concerner,
        ])->render();
    }
}