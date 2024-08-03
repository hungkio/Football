<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\GetCrawledDataController;
use App\Http\Controllers\Head2HeadController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StandingController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TopScoreController;
use App\Http\Controllers\VerificationController;
use App\Models\Standing;
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
//crawl
Route::get('fixtures', [GetCrawledDataController::class, 'getFixtures']);
Route::get('live-fixtures', [GetCrawledDataController::class, 'getLiveFixtures']);
//end crawl

//client api
Route::get('get-menus', [MenuController::class, 'getAll']);
Route::get('posts', [PostController::class, 'getPostsOnPage']);
Route::get('getPostsByCategory', [PostController::class, 'getPostsByCategory']);
Route::get('getPostById', [PostController::class, 'getPostById']);
Route::get('getPostBySlug', [PostController::class, 'getPostBySlug']);
Route::get('getPostsByTag', [PostController::class, 'getPostsByTag']);
Route::get('comments', [CommentController::class, 'getCommentsFromPost']);
Route::get('categories', [CategoryController::class, 'getPostCategories']);
Route::get('countries', [CountryController::class, 'index']);
Route::get('nationalGroupByRegion', [CountryController::class, 'nationalGroupByRegion']);
Route::get('regions', [CountryController::class, 'listRegions']);
Route::get('teams', [TeamController::class, 'index']);
Route::get('players', [PlayerController::class, 'index']);
Route::get('player/{player}', [PlayerController::class, 'details']);
Route::get('coaches', [CoachController::class, 'index']);
Route::get('coach/{coach}', [CoachController::class, 'details']);
Route::get('leagues', [LeagueController::class, 'index']);
Route::get('page/{slug}', [PageController::class, 'getPage']);
Route::get('menu/{position}', [PlayerController::class, 'details']);
Route::post('register', [AuthController::class, 'register']);
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify'); 
Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
Route::get('getFixturesByTeam', [FixtureController::class, 'index'])->name('getFixturesByTeam');
Route::get('standingByLeague', [StandingController::class, 'index'])->name('standingByLeague');
Route::get('getFixturesByCountry', [FixtureController::class, 'getFixturesByCountry'])->name('getFixturesByCountry');
Route::get('getTopScoresByLeague', [TopScoreController::class, 'index']);
Route::get('headToHead', [Head2HeadController::class, 'index']);
