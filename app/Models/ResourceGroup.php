<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceGroup extends Model
{
    use HasFactory;
    use Concerns\UsesUuid;

    protected $fillable = ['name', 'description', 'url', 'image'];

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function saml()
    {
        return $this->hasOne(SAMLEntity::class);
    }

    public function oauth()
    {
        return $this->morphOne(OauthClient::class, 'oauth_clients', 'user_type', 'user_id');
    }
}
