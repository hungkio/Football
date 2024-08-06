<?php

namespace App\Console\Commands;

use App\Models\FixturesQueue;
use App\Models\Player;
use App\Services\ApiService;
use Illuminate\Console\Command;

class CrawlPlayerByFixtureData extends Command
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
    protected $signature = 'app:crawl-player-by-fixture-data';

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
            $fixtures_queues = FixturesQueue::select('team_id')->where('is_crawled', FixturesQueue::NOTCRAWLED)->get();
            foreach ($fixtures_queues as $fixtures_queue) {
                $data = $this->apiService->crawlPlayersByTeam($fixtures_queue->team_id,2024);
                dd($data);
                if ($data) {
                    foreach ($data['response'] as $item) {
                        // Player::updateOrInsert([
                        //     ''
                        // ]);
                    }
                }
            }
            $this->info('Data crawled and stored successfully.');
        } catch (\Throwable $th) {
            $this->error('Failed to fetch data from API. ' . $th);
        }
    }
}
