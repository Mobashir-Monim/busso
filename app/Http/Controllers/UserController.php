<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\UserHelpers\Stats;

class UserController extends Controller
{
    public function index()
    {
        $helper = new Stats;
        return view('user.index', ['stats' => $helper->getQuickStats()]);
    }
}
