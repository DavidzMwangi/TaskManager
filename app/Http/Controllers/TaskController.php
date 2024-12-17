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
//            'filters' => Request::all('search', 'trashed'),
            'tasks' => Task::query()
                ->paginate(10)
        ]);
    }

    public function update(Request $request,Task $task)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'nullable|unique:tasks',
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
}
