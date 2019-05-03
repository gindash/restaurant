<?php

namespace App\Http\Controllers\API;

use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    //
    public function validator($input, $action=null)
    {
        $rules = [];
        $data = [
            "name" => ["required"],
            "category" => ["required"],
            "price" => ["required", "numeric"],
            "status" => ["required", Rule::in(['ready', 'not ready'])],
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

    public function index()
    {
        $product = Product::all();
        return response()->json($product, 200);
    }

    public function store(Request $request)
    {
        $validator = $this->validator($request->all(), 'create');
        if ($validator->fails()){

            return response()->json($validator->errors(), 400);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->status = $request->status;
        $product->category = $request->category;
        $product->save();

        return response()->json($product, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()){

            return response()->json($validator->errors(), 400);
        }

        $product = Product::findOrFail($id);

        foreach ($request->all() as $key => $value) {
            # code...
            $product->$key = $value;
        }

        $product->save();

        return response()->json($product, 200);
    }

    public function productsReady()
    {
        $product = Product::where('status', 'ready')->get();
        return response()->json($product, 200);
    }
}
