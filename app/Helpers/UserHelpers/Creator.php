<?php

namespace App\Helpers\UserHelpers;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Role;
use App\Mail\PassEmailer;
use App\Helpers\ChangeLogHelpers\User\LogHelper;

class Creator extends Helper
{
    protected $name;
    protected $email;
    protected $pass;
    protected $role;
    protected $mode;
    public $status;

    public function __construct($request)
    {
        $this->name = $request->name;
        $this->email = $request->email;
        $this->pass = \Str::random(rand(12, 16));
        $this->role = Role::where('name', $request->system_role)->first()->id;
    }

    public function create()
    {
        $user = User::where('email', $this->email)->first();
        
        if (is_null($user)) {
            $user = User::create(['name' => $this->name, 'email' => str_replace(" ", "", $this->email), 'password' => bcrypt($this->pass)]);
            new LogHelper($user, 'create');
            $user->roles()->attach($this->role);
            Mail::to($this->email)->send(new PassEmailer($this->name, $this->email, $this->pass));
            $this->setStatusToTrue("Account for $user->name with email $user->email created");
        } else {
            $this->setStatusToFalse("User with email $user->email already exists");
        }
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

    public function getStatus()
    {
        return $this->status;
    }
}