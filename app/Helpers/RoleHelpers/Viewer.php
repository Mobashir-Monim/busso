<?php

namespace App\Helpers\RoleHelpers;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Storage;
use App\Models\Role;
use App\Models\ResourceGroup;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Viewer extends Helper
{
    protected $role;
    public $data = [];

    public function __construct($role, $view = 'show')
    {
        $this->role = $role;
        $this->constructRoleDetails();
        
        if ($view == 'users') {
            $this->constructRoleUsers();
        } elseif ($view == 'groups') {
            $this->data['groups'] = [];
            $this->constructRoleGroups();
        }

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

    public function constructRoleGroups()
    {
        $attached = $this->role->resourceGroups;
        $detached = ResourceGroup::whereNotIn('id', $attached->plucK('id')->toArray())->get();

        $this->data['groups'] = [
            'attached' => $this->formatResourceGroups($attached),
            'detached' => $this->formatResourceGroups($detached)
        ];
    }

    public function formatResourceGroups($groups)
    {
        $formatted = [];

        foreach ($groups as $group) {
            $formatted[] = [
                'id' => $group->id,
                'name' => $group->name,
                'description' => $group->description,
                'image' => !is_null($group->image) ? Storage::disk(config('app.storage'))->url($group->image) : "/img/rg-placeholder.png",
            ];
        }

        return $formatted;
    }
}