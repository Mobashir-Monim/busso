<?php

namespace App\Helpers\UserHelpers;

use App\Helpers\Helper;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Role;
use App\Models\AccessLog;

class Stats extends Helper
{
    public function getQuickStats()
    {
        return [
            'users' => User::count(),
            'super-admins' => Role::where('name', 'super-admin')->get()->count(),
            'user-admins' => Role::where('name', 'user-admin')->count(),
            'resource-admins' => Role::where('name', 'resource-admin')->count(),
            'active-users' => User::where('is_active', true)->count(),
            'activity-month' => AccessLog::where('created_at', '>=', Carbon::now()->addMonths(-1))->count(),
            'activity-week' => AccessLog::where('created_at', '>=', Carbon::now()->addDays(-7))->count(),
            'activity-today' => AccessLog::where('created_at', '>=', Carbon::now()->addDays(-1))->count(),
        ];
    }
}