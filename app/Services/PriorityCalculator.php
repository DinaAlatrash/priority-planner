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

    private const IMPORTANCE_LABELS = [
        'high' => 'High importance',
        'medium' => 'Medium importance',
        'low' => 'Low importance',
    ];

    private const QUICK_TASK_MINUTES = 15;
    private const QUICK_TASK_BONUS = 5;

    public function calculate(Task $task): array
    {
        if ($task->status === 'done') {
            return ['score' => 0, 'level' => 'done', 'reason' => 'Completed'];
        }

        $factors = [
            $this->deadlineFactor($task),
            $this->importanceFactor($task),
            $this->quickTaskFactor($task),
        ];

        $score = array_sum(array_column($factors, 'points'));

        return [
            'score' => $score,
            'level' => $this->level($score),
            'reason' => $this->reason($factors),
        ];
    }

    private function deadlineFactor(Task $task): array
    {
        if ($task->deadline === null) {
            return ['points' => 0, 'label' => null];
        }

        $now = now();

        if ($task->deadline->isPast()) {
            return ['points' => 50, 'label' => 'Overdue'];
        }
        if ($task->deadline->isToday()) {
            return ['points' => 40, 'label' => 'Due today'];
        }
        if ($task->deadline->lte($now->copy()->addDay()->endOfDay())) {
            return ['points' => 40, 'label' => 'Due tomorrow'];
        }
        if ($task->deadline->lte($now->copy()->addDays(3)->endOfDay())) {
            return ['points' => 30, 'label' => 'Due within 3 days'];
        }
        if ($task->deadline->lte($now->copy()->addDays(7)->endOfDay())) {
            return ['points' => 18, 'label' => 'Due this week'];
        }

        return ['points' => 8, 'label' => null];
    }

    private function importanceFactor(Task $task): array
    {
        $importance = array_key_exists($task->importance, self::IMPORTANCE_POINTS)
            ? $task->importance
            : 'medium';

        return [
            'points' => self::IMPORTANCE_POINTS[$importance],
            'label' => self::IMPORTANCE_LABELS[$importance],
        ];
    }

    private function quickTaskFactor(Task $task): array
    {
        if ($task->estimated_minutes <= self::QUICK_TASK_MINUTES) {
            return ['points' => self::QUICK_TASK_BONUS, 'label' => 'Quick task'];
        }

        return ['points' => 0, 'label' => null];
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

    private function reason(array $factors): string
    {
        $labelled = array_filter($factors, fn ($factor) => $factor['label'] !== null);

        usort($labelled, fn ($a, $b) => $b['points'] <=> $a['points']);

        $labels = array_map(fn ($factor) => $factor['label'], array_slice($labelled, 0, 2));

        return implode(' · ', $labels);
    }
}