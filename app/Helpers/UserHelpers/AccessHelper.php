<?php

namespace App\Helpers\UserHelpers;

use App\Helpers\Helper;
use Auth;

class AccessHelper extends Helper
{
    public $status;
    protected $user;
    protected $logout = false;
    protected $redirect = null;

    public function __construct($resource_group = null)
    {
        $this->user = auth()->user();

        if ($this->checkAccountStatus()) {
            if (!is_null($resource_group)) {
                if ($this->hasResourceGroupAccess($resource_group)) {
                    $this->setStatusToTrue('Access Granted');
                }
            } else{
                $this->setStatusToTrue('Access Granted');
            }
        }
    }

    public function checkAccountStatus($message = 'Please login to continue')
    {   
        if ($this->user != null) {
            if ($this->user->is_active || $this->isSystemSuperAdmin()) {
                return true;
            } else {
                $message = 'Your account has been deactived. Please contact the administrators if you think this was as a mistake';
            }
        }

        $this->setStatusToFalse($message);
        $this->logout = true;
        $this->redirect = redirect()->route('login');

        return false;
    }

    public function hasResourceGroupAccess($resource_group)
    {
        if (auth()->user()->hasAccess($resource_group))
            return true;

        $this->setStatusToFalse('You are not authorized to access the requested resource');

        return false;
    }

    public function setStatusToFalse($message)
    {
        $this->status = [
            'success' => false,
            'message' => $message
        ];
    }

    public function setStatusToTrue($message)
    {
        $this->status = [
            'success' => true,
            'message' => $message
        ];
    }

    public function accessDenied()
    {
        if ($this->logout) Auth::logout();
        flash($this->status['message']);

        return redirect()->route('login');
    }

    public function isSystemSuperAdmin()
    {
        if ($this->user->hasSystemRole('super-admin'))
            return true;

        return false;
    }
}