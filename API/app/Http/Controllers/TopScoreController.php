<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetTopScoresByLeagueRequest;
use App\Models\League;
use App\Models\Player;
use App\Models\Team;
use App\Models\TopScore;
use Illuminate\Http\Request;

class TopScoreController extends Controller
{
    public function index(GetTopScoresByLeagueRequest $request){
        try {
            $league = League::where('slug', $request->league_slug)->first();
            $topscores = TopScore::where('league_id', $league->api_id)
            ->where('season', $request->season)
            ->orderBy('goals', 'desc')->get();
            foreach ($topscores as $topscore) {
                $player = Player::where('api_id', $topscore->player_id)->first();
                $team = Team::where('api_id', $topscore->team_id)->first();
                $topscore->player_name = $player->name;
                $topscore->team = $team->name;
            }
            return response()->json([
                'status' => true,
                'data' => $topscores,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => true,
                'data' => $th,
            ]);
        }
    }

    public function getTopScoresByTeam(Request $request){
        $team = Team::where('slug', $request->team_slug)->first();
        $leagues = TopScore::select('league_id', 'season')
                ->where('team_id', $team->api_id)
                ->whereIn('season', function($query) use ($team) {
                    $query->selectRaw('MAX(season)')
                        ->from('top_scores')
                        ->where('team_id', $team->api_id);
                })
                ->orderBy('goals', 'desc')
                ->distinct()
                ->get();

        $arr = [];
        foreach ($leagues as $league) {
            $leagueName = League::where('api_id', $league->league_id)->pluck('name')->first();
            $arr[$leagueName .' - '. $league->season][] = TopScore::where('league_id', $league->league_id)
            ->where('season', $league->season)
            ->orderBy('goals', 'desc')
            ->where('team_id', $team->api_id)
            ->distinct()
            ->get();
        }
        
        return response()->json($arr);
        // $leagueNames = League::whereIn('api_id', $leagueIds)->pluck('name')->toArray();
        // $arr = [];
        // foreach ($leagueNames as $leagueName) {
        //     # code...
        //     $arr[$leagueName][] = T
        // }
    }
}
