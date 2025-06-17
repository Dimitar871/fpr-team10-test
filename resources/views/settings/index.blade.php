@extends('layouts.app')

@section('main-content')
    @php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
    @endphp

    <main class="w-full h-full flex flex-col gap-6 max-w-[800px] mx-auto text-[var(--text-color)]">
        <!-- Header -->
        <div class="flex flex-col gap-1">
            <p class="text-xl font-semibold">Settings</p>
            <span class="text-xs text-[var(--extra-color)]">Where you can change your avatar, theme, and account settings</span>
        </div>

        <!-- Info Section -->
        <section class="flex flex-col gap-2 p-4 bg-[var(--main-color)] border border-[var(--extra-color)] rounded-md shadow-sm">
            <h2 class="text-lg font-semibold">Information</h2>
            <p><strong>Name:</strong> {{ $user->name ?? 'Name' }}</p>
            <p><strong>Position:</strong> {{ $user->name ?? 'Name' }}</p>
            <p><strong>Age group:</strong> 18–30 years</p>
            <p>
                <strong>Privacy:</strong>
                <span class="inline-block px-2 py-1 text-xs bg-[var(--sub-color)] text-white rounded">Public</span>
            </p>
        </section>

        <!-- Avatar Section -->
        <section class="flex flex-col gap-3 p-4 bg-[var(--main-color)] border border-[var(--extra-color)] rounded-md shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">Avatar</h2>
                <span class="text-xs bg-[var(--extra-color)] px-2 py-[2px] rounded text-white">Saved</span>
            </div>
            <p class="text-sm text-[var(--extra-color)]">It only shows the Avatars that you own</p>
            <div class="flex gap-4">
                <div class="w-12 h-12 rounded-full bg-[var(--extra-color)]"></div>
                <div class="w-12 h-12 rounded-full bg-[var(--sub-color)]/[0.3]"></div>
                <img src="{{ asset('images/user.jpg') }}" alt="User Avatar" class="w-12 h-12 rounded-full border-2 border-[var(--sub-color)]">
            </div>
        </section>

        <!-- Theme Section -->
        <section class="flex flex-col gap-3 p-4 bg-[var(--main-color)] border border-[var(--extra-color)] rounded-md shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">Themes</h2>
                <h3 id="current-theme-label" class="font-semibold">Your Current theme: {{ $activeTheme?->title }}</h3>
            </div>
            <p class="text-sm text-[var(--extra-color)]">It only shows the Themes that you own</p>
            <div class="flex flex-wrap gap-3">
                @foreach ($user->themes as $theme)
                    @php $isEquipped = $theme->pivot->equipped; @endphp
                    <button
                        class="px-3 py-1 text-sm rounded hover:cursor-pointer equip-theme-btn {{ $isEquipped ? 'ring-4' : '' }}"
                        style="
                            background-color: #{{ $theme->main_color }};
                            color: #{{ $theme->text_color }};
                            border: {{ $isEquipped ? '6px' : '2px' }} solid #{{ $isEquipped ? $theme->sub_color : $theme->extra_color }};
                        "
                        data-theme-id="{{ $theme->id }}"
                    >
                        {{ $theme->title }}
                    </button>
                @endforeach
            </div>
        </section>
    </main>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function hexToRgb(hex) {
            const bigint = parseInt(hex, 16);
            return [(bigint >> 16) & 255, (bigint >> 8) & 255, bigint & 255];
        }

        function updateCssVariables(theme) {
            const root = document.documentElement;

            root.style.setProperty('--main-color', `#${theme.main_color}`);
            root.style.setProperty('--sub-color', `#${theme.sub_color}`);
            root.style.setProperty('--accent-color', `#${theme.accent_color}`);
            root.style.setProperty('--edit-color', `#${theme.edit_color}`);
            root.style.setProperty('--delete-color', `#${theme.delete_color}`);
            root.style.setProperty('--create-color', `#${theme.create_color}`);
            root.style.setProperty('--background-color', `#${theme.background_color}`);
            root.style.setProperty('--extra-color', `#${theme.extra_color}`);
            root.style.setProperty('--text-color', `#${theme.text_color}`);

            const [r, g, b] = hexToRgb(theme.accent_color);
            root.style.setProperty('--accent-color-rgb', `${r}, ${g}, ${b}`);
        }

        document.querySelectorAll('.equip-theme-btn').forEach(button => {
            button.addEventListener('click', () => {
                const themeId = button.getAttribute('data-theme-id');

                fetch(`{{ url('theme/equip') }}/${themeId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({})
                })
                    .then(async response => {
                        if (!response.ok) {
                            const errorText = await response.text();
                            throw new Error(`Server error: ${response.status} - ${errorText}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Update theme button UI
                        document.querySelectorAll('.equip-theme-btn').forEach(btn => {
                            btn.classList.remove('ring-4');
                            btn.style.border = btn.style.border.replace(/^(\d+)px/, '2px');
                        });

                        button.classList.add('ring-4');
                        button.style.border = button.style.border.replace(/^(\d+)px/, '6px');

                        // Update CSS variables
                        updateCssVariables(data);

                        // Update current theme label
                        document.querySelector('#current-theme-label').textContent = `Your Current theme: ${data.title}`;
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        alert('Something went wrong while switching themes.');
                    });
            });
        });
    </script>
@endsection
