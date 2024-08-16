<?php

namespace Database\Seeders;

use App\Models\FiberMarker;
use Illuminate\Database\Seeder;

class FiberMarkerSeeder extends Seeder
{

    public function run()
    {
        FiberMarker::factory()
            ->count(3)
            ->create();
    }
}
