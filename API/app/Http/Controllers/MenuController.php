<?php

namespace App\Http\Controllers;

use App\Domain\Menu\Models\MenuItem;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function getAll(){
        $menus = Menu::all();
        return response($menus, 200);
    }

    public function getMenuPosition($position) {
        $rootMenu = MenuItem::where('menu_id', setting('menu_header', 1))->whereNull('parent_id')->first();
        if (!$rootMenu) {
            return collect([]);
        }

        $items = MenuItem::where('parent_id', $rootMenu->id)
            ->with('childs')->get();

        return response($items, 200);

    }
}
