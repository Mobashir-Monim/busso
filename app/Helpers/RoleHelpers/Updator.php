<?php

namespace App\Helpers\RoleHelpers;

use App\Helpers\Helper;
use App\Models\Role;
use App\Helpers\ChangeLogHelpers\Role\LogHelper;

class Updator extends Helper
{
    protected $role;
    protected $role_details;
    public $status;

    public function __construct($role, $display_name, $name, $description, $is_system_role = false)
    {
        $this->role = $role;
        $this->role_details = [
            'display_name' => $display_name,
            'name' => $name,
            'description' => $description,
            'is_system_role' => auth()->user()->hasSystemRole('super-admin') ? $is_system_role : false,
        ];

        $this->verifyRoleDetails();
    }

    public function verifyRoleDetails()
    {
        if (Role::where('name', $this->role_details['name'])->first() != null) {
            $this->status = [
                'success' => false,
                'message' => 'Role creation failed. Duplicate role system name.'
            ];
        } else {
            new LogHelper($role, 'update', $this->role_details);
            $this->updateRole();
        }
    }

    public function updateRole()
    {
        $this->role->display_name = $this->role_details['display_name'];
        $this->role->name = $this->role_details['name'];
        $this->role->description = $this->role_details['description'];
        $this->role->is_system_role = $this->role_details['is_system_role'];
        $this->role->save();

        $this->status = [
            'success' => true,
            'message' => 'Successfully updated role',
        ];
    }
}