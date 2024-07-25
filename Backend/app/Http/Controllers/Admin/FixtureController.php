<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\DataTables\FixtureDataTable;
use App\Domain\Fixture\Models\Fixture;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class FixtureController
{
    use AuthorizesRequests;

    public function index(FixtureDataTable $dataTable)
    {
        $this->authorize('view', Fixture::class);

        return $dataTable->render('admin.fixtures.index');
    }

    public function create(): View
    {
        $this->authorize('create', Fixture::class);
        return view('admin.fixtures.create');
    }

    public function edit(Fixture $fixture): View
    {
        $this->authorize('update', $fixture);

        return view('admin.fixtures.edit', compact('fixture'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Fixture::class);
        $data = [
            'api_id' => $request->api_id,
            'referee' => $request->referee,
            'date' => $request->date,
            'periods' => [
                'first' => $request->round_1,
                'second' => $request->round_2
            ],
            'venue' => [
                'id' => $request->venue_id
            ],
            'league' => [
                'id' => $request->league_id
            ],
            'teams' => [
                'home' => [
                    'id'=> $request->team_home
                ],
                'away' => [
                    'id'=> $request->team_away
                ],
            ],
            'goals' => [
                'home' => $request->goals_home,
                'away' => $request->goals_away,
            ]
        ];
        
        $fixture = Fixture::create($data);
        if ($request->hasFile('photo')) {
            $fixture->addMedia($request->file('photo'))->toMediaCollection('fixture');
        }
        flash()->success(__('Đội tuyển ":model" đã tạo thành công !', ['model' => $fixture->name]));

        logActivity($fixture, 'create'); // log activity

        return intended($request, route('admin.api.fixtures'));
    }

    public function update(Fixture $fixture, Request $request)
    {
        $this->authorize('update', $fixture);
        $fixture->update($request->except('photo'));
        if ($request->hasFile('photo')) {
            $fixture->addMedia($request->file('photo'))->toMediaCollection('fixture');
        }
        flash()->success(__('Fixture ":model" đã được cập nhật thành công!', ['model' => $fixture->name]));

        logActivity($fixture, 'update'); // log activity

        return intended($request, route('admin.api.fixtures'));
    }

    public function delete($id){
        $country = Fixture::find($id);
        $country->delete();

        return response()->json([
            'success' => true,
            'message' => __('Cầu thủ đã được xóa thành công!'),
        ]);
    }
}
