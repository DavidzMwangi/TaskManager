<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;

class TaskController extends Controller
{
    public function index()
    {
         return Inertia::render('Tasks/Index', [
             'filters' => Request::all('search', 'trashed'),
             'tasks'=>Task::query()
                ->paginate(10)
    ]);
   }
}
