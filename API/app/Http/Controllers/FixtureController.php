<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetFixtureByClubRequest;
use App\Http\Requests\GetFixturesByCountryRequest;
use App\Http\Requests\GetFixturesByLeagueRequest;
use App\Http\Requests\GetFixturesByTeamRequest;
use App\Models\Country;
use App\Models\Fixture;
use App\Models\League;
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
        ->when($request->status, function($query) use ($request){
            switch ($request->status) {
                case Fixture::FINISHED: //2
                    $query->whereRaw("JSON_EXTRACT(status, '$.long') = ?", ['Match Finished']);
                    break;
                case Fixture::NOT_STARTED: //1
                    $query->whereRaw("JSON_EXTRACT(status, '$.long') = ?", ['Not Started']);
                    break;
                case Fixture::LIVE: 
                    $query->whereRaw("TRIM(BOTH ' ' FROM JSON_UNQUOTE(JSON_EXTRACT(status, '$.long'))) NOT IN (?, ?)", ['Not Started', 'Match Finished']);
                    break;
            }
        })
        ->limit(100)
        ->get();

        $countryTeamFixtures = Fixture::where(function ($query) use ($country){
            $query->whereRaw("JSON_EXTRACT(teams, '$.home.name') = ?", [$country->name])
                  ->orWhereRaw("JSON_EXTRACT(teams, '$.away.name') = ?", [$country->name]);
        })
        ->when($request->status, function($query) use ($request){
            switch ($request->status) {
                case Fixture::FINISHED: //2
                    $query->whereRaw("JSON_EXTRACT(status, '$.long') = ?", ['Match Finished']);
                    break;
                case Fixture::NOT_STARTED: //1
                    $query->whereRaw("JSON_EXTRACT(status, '$.long') = ?", ['Not Started']);
                    break;
                case Fixture::LIVE: 
                    $query->whereRaw("TRIM(BOTH ' ' FROM JSON_UNQUOTE(JSON_EXTRACT(status, '$.long'))) NOT IN (?, ?)", ['Match Finished', 'Not Started']);
                    break;
            }
        })
        ->limit(10)
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

    public function getFixturesByLeague(GetFixturesByLeagueRequest $request){
        try {
            $league = League::where('slug', $request->league_slug)->first();
            
            $fixtures = Fixture::whereRaw("JSON_EXTRACT(league, '$.id') = ?", [$league->api_id])
            ->when($request->round, function($query) use ($request){
                $query->whereRaw("TRIM(BOTH ' ' FROM SUBSTRING_INDEX(JSON_UNQUOTE(JSON_EXTRACT(league, '$.round')), '-', -1)) = ?", [$request->round]);
            })
            ->when($request->status, function($query) use ($request){
                switch ($request->status) {
                    case Fixture::FINISHED: //2
                        $query->whereRaw("JSON_EXTRACT(status, '$.long') = ?", ['Match Finished']);
                        break;
                    case Fixture::NOT_STARTED: //1
                        $query->whereRaw("JSON_EXTRACT(status, '$.long') = ?", ['Not Started']);
                        break;
                    case Fixture::LIVE: 
                        $query->whereRaw("TRIM(BOTH ' ' FROM JSON_UNQUOTE(JSON_EXTRACT(status, '$.long'))) NOT IN (?, ?)", ['Match Finished', 'Not Started']);
                        break;
                }
            })
            ->paginate($request->per_page);
            
            return response()->json($fixtures);

        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => $th,
            ]);
        }
    }

    public function getRounds(GetFixturesByLeagueRequest $request){
        try {
            $league = League::where('slug', $request->league_slug)->first();

            $roundsCount = Fixture::whereRaw("JSON_EXTRACT(league, '$.id') = ?", [$league->api_id])
            ->distinct()
            ->count(DB::raw("TRIM(BOTH ' ' FROM SUBSTRING_INDEX(JSON_UNQUOTE(JSON_EXTRACT(league, '$.round')), '-', -1))"));

            return response()->json($roundsCount);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th,
            ]);
        }
    }

    public function getFixtureByClub(GetFixtureByClubRequest $request){
        try {
            $team = Team::where('slug', $request->team_slug)->first();
            
            $fixtures = Fixture::where(function($query) use ($team){
                $query->whereRaw("JSON_EXTRACT(teams, '$.home.id') = ?", [$team->api_id])
                ->orWhereRaw("JSON_EXTRACT(teams, '$.away.id') = ?", [$team->api_id]);
            })
            ->when($request->status, function($query) use ($request){
                switch ($request->status) {
                    case Fixture::FINISHED: //2
                        $query->whereRaw("JSON_EXTRACT(status, '$.long') = ?", ['Match Finished']);
                        break;
                    case Fixture::NOT_STARTED: //1
                        $query->whereRaw("JSON_EXTRACT(status, '$.long') = ?", ['Not Started']);
                        break;
                    case Fixture::LIVE: 
                        $query->whereRaw("TRIM(BOTH ' ' FROM JSON_UNQUOTE(JSON_EXTRACT(status, '$.long'))) NOT IN (?, ?)", ['Match Finished', 'Not Started']);
                        break;
                }
            })
            ->when($request->limit, function($query) use ($request){
                $query->limit($request->limit);
            })
            ->get();

            return response()->json($fixtures);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th,
            ]);
        }
    }
}
