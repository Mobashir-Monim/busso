<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    use Concerns\UsesUuid;
    
    protected $guarded = [];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function resourceGroups()
    {
        return $this->belongsToMany(ResourceGroup::class);
    }

    public function groupIsAttached($group)
    {
        return in_array($group, $this->resourceGroups->pluck('id')->toArray());
    }
}
