<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChangeLog;

class ChangeLogController extends Controller
{
    public function index()
    {
        $logs = ChangeLog::select('type', 'mode', 'group_id', 'user_id')->groupBy('type', 'mode', 'group_id', 'user_id')->paginate(20);
        
        return view('change-log.index', [
            'logs' => $logs
        ]);
    }

    public function show(Request $request, $group)
    {
        $logs = ChangeLog::where('group_id', $group)->get();
        $view = strtolower("change-log.parts.{$logs[0]->type}.{$logs[0]->mode}");

        return view($view, [
            'logs' => $logs
        ]);
    }
}
