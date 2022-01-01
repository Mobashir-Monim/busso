<?php

namespace App\Helpers\ChangeLogHelpers;

use App\Helpers\Helper;
use App\Models\ChangeLog;
use Carbon\Carbon;
use Illuminate\Support\Str;

abstract class Logger extends Helper
{
    public $target;
    public $mode;
    public $updated;
    public $log;

    public function __construct($target, $mode, $type, $updated)
    {
        $this->target = $target;
        $this->mode = $mode;
        $this->updated = $updated;
        $this->initLog($type);
    }

    public function initLog($type)
    {
        $this->log = [
            'type' => $type,
            'mode' => $this->mode,
            'url' => request()->url(),
            'route_name' => str_replace('api.', '', request()->route()->getName()),
            'change_data' => [],
        ];

        $this->setLogUser();

        $this->log['group_id'] = $this->generateGroupID($type);
    }

    public function generateGroupID($type)
    {
        $log = ChangeLog::where('type', $type)->
            where('url', $this->log['url'])->
            where('route_name', $this->log['route_name'])->
            where('user_id', $this->log['user_id'])->
            where('created_at', '>=', Carbon::now()->subMinutes(15))->first();

        if (is_null($log)) {
            $group_id = Str::uuid();

            while (!is_null(ChangeLog::where('group_id', $group_id)->first()))
                $group_id = Str::uuid();

            return $group_id;
        } else {
            return $log->group_id;
        }
    }

    public function setLogUser()
    {
        if (!is_null(request()->api_client)) {
            $this->log['user_id'] = request()->api_client->id;
            $this->log['user_type'] = 'api_client';
        } else {
            $this->log['user_id'] = auth()->user()->id;
            $this->log['user_type'] = 'user';
        }
    }
    
    public function storeLog()
    {
        ChangeLog::create($this->log);
    }

    // function to log updats of target
    abstract public function logUpdate();
    
    // function to log creation of target
    abstract public function logCreate();

    // function to log deletion of target
    abstract public function logDelete();
}