<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\PriorityCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = $this->withPriority(
            $request->user()->tasks()
                ->get(['id', 'title', 'estimated_minutes', 'importance', 'status', 'deadline'])
        );

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

        $task->load(['subtasks' => fn ($query) => $query->orderBy('id')]);
        $this->applyPriority($task);

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

    public function board(Request $request)
    {
        $tasks = $this->withPriority(
            $request->user()->tasks()
                ->get(['id', 'title', 'estimated_minutes', 'importance', 'status', 'deadline'])
        );

        return view('tasks.board', ['tasks' => $tasks]);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $this->ensureOwner($request, $task);

        $data = $request->validate([
            'status' => ['required', 'in:todo,doing,done'],
        ]);

        $task->update([
            'status' => $data['status'],
            'completed_at' => $data['status'] === 'done' ? now() : null,
        ]);

        $this->applyPriority($task);

        return response()->json([
            'id' => $task->id,
            'status' => $task->status,
            'priority_score' => $task->priority_score,
            'priority_level' => $task->priority_level,
            'priority_reason' => $task->priority_reason,
        ]);
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

    private function applyPriority(Task $task): Task
    {
        $priority = (new PriorityCalculator())->calculate($task);

        $task->setAttribute('priority_score', $priority['score']);
        $task->setAttribute('priority_level', $priority['level']);
        $task->setAttribute('priority_reason', $priority['reason']);

        return $task;
    }

    private function withPriority(Collection $tasks): Collection
    {
        return $tasks
            ->map(fn (Task $task) => $this->applyPriority($task))
            ->sort(function (Task $a, Task $b) {
                return [
                    $a->priority_level === 'done' ? 1 : 0,
                    -$a->priority_score,
                    $a->deadline?->timestamp ?? PHP_INT_MAX,
                    $a->id,
                ] <=> [
                    $b->priority_level === 'done' ? 1 : 0,
                    -$b->priority_score,
                    $b->deadline?->timestamp ?? PHP_INT_MAX,
                    $b->id,
                ];
            })
            ->values();
    }
}