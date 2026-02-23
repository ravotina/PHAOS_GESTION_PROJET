<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

class Client
{
    private $dolibarrUrl;

    public function __construct()
    {
        $this->dolibarrUrl = env('DOLIBARR_URL') . 'index.php';
    }

    /**
     * Récupérer le token admin depuis la base de données
     */
    private function getAdminToken()
    {
        try {
            $result = DB::connection('pgsql')->select("
                SELECT token 
                FROM token_user 
                WHERE id_user = 1
                LIMIT 1
            ");

            return $result ? $result[0]->token : null;

        } catch (Exception $e) {
            Log::error('Erreur getAdminToken: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Récupérer tous les clients
     */
    public function getAllClients()
    {
        // try {
        //     $token = $this->getAdminToken();
            
        //     if (!$token) {
        //         Log::error('Token admin non trouvé');
        //         return $this->getEmptyClientsResponse();
        //     }

        //     Log::info('Tentative de récupération des clients Dolibarr');

        //     $response = Http::timeout(30)->withHeaders([
        //         'DOLAPIKEY' => $token,
        //         'Content-Type' => 'application/json'
        //     ])->get($this->dolibarrUrl . "/thirdparties", [
        //         'client' => 1           // ← Changé ici
        //     ]);

        //     if ($response->successful()) {
        //         $clientsData = $response->json();
        //         Log::info('Clients récupérés avec succès: ' . count($clientsData['thirdparties'] ?? []) . ' trouvés');
                
        //         return $this->formatClients($clientsData);
        //     } else {
        //         Log::warning('Erreur récupération clients - Statut: ' . $response->status());
        //         return $this->getEmptyClientsResponse();
        //     }

        // } catch (Exception $e) {
        //     Log::error('Erreur récupération clients: ' . $e->getMessage());
        //     return $this->getEmptyClientsResponse();
        // }

        try {
            $token = $this->getAdminToken();
            
            if (!$token) {
                return ['formatted' => ['clients' => []]];  // Structure cohérente
            }

            $response = Http::timeout(30)->withHeaders([
                'DOLAPIKEY' => $token,
                'Content-Type' => 'application/json'
            ])->get($this->dolibarrUrl . "/thirdparties", [
                'client' => 1
            ]);

            if ($response->successful()) {
                $clients = $response->json();
                
                // Retourner directement la structure attendue
                return [
                    'formatted' => [
                        'clients' => $clients
                    ]
                ];
            } else {
                return ['formatted' => ['clients' => []]];
            }

        } catch (Exception $e) {
            return ['formatted' => ['clients' => []]];
        }
    }

    /**
     * Récupérer un client spécifique par ID
     */
    public function getClientById($clientId)
    {
        try {
            $token = $this->getAdminToken();
            
            if (!$token) {
                return null;
            }

            $response = Http::timeout(30)->withHeaders([
                'DOLAPIKEY' => $token,
                'Content-Type' => 'application/json'
            ])->get($this->dolibarrUrl . "/thirdparties/{$clientId}");

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::warning('Client non trouvé - ID: ' . $clientId . ' - Statut: ' . $response->status());
                return null;
            }

        } catch (Exception $e) {
            Log::error('Erreur récupération client ID ' . $clientId . ': ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Rechercher des clients par nom
     */
    public function searchClientsByName($name, $limit = 50)
    {
        try {
            $token = $this->getAdminToken();
            
            if (!$token) {
                return $this->getEmptyClientsResponse();
            }

            $response = Http::timeout(30)->withHeaders([
                'DOLAPIKEY' => $token,
                'Content-Type' => 'application/json'
            ])->get($this->dolibarrUrl . "/thirdparties", [
                'sqlfilters' => "t.client=1 AND t.name LIKE '%{$name}%'",
                'limit' => $limit
            ]);

            if ($response->successful()) {
                $clientsData = $response->json();
                return $this->formatClients($clientsData);
            } else {
                return $this->getEmptyClientsResponse();
            }

        } catch (Exception $e) {
            Log::error('Erreur recherche clients: ' . $e->getMessage());
            return $this->getEmptyClientsResponse();
        }
    }

    /**
     * Formater les données clients
     */
    private function formatClients($clientsData)
    {
        $clients = $clientsData['thirdparties'] ?? [];
        
        $formatted = [
            'raw_data' => $clientsData,
            'formatted' => [
                'clients' => [],
                'summary' => [
                    'total_clients' => count($clients),
                    'clients_with_email' => 0,
                    'clients_with_phone' => 0,
                    'cities' => []
                ]
            ]
        ];

        foreach ($clients as $client) {
            $formattedClient = [
                'id' => $client['id'] ?? null,
                'name' => $client['name'] ?? 'N/A',
                'name_alias' => $client['name_alias'] ?? null,
                'code_client' => $client['code_client'] ?? null,
                'email' => $client['email'] ?? null,
                'phone' => $client['phone'] ?? null,
                'address' => $client['address'] ?? null,
                'zip' => $client['zip'] ?? null,
                'town' => $client['town'] ?? null,
                'country_code' => $client['country_code'] ?? null,
                'status' => $client['status'] ?? null,
                'date_creation' => $client['date_creation'] ?? null,
                'date_creation_formatted' => $this->formatTimestamp($client['date_creation'] ?? null)
            ];

            $formatted['formatted']['clients'][] = $formattedClient;

            // Statistiques
            if (!empty($client['email'])) {
                $formatted['formatted']['summary']['clients_with_email']++;
            }
            if (!empty($client['phone'])) {
                $formatted['formatted']['summary']['clients_with_phone']++;
            }
            if (!empty($client['town'])) {
                $formatted['formatted']['summary']['cities'][] = $client['town'];
            }
        }

        // Dédupliquer les villes
        $formatted['formatted']['summary']['cities'] = array_unique($formatted['formatted']['summary']['cities']);
        $formatted['formatted']['summary']['cities_count'] = count($formatted['formatted']['summary']['cities']);

        return $formatted;
    }

    /**
     * Formater le timestamp
     */
    private function formatTimestamp($timestamp)
    {
        if (!$timestamp) {
            return null;
        }

        return date('d/m/Y H:i', $timestamp);
    }

    /**
     * Retourne une structure vide pour les clients
     */
    private function getEmptyClientsResponse()
    {
        return [
            'raw_data' => [],
            'formatted' => [
                'clients' => [],
                'summary' => [
                    'total_clients' => 0,
                    'clients_with_email' => 0,
                    'clients_with_phone' => 0,
                    'cities' => [],
                    'cities_count' => 0
                ]
            ]
        ];
    }

    /**
     * Vérifier si un client existe par son code
     */
    public function clientExistsByCode($clientCode)
    {
        $clients = $this->getAllClients(1000); // Augmenter la limite pour la recherche
        
        foreach ($clients['formatted']['clients'] as $client) {
            if ($client['code_client'] === $clientCode) {
                return true;
            }
        }
        
        return false;
    }
}