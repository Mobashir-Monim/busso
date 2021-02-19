<?php

namespace App\Helpers\UserHelpers\SearchHelpers;

use App\Helpers\Helper;
use App\Models\Role;
use App\Models\User;
use \DB;

class RoleSearch extends Helper
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function searchUsers($phrase)
    {
        if ($this->type == 'application') {
            return $this->getUsersWithSystemRole($phrase);
        } else {
            return $this->getUsersWithApplicationRole($phrase);
        }
    }

    public function getUsersWithApplicationRole($phrase)
    {
        $roles = Role::where('is_system_role', true)->where('name', 'like', "%$phrase%")->get()->pluck('id')->toArray();
        $user_ids = DB::table('role_user')->whereIn('role_id', $roles)->get()->pluck('user_id')->toArray();
        return User::whereIn('id', $user_ids)->paginate(30);
    }

    public function getUsersWithSystemRole($phrase)
    {
        $roles = Role::where('is_system_role', false)->where('name', 'like', "%$phrase%")->get()->pluck('id')->toArray();
        $user_ids = DB::table('role_user')->whereIn('role_id', $roles)->get()->pluck('user_id')->toArray();
        return User::whereIn('id', $user_ids)->paginate(30);
    }
}

// <option value="email @bracu.ac.bd">@bracu.ac.bd Email</option>
// <option value="email @g.bracu.ac.bd">@g.bracu.ac.bd Email</option>
// <option value="email non-bracu">Non BracU Email</option>
// <option value="email specific">Specific Email Address</option>
// <option value="all">All Users</option>
// <option value="role application">Application Role</option>
// <option value="role system">System Role</option>