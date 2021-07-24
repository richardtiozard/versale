<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->insert([
            [
                'id'=>1,
                'method'=>'Credit Cards',
                'status'=>'Success',
                'amount'=>40,
                'offer_id'=>1,
                'created_at'=> '2021-04-22 11:02:15'
            ],
            [
                'id'=>2,
                'method'=>'Mobile Payments',
                'status'=>'Success',
                'amount'=>120,
                'offer_id'=>2,
                'created_at'=> '2021-06-11 11:02:15'
            ]
        ]); 
    }
}
