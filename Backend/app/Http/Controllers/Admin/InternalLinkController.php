<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\InternalLinkDataTable;
use App\Domain\Menu\Models\InternalLink;
use Illuminate\Http\Request;

class InternalLinkController
{
    public function index(InternalLinkDataTable $dataTable){
        return $dataTable->render('admin.internal-links.index');
    }

    public function save(Request $request){
        $request->id ? $internalLink = InternalLink::find($request->id) : $internalLink = new InternalLink;
        $internalLink->url = $request->url;
        $internalLink->save();
        return redirect()->back();
    }

    public function edit($id){
        $internalLink = InternalLink::find($id);
        return view('admin.internal-links.edit', compact('internalLink', 'id'));
    }

    public function delete($id){
        InternalLink::find($id)->delete();
        return redirect()->back();
    }
}
