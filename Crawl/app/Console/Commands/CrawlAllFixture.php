<?php

namespace App\Console\Commands;

use App\Http\Controllers\CrawlApiController;
use App\Models\League;
use App\Models\Season;
use App\Services\ApiService;
use Illuminate\Console\Command;

class CrawlAllFixture extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crawl-all-fixture';

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
        $leagues = League::all();
        $seasons = Season::all();
        $apiService = new ApiService();
        $crawlApiController = new CrawlApiController($apiService);

        foreach ($leagues as $league) {
            foreach ($seasons as $season) {
                // fixtures
                if ($league->api_id && $season->year) {
                    $crawlApiController->crawlFixtures($league->api_id, $season->year);
                }
            }
        }
    }
}
