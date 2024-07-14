<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\Venue;
use App\Services\ApiService;
use Illuminate\Console\Command;

class CrawlCountriesData extends Command
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
    protected $signature = 'app:crawl-countries-data';

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
            $data = $this->apiService->crawlCountries();
            foreach ($data['response'] as $item) {
                Country::updateOrInsert(
                    ['code' => $item['code']],
                    [
                        'name'         => $item['name'],
                        'code'         => $item['code'],
                        'flag'         => $item['flag'],
                    ]
                );
                $venueData = $this->apiService->crawlVenues($item['name']);
                foreach ($venueData['response'] as $venueItem) {
                    Venue::updateOrInsert(
                        ['api_id' => $venueItem['id']],
                        [
                            'api_id' => $venueItem['id'],
                            'name' => $venueItem['name'],
                            'address' => $venueItem['address'],
                            'city' => $venueItem['city'],
                            'country' => $venueItem['country'],
                            'capacity' => $venueItem['capacity'],
                            'surface' => $venueItem['surface'],
                            'image' => $venueItem['image'],
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
