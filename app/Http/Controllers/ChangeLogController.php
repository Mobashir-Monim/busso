<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChangeLog;

class ChangeLogController extends Controller
{
    public function index()
    {
        $logs = ChangeLog::select('type', 'mode', 'group_id', 'user_id')->orderBy('created_at', 'DESC')->groupBy('type', 'mode', 'group_id', 'user_id', 'created_at')->paginate(20);
        
        return view('change-log.index', [
            'logs' => $logs
        ]);
    }

    public function show(Request $request, $group)
    {
        $logs = ChangeLog::where('group_id', $group)->get();
        // $view = strtolower("change-log.parts.{$logs[0]->type}.{$logs[0]->mode}");

        return view('change-log.show', [
            'logs' => $logs,
            'part_view'
        ]);
    }

    public function revert(ChangeLog $log, Request $request)
    {
        dd('processing reversion');
    }
}
