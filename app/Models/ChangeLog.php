<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(User::class);
    }

    public function getGroupCountAttribute()
    {
        return count(ChangeLog::where('group_id', $this->attributes['group_id'])->get());
    }
}
