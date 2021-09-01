<?php

namespace App\Helpers\ChangeLogHelpers\Role;

use App\Helpers\Helper;
use App\Helpers\ChangeLogHelpers\Logger;

class LogHelper extends Logger
{
    public function __construct($target, $mode, $updated = null)
    {
        parent::__construct($target, $mode, 'Role', $updated);
        
        if ($this->{"log" . ucfirst($mode)}())
            $this->storeLog();
    }

    public function logUpdate()
    {
        $this->log['change_data']['role'] = ["id" => $this->target->id];
        $this->log['change_data']['role']['previous'] = [];
        $this->log['change_data']['role']['updated'] = [];
        
        foreach (['display_name', 'name', 'description', 'is_system_role'] as $attribute) {
            if ($this->target->$attribute != $this->updated[$attribute])
                $this->log['change_data']['role']['previous'][$attribute] = $this->target->$attribute;

            $this->log['change_data']['role']['updated'][$attribute] = $this->updated[$attribute];
        }

        return sizeof($this->log['change_data']['role']['previous']) != 0;
    }

    public function logCreate()
    {
        $this->log['change_data']['role'] = [
            'id' => $this->target->id,
            'name' => $this->target->name,
            'display_name' => $this->target->display_name,
            'is_system_role' => $this->target->is_system_role,
            'description' => $this->target->description,
            'created_at' => $this->target->created_at,
            'updated_at' => $this->target->updated_at,
        ];

        return true;
    }

    public function logDelete()
    {
        $this->logCreate();
        $this->log['change_data']['users'] = [];
        $this->log['change_data']['resource_groups'] = [];

        foreach ($this->target->users as $user)
            $this->log['change_data']['users'][] = $user->id;

        foreach ($this->target->resourceGroups as $groups)
            $this->log['change_data']['resource_groups'][] = $groups->id;

        return true;
    }
}