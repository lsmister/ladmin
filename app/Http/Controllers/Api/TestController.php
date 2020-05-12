<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function index(Request $request)
    {
        $arrs = Permission::GetAllMenus();
//        dd($arrs);
        dd(json_encode($arrs, JSON_UNESCAPED_UNICODE));
    }
}
