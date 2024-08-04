<?php

namespace App\Http\Controllers\Admin;

use App\Models\ToolMetaSeoLink;
use App\Models\ToolMetaSeoLinkTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ToolMetaSeoLinkController
{
    //
    protected $toolMetaSeoLink;
    protected $toolMetaSeoLinkTransaction;


    public function __construct(ToolMetaSeoLink $toolMetaSeoLink, ToolMetaSeoLinkTransaction $toolMetaSeoLinkTransaction)
    {
        $this->toolMetaSeoLink = $toolMetaSeoLink;
        $this->toolMetaSeoLinkTransaction = $toolMetaSeoLinkTransaction;
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

        $query = $this->toolMetaSeoLink->newQuery();
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
                'language.*.meta_title' => 'required|string|max:255',
                'language.*.meta_keyword' => 'nullable|string|max:255',
                'language.*.meta_description' => 'nullable|string|max:1000',
                'language.*.content_header' => 'nullable|string|max:1000',
                'language.*.content_footer' => 'nullable|string|max:1000',
            ]);

            $params = $request->all();
            if ($validate->fails()) {
                return response()->json($validate->messages(), 422);
            }
            $dataToolRedirecter = [
                'meta_canonical' => $request->meta_canonical,
                'redirect_link' => $request->redirect_link,
            ];

            $metaSeoLinkInfo = $this->toolMetaSeoLink->create($dataToolRedirecter);
            foreach ($params['language'] as $key => $value) {
                $this->toolMetaSeoLinkTransaction->create([
                    'name' => $value['name'],
                    'meta_seo_link_id' => $metaSeoLinkInfo['id'],
                    'lang' => $value['lang'],
                    'meta_title' => $value['meta_title'],
                    'meta_keyword' => $value['meta_keyword'],
                    'meta_description' => $value['meta_description'],
                    'content_header' => $value['content_header'],
                    'content_footer' => $value['content_footer'],
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

            $this->toolMetaSeoLink->findOrFail($id);

            $validate = Validator::make($request->all(), [
                'redirect_link' => 'required|url', // Ensures redirect_link is a valid URL
                'meta_canonical' => 'required',
                'language' => 'required|array',
                'language.*.name' => 'required|string|max:255',
                'language.*.lang' => 'required|string|max:10',
                'language.*.meta_title' => 'required|string|max:255',
                'language.*.meta_keyword' => 'nullable|string|max:255',
                'language.*.meta_description' => 'nullable|string|max:1000',
                'language.*.content_header' => 'nullable|string|max:1000',
                'language.*.content_footer' => 'nullable|string|max:1000',
            ]);

            $params = $request->all();
            if ($validate->fails()) {
                return response()->json($validate->messages(), 422);
            }

            $this->toolMetaSeoLink->where('id', $id)->update([
                'meta_canonical' => $request->meta_canonical,
                'redirect_link' => $request->redirect_link,
            ]);
            $this->toolMetaSeoLinkTransaction->where('meta_seo_link_id', $id)->delete();
            foreach ($params['language'] as $key => $value) {
                $this->toolMetaSeoLinkTransaction->create([
                    'name' => $value['name'],
                    'meta_seo_link_id' => $id,
                    'lang' => $value['lang'],
                    'meta_title' => $value['meta_title'],
                    'meta_keyword' => $value['meta_keyword'],
                    'meta_description' => $value['meta_description'],
                    'content_header' => $value['content_header'],
                    'content_footer' => $value['content_footer'],
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

            $toolMetaSeoLink = $this->toolMetaSeoLink->findOrFail($id);
            $toolMetaSeoLink->delete();
            $this->toolMetaSeoLinkTransaction->where('meta_seo_link_id', $id)->delete();
            DB::commit();

            return response()->json(['message' => "success", "status" => 200]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json($th->getMessage(), 500);
        }
    }
}
