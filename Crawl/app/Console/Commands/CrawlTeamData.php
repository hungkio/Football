<?php

namespace App\Console\Commands;

use App\Http\Controllers\CrawlApiController;
use App\Models\League;
use App\Models\Season;
use App\Services\ApiService;
use Illuminate\Console\Command;

class CrawlTeamData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crawl-team-data';

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
            //code...
            $leagues = League::all();
            $seasons = Season::all();
            $apiService = new ApiService();
            $crawlApiController = new CrawlApiController($apiService);
    
            foreach ($leagues as $league) {
                foreach ($seasons as $season) {
                    // fixtures
                    $crawlApiController->crawlTeams($league->api_id, $season->year);
                }
            }
            return $this->info('Data crawled and stored successfully.');
        } catch (\Throwable $th) {
            return $this->error('Failed to fetch data from API. ' . $th);
        }
    }
}
