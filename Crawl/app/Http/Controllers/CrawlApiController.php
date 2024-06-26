<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\LiveFixtures;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class CrawlApiController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function crawlFixtures()
    {
        $today = date('Y-m-d');
        $data = $this->apiService->crawlFixtures($today);
        if ($data) {
            foreach ($data['response'] as $item) {
                Fixture::updateOrInsert(
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

            return 'Data crawled and stored successfully.';
        } else {
            return 'Failed to fetch data from API.';
        }
    }

    public function crawlLiveFixtures()
    {
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

            return 'Data crawled and stored successfully.';
        } else {
            return 'Failed to fetch data from API.';
        }
    }
}
