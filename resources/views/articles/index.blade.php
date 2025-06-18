@extends('layouts.app')
@include('components.modal')


@section('main-content')
    @php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
    @endphp
<script>
        // Toggle the visibility of the label filter dropdownAdd commentMore actions
            function toggleLabelDropdown() {
                const dropdown = document.getElementById('labelDropdown');
                dropdown.classList.toggle('hidden');
            }

            // Remove a selected label from the filter by clicking on the cross icon
            function removeLabel(labelId) {
                // Find the checkbox that suits the label being removed
                const checkbox = document.querySelector(input[name="labels[]"][value="${labelId}"]);
                if (checkbox) {
                    // Uncheck the checkbox and submit the form to update the filter
                    checkbox.checked = false;
                    checkbox.form.submit();
                }
            }

            // Close the label dropdown when clicking outside of it
            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById('labelDropdown');
                const filterButton = event.target.closest('button');

                // Close if clicking outside both the dropdown and the filter button
                if (!dropdown.contains(event.target) && !filterButton) {
                    dropdown.classList.add('hidden');
                }
            });
        </script>
    <main class="w-full h-full flex flex-col gap-4 max-w-[800px] mx-auto">
        <!-- Navbar -->
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div class="flex flex-col gap-1 items-start">
                    <p class="text-xl font-semibold">Articles</p>
                    <span class="text-[var(--text-color)] text-xs">Browse and discover wellness content</span>
                </div>
                @if($user && $user->name === 'HR member')
                    <div class="ring-2 p-[1px] ring-[var(--sub-color)] rounded-md duration-300">
                        <a href="{{ route('articles.create') }}">
                            <button class="px-4 py-2 rounded-md bg-[var(--sub-color)] text-white font-semibold">+ Create Article</button>
                        </a>
                    </div>
                @endif
            </div>

            <form action="{{ route('articles.index') }}" method="GET" class="flex items-center gap-4">
                <!-- Search bar -->
                <div class="relative flex-1">
                    <div class="flex items-center gap-2 bg-[var(--main-color)] border border-[var(--text-color)] rounded-md px-3 py-1.5 w-full">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search articles..."
                               class="text-sm bg-transparent text-[var(--text-color)] focus:outline-none w-full"
                        >
                        <div class="h-5 w-[2px] bg-[var(--text-color)] opacity-30"></div>
                        <button type="submit" class="text-[var(--text-color)] text-sm hover:text-[var(--sub-color)]">
                            Apply
                        </button>
                    </div>
                </div>
                <!--Filter by labels-->
                <div class="relative w-[180px]">
                    <div class="flex items-center gap-2 bg-[var(--main-color)] border border-[var(--text-color)] rounded-md px-3 py-1.5 w-full">
                        <div class="flex items-center gap-1.5 flex-wrap w-full max-h-[60px] overflow-y-auto">
                            @if(!empty($selectedLabels))
                                @foreach($selectedLabels as $selectedId)
                                    @php
                                        $selectedLabel = $labels->firstWhere('id', $selectedId);
                                    @endphp
                                    @if($selectedLabel)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-[rgba(var(--accent-color-rgb),0.5)] text-[var(--text-color)] text-xs rounded whitespace-nowrap">
                                            {{ $selectedLabel->name }}
                                            <button type="button" onclick="removeLabel({{ $selectedId }})" class="hover:text-[var(--delete-color)]">×</button>
                                        </span>
                                    @endif
                                @endforeach
                            @endif
                            <button type="button" name="sort" onclick="toggleLabelDropdown()" class="text-[var(--text-color)] text-sm hover:text-[var(--sub-color)] flex-1 text-left whitespace-nowrap">
                                {{ empty($selectedLabels) ? 'Filter by Labels' : '+ Add More' }}
                            </button>
                        </div>
                    </div>

                    <div id="labelDropdown" class="absolute left-0 mt-1 w-full bg-[var(--main-color)] border border-[var(--text-color)] rounded-md shadow-sm hidden z-10">
                        <div class="p-2">
                            <div class="max-h-48 overflow-y-auto">
                                @foreach($labels as $label)
                                    <label class="flex items-center gap-2 p-1.5 hover:bg-[var(--background-color)] rounded cursor-pointer">
                                        <input type="checkbox"
                                               name="labels[]"
                                               value="{{ $label->id }}"
                                               {{ in_array($label->id, $selectedLabels ?? []) ? 'checked' : '' }}
                                               onchange="this.form.submit()"
                                               class="rounded border-[var(--text-color)] text-[var(--sub-color)] focus:ring-[var(--sub-color)]">
                                        <span class="text-sm text-[var(--text-color)]">{{ $label->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!--Sorting-->
                <select name="sort" onchange="this.form.submit()" class="text-sm border border-[var(--text-color)] rounded-md px-3 py-1.5 bg-[var(--main-color)] text-[var(--text-color)] focus:outline-none focus:ring-1 focus:ring-[var(--sub-color)] w-[140px]">
                    <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="a-z" {{ $sort === 'a-z' ? 'selected' : '' }}>A-Z</option>
                    <option value="z-a" {{ $sort === 'z-a' ? 'selected' : '' }}>Z-A</option>
                    <option value="most_reads" {{ $sort === 'most_reads' ? 'selected' : '' }}>Most Reads</option>
                    <option value="least_reads" {{ $sort === 'least_reads' ? 'selected' : '' }}>Least Reads</option>
                    <option value="favourites" {{ $sort === 'favourites' ? 'selected' : '' }}>Favourites</option>
                </select>
            </form>
        </div>

        @if(session('success'))
            <div id="success-alert"
                 class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 transition-opacity duration-500"
                 role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('points'))
            <div id="points-alert"
                 class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 transition-opacity duration-500"
                 role="alert">
                <span class="block sm:inline">{{ session('points') }}</span>
            </div>
        @endif

        <!-- Articles List -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @if($sort === 'favourites' && Auth::check() && !$articles->contains(function($article) {
                return $article->likers->contains(function($liker) {
                    return $liker->id === Auth::id() && $liker->pivot->favourite;
                });
            }))
                <div class="col-span-2 bg-[var(--main-color)] border border-[#E5E7EB] p-6 rounded-md shadow-sm">
                    <div class="flex flex-col items-center justify-center gap-2">
                        <span class="text-4xl">🤍</span>
                        <p class="text-[var(--text-color)] font-medium">No Favourites Yet</p>
                        <p class="text-sm text-[var(--extra-color)] text-center">You haven't favourited any articles yet. Click the heart icon on any article to add it to your favourites.</p>
                    </div>
                </div>
            @else
                @foreach($articles as $article)
                    @php
                        $pivotRead = null;
                        $pivotLike = null;
                        $isRead = false;
                        $isFavourite = false;

                        if ($user) {
                            $pivotRead = $article->readers->find($user->id)?->pivot;
                            $isRead = $pivotRead?->read ?? false;

                            $pivotLike = $article->likers->find($user->id)?->pivot;
                            $isFavourite = $pivotLike?->favourite ?? false;
                        }

                        $readCount = $article->readers()->wherePivot('read', true)->count();
                    @endphp
                    <div class="{{ $isRead ? 'bg-[var(--background-color)]' : 'bg-[var(--main-color)] ' }}border border-[#E5E7EB] p-6 rounded-md flex flex-col gap-2 shadow-sm">
                        <div class="flex justify-between items-start">
                            <div class="flex flex-wrap gap-1">
                                @foreach($article->labels as $label)
                                    <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-md">{{ $label->name }}</span>
                                @endforeach
                            </div>
                            <form action="{{ route('articles.toggleFavourite', $article->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2" title="Favorite">
                                    {{ $isFavourite ? '❤️' : '🤍' }}
                                </button>
                            </form>
                        </div>
                        <div class="flex justify-between items-start">
                            <a href="{{ route('articles.show', $article) }}"><strong>{{ $article->title }}</strong></a>
                            <span class="text-sm text-gray-400">Reads: {{ $readCount }}</span>
                        </div>
                        <p class="text-sm text-[var(--text-color)] leading-relaxed line-clamp-3">{{ $article->excerpt }}</p>
                        <div class="text-xs text-[var(--text-color)] mt-2">By {{ $article->author }} · {{ \Carbon\Carbon::parse($article->created_at)->format('F d, Y') }}</div>
                        <div class="flex items-center gap-2 mt-4">
                            <!-- Mark as Read -->
                            <form action="{{ route('articles.toggleRead', $article->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1 text-sm text-[var(--extra-color)] {{ $isRead ? 'bg-[var(--background-color)]' : 'bg-[rgba(var(--accent-color-rgb),0.5)]' }} border border-gray-300 rounded-md hover:bg-[var(--background-color)]">
                                    {{ $isRead ? 'Unmark as Read' : 'Mark as Read' }}
                                </button>
                            </form>

                            @if($user && $user->name === 'HR member')
                                <!-- Edit -->
                                <a href="{{ route('articles.edit', $article->id) }}">
                                    <button type="button" class="text-gray-500 edit-label-btn" title="Edit">&#9998;</button>
                                </a>

                                <!-- Delete -->
                                <button type="button"
                                        class="text-[var(--delete-color)] open-action-modal"
                                        title="Delete"
                                        data-action="{{ route('articles.destroy', $article->id) }}"
                                        data-title="Confirm Deletion"
                                        data-message="Are you sure you want to delete article '{{ $article->title }}'?"
                                        data-method="DELETE">
                                    &#128465;
                                </button>

                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </main>
@endsection
