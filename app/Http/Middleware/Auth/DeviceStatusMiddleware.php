<?php

namespace App\Http\Middleware\Auth;

use App\Models\Auth\Device;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeviceStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$this->getDeviceStatus($request)){
            return response()->json(['message' => 'Device Locked is not locked'], Response::HTTP_LOCKED);
        }
        return $next($request);
    }

    private function getDeviceStatus(Request $request)
    {
        if ($request->method() === 'POST'){
           $deviceToken = $request->input('device.token');
        }else{
            $deviceToken = $request->get('device_token');
        }
        if($deviceToken){
            $deviceStatus = Device::find($deviceToken)->DeviceStatus;
            if($deviceStatus){
                return (int)$deviceStatus === 1;
            }
        }
        return false;
    }
}
