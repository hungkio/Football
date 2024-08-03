<?php

namespace App\Console\Commands;

use App\Models\League;
use App\Models\Standing;
use App\Services\ApiService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class crawlStandingsData extends Command
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
    protected $signature = 'app:crawl-standings-data';

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
            foreach ($leagues as $league) {
                $data = $this->apiService->crawlStandings($league->api_id, $thisSeason);
                if ($data['response']) {
                    foreach ($data['response'][0]['league']['standings'] as $items) {
                        foreach ($items as $item) {
                            Standing::updateOrCreate(
                                [
                                    'league_id' => $league->api_id,
                                    'season'    => $thisSeason,
                                    'team_id'   => $item['team']['id'],
                                    'group'       => $item['group'],
                                    'form'        => $item['form'],
                                ],
                                [
                                    'league_id'   => $league->api_id,
                                    'season'      => $thisSeason,
                                    'team_id'     => $item['team']['id'],
                                    'rank'        => $item['rank'],
                                    'points'      => $item['points'],
                                    'goalsDiff'   => $item['goalsDiff'],
                                    'group'       => $item['group'],
                                    'form'        => $item['form'],
                                    'status'      => $item['status'],
                                    'description' => $item['description'],
                                    'all'         => $item['all'],
                                    'home'        => $item['home'],
                                    'away'        => $item['away'],
                                ]
                            );
                        }
                    }
                }
            }
            return $this->info('Data crawled and stored successfully.');
        } catch (\Throwable $th) {
            return $this->error('Failed to fetch data from API. ' . $th);
        }
    }
}
