<?php

namespace App\Http\Controllers\Api;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google;

class UserController extends Controller
{
    /**
     * 获取用户信息 - 基本信息
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
                'introduction' => '菜鸟大神',
                'name' => $user->name,
                'roles' => [$user->role->name]
            ];
        }

        return response()->json(['code'=>20000,'message'=>'获取成功','data'=>$result]);
    }

    /**
     * 获取用户信息 - 重要信息
     * @param Request $request
     */
    public function getUserInfoImportant(Request $request)
    {
        $user = auth()->user();
        if(!$user) {
            $result = [];
        } else {
            $result = [
                'name' => $user->name,
                'username' => $user->username,
                'avatar' => $user->avatar,
                'mId' => $user->merchant_id,
                'mKey' => $user->merchant_key,
                'balance' => $user->balance,
                'googleStatus' => $user->google_status,
                'googleCode' => $user->google_code,
                'googleSecret' => $user->google_secret
            ];
        }

        return response()->json(['code'=>20000,'message'=>'获取成功','data'=>$result]);
    }

    /**
     * 更新谷歌状态
     * @param Request $request
     */
    public function updateGoogleStatus(Request $request)
    {
        $user = auth()->user();

        $user->google_status = $request->status;

        if($request->status == 1) {
            if(empty($user->google_secret) && empty($user->google_code)) {
                $createSecret = Google::CreateSecret();
                $user->google_secret = $createSecret['secret'];
                $user->google_code = $createSecret['codeurl'];
            }else {
                $createSecret = [
                    "secret" => $user->google_secret,
                    "code" => $user->google_code
                ];
            }
        }else {
            $createSecret = [];
        }

        if($user->save()) {
            return response()->json(['code'=>20000,'message'=>'更新成功','data'=>$createSecret]);
        }

        return response()->json(['code'=>50000,'message'=>'更新失败']);
    }

    /**
     * 获取用户角色路由
     */
    public function getUserRole()
    {
        $user = auth()->user();
        dd($user);
    }
}
