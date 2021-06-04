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
        $users = User::factory(50)->create();
        $categories = Category::factory(5)->create();
        $products = Product::factory(20)->make();
        $orders = Order::factory(10)->make();
        $products->each(function (Product $p) use ($users, $categories) {
            $p->user()->associate($users->random());
            $p->save();
            $p->categories()->sync($categories->random());
        });
        $orders->each(function (Order $o) use ($users, $products) {
            $o->user()->associate($users->random());
            $o->product()->associate($products->random());
            $o->save();
        });
    }
}
