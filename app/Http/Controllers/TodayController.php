<?php

namespace App\Http\Controllers;

use App\Services\DailyPlanner;
use Illuminate\Http\Request;

class TodayController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        $tasks = $user->tasks()
            ->get(['id', 'title', 'estimated_minutes', 'importance', 'status', 'deadline']);

        $plan = (new DailyPlanner())->plan($tasks, (float) $user->available_hours);

        return view('today', [
            'planned' => $plan['planned'],
            'skipped' => $plan['skipped'],
            'availableMinutes' => $plan['available_minutes'],
            'plannedMinutes' => $plan['planned_minutes'],
            'leftMinutes' => $plan['left_minutes'],
            'settingsUrl' => route('settings.show'),
        ]);
    }
}
