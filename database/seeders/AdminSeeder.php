<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            [
                'id'=>1,
                'fullname'=>'admin',
                'username'=>'admin',
                'phonenumber'=>'016457898',
                'gender'=>'male',
                'country'=>'New Orleans',
                'city'=> 'East Central',
                'address'=> '1163 Autumn Hell Leaf',
                'zipcode'=> '045462',
                'image'=>'/img/illustrator/defaultprofile.png',
                'user_id'=> 1

            ],
            [
                'id'=>2,
                'fullname'=>'Richard Oswald Tiozard',
                'username'=>'richardtiozard',
                'phonenumber'=>'0167219845',
                'gender'=>'male',
                'country'=>'Malaysia',
                'city'=> 'Kuala Lumpur',
                'address'=> 'Endah Promenade',
                'zipcode'=> '57000',
                'image'=>'/img/illustrator/defaultprofile.png',
                'user_id'=> 2
            ],
            
        ]);
    }
}
