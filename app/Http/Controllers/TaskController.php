<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // T-17 — US3: list only the logged-in user's tasks
    public function index(Request $request)
    {
        $query = auth()->user()->tasks()->with('category');

        // T-24 — US8: filter by status
        $query->when($request->status,
            fn($q, $s) => $q->where('status', $s)
        );

        // T-25 — US9: filter by category
        $query->when($request->category_id,
            fn($q, $c) => $q->where('category_id', $c)
        );

        // T-29 bonus: swap ->get() for ->paginate(8) later
        $tasks = $query->get();

        // T-27 bonus: task counts per status
        $counts = auth()->user()->tasks()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $categories = Category::all();

        return view('tasks.index', compact('tasks', 'categories', 'counts'));
    }

    // T-18 — US4: show create form
    public function create()
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    // T-18 — US4: store new task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:to_do,in_progress,completed',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        auth()->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created!');
    }

    // T-19 — US5: show edit form
    public function edit(Task $task)
    {
        if ($task->user_id !== auth()->id()) abort(403);

        $categories = Category::all();
        return view('tasks.edit', compact('task', 'categories'));
    }

    // T-19 — US5: update task
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:to_do,in_progress,completed',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated!');
    }

    // T-20 — US6: delete task
    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) abort(403);

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted.');
    }

    // T-21 — US7: cycle status to_do → in_progress → completed
    public function updateStatus(Task $task)
    {
        if ($task->user_id !== auth()->id()) abort(403);

        $next = [
            'to_do'       => 'in_progress',
            'in_progress' => 'completed',
            'completed'   => 'to_do',
        ];

        $task->update(['status' => $next[$task->status]]);

        return redirect()->route('tasks.index')
            ->with('success', 'Status updated.');
    }

    // not used in this project but required by --resource
    public function show(Task $task) {}
}