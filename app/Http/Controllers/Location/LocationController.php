<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\Location\LocationRequest;
use App\Models\Location\Location;
use Illuminate\Http\Response;

class LocationController extends Controller
{
    public function store(LocationRequest $location)
    {
        Location::storeLocation($location);
        return response()->json([],Response::HTTP_OK);
    }
}
