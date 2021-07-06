<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ResourceGroup;
use App\Helpers\Helper;

class OauthClient extends Model
{
    use HasFactory;
    use Concerns\UsesUuid;

    public function entity()
    {
        Relation::morphMap([
            'resource_group' => 'App\Models\ResourceGroup',
            'user' => 'App\Models\User',
        ]);

        return $this->morphTo(__FUNCTION__, 'user_type', 'user_id');
    }

    public function getPemPassAttribute()
    {
        $helper = new Helper;
        return hash('sha512', $helper->base64url_encode($this->group->id));
    }

    public function getGroupAttribute()
    {
        if ($this->attributes['user_type'] == 'resource_group') {
            return ResourceGroup::find($this->attributes['user_id']);
        }

        return null;
    }
}
