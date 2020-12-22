<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAttribute extends Model
{
    use HasFactory;
    use Concerns\UsesUuid;

    public function uav()
    {
        return $this->hasMany(UserAttributeValue::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, UserAttributeValue::class);
    }

    public function usedBy()
    {
        return $this->belongsToMany(SAMLEntity::class, 'saml_user_attribute', 'user_attribute_id', 'saml_entity_id');
    }
}
