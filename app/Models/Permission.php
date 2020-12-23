<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Permission extends Model
{
    use HasFactory;
    use Concerns\UsesUuid;
    
    public function entity()
    {
        Relation::morphMap([
            'resource_group' => 'App\Models\ResourceGroup',
            'resource' => 'App\Models\Resource',
            'role' => 'App\Models\Role',
            'user_role' => 'App\Models\UserRole',
            'user_permission' => 'App\Models\UserPermission',
            'role_permission' => 'App\Models\RolePermission',
            'user' => 'App\Models\User',
            'user_attribute' => 'App\Models\UserAttribute',
            'user_value' => 'App\Models\UserAttributeValue',
        ]);

        return $this->morphTo(__FUNCTION__, 'entity_type', 'entity_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
