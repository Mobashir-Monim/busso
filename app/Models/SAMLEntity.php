<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Helpers\Helper;

class SAMLEntity extends Model
{
    use HasFactory;
    use Concerns\UsesSecureSAML;

    protected $guarded = ['id', 'folder', 'key', 'cert'];

    public function group()
    {
        return $this->belongsTo(ResourceGroup::class, 'resource_group_id');
    }

    public function getMetadataDocNameAttribute()
    {
        return hash('sha256', json_encode([$this->attributes['folder'], $this->attributes['key'], $this->attributes['cert']]));
    }

    public function userAttributes()
    {
        return $this->belongsToMany(UserAttribute::class, 'saml_user_attribute', 'saml_entity_id', 'user_attribute_id');
    }

    public function getEntityIDAttribute()
    {
        return route('sso.saml.login', ['entity' => $this->attributes['id']]);
    }

    public function getSLOIdAttribute()
    {
        return route('sso.saml.logout', ['entity' => $this->attributes['id']]);
    }

    public function getPemPassAttribute()
    {
        $helper = new Helper;
        return hash('sha512', $helper->base64url_encode($this->group->oauth->secret));
    }
}
