<?php

namespace App\Helpers\UserHelpers\Password;

use App\Helpers\Helper;
use Carbon\Carbon;
use App\Mail\Password\OverrideMail;
use Mail;
use App\Helpers\ChangeLogHelpers\User\LogHelper;

class Override extends Helper
{
    public function __construct($user, $request)
    {
        if ($this->verifySuperAdmin($request->super_admin_password)) {
            $this->updateUserPassword($user, $request->new_password);
            flash('Successfully Password Overriden')->success();
        }
    }

    public function verifySuperAdmin($pass)
    {
        if (!\Hash::check($pass, auth()->user()->password)) {
            flash("Super Admin password does not match")->error();

            return false;
        }

        return true;
    }

    public function updateUserPassword($user, $pass)
    {
        new LogHelper($user, 'update', ['password' => bcrypt($pass)]);
        $user->password = bcrypt($pass);
        $user->save();
        $this->updateLastChange($user);
        $this->forceReset($user);
        $this->mailUserWithPassword($user, $pass);
    }

    public function updateLastChange($user)
    {
        $user->pass_change_at = Carbon::now()->toDateTimeString();
        $user->save();
    }

    public function forceReset($user)
    {
        $user->force_reset = true;
        $user->save();
    }

    public function mailUserWithPassword($user, $pass)
    {
        // Mail::to($user->email)->send(new OverrideMail($user->name, $user->email, $pass));
    }
}