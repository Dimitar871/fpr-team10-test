<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\DiaryEntry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DiaryEntrySeeder extends Seeder
{
    public function run(): void
    {
        $users = User::take(3)->get();

        $moods = ['Poor', 'Below Average', 'Average', 'Good', 'Excellent'];

        foreach ($users as $user) {
            for ($i = 0; $i < 5; $i++) {
                DiaryEntry::create([
                    'user_id' => $user->id,
                    'entry_date' => Carbon::now()->subDays($i)->toDateString(),
                    'mood' => $moods[array_rand($moods)],
                    'energy' => $moods[array_rand($moods)],
                    'stress' => $moods[array_rand($moods)],
                    'highlights' => 'Today I accomplished several important tasks and felt motivated.',
                    'challenges' => 'I found it challenging to stay focused during the afternoon.',
                    'gratitude' => 'I am grateful for the support from my friends and family.',
                    'improvements' => 'I plan to manage my time better and avoid distractions.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
