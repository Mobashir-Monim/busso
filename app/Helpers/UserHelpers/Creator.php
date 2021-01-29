<?php

namespace App\Helpers\UserHelpers;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Role;
use App\Mail\PassEmailer;

class Creator extends Helper
{
    protected $name;
    protected $email;
    protected $pass;
    protected $role;
    protected $mode;

    public function __construct($request)
    {
        $this->name = $request->name;
        $this->email = $request->email;
        $this->pass = \Str::random(rand(12, 16));
        $this->role = is_null($request->system_role) ? Role::where('name', 'system-user')->first()->id : $request->system_role;
        $this->mode = is_int(strpos($request->path(), 'api')) ;
    }

    public function create()
    {
        $message = "Account for " . $this->name . " created.";

        if (is_null(User::where('email', $this->email)->first())) {
            $user = User::create(['name' => $this->name, 'email' => str_replace(" ", "", $this->email), 'password' => bcrypt($this->pass)]);
            $user->roles()->attach($this->role);
            Mail::to($this->email)->send(new PassEmailer($this->name, $this->email, $this->pass));
        } else {
            $message = "User already exists";
        }

        return $this->returningMessage($message);
    }

    public function returningMessage($message)
    {
        if ($this->mode) {
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } else {
            flash($message)->success();

            return redirect()->route('users');
        }
    }
}