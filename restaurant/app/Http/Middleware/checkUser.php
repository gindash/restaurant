<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use App\Department;
use App\User;

class checkUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            //code...

            if (!$request->isMethod('get')) {

                $token = $request->header('Authorization');
            } else {

                $token = $request->api_token;
            }

            // dd($token);
            $user = User::where('api_token', $token)->firstorFail();

            if ( $user->department_id == 3){

                return $next($request);
            }

            $currentRoute = Route::currentRouteName();
            $checkroutes = Department::where('id', $request->user()->department_id)
                ->whereRaw('FIND_IN_SET("'.$currentRoute. '", routes)')
                ->firstorFail();

            return $next($request);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['Forbidden'], 403);
        }
    }
}
