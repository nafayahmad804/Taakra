<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Competition;

class CompetitionController extends Controller
{
    public function calendar()
    {
        $competitions = Competition::where('status', 'published')->get();

        $events = $competitions->map(function ($competition) {
            return [
                'title' => $competition->title,
                'start' => $competition->start_date->format('Y-m-d'),
                'end' => $competition->end_date->format('Y-m-d'),
                'url' => route('competitions.show', $competition->slug),
                'backgroundColor' => '#4A90E2',
                'borderColor' => '#357ABD'
            ];
        });

        return response()->json($events);
    }
}
