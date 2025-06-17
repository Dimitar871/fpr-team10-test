@extends('layouts.app')

@section('main-content')
    <main class="w-full h-full flex flex-col gap-4 max-w-[800px] mx-auto py-6">
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-1 items-start">
                <p class="text-xl font-semibold">Create New Task</p>
                <span class="text-[var(--text-color)] text-xs">Add details for your new task</span>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('tasks.store') }}" class="bg-[var(--main-color)] border-[var(--background-color)] p-6 rounded-md shadow-sm mt-4">
            @csrf

            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-[var(--text-color)] mb-1">Title*</label>
                <input type="text" id="title" name="title"
                       value="{{ old('title') }}"
                       class="w-full px-3 py-2 border @error('title') border-[var(--delete-color)] @else border-[var(--text-color)] @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--sub-color)] focus:border-transparent"
                       placeholder="Enter task title">
                @error('title')
                <p class="mt-1 text-sm text-[var(--delete-color)]">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-[var(--text-color)] mb-1">Description*</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full px-3 py-2 border @error('description') border-[var(--delete-color)] @else border-[var(--text-color)] @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--sub-color)] focus:border-transparent"
                          placeholder="Describe your task">{{ old('description') }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-[var(--delete-color)]">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="task-type" class="block text-sm font-medium text-[var(--text-color)] mb-1">Task Type*</label>
                <select id="task-type" name="type"
                        class="w-full px-3 py-2 border @error('type') border-[var(--delete-color)] @else border-[var(--text-color)] @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--sub-color)] focus:border-transparent appearance-none">
                    <option value="" disabled selected>Select task type</option>
                    <option value="personal" @selected(old('type') == 'personal')>Personal</option>
                    <option value="group" @selected(old('type') == 'group')>Group</option>
                </select>
                @error('type')
                <p class="mt-1 text-sm text-[var(--delete-color)]">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-[var(--text-color)]">Points will be assigned automatically based on task type</p>
            </div>

            <div class="mb-6">
                <label for="due-date" class="block text-sm font-medium text-[var(--text-color)] mb-1">Due Date*</label>
                <input type="date" id="due-date" name="due_date"
                       value="{{ old('due_date') }}"
                       min="{{ date('Y-m-d') }}"
                       class="w-full px-3 py-2 border @error('due_date') border-[var(--delete-color)] @else border-[var(--text-color)] @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--sub-color)] focus:border-transparent">
                @error('due_date')
                <p class="mt-1 text-sm text-[var(--delete-color)]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Goal selector -->
                    @php
                        $available_user_goals = $user_goals->filter(fn($goal) => !$goal->achieved);
                        $available_team_goals = $team_goals->filter(fn($goal) => !$goal->achieved);
                    @endphp
                <div class="mb-6">
                <label for="goal_id" class="block text-sm font-medium text-gray-700 mb-1">Goal</label>
                <select id="goal_id" name="goal_id"
                    @if(count($available_team_goals) + count($available_user_goals) === 0) disabled @endif
                        class="w-full px-3 py-2 border @error('type') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-[#3aa499] focus:border-transparent appearance-none
                        @if (count($available_team_goals) + count($available_user_goals) === 0)
                            border-gray-100 cursor-not-allowed text-gray-400
                        @endif
                        ">
                    <option value="" selected>No selection</option>
                    <option value="" disabled> --- Individual ---</option>

                    @foreach ($available_user_goals as $goal)
                         <option value="{{ $goal->id }}" @selected(old('team_id') == $goal->id)>{{$goal->title}}</option>
                    @endforeach
                    <option value="" disabled> --- Team ---</option>

                    @foreach ($available_team_goals as $goal)
                         <option value="{{ $goal->id }}" @selected(old('team_id') == $goal->id)>{{$goal->title}}</option>
                    @endforeach

                </select>
                @if(count($available_team_goals) + count($available_user_goals) === 0)
                    <p class="mt-1 text-sm text-gray-500">Info: You have no on-going goals. Create one first.</p>
                @endif

            </div>

            <!-- Form Actions -->

            <div class="flex justify-end gap-3">
                <a href="{{ route('tasks.index') }}"
                   class="px-4 py-2 border border-[var(--text-color)] rounded-md text-[var(--text-color)] hover:bg-[var(--background-color)] transition duration-200">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 rounded-md bg-[var(--create-color)] text-[var(--text-color)] font-semibold hover:bg-[var(--accent-color)] transition duration-200">
                    Create Task
                </button>
            </div>
        </form>
    </main>
@endsection
