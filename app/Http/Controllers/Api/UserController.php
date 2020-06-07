<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google;

class UserController extends Controller
{
    /**
     * 获取用户列表
     */
    public function getList(Request $request)
    {
        $model = User::query();

        if($request->filled('name'))  {
            $model = $model->where('name', 'like', '%'.$request->name.'%');
        }

        if($request->filled('username'))  {
            $model = $model->where('username', 'like', '%'.$request->username.'%');
        }

        if($request->filled('status'))  {
            $model = $model->where('status', $request->status);
        }

        $list = $model
            ->select('id','username','name','google_status','status','created_at','merchant_id','role_id')
            ->paginate($request->limit);

        return response()->json(['code'=>20000, 'message'=>'获取成功', 'data'=>$list]);
    }

    /**
     * 角色列表
     */
    public function getRoleList()
    {
        $list = Role::select('id','name')->get()->makeHidden('routes');
        return response()->json(['code'=>20000, 'message'=>'获取成功', 'data'=>$list]);
    }

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
        $role = $user->role;

        $routes = $role->permissions->toArray();
        $tree = $this->getTree($routes, 1);

        return response()->json(['code'=>20000,'message'=>'获取成功','data'=>$tree]);
    }

    /**
     * 路由树
     */
    public function getTree($data, $pid)
    {
        $tree = [];
        foreach($data as $k => $v)
        {
            if($v['parent_id'] == $pid)
            {
                $temp['name'] = $v['description'];
                $temp['path'] = $v['url'];
                $temp['component'] = $v['url'];
                $temp['children'] = $this->getTree($data, $v['id']);
//                $v['children'] = $this->getTree($data, $v['id']);

                $tree[] = $temp;;
            }
        }
        return $tree;
    }

    //添加用户
    public function add(Request $request) {
        $data = $request->all();
        //dd($data);
        $data['parent_id'] = auth()->id();

        if(User::where('name', $data['name'])->first()) {
            return response()->json(['code'=>50000, 'message'=>'用户名称已存在, 请更换!']);
        }

        $p = User::create($data);
        if($p) {
            return response()->json(['code'=>20000, 'message'=>'添加成功', 'data'=>$p]);
        }

        return response()->json(['code'=>50000, 'message'=>'添加失败']);
    }

    //更新用户
    public function update($id, Request $request) {
        $p = User::where('id', $id)->update($request->all());
        if($p){
            return response()->json(['code'=>20000, 'message'=>'更新成功', 'data'=>$p]);
        }
        return response()->json(['code'=>20000, 'message'=>'更新失败']);
    }

    //删除用户
    public function delete($id) {
        if(User::destroy($id)) {
            return response()->json(['code'=>20000, 'message'=>'删除成功']);
        }
        return response()->json(['code'=>50000, 'message'=>'删除失败']);
    }

    //更新用户状态
    public function updateStatus($id, Request $request)
    {
        //dd($request->all());
        $p = User::find($id);
        if(!$p) {
            return response()->json(['code'=>50000, 'message'=>'用户不存在']);
        }
        $p->status = $request->status;
        $p->save();

        return response()->json(['code'=>20000, 'message'=>'操作成功']);
    }

}
