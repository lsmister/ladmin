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
        $list = Role::where('status', 1)->paginate($request->limit)->makeHidden('permissions');
//        dd();
        return response()->json([
            'code'=>20000,
            'message'=>'获取成功',
            'data'=>[
                'total'=>$list->count(),
                'data'=>$list
            ]
        ]);
    }

    //添加权限
    public function add(Request $request)
    {
        $data['name'] = $request->name;
        $data['description'] = $request->description;

        $r = Role::create($data);
        if($r) {
            if(!empty($request->routes)) {
                $r->permissions()->attach($request->routes); //添加关联数据
            }

            return response()->json(['code'=>20000, 'message'=>'添加成功', 'data'=>$r]);
        }

        return response()->json(['code'=>50000, 'message'=>'添加失败']);

    }

    //更新权限
    public function update($id, Request $request)
    {
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $r = Role::find($id);
        $r->name = $request->name;
        $r->description = $request->description;
        if($r->save()){
            if(empty($request->routes)) {
                $r->permissions()->detach($request->routes);
            }else {
                $r->permissions()->sync($request->routes);
            }

            return response()->json(['code'=>20000, 'message'=>'更新成功', 'data'=>$r]);
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

    //权限列表
    public function permissions()
    {
        $list = Permission::GetAllMenus2(1);

        return response()->json(['code'=>20000, 'message'=>'获取成功', 'data'=>$list]);
    }
}
