<?php

use App\Http\Controllers\CrawlApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('crawlTeams', [CrawlApiController::class, 'crawlTeams']);
Route::post('crawlPlayersByLeague', [CrawlApiController::class, 'crawlPlayersByLeague']);
Route::get('crawlStandings', [CrawlApiController::class, 'crawlStandings']);
Route::get('crawlFixtures', [CrawlApiController::class, 'crawlFixtures']);
