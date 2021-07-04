<?php

namespace App\Models\Passport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\Client as PassportClient;
use App\Models\ResourceGroup;
use App\Helpers\Helper;

class Client extends PassportClient
{
    use \App\Models\Concerns\UsesUuid;

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