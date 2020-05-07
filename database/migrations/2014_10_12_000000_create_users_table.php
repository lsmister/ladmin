<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('昵称');
            $table->string('username')->comment('登录账号')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->integer('merchant_id')->comment('商户号')->unique();
            $table->string('merchant_key',32)->comment('商户密钥')->unique();
            $table->string('last_login_ip',15)->comment('最后登录ip')->nullable();
            $table->integer('last_login_time')->comment('最后登录时间')->nullable();
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
        Schema::dropIfExists('users');
    }
}
