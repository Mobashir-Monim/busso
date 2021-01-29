<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    use HasFactory;
    use Concerns\UsesUuid;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function group()
    {
        return $this->belongsTo(ResourceGroup::class, 'resource_group_id');
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class, 'resource_id');
    }
}
