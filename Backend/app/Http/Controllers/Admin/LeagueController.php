<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LeagueDataTable;
use App\Domain\League\Models\League;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeagueController
{
    use AuthorizesRequests;

    public function index(LeagueDataTable $dataTable)
    {
        $this->authorize('view', League::class);

        return $dataTable->render('admin.leagues.index');
    }
    public function create(): View
    {
        $this->authorize('create', League::class);
        return view('admin.leagues.create');
    }
    public function delete($id){
        $league = League::find($id);
        $league->delete();

        return response()->json([
            'success' => true,
            'message' => __('Giải đấu đã được xóa thành công!'),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', League::class);
        $data = $request->all();
        $league = League::create($data);
        if ($request->hasFile('logo')) {
            $league->addMedia($request->file('logo'))->toMediaCollection('league');
        }
        flash()->success(__('Giải đấu ":model" đã tạo thành công !', ['model' => $league->name]));

        logActivity($league, 'create'); // log activity

        return intended($request, route('admin.api.leagues'));
    }

    public function edit(League $league): View
    {
        $this->authorize('update', $league);

        return view('admin.leagues.edit', compact('league'));
    }

    public function update(League $league, Request $request)
    {
        $this->authorize('update', $league);
        $league->update($request->except('logo'));
        if ($request->hasFile('logo')) {
            $league->addMedia($request->file('logo'))->toMediaCollection('league');
        }
        flash()->success(__('Giải đấu ":model" đã được cập nhật thành công!', ['model' => $league->name]));

        logActivity($league, 'update'); // log activity

        return intended($request, route('admin.api.leagues'));
    }
}
