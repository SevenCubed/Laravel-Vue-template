<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bid;


class BidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bid::factory(10)
        ->hasProduct(1)
        ->hasUser(1)
        ->create();
    }
}
