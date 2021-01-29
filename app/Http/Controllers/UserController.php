<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\UserHelpers\Stats;
use App\Helpers\UserHelpers\PasswordReset;
use App\Models\User;
use App\Models\AccessLog;
use App\Helpers\UserHelpers\Creator;
use App\Http\Requests\PasswordResetRequest;

class UserController extends Controller
{
    public function index()
    {
        $helper = new Stats;
        return view('user.index', ['stats' => $helper->getQuickStats()]);
    }

    public function create(Request $request)
    {
        $helper = new Creator($request);
        
        return $helper->create();
    }

    public function showUser(User $user)
    {
        return view('home', ['user' => $user]);
    }

    public function passwordReset()
    {
        return view('user.password.reset');
    }

    public function resetPassword(PasswordResetRequest $request)
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
}
