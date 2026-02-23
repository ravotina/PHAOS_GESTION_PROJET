<?php

namespace App\Services;

use App\Models\EmailLog;

class EmailLoggerService
{
    /**
     * Enregistrer un email envoyé
     */
    public function logEmail($data)
    {
        try {
            $contenuHtml = $data['contenu_html'] ?? '';
            
            // Si le contenu est un objet View, on le rend
            if ($contenuHtml instanceof \Illuminate\View\View) {
                $contenuHtml = $contenuHtml->render();
            }

            return EmailLog::create([
                'id_utilisateur' => $data['id_utilisateur'] ?? null,
                'email_destinataire' => $data['email_destinataire'],
                'sujet' => $data['sujet'] ?? 'Sans sujet',
                'contenu_html' => $contenuHtml,
                'donnees_envoyees' => $data['donnees_envoyees'] ?? null,
                'type_email' => $data['type_email'] ?? 'notification_tache',
                'statut' => $data['statut'] ?? 'en_attente',
                'erreur_message' => $data['erreur_message'] ?? null,
                'modele_source' => $data['modele_source'] ?? null,
                'id_source' => $data['id_source'] ?? null,
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'enregistrement du log email', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            return null;
        }
    }

    /**
     * Enregistrer un email envoyé avec succès
     */
    public function logEmailEnvoye($data)
    {
        $data['statut'] = 'envoye';
        return $this->logEmail($data);
    }

    /**
     * Enregistrer un email en erreur
     */
    public function logEmailErreur($data, $messageErreur)
    {
        $data['statut'] = 'erreur';
        $data['erreur_message'] = $messageErreur;
        return $this->logEmail($data);
    }

    /**
     * Récupérer les logs d'un utilisateur
     */
    public function getLogsByUser($userId, $limit = 10)
    {
        return EmailLog::where('id_utilisateur', $userId)
                      ->orderBy('created_at', 'desc')
                      ->limit($limit)
                      ->get();
    }

    /**
     * Récupérer les logs d'un événement
     */
    public function getLogsBySource($modele, $idSource)
    {
        return EmailLog::where('modele_source', $modele)
                      ->where('id_source', $idSource)
                      ->orderBy('created_at', 'desc')
                      ->get();
    }

    /**
     * Statistiques d'envoi d'emails
     */
    public function getStats()
    {
        return [
            'total' => EmailLog::count(),
            'envoyes' => EmailLog::where('statut', 'envoye')->count(),
            'erreurs' => EmailLog::where('statut', 'erreur')->count(),
            'en_attente' => EmailLog::where('statut', 'en_attente')->count(),
        ];
    }
}