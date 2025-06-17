@extends('layouts.app')

@section('main-content')
    <main class="w-full h-full flex flex-col gap-4 max-w-[800px] mx-auto py-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-1 items-start">
                <p class="text-xl font-semibold">Edit Task</p>
                <span class="text-[var(--text-color)] text-xs">Update task details</span>
            </div>
        </div>

        <form method="POST" action="{{ route('tasks.update', $task->id) }}" class="bg-[var(--main-color)] border-[var(--background-color)] p-6 rounded-md shadow-sm mt-4">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-[var(--text-color)] mb-1">Title*</label>
                <input type="text" id="title" name="title"
                       value="{{ old('title', $task->title) }}"
                       class="w-full px-3 py-2 border @error('title') border-[var(--delete-color)] @else border-[var(--text-color)] @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--sub-color)] focus:border-transparent"
                       placeholder="Enter task title">
                @error('title')
                <p class="mt-1 text-sm text-[var(--delete-color)]">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-[var(--text-color)] mb-1">Description*</label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-3 py-2 border @error('description') border-[var(--delete-color)] @else border-[var(--text-color)] @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--sub-color)] focus:border-transparent"
                          placeholder="Describe the task">{{ old('description', $task->description) }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-[var(--delete-color)]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Task Type -->
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-[var(--text-color)] mb-1">Task Type*</label>
                <select id="type" name="type"
                        class="w-full px-3 py-2 border @error('type') border-[var(--delete-color)] @else border-[var(--text-color)] @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--sub-color)] focus:border-transparent text-[var(--text-color)]">
                    @foreach(['personal', 'group'] as $type)
                        <option value="{{ $type }}" {{ old('type', $task->type) === $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
                @error('type')
                <p class="mt-1 text-sm text-[var(--delete-color)]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Due Date -->
            <div class="mb-4">
                <label for="due_date" class="block text-sm font-medium text-[var(--text-color)] mb-1">Due Date*</label>
                <input type="date" id="due_date" name="due_date"
                       value="{{ old('due_date', $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}"
                       class="w-full px-3 py-2 border @error('due_date') border-[var(--delete-color)] @else border-[var(--text-color)] @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--sub-color)] focus:border-transparent">
                @error('due_date')
                <p class="mt-1 text-sm text-[var(--delete-color)]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Goal relationship -->

             <div class="mb-6">
                <label for="goal_id" class="block text-sm font-medium text-gray-700 mb-1">Goal</label>
                <select id="goal_id" name="goal_id"
                        class="w-full px-3 py-2 border @error('goal_id') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-[#3aa499] focus:border-transparent appearance-none">
                    <option value="" selected>No selection</option>
                    <option value="" disabled> --- Individual ---</option>

                    @foreach ($user_goals as $goal)
                         <option value="{{ $goal->id }}" @selected((old('goal_id') ?? $task->goal_id ?? '') == $goal->id)
                            >{{$goal->title}}</option>
                    @endforeach
                    <option value="" disabled> --- Team ---</option>

                    @foreach ($team_goals as $goal)
                         <option value="{{ $goal->id }}" @selected((old('goal_id') ?? $task->goal_id ?? '') == $goal->id)
                            >{{$goal->title}}</option>
                    @endforeach

                </select>


            </div>

            <!-- Completed Checkbox -->
            <div class="mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="completed" value="1"
                           {{ old('completed', $task->completed) ? 'checked' : '' }}
                           class="form-checkbox h-5 w-5 text-[var(--create-color)]">
                    <span class="ml-2 text-[var(--text-color)]">Mark as completed</span>
                </label>
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('tasks.index') }}"
                   class="px-4 py-2 border border-[var(--text-color)] rounded-md text-[var(--text-color)] hover:bg-[var(--background-color)] transition duration-200">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 rounded-md bg-[var(--create-color)] text-[var(--text-color)] font-semibold hover:bg-[var(--accent-color)] transition duration-200">
                    Update Task
                </button>
            </div>
        </form>
    </main>
@endsection
