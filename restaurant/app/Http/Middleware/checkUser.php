<?php

namespace App\Http\Middleware;

use Closure;
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
            $header = $request->header('remember_token');
            $user = User::where('remember_token', $header)->firstorfail();

            return $next($request);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(["Authentication required"], 401);
        }
    }
}
