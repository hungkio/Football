<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Admin\CoachController;
use App\Http\Controllers\Admin\AccountSettingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\Auth\ConfirmPasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\VerificationController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FixtureController;
use App\Http\Controllers\Admin\InternalLinkController;
use App\Http\Controllers\Admin\LeagueController;
use App\Http\Controllers\Admin\MostVisitedPageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TaxonController;
use App\Http\Controllers\Admin\TaxonomyController;
use App\Http\Controllers\Admin\TaxonomyTreeController;
use App\Http\Controllers\Admin\TaxonRenameController;
use App\Http\Controllers\Admin\TaxonSearchController;
use App\Http\Controllers\Admin\TaxonSortController;
use App\Http\Controllers\Admin\TaxonTreeController;
use App\Http\Controllers\Admin\TopReferrerController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UploadTinymceController;
use App\Http\Controllers\Admin\LogActivityController;
use App\Http\Controllers\Admin\MailSettingController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\ToolRedirecterController;
use App\Http\Controllers\Admin\ToolAutoLinkController;
use App\Http\Controllers\Admin\ToolMetaSeoLinkController;
use App\Http\Controllers\Admin\ToolTextSeoFooterController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Registration Routes...
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    // Password Confirmation Routes...
    Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);

    // Email Verification Routes...
    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

    // Route Dashboards
    Route::middleware('auth')
        ->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

            //Upload Tinymce
            Route::post('uploads-tinymce', UploadTinymceController::class)->name('public.upload-tinymce');

            // Application Route
            Route::get('taxonomies/{taxonomy}/taxon/{taxon}/jstree', TaxonTreeController::class)->name('taxons.tree');
            Route::get('/taxonomies/{taxonomy}/jstree', TaxonomyTreeController::class)->name('taxonomies.tree');
            Route::post('/taxonomies/bulk-delete', [TaxonomyController::class, 'bulkDelete'])->name('taxonomies.bulk-delete');
            Route::get('/taxonomies', [TaxonomyController::class, 'index'])->name('taxonomies.index');
            Route::get('/taxonomies/create', [TaxonomyController::class, 'create'])->name('taxonomies.create');
            Route::post('/taxonomies', [TaxonomyController::class, 'store'])->name('taxonomies.store');
            Route::get('/taxonomies/{taxonomy}/edit', [TaxonomyController::class, 'edit'])->name('taxonomies.edit');
            Route::delete('/taxonomies/{taxonomy}', [TaxonomyController::class, 'destroy'])->name('taxonomies.destroy');
            Route::put('/taxonomies/{taxonomy}', [TaxonomyController::class, 'update'])->name('taxonomies.update');


            Route::post('taxons/{taxon}/sort', TaxonSortController::class)->name('taxons.sort');
            Route::post('taxons/{taxon}/rename', TaxonRenameController::class)->name('taxons.rename');
            Route::post('/taxons', [TaxonController::class, 'store'])->name('taxons.store');
            Route::get('/taxons/{taxon}/edit', [TaxonController::class, 'edit'])->name('taxons.edit');
            Route::delete('/taxons/{taxon}', [TaxonController::class, 'destroy'])->name('taxons.destroy');
            Route::put('/taxons/{taxon}', [TaxonController::class, 'update'])->name('taxons.update');

            // System Route
            Route::post('/admins/bulk-delete', [AdminController::class, 'bulkDelete'])->name('admins.bulk-delete');
            Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
            Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
            Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
            Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
            Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');
            Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');

            Route::post('/roles/bulk-delete', [RoleController::class, 'bulkDelete'])->name('roles.bulk-delete');
            Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
            Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
            Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
            Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
            Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
            Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');

            Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
            Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

            Route::get('/account-settings', [AccountSettingController::class, 'edit'])->name('account-settings.edit');
            Route::put('/account-settings', [AccountSettingController::class, 'update'])->name('account-settings.update');

            Route::get('/analytics', AnalyticsController::class)->name('analytics');
            Route::get('/top-referrers', TopReferrerController::class)->name('top-referrers');
            Route::get('/most-visited-pages', MostVisitedPageController::class)->name('most-visited-pages');

            // PAGE
            Route::post('/pages/bulk-delete', [PageController::class, 'bulkDelete'])->name('pages.bulk-delete');
            Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
            Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
            Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
            Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
            Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');
            Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
            Route::post('/pages/{page}/status', [PageController::class, 'changeStatus'])->name('pages.change.status');
            //Upload Tinymce
            Route::post('pages/upload/image', [PageController::class, 'upLoadFileImage'])->name('pages.upload.image');

            // POST
            Route::post('/posts/bulk-delete', [PostController::class, 'bulkDelete'])->name('posts.bulk-delete');
            Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
            Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
            Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
            Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
            Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
            Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
            Route::post('/posts/{post}/status', [PostController::class, 'changeStatus'])->name('posts.change.status');
            Route::post('/posts/bulk-status', [PostController::class, 'bulkStatus'])->name('posts.bulk.status');

            //Upload Tinymce
            Route::post('posts/upload/image', [PostController::class, 'upLoadFileImage'])->name('posts.upload.image');

            // BANNER
            Route::group(['middleware' => ['banner']], function () {
                Route::post('/banners/bulk-delete', [BannerController::class, 'bulkDelete'])->name('banners.bulk-delete');
                Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
                Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
                Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
                Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');
                Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');
                Route::put('/banners/{banner}', [BannerController::class, 'update'])->name('banners.update');
                Route::post('/banners/{banner}/status', [BannerController::class, 'changeStatus'])->name('banners.change.status');
                Route::post('/banners/bulk-status', [BannerController::class, 'bulkStatus'])->name('banners.bulk.status');
            });

            // LOG ACTIVITY
            Route::get('/log-activities', [LogActivityController::class, 'index'])->name('log-activities.index');
            Route::get('/log-activities/{log_activitiy}', [LogActivityController::class, 'show'])->name('log-activities.show');
            Route::post('/log-activities/bulk-delete', [LogActivityController::class, 'bulkDelete'])->name('log-activities.bulk-delete');
            Route::delete('/log-activities/{log_activitiy}', [LogActivityController::class, 'destroy'])->name('log-activities.destroy');

            //Search Taxon
            Route::get('/taxons/search', TaxonSearchController::class)->name('taxons.search');

            //Contact
            Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
            Route::get('/subscribe-emails', [ContactController::class, 'subscribeEmail'])->name('contacts.subscribe_email');
            Route::get('/searchs', [ContactController::class, 'search'])->name('contacts.search');

            //Mail
            Route::get('/mail-settings', [MailSettingController::class, 'index'])->name('mail-settings.index');
            Route::post('/mail-settings', [MailSettingController::class, 'save'])->name('mail-settings.save');
            Route::post('/send-mail-now', [MailSettingController::class, 'send_mail_now'])->name('mail-settings.send-mail-now');
            Route::delete('/mail-settings/delete/{slug}', [MailSettingController::class, 'delete'])->name('mail-settings.delete');

            //Menu
            Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
            Route::post('/menus/store', [MenuController::class, 'store'])->name('menus.store');
            Route::get('/menus/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit');
            Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
            Route::post('/menus/{menu}/status', [MenuController::class, 'changeStatus'])->name('menus.change.status');
            Route::post('/menus/bulk-status', [MenuController::class, 'bulkStatus'])->name('menus.bulk.status');
            Route::get('menus/{menu}/menu-item/{menu_item}/jstree', [MenuItemController::class, 'tree'])->name('menu_item.tree');
            Route::get('/menus/{menu}/jstree', [MenuController::class, 'tree'])->name('menus.tree');
            Route::post('/menus/get_data_create', [MenuController::class, 'getDataCreate'])->name('menus.getDataCreate');
            Route::post('/menus/get_data_update', [MenuController::class, 'getDataUpdate'])->name('menus.getDataUpdate');
            Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');
            Route::post('/menus/bulk-delete', [MenuController::class, 'bulkDelete'])->name('menus.bulk-delete');
            Route::get('/menus/search-data', [MenuController::class, 'searchData'])->name('menus.search-data');
            Route::post('/menus/{menu}/sort', [MenuController::class, 'sort'])->name('menus.sort');

            Route::post('/menu-item', [MenuItemController::class, 'store'])->name('menu-item.store');
            Route::get('/menu-item/{menu_item}/edit', [MenuItemController::class, 'edit'])->name('menu-item.edit');
            Route::delete('/menu-item/{menu_item}', [MenuItemController::class, 'destroy'])->name('menu-item.destroy');
            Route::post('/menu-item/update', [MenuItemController::class, 'update'])->name('menu-item.update');
            Route::get('/internal-links', [InternalLinkController::class, 'index'])->name('internal-links');
            Route::post('/internal-links', [InternalLinkController::class, 'save'])->name('internal-links.save');
            Route::get('/internal-links/{id}', [InternalLinkController::class, 'edit'])->name('internal-links.edit');
            Route::delete('/internal-links/{id}', [InternalLinkController::class, 'delete'])->name('internal-links.destroy');

            //Comments
            Route::get('/comments', [CommentController::class, 'index'])->name('comments');
            Route::delete('/comments/delete/{id}', [CommentController::class, 'delete'])->name('comments.destroy');

            //Api
            Route::get('/api/countries', [CountryController::class, 'index'])->name('api.countries');


            Route::delete('/api/country/{id}', [CountryController::class, 'delete'])->name('api.countries.destroy');
            Route::get('/api/country/{country}', [CountryController::class, 'edit'])->name('api.countries.edit');
            Route::put('/api/country/{country}', [CountryController::class, 'update'])->name('api.countries.update');

            Route::get('/api/teams', [TeamController::class, 'index'])->name('api.teams');
            Route::get('/api/teams/create', [TeamController::class, 'create'])->name('api.team.create');
            Route::post('/api/teams/store', [TeamController::class, 'store'])->name('api.team.store');
            Route::get('/api/team/{team}', [TeamController::class, 'edit'])->name('api.team.edit');
            Route::put('/api/team/{team}', [TeamController::class, 'update'])->name('api.team.update');
            Route::delete('/api/team/{id}', [TeamController::class, 'delete'])->name('api.team.destroy');

            Route::get('/api/players', [PlayerController::class, 'index'])->name('api.players');
            Route::post('/api/players/store', [PlayerController::class, 'store'])->name('api.player.store');
            Route::get('/api/players/create', [PlayerController::class, 'create'])->name('api.player.create');
            Route::get('/api/player/{player}', [PlayerController::class, 'edit'])->name('api.player.edit');
            Route::put('/api/player/{player}', [PlayerController::class, 'update'])->name('api.player.update');
            Route::delete('/api/player/{id}', [PlayerController::class, 'delete'])->name('api.player.destroy');

            Route::get('/api/fixtures', [FixtureController::class, 'index'])->name('api.fixtures');
            Route::post('/api/fixtures/store', [FixtureController::class, 'store'])->name('api.fixture.store');
            Route::get('/api/fixtures/create', [FixtureController::class, 'create'])->name('api.fixture.create');
            Route::get('/api/fixture/{fixture}', [FixtureController::class, 'edit'])->name('api.fixture.edit');
            Route::put('/api/fixture/{fixture}', [FixtureController::class, 'update'])->name('api.fixture.update');
            Route::delete('/api/fixture/{id}', [FixtureController::class, 'delete'])->name('api.fixture.destroy');

            Route::get('/api/leagues', [LeagueController::class, 'index'])->name('api.leagues');
            Route::post('/api/leagues/store', [LeagueController::class, 'store'])->name('api.league.store');
            Route::post('/api/leagues/priority', [LeagueController::class, 'savePriority'])->name('api.league.priority.save');
            Route::post('/api/leagues/savepsp', [LeagueController::class, 'savePSP'])->name('api.league.savepsp');
            Route::get('/api/leagues/create', [LeagueController::class, 'create'])->name('api.league.create');
            Route::get('/api/league/{league}', [LeagueController::class, 'edit'])->name('api.league.edit');
            Route::put('/api/league/{league}', [LeagueController::class, 'update'])->name('api.league.update');
            Route::delete('/api/league/{id}', [LeagueController::class, 'delete'])->name('api.league.destroy');

            Route::get('/api/coaches', [CoachController::class, 'index'])->name('api.coaches');
            Route::post('/api/coaches/store', [CoachController::class, 'store'])->name('api.coach.store');
            Route::get('/api/coaches/create', [CoachController::class, 'create'])->name('api.coach.create');
            Route::get('/api/coach/{coach}', [CoachController::class, 'edit'])->name('api.coach.edit');
            Route::put('/api/coach/{coach}', [CoachController::class, 'update'])->name('api.coach.update');
            Route::delete('/api/coach/{id}', [CoachController::class, 'delete'])->name('api.coach.destroy');

            // tool redirecter
            Route::get('/api/tools-redirecter', [ToolRedirecterController::class, 'index'])->name('api.tools-redirecter');
            Route::get('/api/tools-redirecter/create', [ToolRedirecterController::class, 'create'])->name('api.tools-redirecter.create');
            Route::get('/api/tools-redirecter/{tool}', [ToolRedirecterController::class, 'edit'])->name('api.tools-redirecter.edit');
            Route::post('/api/tools-redirecter', [ToolRedirecterController::class, 'store'])->name('api.tools-redirecter.store');
            Route::put('/api/tools-redirecter/{tool}', [ToolRedirecterController::class, 'update'])->name('api.tools-redirecter.update');
            Route::delete('/api/tools-redirecter/{tool}', [ToolRedirecterController::class, 'delete'])->name('api.tools-redirecter.destroy');

            // tool autoLink
            Route::get('/api/tools-auto-link', [ToolAutoLinkController::class, 'index'])->name('api.tools-auto-link');
            Route::get('/api/tools-auto-link/create', [ToolAutoLinkController::class, 'create'])->name('api.tools-auto-link.create');
            Route::get('/api/tools-auto-link/{tool}', [ToolAutoLinkController::class, 'edit'])->name('api.tools-auto-link.edit');
            Route::post('/api/tools-auto-link', [ToolAutoLinkController::class, 'store'])->name('api.tools-auto-link.store');
            Route::put('/api/tools-auto-link/{tool}', [ToolAutoLinkController::class, 'update'])->name('api.tools-auto-link.update');
            Route::delete('/api/tools-auto-link/{tool}', [ToolAutoLinkController::class, 'delete'])->name('api.tools-auto-link.destroy');
            
            // tool autoLink seo
            Route::get('/api/tool-meta-seo-link', [ToolMetaSeoLinkController::class, 'index']);
            Route::post('/api/tool-meta-seo-link', [ToolMetaSeoLinkController::class, 'store']);
            Route::put('/api/tool-meta-seo-link/{id}', [ToolMetaSeoLinkController::class, 'update']);
            Route::delete('/api/tool-meta-seo-link/{id}', [ToolMetaSeoLinkController::class, 'delete']);

            // tool autoLink seo
            Route::get('/api/tool-text-seo-footer', [ToolTextSeoFooterController::class, 'index']);
            Route::post('/api/tool-text-seo-footer', [ToolTextSeoFooterController::class, 'store']);
            Route::put('/api/tool-text-seo-footer/{id}', [ToolTextSeoFooterController::class, 'update']);
            Route::delete('/api/tool-text-seo-footer/{id}', [ToolTextSeoFooterController::class, 'delete']);
        });
});
