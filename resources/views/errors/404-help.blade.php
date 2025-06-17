@extends('layouts.app')


@section('main-content')
    <div class="mb-4">
        <a href="{{ url()->previous() }}" class="text-sm text-gray-600 hover:text-gray-800">
            ← Back
        </a>
    </div>
    <div class="flex justify-center items-center h-full">
        <div class="bg-white rounded-2xl shadow-md p-10 max-w-xl text-center">
            <h1 class="text-black text-2xl font-bold mb-4">404: Common fixes</h1>

            <ol class="text-left text-gray-800 list-decimal list-inside space-y-2 mb-6">
                <li>Check the URL spelling, in case of typos</li>
                <li>Use the website’s search feature</li>
                <li>Retry your path to here from the home page</li>
                <li>Browse the navigation menu</li>
                <li>Check for broken links (if the link is outdated)</li>
                <li>Refresh the page</li>
                <li>Contact support if you believe it is supposed to be here</li>
            </ol>

            <div class="flex justify-center space-x-4">
                <a href="{{ url('/') }}" class="text-black px-4 py-2 bg-white border border-gray-300 rounded-md hover:bg-gray-100">
                    Go Home
                </a>
                <a href="mailto:support@example.com" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Contact Support
                </a>
            </div>
        </div>
    </div>
@endsection
