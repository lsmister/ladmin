<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Permission extends Model
{
    //protected $hidden = ['children'];

    protected $guarded = ['id'];

    protected $appends = ['parent_label'];

    //关联角色 多对多
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }

    public function getParentLabelAttribute()
    {
        return $this->where('id', $this->attributes['parent_id'])->value('description');
    }

    public function children()
    {
        return $this->hasMany(self::class,'parent_id','value')
            ->select('id as value', 'description as label','parent_id', 'sort', 'status')
            ->where('status', 1)
            ->orderBy('sort', 'desc')
            ->with(['children']);
    }

    //获取权限菜单 - 无限级  -级联选择器
    public static function GetAllMenus($parent_id = 0)
    {
        $arr = self::query()
            ->select('id as value', 'parent_id', 'description as label', 'sort', 'status')
            ->where('status', 1)
            ->where('parent_id',$parent_id)
            ->orderBy('sort', 'desc')
            ->with(['children'])
            ->get()->toArray();

        return $arr;
    }


    //获取权限菜单2 - 无限级  -树形控件
    public static function GetAllMenus2($parent_id = 0)
    {
        $arr = self::query()
//            ->select('id', 'parent_id', 'description as label', 'sort', url, 'status')
            ->where('status', 1)
            ->where('parent_id',$parent_id)
            ->orderBy('sort', 'desc')
            ->with(['children2'])
            ->get()->toArray();

        return $arr;
    }

    public function children2()
    {
        return $this->hasMany(self::class,'parent_id','id')
//            ->select('id', 'description as label','parent_id', 'sort', 'status')
            ->where('status', 1)
            ->orderBy('sort', 'desc')
            ->with(['children2']);
    }

}
