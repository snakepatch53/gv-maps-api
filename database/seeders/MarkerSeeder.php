<?php

namespace Database\Seeders;

use App\Models\Marker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarkerSeeder extends Seeder
{
    public function run()
    {
        Marker::factory()
            ->count(3)
            ->create();
    }
}
