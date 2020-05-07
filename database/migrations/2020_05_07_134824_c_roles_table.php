<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('名称')->unique();
            $table->string('description')->comment('描述');
            $table->boolean('status')->comment('状态 0:不可用 1:可用')->default(1);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->comment('对应用户');
            $table->bigInteger('role_id')->comment('对应角色');
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
        Schema::dropIfExists('roles');

        Schema::dropIfExists('user_role');
    }
}
