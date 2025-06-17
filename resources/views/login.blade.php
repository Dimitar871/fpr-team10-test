<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Syntess Vitality</title>
    @vite('resources/css/app.css')
    <style>
        :root {
            --main-color: #f9f9f9;
            --sub-color: #3aa499;
            --background-color: #eeeeee;
            --text-color: #2e2e2e;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-[var(--background-color)]">

<div class="bg-[var(--main-color)] p-10 rounded-2xl shadow-xl w-full max-w-md">
    <h2 class="text-3xl font-bold text-center text-[var(--text-color)] mb-6">Access Syntess vitality website</h2>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}" class="space-y-6">
        @csrf

        <!-- User Select -->
        <div>
            <label for="user_id" class="block text-sm font-semibold mb-1 text-[var(--text-color)]">Select user you want to start as</label>
            <select name="user_id" id="user_id" required
                    class="w-full px-4 py-2 border rounded-md bg-[var(--background-color)] border-gray-300 text-[var(--text-color)]">
                <option value="" disabled selected>Select a user</option>
                @foreach(\App\Models\User::all() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            @error('user_id')
            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Access Code Field -->
        <div>
            <label for="access_code" class="block text-sm font-semibold mb-1 text-[var(--text-color)]">Access Code</label>
            <input type="password" name="access_code" id="access_code" required
                   class="w-full px-4 py-2 border rounded-md bg-[var(--background-color)] border-gray-300 text-[var(--text-color)]" />
            @error('access_code')
            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <button type="submit"
                    class="w-full py-2 px-4 bg-[var(--sub-color)] hover:bg-opacity-80 text-white font-semibold rounded-md transition">
                Get access
            </button>
        </div>
    </form>
</div>

</body>
</html>
