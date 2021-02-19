<?php

namespace App\Helpers\UserHelpers\Password;

use App\Helpers\Helper;
use Carbon\Carbon;
use App\Mail\Password\ResetMail;
use Mail;

class Reset extends Helper
{
    public function resetPassword($pass)
    {
        $user = auth()->user();
        $user->password = bcrypt($pass);
        $this->passwordResetted($user);
        $user->save();
        Mail::to($user->email)->send(new ResetMail($user->name, $pass));
    }

    public function passwordResetted($user)
    {
        $this->updateLastChange($user);
        $this->noForceReset($user);
    }

    public function updateLastChange($user)
    {
        $user->pass_change_at = Carbon::now()->toDateTimeString();
    }

    public function noForceReset($user)
    {
        $user->force_reset = false;
    }
}