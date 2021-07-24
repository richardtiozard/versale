<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            [
                'id'=>1,
                'status'=>'Completed',
                'payment_id'=>1,
                'created_at'=> '2021-04-22 11:02:15'
            ],
            [
                'id'=>2,
                'status'=>'Pending',
                'payment_id'=>2,
                'created_at'=> '2021-06-11 11:02:15'
            ]
        ]); 
    }
}
