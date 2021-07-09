<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
            // $rand1 = (float)mt_rand()/(float)mt_getrandmax();
            // $rand2 = (float)mt_rand()/(float)mt_getrandmax();
            // $gaussian_number = sqrt(-2 * log($rand1)) * cos(2 * M_PI * $rand2);
            // $mean = (1000 + 1) / 2;
            // $random_number = ($gaussian_number * 250) + $mean;
            // $random_number = round($random_number / 1) * 1;
        
            return [
            'name' => $this->faker->word(),
            'status' => 'open',
            'price' => $this->faker->randomNumber(3,false),
            'description' => $this->faker->realText(1000),
        ];
    }
}
