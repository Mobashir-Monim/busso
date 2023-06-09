<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
    use Concerns\UsesUuid;

    protected $fillable = ['name', 'description', 'uri'];

    public function group()
    {
        return $this->belongsTo(ResourceGroup::class);
    }

    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class);
    }
}
