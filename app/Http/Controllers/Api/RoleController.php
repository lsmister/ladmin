<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //获取权限列表
    public function list(Request $request)
    {
        $list = Role::where('status', 1)->paginate($request->limit);
        return response()->json(['code'=>20000, 'message'=>'获取成功', 'data'=>$list]);
    }

    //添加权限
    public function add(Request $request)
    {
        $data['name'] = $request->name;
        $data['description'] = $request->description;

        $r = Role::create($data);
        if($r) {
            if(!empty($request->routes)) {
                $ids = [1,2,3];
                $r->permissions()->attach([$ids]); //添加关联数据
            }

            return response()->json(['code'=>20000, 'message'=>'添加成功', 'data'=>$r]);
        }

        return response()->json(['code'=>50000, 'message'=>'添加失败']);

    }

    //更新权限
    public function update($id, Request $request)
    {
        $p = Role::where('id', $id)->update($request->all());
        if($p){
            return response()->json(['code'=>20000, 'message'=>'更新成功', 'data'=>$p]);
        }
        return response()->json(['code'=>20000, 'message'=>'更新失败']);
    }

    //删除权限
    public function delete($id)
    {
        if(Role::destroy($id)) {
            return response()->json(['code'=>20000, 'message'=>'删除成功']);
        }
        return response()->json(['code'=>50000, 'message'=>'删除失败']);
    }

    //更新权限状态
    public function updateStatus($id, Request $request)
    {
        $p = Role::find($id);
        if(!$p) {
            return response()->json(['code'=>50000, 'message'=>'权限不存在']);
        }
        $p->status = $request->status;
        $p->save();

        return response()->json(['code'=>20000, 'message'=>'操作成功']);
    }

    //权限列表
    public function permissions()
    {
        $list = Permission::GetAllMenus2();

        dd($list);
    }
}
