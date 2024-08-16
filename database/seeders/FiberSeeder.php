<?php

namespace Database\Seeders;

use App\Models\Fiber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FiberSeeder extends Seeder
{

    public function run()
    {
        Fiber::factory()
            ->hasFiberMarkers(3)
            ->count(3)
            ->create();
    }
}
