<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellerRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seller_ratings')->insert([
            [
                'id'=>1,
                'product_id'=>1,
                'rating'=>5,
                'message'=>'Good quality products and services',
                'buyer_id'=> 1
            ],
            [
                'id'=>2,
                'product_id'=>2,
                'rating'=>4,
                'message'=>'Fast delivery',
                'buyer_id'=> 1
            ],
            
        ]);
    }
}
