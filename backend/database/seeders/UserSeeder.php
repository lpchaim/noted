<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->createOne([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        User::factory()->count(9)->create();
    }
}