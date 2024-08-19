<?php

namespace Database\Factories;

use App\Models\Map;
use App\Models\Marker;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarkerFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'description' => $this->faker->text(40),
            'type' => $this->faker->randomElement(Marker::$_TYPES),
            // reserve type
            'reserve_meters' => $this->faker->randomNumber(3),
            // nap type
            'nap_buffer' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]),
            'nap_thread' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]),
            'nap_ports' => $this->faker->randomElement([2, 4, 8, 12, 16, 24]),

            'map_id' => Map::factory(),
        ];
    }
}
