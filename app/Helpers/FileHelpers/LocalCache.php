<?php

namespace App\Helpers\FileHelpers;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Storage;

class LocalCache extends Helper
{
    public function __construct($storage_path, $local_path, $file)
    {
        if (!Storage::disk('local')->exists("$local_path/$file")) {
            $this->checkDirectories($local_path);

            Storage::disk('local')->put(
                "$local_path/$file",
                Storage::disk('s3')->get("$storage_path/$file")
            );
        }
    }

    public function checkDirectories($local_path)
    {
        $parts = explode("/", $local_path);
        $path = "";

        foreach ($parts as $part) {
            if ($part != 'app') {
                $path = $path != "" ? "$path/$part" : $part;
                if (!Storage::disk('local')->exists($path)) Storage::disk('local')->makeDirectory($path, 0700, true);
            }
        }
    }
}