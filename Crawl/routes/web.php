<?php

use App\Http\Controllers\CrawlApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('crawlFixtures', [CrawlApiController::class, 'crawlFixtures']);
Route::get('crawlLiveFixtures', [CrawlApiController::class, 'crawlLiveFixtures']);
Route::get('crawlLeagues', [CrawlApiController::class, 'crawlLeagues']);
Route::get('crawlCountries', [CrawlApiController::class, 'crawlCountries']);
Route::get('crawlTeamsCountries', [CrawlApiController::class, 'crawlTeamsCountries']);
Route::get('updatefifarank', [CrawlApiController::class, 'crawlFifarank']);

Route::get('crawlFixturesexample', [CrawlApiController::class, 'crawlFixturesbyteam']);
