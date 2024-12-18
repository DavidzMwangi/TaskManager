<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function createTask(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|unique:tasks',
            'description' => 'nullable',
        ]);
        if ($validator->fails()) {
            return Redirect::back()
                ->with('error', $validator->errors());
        }

        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    public function getAllTasks(Request $request)
    {
        $tasks = Task::query()
            ->filter([
                'search'=>$request->input('search'),
                'status'=>$request->input('status')])
            ->latest()
            ->paginate(10);;

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
         $validator = Validator::make($request->all(),[
            'title' => 'nullable|unique:tasks,title,'.$task->id,
            'description' => 'nullable',
            'status' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error'=> $validator->errors()
                ], 400);
        }
        $task->update($request->all());

        return  response()->json(['message' => 'Task updated successfully']);
    }

    public function deleteTask($id)
    {
        Task::findOrFail($id)->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }

}
