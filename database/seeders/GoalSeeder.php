<?php

namespace Database\Seeders;

use Carbon\Carbon;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seed_data = [
            [
                'title' => 'Read 12 Books in a Year',
                'description' => 'Improve knowledge and mental sharpness by reading one book each month.',
                'specific' => 'Read one personal development book every month.',
                'measureable' => 'Track number of books read using Goodreads.',
                'achievable' => 5,
                'relevance' => 'Work',
                'time_based' => '2025-12-31',
                'achieved' => false,
                'user_id' => '1',
                'progress' => 25,
                'created_at' => now(),
                'updated_at' => now(),
                'achieved_by' => null,
                'goal_type' => "individual",
                'team_id' => null
            ],
            [
                'title' => 'Meditate Daily for 10 Minutes',
                'description' => 'Build a consistent meditation habit to reduce stress and increase focus.',
                'specific' => 'Practice 10 minutes of mindfulness meditation every morning.',
                'measureable' => 'Track sessions with a meditation app.',
                'achievable' => 3,
                'relevance' => 'Personal',
                'time_based' => '2025-06-30',
                'achieved' => false,
                'user_id' => '3',
                'progress' => 60,
                'created_at' => now(),
                'updated_at' => now(),
                'achieved_by' => null,
                'goal_type' => "individual",
                'team_id' => null
            ],
            [
                'title' => 'Improve Public Speaking Skills',
                'description' => 'Become more confident and clear when speaking in public.',
                'specific' => 'Attend Toastmasters twice a month and record speeches.',
                'measureable' => 'Complete 5 speeches and get feedback.',
                'achievable' => 10,
                'relevance' => 'Physical/mental health',
                'time_based' => '2025-09-01',
                'achieved' => false,
                'user_id' => '2',
                'progress' => 40,
                'created_at' => now(),
                'updated_at' => now(),
                'achieved_by' => null,
                'goal_type' => "individual",
                'team_id' => null
            ],
            [
                'title' => 'Wake Up at 6AM on Weekdays',
                'description' => 'Start the day earlier to have more time for focus and planning.',
                'specific' => 'Set alarm for 6:00 AM Monday-Friday.',
                'measureable' => 'Track wake-ups with a habit tracker app.',
                'achievable' => 7,
                'relevance' => 'Other',
                'time_based' => '2025-07-01',
                'achieved' => false,
                'user_id' => '3',
                'progress' => 50,
                'created_at' => now(),
                'updated_at' => now(),
                'achieved_by' => null,
                'goal_type' => "individual",
                'team_id' => null
            ],
            [
                'title' => 'Learn Basic Spanish',
                'description' => 'Be able to hold a basic conversation in Spanish.',
                'specific' => 'Complete Duolingo course and practice with native speakers.',
                'measureable' => 'Reach level 5 in 10 topics and do 3 language exchanges.',
                'achievable' => 6,
                'relevance' => 'Work',
                'time_based' => '2025-10-15',
                'achieved' => false,
                'user_id' => '2',
                'progress' => 30,
                'created_at' => now(),
                'updated_at' => now(),
                'achieved_by' => null,
                'goal_type' => "individual",
                'team_id' => null
            ],
            [
                'title' => 'Bug Fixes',
                'description' => 'All bugs on branch X should be done',
                'specific' => 'All bugs on branch X should be fixed and their PRs should be reviewed.',
                'measureable' => 'All bugs are  fixed.',
                'achievable' => 9,
                'relevance' => 'Work',
                'time_based' => '2025-10-15',
                'achieved' => false,
                'user_id' => null,
                'progress' => 30,
                'created_at' => now(),
                'updated_at' => now(),
                'achieved_by' => null,
                'goal_type' => "team",
                'team_id' => 1
            ],
            [
                'title' => 'Complete a 30-Day Fitness Challenge',
                'description' => 'Boost energy and improve physical health with daily workouts.',
                'specific' => 'Follow a structured 30-day full-body workout plan.',
                'measureable' => 'Check off each completed day in fitness tracker app.',
                'achievable' => 7,
                'relevance' => 'Physical/mental health',
                'time_based' => '2025-07-30',
                'achieved' => false,
                'user_id' => '1',
                'progress' => 20,
                'created_at' => now(),
                'updated_at' => now(),
                'achieved_by' => null,
                'goal_type' => "individual",
                'team_id' => null
            ],
            [
                'title' => 'Team Step Count Challenge',
                'description' => 'Encourage physical activity by collectively reaching 1 million steps in 1 month.',
                'specific' => 'Each member walks 10,000 steps daily and logs them.',
                'measureable' => 'Steps tracked via shared fitness app.',
                'achievable' => 6,
                'relevance' => 'Physical/mental health',
                'time_based' => '2025-07-31',
                'achieved' => false,
                'user_id' => null,
                'progress' => 45,
                'created_at' => now(),
                'updated_at' => now(),
                'achieved_by' => null,
                'goal_type' => "team",
                'team_id' => 1
            ],
            [
                'title' => 'Drink 2L of Water Daily',
                'description' => 'Stay hydrated to support focus, digestion, and energy levels.',
                'specific' => 'Log daily water intake and aim for 2 liters per day.',
                'measureable' => 'Use hydration tracker app.',
                'achievable' => 3,
                'relevance' => 'Physical/mental health',
                'time_based' => '2025-07-01',
                'achieved' => false,
                'user_id' => '2',
                'progress' => 70,
                'created_at' => now(),
                'updated_at' => now(),
                'achieved_by' => null,
                'goal_type' => "individual",
                'team_id' => null
            ],
            [
                'title' => 'Monthly Wellness Workshop',
                'description' => 'Host one wellness workshop per month to promote healthy living.',
                'specific' => 'Team organizes and attends sessions on sleep, nutrition, and stress.',
                'measureable' => 'Attendance and feedback tracked.',
                'achievable' => 8,
                'relevance' => 'Work',
                'time_based' => '2025-12-01',
                'achieved' => false,
                'user_id' => null,
                'progress' => 10,
                'created_at' => now(),
                'updated_at' => now(),
                'achieved_by' => null,
                'goal_type' => "team",
                'team_id' => 1
            ],
            [
                'title' => 'Unplug After 8PM',
                'description' => 'Support better sleep and recovery by reducing screen time in the evenings.',
                'specific' => 'Avoid screens and tech after 8PM for better sleep hygiene.',
                'measureable' => 'Daily journaling and tracking sleep quality.',
                'achievable' => 4,
                'relevance' => 'Physical/mental health',
                'time_based' => '2025-08-15',
                'achieved' => false,
                'user_id' => '3',
                'progress' => 35,
                'created_at' => now(),
                'updated_at' => now(),
                'achieved_by' => null,
                'goal_type' => "individual",
                'team_id' => null
            ],
            [
                'title' => 'Healthy Lunch Rotation',
                'description' => 'Create a system for rotating healthy meals at work to improve team vitality.',
                'specific' => 'Team members take turns preparing nutritious lunches once a week.',
                'measureable' => 'Shared calendar and meal photo log.',
                'achievable' => 5,
                'relevance' => 'Work',
                'time_based' => '2025-09-30',
                'achieved' => false,
                'user_id' => null,
                'progress' => 20,
                'created_at' => now(),
                'updated_at' => now(),
                'achieved_by' => null,
                'goal_type' => "team",
                'team_id' => 1
            ],

        ];
        foreach ($seed_data as $goal) {
            DB::table('goals')->insert($goal);
        };
    }
}
