<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buyers')->insert([
            [
                'id'=>1,
                'fullname'=>'Buyer',
                'username'=>'buyer',
                'phonenumber'=>'0125487652',
                'gender'=>'male',
                'country'=>'New Jersey',
                'city'=> 'East Orange',
                'address'=> '1163 Spring Haven Trail',
                'zipcode'=> '07017',
                'image'=>'/img/illustrator/defaultprofile.png',
                'user_id'=> 5
            ],
            [
                'id'=>2,
                'fullname'=>'Gail Welton',
                'username'=>'gailwelton',
                'phonenumber'=>'0167845126',
                'gender'=>'female',
                'country'=>'Pennsylvania',
                'city'=> 'Erie',
                'address'=> '653 Custer Street',
                'zipcode'=> '16505',
                'image'=>'/img/illustrator/defaultprofile.png',
                'user_id'=> 6
            ],
            
        ]);    
    }
}
