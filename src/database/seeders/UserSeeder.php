<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert
        ([ 
            [ 
                'name' => '管理者ユーザー例', 
                'email' => 'admin@example.com',
                'password' => Hash::make('12345678'), 
                'privilege' => 0,
                'created_at' => now(), 
                'updated_at' => now(), 
            ], 
            [ 
                'name' => '一般ユーザー例', 
                'email' => 'general@sample.com',
                'password' => Hash::make('87654321'), 
                'privilege' => 1,
                'created_at' => now(), 
                'updated_at' => now(), 
            ], 
        ]);
    }
}
