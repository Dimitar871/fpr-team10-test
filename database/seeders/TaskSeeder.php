<?php

namespace Database\Seeders;

use App\Models\Goal;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $goals = Goal::all();

        if ($goals->isEmpty()) return;

        $completedGoal = $goals->first();
        $remainingGoals = $goals->skip(1);

        $this->seedTasksForGoal($completedGoal, allCompleted: true);

        foreach ($remainingGoals as $goal) {
            $this->seedTasksForGoal($goal, allCompleted: false);
        }
    }

    private function seedTasksForGoal($goal, bool $allCompleted): void
    {
        $taskCount = rand(2, 5);

        for ($i = 0; $i < $taskCount; $i++) {
            $createdAt = now()->subDays(rand(10, 40));
            $updatedAt = now()->subDays(rand(1, 9));

            $isCompleted = $allCompleted || (rand(0, 100) < 50);
            $completedAt = null;

            if ($isCompleted) {
                $recent = rand(0, 1) === 1;
                $completedAt = $recent
                    ? now()->subDays(rand(0, 6))
                    : Carbon::parse($createdAt)->addDays(rand(1, 10));
            }

            $type = $goal->goal_type === 'team' ? 'group' : 'personal';
            $points = $type === 'group' ? 15 : 10;

            Task::create([
                'goal_id'      => $goal->id,
                'title'        => $this->generateTaskTitle($goal, $i),
                'description'  => $goal->specific ?? $goal->description,
                'type'         => $type,
                'due_date'     => now()->addDays(rand(5, 30)),
                'points'       => $points,
                'completed'    => $isCompleted,
                'created_at'   => $createdAt,
                'updated_at'   => $completedAt ?? $updatedAt,
                'completed_at' => $completedAt,
            ]);
        }
    }

    private function generateTaskTitle($goal, $index): string
    {
        $base = Str::words($goal->title, 4, '');
        $suffixes = [
            "Phase " . ($index + 1),
            "Prep Task",
            "Checklist Item " . ($index + 1),
            "Subtask " . ($index + 1),
            "Milestone " . ($index + 1),
            "Daily Step"
        ];

        return "{$base}: " . $suffixes[array_rand($suffixes)];
    }
}
