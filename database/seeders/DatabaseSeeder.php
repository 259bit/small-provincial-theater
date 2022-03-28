<?php

namespace Database\Seeders;

use App\Models\Theater\TheaterPlay;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        TheaterPlay::factory(10)->create();
    }
}
