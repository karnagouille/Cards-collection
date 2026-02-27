<?php 

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ScryfallService {

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
    $this->client = $client;
    }

    public function findcard(string $id): array
    {
         // On récupére l'API
        $url = 'https://api.scryfall.com/cards/' . $id;

        $response = $this->client->request('GET',$url);

        return $response->toArray();
    }

}