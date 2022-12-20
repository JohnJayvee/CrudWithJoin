<?php

namespace App\Http\Controllers;

use App\Models\usersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        // $json = DB::table('tbl_users')->get()->tojson();
        $users = usersModel::get();
        // return response($users, 200);

        if ($request->ajax()) {
            $data = $users;
            return Datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '
                                <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editUser">Edit</a>


                                <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm     deleteUser">Delete</a>
                            ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        if ($request->expectsJson()) {
            return response()->json($users, 200);
        }
        return view('userView', ['users' => $users]);
    }

    public function store(Request $request)
    {

        $errors = Validator::make(
            $request->all(),
            [
                'c_firstName' => 'required|string|max:255',
                'c_lastName' => 'required|string|max:255',
            ],
            [
                'c_firstName.required' => 'The First Name field are required',
                'c_lastName.required' => 'The Last Name field are required'
            ]
        );

        if ($errors->fails()) {
            return response()->json(['errors' => $errors->errors()], 400);
        }


        if ($users = new usersModel()) {
            $users->firstName = $request->c_firstName;
            $users->lastName = $request->c_lastName;
            $users->save();

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
        // $users = usersModel::find($id);
        // return response()->json($users);
        if (usersModel::where('id', $id)->exists()) {
            $users = usersModel::find($id);
            return response($users, 200);
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
                'u_firstName' => 'required|string|max:255',
                'u_lastName' => 'required|string|max:255',
            ],
            [
                'u_firstName.required' => 'The First Name field are required',
                'u_lastName.required' => 'The Last Name field are required'
            ]
        );

        if ($errors->fails()) {
            return response()->json(['errors' => $errors->errors()], 400);
        }


        if (usersModel::where('id', $id)->exists()) {
            $users = usersModel::find($id);
            $users->firstName = is_null($request->u_firstName) ? $users->firstName : $request->u_firstName;
            $users->lastName = is_null($request->u_lastName) ? $users->lastName : $request->u_lastName;
            $users->save();

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


        if (usersModel::where('id', $id)->exists()) {
            $users = usersModel::find($id);
            $users->delete();

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