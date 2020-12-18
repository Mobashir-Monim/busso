<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

use App\Helpers\SSOHelpers\RGOnboarder as RGO;
use App\Models\ResourceGroup as RG;

class ResourceGroupHelper extends Helper
{
    public function create($request)
    {
        $rg = RG::create($this->stripRequestParameters($request));
        $onboarder = new RGO($rg);
        $onboarder->onboardGroup();
    }

    public function stripRequestParameters($request)
    {
        return [
            'name' => $request->name,
            'description' => $request->description,
            'url' => $this->stripURL($request->url),
        ];
    }

    public function stripURL($url)
    {
        $url = str_replace("http://", "", str_replace("https://", "", $url));
        return explode("/", $url)[0];
    }

    public function storeImage($request)
    {
        file_exists();
    }
}