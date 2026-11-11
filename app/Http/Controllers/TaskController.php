<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'deadline' => ['nullable', 'date', 'after_or_equal:today'],
            'estimated_minutes' => ['required', 'integer', 'min:1', 'max:1440'],
            'importance' => ['required', 'in:low,medium,high'],
        ]);

        $request->user()->tasks()->create($data);

        return redirect()->route('tasks.create')->with('success', 'Task added.');
    }
}
