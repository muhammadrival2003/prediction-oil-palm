<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = ActivityLog::with(['user', 'blok'])
            ->latest()
            ->paginate(20);
            
        return view('activities.index', compact('activities'));
    }

    public function getActivities()
    {
        $activities = ActivityLog::with('blok')
            ->where('user_id', auth()->id())
            ->latest()
            // ->limit(5)
            ->get();
            
        return response()->json($activities);
    }
}