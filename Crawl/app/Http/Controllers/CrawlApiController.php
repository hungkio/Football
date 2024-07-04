<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Fixture;
use App\Models\League;
use App\Models\LiveFixture;
use App\Models\LiveFixtures;
use App\Models\Team;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class CrawlApiController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function crawlFixtures()
    {
        $today = date('Y-m-d');
        $data = $this->apiService->crawlFixtures($today);
        if ($data) {
            foreach ($data['response'] as $item) {
                Fixture::updateOrInsert(
                    ['fixture' => json_encode($item['fixture'])],
                    [
                        'fixture' => json_encode($item['fixture']),
                        'league'     => json_encode($item['league']),
                        'teams'      => json_encode($item['teams']),
                        'goals'      => json_encode($item['goals']),
                        'score'      => json_encode($item['score']),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            return 'Data crawled and stored successfully.';
        } else {
            return 'Failed to fetch data from API.';
        }
    }

    public function crawlLiveFixtures()
    {
        LiveFixture::truncate();
        $data = $this->apiService->crawlLiveFixtures();
        if ($data) {
            foreach ($data['response'] as $item) {
                LiveFixtures::updateOrInsert(
                    ['fixture' => json_encode($item['fixture'])],
                    [
                        'fixture' => json_encode($item['fixture']),
                        'league'     => json_encode($item['league']),
                        'teams'      => json_encode($item['teams']),
                        'goals'      => json_encode($item['goals']),
                        'score'      => json_encode($item['score']),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            return 'Data crawled and stored successfully.';
        } else {
            return 'Failed to fetch data from API.';
        }
    }

    public function crawlTeams(Request $request){
        try {
            $league = $request->league;
            $season = $request->season;
            $data = $this->apiService->crawlTeams($league, $season);
            if ($data) {
                foreach ($data['response'] as $item) {
                    Team::updateOrInsert(
                        ['api_id' => $item['team']['id']],
                        [
                            'api_id'    => $item['team']['id'],
                            'name'      => $item['team']['name'],
                            'code'      => $item['team']['code'],
                            'country'   => $item['team']['country'],
                            'national'  => $item['team']['national'],
                            'logo'      => $item['team']['logo'],
                            'league_id' => $league,
                            'season'    => $season,
                        ]
                    );
                }
            }
            return 'Data crawled and stored successfully.';
        } catch (\Throwable $th) {
            return 'Failed to fetch data from API. ' . $th;
        }
    }

    public function crawlLeagues(){
        try {
            $data = $this->apiService->crawlLeagues();
            foreach ($data['response'] as $item) {
                League::updateOrInsert(
                    ['api_id' => $item['league']['id']],
                    [
                        'api_id'       => $item['league']['id'],
                        'name'         => $item['league']['name'],
                        'type'         => $item['league']['type'],
                        'logo'         => $item['league']['logo'],
                        'country_code' => $item['country']['code'],
                    ]
                );
                Country::updateOrInsert(
                    ['code' => $item['country']['code']],
                    [
                        'name'         => $item['country']['name'],
                        'code'         => $item['country']['code'],
                        'flag'         => $item['country']['flag'],
                    ]
                );
            }
            return 'Data crawled and stored successfully.';
        } catch (\Throwable $th) {
            return 'Failed to fetch data from API. ' . $th;
        }
    }

    public function crawlCountries(){
        try {
            $data = $this->apiService->crawlCountries();
            foreach ($data['response'] as $item) {
                Country::updateOrInsert(
                    ['code' => $item['code']],
                    [
                        'name'         => $item['name'],
                        'code'         => $item['code'],
                        'flag'         => $item['flag'],
                    ]
                );
            }
            return 'Data crawled and stored successfully.';
        } catch (\Throwable $th) {
            return 'Failed to fetch data from API. ' . $th;
        }
    }
}
