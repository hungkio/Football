<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\DataTables\FixtureDataTable;
use App\Domain\Fixture\Models\Fixture;
use App\Domain\Post\Models\Post;
use App\Domain\League\Models\League;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class FixtureController
{
    use AuthorizesRequests;

    public function index(FixtureDataTable $dataTable)
    {
        $this->authorize('view', Fixture::class);
        $leagues = League::orderBy('priority')->get();
        $get = $request->all();
        $league_selected = isset($get['league'])?$get['league']:'';
        return $dataTable->render('admin.fixtures.index',compact('leagues','league_selected'));
    }

    public function create(): View
    {
        $this->authorize('create', Fixture::class);
        return view('admin.fixtures.create');
    }

    public function edit(Fixture $fixture): View
    {
        $this->authorize('update', $fixture);
        $posts = Post::all();

        return view('admin.fixtures.edit', compact('fixture', 'posts'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Fixture::class);
        $data = [
            'api_id' => $request->api_id,
            'referee' => $request->referee,
            'date' => $request->date,
            'content' => $request->content,
            'vi_content' => $request->vi_content,
            'periods' => json_encode([
                'first' => Carbon::createFromFormat('Y-m-d', $request->round_1)->timestamp,
                'second' => Carbon::createFromFormat('Y-m-d', $request->round_2)->timestamp
            ]),
            'venue' => json_encode(
                [
                    'id' => $request->venue_id
                ]),
            'league' => json_encode([
                'id' => $request->league_id
            ]),
            'teams' => json_encode([
                'home' => [
                    'name'=> $request->team_home
                ],
                'away' => [
                    'name'=> $request->team_away
                ],
            ]),
            'goals' => json_encode([
                'home' => $request->goals_home,
                'away' => $request->goals_away,
            ])
        ];

        $fixture = Fixture::create($data);
        if ($request->hasFile('photo')) {
            $fixture->addMedia($request->file('photo'))->toMediaCollection('fixture');
        }
        flash()->success(__('Trận đấu ":model" đã tạo thành công !', ['model' => $fixture->api_id]));

        logActivity($fixture, 'create'); // log activity

        return intended($request, route('admin.api.fixtures'));
    }

    public function update(Fixture $fixture, Request $request)
    {
        $this->authorize('update', $fixture);
        $data = [
            'api_id' => $request->api_id,
            'referee' => $request->referee,
            'date' => $request->date,
            'content' => $request->content,
            'vi_content' => $request->vi_content,
            'related_posts' => $request->related_posts,
            'periods' => json_encode([
                'first' => $request->round_1 ? Carbon::createFromFormat('Y-m-d', $request->round_1)->timestamp : null,
                'second' => $request->round_2 ? Carbon::createFromFormat('Y-m-d', $request->round_2)->timestamp : null
            ]),
            // 'venue' => json_encode(
            //     [
            //         'id' => $request->venue_id
            //     ]),
            // 'league' => json_encode([
            //     'id' => $request->league_id
            // ]),
            // 'teams' => json_encode([
            //     'home' => [
            //         'name'=> $request->team_home
            //     ],
            //     'away' => [
            //         'name'=> $request->team_away
            //     ],
            // ]),
            'goals' => json_encode([
                'home' => $request->goals_home,
                'away' => $request->goals_away,
            ])
        ];
        $fixture->update($data);
        flash()->success(__('Trận đấu ":model" đã được cập nhật thành công!', ['model' => $fixture->api_id]));

        logActivity($fixture, 'update'); // log activity

        return intended($request, route('admin.api.fixtures'));
    }

    public function delete($id){
        $country = Fixture::find($id);
        $country->delete();

        return response()->json([
            'success' => true,
            'message' => __('Trận đấu đã được xóa thành công!'),
        ]);
    }
}
