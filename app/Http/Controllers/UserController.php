<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\UserHelpers\Stats;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $helper = new Stats;
        return view('user.index', ['stats' => $helper->getQuickStats()]);
    }

    public function create(Request $request)
    {
        $pass = \Str::random(rand(12, 16));
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($pass);
        $user->save();

        $user->roles()->attach($request->system_role);

        flash("User $user->email created with password $pass")->success();

        return redirect()->route('users');
    }

    public function showUser(User $user)
    {
        return view('home', ['user' => $user]);
    }
}
