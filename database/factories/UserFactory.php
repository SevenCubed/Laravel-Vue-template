<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $postal_code = DB::select("select postcode from 4pp order by rand() limit 1"); //There are gaps in the 1000-9999 range, so it's safer to pluck there from the 4pp than to $faker them
        $postal_code = $postal_code[0]->postcode;
        // $lat = DB::select("select latitude from 4pp where postcode = {$postal_code}");
        // $long = DB::select("select longitude from 4pp where postcode = {$postal_code}");
        // $location = DB::select("select woonplaats from 4pp where postcode = {$postal_code}");

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => '$2$10$qh1YTNjcU7oweU6JzzqhEOk3lGkV4raUogMChR95dOq36jiNt0mPC', // password
            'postal_code' => $postal_code,
        ];
    }
}
