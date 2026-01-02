<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        // Bonus: Search functionality
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Bonus: Filtering by status
        if ($request->filled('status') && $request->status !== 'All') {
            $query->where('status', $request->status);
        }

        $tasks = $query->latest()->get();

        // Bonus: Stats for the dashboard
        $stats = [
            'total' => Task::count(),
            'pending' => Task::where('status', 'Pending')->count(),
            'completed' => Task::where('status', 'Completed')->count(),
        ];

        return view('tasks.index', compact('tasks', 'stats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:Low,Medium,High',
        ]);

        Task::create($data);
        return back()->with('success', 'Task created successfully!');
    }

    public function update(Request $request, Task $task)
    {
        $task->update([
            'status' => $task->status === 'Pending' ? 'Completed' : 'Pending'
        ]);
        return back()->with('success', 'Task status updated!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return back()->with('success', 'Task deleted successfully!');
    }
}