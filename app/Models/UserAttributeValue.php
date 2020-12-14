<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAttributeValue extends Model
{
    use HasFactory;
    use Concerns\UsesUuid;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userAttribute()
    {
        return $this->belongsTo(UserAttribute::class);
    }
}
