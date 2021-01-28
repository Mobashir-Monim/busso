<?php

namespace App\Helpers\UserHelpers;

use App\Helpers\Helper;
use Carbon\Carbon;

class PasswordReset extends Helper
{
    public function resetPassword($pass)
    {
        $user = auth()->user();
        $user->password = bcrypt($pass);
        $this->passwordResetted($user);
        $user->save();
    }

    public function passwordResetted($user)
    {
        $this->updateLastChange($user);
        $this->noForceReset($user);
    }

    public function updateLastChange($user)
    {
        $user->pass_change_at = Carbon::now()->toDateTimeString();
        $user->save();   
    }

    public function noForceReset($user)
    {
        $user->force_reset = false;
        $user->save();
    }
}