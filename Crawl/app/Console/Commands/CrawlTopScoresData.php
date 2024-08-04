<?php

namespace App\Console\Commands;

use App\Models\League;
use App\Models\Player;
use App\Models\PlayerStatistic;
use App\Models\Team;
use App\Models\TopScore;
use App\Services\ApiService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CrawlTopScoresData extends Command
{
    protected $apiService;
    public function __construct(ApiService $apiService)
    {
        parent::__construct();
        $this->apiService = $apiService;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crawl-top-scores-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $thisSeason = Carbon::now()->year;
            $leagues = League::all();
            // foreach ($leagues as $league) {
            //     $data = $this->apiService->crawlTopScores($league->api_id, $thisSeason);
            //     foreach ($data['response'] as $item) {
            //         TopScore::updateOrCreate(
            //             ['player_id' => $item['player']['id']],
            //             [
            //                 'player_id' => $item['player']['id'],
            //                 'league_id' => $league->api_id,
            //                 'season'    => $thisSeason,
            //                 'goals'     => $item['statistics'][0]['goals']['total'],
            //                 'penalty'   => $item['statistics'][0]['penalty']['scored'],
            //                 'team_id'   => $item['statistics'][0]['team']['id'],
            //             ]
            //         );
            //     }
            // }
            $data = $this->apiService->crawlTopScores(39, 2023);
            foreach ($data['response'] as $item) {
                TopScore::updateOrCreate(
                    ['player_id' => $item['player']['id']],
                    [
                        'player_id' => $item['player']['id'],
                        'league_id' => $item['statistics'][0]['league']['id'],
                        'season'    => $item['statistics'][0]['league']['season'],
                        'goals'     => $item['statistics'][0]['goals']['total'],
                        'penalty'   => $item['statistics'][0]['penalty']['scored'],
                        'team_id'   => $item['statistics'][0]['team']['id'],
                    ]
                );
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
                        'slug'           => createSlug($item['player']['name']),
                    ]
                );
                PlayerStatistic::updateOrCreate(
                    [
                        'player_id'   => $item['player']['id'],
                        'team_id'     => $item['statistics'][0]['team']['id'],
                        'league_id'   => $item['statistics'][0]['league']['id'],
                        'season'      => $item['statistics'][0]['league']['season'],
                    ],
                    [
                        'player_id'   => $item['player']['id'],
                        'team_id'     => $item['statistics'][0]['team']['id'],
                        'league_id'   => $item['statistics'][0]['league']['id'],
                        'season'      => $item['statistics'][0]['league']['season'],
                        'games'       => $item['statistics'][0]['games'],
                        'substitutes' => $item['statistics'][0]['substitutes'],
                        'shots'       => $item['statistics'][0]['shots'],
                        'goals'       => $item['statistics'][0]['goals'],
                        'passes'      => $item['statistics'][0]['passes'],
                        'tackles'     => $item['statistics'][0]['tackles'],
                        'duels'       => $item['statistics'][0]['duels'],
                        'dribbles'    => $item['statistics'][0]['dribbles'],
                        'fouls'       => $item['statistics'][0]['fouls'],
                        'cards'       => $item['statistics'][0]['cards'],
                        'penalty'     => $item['statistics'][0]['penalty'],
                    ]
                );
                Team::updateOrInsert(
                    ['api_id' => $item['statistics'][0]['team']['id']],
                    [
                        'api_id'    => $item['statistics'][0]['team']['id'],
                        'name'      => $item['statistics'][0]['team']['name'],
                        'logo'      => $item['statistics'][0]['team']['logo'],
                        'slug'      => createSlug($item['statistics'][0]['team']['name'])
                    ]
                );
            }
            return $this->info('Data crawled and stored successfully.');
        } catch (\Throwable $th) {
            return $this->error('Failed to fetch data from API. ' . $th);
        }
    }
}
