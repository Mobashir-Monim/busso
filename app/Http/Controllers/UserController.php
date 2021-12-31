<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\UserHelpers\Stats;
use App\Helpers\UserHelpers\Password\Reset as PasswordReset;
use App\Helpers\UserHelpers\Password\Override as PasswordOverride;
use App\Models\User;
use App\Models\AccessLog;
use App\Helpers\UserHelpers\Creator;
use App\Helpers\UserHelpers\Updator;
use App\Helpers\UserHelpers\Deletor;
use App\Helpers\UserHelpers\SearchHelpers\SearchHelper;
use App\Http\Requests\Password\ResetRequest;
use App\Http\Requests\Password\OverrideRequest;
use App\Helpers\UserHelpers\AccessClientHelper;

class UserController extends Controller
{
    public function index()
    {
        $helper = new Stats;
        new AccessClientHelper();

        return view('user.index', ['stats' => $helper->getQuickStats()]);
    }

    public function create(Request $request)
    {
        $helper = new Creator($request);
        $helper->create();
        
        return response()->json($helper->getStatus(), $helper->getCode());
    }

    public function showUser(User $user)
    {
        return view('user.dashboard.index', ['user' => $user]);
    }

    public function passwordReset()
    {
        return view('user.password.reset');
    }

    public function resetPassword(ResetRequest $request)
    {
        if (\Hash::check($request->password, auth()->user()->password)) {
            flash("Your new password cannot be the same as the last password")->error();

            return back();
        }

        (new PasswordReset)->resetPassword($request->password);

        return redirect()->route('home');
    }

    public function accessLog()
    {
        return view('user.access-log', [
            'logs' => AccessLog::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->paginate(20)
        ]);
    }

    public function search(Request $request)
    {
        $helper = new SearchHelper($request);

        return view('user.search', ['users' => $helper->searchUsers(), 'phrase' => $request->phrase, 'type' => $request->type]);
    }

    public function overridePassword(User $user, OverrideRequest $request)
    {
        new PasswordOverride($user, $request);

        return redirect()->back();
    }

    public function alterStatus(User $user, Request $request)
    {
        $helper = new Updator($user, ['is_active' => true]);
        $helper->update();

        flash('User account status successfully updated!')->success();

        return redirect()->back();
    }

    public function update(User $user, Request $request)
    {
        $helper = new Updator($user, ['name' => $request->name]);
        $helper->update();

        flash('User name successfully updated!')->success();

        return redirect()->back();
    }

    public function delete(User $user, Request $request)
    {
        $helper = new Deletor($user);
        $helper->execute();

        return $helper->status['redirect'];
    }
}
