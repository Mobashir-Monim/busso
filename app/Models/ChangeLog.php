<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    use HasFactory;
    use Concerns\UsesUuid;

    protected $casts = [
        'change_data' => 'array',
    ];
}
