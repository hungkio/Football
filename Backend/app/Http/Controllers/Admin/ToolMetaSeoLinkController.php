<?php

namespace App\Http\Controllers\Admin;
// use App\Models\ToolMetaSeoLink;
use App\Models\ToolMetaSeoLinkTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Domain\ToolMetaSeoLink\Models\ToolMetaSeoLink;
use App\DataTables\ToolMetaSeoLinkDataTable;
use Illuminate\View\View;

class ToolMetaSeoLinkController
{
    //
    protected $toolMetaSeoLink;
    protected $toolMetaSeoLinkTransaction;
    use AuthorizesRequests;


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

    public function index(ToolMetaSeoLinkDataTable $dataTable)
    {
        $this->authorize('view', ToolMetaSeoLink::class);

        return $dataTable->render('admin.tools-meta-seo-link.index');
    }


    public function create(): View
    {

        $this->authorize('create', ToolMetaSeoLinkDataTable::class);
        return view('admin.tools-meta-seo-link.create');
    }


    public function edit(ToolMetaSeoLink $tool): View
    {
        $this->authorize('update', $tool);

        return view('admin.tools-meta-seo-link.edit', compact('tool'));
    }


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $validate = Validator::make($request->all(), [
                'redirect_link' => 'required|url', // Ensures redirect_link is a valid URL
                'meta_canonical' => 'required',
                'name_vi' => 'required|string|max:255',
                'meta_title_vi' => 'required|string|max:255',
                'meta_keyword_vi' => 'nullable|string|max:255',
                'meta_description_vi' => 'nullable|string|max:1000',
                'content_header_vi' => 'nullable|string|max:1000',
                'content_footer_vi' => 'nullable|string|max:1000',
                'name_en' => 'required|string|max:255',
                'meta_title_en' => 'required|string|max:255',
                'meta_keyword_en' => 'nullable|string|max:255',
                'meta_description_en' => 'nullable|string|max:1000',
                'content_header_en' => 'nullable|string|max:1000',
                'content_footer_en' => 'nullable|string|max:1000',
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
