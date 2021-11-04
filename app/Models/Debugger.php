<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debugger extends Model
{
    use HasFactory;
    use Concerns\UsesUuid;

    protected $guarded = [];
    protected $casts = [
        'settings' => 'array',
    ];

    public function getContentAttribute()
    {
        return [
            'name' => $this->attributes['name'],
            'identifier' => $this->attributes['identifier'],
            'is_active' => $this->attributes['is_active'] ? true : false,
            'settings' => json_decode($this->attributes['settings'], true)
        ];
    }
}
