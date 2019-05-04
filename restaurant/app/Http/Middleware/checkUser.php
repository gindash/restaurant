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

            $user = User::where('api_token', $token)->firstorFail();
            // var_dump($user);

            $currentRoute = Route::currentRouteName();

            $checkroutes = Department::where('id', $user->department_id)
            ->whereRaw('FIND_IN_SET("'.$currentRoute. '", routes)')
            ->first();

            return $next($request);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json( $th->getMessage(), 403);
            return response()->json(['Forbidden'], 403);
        }
    }
}
