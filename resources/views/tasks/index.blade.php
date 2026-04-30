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
        $columns = [
            ['key' => 'to_do', 'title' => 'To Do', 'lane' => 'bg-slate-100', 'pill' => 'bg-slate-200 text-slate-700'],
            ['key' => 'in_progress', 'title' => 'In Progress', 'lane' => 'bg-indigo-50', 'pill' => 'bg-indigo-200 text-indigo-700'],
            ['key' => 'completed', 'title' => 'Completed', 'lane' => 'bg-emerald-50', 'pill' => 'bg-emerald-200 text-emerald-700'],
        ];
    @endphp

    <div class="overflow-x-auto rounded-2xl bg-[#0079bf] p-3">
        <div class="grid auto-cols-[272px] grid-flow-col gap-3">
        @foreach ($columns as $column)
            <section class="flex max-h-[75vh] flex-col rounded-lg bg-[#ebecf0] p-2">
                <div class="mb-2 flex items-center justify-between px-1">
                    <span class="text-sm font-semibold text-slate-800">
                        {{ $column['title'] }}
                    </span>
                    <span class="rounded-full bg-white px-2 py-0.5 text-xs font-semibold text-slate-600">
                        {{ $counts[$column['key']] ?? 0 }}
                    </span>
                </div>

                <div class="flex flex-1 flex-col gap-2 overflow-y-auto">
                    @forelse ($tasks->where('status', $column['key']) as $task)
                        <article class="rounded-lg bg-white p-3 shadow-[0_1px_0_rgba(9,30,66,0.25)] transition hover:bg-slate-50">
                            <h3 class="line-clamp-1 text-sm font-semibold text-slate-800">{{ $task->title }}</h3>

                            <p class="mt-2 line-clamp-3 text-xs text-slate-600">{{ $task->description ?: 'No description' }}</p>

                            <div class="mt-3 flex flex-wrap gap-2">
                                <span class="{{ $column['pill'] }} rounded-full px-2.5 py-1 text-[11px] font-semibold">
                                    {{ str_replace('_', ' ', $task->status) }}
                                </span>
                                @if ($task->priority === 'high')
                                    <span class="rounded-full bg-gradient-to-r from-amber-400 to-orange-500 px-2.5 py-1 text-[11px] font-semibold text-white">High</span>
                                @elseif ($task->priority === 'medium')
                                    <span class="rounded-full bg-sky-100 px-2.5 py-1 text-[11px] font-semibold text-sky-700">Medium</span>
                                @else
                                    <span class="rounded-full bg-slate-200 px-2.5 py-1 text-[11px] font-semibold text-slate-700">Low</span>
                                @endif
                                @if ($task->category)
                                    <span class="rounded-full bg-violet-100 px-2.5 py-1 text-[11px] font-semibold text-violet-700">{{ $task->category->name }}</span>
                                @endif
                            </div>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <a href="{{ route('tasks.edit', $task) }}" class="rounded-full bg-gradient-to-r from-sky-500 to-cyan-400 px-3 py-1 text-xs font-medium text-white">Edit</a>
                                <form method="POST" action="{{ route('tasks.status', $task) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded-full bg-gradient-to-r from-violet-600 to-indigo-500 px-3 py-1 text-xs font-medium text-white">Move</button>
                                </form>
                                <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-full bg-gradient-to-r from-rose-500 to-pink-500 px-3 py-1 text-xs font-medium text-white">Delete</button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-lg bg-white/70 p-3 text-center text-xs text-slate-500">
                            No tickets in this column.
                        </div>
                    @endforelse
                </div>

                <a href="{{ route('tasks.create') }}" class="mt-2 block rounded-md px-2 py-1.5 text-xs font-medium text-slate-600 transition hover:bg-black/5">
                    + Add another card
                </a>
            </section>
        @endforeach
        </div>
    </div>
</x-app-layout>
