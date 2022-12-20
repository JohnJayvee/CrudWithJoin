<?php

namespace App\Http\Controllers;

use App\Models\orderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        // $json = DB::table('customer')->get()->tojson();
        $customer = orderModel::get();
        // return response($customer, 200);

        if ($request->ajax()) {
            $data = $customer;
            return Datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '
                                <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editCustomer">Edit</a>


                                <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteOrder">Delete</a>
                            ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        if ($request->expectsJson()) {
            return response()->json($customer, 200);
        }

        $join = DB::table('order')
            ->select('customer.*')
            ->rightJoin('customer', 'order.id', '=', 'customer.order_id')
                // ->where('customer.id', '=','*')
            ->get();
        return view('orderView', ['users' => $customer])->with('join', json_decode($join, true));



        // $users = DB::table('order')
        //     ->select('customer.id')
        //     ->rightJoin('customer', 'order.id', '=', 'customer.order_id')
        //     // ->where('customer.id', '=','*')
        //     ->get();
        // return response()->json($users, 200);


    }

    public function store(Request $request)
    {

        $errors = Validator::make(
            $request->all(),
            [
                'c_customer' => 'required',
                'c_delivery_address' => 'required|string|max:255',
                'c_phone_number' => 'required|string|max:255',
                'c_package_weight' => 'required|string|max:255',
                'c_dimension' => 'required|string|max:255',

            ],
            [
                // 'c_name.required' => 'Name field are required',
                // 'c_address.required' => 'Address field are required',
                // 'c_phone_number.required' => 'Phone Number field are required',
                // 'c_email.required' => 'Phone Number field are required',
                // 'c_email.email' => 'Enter valid email address'


            ]
        );

        if ($errors->fails()) {
            return response()->json(['errors' => $errors->errors()], 400);
        }


        if ($customer = new orderModel()) {
            $customer->customer_id = $request->c_customer;
            $customer->delivery_address = $request->c_delivery_address;
            $customer->phone_number = $request->c_phone_number;
            $customer->package_weight = $request->c_package_weight;
            $customer->dimension = $request->c_dimension;

            $customer->save();

            return response()->json([
                "success" => "users record created"
            ], 201);
        } else {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }
    }

    public function edit($id)
    {
        if (orderModel::where('id', $id)->exists()) {
            $order = orderModel::find($id);
            return response($order, 200);
        } else {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $errors = Validator::make(
            $request->all(),
            [
                'u_customer' => 'required',
                'u_delivery_address' => 'required|string|max:255',
                'u_phone_number' => 'required|string|max:255',
                'u_package_weight' => 'required|string|max:255',
                'u_dimension' => 'required|string|max:255',

            ],
            [
                // 'u_name.required' => 'Name field are required',
                // 'u_address.required' => 'Address field are required',
                // 'u_phone_number.required' => 'Phone Number field are required',
                // 'u_email.required' => 'Email field are required',
                // 'u_email.email' => 'Enter valid email address'

            ]
        );

        if ($errors->fails()) {
            return response()->json(['errors' => $errors->errors()], 400);
        }


        if (orderModel::where('id', $id)->exists()) {
            $order = orderModel::find($id);
            $order->delivery_address = is_null($request->c_delivery_address) ? $order->delivery_address : $request->c_delivery_address;
            $order->phone_number = is_null($request->c_phone_number) ? $order->phone_number : $request->c_phone_number;
            $order->package_weight = is_null($request->c_package_weight) ? $order->package_weight : $request->c_package_weight;
            $order->dimension = is_null($request->c_dimension) ? $order->dimension : $request->c_dimension;


            $order->save();

            return response()->json([
                "success" => "User record updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }
    }

    public function destroy($id)
    {


        if (orderModel::where('id', $id)->exists()) {
            $order = orderModel::find($id);
            $order->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }
    }
}