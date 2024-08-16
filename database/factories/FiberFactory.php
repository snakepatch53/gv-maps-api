<?php

namespace Database\Factories;

use App\Models\Fiber;
use App\Models\Map;
use Illuminate\Database\Eloquent\Factories\Factory;

class FiberFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'type' => $this->faker->randomElement(Fiber::$_TYPES),
            'threads' => $this->faker->numberBetween(1, 144),
            'serie' => $this->faker->text(10),
            'description' => $this->faker->text(40),
            'map_id' => Map::factory(),
        ];
    }
}
