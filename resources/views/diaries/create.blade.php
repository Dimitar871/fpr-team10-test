@extends('layouts.app')

@section('main-content')
    <main class="w-full h-full flex flex-col gap-4 max-w-[800px] mx-auto py-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-1 items-start">
                <h1 class="text-xl font-semibold text-[var(--text-color)]">New Diary Entry</h1>
                <span class="text-[var(--text-color)] text-xs">{{ now()->format('F j, Y') }}</span>
            </div>
        </div>
        <form action="{{ isset($diary) ? route('diaries.update', $diary) : route('diaries.store') }}" method="POST" class="bg-[var(--main-color)] border border-[var(--background-color)] p-6 rounded-md shadow-sm" novalidate>
            @csrf
            @if(isset($diary))
                @method('PUT')
            @endif
            <input type="hidden" name="entry_date" value="{{ request('date', isset($diary) ? $diary->entry_date->format('Y-m-d') : now()->format('Y-m-d')) }}">
            @error('entry_date')
            <div class="mb-4 p-4 bg-[var(--delete-color)] border border-[var(--delete-color)] rounded-md">
                <p class="text-sm text-[var(--text-color)]">{{ $message }}</p>
            </div>
            @enderror
            <!-- Mood, Energy, and Stress Selection -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                @foreach (['mood' => 'Mood 😄', 'energy' => 'Energy ⚡', 'stress' => 'Stress 😰'] as $field => $label)
                    <div>
                        <label class="block text-sm font-medium text-[var(--text-color)] mb-2">{{ explode(' ', $label)[0] }}</label>
                        <select name="{{ $field }}" required class="w-full border p-2 rounded @error($field) border-red-500 @else border-gray-300 @enderror">
                            <option value="">Select {{ strtolower(explode(' ', $label)[0]) }}</option>
                            @foreach(['Poor', 'Below Average', 'Average', 'Good', 'Excellent'] as $value)
                                @php
                                    $icons = [
                                        'mood' => ['😢','😕','😐','🙂','😊'],
                                        'energy' => ['😫','😴','😌','💪','⚡'],
                                        'stress' => ['😱','😰','😐','😊','😌'],
                                    ];
                                    $index = array_search($value, ['Poor','Below Average','Average','Good','Excellent']);
                                @endphp
                                <option value="{{ $value }}" {{ old($field) === $value ? 'selected' : '' }}>
                                    {{ $value }} {{ $icons[$field][$index] }}
                                </option>
                            @endforeach
                        </select>
                        @error($field)
                        <p class="mt-1 text-sm text-[var(--delete-color)]">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>
            <!-- Highlights -->
            <div class="mb-6">
                <label for="highlights" class="block text-sm font-medium text-[var(--text-color)] mb-2">What were your highlights today?</label>
                <textarea name="highlights" id="highlights" rows="3" required
                          class="w-full px-3 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3aa499] focus:border-transparent @error('highlights') border-2 border-[var(--delete-color)] @else border border-gray-300 @enderror"
                          placeholder="What went well or made you happy today?">{{ old('highlights') }}</textarea>
                @error('highlights')
                    <p class="mt-1 text-sm text-[var(--delete-color)]">{{ $message }}</p>
                @enderror
            </div>
            <!-- Challenges -->
            <div class="mb-6">
                <label for="challenges" class="block text-sm font-medium text-[var(--text-color)] mb-2">What challenges did you face?</label>
                <textarea name="challenges" id="challenges" rows="3" required
                          class="w-full px-3 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--sub-color)] focus:border-transparent @error('challenges') border-2 border-[var(--delete-color)] @else border-[var(--extra-color)] @enderror"
                          placeholder="What was difficult or could have gone better?">{{ old('challenges') }}</textarea>
                @error('challenges')
                    <p class="mt-1 text-sm text-[var(--delete-color)]">{{ $message }}</p>
                @enderror
            </div>
            <!-- Gratitude -->
            <div class="mb-6">
                <label for="gratitude" class="block text-sm font-medium text-gray-700 mb-2">What are you grateful for?</label>
                <textarea name="gratitude" id="gratitude" rows="3" required
                          class="w-full px-3 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3aa499] focus:border-transparent @error('gratitude') border-2 border-red-500 @else border border-gray-300 @enderror"
                          placeholder="List three things that you're thankful for today.">{{ old('gratitude') }}</textarea>
                @error('gratitude')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <!-- Improvements -->
            <div class="mb-6">
                <label for="improvements" class="block text-sm font-medium text-gray-700 mb-2">What do you want to improve in the future?</label>
                <textarea name="improvements" id="improvements" rows="3" required
                          class="w-full px-3 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3aa499] focus:border-transparent @error('improvements') border-2 border-red-500 @else border border-gray-300 @enderror"
                          placeholder="What do you want to accomplish tomorrow?">{{ old('improvements') }}</textarea>
                @error('improvements')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('diaries.index') }}" class="px-4 py-2 border border-[var(--extra-color)] rounded-md text-[var(--text-color)] hover:bg-[var(--background-color)]">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-[var(--create-color)] text-[var(--text-color)] rounded-md hover:bg-[var(--accent-color)]">
                    {{ isset($diary) ? 'Update Entry' : 'Save Entry' }}
                </button>
            </div>
        </form>
    </main>
@endsection
