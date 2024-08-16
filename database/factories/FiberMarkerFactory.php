<?php

namespace Database\Factories;

use App\Models\Fiber;
use Illuminate\Database\Eloquent\Factories\Factory;

class FiberMarkerFactory extends Factory
{

    public function definition()
    {
        return [
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'fiber_id' => Fiber::factory(),
        ];
    }
}
