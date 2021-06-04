<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Order;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)
        // ->hasProducts(5)
        // // ->hasOrders(2)
        // ->create();
        
        $users = User::factory(10)->make();
        $products = Product::factory(5)->make();
        $orders = Order::factory(5)->make();
        $categories = Category::factory(4)->make();
        // $products->each(function (Product $p) use ($users)
        //     {$p->user()->associate(
        //         $users->random(rand(1, 5))->pluck('id')->toArray()
        //         );
        //     });
    echo '\nBREAK';
    echo $users;
    echo $products;
    // Product::factory(10)
        // ->forUser()
        // ->hasOrders(1)
        // ->hasCategories(1)
        // ->create();
    }
}
