@extends('layouts.app')

@section('main-content')
    <main class="w-full h-full flex flex-col gap-4 max-w-[800px] mx-auto py-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-1 items-start">
                <h1 class="text-xl font-semibold text-[var(--text-color)]">My Diary</h1>
                <span class="text-[var(--text-color)] text-xs">Track your daily reflection and well-being</span>
            </div>
            <div class="hover:ring-2 p-[1px] ring-[var(--sub-color)] rounded-md duration-300">
                <a href="{{ route('diaries.create') }}">
                    <button class="px-4 py-2 rounded-md bg-[var(--sub-color)] text-white font-semibold">+ Create Entry</button>
                </a>
            </div>
        </div>
        @if(session('success'))
            <div id="success-alert"
                 class="bg-[var(--create-color)] border border-[var(--create-color)] text-[var(--text-color)] px-4 py-3 rounded relative mb-4 transition-opacity duration-500"
                 role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <!-- Filter Form -->
<form method="GET" action="{{ route('diaries.index') }}" class="flex gap-4 flex-wrap items-center bg-[var(--main-color)] border border-[#E5E7EB] p-4 rounded-md shadow-sm mt-2">
    <select name="mood" class="border p-2 rounded bg-[var(--main-color)]">
        <option value="">All Moods</option>
        @foreach(['Poor', 'Below Average', 'Average', 'Good', 'Excellent'] as $value)
            <option value="{{ $value }}" {{ request('mood') == $value ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>

    <select name="energy" class="border p-2 rounded bg-[var(--main-color)]">
        <option value="">All Energy Levels</option>
        @foreach(['Poor', 'Below Average', 'Average', 'Good', 'Excellent'] as $value)
            <option value="{{ $value }}" {{ request('energy') == $value ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>

    <select name="stress" class="border p-2 rounded bg-[var(--main-color)]">
        <option value="">All Stress Levels</option>
        @foreach(['Poor', 'Below Average', 'Average', 'Good', 'Excellent'] as $value)
            <option value="{{ $value }}" {{ request('stress') == $value ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>

    <button type="submit" class="bg-[var(--sub-color)] text-white px-4 py-2 rounded">Filter</button>
    <a href="{{ route('diaries.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Reset</a>
</form>
        <!-- Recent Entries Section -->
        <div class="flex flex-col gap-4 mt-4">
            @if($entries->isEmpty())
                <div class="bg-[var(--main-color)] border border-[var(--background-color)] p-6 rounded-md shadow-sm text-center text-[var(--text-color)]">
                    No diary entries yet. Start by creating your first entry!
                </div>
            @else
                @foreach($entries as $entry)
                    <div class="bg-[var(--main-color)] border border-[var(--background-color)] p-4 rounded-md shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-[var(--text-color)]">{{ $entry->entry_date->format('F j, Y') }}</h3>
                                <div class="flex gap-4 mt-2">
                                    <span class="text-sm text-[var(--text-color)]">
                                        Mood: {{ $entry->mood }} {{ $entry->mood === 'Excellent' ? '😊' : ($entry->mood === 'Good' ? '🙂' : ($entry->mood === 'Average' ? '😐' : ($entry->mood === 'Below Average' ? '😕' : '😢'))) }}
                                    </span>
                                    <span class="text-sm text-[var(--text-color)]">
                                        Energy: {{ $entry->energy }} {{ $entry->energy === 'Excellent' ? '⚡' : ($entry->energy === 'Good' ? '💪' : ($entry->energy === 'Average' ? '😌' : ($entry->energy === 'Below Average' ? '😴' : '😫'))) }}
                                    </span>
                                    <span class="text-sm text-[var(--text-color)]">
                                        Stress: {{ $entry->stress }} {{ $entry->stress === 'Excellent' ? '😌' : ($entry->stress === 'Good' ? '😊' : ($entry->stress === 'Average' ? '😐' : ($entry->stress === 'Below Average' ? '😰' : '😱'))) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                @if($entry->canBeEdited())
                                    <a href="{{ route('diaries.edit', $entry) }}" class="text-xs bg-[var(--edit-color)] text-[var(--text-color)] px-2 py-1 rounded hover:bg-[var(--edit-color)] transition">
                                        Edit
                                    </a>
                                @endif
                                <a href="{{ route('diaries.show', $entry) }}" class="text-xs bg-[var(--create-color)] text-[var(--text-color)] px-2 py-1 rounded hover:bg-[var(--create-color)] transition">
                                    View
                                </a>
                            </div>
                        </div>
                        <div class="mt-3">
                            <p class="text-sm text-[var(--text-color)] mb-2"><strong>Highlights:</strong> {{ Str::limit($entry->highlights, 100) }}</p>
                            <p class="text-sm text-[var(--text-color)] mb-2"><strong>Challenges:</strong> {{ Str::limit($entry->challenges, 100) }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </main>
@endsection

<script>
    setTimeout(function () {
        const alert = document.getElementById('success-alert');
        if (alert) {
            alert.remove();
        }
    }, 7000);
</script>
