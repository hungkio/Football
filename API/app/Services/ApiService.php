<?php

namespace App\Services;

use GuzzleHttp\Client;

class ApiService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api-football-v1.p.rapidapi.com/v3/',
        ]);
    }

    public function crawlHead2Head($h2h){
        $response = $this->client->request('GET', 'fixtures/headtohead', [
            'headers' => [
                'X-RapidAPI-Key' => config('app.rapid_api_key'),
                'X-RapidAPI-Host' => 'api-football-v1.p.rapidapi.com',
                'Accept'        => 'application/json',
            ],
            'query' => [
                'h2h' => $h2h,
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody(), true);
        }

        return null;
    }
}
