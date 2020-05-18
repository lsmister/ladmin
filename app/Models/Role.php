<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = ['id'];

    //关联用户 一对多
    public function users()
    {
        return $this->hasMany(User::class);
    }

    //关联权限 多对多
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}
