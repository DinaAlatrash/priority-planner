<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function show(Request $request)
    {
        return view('settings', [
            'availableHours' => (float) $request->user()->available_hours,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'available_hours' => ['required', 'numeric', 'min:0.5', 'max:24'],
        ]);

        $request->user()->update([
            'available_hours' => round((float) $data['available_hours'], 1),
        ]);

        return response()->json([
            'available_hours' => (float) $request->user()->available_hours,
        ]);
    }
}