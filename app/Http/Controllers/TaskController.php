<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $selectedType = $request->type;

        $tasks = Task::when($selectedType, function ($query, $type) {
            return $query->where('type', $type);
        })
            ->orderBy('completed')
            ->orderBy('due_date')
            ->get();

        return view('tasks.index', [
            'tasks' => $tasks,
            'selectedType' => $selectedType
        ]);
    }
    public function create()
    {
        $user = Auth::user();
        $user_goals = Goal::where('user_id', $user->id)->get();
        $team_goals = collect();
        if (!is_null($user->team_id)) {
            $team_goals = Goal::where('team_id', $user->team_id)->get();
        }

        return view('tasks.create', ['user_goals' => $user_goals, 'team_goals' => $team_goals]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:personal,group',
            'due_date' => 'required|date|after_or_equal:today',
            'goal_id' => 'nullable|exists:goals,id',
            'completed_at' => 'nullable|date'
        ]);

        $validated['points'] = $validated['type'] === 'group' ? 15 : 10;

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function edit(Task $task)
    {
        $user = Auth::user();
        $user_goals = Goal::where('user_id', $user->id)->get();
        $team_goals = collect();
        if (!is_null($user->team_id)) {
            $team_goals = Goal::where('team_id', $user->team_id)->get();
        }
        return view('tasks.edit', ['task' => $task, 'user_goals' => $user_goals, 'team_goals' => $team_goals]);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:personal,group',
            'due_date' => 'required|date',
            'goal_id' => 'nullable|exists:goals,id'
        ]);

        $validated['points'] = $validated['type'] === 'group' ? 15 : 10;

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated!');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
    public function toggle(Task $task)
    {
        $user = Auth::user();

        // If marking as completed and it was not already completed
        if (!$task->completed) {
            $task->update([
                'completed' => true,
                'completed_at' => now(),
            ]);

            // Add task points to user
            $user->points += $task->points;
            $user->save();

            return back()->with('success', "Task completed! Gained {$task->points} points.");
        } else {
            // If uncompleting the task, subtract the points (optional — remove this block if you don't want that behavior)
            $task->update([
                'completed' => false,
                'completed_at' => null,
            ]);

            $user->points = max(0, $user->points - $task->points);
            $user->save();

            return back()->with('success', "Task marked incomplete. Removed {$task->points} points.");
        }
    }
}
