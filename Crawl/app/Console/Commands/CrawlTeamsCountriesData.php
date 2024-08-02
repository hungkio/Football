<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Services\ApiService;
use Illuminate\Console\Command;

class CrawlTeamsCountriesData extends Command
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
    protected $signature = 'app:crawl-teams-countries-data';

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
            $data = $this->apiService->crawlTeamsCountries();
            foreach ($data['response'] as $item) {
                Country::updateOrInsert(
                    [
                        'code' => $item['code'],
                        'name' => $item['name'],
                    ],
                    [
                        'name'         => $item['name'],
                        'code'         => $item['code'],
                        'flag'         => $item['flag'],
                        'from_team'    => 1,
                        'slug'         => createSlug($item['name']),
                    ]
                );
            }
            return $this->info('Data crawled and stored successfully.');
        } catch (\Throwable $th) {
            return $this->error('Failed to fetch data from API. ' . $th);
        }
    }
}
