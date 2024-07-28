<?php

namespace App\Console\Commands;

use App\Models\LiveFixtures;
use App\Models\Player;
use App\Models\PlayerStatistic;
use App\Services\ApiService;
use Illuminate\Console\Command;

class CrawlLiveFixturesData extends Command
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
    protected $signature = 'app:crawl-live-fixtures-data';

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
                        'slug'  => 'fixture-' . createSlug($item['fixture']['id']),
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
                                        'slug'           => createSlug($playerItem['player']['name']),
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

            $this->info('Data crawled and stored successfully.');
        } else {
            $this->error('Failed to fetch data from API.');
        }
    }
}
