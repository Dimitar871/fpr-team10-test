<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Theme;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Employee',
                'email' => 'user1@example.com',
                'password' => Hash::make('password'),
                'team_id' => 1,
                'points' => 145
            ],
            [
                'name' => 'HR member',
                'email' => 'user2@example.com',
                'password' => Hash::make('password'),
                'team_id' => null,
                'points' => 250
            ],
            [
                'name' => 'Admin',
                'email' => 'user3@example.com',
                'password' => Hash::make('password'),
                'team_id' => 1,
                'points' => 1000
            ],
            [
                'name' => 'Jerry 😎',
                'email' => 'user4@example.com',
                'password' => Hash::make('password'),
                'team_id' => 2
            ],
        ];

        $themes = Theme::orderBy('id')->take(2)->get();

        foreach ($users as $userData) {
            $user = User::create($userData);

            foreach ($themes as $theme) {
                $user->themes()->attach($theme->id, [
                    'owned' => true,
                    'equipped' => $theme->id === 1,
                ]);
            }
        }
    }
}
