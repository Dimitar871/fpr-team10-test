@extends('layouts.app')
@include('components.modal')

@section('main-content')
    <main class="w-full h-full flex flex-col gap-4 max-w-[800px] mx-auto py-6 text-[var(--text-color)]">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-1 items-start">
                <p class="text-xl font-semibold">Shop</p>
                <span class="text-xs text-[var(--extra-color)]">Buy items to grow your inventory</span>
            </div>
            <div class="hover:ring-2 p-[1px] ring-[var(--sub-color)] rounded-md duration-300">
                <button class="px-4 py-2 rounded-md bg-[var(--sub-color)] text-white font-semibold">🧾 {{ Auth::user()?->points }} points </button>
            </div>
        </div>

        @if(session('success'))
            <div id="success-alert"
                 class="bg-[var(--edit-color)]/[0.1] border border-[var(--edit-color)] text-[var(--edit-color)] px-4 py-3 rounded relative mb-4 transition-opacity duration-500"
                 role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div id="error-alert"
                 class="bg-[var(--delete-color)]/[0.1] border border-[var(--delete-color)] text-[var(--delete-color)] px-4 py-3 rounded relative mb-4 transition-opacity duration-500"
                 role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @php
            $currentFilter = request()->get('filter', 'all');
        @endphp

        <div class="flex flex-wrap gap-2 mt-4">
            @foreach (['all' => 'All', 'owned' => 'Owned', 'unowned' => 'Unowned'] as $value => $label)
                <a href="{{ route('shop.index', ['filter' => $value]) }}"
                   class="px-3 py-1 text-sm rounded-md transition-all duration-200
           {{ $currentFilter === $value ? 'bg-[var(--sub-color)] text-white' : 'bg-[var(--background-color)] text-[var(--extra-color)] hover:bg-[var(--sub-color)] hover:text-white' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
        <section class="mt-6 flex flex-col gap-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($themes as $theme)
                    @php
                        $owned = $user->themes->contains('id', $theme->id);
                        $colors = [
                            $theme->main_color,
                            $theme->sub_color,
                            $theme->accent_color,
                            $theme->extra_color,
                            $theme->text_color,
                            $theme->background_color
                        ];
                    @endphp

                    <div class="p-4 rounded-md border border-[var(--extra-color)] bg-[var(--main-color)] flex flex-col justify-between gap-3">
                        <!-- Title and Type -->
                        <span class="text-xs px-2 py-1 rounded-md w-fit bg-gray-200 text-gray-700">Theme</span>
                        <h3 class="text-sm font-semibold text-[var(--text-color)]">{{ $theme->title }}</h3>

                        <!-- Theme color pallet-->
                        <div class="relative h-16 overflow-hidden rounded-md">
                            <div class="absolute inset-0 flex">
                                @foreach ($colors as $color)
                                    <div class="flex-1" style="background-color: #{{ $color }}"></div>
                                @endforeach
                            </div>
                        </div>

                        <!-- price and button/owned -->
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-xs text-[var(--extra-color)] font-medium">{{ $theme->points }} points</span>

                            @if ($owned)
                                <span class="text-xs font-semibold text-[var(--create-color)]">Owned</span>
                            @else
                                <button type="button"
                                        onclick="showBuyConfirmModal('{{ route('shop.buyTheme', $theme->id) }}', '{{ $theme->title }}', {{ $theme->points }})"
                                        class="px-3 py-1 text-xs bg-[var(--sub-color)] text-white rounded hover:bg-opacity-80">
                                    Buy
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
@endsection
