<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            EntitySeeder::class,
            UserSeeder::class,
            MapSeeder::class,
            FiberSeeder::class,
            FiberMarkerSeeder::class,
            MarkerSeeder::class,
        ]);
    }
}
