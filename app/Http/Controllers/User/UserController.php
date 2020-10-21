<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Auth\Device;
use App\Models\Auth\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(Device::all()->toArray());
        return UserResource::collection(User::getUsers())->response();
    }
}
