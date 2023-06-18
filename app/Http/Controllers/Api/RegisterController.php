<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        // set validator
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        //* if validator fails
        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //* create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //* return response JSON user is created
        if($user) {
            return response()->json([
                'status' => 'success',
                'user' => $user
            ], 201);
        }

        //* return response JSON user insert fail
        return response()->json([
            'status' => 'fail'
        ], 409);
    }
}
