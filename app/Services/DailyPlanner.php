<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Collection;

class DailyPlanner
{
    private PriorityCalculator $calculator;

    public function __construct()
    {
        $this->calculator = new PriorityCalculator();
    }

    public function plan(Collection $tasks, float $availableHours): array
    {
        $availableMinutes = (int) round($availableHours * 60);

        $open = $tasks
            ->filter(fn (Task $task) => $task->status !== 'done')
            ->map(fn (Task $task) => $this->withPriority($task))
            ->sort(function (Task $a, Task $b) {
                return [
                    -$a->priority_score,
                    $a->deadline?->timestamp ?? PHP_INT_MAX,
                    $a->id,
                ] <=> [
                    -$b->priority_score,
                    $b->deadline?->timestamp ?? PHP_INT_MAX,
                    $b->id,
                ];
            })
            ->values();

        $planned = collect();
        $skipped = collect();
        $used = 0;

        foreach ($open as $task) {
            if ($used + $task->estimated_minutes <= $availableMinutes) {
                $planned->push($task);
                $used += $task->estimated_minutes;
            } else {
                $skipped->push($task);
            }
        }

        return [
            'planned' => $planned,
            'skipped' => $skipped,
            'available_minutes' => $availableMinutes,
            'planned_minutes' => $used,
            'left_minutes' => $availableMinutes - $used,
        ];
    }

    private function withPriority(Task $task): Task
    {
        $priority = $this->calculator->calculate($task);

        $task->setAttribute('priority_score', $priority['score']);
        $task->setAttribute('priority_level', $priority['level']);
        $task->setAttribute('priority_reason', $priority['reason']);

        return $task;
    }
}