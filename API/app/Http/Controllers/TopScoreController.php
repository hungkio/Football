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
}
