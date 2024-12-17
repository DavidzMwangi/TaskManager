<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function createTask(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:tasks',
            'description' => 'optional',
        ]);

        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    public function getAllTasks(Request $request)
    {
        $query = Task::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('due_date')) {
            $query->whereDate('due_date', $request->due_date);
        }
        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $tasks = $query->paginate(10);
        return response()->json($tasks);
    }

    public function getTask($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    public function updateTask(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $request->validate([
            'title' => 'required|unique:tasks',
            'description' => 'optional',
        ]);

        $task->update($request->all());
        return response()->json($task);
    }

    public function deleteTask($id)
    {
        Task::findOrFail($id)->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }

}
