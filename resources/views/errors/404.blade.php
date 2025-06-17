@extends('layouts.app')


@section('main-content')
    <div class="mb-4">
        <a href="{{ url()->previous() }}" class="text-sm text-gray-600 hover:text-gray-800">
            ← Back
        </a>
    </div>
    <div class="flex justify-center items-center h-full">
        <div class="bg-white rounded-2xl shadow-md p-10 max-w-lg text-center">
            <h1 class="text-black text-3xl font-bold mb-2">404 Page not found</h1>
            <p class="text-gray-600 mb-6">The page you are looking for does not exist.</p>
            <div class="mb-6">
                <img src="{{ asset('images/404.png') }}" alt="Lost bunny illustration" class="mx-auto h-auto">
            </div>
            <div class="flex justify-center space-x-4">
                <a href="{{ url('/') }}" class="text-black px-4 py-2 bg-white border border-gray-300 rounded-md hover:bg-gray-100">
                    Go Home
                </a>
                <a href="{{ url('/support/404') }}" class="px-4 py-2 bg-green-700 text-white rounded-md hover:bg-green-800">
                    Look for common fixes
                </a>
            </div>
        </div>
    </div>

@endsection
