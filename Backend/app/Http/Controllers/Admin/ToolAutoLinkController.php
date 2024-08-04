<?php

namespace App\Http\Controllers\Admin;

use App\Models\ToolAutoLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ToolAutoLinkController
{
    protected $toolAutoLink;


    public function __construct(ToolAutoLink $toolAutoLink)
    {
        $this->toolAutoLink = $toolAutoLink;
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
        $keyWord =  $request->input('key_word', null);

        $query = $this->toolAutoLink->newQuery();
        if ($keyWord) {
            // For example, assuming 'name' is a column you want to filter by
            $query->where('key_word', 'like', "%{$keyWord}%");
        }

        // Fetch the paginated list of ToolRedirecters
        $toolRedirecters = $query->paginate($perPage,['*'], 'page', $page);
        return response()->json($toolRedirecters);
    }

    public function store(Request $request)
    {

        try {

            $validate = Validator::make($request->all(), [
                'key_word' => 'required',
                'redirect_link' => 'required'
            ]);

            if ($validate->fails()) {
                return response()->json($validate->messages(), 422);
            }
            $dataToolAutoLink = [
                'key_word' => $request->key_word,
                'redirect_link' => $request->redirect_link,
            ];
            $this->toolAutoLink->create($dataToolAutoLink);
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

            $this->toolAutoLink->findOrFail($id);

            $validate = Validator::make($request->all(), [
                'key_word' => 'required',
                'redirect_link' => 'required'
            ]);

            if ($validate->fails()) {
                return response()->json($validate->messages(), 422);
            }
            $dataToolAutoLink = [
                'key_word' => $request->key_word,
                'redirect_link' => $request->redirect_link,
            ];

            $this->toolAutoLink->where('id', $id)->update($dataToolAutoLink);
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

            $toolRedirecterInfo = $this->toolAutoLink->findOrFail($id);
            $toolRedirecterInfo->delete();
            return response()->json(['message' => "success", "status" => 200]);
            // Validate the incoming request data
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 500);
        }
    }
}
