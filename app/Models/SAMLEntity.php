<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SAMLEntity extends Model
{
    use HasFactory;
    use Concerns\UsesSecureSAML;

    protected $guarded = ['id', 'folder', 'key', 'cert'];

    public function group()
    {
        return $this->belongsTo(ResourceGroup::class, 'resource_group_id');
    }

    public function getMetadataDocNameAttribute()
    {
        return hash('sha256', json_encode([$this->attributes['folder'], $this->attributes['key'], $this->attributes['cert']]));
    }
}
