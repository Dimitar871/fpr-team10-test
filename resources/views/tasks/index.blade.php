@extends('layouts.app')
@include('components.modal')

@section('main-content')
    <main class="w-full h-full flex flex-col gap-4 max-w-[800px] mx-auto py-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-1 items-start">
                <p class="text-xl font-semibold">Tasks</p>
                <span class="text-[var(--text-color)] text-xs">Manage your personal, group, and assigned tasks</span>
            </div>
            <div class="hover:ring-2 p-[1px] ring-[var(--sub-color)] rounded-md duration-300">
                <a href="{{ route('tasks.create') }}">
                    <button class="px-4 py-2 rounded-md bg-[var(--sub-color)] text-white font-semibold">+ Create Task</button>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div id="success-alert"
                 class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 transition-opacity duration-500"
                 role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex flex-wrap gap-2 mt-4">
            <a href="{{ route('tasks.index') }}"
               class="px-3 py-1 text-sm rounded-md transition-all duration-200
                      {{ !$selectedType ? 'bg-[var(--sub-color)] text-white' : 'bg-[var(--background-color)] text-[var(--text-color)] hover:bg-[var(--secondary-color)]' }}">
                All Tasks
            </a>

            @foreach(['personal', 'group'] as $type)
                <a href="{{ route('tasks.index', ['type' => $type]) }}"
                   class="px-3 py-1 text-sm rounded-md transition-all duration-200
                          {{ $selectedType === $type ?
                             'bg-[var(--sub-color)] text-white' :
                             'bg-[var(--background-color)] text-[var(--text-color)] hover:bg-[var(--secondary-color)]' }}">
                    {{ ucfirst($type) }}
                </a>
            @endforeach
        </div>

        <!-- Tasks List -->
        <div class="flex flex-col gap-4 mt-4">
            @forelse($tasks as $task)
                <div class="{{ $task->completed ? 'bg-[var(--background-color)]' : 'bg-[var(--main-color)]' }} border border-[#E5E7EB] p-4 rounded-md shadow-sm {{ $task->completed ? '' : 'hover:shadow-md' }} transition-shadow duration-200">
                    <div class="flex justify-between items-start">
                        @php
                            $typeClasses = [
                                'personal' => 'bg-[#F0FDFA] text-[#45968F]',
                                'group' => 'bg-[#EFF6FF] text-[#3B82F6]'
                            ];
                        @endphp
                        <span class="text-xs px-2 py-1 rounded-md {{ $task->completed ? 'bg-gray-100 text-gray-500' : ($typeClasses[$task->type] ?? 'bg-gray-100') }}">
                            {{ $task->type }}
                        </span>
                    </div>

                    <p class="font-semibold mt-2 {{ $task->completed ? 'text-[var(--text-color)]' : 'text-[var(--text-color)]' }}">{{ $task->title }}</p>
                    <p class="text-sm {{ $task->completed ? 'text-[var(--text-color)]' : 'text-[var(--text-color)]' }} mt-1">{{ $task->description }}</p>

                    <div class="flex justify-between items-center mt-3">
                        <div class="flex items-center gap-1 text-xs text-[var(--text-color)]">
                            <span>💬</span>
                            <span>Due: {{ \Carbon\Carbon::parse($task->due_date)->format('F j, Y') }}</span>
                        </div>

                        <div class="flex gap-2 items-center">
                            <form action="{{ route('tasks.toggle', $task->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="px-3 py-1 text-sm border border-[var(--background-color)] rounded-md
                    {{ $task->completed
                        ? 'bg-[var(--background-color)] text-[var(--text-color)]'
                        : 'bg-[var(--accent-color)] text-white hover:bg-[var(--background-color)]' }}">
                                    {{ $task->completed ? '✓ Completed' : 'Mark Complete' }}
                                </button>
                            </form>
                            <a href="{{ route('tasks.edit', $task->id) }}"
                               class="text-xs px-2 py-1 rounded transition
                  bg-[var(--edit-color)] text-white hover:opacity-80">
                                Edit
                            </a>
                            <button type="button"
                                    class="text-xs bg-[var(--delete-color)] text-white px-2 py-1 rounded hover:bg-red-200 transition open-action-modal"
                                    title="Delete"
                                    data-action="{{ route('tasks.destroy', $task->id) }}"
                                    data-title="Confirm Deletion"
                                    data-message="Are you sure you want to delete task '{{ $task->title }}'?"
                                    data-method="DELETE">
                                Delete
                            </button>

                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-[var(--main-color)] border border-[#E5E7EB] p-6 rounded-md shadow-sm text-center text-[var(--text-color)]">
                    No tasks found. Create your first task!
                </div>
            @endforelse
        </div>
    </main>
@endsection
