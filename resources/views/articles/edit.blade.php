@extends('layouts.app')
@include('components.modal')

@section('main-content')
    <main class="w-full h-full flex flex-col gap-4 max-w-[800px] mx-auto py-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-1 items-start">
                <p class="text-xl font-semibold">Edit Article</p>
                <span class="text-[var(--text-color)] text-xs">Update your article details</span>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add your new message box here -->
        <div id="messageBox" class="hidden fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-md z-50"></div>

        <form method="POST" action="{{ route('articles.update', $article->id) }}" class="bg-[var(--main-color)] border-[var(--background-color)] p-6 rounded-md shadow-sm mt-4">
            @csrf
            @method('PUT')

            <!-- Labels Field -->
            <div class="mb-6">
                <label for="labels" class="block text-sm font-medium text-gray-700 mb-1">Labels</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($labels as $label)
                        <div class="flex items-center gap-2 mb-2" data-label-id="{{ $label->id }}">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="labels[]" value="{{ $label->id }}"
                                       class="form-checkbox"
                                    {{ in_array($label->id, old('labels', $article->labels->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700 label-name">{{ $label->name }}</span>
                                <button type="button" class="ml-1 text-gray-500 edit-label-btn" title="Edit">&#9998;</button>
                                <button type="button"
                                        class="text-[var(--delete-color)] open-action-modal"
                                        title="Delete"
                                        data-action="{{ route('labels.destroy', $label->id) }}"
                                        data-title="Confirm Label Deletion"
                                        data-message="Are you sure you want to delete label '{{ $label->name }}'?"
                                        data-method="DELETE">
                                    &#128465;
                                </button>
                            </label>

                            <!-- Edit input (hidden initially) -->
                            <input type="text" class="hidden edit-label-input w-full px-3 py-2 border border-gray-300 rounded-md"
                                   value="{{ $label->name }}">
                            <button type="button" class="hidden text-[var(--create-color)] text-sm update-label-btn">Update</button>
                            <button type="button" class="hidden text-[var(--delete-color)] text-sm cancel-edit-btn">Cancel</button>
                        </div>
                    @endforeach
                    <!-- 'Other' Option -->
                    <label class="inline-flex items-center mr-4">
                        <input type="checkbox" id="otherCheckbox" class="form-checkbox">
                        <span class="ml-2 text-gray-700">Add custom label</span>
                    </label>
                </div>
                @error('labels')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <!-- Textbox for 'Other' (initially hidden) -->
                <div id="otherInputContainer" class="mt-2 {{ old('other_label') ? '' : 'hidden' }} w-full">
                    <input type="text" id="other_label" name="other_label"
                           value="{{ old('other_label') }}"
                           class="w-full px-3 py-2 border @error('other_label') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-[#3aa499] focus:border-transparent"
                           placeholder="Enter custom label">
                    @error('other_label')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Title Field -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-[var(--text-color)] mb-1">Title*</label>
                <input type="text" id="title" name="title"
                       value="{{ old('title', $article->title) }}"
                       class="w-full px-3 py-2 border @error('title') border-[var(--delete-color)] @else border-[var(--text-color)] @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--sub-color)] focus:border-transparent"
                       placeholder="Enter article title">
                @error('title')
                <p class="mt-1 text-sm text-[var(--delete-color)]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Excerpt Field -->
            <div class="mb-6">
                <label for="excerpt" class="block text-sm font-medium text-[var(--text-color)] mb-1">Excerpt*</label>
                <textarea id="excerpt" name="excerpt" rows="2"
                          class="w-full px-3 py-2 border @error('excerpt') border-[var(--delete-color)] @else border-[var(--text-color)] @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--sub-color)] focus:border-transparent"
                          placeholder="Give a short excerpt">{{ old('excerpt', $article->excerpt) }}</textarea>
                @error('excerpt')
                <p class="mt-1 text-sm text-[var(--delete-color)]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content Field -->
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-[var(--text-color)] mb-1">Content*</label>
                <textarea id="content" name="content" rows="5"
                          class="w-full px-3 py-2 border @error('content') border-[var(--delete-color)] @else border-[var(--text-color)] @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--sub-color)] focus:border-transparent"
                          placeholder="Enter article content">{{ old('content', $article->content) }}</textarea>
                @error('content')
                <p class="mt-1 text-sm text-[var(--delete-color)]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Author Field -->
            <div class="mb-6">
                <label for="author" class="block text-sm font-medium text-[var(--text-color)] mb-1">Author*</label>
                <input id="author" name="author"
                       value="{{ old('author', $article->author) }}"
                       class="w-full px-3 py-2 border @error('author') border-[var(--delete-color)] @else border-[var(--text-color)] @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--sub-color)] focus:border-transparent"
                       placeholder="Enter article author">
                @error('author')
                <p class="mt-1 text-sm text-[var(--delete-color)]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('articles.index') }}"
                   class="px-4 py-2 border border-[var(--text-color)] rounded-md text-[var(--text-color)] hover:bg-[var(--background-color)] transition duration-200">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 rounded-md bg-[var(--create-color)] text-[var(--text-color)] font-semibold hover:bg-[var(--accent-color)] transition duration-200">
                    Update Article
                </button>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    function showMessage(message, isError = false) {
                        const messageBox = document.getElementById('messageBox');
                        messageBox.textContent = message;
                        messageBox.classList.remove('hidden');
                        messageBox.style.backgroundColor = isError ? '#fecaca' : '#bbf7d0';
                        messageBox.style.color = isError ? '#991b1b' : '#166534';
                        setTimeout(() => {
                            messageBox.classList.add('hidden');
                        }, 3000);
                    }

                    const otherCheckbox = document.getElementById('otherCheckbox');
                    const otherInputContainer = document.getElementById('otherInputContainer');

                    if (otherCheckbox && otherInputContainer) {
                        otherCheckbox.addEventListener('change', function () {
                            otherInputContainer.classList.toggle('hidden', !this.checked);
                        });
                    }

                    // Edit Label
                    document.querySelectorAll('.edit-label-btn').forEach(function (editBtn) {
                        editBtn.addEventListener('click', function () {
                            const container = this.closest('[data-label-id]');
                            container.querySelector('.label-name').classList.add('hidden');
                            this.classList.add('hidden');
                            container.querySelector('.edit-label-input').classList.remove('hidden');
                            container.querySelector('.update-label-btn').classList.remove('hidden');
                            container.querySelector('.cancel-edit-btn').classList.remove('hidden');
                        });
                    });

                    // Cancel Edit
                    document.querySelectorAll('.cancel-edit-btn').forEach(function (cancelBtn) {
                        cancelBtn.addEventListener('click', function () {
                            const container = this.closest('[data-label-id]');
                            container.querySelector('.label-name').classList.remove('hidden');
                            container.querySelector('.edit-label-btn').classList.remove('hidden');
                            container.querySelector('.edit-label-input').classList.add('hidden');
                            container.querySelector('.update-label-btn').classList.add('hidden');
                            container.querySelector('.cancel-edit-btn').classList.add('hidden');
                        });
                    });

                    // Update Label via PATCH
                    document.querySelectorAll('.update-label-btn').forEach(function (updateBtn) {
                        updateBtn.addEventListener('click', function () {
                            const container = this.closest('[data-label-id]');
                            const labelId = container.getAttribute('data-label-id');
                            const input = container.querySelector('.edit-label-input');
                            const newName = input.value;
                            const labelSpan = container.querySelector('.label-name');

                            fetch(`/labels/${labelId}`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ name: newName })
                            })
                                .then(async response => {
                                    const data = await response.json();


                                    if (!response.ok) {
                                        showMessage(data.error || 'Validation failed', true);
                                        throw new Error(data.error || 'Validation failed');
                                    }

                                    labelSpan.textContent = data.name;
                                    input.value = data.name;

                                    labelSpan.classList.remove('hidden');
                                    container.querySelector('.edit-label-input').classList.add('hidden');
                                    container.querySelector('.update-label-btn').classList.add('hidden');
                                    container.querySelector('.cancel-edit-btn').classList.add('hidden');
                                    container.querySelector('.edit-label-btn').classList.remove('hidden');

                                    labelSpan.classList.add('bg-yellow-100');
                                    setTimeout(() => labelSpan.classList.remove('bg-yellow-100'), 1000);

                                    showMessage('Label updated successfully');
                                })
                                .catch(async (error) => {
                                    if (error instanceof Response && error.status === 422) {
                                        const data = await error.json();
                                        showMessage(data.error || 'Validation failed', true);
                                    } else {
                                        showMessage(error.message, true);
                                    }
                                });
                        });
                    });

                    // Modal Delete Confirmation
                    const actionModal = document.getElementById('actionModal');
                    const cancelActionBtn = document.getElementById('cancelActionBtn');
                    const actionForm = document.getElementById('actionForm');
                    const modalMessage = document.getElementById('modalMessage');
                    const modalTitle = document.getElementById('modalTitle');

                    document.querySelectorAll('.open-action-modal').forEach(btn => {
                        btn.addEventListener('click', function () {
                            const action = this.dataset.action;
                            const title = this.dataset.title || 'Confirm Action';
                            const message = this.dataset.message || 'Are you sure you want to proceed?';
                            const method = this.dataset.method || 'POST';

                            actionForm.setAttribute('action', action);
                            modalTitle.textContent = title;
                            modalMessage.textContent = message;

                            const existingMethod = actionForm.querySelector('input[name="_method"]');
                            if (existingMethod) {
                                existingMethod.remove();
                            }

                            if (method !== 'POST') {
                                const methodInput = document.createElement('input');
                                methodInput.type = 'hidden';
                                methodInput.name = '_method';
                                methodInput.value = method;
                                actionForm.appendChild(methodInput);
                            }

                            actionModal.classList.remove('hidden');
                        });
                    });

                    if (cancelActionBtn) {
                        cancelActionBtn.addEventListener('click', () => {
                            actionModal.classList.add('hidden');
                            actionForm.setAttribute('action', '');
                            modalTitle.textContent = '';
                            modalMessage.textContent = '';
                        });
                    }
                });
            </script>
        </form>
    </main>
    <style>
        #messageBox {
            position: fixed;
            top: 1rem;
            right: 1rem;
            background-color: #22c55e;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            z-index: 9999;
            transition: opacity 0.3s ease;
        }
        .hidden {
            display: none;
        }
    </style>
<x-modal />
@endsection
