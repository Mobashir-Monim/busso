<?php

namespace App\Helpers\RoleHelpers;

use App\Helpers\Helper;
use App\Models\Role;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Viewer extends Helper
{
    protected $role;
    public $data;

    public function __construct($role, $view = 'show')
    {
        $this->role = $role;
        $this->constructRoleDetails();
        
        if ($view == 'users')
            $this->constructRoleUsers();
    }

    public function constructRoleDetails()
    {
        $this->data['details'] = [
            'id' => $this->role->id,
            'display_name' => $this->role->display_name,
            'name' => $this->role->name,
            'is_system_role' => $this->role->is_system_role,
            'description' => $this->role->description,
            'users' => count($this->role->users),
            'resource_groups' => count($this->role->resourceGroups)
        ];
    }

    public function constructRoleUsers()
    {
        $page = Paginator::resolveCurrentPage() ?: 1;
        $users = $this->role->users instanceof Collection ? $this->role->users : Collection::make($this->role->users);
        $this->data['users'] = new LengthAwarePaginator($users->forPage($page, 100), $users->count(), 100, $page);
    }
}