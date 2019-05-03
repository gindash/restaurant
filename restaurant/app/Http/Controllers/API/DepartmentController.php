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
        $validator = $this->validator($request->all(), 'create');
        if($validator->fails()){

            return response()->json($validator->errors(), 400);
        }

        $department = new Department();
        $department->name = $request->name;
        $department->routes = implode(",", $request->routes);
        $department->save();

        return response()->json($department, 200);
    }

    public function validator($input, $action=null)
    {
        $rules = [];
        $data = [
            "name" => "required",
            "routes.0" => "required",
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

    public function update(Request $request, $id)
    {
        $validator = $this->validator($request->all());
        if($validator->fails()){

            return response()->json($validator->errors(), 400);
        }

        $department = Department::findOrFail($id);

        foreach ($request->all() as $key => $value) {
            # code...
            $department->$key = $value;
        }

        $department->save();

        return response()->json($department, 200);
    }
}
