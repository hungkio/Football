<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\PlayerStatistic;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index(Request $request){
        try {
            $players = Player::when(isset($request->keyword), function($query) use ($request){
                $query->where('name','like', $request->keyword . '%')
                      ->orWhere('api_id', 'like', $request->keyword . '%');
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
}
