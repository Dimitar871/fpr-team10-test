<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/webp" href="{{ asset('images/tab_logo.webp') }}">
    <title>Syntess Vitality</title>
    @vite('resources/css/app.css')
    @vite(['resources/js/modal-handler.js'])
    @php
        $accent = $activeTheme?->accent_color ?? '0000ff';
        $accentR = hexdec(substr($accent, 0, 2));
        $accentG = hexdec(substr($accent, 2, 2));
        $accentB = hexdec(substr($accent, 4, 2));
    @endphp
    <style>
        [x-cloak] { display: none !important; }
        :root {
            --main-color: {{ '#' . ($activeTheme?->main_color ?? 'f9f9f9') }};
            --sub-color: {{ '#' . ($activeTheme?->sub_color ?? '3aa499') }};
            --accent-color: {{ '#' . ($activeTheme?->accent_color ?? '7be8dd') }};
            --edit-color: {{ '#' . ($activeTheme?->edit_color ?? '0000ff') }};
            --delete-color: {{ '#' . ($activeTheme?->delete_color ?? 'ff0000') }};
            --create-color: {{ '#' . ($activeTheme?->create_color ?? '3aa499') }};
            --background-color: {{ '#' . ($activeTheme?->background_color ?? 'eeeeee') }};
            --extra-color: {{ '#' . ($activeTheme?->extra_color ?? '297a7b') }};
            --text-color: {{ '#' . ($activeTheme?->text_color ?? '2e2e2e') }};

            --accent-color-rgb: {{ hexdec(substr($activeTheme?->accent_color ?? '0000ff', 0, 2)) }}, {{ hexdec(substr($activeTheme?->accent_color ?? '0000ff', 2, 2)) }}, {{ hexdec(substr($activeTheme?->accent_color ?? '0000ff', 4, 2)) }};
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .app-container {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 240px;
            /* background-color: ; */
            /* padding: 1.5rem 1rem; */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid #ccc;
        }


        .main-area {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            /* background-color: #ccc; */
            height: 7.5%;
            flex-shrink: 0;
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search {
            padding: 0.4rem 0.75rem;
            border: 1px solid #aaa;
            border-radius: 8px;
            width: 240px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .notification-btn {
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
        }

        .profile-pic {
            width: 36px;
            height: 36px;
            border-radius: 50%;
        }

        .main-content {
            padding: 2rem;
            overflow-y: auto;
            flex-grow: 1;
            /* background: #e5e5e5; */
        }

        footer {
            background-color: #ddd;
            padding: 1rem;
            text-align: center;
            font-size: 0.875rem;
            color: #555;
        }
    </style>
</head>

<body>
<div class="app-container">
    <!-- Sidebar -->
    <aside class="w-[240px] flex justify-between flex-col bg-[var(--main-color)] border-[var(--background-color)] border-r">
        <div class="">
            <div class="border-b border-[var(--background-color)] h-[100px]">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" />
            </div>
            <nav class="flex flex-col p-1">
                <a href="/" class="{{ request()->is('/') ? 'bg-[rgba(var(--accent-color-rgb),0.2)] text-[var(--sub-color)]' : 'text-[var(--text-color)]' }} w-full px-4 py-2 font-semibold">Dashboard</a>
                <a href="{{ route('articles.index') }}" class="{{ request()->is('articles') ? 'bg-[rgba(var(--accent-color-rgb),0.2)] text-[var(--sub-color)]' : 'text-[var(--text-color)]' }} w-full px-4 py-2 font-semibold">Articles</a>
                <a href="{{ route('tasks.index') }}" class="{{ request()->is('tasks') ? 'bg-[rgba(var(--accent-color-rgb),0.2)] text-[var(--sub-color)]' : 'text-[var(--text-color)]' }} w-full px-4 py-2 font-semibold">Tasks</a>
                <a href="{{ route('goals.index') }}" class="{{ request()->is('goals') ? 'bg-[rgba(var(--accent-color-rgb),0.2)] text-[var(--sub-color)]' : 'text-[var(--text-color)]' }} w-full px-4 py-2 font-semibold">Goals</a>
                <a href="{{ route('diaries.index') }}" class="{{ request()->is('diaries') ? 'bg-[rgba(var(--accent-color-rgb),0.2)] text-[var(--sub-color)]' : 'text-[var(--text-color)]' }} w-full px-4 py-2 font-semibold">Diary</a>
                <a href="{{ route('shop.index') }}" class="{{ request()->is('shop') ? 'bg-[rgba(var(--accent-color-rgb),0.2)] text-[var(--sub-color)]' : 'text-[var(--text-color)]' }} w-full px-4 py-2 font-semibold">Shop</a>
            </nav>
        </div>
        <a href="{{ route('settings.index') }}">
            <div class="flex items-center gap-2 border-[var(--background-color)] px-3 py-2 border-t">
                <img src="{{ asset('images/user.jpg') }}" alt="User" class="h-[40px] w-[40px] rounded-full border " />
                <div class="flex flex-col items-start gap-1 justify-around">
                    <span class="font-semibold text-sm">{{ Auth::user()?->name }}</span>
                    <span class="text-[var(--text-color)] text-xs">{{ Auth::user()?->points }} points</span>
                </div>
            </div>
        </a>
    </aside>

    <!-- Main Area -->
    <div class="main-area">
        <!-- Topbar -->
        <header class=" flex items-center p-4   justify-end h-[65px] bg-[var(--main-color)] border-b border-[var(--background-color)]">
            <div class="topbar-right">
                <button class="notification-btn">🔔</button>
                <a href="{{ route('settings.index') }}" class="notification-btn" title="Settings">⚙️</a>
                <form action="{{ route('switch-user') }}" method="POST">
                    @csrf
                    <select name="user_id" onchange="this.form.submit()" class="block w-full rounded-md border border-[var(--background-color)] bg-[var(--main-color)] py-2 px-3 shadow-sm">
                        <option value="" disabled selected>Select user to log in</option>
                        @foreach($switchableUsers as $user)
                            <option value="{{ $user->id }}" {{ Auth::id() === $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <a href="{{ route('settings.index') }}">
                <img src="{{ asset('images/user.jpg') }}" alt="Profile" class="profile-pic" />
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content bg-[var(--background-color)]">
            @yield('main-content')
        </main>
    </div>
</div>

<!-- Footer -->
<!-- <footer>
Project Footer
</footer> -->
</body>

</html>
