<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        $users = User::all()->first();
        return response()->json($users);
    }
}
