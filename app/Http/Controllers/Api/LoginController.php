<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Google;

class LoginController extends Controller
{

    /***
     * 后台管理员登录
     * @param Request $request
     */
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $googleCode = $request->googleCode;

        if (empty($username) || empty($password)) {
            return response()->json(['code' => 40001, 'message' => '账号或密码为必填！']);
        }

        $user = User::where('username', $username)->first();
        if (!$user) {
            return response()->json(['code' => 40001, 'message' => '用户不存在！']);
        }

        if (!Hash::check($password, $user->password)) {
            return response()->json(['code' => 40001, 'message' => '密码错误！']);
        }

        if($user->google_status == 1) {
            if(empty($googleCode)) {
                return response()->json(['code' => 40001, 'message' => '请输入谷歌验证码！']);
            }

            if(!Google::CheckCode($user->google_secret, $googleCode)) {
                return response()->json(['code' => 40001, 'message' => '谷歌验证码不正确！']);
            }
        }

        $credentials = request(['username', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['code' => 40001, 'message' => '授权失败！']);
        }

        return response()->json([
            'code' => 20000,
            'message' => '登录成功！',
            'token' => $token,
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    /**
     * Log the admin out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['code'=>20000,'message' => '登出成功']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
