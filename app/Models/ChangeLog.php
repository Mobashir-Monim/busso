<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class ChangeLog extends Model
{
    use HasFactory;
    use Concerns\UsesUuid;

    protected $guarded = [];
    protected $casts = [
        'change_data' => 'array',
    ];

    public function user()
    {
        Relation::morphMap([
            'api_client' => 'App\Models\OauthClient',
            'user' => 'App\Models\User',
        ]);

        return $this->morphTo(__FUNCTION__, 'user_type', 'user_id');
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function getGroupCountAttribute()
    {
        return count(ChangeLog::where('group_id', $this->attributes['group_id'])->get());
    }
}
