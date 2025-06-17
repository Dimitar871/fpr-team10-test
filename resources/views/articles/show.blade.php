@extends('layouts.app')
@include('components.modal')

@section('main-content')
    @php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
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
    <main class="w-full max-w-[800px] mx-auto py-8 flex flex-col gap-6">
        <!-- Back Button -->
        <div>
            <a href="{{ route('articles.index') }}" class="text-sm text-[var(--sub-color)] hover:underline">&larr; Back to Articles</a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Article Labels -->
        <div class="flex flex-wrap gap-2 mt-2">
            @foreach($article->labels as $label)
                <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-md">
            {{ $label->name }}
        </span>
            @endforeach
        </div>

        <!-- Article Header -->
        <div class="relative flex-col gap-2">
            <h1 class="text-3xl font-bold">{{ $article->title }}</h1>
            <div class="text-sm">
                By {{ $article->author }} · {{ \Carbon\Carbon::parse($article->created_at)->format('F d, Y') }} · {{ $readCount }} reads
            </div>
            <form action="{{ route('articles.toggleFavourite', $article->id) }}" method="POST">
                @csrf
                <button type="submit" class="absolute top-0 right-0 p-2" title="Favorite">
                    {{ $isFavourite ? '❤️' : '🤍' }}
                </button>
            </form>
        </div>

        <!-- Excerpt -->
        <div class="text-md italic">
            "{{ $article->excerpt }}"
        </div>

        <!-- Article Content -->
        <div class="prose max-w-none">
            {!! nl2br(e($article->content)) !!}
        </div>

        <!-- Buttons -->
        <div class="flex justify-between items-center mt-8">
            <!-- Previous -->
            @if($previous)
                <a href="{{ route('articles.show', $previous->id) }}"
                   class="px-4 py-2 bg-[var(--sub-color)] text-white rounded-md hover:bg-[var(--accent-color)] text-sm">
                   Previous article
                </a>
            @endif

            <!-- Middle section -->
            <div class="flex gap-2">
                <!-- Mark as read -->
                <form action="{{ route('articles.toggleRead', $article->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-sm border {{ $isRead ? 'bg-[var(--background-color)]' : 'bg-[rgba(var(--accent-color-rgb),0.5)]' }} border-gray-300 rounded-md hover:bg-[var(--background-color)]">
                        {{ $isRead ? 'Unmark as Read' : 'Mark as Read' }}
                    </button>
                </form>

                @if($user && $user->name === 'HR member')
                <!-- Edit -->
                <a href="{{ route('articles.edit', $article->id) }}">
                    <button class="px-4 py-2 bg-[var(--edit-color)] text-white rounded-md hover:bg-[var(--edit-color)] text-sm">Edit</button>
                </a>

                <!-- Delete -->
                    <button type="button"
                            class="open-action-modal px-4 py-2 bg-[var(--delete-color)] text-white rounded-md hover:bg-[var(--delete-color)] text-sm"
                            data-action="{{ route('articles.destroy', $article->id) }}"
                            data-name="article '{{ $article->title }}'"
                            data-title="Confirm Deletion"
                            data-message="Are you sure you want to delete article '{{ $article->title }}'?"
                            data-method="DELETE"
                            title="Delete">
                        Delete
                    </button>
                @endif
            </div>

            <!-- Next -->
            @if($next)
                <a href="{{ route('articles.show', $next->id) }}"
                   class="px-4 py-2 bg-[var(--sub-color)] text-white rounded-md hover:bg-[var(--accent-color)] text-sm">
                    Next article
                </a>
            @endif
        </div>
    </main>
@endsection
