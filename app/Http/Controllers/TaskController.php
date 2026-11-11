<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = $request->user()->tasks()
            ->orderByRaw('deadline is null')
            ->orderBy('deadline')
            ->get(['id', 'title', 'estimated_minutes', 'importance', 'status', 'deadline']);

        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);

        $request->user()->tasks()->create($data);

        return redirect()->route('tasks.create')->with('success', 'Task added.');
    }

    public function show(Request $request, Task $task)
    {
        $this->ensureOwner($request, $task);

        return view('tasks.show', ['task' => $task]);
    }

    public function edit(Request $request, Task $task)
    {
        $this->ensureOwner($request, $task);

        return view('tasks.edit', ['task' => $task]);
    }

    public function update(Request $request, Task $task)
    {
        $this->ensureOwner($request, $task);

        $task->update($this->validated($request, false));

        return redirect()->route('tasks.show', $task);
    }

    public function destroy(Request $request, Task $task)
    {
        $this->ensureOwner($request, $task);

        $task->delete();

        return redirect()->route('tasks.index');
    }

    private function validated(Request $request, bool $creating): array
    {
        $deadlineRules = ['nullable', 'date'];

        if ($creating) {
            $deadlineRules[] = 'after_or_equal:today';
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'deadline' => $deadlineRules,
            'estimated_minutes' => ['required', 'integer', 'min:1', 'max:1440'],
            'importance' => ['required', 'in:low,medium,high'],
        ]);
    }

    private function ensureOwner(Request $request, Task $task): void
    {
        abort_unless($task->user_id === $request->user()->id, 404);
    }
}