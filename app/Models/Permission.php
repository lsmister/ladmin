<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Permission extends Model
{
    public static $menu = [];

    //关联角色 多对多
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }

    public function childrens()
    {
        return $this->hasMany(self::class,'parent_id','id')
            ->select('id', 'parent_id', 'description', 'sort')
            ->where('status', 1)
            ->orderBy('sort', 'desc')
            ->with(['childrens']);
    }

    //获取所有子级 - 无限级
    public static function GetAllChildrens($parent_id = 0)
    {
        $arr = self::query()
            ->select('id', 'parent_id', 'description')
            ->where('parent_id',$parent_id)
            ->with(['childrens'])
            ->get()->toArray();

        return $arr;
    }

    //生成菜单树
    public static function GetMenuTree($arrs, $level = 0, $menus = [], $de = '')
    {
        array_push($menus, $de);
        if(isset($arrs['childrens'])) {
            $res = self::GetMenuTree($arrs);
            array_merge($menus, $res);
        }

        return $menus;
        /*$arrlist = self::query()
            ->select('id', 'parent_id', 'description', 'sort')
            ->where('parent_id',$parent_id)
            ->where('status',1)
            ->orderBy('sort', 'desc')
            ->get();

        if($arrlist->count() > 0) {
            foreach ($arrlist as $arr) {
                $res = self::GetMenuTree($arr->id, $menu);
                array_push($menu, $res);
            }
        }

        return $menu;*/
    }


}
