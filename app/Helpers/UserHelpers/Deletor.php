<?php

namespace App\Helpers\UserHelpers;

use App\Helpers\Helper;
use Carbon\Carbon;

class Deletor extends Helper
{
    protected $user;
    public $status;

    public function __construct($user)
    {
        $this->user = $user;

        if ($this->hasPriviledge()) {
            $this->setStatusToTrue('Successfully deleted user account');
        }
    }

    public function hasPriviledge()
    {
        $can_delete = (auth()->user()->hasRole('super-admin')) ||
                auth()->user()->hasRole('admin') && !$this->user->hasRole('super-admin') ||
                auth()->user()->hasRole('user-admin') && !$this->user->hasRole('super-admin') && !$this->user->hasRole('admin');
        
        if ($this->user->id != auth()->user()->id && $can_delete)
            return true;

        $this->setStatusToFalse('You do not have the required permissions to delete this account');

        return false;
    }

    public function setStatusToFalse($message)
    {
        $this->status = [
            'success' => false,
            'redirect' => back(),
            'message' => $message
        ];
    }

    public function setStatusToTrue($message)
    {
        $this->status = [
            'success' => true,
            'redirect' => redirect()->route('users'),
            'message' => $message
        ];
    }

    public function execute()
    {
        if ($this->status['success']) {
            $this->deleteAccessLogs();
            $this->detachRoles();
            $this->user->delete();

            flash($this->status['message'])->success();
        } else {
            flash($this->status['message'])->error();
        }
    }

    public function detachRoles()
    {
        foreach ($this->user->roles as $role)
            $role->users()->detach($this->user->id);
    }

    public function deleteAccessLogs()
    {
        foreach ($this->user->accessLogs as $log)
            $log->delete();
    }
}