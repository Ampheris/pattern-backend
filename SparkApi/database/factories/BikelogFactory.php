<?php

namespace Database\Factories;

use App\Models\Bikelog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class BikelogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bikelog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'start_x' => $this->faker->randomFloat(),
            'start_y' => $this->faker->randomFloat(),
            'start_time' => Carbon::now(),
            'stop_time' => Carbon::now(),
            'stop_x' => $this->faker->randomFloat(),
            'stop_y' => $this->faker->randomFloat(),
            'inside_parking_area' => $this->faker->numberBetween($min = 0, $max = 1),
            'customer_id' => 1,
            'bike_id' => 1,
        ];
    }
}
