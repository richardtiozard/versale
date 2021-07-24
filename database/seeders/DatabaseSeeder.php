<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            BuyerSeeder::class,
            SellerSeeder::class,
            CategorySeeder::class,
            RequestSeeder::class,
            ProductSeeder::class,
            OfferSeeder::class,
            PaymentSeeder::class,
            OrderSeeder::class,
            SellerRatingSeeder::class,
            BuyerRatingSeeder::class,
        ]);
    }
}
