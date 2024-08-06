<?php

namespace App\Console;

use App\Http\Controllers\CrawlApiController;
use App\Models\League;
use App\Models\Season;
use App\Services\ApiService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Http;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // to run schedule on server, setup like this: * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

        $apiService = new ApiService;
        $crawlApiController = new CrawlApiController($apiService);

        // countries, venues
        $schedule->call(function () use ($crawlApiController) {
            $crawlApiController->crawlCountries();
            $crawlApiController->crawlTeamsCountries();
        })->daily();

        // seasons
        $schedule->command('app:crawl-seasons-data')->daily();

        // coaches
        $schedule->command('app:crawl-coachs-data')->daily();

        // leagues
        $schedule->command('app:crawl-leagues-data')->daily();

        $schedule->call(function () {
            $leagues = League::all();
            $seasons = Season::all();
            foreach ($leagues as $league) {
                foreach ($seasons as $season) {
                    // teams
                    Http::post(config('app.url') . '/api/crawlTeams', [
                        'league' => $league->api_id,
                        'season' => $season->year,
                    ]);

                    // players
                    Http::post(config('app.url') . '/api/crawlPlayersByLeague', [
                        'league' => $league->api_id,
                        'season' => $season->year,
                    ]);
                }
            }
        })->daily();

        // top scores
        $schedule->command('app:crawl-top-scores-data')->daily();

        // live fixtures
        $schedule->command('app:crawl-live-fixtures-data')->everyMinute();

        // fixtures
        $schedule->command('app:crawl-fixtures-data')->everyTwoMinutes();
        // standing
        $schedule->call(function () use ($crawlApiController) {
            $crawlApiController->crawlStandings();
        })->hourly();
        $schedule->call(function () use ($crawlApiController) {
            $crawlApiController->crawlFifarank();
        })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
