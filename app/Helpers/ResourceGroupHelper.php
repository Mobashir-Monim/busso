<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Helpers\SSOHelpers\RGOnboarder as RGO;
use App\Models\ResourceGroup as RG;

class ResourceGroupHelper extends Helper
{
    public function create($request)
    {
        $rg = RG::create($this->stripRequestParameters($request));
        $onboarder = new RGO($rg);
        $onboarder->onboardGroup($request);

        return $rg;
    }

    public function stripRequestParameters($request)
    {
        return [
            'name' => $request->name,
            'description' => $request->description,
            'url' => $this->stripURL($request->url),
            'image' => $this->storeImage($request),
        ];
    }

    public function stripURL($url)
    {
        $protocol = startsWith($url, "https://") ? "https://" : "http://";
        $url = str_replace("http://", "", str_replace("https://", "", $url));
        return $protocol . explode("/", $url)[0];
    }

    public function storeImage($request, $disk = 'public', $existing = null)
    {
        if (!Storage::disk($disk)->exists("Resource Group Images")) Storage::disk($disk)->makeDirectory("Resource Group Images", 'public');
        if (!is_null($existing)) Storage::disk($disk)->delete($existing);
        return $request->file('image')->storeAs('Resource Group Images', Carbon::now()->timestamp . " - " . $request->name . "." . $request->file('image')->extension(), $disk);
    }
}