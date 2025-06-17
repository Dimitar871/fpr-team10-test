@extends('layouts.app')

@section('main-content')
    <main class="w-full h-full flex flex-col gap-4 max-w-[800px] mx-auto py-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-1 items-start">
                <h1 class="text-xl font-semibold text-[var(--text-color)]">Diary Entry</h1>
                <span class="text-[var(--text-color)] text-xs">{{ $diary->entry_date->format('F j, Y') }}</span>
            </div>
            <div class="flex gap-2">
                @if($diary->canBeEdited())
                    <a href="{{ route('diaries.edit', $diary) }}" class="text-xs bg-[var(--edit-color)] text-[var(--text-color)] px-2 py-1 rounded hover:bg-[var(--edit-color)] transition">Edit Entry</a>
                @endif
                <a href="{{ route('diaries.index') }}" class="text-xs bg-[var(--sub-color)] text-[var(--text-color)] px-2 py-1 rounded hover:bg-[var(--accent-color)] transition">&larr; Back to Diary</a>
            </div>
        </div>

        <!-- Entry Content -->
        <div class="bg-[var(--main-color)] border border-[var(--background-color)] p-6 rounded-md shadow-sm">
            <div class="mb-6">
                <div class="flex gap-6">
                    <div class="flex items-center">
                        <span class="text-sm text-[var(--text-color)] mr-2">Mood:</span>
                        <span class="text-sm text-[var(--text-color)]">{{ $diary->mood }}</span>
                        <span class="ml-2">
                            {{ $diary->mood === 'Excellent' ? '😊' : ($diary->mood === 'Good' ? '🙂' : ($diary->mood === 'Average' ? '😐' : ($diary->mood === 'Below Average' ? '😕' : '😢'))) }}
                        </span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm text-[var(--text-color)] mr-2">Energy:</span>
                        <span class="text-sm text-[var(--text-color)]">{{ $diary->energy }}</span>
                        <span class="ml-2">
                            {{ $diary->energy === 'Excellent' ? '⚡' : ($diary->energy === 'Good' ? '💪' : ($diary->energy === 'Average' ? '😌' : ($diary->energy === 'Below Average' ? '😴' : '😫'))) }}
                        </span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm text-[var(--text-color)] mr-2">Stress:</span>
                        <span class="text-sm text-[var(--text-color)]">{{ $diary->stress }}</span>
                        <span class="ml-2">
                            {{ $diary->stress === 'Excellent' ? '😌' : ($diary->stress === 'Good' ? '😊' : ($diary->stress === 'Average' ? '😐' : ($diary->stress === 'Below Average' ? '😰' : '😱'))) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-[var(--text-color)] mb-2">Highlights</h3>
                    <p class="text-sm text-[var(--text-color)] whitespace-pre-wrap">{{ $diary->highlights }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-[var(--text-color)] mb-2">Challenges</h3>
                    <p class="text-sm text-[var(--text-color)] whitespace-pre-wrap">{{ $diary->challenges }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-[var(--text-color)] mb-2">Gratitude</h3>
                    <p class="text-sm text-[var(--text-color)] whitespace-pre-wrap">{{ $diary->gratitude }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-[var(--text-color)] mb-2">Future Improvements</h3>
                    <p class="text-sm text-[var(--text-color)] whitespace-pre-wrap">{{ $diary->improvements }}</p>
                </div>
            </div>
        </div>
    </main>
@endsection
