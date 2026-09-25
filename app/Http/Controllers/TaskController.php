<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('due_date', 'asc')->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:Pending,Completed',
            'due_date' => 'nullable|date',
        ]);

        Task::create([
            'task_name' => $request->task_name,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
        ]);

        $tasks = Task::orderBy('due_date', 'asc')->get();

        return view('tasks.index', [
            'tasks' => $tasks,
        ])->with('success', 'Task added successfully!');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'task_name' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:Pending,Completed',
            'due_date' => 'nullable|date',
        ]);

        $task->update([
            'task_name' => $request->task_name,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
        ]);

        $tasks = Task::orderBy('due_date', 'asc')->get();

        return view('tasks.index', [
            'tasks' => $tasks,
        ])->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        $tasks = Task::orderBy('due_date', 'asc')->get();

        return view('tasks.index', [
            'tasks' => $tasks,
        ])->with('success', 'Task deleted successfully!');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:Pending,Completed',
        ]);

        $task->update([
            'status' => $request->status,
        ]);

        $tasks = Task::orderBy('due_date', 'asc')->get();

        return view('tasks.index', [
            'tasks' => $tasks,
        ])->with('success', 'Task status updated!');
    }
}