<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $row = [
            'name' => '超管',
            'username' => 'root',
            'password' => Hash::make('root'),
            'merchant_id' => 1001,
            'merchant_key' => Str::random(32),
            'last_login_ip' => '127.0.0.1',
            'last_login_time' => time()
        ];

        User::create($row);
    }
}
