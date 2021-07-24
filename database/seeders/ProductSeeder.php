<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'id'=>1,
                'name'=>'Cat food',
                'brand'=>'Whiskas',
                'description'=>'Healthy food for your catty pet.',
                'stock'=>'500',
                'price'=>55,
                'image'=>'/storage/img/products/1.jpg',
                'seller_id'=>1,
                'category_id'=>896,
            ],
            [
                'id'=>2,
                'name'=>'Dog food',
                'brand'=>'Pedigree',
                'description'=>'Healthy food for your doggy pet.',
                'stock'=>'500',
                'price'=>80,
                'image'=>'/storage/img/products/2.jpg',
                'seller_id'=>1,
                'category_id'=>895,
            ],
            [
                'id'=>3,
                'name'=>'Fish food',
                'brand'=>'Vibra Bites',
                'description'=>'Healthy food for your fishy pet.',
                'stock'=>'500',
                'price'=>30,
                'image'=>'/storage/img/products/3.jpg',
                'seller_id'=>1,
                'category_id'=>897,
            ],
            [
                'id'=>4,
                'name'=>'Pedigree Dog food',
                'brand'=>'Pedigree',
                'description'=>'Good quality dog food.',
                'stock'=>'250',
                'price'=>90,
                'image'=>'/storage/img/products/4.jpg',
                'seller_id'=>2,
                'category_id'=>895,
            ],
            [
                'id'=>5,
                'name'=>'Vibra Bites Fish food',
                'brand'=>'Vibra Bites',
                'description'=>'Good quality food for fish.',
                'stock'=>'250',
                'price'=>35,
                'image'=>'/storage/img/products/5.jpg',
                'seller_id'=>2,
                'category_id'=>897,
            ],
            
        ]); 
    }
}
