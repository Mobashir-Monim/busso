<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\UserHelpers\Stats;
use App\Models\User;
use App\Helpers\UserHelpers\Creator;

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
}
