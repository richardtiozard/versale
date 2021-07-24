<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offers')->insert([
            [
                'id'=>1,
                'status'=>'Pending',
                'request_id'=>1,
                'product_id'=>1,
                'created_at'=> '2021-06-30 11:02:15'
            ],
            [
                'id'=>2,
                'status'=>'Accepted',
                'request_id'=>2,
                'product_id'=>2,
                'created_at'=> '2021-04-03 11:02:15'
            ],
            [
                'id'=>3,
                'status'=>'Pending',
                'request_id'=>2,
                'product_id'=>4,
                'created_at'=> '2021-03-15 11:02:15'
            ],
            
        ]); 
    }
}
