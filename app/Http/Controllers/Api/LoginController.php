<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //* set validator
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        //* if validator fail
        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //* get credentials from request
        $credentials = $request->only('email', 'password');

        //* if auth failed
        if(!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Email atau password Anda salah!'
            ], 401);
        }

        //* if auth success
        return response()->json([
            'status' => 'success',
            'user' => auth()->guard('api')->user(),
            'token' => $token
        ], 200);
    }
}
