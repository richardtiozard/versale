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
        DB::table('users')->insert([
            [
                'id'=>1,
                'email'=>'admin@mail.com',
                'password'=>Hash::make('admin'),
                'role'=>'admin',
                'status'=>'Active',
            ],
            [
                'id'=>2,
                'email'=>'richard@mail.com',
                'password'=>Hash::make('richard'),
                'role'=>'admin',
                'status'=>'Active',
            ],
            [
                'id'=>3,
                'email'=>'seller@mail.com',
                'password'=>Hash::make('seller'),
                'role'=>'seller',
                'status'=>'Active',
            ],
            [
                'id'=>4,
                'email'=>'john@mail.com',
                'password'=>Hash::make('john'),
                'role'=>'seller',
                'status'=>'Active',
            ],
            [
                'id'=>5,
                'email'=>'buyer@mail.com',
                'password'=>Hash::make('buyer'),
                'role'=>'buyer',
                'status'=>'Active',
            ],
            [
                'id'=>6,
                'email'=>'gail@mail.com',
                'password'=>Hash::make('gail'),
                'role'=>'buyer',
                'status'=>'Active',
            ],
            
        ]);
    }
}
