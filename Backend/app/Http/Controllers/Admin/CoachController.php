<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CoachDataTable;
use App\Domain\Coach\Models\Coach;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoachController
{
    use AuthorizesRequests;

    public function index(CoachDataTable $dataTable)
    {
        $this->authorize('view', Coach::class);

        return $dataTable->render('admin.coaches.index');
    }
    public function create(): View
    {
        $this->authorize('create', Coach::class);
        return view('admin.coaches.create');
    }
    public function delete($id){
        $coach = Coach::find($id);
        $coach->delete();

        return response()->json([
            'success' => true,
            'message' => __('HLV đã được xóa thành công!'),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Coach::class);
        $data = $request->all();
        $coach = Coach::create($data);
        if ($request->hasFile('photo')) {
            $coach->addMedia($request->file('photo'))->toMediaCollection('coach');
        }
        flash()->success(__('Đội tuyển ":model" đã tạo thành công !', ['model' => $coach->name]));

        logActivity($coach, 'create'); // log activity

        return intended($request, route('admin.api.coaches'));
    }

    public function edit(Coach $coach): View
    {
        $this->authorize('update', $coach);

        return view('admin.coaches.edit', compact('coach'));
    }

    public function update(Coach $coach, Request $request)
    {
        $this->authorize('update', $coach);
        $coach->update($request->except('logo'));
        if ($request->hasFile('logo')) {
            $coach->addMedia($request->file('logo'))->toMediaCollection('coach');
        }
        flash()->success(__('HLV ":model" đã được cập nhật thành công!', ['model' => $coach->name]));

        logActivity($coach, 'update'); // log activity

        return intended($request, route('admin.api.coaches'));
    }
}
