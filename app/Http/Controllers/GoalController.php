<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Carbon\Carbon;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class GoalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return view('goals.index', ['goals' => [], 'show_form' => false]);
        }

        $filter_assigned = $request->input('filter_assigned', []);
        $filter_achieved = $request->input('filter_achieved', []);
        // dd($filter_assigned, $filter_achieved);

        $goal_query = Goal::query();
        // dd($filter_achieved, $filter_assigned);
        if ($filter_assigned === 'individual') {
            $goal_query->where('user_id', $user->id);
        } elseif ($filter_assigned === 'team') {
           if (!is_null($user->team_id)) {
                $goal_query->where('team_id', $user->team_id);
            } else {
                $goal_query->whereRaw('0 = 1');
            }
        } else {
            // dd("Reaching here");
            $goal_query->where(function ($query) use ($user) {
                $query->where('user_id', $user->id);
                if(!is_null($user->team_id)) {
                    $query->orWhere('team_id', $user->team_id);
                }
            });
        }

        if ($filter_achieved) {
            $goal_query->where('achieved', $filter_achieved === 'achieved' ? 1 : 0);
        }

        $goals = $goal_query->get();
        // dd($goals);

        return view('goals.index', ["goals" => $goals, 'show_form' => false]);
    }

    public function create()
    {
        return view('goals.index', ['show-form', true]);
    }

    public function store(Request $request)
    {
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'title' => 'required|max:128',
                'description' => 'max:255',
                'specific' => '',
                'measureable' => '',
                'achievable' => 'max:10|min:1',
                'relevance' => ['required', Rule::in(['Work', 'Personal', 'Education', 'Physical/mental health', 'Other'])],
                'time_based' => 'required|date',
                'goal_type' => ['required',  Rule::in(['individual', 'team'])]
            ]);

            $user_goals = Goal::where('user_id', $user->id)->get();
            $team_goals = Goal::where('team_id', $user->team_id)->get();
            $goals = $user_goals->merge($team_goals);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('show_form', true);
            }

            $validated = $validator->validated();

            Goal::create(
                array_merge($validated, [
                    'user_id' => $validated['goal_type']  === 'team'  ? null : Auth::id(),
                    'achieved' => false,
                    'team_id' => $validated['goal_type']  ===  'team' ? $user->team_id  :  null
                ])
            );
            return redirect()->route('goals.index')->with('success', 'Goal created successfully!');
    }

    public function edit(Request $request, Goal $goal)
    {
        $goals = Goal::get();
        return view('goals.index', ['edit_goal' => $goal, 'show_form' => true, 'goals' => $goals]);
    }

    public function update(Request $request, Goal $goal)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:128',
            'description' => 'nullable|string|max:255',
            'specific' => 'nullable|string',
            'measureable' => 'nullable|string',
            'achievable' => 'nullable|integer|min:1|max:10',
            'relevance' => ['nullable', Rule::in(['Work', 'Personal', 'Education', 'Physical/mental health', 'Other'])],
            'time_based' => 'nullable|date',
            'achieved' => 'nullable|boolean',
        ]);
        $previousAchieved = $goal->achieved;

        if (isset($validated['achieved'])) {
            $allTasksCompleted = $goal->tasks()->where('completed', false)->doesntExist();

            if (!$allTasksCompleted) {
                return redirect()->back()->withErrors(['incomplete_tasks' => 'Goal cannot be marked as achieved unless all tasks are completed.']);
            }
        }
        $validated['achieved_by'] = Carbon::today()->toDateString();
        $goal->update($validated);

        if (!$previousAchieved && isset($validated['achieved'])) {
            $user = Auth::user();
            $today = Carbon::today()->toDateString();

            if ($user->last_point_update !== $today) {
                FacadesDB::table('users')->where('id', $user->id)->update([
                    'daily_points' => 0,
                    'last_point_update' => $today
                ]);
            }

            $points_available = max(0, 25 - $user->daily_points);
            $total_points = $goal->tasks()->count() * 10;
            $end_points = min($total_points, $points_available);

            if ($end_points > 0) {
                FacadesDB::table('users')->where('id', $user->id)->update([
                    'points' => FacadesDB::raw("points + $end_points"),
                    'daily_points' => FacadesDB::raw("daily_points + $end_points"),
                    'last_point_update' => $today
                    ]);
            }
        }

        return redirect()->route('goals.index')->with('success', 'Goal updated successfully.');
    }

    public  function destroy(Request $request, Goal $goal)
    {
        foreach($goal->tasks as $task) {
            $task->delete();
        }
        $goal->delete();
        return redirect()->route('goals.index')->with('success', 'Goal deleted successfully.');
    }
}
