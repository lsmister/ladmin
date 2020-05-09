<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function index(Request $request)
    {
        $p = Permission::GetMenuTree();
//        $menu = $p->childrens()->toArray();

//        $p = Permission::find(1);
//        $data = $p->childrens->toArray();
//        dd($data);

        dd($p);
    }
}
