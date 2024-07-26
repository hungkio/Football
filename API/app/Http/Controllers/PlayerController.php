<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetPlayersRequest;
use App\Models\Player;
use App\Models\PlayerStatistic;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index(GetPlayersRequest $request){
        try {
            $players = Player::when(isset($request->keyword), function($query) use ($request){
                $query->where('name','like', $request->keyword . '%')
                      ->orWhere('api_id', 'like', $request->keyword . '%');
            })
            ->when(isset($request->team_id), function($query) use ($request){
                $playerStatistics = PlayerStatistic::where('team_id',$request->team_id)
                                            ->where('league_id', $request->league_id)
                                            ->where('season', $request->season)
                                            ->get();
                $player_ids = [];
                foreach ($playerStatistics as $playerStatistic) {
                    $player_ids[] = $playerStatistic->player_id;
                }
                $query->whereIn('api_id', $player_ids);
            })
            ->paginate($request->per_page);
            foreach ($players as $player) {
                $player->statistics = PlayerStatistic::where('player_id', $player->api_id)->get()->toArray();
            }
            return response()->json([
                'status' => true,
                'data' => $players
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th
            ]);
        }
    }

    public function details($player){
        $player = Player::find($player);
        $player->statistics = PlayerStatistic::where('player_id', $player->api_id)->get()->toArray();
        return response()->json([
            'status' => true,
            'data' => $player
        ]);
    }
}
