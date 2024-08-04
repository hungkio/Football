<?php

namespace App\Http\Controllers\Admin;

use App\Models\ToolTextSeoFooter;
use App\Models\ToolTextSeoFooterTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ToolTextSeoFooterController
{
    //
    protected $toolTextSeoFooter;
    protected $toolTextSeoFooterTransaction;


    public function __construct(ToolTextSeoFooter $toolTextSeoFooter, ToolTextSeoFooterTransaction $toolTextSeoFooterTransaction)
    {
        $this->toolTextSeoFooter = $toolTextSeoFooter;
        $this->toolTextSeoFooterTransaction = $toolTextSeoFooterTransaction;
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

        $query = $this->toolTextSeoFooter->newQuery();
        if ($keyWord) {
            // For example, assuming 'name' is a column you want to filter by
            $query->whereHas('transactions', function ($query) use ($keyWord) {
                $query->where('name', 'like', "%{$keyWord}%");
            });    
        }
        $query->with('transactions');

        // Fetch the paginated list of ToolRedirecters
        $toolRedirecters = $query->paginate($perPage, ['*'], 'page', $page);
        return response()->json($toolRedirecters);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $validate = Validator::make($request->all(), [
                'redirect_link' => 'required|url', // Ensures redirect_link is a valid URL
                'meta_canonical' => 'required',
                'language' => 'required|array',
                'language.*.name' => 'required|string|max:255',
                'language.*.lang' => 'required|string|max:10',
                'language.*.content' => 'required|string|max:255',
            ]);

            $params = $request->all();
            if ($validate->fails()) {
                return response()->json($validate->messages(), 422);
            }
            $dataToolTextSeoFooter = [
                'meta_canonical' => $request->meta_canonical,
                'redirect_link' => $request->redirect_link,
            ];

            $textSeoFooter = $this->toolTextSeoFooter->create($dataToolTextSeoFooter);
            foreach ($params['language'] as $key => $value) {
                $this->toolTextSeoFooterTransaction->create([
                    'name' => $value['name'],
                    'text_seo_footer_id' => $textSeoFooter['id'],
                    'lang' => $value['lang'],
                    'content' => $value['content'],
                    'status' => true,
                ]);
            }
            DB::commit();

            return response()->json(['message' => "success", "status" => 200]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return response()->json($th->getMessage(), 500);
        }
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $this->toolTextSeoFooter->findOrFail($id);

            $validate = Validator::make($request->all(), [
                'redirect_link' => 'required|url', // Ensures redirect_link is a valid URL
                'meta_canonical' => 'required',
                'status' => 'required|boolean',
                'language' => 'required|array',
                'language.*.name' => 'required|string|max:255',
                'language.*.lang' => 'required|string|max:10',
                'language.*.content' => 'required|string|max:255',
            ]);

            $params = $request->all();
            if ($validate->fails()) {
                return response()->json($validate->messages(), 422);
            }

            $this->toolTextSeoFooter->where('id', $id)->update([
                'meta_canonical' => $request->meta_canonical,
                'redirect_link' => $request->redirect_link,
                'status' => $request->status,
            ]);
            $this->toolTextSeoFooterTransaction->where('text_seo_footer_id', $id)->delete();
            foreach ($params['language'] as $key => $value) {
                $this->toolTextSeoFooterTransaction->create([
                    'name' => $value['name'],
                    'text_seo_footer_id' => $id,
                    'lang' => $value['lang'],
                    'content' => $value['content']
                ]);
            }
            DB::commit();

            return response()->json(['message' => "success", "status" => 200]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json($th->getMessage(), 500);
        }
    }
    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $toolTextSeoFooter = $this->toolTextSeoFooter->findOrFail($id);
            $toolTextSeoFooter->delete();
            $this->toolTextSeoFooterTransaction->where('text_seo_footer_id', $id)->delete();
            DB::commit();

            return response()->json(['message' => "success", "status" => 200]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json($th->getMessage(), 500);
        }
    }
}
