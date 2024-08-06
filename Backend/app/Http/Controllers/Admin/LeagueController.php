<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LeagueDataTable;
use App\Domain\Country\Models\Country;
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
        $countries = Country::all();
        $country_codes = [];
        foreach ($countries as $country) {
            if ($country->code) {
                $country_codes[] = $country->code;
            }
        }
        return view('admin.leagues.create', compact('country_codes'));
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
        $data['popular'] = isset($data['popular'])?1:0;
        $data['shown_on_country_standing'] = isset($data['shown_on_country_standing'])?1:0;
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
        $countries = Country::all();
        $country_codes = [];
        foreach ($countries as $country) {
            if ($country->code) {
                $country_codes[] = $country->code;
            }
        }
        return view('admin.leagues.edit', compact('league', 'country_codes'));
    }

    public function update(League $league, Request $request)
    {
        $this->authorize('update', $league);
        $data = $request->except('logo');
        $data['popular'] = isset($data['popular'])?1:0;
        $data['shown_on_country_standing'] = isset($data['shown_on_country_standing'])?1:0;
        $league->update($data);
        if ($request->hasFile('logo')) {
            $league->addMedia($request->file('logo'))->toMediaCollection('league');
        }
        flash()->success(__('Giải đấu ":model" đã được cập nhật thành công!', ['model' => $league->name]));

        logActivity($league, 'update'); // log activity

        return intended($request, route('admin.api.leagues'));
    }

    public function savePriority(Request $request){
        $league = League::find($request->league_id);
        $league->priority = $request->priority;
        $league->save();
        flash()->success(__('Giải đấu ":model" đã được cập nhật thành công!', ['model' => $league->name]));
        logActivity($league, 'update'); // log activity
        return intended($request, route('admin.api.leagues'));
    }
    public function savePSP(Request $request){
        $data = $request->all();
        $priority = $data['priority'];
        foreach ($priority as $key => $value){
            if($value){
                $league = League::find($key);
                $league->priority = $value;
                $league->save();
            }
        }
        $shown_standing = $data['shown_standing'];
        foreach ($shown_standing as $key => $value){
            if($value){
                $league = League::find($key);
                $league->shown_on_country_standing = $value;
                $league->save();
            }
        }
        $popular = $data['popular'];
        foreach ($popular as $key => $value){
            if($value){
                $league = League::find($key);
                $league->popular = $value;
                $league->save();
            }
        }
        logActivity($league, 'update'); // log activity
        return array('status'=>true,'message'=>__('Giải đấu ":model" đã được cập nhật thành công!', ['model' => $league->name]));
    }
}
