<?php

namespace App\Http\Controllers\Api;

use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    //获取权限列表
    public function list() {
        $list = Permission::all();
        return response()->json(['code'=>20000, 'message'=>'获取成功', 'data'=>$list]);
    }

    //获取权限菜单
    public function menu() {
        $list = Permission::GetAllMenus();
        return response()->json(['code'=>20000, 'message'=>'获取成功', 'data'=>$list]);
    }

    //添加权限
    public function add(Request $request) {
        dd($request->all());
        $list = Permission::GetAllMenus();
        return response()->json(['code'=>20000, 'message'=>'添加成功', 'data'=>$list]);
    }

    //更新权限
    public function update($id, Request $request) {
        dd($request->all());
        $list = Permission::GetAllMenus();
        return response()->json(['code'=>20000, 'message'=>'更新成功', 'data'=>$list]);
    }

    //删除权限
    public function delete($id) {
        dd($id);
        $list = Permission::GetAllMenus();
        return response()->json(['code'=>20000, 'message'=>'删除成功', 'data'=>$list]);
    }

    //更新权限状态
    public function updateStatus($id, Request $request)
    {
        $p = Permission::find($id);
        if(!$p) {
            return response()->json(['code'=>50000, 'message'=>'权限不存在']);
        }
        $p->status = $request->status;
        $p->save();

        return response()->json(['code'=>20000, 'message'=>'操作成功']);
    }
}
