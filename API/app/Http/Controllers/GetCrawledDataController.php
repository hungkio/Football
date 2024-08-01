<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetFixturesRequest;
use App\Models\Fixture;
use App\Models\LiveFixture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
class GetCrawledDataController extends Controller
{
    public function getFixtures(GetFixturesRequest $request){
        $date = $request->date;
        $fixtures = Fixture::where('date','like', $date.'%')->get();
        $arr = [];
        foreach ($fixtures as $fixture) {
            $leagueName = $fixture->league['name'];
            $arr[$leagueName][] = $fixture->toArray();
        }
        // dd($arr);
        $collection = collect($arr);
        $page = request()->get('page', 1); // Lấy trang hiện tại từ request, mặc định là 1
        $perPage = $request->per_page; // Số lượng items trên mỗi trang
        $paginatedMatches = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return response()->json($paginatedMatches);
    }

    public function getLiveFixtures(Request $request){
        $fixtures = LiveFixture::all();
        $arr = [];
        foreach ($fixtures as $fixture) {
            $leagueName = $fixture->league['name'];
            $arr[$leagueName][] = $fixture->toArray();
        }

        $collection = collect($arr);

        $perPage = $request->per_page ?? 15;

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $offset = ($currentPage * $perPage) - $perPage;

        $itemsForCurrentPage = $collection->slice($offset, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $itemsForCurrentPage,
            $collection->count(),
            $perPage,
            $currentPage,
        );
        return response()->json($paginator);
    }
}
