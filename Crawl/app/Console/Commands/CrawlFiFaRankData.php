<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\Venue;
use App\Services\ApiService;
use Illuminate\Console\Command;

class CrawlFiFaRankData extends Command
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
    protected $signature = 'app:crawl-fifa-rank-data';

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
            $data = $this->apiService->crawlFifaRank();
            if ($data) {
                foreach ($data['ranking'] as $item) {
                    Country::where('name', 'like', str_replace(' ','-',substr($item['name'], 0, 4)).'%')->update(
                        [
                            'rank'         => $item['rank'],
                            'points'         => $item['points'],
                            'previous_rank'         => $item['previous_rank'],
                            'previous_points'         => $item['previous_points']
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
