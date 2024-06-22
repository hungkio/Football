<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function getAll(){
        $menus = Menu::all();
        return response($menus, 200);
    }
}
