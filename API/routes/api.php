<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GetCrawledDataController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PostController;
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
Route::get('comments', [CommentController::class, 'getCommentsFromPost']);
Route::get('categories', [CategoryController::class, 'getPostCategories']);