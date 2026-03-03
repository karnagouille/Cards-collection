<?php 

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ScryfallService {

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
    $this->client = $client;
    }




public function findcard(string $name): ?array
{
    try {
        $response = $this->client->request('GET', 'https://api.scryfall.com/cards/named', [
            'query' => ['exact' => $name]
        ]);

        return $response->toArray();
    } catch (ClientExceptionInterface $e) {
        return null;
    }
}




public function findAllEditions(string $name): array
{
    try {
        // 1️⃣ On récupère la carte pour avoir l'oracle_id
        $card = $this->client->request('GET', 'https://api.scryfall.com/cards/named', [
            'query' => [
                'exact' => $name
            ]
        ])->toArray();

        $oracleId = $card['oracle_id'];

        // 2️⃣ On récupère toutes les impressions
        $response = $this->client->request('GET', 'https://api.scryfall.com/cards/search', [
            'query' => [
                'q' => 'oracleid:'.$oracleId,
                'unique' => 'prints'
            ]
        ]);

        $data = $response->toArray();

        $editions = [];

        foreach ($data['data'] as $card) {
            $label = $card['set_name'].' - #'.$card['collector_number'];
            $editions[$label] = $card['id'];
        }

        return $editions;

    } catch (ClientExceptionInterface $e) {
        return []; // 👈 si la carte n'existe pas
    }
}

}