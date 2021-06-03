<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)
        ->hasProducts(5)
        // ->hasOrders(2)
        ->create();

        // Product::factory(10)
        // ->forUser()
        // ->hasOrders(1)
        // ->hasCategories(1)
        // ->create();
    }
}
