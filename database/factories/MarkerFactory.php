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
            'reserve_meters' => $this->faker->randomNumber(3),
            'nap_threads' => $this->faker->randomElement([1, 2, 4, 8, 16, 32, 64, 128]),
            'nap_buffers' => $this->faker->randomElement([1, 2, 4, 8, 16, 32, 64, 128]),
            'nap_ports' => $this->faker->randomElement([1, 2, 4, 8, 16, 32, 64, 128]),
            'map_id' => Map::factory(),
        ];
    }
}
