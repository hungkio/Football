<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrawlTeamsRequest;
use App\Models\Country;
use App\Models\Fixture;
use App\Models\League;
use App\Models\LiveFixture;
use App\Models\LiveFixtures;
use App\Models\Player;
use App\Models\PlayerStatistic;
use App\Models\Team;
use App\Services\ApiService;
use Carbon\Carbon;
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
        LiveFixtures::truncate();
        $data = $this->apiService->crawlLiveFixtures();
        if ($data) {
            foreach ($data['response'] as $item) {
                LiveFixtures::updateOrInsert(
                    ['fixture' => json_encode($item['fixture'])],
                    [
                        'fixture'    => json_encode($item['fixture']),
                        'league'     => json_encode($item['league']),
                        'teams'      => json_encode($item['teams']),
                        'goals'      => json_encode($item['goals']),
                        'score'      => json_encode($item['score']),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
                $page = 1;
                $totalPages = 1;
                while ($page <= $totalPages) {
                    foreach ($item['teams'] as $teamItem) {
                        $playerData = $this->apiService->crawlPlayersByTeam($teamItem['id'], $item['league']['season'], $page);
                        if ($playerData) {
                            foreach ($playerData['response'] as $playerItem){
                                Player::updateOrCreate(
                                    ['api_id' => $playerItem['player']['id']],
                                    [
                                        'api_id'         => $playerItem['player']['id'],
                                        'name'           => $playerItem['player']['name'],
                                        'first_name'     => $playerItem['player']['firstname'],
                                        'last_name'      => $playerItem['player']['lastname'],
                                        'age'            => $playerItem['player']['age'],
                                        'date_of_birth'  => $playerItem['player']['birth']['date'],
                                        'place_of_birth' => $playerItem['player']['birth']['place'],
                                        'country'        => $playerItem['player']['birth']['country'],
                                        'nationality'    => $playerItem['player']['nationality'],
                                        'height'         => $playerItem['player']['height'],
                                        'weight'         => $playerItem['player']['weight'],
                                        'injured'        => $playerItem['player']['injured'],
                                        'photo'          => $playerItem['player']['photo'],
                                    ]
                                );
                                foreach ($playerItem['statistics'] as $statistic) {
                                    PlayerStatistic::updateOrCreate(
                                        [
                                            'player_id'   => $playerItem['player']['id'],
                                            'team_id'     => $statistic['team']['id'],
                                            'league_id'   => $statistic['league']['id'],
                                            'season'      => $statistic['league']['season'],
                                        ],
                                        [
                                            'player_id'   => $playerItem['player']['id'],
                                            'team_id'     => $statistic['team']['id'],
                                            'league_id'   => $statistic['league']['id'],
                                            'season'      => $statistic['league']['season'],
                                            'games'       => $statistic['games'],
                                            'substitutes' => $statistic['substitutes'],
                                            'shots'       => $statistic['shots'],
                                            'goals'       => $statistic['goals'],
                                            'passes'      => $statistic['passes'],
                                            'tackles'     => $statistic['tackles'],
                                            'duels'       => $statistic['duels'],
                                            'dribbles'    => $statistic['dribbles'],
                                            'fouls'       => $statistic['fouls'],
                                            'cards'       => $statistic['cards'],
                                            'penalty'     => $statistic['penalty'],
                                        ]
                                    );
                                }
                            }
                        }
                        $totalPages = $playerData['paging']['total'];
                        $page++;
                    }
                }
            }

            return 'Data crawled and stored successfully.';
        } else {
            return 'Failed to fetch data from API.';
        }
    }

    public function crawlTeams(CrawlTeamsRequest $request){
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
                    [
                        'code' => $item['country']['code'],
                        'name' => $item['country']['name'],
                    ],
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
                    [
                        'name' => $item['name'],
                        'code' => $item['code'],
                    ],
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

    public function crawlTeamsCountries(){
        try {
            $data = $this->apiService->crawlTeamsCountries();
            foreach ($data['response'] as $item) {
                Country::updateOrInsert(
                    [
                        'code' => $item['code'],
                        'name' => $item['name']
                    ],
                    [
                        'name'         => $item['name'],
                        'code'         => $item['code'],
                        'flag'         => $item['flag'],
                        'from_team'    => 1
                    ]
                );
            }
            return 'Data crawled and stored successfully.';
        } catch (\Throwable $th) {
            return 'Failed to fetch data from API. ' . $th;
        }
    }

    public function crawlPlayersByLeague(Request $request){
        try {
            $league = $request->league;
            $season = $request->season;
            $page = 1;
            $totalPages = 1;
            while ($page <= $totalPages) {
                $data = $this->apiService->crawlPlayersByLeague($league, $season, $page);
                if ($data) {
                    foreach ($data['response'] as $item) {
                        Player::updateOrCreate(
                            ['api_id' => $item['player']['id']],
                            [
                                'api_id'         => $item['player']['id'],
                                'name'           => $item['player']['name'],
                                'first_name'     => $item['player']['firstname'],
                                'last_name'      => $item['player']['lastname'],
                                'age'            => $item['player']['age'],
                                'date_of_birth'  => $item['player']['birth']['date'],
                                'place_of_birth' => $item['player']['birth']['place'],
                                'country'        => $item['player']['birth']['country'],
                                'nationality'    => $item['player']['nationality'],
                                'height'         => $item['player']['height'],
                                'weight'         => $item['player']['weight'],
                                'injured'        => $item['player']['injured'],
                                'photo'          => $item['player']['photo'],
                            ]
                        );
                        foreach ($item['statistics'] as $statistic) {
                            PlayerStatistic::updateOrCreate(
                                [
                                    'player_id'   => $item['player']['id'],
                                    'team_id'     => $statistic['team']['id'],
                                    'league_id'   => $statistic['league']['id'],
                                    'season'      => $statistic['league']['season'],
                                ],
                                [
                                    'player_id'      => $item['player']['id'],
                                    'team_id'     => $statistic['team']['id'],
                                    'league_id'   => $statistic['league']['id'],
                                    'season'      => $statistic['league']['season'],
                                    'games'       => $statistic['games'],
                                    'substitutes' => $statistic['substitutes'],
                                    'shots'       => $statistic['shots'],
                                    'goals'       => $statistic['goals'],
                                    'passes'      => $statistic['passes'],
                                    'tackles'     => $statistic['tackles'],
                                    'duels'       => $statistic['duels'],
                                    'dribbles'    => $statistic['dribbles'],
                                    'fouls'       => $statistic['fouls'],
                                    'cards'       => $statistic['cards'],
                                    'penalty'     => $statistic['penalty'],
                                ]
                            );
                        }
                    }
                }
                $totalPages = $data['paging']['total'];
                $page++;
            }
            return 'Data crawled and stored successfully.';
        } catch (\Throwable $th) {
            return $th;
        }

    }

    public function crawlStandings(){
        try {
            $thisSeason = Carbon::now()->year;
            $leagues = League::all();
            foreach ($leagues as $league) {
                $data = $this->apiService->crawlStandings($league->api_id, $thisSeason);
                // dd($data['response'][0]['league']);
                foreach ($data['response'] as $groups) {
                    if (!$data['response'][0]) {
                        dd($data['response']);
                    }
                }
            }
            return 'Data crawled and stored successfully.';
        } catch (\Throwable $th) {
            return 'Failed to fetch data from API. ' . $th;
        }
    }
    public function crawlFifarank(){
        try {
            $data = $this->apiService->crawlFifaRank();
            if ($data) {
                foreach ($data['ranking'] as $item) {
                    $count = Country::where('name', 'like', str_replace(' ', '-', substr($item['name'], 0, 5)).'%')->get()->count();
                    if($count==1){
                        Country::where('name', 'like', str_replace(' ', '-', substr($item['name'], 0, 5)).'%')->update(
                            [
                                'rank'         => $item['rank'],
                                'points'         => $item['points'],
                                'previous_rank'         => $item['previous_rank'],
                                'previous_points'         => $item['previous_points']
                            ]
                        );
                    }else{
                        $update = Country::where('name', '=', str_replace(' ','-',$item['name']))->update(
                            [
                                'rank'         => $item['rank'],
                                'points'         => $item['points'],
                                'previous_rank'         => $item['previous_rank'],
                                'previous_points'         => $item['previous_points']
                            ]
                        );
                    }

                }
            }
            return 'Data crawled and stored successfully.';
        } catch (\Throwable $th) {
            return 'Failed to fetch data from API. ' . $th;
        }
    }
}
