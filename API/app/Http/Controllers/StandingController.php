<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetStandingByLeagueRequest;
use App\Models\Fixture;
use App\Models\League;
use App\Models\Standing;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StandingController extends Controller
{
    function index(GetStandingByLeagueRequest $request) {
        $league = League::where('slug', $request->league_slug)->first();
        $standings = Standing::where('league_id', $league->api_id)
        ->where('season', $request->season)
        ->paginate($request->per_page);
        foreach ($standings as $standing) {
            $team = Team::where('api_id', $standing->team_id)->first();
            $standing->team_name = $team ? $team->name : '';

            $fixtures = Fixture::whereRaw("JSON_EXTRACT(league, '$.id') = ?", [$standing->league_id])
                              ->whereRaw("JSON_EXTRACT(league, '$.season') = ?", [$standing->season])
                              ->where(function ($query) use ($standing) {
                                    $query->whereRaw("JSON_EXTRACT(teams, '$.home.id') = ?", [$standing->team_id])
                                    ->orWhereRaw("JSON_EXTRACT(teams, '$.away.id') = ?", [$standing->team_id]);
                                })
                              ->orderBy('date', 'desc')->limit(5)->get();
            $fiveRecentMatchesResults = [];
            foreach ($fixtures as $fixture) {
                $result = $this->checkTeamResult($fixture->teams, $standing->team_id, $fixture->goals);
                $fiveRecentMatchesResults[] = $result;
            }
            $standing->five_recent_matches = $fiveRecentMatchesResults;
        }
        return response()->json($standings);
    }

    private function checkTeamResult($teams, $teamId, $goals)
    {
        if ($goals['home'] !== null && $goals['away'] !== null) {
            // Kiểm tra đội nhà
            if ($teams['home']['id'] == $teamId && $teams['home']['winner'] !== null) {
                return $teams['home']['winner'] === true ? 'win' : 'lose';
            }
            
            // Kiểm tra đội khách
            if ($teams['away']['id'] == $teamId && $teams['away']['winner'] !== null) {
                return $teams['away']['winner'] === true ? 'win' : 'lose';
            }
            
            // Trường hợp không tìm thấy đội
            return 'draw';
        }else{
            return null;
        }
    }
}
