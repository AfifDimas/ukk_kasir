<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

    //     User::factory()->create([
    //         'name' => 'admin',
    //         'email' => 'admin@gmail.com',
    //     ]);
    User::factory()->create([
        'name' => 'admin',
        'last_name' => 'admin',
        'email' => 'admin@gmail.com',
        'password' => 'admin'

    ]);
    }
}
