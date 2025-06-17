<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Radiant Rabbits',
            ],
            [
                'name' => 'Playful penguins',
            ],
        ];

        foreach ($teams as $team) {
            DB::table('teams')->insert($team);
        }
    }
}
