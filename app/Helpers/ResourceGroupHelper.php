<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Helpers\SSOHelpers\RGOnboarder as RGOn;
use App\Helpers\SSOHelpers\RGOffboarder as RGOff;
use App\Models\ResourceGroup as RG;

class ResourceGroupHelper extends Helper
{
    public function create($request)
    {
        $rg = RG::create($this->stripRequestParameters($request));
        $onboarder = new RGOn($rg);
        $onboarder->onboardGroup($request);

        return $rg;
    }

    public function stripRequestParameters($request)
    {
        return [
            'name' => $request->name,
            'description' => substr($request->description, 0, 250),
            'url' => $this->stripURL($request->url),
            'image' => $request->hasFile('image') ? $this->storeImage($request) : null,
        ];
    }

    public function stripURL($url)
    {
        $protocol = startsWith($url, "https://") ? "https://" : "http://";
        $url = str_replace("http://", "", str_replace("https://", "", $url));
        return $protocol . explode("/", $url)[0];
    }

    public function storeImage($request, $existing = null)
    {
        if (!Storage::disk(config('app.storage'))->exists("Resource Group Images")) Storage::disk(config('app.storage'))->makeDirectory("Resource Group Images", 'public');
        if (!is_null($existing)) Storage::disk(config('app.storage'))->delete($existing);
        return $request->file('image')->storePubliclyAs('Resource Group Images', Carbon::now()->timestamp . " - " . $request->name . "." . $request->file('image')->extension(), config('app.storage'));
    }

    public function offBoard($group)
    {
        $offboarder = new RGOff($group);
        $offboarder->offboard();

        return $offboarder->status;
    }
}