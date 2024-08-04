<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ToolRedirecterStore;
use Illuminate\Http\Request;
use App\Models\ToolRedirecter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

class ToolRedirecterController
{
    //
    protected $toolRedirecter;


    public function __construct(ToolRedirecter $toolRedirecter)
    {
        $this->toolRedirecter = $toolRedirecter;
    }

    /**
     * get list tool redirecter
     * params page
     * params perpage 
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage =  $request->input('perPage', 15);

        $query = $this->toolRedirecter->newQuery();

        // Fetch the paginated list of ToolRedirecters
        $toolRedirecters = $query->paginate($perPage, ['*'], 'page', $page);
        return response()->json($toolRedirecters);
    }

    public function store(Request $request)
    {

        try {

            $validate = Validator::make($request->all(), [
                'origin_link' => 'required',
                'redirect_link' => 'required',
                'start_at' => 'required|date_format:Y-m-d',
                'start_at' => 'date_format:Y-m-d',
            ]);

            if ($validate->fails()) {
                return response()->json($validate->messages(), 422);
            }
            $dataToolRedirecter = [
                'origin_link' => $request->origin_link,
                'redirect_link' => $request->redirect_link,
                'start_at' => $request->start_at,
                'status' => true,
                'end_at' =>  $request->end_at ?? null,
            ];
            $this->toolRedirecter->create($dataToolRedirecter);
            return response()->json(['message' => "success", "status" => 200]);
            // Validate the incoming request data
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 500);
        }
    }
    public function update(Request $request, $id)
    {

        try {

            $this->toolRedirecter->findOrFail($id);

            $validate = Validator::make($request->all(), [
                'origin_link' => 'required',
                'redirect_link' => 'required',
                'start_at' => 'required|date_format:Y-m-d',
                'start_at' => 'date_format:Y-m-d',
            ]);

            if ($validate->fails()) {
                return response()->json($validate->messages(), 422);
            }
            $dataToolRedirecter = [
                'origin_link' => $request->origin_link,
                'redirect_link' => $request->redirect_link,
                'start_at' => $request->start_at,
                'status' => $request->status,
                'end_at' =>  $request->end_at ?? null,
            ];

            $this->toolRedirecter->where('id', $id)->update($dataToolRedirecter);
            return response()->json(['message' => "success", "status" => 200]);
            // Validate the incoming request data
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 500);
        }
    }

    public function delete($id)
    {

        try {

            $toolRedirecterInfo = $this->toolRedirecter->findOrFail($id);
            $toolRedirecterInfo->delete();
            return response()->json(['message' => "success", "status" => 200]);
            // Validate the incoming request data
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 500);
        }
    }
}
