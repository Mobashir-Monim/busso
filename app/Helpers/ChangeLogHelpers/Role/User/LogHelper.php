<?php

namespace App\Helpers\ChangeLogHelpers\Role\User;

use App\Helpers\Helper;
use App\Helpers\ChangeLogHelpers\Logger;

class LogHelper extends Logger
{
    public function __construct($target, $mode, $updated = null)
    {
        $log_mode = $mode == 'create' ? 'attach' : 'detach';
        parent::__construct($target, $log_mode, 'RoleUser', $updated);
        
        if ($this->{"log" . ucfirst($mode)}())
            $this->storeLog();
    }

    public function logUpdate()
    {
        throw new Exception("Update not possible");
    }

    public function logCreate()
    {
        $this->log['change_data']['role'] = [
            'id' => $this->target['role']->id,
            'name' => $this->target['role']->name,
            'display_name' => $this->target['role']->display_name,
            'is_system_role' => $this->target['role']->is_system_role,
            'description' => $this->target['role']->description,
        ];

        $this->log['change_data']['user'] = [
            'id' => $this->target['user']->id,
            'name' => $this->target['user']->name,
            'email' => $this->target['user']->email
        ];

        return true;
    }

    public function logDelete()
    {
        $this->logCreate();

        return true;
    }
}