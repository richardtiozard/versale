<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('requests')->insert([
            [
                'id'=>1,
                'budget'=>40,
                'quantity'=>1,
                'title'=>'Cat Food',
                'description'=>'Prefered whiskas',
                'status'=>'Available',
                'category_id'=>896,
                'buyer_id'=> 1,
                'created_at'=> '2021-06-20 11:02:15',
            ],
            [
                'id'=>2,
                'budget'=>60,
                'quantity'=>2,
                'title'=>'Dog Food',
                'description'=>'Pedigree or royal canin brand',
                'status'=>'Available',
                'category_id'=>895,
                'buyer_id'=> 1,
                'created_at'=> '2021-04-22 11:02:15'
            ],
            [
                'id'=>3,
                'budget'=>25,
                'quantity'=>2,
                'title'=>'Vibra Bites Fish Food',
                'description'=>'Vibra Bites Brand',
                'status'=>'Available',
                'category_id'=>897,
                'buyer_id'=> 2,
                'created_at'=> '2021-03-05 11:02:15'
            ],
            
        ]); 
    }
}
