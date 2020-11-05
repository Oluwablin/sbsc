<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Password;

class AuthenticationController extends Controller
{
    /*
    |-----------------------------------------
    | LOGIN A USER
    |-----------------------------------------
    */
    public function loginUser(Request $request)
    {
        $validator                  = Validator::make($request->all(), [
            'email'                 => 'required|string|email|max:255',
            'password'              => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
	        	"status"            => "validation_error",
	        	"message"           => $validator->errors(),
	        	"token"             => "",
	        	"user_details"      => "",
            ];
            
	        return response()->json($data, 400);
        }
        $credentials                = $request->only('email', 'password');
        try {
            if (! $token            = JWTAuth::attempt($credentials)) {
                $data = [
		        	"status"        => "error",
		        	"message"       => "Invalid Credentials",
		        	"token"         => "",
		        	"user_details"  => "",
                ];
                
		        return response()->json($data, 401);
            }
        } catch (JWTException $e) {
            $data = [
	        	"status"            => "error",
	        	"message"           => "Could not create token",
	        	"token"             => "",
	        	"user_details"      => "",
	        ];
	        return response()->json($data, 401);
        }
         
        $user_id                   = Auth::id();    
        $user_details              = User::where('id', $user_id)->first();
        
        $data = [
        	"status"                => "success",
        	"message"               => "Login was successful",
        	"token"                 => $token,
        	"user_details"          => $user_details,
        ];

        return response()->json($data, 200);
    }

    /*
    |---------------------------------------------
    | SEND FORGOT PASSOWORD RESET LINK TO A USER
    |---------------------------------------------
    */
    public function forgotPassword(Request $request)
    {
    }

    /*
    |-----------------------------------------
    | RESET A USER PASSWORD
    |-----------------------------------------
    */
    public function resetPassword(Request $request)
    {
    }
}
