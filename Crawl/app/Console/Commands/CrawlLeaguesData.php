<?php

namespace App\Console\Commands;

use App\Models\League;
use App\Services\ApiService;
use Illuminate\Console\Command;

class CrawlLeaguesData extends Command
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
    protected $signature = 'app:crawl-leagues-data';

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
            }
            return $this->info('Data crawled and stored successfully.');
        } catch (\Throwable $th) {
            return $this->error('Failed to fetch data from API. ' . $th);
        }
    }
}
