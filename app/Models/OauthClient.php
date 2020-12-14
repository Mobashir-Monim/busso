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
        return $this->morphTo(__FUNCTION__, 'user_type', 'user_id');
    }
}
