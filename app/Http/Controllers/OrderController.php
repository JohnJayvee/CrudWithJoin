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
        return view('orderView', ['users' => $customer]);
    }

    public function store(Request $request)
    {

        $errors = Validator::make(
            $request->all(),
            [
                'c_name' => 'required|string|max:255',
                'c_address' => 'required|string|max:255',
                'c_phone_number' => 'required|string|max:255',
                'c_email' => 'required|string|max:255|email',

            ],
            [
                'c_name.required' => 'Name field are required',
                'c_address.required' => 'Address field are required',
                'c_phone_number.required' => 'Phone Number field are required',
                'c_email.required' => 'Phone Number field are required',
                'c_email.email' => 'Enter valid email address'


            ]
        );

        if ($errors->fails()) {
            return response()->json(['errors' => $errors->errors()], 400);
        }


        if ($customer = new customerModel()) {
            $customer->name= $request->c_name;
            $customer->address = $request->c_address;
            $customer->phone_number = $request->c_phone_number;
            $customer->email = $request->c_email;

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
        if (customerModel::where('id', $id)->exists()) {
            $customer = customerModel::find($id);
            return response($customer, 200);
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
                'u_name' => 'required|string|max:255',
                'u_address' => 'required|string|max:255',
                'u_phone_number' => 'required|string|max:255',
                'u_email' => 'required|string|max:255|email',

            ],
            [
                'u_name.required' => 'Name field are required',
                'u_address.required' => 'Address field are required',
                'u_phone_number.required' => 'Phone Number field are required',
                'u_email.required' => 'Email field are required',
                'u_email.email' => 'Enter valid email address'

            ]
        );

        if ($errors->fails()) {
            return response()->json(['errors' => $errors->errors()], 400);
        }


        if (customerModel::where('id', $id)->exists()) {
            $customer = customerModel::find($id);
            $customer->name = is_null($request->u_name) ? $customer->name : $request->u_name;
            $customer->address = is_null($request->u_address) ? $customer->address : $request->u_address;
            $customer->phone_number = is_null($request->u_phone_number) ? $customer->phone_number : $request->u_phone_number;
            $customer->email = is_null($request->u_email) ? $customer->email : $request->u_email;


            $customer->save();

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
