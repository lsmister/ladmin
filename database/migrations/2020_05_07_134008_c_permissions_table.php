<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('名称')->unique();
            $table->string('description')->comment('描述');
            $table->string('url')->comment('路由url');
            $table->bigInteger('parent_id')->comment('父级id');
            $table->smallInteger('sort')->comment('排序号 数值越大级别越高')->default(0);
            $table->boolean('status')->comment('状态 0:不可用 1:可用')->default(1);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('role_permission', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('role_id')->comment('对应角色');
            $table->bigInteger('permission_id')->comment('对应权限');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');

        Schema::dropIfExists('role_permission');
    }
}
