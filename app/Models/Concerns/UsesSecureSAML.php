<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;
use App\Models\SAMLEntity as SE;

trait UsesSecureSAML
{
    protected static function bootUsesSecureSAML()
    {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = self::setRandName('id');
                $model->folder = self::setRandName('folder');
                $model->key = self::setRandName('key');
                $model->cert = self::setRandName('cert');
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    protected static function setRandName($for)
    {
        $name = Str::random(rand(100, 250));

        while (!is_null(SE::where($for, $name)->first())) {
            $name = Str::random(rand(100, 250));
        }

        return $name;
    }
}