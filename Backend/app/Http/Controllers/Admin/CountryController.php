<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CountryDataTable;
use App\Domain\Country\Models\Country;
use App\Http\Requests\Admin\CountryUpdateRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class CountryController
{
    use AuthorizesRequests;

    public function index(CountryDataTable $dataTable)
    {
        $this->authorize('view', Country::class);

        return $dataTable->render('admin.countries.index');
    }

    public function delete($id){
        $country = Country::find($id);
        $country->delete();

        return response()->json([
            'success' => true,
            'message' => __('Quốc gia đã được xóa thành công!'),
        ]);
    }

    public function edit(Country $country): View
    {
        $this->authorize('update', $country);

        return view('admin.countries.edit', compact('country'));
    }

    public function update(Country $country, CountryUpdateRequest $request)
    {
        $this->authorize('update', $country);
        $country->update($request->except('flag'));
        if ($request->hasFile('flag')) {
            $country->addMedia($request->file('flag'))->toMediaCollection('country');
        }
        flash()->success(__('Country ":model" đã được cập nhật thành công!', ['model' => $country->name]));

        logActivity($country, 'update'); // log activity

        return intended($request, route('admin.api.countries'));
    }
}
