<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Department;

class DepartmentController extends Controller
{
    //
    public function index()
    {
        $data = Department::get();
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if($validator->fails()){

            return response()->json($validator->errors(), 400);
        }

        $department = new Department();
        $department->name = $request->name;
        $department->routes = implode(",", $request->routes);
        $department->save();

        return response()->json($department, 200);
    }

    public function validator($input)
    {
        $rules = [
            "name" => "required",
            "routes.0" => "required",
        ];

        $validator = \Validator::make($input, $rules);

        return $validator;
    }
}
