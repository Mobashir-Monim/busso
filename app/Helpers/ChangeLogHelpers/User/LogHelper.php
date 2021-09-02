<?php

namespace App\Helpers\ChangeLogHelpers\User;

use App\Helpers\Helper;
use App\Helpers\ChangeLogHelpers\Logger;
use Carbon\Carbon;

class LogHelper extends Logger
{
    public function __construct($target, $mode, $updated = null)
    {
        parent::__construct($target, $mode, 'User', $updated);
        
        if ($this->{"log" . ucfirst($mode)}())
            $this->storeLog();
    }

    public function logUpdate()
    {
        $this->log['change_data']['user'] = [];
        $this->log['change_data']['user']['previous'] = [];
        $this->log['change_data']['user']['updated'] = [];

        foreach (['name', 'password', 'is_active', 'email'] as $attribute) {
            if (array_key_exists($attribute, $this->updated)) {
                if ($this->target->$attribute != $this->updated[$attribute])
                    $this->log['change_data']['user']['previous'][$attribute] = $this->target->$attribute;
                
                $this->log['change_data']['user']['updated'][$attribute] = $this->updated[$attribute];
            } else {
                $this->log['change_data']['user']['updated'][$attribute] = $this->target->$attribute;
            }
        }
        
        return sizeof($this->log['change_data']['user']['previous']) != 0;
    }

    public function logCreate()
    {
        $this->log['change_data']['user'] = [
            'id' => $this->target->id,
            'name' => $this->target->name,
            'email' => $this->target->email,
            'password' => $this->target->password,
            'is_active' => $this->target->is_active,
            'created_at' => $this->target->created_at,
            'updated_at' => $this->target->updated_at,
            'force_reset' => $this->target->force_reset,
            'pass_change_at' => $this->target->pass_change_at,
        ];

        return true;
    }

    public function logDelete()
    {
        $this->logCreate();
        $this->log['change_data']['roles'] = [];
        $this->log['change_data']['access_logs'] = [];

        foreach ($this->target->roles as $role)
            $this->log['change_data']['roles'][] = $role->id;

        foreach ($this->target->accessLogs->where('created_at', Carbon::now()->subDays(7)) as $accessLog)
            $this->log['change_data']['access_logs'][] = $accessLog->toArray();

        return true;
    }
}