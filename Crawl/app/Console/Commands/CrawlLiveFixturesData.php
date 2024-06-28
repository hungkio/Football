<?php

namespace App\Console\Commands;

use App\Models\LiveFixtures;
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

            $this->info('Data crawled and stored successfully.');
        } else {
            $this->error('Failed to fetch data from API.');
        }
    }
}
