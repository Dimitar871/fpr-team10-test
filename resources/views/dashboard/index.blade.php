@extends('layouts.app')

@section('main-content')
    <div class="space-y-6">
        <!-- Welcome Header -->
        <div class="text-lg font-semibold text-[var(--text-color)]">Welcome back, {{ Auth::user()?->name }}!</div>
        <div id="current-date" class="text-sm text-[var(--extra-color)]"></div>
        <script>
            document.getElementById('current-date').textContent = new Date().toLocaleDateString(undefined, {
                year: 'numeric', month: 'long', day: 'numeric'
            });
        </script>

        <!-- Top Section: Tasks (2/3) + Quote (1/3)  -->
        <div class="flex flex-col lg:flex-row gap-4">
            <!-- Tasks Overview -->
            <div class="lg:w-2/3 bg-[var(--main-color)] p-4 rounded shadow-sm">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="font-semibold text-[var(--text-color)]">Tasks Overview</h2>
                    <a href="{{ route ('tasks.index') }}" class="text-sm text-[var(--sub-color)] hover:underline">View all ></a>
                </div>
                <ul class="space-y-2">
                    @foreach ($tasks as $task)
                        <li class="p-3 bg-[var(--main-color)] rounded border-l-4 border-[var(--sub-color)]">
                            <div class="text-sm text-[var(--text-color)] font-medium">{{ $task->title }}</div>
                            <div class="text-xs text-[var(--extra-color)]">Due: {{ $task->due_date }}</div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Daily Quote -->
            <div class="lg:w-1/3 bg-[var(--main-color)] p-4 rounded shadow-sm h-fit">
                <h2 class="font-semibold text-[var(--text-color)] mb-2">Daily Quote</h2>
                <blockquote class="text-sm italic text-[var(--extra-color)]">"{{ $quote['q'] }}"</blockquote>
                <p class="text-xs text-right text-[var(--extra-color)] mt-2">- {{ $quote['a'] }}</p>
            </div>
        </div>

        <!-- Bottom Section: Articles (1/2) + Goals (1/2) -->
        <div class="flex flex-col lg:flex-row gap-4">
            <!-- Latest Articles -->
            <div class="lg:w-1/2 bg-[var(--main-color)] p-4 rounded shadow-sm">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="font-semibold text-[var(--text-color)]">Latest Articles</h2>
                    <span class="text-xs text-[var(--extra-color)]">
                        {{ $earnedPointsToday }} of 15 points earned today
                    </span>
                    <a href="{{ route ('articles.index') }}" class="text-sm text-[var(--sub-color)] hover:underline">View all ></a>
                </div>
                <ul class="space-y-2">
                    @foreach ($articles as $article)
                        <li>
                            <div class="text-sm font-medium text-[var(--text-color)]">
                                <a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
                            </div>
                            <div class="text-xs text-[var(--extra-color)]">
                                {{ $article->excerpt }} · By {{ $article->author }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Goals Progress -->
            <div class="lg:w-1/2 bg-[var(--main-color)] p-4 rounded shadow-sm">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="font-semibold text-[var(--text-color)]">Goals Progress</h2>
                    <a href="{{ route ('goals.index') }}" class="text-sm text-[var(--sub-color)] hover:underline">View all ></a>
                </div>
                <div class="space-y-3 text-sm text-[var(--text-color)]">
                    @foreach ($goals as $goal)
                        <div>
                            @php
                                $completed_tasks = collect($goal->tasks)->filter(function ($task) {
                                    return $task->completed;
                                });
                            @endphp
                            <p>{{ $goal->title }} <span class="float-right">
                                    {{ count($goal->tasks) > 0 ? number_format(count($completed_tasks) / count($goal->tasks) * 100, 0) . '%' : 'No associated tasks.' }}
                                </span></p>

                            <div class="w-full h-2 bg-gray-200 rounded">

                                <div class="bg-[var(--sub-color)] h-2 rounded" style="width: {{ count($goal->tasks) > 0 ? number_format((count($completed_tasks) / count($goal->tasks)) * 100, 2) : 0 }}%;"></div>
                            </div>
                            <p class="text-xs text-[var(--extra-color)] mt-1">{{ $goal->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

