<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    use HasFactory;
    use Concerns\UsesUuid;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(ResourceGroup::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
