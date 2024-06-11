<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;
use App\Domain\Banner\Models\Banner;
use App\Domain\Contact\Models\Contact;
use App\Domain\LogSearch\Models\LogSearch;
use App\Domain\Page\Models\Page;
use App\Domain\Post\Models\Post;
use App\Domain\SubscribeEmail\Models\SubscribeEmail;
use App\Domain\Taxonomy\Models\Taxonomy;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Spatie\Analytics\Period;
use Analytics;

class DashboardController
{
    public function index()
    {
        $totalTaxonomy = Taxonomy::count();
        $totalPages = Page::count();
        $totalPosts = Post::count();
        $totalContacts = Contact::count();
        $totalBanners = Banner::count();
        $totalSearchs = LogSearch::count();
        $totalSubscribeEmails = SubscribeEmail::count();

        $pageTops = Page::orderBy('view', 'desc')->take(10)->get();
        $postTops = Post::orderBy('view', 'desc')->take(10)->get();

        return view('admin.dashboards.dashboard', compact( 'totalPosts', 'totalContacts', 'totalTaxonomy', 'totalPages', 'totalBanners', 'postTops', 'pageTops', 'totalSearchs', 'totalSubscribeEmails'));
    }
}
