<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sellers')->insert([
            [
                'id'=>1,
                'fullname'=>'Seller',
                'username'=>'seller',
                'phonenumber'=>'01254876',
                'gender'=>'male',
                'country'=>'New York',
                'city'=> 'East Syracuse',
                'address'=> '3077 Oak Street',
                'zipcode'=> '13057',
                'image'=>'/storage/img/user/seller.png',
                'user_id'=> 3
            ],
            [
                'id'=>2,
                'fullname'=>'John Doe',
                'username'=>'johndoe',
                'phonenumber'=>'015487546',
                'gender'=>'male',
                'country'=>'Indiana',
                'city'=> 'Evansville',
                'address'=> '4922 Lucy Lane',
                'zipcode'=> '47711',
                'image'=>'/img/illustrator/defaultprofile.png',
                'user_id'=> 4
            ],
            
        ]);
    }
}
