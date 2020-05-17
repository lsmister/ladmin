<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Permission extends Model
{
    //protected $hidden = ['children'];

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

    //获取权限菜单 - 无限级
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


}
