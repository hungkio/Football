<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetFixturesByCountryRequest;
use App\Http\Requests\GetFixturesByTeamRequest;
use App\Models\Country;
use App\Models\Fixture;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class FixtureController extends Controller
{
    public function index(GetFixturesByTeamRequest $request){
        try {
            $team = Team::where('slug', $request->team_slug)->first();
            
            $fixtures = Fixture::where(function($query) use ($team){
                if($team->api_id){
                    $query->whereRaw("JSON_EXTRACT(teams, '$.home.id') = ?", [$team->api_id])
                    ->orWhereRaw("JSON_EXTRACT(teams, '$.away.id') = ?", [$team->api_id]);
                }
            })
            // if type = 1 then get schedule
            ->when($request->type == 1, function($query) use ($request){
                $query->whereDate('date', '>=', Carbon::today());
            })
            // if type = 0 then get results
            ->when($request->type == 0, function($query){
                $query->whereDate('date', '<=', Carbon::today())
                      ->limit(10);
            })
            ->paginate($request->per_page);
    
            return response()->json($fixtures);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'data' => $th,
            ]);
        }
    }

    public function getFixturesByCountry(GetFixturesByCountryRequest $request){
        $country = Country::where('slug', $request->country_slug)->first();

        $latestFixture = Fixture::whereRaw("JSON_EXTRACT(league, '$.country') = ?", [$country->name])->orderBy('date', 'desc')->first();

        $startDate = null;
        if ($latestFixture) {
            $startDate = Carbon::parse($latestFixture->date)->subDays(30);
            $endDate = $startDate->copy()->addDays(30);
        }
        // dd([$startDate->toDateString(), $endDate->toDateString()]);
        $fixtures = Fixture::whereRaw("JSON_EXTRACT(league, '$.country') = ?", [$country->name])
        ->when($startDate, function($query) use ($startDate, $endDate){
            $query->whereBetween('date', [$startDate->toDateTimeString(), $endDate->toDateTimeString()]);
        })
        ->limit(100)
        ->get();
        $countryTeamFixtures = Fixture::whereRaw("JSON_EXTRACT(teams, '$.home.name') = ?", [$country->name])
                                    ->orWhereRaw("JSON_EXTRACT(teams, '$.away.name') = ?", [$country->name])
                                    ->get();
        $arr = [];
        $arr[$country->name] = $countryTeamFixtures;
        foreach ($fixtures as $fixture) {
            $leagueName = $fixture->league['name'];
            $arr[$leagueName][] = $fixture->toArray();
        }
        // dd($arr);
        $collection = collect($arr);
        $page = request()->get('page', 1); // Lấy trang hiện tại từ request, mặc định là 1
        $perPage = $request->per_page ?? 15; // Số lượng items trên mỗi trang
        $paginatedMatches = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return response()->json($paginatedMatches);
    }
}
