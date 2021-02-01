<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->resetLinkSent($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }

    public function resetLinkSent($request, $response)
    {
        flash('We have sent you a reset link. Please check your email inbox. Please also check your spam folder if you cannot find it in your inbox.')->success();

        return $this->sendResetLinkResponse($request, $response);
    }

    public function resetLinkFailed($request, $response)
    {
        flash('We could not send the reset link.')->error();
        
        return $this->sendResetLinkFailedResponse($request, $response);
    }
}
