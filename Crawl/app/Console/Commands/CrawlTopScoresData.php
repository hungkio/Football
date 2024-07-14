<?php

namespace App\Console\Commands;

use App\Models\League;
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
            foreach ($leagues as $league) {
                $data = $this->apiService->crawlTopScores($league->api_id, $thisSeason);
                foreach ($data['response'] as $item) {
                    TopScore::updateOrCreate(
                        ['player_id' => $item['player']['id']],
                        [
                            'player_id' => $item['player']['id'],
                            'league_id' => $league->api_id,
                            'season'    => $thisSeason
                        ]
                    );
                }
            }
            return $this->info('Data crawled and stored successfully.');
        } catch (\Throwable $th) {
            return $this->error('Failed to fetch data from API. ' . $th);
        }
    }
}
