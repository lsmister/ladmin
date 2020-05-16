<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 获取用户信息
     * @param Request $request
     */
    public function getUserInfo(Request $request)
    {
        $user = auth()->user();
        if(!$user) {
            $result = [];
        } else {
            $result = [
                'avatar' => $user->avatar,
                'introduction' => '',
                'name' => $user->name,
                'roles' => [$user->role->name]
            ];
        }

        return response()->json($result);
    }
}
