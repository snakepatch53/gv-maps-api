<?php

namespace Database\Seeders;

use App\Models\Entity;
use Illuminate\Database\Seeder;

class EntitySeeder extends Seeder
{

    public function run()
    {
        Entity::factory()
            ->count(3)
            ->create();
    }
}
