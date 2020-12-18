<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
