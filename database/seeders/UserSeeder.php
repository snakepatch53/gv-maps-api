<?php

namespace Database\Seeders;

use App\Models\Entity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Super Admin',
            'email' => 'admin',
            'user' => 'useradmin',
            'password' => bcrypt('admin'),
            'role' => 'SUPERADMIN',
            'entity_id' => Entity::all()->random()->id,
        ]);
        User::factory()
            ->count(3)
            ->create();
    }
}
