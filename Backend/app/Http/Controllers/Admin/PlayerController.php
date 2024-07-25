<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\DataTables\PlayerDataTable;
use App\Domain\Player\Models\Player;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class PlayerController
{
    use AuthorizesRequests;

    public function index(PlayerDataTable $dataTable)
    {
        $this->authorize('view', Player::class);

        return $dataTable->render('admin.players.index');
    }

    public function create(): View
    {
        $this->authorize('create', Player::class);
        return view('admin.players.create');
    }

    public function edit(Player $player): View
    {
        $this->authorize('update', $player);

        return view('admin.players.edit', compact('player'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Player::class);
        $data = $request->all();
        $data['api_id'] = Carbon::now()->timestamp;
        $player = Player::create($data);
        $player->api_id = $player->id;
        $player->save();
        if ($request->hasFile('photo')) {
            $player->addMedia($request->file('photo'))->toMediaCollection('player');
        }
        flash()->success(__('Đội tuyển ":model" đã tạo thành công !', ['model' => $player->name]));

        logActivity($player, 'create'); // log activity

        return intended($request, route('admin.api.players'));
    }

    public function update(Player $player, Request $request)
    {
        $this->authorize('update', $player);
        $player->update($request->except('photo'));
        if ($request->hasFile('photo')) {
            $player->addMedia($request->file('photo'))->toMediaCollection('player');
        }
        flash()->success(__('Player ":model" đã được cập nhật thành công!', ['model' => $player->name]));

        logActivity($player, 'update'); // log activity

        return intended($request, route('admin.api.players'));
    }

    public function delete($id){
        $country = Player::find($id);
        $country->delete();

        return response()->json([
            'success' => true,
            'message' => __('Cầu thủ đã được xóa thành công!'),
        ]);
    }
}
