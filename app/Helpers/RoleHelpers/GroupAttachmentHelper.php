<?php

namespace App\Helpers\RoleHelpers;

use App\Helpers\Helper;
use App\Models\ResourceGroup;
use App\Helpers\ChangeLogHelpers\Role\ResourceGroup\LogHelper;

class GroupAttachmentHelper extends Helper
{
    public $status;

    public function __construct($role, $group, $mode = 'attach')
    {
        if ($this->groupExists($group)) {
            if ($mode == 'attach') {
                $this->attachGroup($role, $group);
            } else {
                $this->detachGroup($role, $group);
            }
        }
    }

    public function groupExists($group)
    {
        if (is_null(ResourceGroup::find($group))) {
            $this->logError('No such group exists!! ( \' - \' )');
            
            return false;
        }

        return true;
    }

    public function attachGroup($role, $group)
    {
        if (!$role->groupIsAttached($group)) {
            $role->resourceGroups()->attach($group);
            new LogHelper(['role' => $role, 'resource_group' => ResourceGroup::find($group)], 'create');
            $this->logSuccess('Successfully attached group to role!');
        } else {
            $this->logError('Group is already attached to role ( \' ~ \' )');
        }
    }

    public function detachGroup($role, $group)
    {
        if ($role->groupIsAttached($group)) {
            $role->resourceGroups()->detach($group);
            new LogHelper(['role' => $role, 'resource_group' => ResourceGroup::find($group)], 'delete');
            $this->logSuccess('Successfully detached group from role!');
        } else {
            $this->logError('Group is already detached from role');
        }
    }

    public function logError($message)
    {
        $this->status = [
            'success' => false,
            'message' => $message
        ];
    }

    public function logSuccess($message)
    {
        $this->status = [
            'success' => true,
            'message' => $message
        ];
    }
}