<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //关联角色 多对多
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }
}
