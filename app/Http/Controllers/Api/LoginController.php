<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register', 'login']]);
    }

    /***
     * 后台管理员注册
     * @param Request $request
     */
    public function register(Request $request)
    {
        $name = $request->name;
        $username = $request->username;
        $password = $request->password;
        $check_password = $request->check_password;

        if (!$name || !$password || !$username) {
            return response()->json(['success' => false, 'message' => '用户名、昵称或密码必填！']);
        }

        if ($check_password != $password) {
            return response()->json(['success' => false, 'message' => '两次密码输入不一致！']);
        }

        $admin = User::where('username', $username)->first();
        if ($admin) {
            return response()->json(['success' => false, 'message' => '用户名已被注册！']);
        }

        $password = Hash::make($password);
        $admin = User::create([
            'name' => $name,
            'password' => $password
        ]);

        return response()->json(['success' => true, 'message' => '注册成功！', 'admin' => $admin]);
    }

    /***
     * 后台管理员登录
     * @param Request $request
     */
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        if (!$username || !$password) {
            return response()->json(['success' => false, 'message' => '账号或密码错误！']);
        }

        $admin = User::where('username', $username)->first();
        if (!$admin) {
            return response()->json(['success' => false, 'message' => '此用户不存在！']);
        }

        if (!Hash::check($password, $admin->password)) {
            return response()->json(['success' => false, 'message' => '密码填写错误！']);
        }

        $credentials = request(['username', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the admin out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
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
