<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{
    public function index()
    {
        return Inertia::render('Tasks/Index', [
            'tasks_prop' => Task::query()
                ->latest()
                ->paginate(10)
        ]);
    }

    public function search(Request $request)
    {
        $tasks = Task::query()
            ->filter([
                'search'=>$request->input('search'),
                'status'=>$request->input('status')])
            ->latest()
            ->paginate(10);

        return response()->json([
            'tasks' => $tasks,
        ]);
    }
    public function update(Request $request,Task $task)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'nullable|unique:tasks,title,'.$task->id,
            'description' => 'nullable',
            'status' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return Redirect::back()
                ->with('error', $validator->errors());
        }
        $task->update($request->all());

        return Redirect::back()->with('success', 'Task updated.');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|unique:tasks',
            'description' => 'nullable',
        ]);
        if ($validator->fails()) {
            return Redirect::back()
                ->with('error', $validator->errors());
        }
        Task::create($request->all());

        return Redirect::back()->with('success', 'Task created.');
    }

    public function deleteTask(Task $task)
    {
        //get the auth user
        $user = auth()->user();

        if ($user->user_type == 0){
            $task->delete();
            return Redirect::back()->with('success', 'Task deleted.');
        }else{
            return Redirect::back()->with('error', 'You are not authorized to delete this task.');
        }
    }
}
