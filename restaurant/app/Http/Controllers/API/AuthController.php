<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function validator($input, $action=null)
    {
        $rules = [];
        $data = [
                'email' => ['required'],
                'password' => ['required'],
            ];

        $rules = $data;

        $validator = \Validator::make($input, $rules);

        return $validator;
    }

    public function login(Request $request)
    {
        $validator = $this->validator($request->all());
        if($validator->fails()){

            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $generateToken = $this->generateToken(Auth::user());
            return response()->json(["api_token" => $generateToken], 200);
        }

        return response()->json(["You are credentials is not match"], 400);
    }

    public function generateToken($user)
    {
        $user->api_token = Str::random(60);
        $user->save();

        return $user->api_token;
    }

    public function logout()
    {
        $user = Auth::user();
        $user->api_token = null;
        $user->save();

        return response()->json(["success"], 200);
    }
}
