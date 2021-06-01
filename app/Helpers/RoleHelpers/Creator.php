<?php

namespace App\Helpers\RoleHelpers;

use App\Helpers\Helper;
use App\Models\Role;

class Creator extends Helper
{
    protected $role;
    public $status;

    public function __construct($display_name, $name, $description, $is_system_role = false)
    {
        $this->role = [
            'display_name' => $display_name,
            'name' => $name,
            'description' => $description,
            'is_system_role' => auth()->user()->hasSystemRole('super-admin') ? $is_system_role : false,
        ];

        $this->verifyRoleDetails();
    }

    public function verifyRoleDetails()
    {
        if (Role::where('name', $this->role['name'])->first() != null) {
            $this->status = [
                'success' => false,
                'message' => 'Role creation failed. Duplicate role system name.'
            ];
        } else {
            $this->createRole();
        }
    }

    public function createRole()
    {
        $role = Role::create($this->role);

        $this->status = [
            'success' => true,
            'message' => 'Successfully created role',
            'role_id' => $role->id,
        ];
    }
}