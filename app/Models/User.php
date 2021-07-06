<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Concerns\UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function uav()
    {
        return $this->hasMany(UserAttributeValue::class);
    }

    public function oauth()
    {
        return $this->morphOne(OauthCliet::class, 'user');
    }

    public function availableAttributes()
    {
        return $this->hasManyThrough(UserAttribute::class, UserAttributeValue::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasRole($name)
    {
        foreach ($this->roles as $role) {
            if ($role->name == $name) return true;
        }

        return false;
    }

    public function hasSystemRole($name)
    {
        foreach ($this->roles->where('is_system_role', true) as $role) {
            if ($role->name == $name) return true;
        }

        return false;
    }

    public function hasAppRole($name)
    {
        foreach ($this->roles->where('is_system_role', false) as $role) {
            if ($role->name == $name) return true;
        }

        return false;
    }

    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class);
    }

    public function hasAccess($entity, $type = 'resource_group')
    {
        if ($this->hasRoleBasedAccess($entity, $type)) return true;

        return $this->hasPermissionBasedAccess($entity, $type);
    }

    public function hasRoleBasedAccess($entity, $type = 'resource_group')
    {
        $user_roles = $this->roles->pluck('id')->toArray();

        if ($type == 'resource') {
            if ($this->hasAccess($entity->group)) return true;
            
            return $this->hasPermissionBasedAccess($entity, $type);
        } else {
            $entity_roles = $entity->roles->pluck('id')->toArray();
            
            return sizeof(array_intersect($user_roles, $entity_roles)) > 0;
        }
    }

    public function hasPermissionBasedAccess($entity, $type = 'resource_group')
    {
        return in_array(
            $entity->id,
            $this->permissions
                ->where('entity_type', $type)
                ->pluck('entity_id')
                ->toArray()
        );
    }
}
