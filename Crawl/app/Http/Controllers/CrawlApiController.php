<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrawlFixturesRequest;
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
    public function crawlFixturesbyteam()
    {
        $data = $this->apiService->crawlFixturesexample();
        if ($data) {
            foreach ($data['response'] as $item) {
                Fixture::updateOrInsert(
                    ['api_id' => $item['fixture']['id']],
                    [
                        'api_id'     => $item['fixture']['id'],
                        'referee'    => $item['fixture']['referee'],
                        'timezone'   => $item['fixture']['timezone'],
                        'date'       => Carbon::parse($item['fixture']['date']),
                        'timestamp'  => $item['fixture']['timestamp'],
                        'periods'    => json_encode($item['fixture']['periods']),
                        'venue'      => json_encode($item['fixture']['venue']),
                        'status'     => json_encode($item['fixture']['status']),
                        'league'     => json_encode($item['league']),
                        'teams'      => json_encode($item['teams']),
                        'goals'      => json_encode($item['goals']),
                        'score'      => json_encode($item['score']),
                        'slug'       => createSlug($item['teams']['home']['name']).
                                        '-vs-' . createSlug($item['teams']['away']['name']),
                    ]
                );
            }

            return 'Data crawled and stored successfully.';
        } else {
            return 'Failed to fetch data from API.';
        }
    }

    public function crawlFixtures($league, $season)
    {
        $data = $this->apiService->crawlFixturesByLeague($league, $season);
        if ($data) {
            foreach ($data['response'] as $item) {
                Fixture::updateOrInsert(
                    ['api_id' => $item['fixture']['id']],
                    [
                        'api_id'     => $item['fixture']['id'],
                        'referee'    => $item['fixture']['referee'],
                        'timezone'   => $item['fixture']['timezone'],
                        'date'       => Carbon::parse($item['fixture']['date']),
                        'timestamp'  => $item['fixture']['timestamp'],
                        'periods'    => json_encode($item['fixture']['periods']),
                        'venue'      => json_encode($item['fixture']['venue']),
                        'status'     => json_encode($item['fixture']['status']),
                        'league'     => json_encode($item['league']),
                        'teams'      => json_encode($item['teams']),
                        'goals'      => json_encode($item['goals']),
                        'score'      => json_encode($item['score']),
                        'slug'       => createSlug($item['teams']['home']['name']).
                                        '-vs-' . createSlug($item['teams']['away']['name']),
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
                            'slug'      => createSlug($item['team']['name'])
                        ]
                    );
                }
            }
            return 'Data crawled and stored successfully.';
        } catch (\Throwable $th) {
            return 'Failed to fetch data from API. ' . $th;
        }
    }

    // public function crawlLeagues(){
    //     try {
    //         $data = $this->apiService->crawlLeagues();
    //         foreach ($data['response'] as $item) {
    //             League::updateOrInsert(
    //                 ['api_id' => $item['league']['id']],
    //                 [
    //                     'api_id'       => $item['league']['id'],
    //                     'name'         => $item['league']['name'],
    //                     'type'         => $item['league']['type'],
    //                     'logo'         => $item['league']['logo'],
    //                     'country_code' => $item['country']['code'],
    //                 ]
    //             );
    //             Country::updateOrInsert(
    //                 [
    //                     'code' => $item['country']['code'],
    //                     'name' => $item['country']['name'],
    //                 ],
    //                 [
    //                     'name'         => $item['country']['name'],
    //                     'code'         => $item['country']['code'],
    //                     'flag'         => $item['country']['flag'],
    //                     'slug'         => $item['country']['name'],
    //                 ]
    //             );
    //         }
    //         return 'Data crawled and stored successfully.';
    //     } catch (\Throwable $th) {
    //         return 'Failed to fetch data from API. ' . $th;
    //     }
    // }

    // public function crawlCountries(){
    //     try {
    //         $data = $this->apiService->crawlCountries();
    //         foreach ($data['response'] as $item) {
    //             Country::updateOrInsert(
    //                 [
    //                     'name' => $item['name'],
    //                     'code' => $item['code'],
    //                 ],
    //                 [
    //                     'name'         => $item['name'],
    //                     'code'         => $item['code'],
    //                     'flag'         => $item['flag'],
    //                     'slug'         => $item['name'],
    //                 ]
    //             );
    //         }
    //         return 'Data crawled and stored successfully.';
    //     } catch (\Throwable $th) {
    //         return 'Failed to fetch data from API. ' . $th;
    //     }
    // }

    // public function crawlTeamsCountries(){
    //     try {
    //         $data = $this->apiService->crawlTeamsCountries();
    //         foreach ($data['response'] as $item) {
    //             Country::updateOrInsert(
    //                 [
    //                     'code' => $item['code'],
    //                     'name' => $item['name']
    //                 ],
    //                 [
    //                     'name'         => $item['name'],
    //                     'code'         => $item['code'],
    //                     'flag'         => $item['flag'],
    //                     'slug'         => $item['name'],
    //                     'from_team'    => 1
    //                 ]
    //             );
    //         }
    //         return 'Data crawled and stored successfully.';
    //     } catch (\Throwable $th) {
    //         return 'Failed to fetch data from API. ' . $th;
    //     }
    // }

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
