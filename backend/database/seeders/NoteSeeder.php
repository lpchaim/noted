<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\User;
use Database\Factories\NoteFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(fn (User $user) =>
            $user->notes()->createMany(
                Note::factory()
                    ->for($user)
                    ->count(random_int(0, 10))
                    ->make()
                    ->toArray()
            )
        );
    }
}
