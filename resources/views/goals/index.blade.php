<?php

use Carbon\Carbon;

$filter_achieved = request()->query('filter_achieved');
$filter_assigned = request()->query('filter_assigned');

?>
@extends('layouts.app')
@include('components.modal')

@section('main-content')
<main class="w-full h-full flex flex-col  gap-4 max-w-[800px] mx-auto">
    <!-- Navbar  -->
    @if(session('success'))
    <div class="w-full bg-[var(--create-color)] flex items-center justify-center p-3 rounded-md">
        <p class="text-[var(--text-color)]">
            {{session('success')}}
        </p>
    </div>
    @endif

    @error('incomplete_tasks')
        <div class="w-full bg-rose-100 flex items-center justify-center p-3 rounded-md">
            <p class="text-rose-400 text-sm mt-1">{{ $message }}</p>
        </div>
    @enderror

    <!-- GOALS PAGE -->
    <div class="flex-col flex">
          <input type="radio" id="goals-tab" name="tab" class="peer/goals hidden" checked>

    <div class="flex-col gap-8 flex">
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-1 items-start">
                <p class="text-xl font-semibold">Goals</p>
                <span class="text-[var(--text-color)]  text-xs">Set and track your SMART goals for personal growth</span>
            </div>
            <label for="toggleForm" class="hover:ring-2 p-[1px] ring-[var(--sub-color)] rounded-md duration-300 cursor-pointer w-fit">
                <div class="px-4 py-2 rounded-md bg-[var(--sub-color)] text-[var(--text-color)] font-semibold">
                    + Create Goal
                </div>
            </label>
        </div>
        <div class="w-full h-[50px] p-1 flex gap-2 lg:flex-">
            <div class="flex items-center gap-1 justify-between md:w-full w-fit">
                <a href="{{ route('goals.index', ['filter_achieved'=> ($filter_achieved === 'achieved' ? null : 'achieved'), 'filter_assigned' => $filter_assigned ]) }}"
                    class="w-[48%] flex items-center justify-center ring-2 rounded-md text-sm h-[30px]
                        @if($filter_achieved && $filter_achieved == 'achieved')
                        bg-[rgba(var(--accent-color-rgb),0.2)]
                        text-[var(--text-color)]
                        ring-[var(--text-color)]
                        @else
                        ring-[var(--extra-color)] text-[var(--extra-color)]
                        @endif
                ">
                    Achieved
                </a>
            <a href="{{ route('goals.index', ['filter_achieved'=> ($filter_achieved === 'ongoing' ?  null : 'ongoing'), 'filter_assigned' => $filter_assigned]) }}"
                class="w-[48%] flex items-center justify-center  rounded-md text-sm h-[30px] ring-2
                       @if($filter_achieved && $filter_achieved == 'ongoing')
                        bg-[rgba(var(--accent-color-rgb),0.2)]
                        text-[var(--text-color)]
                        ring-[var(--text-color)]
                        @else
                        ring-[var(--extra-color)] text-[var(--extra-color)]
                        @endif
                ">
                    On-going
                </a>
            </div>

            <div class="h-full w-[1px] [var(--background-color)] mx-3"></div>

            <div class="flex items-center gap-1 justify-between md:w-full w-fit">
                <a href="{{ route('goals.index', ['filter_assigned'=> ($filter_assigned === 'team' ? null : 'team') , 'filter_achieved' => $filter_achieved]) }}"
                    class="w-[48%] flex items-center justify-center
                ring-2 rounded-md h-[30px] text-sm
               @if($filter_assigned && $filter_assigned == 'team')
                        bg-[rgba(var(--accent-color-rgb),0.2)]
                        text-[var(--text-color)]
                        ring-[var(--text-color)]
                        @else
                        ring-[var(--extra-color)] text-[var(--extra-color)]
                        @endif
                ">
                    Team
                </a>
                <a href="{{ route('goals.index', ['filter_assigned'=> ($filter_assigned === 'individual' ? null : 'individual') , 'filter_achieved' => $filter_achieved]) }}"
                    class="w-[48%] flex items-center justify-center
                ring-2 rounded-md text-sm  h-[30px]
                    @if($filter_assigned && $filter_assigned == 'individual')
                        bg-[rgba(var(--accent-color-rgb),0.2)]
                        text-[var(--text-color)]
                        ring-[var(--text-color)]
                    @else
                        ring-[var(--extra-color)] text-[var(--extra-color)]
                        @endif
                ">
                    Individual
                </a>
            </div>
        </div>
        <input type="checkbox" id="toggleForm" class="hidden peer" {{ ($show_form || session('show_form')) ? 'checked' : '' }}>
        <!-- Create Goal Form (visible when checkbox is checked) -->
        <div class="peer-checked:block hidden bg-[var(--background-color)] border border-[var(--background-color)] w-full p-8 rounded-md">
            <p class="font-semibold text-xl mb-4 text-[var(--text-color)]">Create SMART Goal</p>
            <form action="{{ isset($edit_goal) ? route('goals.update', ['goal' => $edit_goal->id]) : route('goals.store') }}" method="POST" class="flex flex-col gap-4">
                @csrf
                @if (isset($edit_goal))
                @method("PATCH")
                @endif
                <div class="flex flex-col gap-2">
                    <label for="title" class="text-[var(--text-color)] font-semibold text-sm ">Goal Title (required)</label>
                    @error('title')
                        <p class="text-rose-500">{{$message}}</p>
                    @enderror
                    <input
                        value="{{ old('title',  $edit_goal->title ?? '' )}}"
                        type="text" id="title" name="title" class="w-full outline-none bg-transparent ring-1 focus:ring-2  focus:ring-[var(--sub-color)]  rounded-md  p-2
                        @error('title')
                            ring-rose-400 focus:ring-rose-400
                        @enderror
                        ">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="description" class="text-[var(--text-color)] font-semibold text-sm"> Goal Description</label>
                    @error('description')
                        <p class="text-rose-500"> {{$message}}</p>
                    @enderror
                    <input
                        value="{{old('description', $edit_goal->description ?? '')}}"
                        type="text" id="description" name="description" class="w-full outline-none bg-transparent  focus:ring-[var(--sub-color)] ring-1 focus:ring-2 rounded-md  p-2">
                </div>

                    <div class="flex flex-col w-[100%] gap-2 ">
                        <label for="specific" class="text-[var(--text-color)] font-semibold text-sm">Specific</label>
                        @error('specific')
                            <p class="text-rose-500"> {{$message}}</p>
                        @enderror
                        <textarea
                            type="text" id="specific" name="specific" class="w-full ring-1 focus:ring-[var(--sub-color)] focus:ring-2 rounded-md outline-none min-h-[90px] bg-transparent  p-2 placeholder:text-sm text-sm" placeholder="What exactly will you accomplish?">{{old('specific', $edit_goal->specific ?? '')}}
                        </textarea>
                    </div>
                    <div class="flex flex-col w-[100%] gap-2 ">
                        <label for="measureable" class="text-[var(--text-color)] font-semibold text-sm">Measureable</label>
                        @error('measureable')
                            <p class="text-rose-500"> {{$message}}</p>
                        @enderror
                        <textarea type="text" id="measureable" name="measureable" class="w-full ring-1 focus:ring-2 rounded-md  outline-none min-h-[90px] bg-transparent focus:ring-[var(--sub-color)] p-2 placeholder:text-sm text-sm"
                            placeholder="How will you track progress? (e.g. here)">{{old('measureable', $edit_goal->measureable ?? '')}}</textarea>
                    </div>
                    <div class="flex flex-col w-[100%] gap-2 justify-between">
                        <label for="achievable" class="text-[var(--text-color)] font-semibold text-sm">Achievable - Difficulty level:
                            <output id="sliderOutput" class="text-sm w-[10%] font-semibold">{{old('achievable', $edit_goal->achievable ?? 3)}}</output>
                        </label>
                        @error('achievable')
                            <p class="text-rose-500">{{$message}}</p>
                        @enderror
                        <div class="pb-2">
                            <div class="flex items-center flex-col gap-1">
                                <input type="range" id="achievable" name="achievable" min="1" max="5" step="1" class="w-[100%] bg-[var(--sub-color)] accent-[#3aa499]" value="{{old('achievable', $edit_goal->achievable ?? '' )}}" oninput="sliderOutput.value = achievable.value">
                                <div class="w-full flex items-center justify-between">
                                    <span class="text-sm text-[var(--text-color)]">1 (Easy)</span>
                                    <span class="text-sm text-[var(--text-color)]">3 (Moderate)</span>
                                    <span class="text-sm text-[var(--text-color)]">5 (Challenging)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col w-[100%] gap-2  ">
                        <label for="time_based" class="text-[var(--text-color)] font-semibold text-sm">Due-date (required)</label>
                        @error('time_based')
                            <p class="text-rose-500">{{$message}}</p>
                        @enderror
                        <input
                        type="date"
                        name="time_based"
                        min="{{ date('Y-m-d') }}"
                        id="time_based"
                        class="text-sm ring-1 focus:border-none border-none focus:ring-[var(--sub-color)] focus:ring-2 p-2 rounded-md text-[var(--text-color)]
                            {{ $errors->has('time_based') ? 'ring-rose-400 focus:ring-rose-400' : '' }}"
                        value="{{ old('time_based', $edit_goal->time_based ?? '') }}"
                    >

                    </div>
                    <div class="flex flex-col w-[100%] gap-2 ">
                        <label for="relevance" class="text-[var(--extra-color)] font-semibold text-sm">
                            Relevant
                        </label>
                        @error('relevance')
                            <p class="text-rose-500">{{$message}}</p>
                        @enderror
                        <select name="relevance" id="relevance" class=" p-2 rounded-md  ring-1 pr-4
                        @error('relevance')
                            ring-rose-400 focus:ring-rose-400
                        @enderror ">
                            <option disabled selected value="">Select</option>
                            <option {{ old('relevance', $edit_goal->relevance ?? '') === "Work" ?  'selected' : '' }} value="Work">Work</option>
                            <option {{ old('relevance', $edit_goal->relevance ?? '') === "Personal" ?  'selected' : '' }} value="Personal">Personal</option>
                            <option {{ old('relevance', $edit_goal->relevance ?? '') === "Education" ?  'selected' : '' }} value="Education">Education</option>
                            <option {{ old('relevance', $edit_goal->relevance ?? '') === "Physical/Mental Health" ?  'selected' : '' }} value="Physical/mental health">Physical/Mental Health</option>
                            <option {{ old('relevance', $edit_goal->relevance ?? '') === "Other" ?  'selected' : '' }} value="Other">Other</option>
                        </select>
                    </div>

                    <div class=" w-[100%]">
                        <div class="
                        flex-col gap-2
                        @if(Auth::user() && !Auth::user()->team_id)
                            hidden
                        @else
                            flex
                        @endif
                        ">
                            <label for="goal_type" class=" text-[var(--extra-color)] font-semibold text-sm">Goal type (required)</label>
                            @error('goal_type')
                            <p class="text-rose-500">{{$message}}</p>
                            @enderror
                            <label class="text-sm text-[var(--extra-color)] ">
                                <input type="radio" name="goal_type" value="individual" required {{ old('goal_type', $edit_goal->goal_type ?? 'individual') === "individual" ?  'checked' : '' }}>
                                Individual
                            </label>

                            <label class="text-sm text-[var(--extra-color)] ">
                                <input type="radio" name="goal_type" value="team" {{ old('goal_type', $edit_goal->goal_type ?? '') === "team" ?  'checked' : '' }}>
                                Team
                            </label>
                        </div>
                    </div>

                <div class="flex gap-2 items-end w-full ">
                    <a href="{{ route('goals.index') }}" class="px-4 py-2 rounded-md border-1 border-[var(--extra-color)] cursor-pointer  text-[var(--extra-color)] font-semibold duration-300">Cancel</a>
                    <div class="hover:ring-2 p-[1px] ring-[#3aa499] rounded-md duration-300">
                        <button type="submit" class="px-4 py-2 rounded-md border-none cursor-pointer bg-[var(--sub-color)] text-[var(--text-color)] font-semibold hover:outline:green-700 duration-300">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<!-- PROGRESS PAGE -->
        @php
            $all_tasks = collect($goals)->flatMap(fn($goal) => $goal->tasks)->all();
            $all_completed_tasks = array_filter($all_tasks, fn($task) => $task->completed);

            $all_achieved_goals = collect($goals)->filter(fn($goal) => $goal->achieved)
        @endphp

    <div class="flex items-center gap-2 my-6">
        <x-heroicon-o-arrow-trending-up class="h-6 w-6 text-blue-400 "/>
            <p class="text-blue-400 whitespace-nowrap font-semibold text-xl">

            My Progress</p>
            <div class="w-full h-[0.5px] bg-blue-400/50"></div>
    </div>
    <div class="flex flex-col gap-8 mb-20">
        <div class="flex flex-wrap gap-2">
            <div class="flex-1 min-w-[175px] basis-0 py-3 rounded-md border border-[var(--extra-color)] px-2 shadow-sm">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-arrow-trending-up class="h-6 w-6 text-[#3aa499]"/>
                    <div class="flex flex-col">
                        <p class="font-semibold text-xs text-[var(--sub-color)]">Overall Progress</p>
                        <span class="text-xl font-bold text-[var(--sub-color)]">
                        @if (count($goals) || count($all_tasks) > 0)
                            {{ round((count($all_completed_tasks) + count($all_achieved_goals)) / (count($goals) + count($all_tasks)) * 100, 1) }} %
                        @else
                            0 / 0
                        @endif
                         </span>
                    </div>
                </div>
            </div>
            <div class="flex-1 min-w-[175px] basis-0 py-3 rounded-md border border-[var(--extra-color)] px-2 shadow-sm">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-check-circle class="h-6 w-6 text-blue-400"/>
                    <div class="flex flex-col">
                        <p class="font-semibold text-xs text-[var(--sub-color)]">Goals Accomplished</p>
                        <span class="text-xl font-bold text-[var(--sub-color)]">
                            {{ collect($goals)->filter(fn($goal) => $goal->achieved)->count() }} / {{count($goals)}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex-1 min-w-[175px] basis-0 py-3 rounded-md border border-[var(--extra-color)] px-2 shadow-sm">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-rectangle-stack class="h-6 w-6 text-purple-400"/>
                    <div class="flex flex-col">
                        <p class="font-semibold text-xs text-[var(--sub-color)] ">Tasks Completed</p>
                        <span class="text-xl font-bold text-[var(--sub-color)] ">
                            {{count($all_completed_tasks)}} / {{count($all_tasks)}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full p-6 border border-[var(--extra-color)] shadow-sm rounded-md">
            <div class="w-full flex items-center gap-2 mb-2">
                <x-heroicon-o-arrow-trending-up class="h-6 w-6"/>
                <p class="text-xl font-bold text-[var(--sub-color)] ">Recent activity (7 days)</p>
            </div>
            <div class="w-full flex flex-col">
            @php

                $recently_accomplished_goals = collect($goals)
                    ->filter(fn($goal) => isset($goal->achieved_by) && Carbon::parse($goal->achieved_by)->gte(Carbon::now()->subDays(7)))
                    ->map(fn($goal) => [
                        'type' => 'goal',
                        'title' => $goal->title,
                        'date' => Carbon::parse($goal->achieved_by),
                        'data' => $goal
                    ]);

                $recently_accomplished_tasks = collect($all_tasks)
                    ->filter(fn($task) => isset($task->completed_at) && Carbon::parse($task->completed_at)->gte(Carbon::now()->subDays(7)))
                    ->map(fn($task) => [
                        'type' => 'task',
                        'title' => $task->title,
                        'date' => Carbon::parse($task->completed_at),
                        'data' => $task
                    ]);

                $sorted_array = $recently_accomplished_goals
                    ->merge($recently_accomplished_tasks)
                    ->sortByDesc('date')
                    ->values();
                @endphp

                @foreach ($sorted_array as $object)
                <div class="flex items-center py-2 justify-between p-1 border-b border-[var(--extra-color)]">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-check-circle class="h-4 w-4 text-green-400" />
                        <p class="text-sm">{{$object['title']}}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="rounded-full flex font-semibold items-center gap-1 w-fit py-1 text-xs text-white px-2 border border-[var(--extra-color)]
                        @if ($object['type'] === 'task')
                            bg-purple-400
                        @else
                            bg-blue-400
                        @endif
                        ">
                        @if ($object['type'] == 'task')
                            <x-heroicon-o-rectangle-stack class="h-4 w-4 text-white"/>
                        @else
                            <x-heroicon-o-check-circle class="h-4 w-4 text-white"/>
                        @endif
                            {{$object['type']}}
                        </div>
                        <p class="text-sm text-[var(--sub-color)]">{{ $object['date']->format('Y-m-d') }}</p>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>

    <div class="w-full h-fit flex flex-col gap-4">
        <!-- Indivdual goals -->
        <div class="flex items-center gap-2">
            <x-heroicon-o-user class="h-6 w-6 text-[var(--sub-color)]" />
            <p class="text-[var(--sub-color)] whitespace-nowrap font-semibold text-xl">Individual Goals</p>
            <div class="w-full h-[0.5px] bg-[var(--sub-color)]"></div>
        </div>

        @php
            $individualGoals = collect($goals)->filter(fn($goal) => $goal['user_id']);
        @endphp

        <div class="grid gap-4 grid-cols-1
            @if (count($individualGoals) > 0)
                lg:grid-cols-2
            @endif">
            @if ($individualGoals->isEmpty())
            <p class="mx-auto text-2xl text-[var(--text-color)]">No goals found.</p>
            @else
            @foreach ($individualGoals as $goal)
            <x-goal-card :goal="$goal" />
            @endforeach
            @endif
        </div>

        <div class="flex items-center gap-2 mt-20">
            <x-heroicon-o-user-group class="w-6 h-6 text-[var(--accent-color)] " />
            <p class="text-[var(--accent-color)]  whitespace-nowrap font-semibold text-xl">Team Goals</p>
            <div class="w-full h-[0.5px] bg-[var(--accent-color)]"></div>
        </div>

        @php
            $teamGoals = collect($goals)->filter(fn($goal) => $goal['team_id']);
        @endphp
        <div class="grid gap-4 grid-cols-1
        @if (count($teamGoals) > 0)
             lg:grid-cols-2
        @else
            pb-12
        @endif
        "> @if ($teamGoals->isEmpty())
                    <p class="mx-auto text-2xl text-[var(--text-color)]">No goals found.</p>
            @else
                @foreach ($teamGoals as $goal)
                        <x-goal-card :goal="$goal" />
                @endforeach
            @endif
        </div>
    </div>
</main>
@endsection
