<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use App\Models\FixturesQueue;
use App\Models\LiveFixtures;
use App\Models\Player;
use App\Models\PlayerStatistic;
use App\Services\ApiService;
use Carbon\Carbon;
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
                    ['api_id' => $item['fixture']['id']],
                    [
                        'api_id'     => $item['fixture']['id'],
                        'referee'    => $item['fixture']['referee'],
                        'timezone'   => $item['fixture']['timezone'],
                        'date'       => Carbon::parse($item['fixture']['date']),
                        'timestamp'  => $item['fixture']['timestamp'],
                        'periods'    => json_encode($item['fixture']['periods']),
                        'venue'      => json_encode($item['fixture']['venue']),
                        'status'     => json_encode($item['fixture']['status']),
                        'league'     => json_encode($item['league']),
                        'teams'      => json_encode($item['teams']),
                        'goals'      => json_encode($item['goals']),
                        'score'      => json_encode($item['score']),
                    ]
                );
                Fixture::updateOrInsert(
                    ['api_id' => $item['fixture']['id']],
                    [
                        'api_id'     => $item['fixture']['id'],
                        'referee'    => $item['fixture']['referee'],
                        'timezone'   => $item['fixture']['timezone'],
                        'date'       => Carbon::parse($item['fixture']['date']),
                        'timestamp'  => $item['fixture']['timestamp'],
                        'periods'    => json_encode($item['fixture']['periods']),
                        'venue'      => json_encode($item['fixture']['venue']),
                        'status'     => json_encode($item['fixture']['status']),
                        'league'     => json_encode($item['league']),
                        'teams'      => json_encode($item['teams']),
                        'goals'      => json_encode($item['goals']),
                        'score'      => json_encode($item['score']),
                        'slug'       => createSlug($item['teams']['home']['name']).
                                        '-vs-' . createSlug($item['teams']['away']['name']) .
                                        '-' .
                                        Carbon::parse($item['fixture']['date'])->format('Y-m-d'),
                    ]
                );

                FixturesQueue::insert([
                    'fixture_id' => $item['fixture']['id'],
                    'team_id'    => $item['teams']['home']['id'],
                ]);

                FixturesQueue::insert([
                    'fixture_id' => $item['fixture']['id'],
                    'team_id'    => $item['teams']['away']['id'],
                ]);
            }

            $this->info('Data crawled and stored successfully.');
        } else {
            $this->error('Failed to fetch data from API.');
        }
    }
}
