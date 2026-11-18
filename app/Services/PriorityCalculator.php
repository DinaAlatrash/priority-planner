<?php

namespace App\Services;

use App\Models\Task;

class PriorityCalculator
{
    private const IMPORTANCE_POINTS = [
        'high' => 30,
        'medium' => 15,
        'low' => 5,
    ];

    private const QUICK_TASK_MINUTES = 15;
    private const QUICK_TASK_BONUS = 5;

    public function calculate(Task $task): array
    {
        if ($task->status === 'done') {
            return ['score' => 0, 'level' => 'done'];
        }

        $score = $this->deadlinePoints($task)
            + $this->importancePoints($task)
            + $this->quickTaskPoints($task);

        return [
            'score' => $score,
            'level' => $this->level($score),
        ];
    }

    private function deadlinePoints(Task $task): int
    {
        if ($task->deadline === null) {
            return 0;
        }

        $now = now();

        if ($task->deadline->isPast()) {
            return 50;
        }
        if ($task->deadline->lte($now->copy()->addDay()->endOfDay())) {
            return 40;
        }
        if ($task->deadline->lte($now->copy()->addDays(3)->endOfDay())) {
            return 30;
        }
        if ($task->deadline->lte($now->copy()->addDays(7)->endOfDay())) {
            return 18;
        }

        return 8;
    }

    private function importancePoints(Task $task): int
    {
        return self::IMPORTANCE_POINTS[$task->importance] ?? self::IMPORTANCE_POINTS['medium'];
    }

    private function quickTaskPoints(Task $task): int
    {
        return $task->estimated_minutes <= self::QUICK_TASK_MINUTES
            ? self::QUICK_TASK_BONUS
            : 0;
    }

    private function level(int $score): string
    {
        return match (true) {
            $score >= 60 => 'urgent',
            $score >= 40 => 'high',
            $score >= 20 => 'medium',
            default => 'low',
        };
    }
}