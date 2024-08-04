<?php

namespace App\Console\Commands;

use App\Models\Coach;
use App\Models\Team;
use App\Services\ApiService;
use Illuminate\Console\Command;

class crawlCoachsData extends Command
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
    protected $signature = 'app:crawl-coachs-data';

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
            $teams = Team::all();
            foreach ($teams as $team) {
                $data = $this->apiService->crawlCoachs($team->api_id);
                foreach ($data['response'] as $item) {
                    Coach::updateOrInsert(
                        ['api_id' => $item['id']],
                        [
                            'api_id' => $item['id'],
                            'name' => $item['name'],
                            'firstname' => $item['firstname'],
                            'lastname' => $item['lastname'],
                            'age' => $item['age'],
                            'date_of_birth' => $item['birth']['date'],
                            'place_of_birth' => $item['birth']['place'],
                            'country' => $item['birth']['country'],
                            'nationality' => $item['nationality'],
                            'height' => $item['height'],
                            'weight' => $item['weight'],
                            'photo' => $item['photo'],
                            'team_id' => $item['team']['id'],
                            'career' => json_encode($item['career']),
                            'slug'  => createSlug($item['name']),
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
