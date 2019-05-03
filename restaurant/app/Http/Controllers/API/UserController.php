<?php

namespace App\Http\Controllers\API;

use App\Department;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    public function validator($input, $action=null)
    {
        $departmentIds = Department::pluck('id')->toArray();

        $rules = [];
        $data = [
                'department_id' => ['required', Rule::in($departmentIds)],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];

        if ($action == 'create'){
            $rules = $data;

        } else {

            foreach ($input as $key => $value) {
                # code...
                if (isset($data[$key])){
                    $rules[$key] = $data[$key];
                }
            }

        }

        $validator = \Validator::make($input, $rules);

        return $validator;
    }

    public function store(Request $request)
    {
        $validator = $this->validator($request->all(), 'create');
        if($validator->fails()){

            return response()->json($validator->errors(), 400);
        }

        $user = new User();
        $user->department_id = $request->department_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        // $user->api_token = Str::random(60);
        $user->save();

        return response()->json($user, 200);
    }

}
