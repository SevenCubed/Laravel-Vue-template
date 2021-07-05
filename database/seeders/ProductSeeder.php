<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(10)
        ->forUser(1)
        ->hasOrders(1)
        ->hasImages(1)
        ->hasCategories(1)
        ->create();
    }
}
