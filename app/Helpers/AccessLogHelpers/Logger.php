<?php

namespace App\Helpers\AccessLogHelpers;

use App\Helpers\Helper;
use App\Models\AccessLog;

class Logger extends Helper
{
    public function __construct($user, $group, $resource, $type)
    {
        dd('here');
        $log = new AccessLog;
        $log->user_id = $user;
        $log->resource_group_id = $group;
        $log->resource_id = $resource;
        $log->type = $type;
        $log->save();
    }
}