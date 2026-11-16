<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $this->ensureOwner($request, $task);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $subtask = $task->subtasks()->create($data);

        return response()->json($subtask, 201);
    }

    public function update(Request $request, Subtask $subtask)
    {
        $this->ensureOwner($request, $subtask->task);

        $data = $request->validate([
            'is_done' => ['required', 'boolean'],
        ]);

        $subtask->update($data);

        return response()->json($subtask);
    }

    public function destroy(Request $request, Subtask $subtask)
    {
        $this->ensureOwner($request, $subtask->task);

        $subtask->delete();

        return response()->json(['id' => $subtask->id]);
    }

    private function ensureOwner(Request $request, Task $task): void
    {
        abort_unless($task->user_id === $request->user()->id, 404);
    }
}
