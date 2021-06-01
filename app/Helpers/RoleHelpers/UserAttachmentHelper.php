<?php

namespace App\Helpers\RoleHelpers;

use App\Helpers\Helper;
use App\Models\Role;
use App\Models\User;
use \DB;

class UserAttachmentHelper extends Helper
{
    public $status;
    protected $role_priviledge;
    protected $privilege_list = [
        'super-admin' => ['super-admin', 'admin', 'user-admin', 'resource-admin', 'system-user'],
        'admin' => ['user-admin', 'resource-admin', 'system-user'],
        'user-admin' => ['resource-admin', 'system-user'],
    ];

    public function __construct(Role $role, $email, $mode = 'attach')
    {
        $user = User::where('email', $email)->first();

        if (!is_null($user)) {
            if ($this->verifyAttachmentPrivilege($role)) {
                if ($mode == 'attach') {
                    $this->attachUser($role, $user);
                } else {
                    $this->detachUser($role, $user);
                }
    
                $this->setStatusToTrue($mode, $email);
            }
        } else {
            $this->setStatusToFalse("User $email not found, please add the user first");
        }
    }

    public function verifyAttachmentPrivilege($role)
    {
        if ($this->verifyRolePrivilege())
            return $this->verifyRoleAccess($role);

        $this->setStatusToFalse();

        return false;
    }

    public function verifyRolePrivilege()
    {
        $this->role_priviledge = [
            'super-admin' => auth()->user()->hasSystemRole('super-admin'),
            'admin' => auth()->user()->hasSystemRole('admin'),
            'user-admin' => auth()->user()->hasSystemRole('user-admin')
        ];

        return in_array(true, $this->role_priviledge);
    }

    public function verifyRoleAccess($role)
    {
        if ($role->is_system_role) {
            if (in_array($role->name, $this->privilege_list[array_search(true, $this->role_priviledge)])) {
                return true;
            }

            $this->setStatusToFalse();

            return false;
        }

        return in_array(true, $role_priviledge);
    }

    public function attachUser($role, $user)
    {
        $role->users()->attach($user->id);
    }

    public function detachUser($role, $user)
    {
        $role->users()->detach($user->id);
    }

    public function setStatusToFalse($message = 'You do not have required permission to attach/detach users to/from roles')
    {
        $this->status = [
            'success' => false,
            'message' => $message
        ];
    }

    public function setStatusToTrue($mode, $email)
    {
        $message = "Successfully detached user $email from role";

        if ($mode == 'attach') {
            $message = "Successfully attached user $email to role";
        }

        $this->status = [
            'success' => true,
            'message' => $message
        ];
    }
}