<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\DataTables\TeamDataTable;
use App\Domain\Team\Models\Team;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class TeamController
{
    use AuthorizesRequests;

    public function index(TeamDataTable $dataTable)
    {
        $this->authorize('view', Team::class);

        return $dataTable->render('admin.teams.index');
    }

    public function edit(Team $team): View
    {
        $this->authorize('update', $team);

        return view('admin.teams.edit', compact('team'));
    }

    public function update(Team $team, Request $request)
    {
        $this->authorize('update', $team);
        $team->update($request->except('logo'));
        if ($request->hasFile('logo')) {
            $team->addMedia($request->file('logo'))->toMediaCollection('team');
        }
        flash()->success(__('Team ":model" đã được cập nhật thành công!', ['model' => $team->name]));

        logActivity($team, 'update'); // log activity

        return intended($request, route('admin.api.teams'));
    }

    public function destroy($id){
        $country = Team::find($id);
        $country->delete();

        return response()->json([
            'success' => true,
            'message' => __('Đội tuyển đã được xóa thành công!'),
        ]);
    }
}
