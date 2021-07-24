<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuyerRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buyer_ratings')->insert([
            [
                'id'=>1,
                'buyer_id'=>1,
                'rating'=>5,
                'message'=>'Thank you',
                'seller_id'=> 1
            ],
            [
                'id'=>2,
                'buyer_id'=>2,
                'rating'=>4,
                'message'=>'Thank you',
                'seller_id'=> 1
            ],
        ]);
    }
}
