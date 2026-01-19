<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(): View
    {
        $query = ActivityLog::query()->latest();

        if (request('action')) {
            $query->where('action', request('action'));
        }

        if (request('subject_type')) {
            $query->where('subject_type', request('subject_type'));
        }

        $logs = $query->paginate(20)->withQueryString();

        return view('activity-logs.index', compact('logs'));
    }
}
