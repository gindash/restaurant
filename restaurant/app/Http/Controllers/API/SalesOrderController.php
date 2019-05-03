<?php

namespace App\Http\Controllers\API;

use App\Product;
use App\SalesOrder;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SalesOrderController extends Controller
{
    //
    public function getUser()
    {
        if (! request()->isMethod('get')) {

            $token = request()->header('Authorization');
        } else {

            $token = request()->api_token;
        }
        $user = User::where('api_token', $token)->firstorfail();
        return $user;
    }

    public function index()
    {
        $salesOrder = SalesOrder::all();
        return response()->json($salesOrder, 200);
    }

    public function activeSalesOrders()
    {
        $user = $this->getUser();
        $salesOrder = SalesOrder::where('status', 'active')->get();
        return response()->json($salesOrder, 200);
    }


    public function mySalesOrders()
    {
        $user = $this->getUser();
        $salesOrder = SalesOrder::where('created_by', $user->id)->get();
        return response()->json($salesOrder, 200);
    }

    public function getOrderNumber()
    {
        $lastOrder = SalesOrder::where('created_date', \Carbon\Carbon::now()->toDateString())->orderBy('created_at', 'desc')->first();
        if ($lastOrder != null){

            $number = ((int) explode("-", $lastOrder->order_number)[1]) + 1;
            if (count(str_split($number)) == 1){
                $newnumber = "00".$number;
            } else if (count(str_split($number)) == 2){
                $newnumber = "0".$number;
            } else {
                $newnumber = $number;
            }

            $number = $newnumber;

        } else {

            $number = "001";
        }

        $date = \Carbon\Carbon::now();
        $fullnumber = "ERP".$date->format('dmY')."-".$number;

        return $fullnumber;
    }

    public function validator($input, $action=null)
    {
        $rules = [];
        $data = [
            "table_no" => ["required"],
            "items" => ["required"],
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
        if ($validator->fails()){

            return response()->json($validator->errors(), 400);
        }

        $items = $this->setItems($request->items);
        $user = $this->getUser();

        $salesOrder = new SalesOrder();
        $salesOrder->table_no = $request->table_no;
        $salesOrder->order_number = $this->getOrderNumber();
        $salesOrder->status = "active";
        $salesOrder->items = $items['items'];
        $salesOrder->amount = $items['amount'];
        $salesOrder->created_by = $user->id;
        $salesOrder->created_date = \Carbon\Carbon::now()->toDateString();
        $salesOrder->save();

        return response()->json($salesOrder, 200);
    }

    public function setItems($data)
    {
        $items = [];
        $amount = 0;
        foreach ($data as $key => $value) {
            # code...
            $product = Product::findorFail($value);
            $items[$key]['category'] = $product->category;
            $items[$key]['name'] = $product->name;
            $items[$key]['price'] = $product->price;
            $items[$key]['product_id'] = $product->id;

            $amount += $product->price;
        }

        return ["items" => $items, "amount" => $amount];
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validator($request->all(), 'create');
        if ($validator->fails()){

            return response()->json($validator->errors(), 400);
        }

        $items = $this->setItems($request->items);

        $salesOrder = SalesOrder::where('id', $id)->where('status', 'active')->firstorFail();
        $salesOrder->items = $items['items'];
        $salesOrder->amount = $items['amount'];

        $salesOrder->save();

        return response()->json($salesOrder, 200);
    }

    public function validatorSetStatus($input, $action=null)
    {
        $rules = [];
        $data = [
            "status" => ["required", Rule::in(["active", "completed", "canceled"])],
            "payment_amount" => ["required", "numeric"],
            ];

        $rules = $data;

        $validator = \Validator::make($input, $rules);

        return $validator;
    }

    public function setStatus(Request $request, $id)
    {
        $validator = $this->validatorSetStatus($request->all());
        if ($validator->fails()){

            return response()->json($validator->errors(), 400);
        }

        $salesOrder = SalesOrder::findorFail($id);
        $salesOrder->status = $request->status;
        $salesOrder->payment_amount = $request->payment_amount;
        $salesOrder->save();

        return response()->json($salesOrder, 200);
    }
}
