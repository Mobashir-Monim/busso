<?php

namespace App\Helpers\RoleHelpers;

use App\Helpers\Helper;
use App\Helpers\ChangeLogHelpers\Role\LogHelper;

class Deletor extends Helper
{
    protected $role;
    public $status;

    public function __construct($role)
    {
        $this->role = $role;

        if ($this->checkRoleType())
            $this->setStatusToTrue('Role successfully deleted');
    }

    public function checkRoleType()
    {
        if (!in_array($this->role->name, ['system-user', 'super-admin'])) {
            if (!$this->role->is_system_role || ($this->role->is_system_role && auth()->user()->hasSystemRole('super-admin')))
                return true;
        }

        $this->setStatusToFalse('You may not delete this role');

        return false;
    }

    public function setStatusToFalse($message)
    {
        $this->status = [
            'success' => false,
            'redirect' => back(),
            'message' => $message
        ];
    }

    public function setStatusToTrue($message)
    {
        $this->status = [
            'success' => true,
            'redirect' => redirect()->route('roles'),
            'message' => $message
        ];
    }

    public function execute()
    {
        if ($this->status['success']) {
            new LogHelper($this->role, 'delete');
            $this->detachUsers();
            $this->detachResourceGroups();
            $this->role->delete();

            flash($this->status['message'])->success();
        } else {
            flash($this->status['message'])->error();
        }
    }

    public function detachUsers()
    {
        foreach ($this->role->users as $user)
            $user->roles()->detach($this->role->id);
    }

    public function detachResourceGroups()
    {
        foreach ($this->role->resourceGroups as $group)
            $group->roles()->detach($this->role->id);
    }
}