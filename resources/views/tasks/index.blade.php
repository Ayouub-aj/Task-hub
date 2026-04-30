<x-app-layout>
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">My Tasks</h1>
            <p class="text-sm text-slate-500">Track progress across your board.</p>
        </div>
        <a href="{{ route('tasks.create') }}" class="rounded-full bg-gradient-to-r from-violet-600 to-indigo-500 px-5 py-2 text-sm font-medium text-white transition hover:opacity-95">
            New Task
        </a>
    </div>

    <div class="mb-6 rounded-xl bg-white p-4 shadow-sm">
        <form method="GET" action="{{ route('tasks.index') }}" class="grid gap-3 md:grid-cols-3">
            <select name="status" class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                <option value="">All Statuses</option>
                <option value="to_do" @selected(request('status') === 'to_do')>To Do</option>
                <option value="in_progress" @selected(request('status') === 'in_progress')>In Progress</option>
                <option value="completed" @selected(request('status') === 'completed')>Completed</option>
            </select>

            <select name="category_id" class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="rounded-full bg-gradient-to-r from-sky-500 to-cyan-400 px-4 py-2 text-sm font-medium text-white transition hover:opacity-95">
                Apply Filters
            </button>
        </form>
    </div>

    @php
        $toDoTasks = $tasks->where('status', 'to_do');
        $inProgressTasks = $tasks->where('status', 'in_progress');
        $completedTasks = $tasks->where('status', 'completed');
    @endphp

    <div class="grid gap-4 md:grid-cols-3">
        <section class="rounded-xl bg-slate-100 p-4">
            <div class="mb-3 inline-flex rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-700">
                To Do ({{ $counts['to_do'] ?? 0 }})
            </div>
            <div class="space-y-3">
                @forelse ($toDoTasks as $task)
                    <article class="rounded-xl bg-white p-4 shadow-sm transition hover:shadow-md">
                        <div class="mb-2 flex items-center justify-between">
                            <h3 class="font-medium text-slate-800">{{ $task->title }}</h3>
                            <span class="rounded-full bg-slate-200 px-2.5 py-0.5 text-xs font-semibold text-slate-700">to_do</span>
                        </div>
                        <p class="mb-3 text-sm text-slate-600">{{ $task->description ?: 'No description' }}</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('tasks.edit', $task) }}" class="rounded-full bg-gradient-to-r from-sky-500 to-cyan-400 px-3 py-1 text-xs font-medium text-white">Edit</a>
                            <form method="POST" action="{{ route('tasks.status', $task) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="rounded-full bg-gradient-to-r from-violet-600 to-indigo-500 px-3 py-1 text-xs font-medium text-white">Advance</button>
                            </form>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-full bg-gradient-to-r from-rose-500 to-pink-500 px-3 py-1 text-xs font-medium text-white">Delete</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <p class="text-sm text-slate-500">No tasks in this column.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-xl bg-indigo-50 p-4">
            <div class="mb-3 inline-flex rounded-full bg-indigo-200 px-3 py-1 text-xs font-semibold text-indigo-700">
                In Progress ({{ $counts['in_progress'] ?? 0 }})
            </div>
            <div class="space-y-3">
                @forelse ($inProgressTasks as $task)
                    <article class="rounded-xl bg-white p-4 shadow-sm transition hover:shadow-md">
                        <div class="mb-2 flex items-center justify-between">
                            <h3 class="font-medium text-slate-800">{{ $task->title }}</h3>
                            <span class="rounded-full bg-indigo-200 px-2.5 py-0.5 text-xs font-semibold text-indigo-700">in_progress</span>
                        </div>
                        <p class="mb-3 text-sm text-slate-600">{{ $task->description ?: 'No description' }}</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('tasks.edit', $task) }}" class="rounded-full bg-gradient-to-r from-sky-500 to-cyan-400 px-3 py-1 text-xs font-medium text-white">Edit</a>
                            <form method="POST" action="{{ route('tasks.status', $task) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="rounded-full bg-gradient-to-r from-violet-600 to-indigo-500 px-3 py-1 text-xs font-medium text-white">Advance</button>
                            </form>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-full bg-gradient-to-r from-rose-500 to-pink-500 px-3 py-1 text-xs font-medium text-white">Delete</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <p class="text-sm text-slate-500">No tasks in this column.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-xl bg-emerald-50 p-4">
            <div class="mb-3 inline-flex rounded-full bg-emerald-200 px-3 py-1 text-xs font-semibold text-emerald-700">
                Completed ({{ $counts['completed'] ?? 0 }})
            </div>
            <div class="space-y-3">
                @forelse ($completedTasks as $task)
                    <article class="rounded-xl bg-white p-4 shadow-sm transition hover:shadow-md">
                        <div class="mb-2 flex items-center justify-between">
                            <h3 class="font-medium text-slate-800">{{ $task->title }}</h3>
                            <span class="rounded-full bg-emerald-200 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">completed</span>
                        </div>
                        <p class="mb-3 text-sm text-slate-600">{{ $task->description ?: 'No description' }}</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('tasks.edit', $task) }}" class="rounded-full bg-gradient-to-r from-sky-500 to-cyan-400 px-3 py-1 text-xs font-medium text-white">Edit</a>
                            <form method="POST" action="{{ route('tasks.status', $task) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="rounded-full bg-gradient-to-r from-violet-600 to-indigo-500 px-3 py-1 text-xs font-medium text-white">Advance</button>
                            </form>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-full bg-gradient-to-r from-rose-500 to-pink-500 px-3 py-1 text-xs font-medium text-white">Delete</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <p class="text-sm text-slate-500">No tasks in this column.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
