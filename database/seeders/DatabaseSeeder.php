<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tickets;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TicketsSeeder::class,
        ]);
        // User::factory(10)->create();
        // Tickets::factory(20)->create();

        // $this->call([
        //     UserSeeder::class,
        // ]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
