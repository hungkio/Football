<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ToolAutoLinkDataTable;
use App\Domain\Team\Models\Team;
// use App\Models\ToolAutoLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Domain\ToolAutoLink\Models\ToolAutoLink;
use Illuminate\View\View;

class ToolAutoLinkController
{
    protected $toolAutoLink;
    use AuthorizesRequests;


    public function __construct(ToolAutoLink $toolAutoLink)
    {
        $this->toolAutoLink = $toolAutoLink;
    }

    /**
     * get list tool redirecter
     * params page
     * params perpage 
     */
    public function index(ToolAutoLinkDataTable $dataTable)
    {
        $this->authorize('view', ToolAutoLink::class);

        return $dataTable->render('admin.tools-auto-link.index');
    }


    public function create(): View
    {

        $this->authorize('create', ToolAutoLinkDataTable::class);
        return view('admin.tools-auto-link.create');
    }


    public function edit(ToolAutoLink $tool): View
    {
        $this->authorize('update', $tool);

        return view('admin.tools-auto-link.edit', compact('tool'));
    }

    // public function edit(ToolAutoLinkDataTable $team): View
    // {
    //     $this->authorize('update', $team);
    //     // dd($team);

    //     return view('admin.tools-auto-link.edit', compact('team'));
    // }

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
            return intended($request, route('admin.api.tools-auto-link'));

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
            return intended($request, route('admin.api.tools-auto-link'));

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
