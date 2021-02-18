<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ResourceGroup as RG;
use App\Models\OauthClient as OC;
use App\Models\SAMLEntity as SE;
use App\Helpers\ResourceGroupHelper as RGH;
use App\Helpers\SAMLEntityHelpers\Configurer;

class ResourceGroupController extends Controller
{
    public function index()
    {
        return view('resource-group.index', [
            'groups' => RG::select('id', 'name', 'image')->orderBy('created_at')->paginate(20)
        ]);
    }

    public function create(Request $request)
    {
        $group = (new RGH)->create($request);

        return redirect(route('resource-groups.show', ['group' => $group->id]));
    }

    public function show(RG $group)
    {
        return view('resource-group.show', ['group' => $group]);
    }

    public function oauthReset(RG $group, OC $oauth)
    {
        $oauth->secret = Str::random(rand(50, 60));
        $oauth->save();

        return redirect(route('resource-groups.show', ['group' => $group->id]));
    }

    public function redirectSet(RG $group, OC $oauth, Request $request)
    {
        $oauth->redirect = $request->redirect;
        $oauth->save();

        return redirect(route('resource-groups.show', ['group' => $group->id]));
    }

    public function samlConfig(RG $group, SE $saml, Request $request)
    {
        (new Configurer($saml))->updateConfig($request);

        return redirect(route('resource-groups.show', ['group' => $group->id]));
    }
}
