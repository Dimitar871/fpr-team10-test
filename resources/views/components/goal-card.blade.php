<div class="w-full min-h-[400px] shadow-sm flex flex-col bg-[var(--main-color)] border-2 relative rounded-md lg:max-w-[400px] mx-auto
    {{ $goal->achieved ? 'border-[var(--sub-color)]' : 'border-[var(--background-color)]' }}">
    <div class="w-full border-b border-[var(--background-color)] gap-2 flex-col flex p-4 min-h-[110px]">
        <div class="flex items-center gap-2 justify-start w-full">
            <p class="text-base font-semibold">{{ $goal->title }}</p>

        </div>
        <p class="text-[var(--text-color)] text-sm">{{ $goal->description }}</p>
    </div>

    <div class="absolute top-2 right-2 ring-1 p-1 rounded-md text-xs
        {{ $goal->goal_type == 'individual' ? 'bg-[var(--sub-color)]' : 'bg-[var(--accent-color)]' }} text-white">
        {{ $goal->goal_type }}
    </div>

    <div class="p-4 flex flex-col items-start gap-2 border-[var(--background-color)] border-b min-h-[250px]">
        <p class="text-[var(--text-color)] font-semibold text-xs">SMART CRITERIA</p>
        <p class="text-[var(--text-color)]"><span class="text-sm font-semibold">Specific: </span>{{ $goal->specific }}</p>
        <p class="text-[var(--text-color)]"><span class="text-sm font-semibold">Measureable: </span>{{ $goal->measureable }}</p>
        <p class="text-[var(--text-color)]"><span class="text-sm font-semibold">Achievable: </span>{{ $goal->achievable }}/10</p>
        <p class="text-[var(--text-color)]"><span class="text-sm font-semibold">Relevant tag: </span>{{ $goal->relevance }}</p>
    </div>

    <div class="w-full flex-1 p-4 border-b border-[#E5E7EB] ">
       <p class="text-gray-400 font-semibold text-sm mb-2">Tasks</p>

       <div class="flex flex-col gap-2">
           @foreach ($goal->tasks as $task)
           <div class="flex items-center gap-2">
            <x-heroicon-o-check-circle class="w-6 h-6
           {{ $task->completed ? 'text-[#3aa499]' : '' }}
            " />
                <p class="{{ $task->completed ? 'line-through text-gray-500' : '' }}">{{$task->title}}</p>
           </div>
           @endforeach
           @if (count($goal->tasks) === 0)
               <p>No associated tasks.</p>
           @endif
           <!-- {{ $goal->tasks->filter(fn($task) => $task->completed)->count() }} / {{count($goal->tasks)}} -->

        </div>
    </div>

    <div class="w-full flex items-center justify-between justify-self-end p-4">
        <div class="flex items-center gap-2">
            <x-heroicon-o-calendar class="w-4 h-4 text-[var(--text-color)]" />
            <p class="text-[var(--text-color)] text-sm">
                Finish by: {{ \Carbon\Carbon::parse($goal->time_based)->format('F j, Y') }}</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('goals.edit', ['goal' => $goal->id]) }}"
               class="text-[var(--edit-color)] font-semibold text-sm cursor-pointer gap-1 flex items-center hover:text-[var(--edit-color)] group duration-300">
                <x-heroicon-o-pencil-square class="w-4 h-4 text-[var(--edit-color)] group-hover:text-[var(--edit-color)] duration-300" />
                Edit
            </a>
            <button type="button"
                    class="font-semibold text-[var(--delete-color)] text-sm cursor-pointer flex items-center gap-1 group hover:text-[var(--delete-color)] duration-300 open-action-modal"
                    title="Delete"
                    data-action="{{ route('goals.destroy', $goal->id) }}"
                    data-name="goal '{{ $goal->title }}'"
                    data-title="Confirm Deletion"
                    data-message="Are you sure you want to delete goal '{{ $goal->title }}'?"
                    data-method="DELETE">

                <x-heroicon-o-trash class="w-4 h-4 text-[var(--delete-color)] group-hover:text-[var(--delete-color)] duration-300" />
                Delete
            </button>

        </div>
    </div>

    @if (!$goal->achieved)
        <form action="{{ route('goals.update', ['goal' => $goal->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="achieved" value="1">
            <div class="p-2">
                <button type="submit"
                        class="flex items-center gap-1 border-2 rounded-md w-full justify-center cursor-pointer py-2 border-[var(--create-color)] font-semibold text-[var(--create-color)] duration-300 ">
                    <x-heroicon-o-check-circle class="w-6 h-6" />
                    Mark As Completed
                </button>
            </div>
        </form>
    @else
        <button
            class="flex items-center gap-1 border-2 w-full justify-center cursor-pointer py-2 border-[var(--create-color)] text-[var(--text-color)] font-semibold bg-[var(--create-color)] duration-300 ">
            <x-heroicon-o-check-circle class="w-6 h-6" />
            Completed
        </button>
    @endif
</div>
