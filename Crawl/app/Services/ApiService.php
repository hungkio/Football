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

    public function crawlFixtures($date)
    {
        $response = $this->client->request('GET', 'fixtures', [
            'headers' => [
                'X-RapidAPI-Key' => config('app.rapid_api_key'),
                'X-RapidAPI-Host' => 'api-football-v1.p.rapidapi.com',
                'Accept'        => 'application/json',
            ],
            'query' => [
                'date' => $date,
                'timezone' => 'Asia/Ho_Chi_Minh'
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody(), true);
        }

        return null;
    }

    public function crawlLiveFixtures()
    {
        $response = $this->client->request('GET', 'fixtures', [
            'headers' => [
                'X-RapidAPI-Key' => config('app.rapid_api_key'),
                'X-RapidAPI-Host' => 'api-football-v1.p.rapidapi.com',
                'Accept'        => 'application/json',
            ],
            'query' => [
                'live' => 'all',
                'timezone' => 'Asia/Ho_Chi_Minh'
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody(), true);
        }

        return null;
    }

    public function crawlTeams($league, $season)
    {
        $response = $this->client->request('GET', 'teams', [
            'headers' => [
                'X-RapidAPI-Key' => config('app.rapid_api_key'),
                'X-RapidAPI-Host' => 'api-football-v1.p.rapidapi.com',
                'Accept'        => 'application/json',
            ],
            'query' => [
                'league' => $league,
                'season' => $season,
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody(), true);
        }

        return null;
    }
}
