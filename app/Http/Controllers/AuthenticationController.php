<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Password;

class AuthenticationController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
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
            'token_type'            => 'bearer',
            'expires_in'            => auth('api')->factory()->getTTL() * 60,
        	"user_details"          => $user_details,
        ];

        return response()->json($data, 200);
    }

    /*
    |---------------------------------------------
    | SEND FORGOT PASSWORD RESET LINK TO A USER
    |---------------------------------------------
    */
    public function forgotPassword(Request $request)
    {
        $validator                  = Validator::make($request->all(), [
            'email'                 => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            $data = [
	        	"status"            => "validation_error",
	        	"message"           => $validator->errors(),
            ];
            
	        return response()->json($data, 400);
        }
        $credentials                = $request->only('email');

        Password::sendResetLink($credentials);

        return response()->json(['message' => 'Reset password link sent to your email address.'], 200);
    }

    /*
    |-----------------------------------------
    | RESET A USER PASSWORD
    |-----------------------------------------
    */
    public function resetPassword(Request $request)
    {
        $validator                  = Validator::make($request->all(), [
            'email'                 => 'required|string|email|max:255',
            'token'                 => 'required|string',
            'password'              => 'required|string|min:4|confirmed'
        ]);

        if ($validator->fails()) {
            $data = [
	        	"status"            => "validation_error",
	        	"message"           => $validator->errors(),
            ];
            
	        return response()->json($data, 400);
        }

        $credentials                = $request->only('email', 'token', 'password', 'password_confirmation');

        $reset_password_status      = Password::reset($credentials, function ($user, $password) {
            $user->password         = bcrypt($password);
            $user->changed_password = 1;
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return response()->json(['message' => 'Invalid token provided'], 400);
        }

        return response()->json(['message' => 'Password has been successfully changed'], 200);       
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /*
    |---------------------------------------------
    | GET THE USER THAT IS CURRENTLY LOGGED-IN
    |---------------------------------------------
    */
    public function userCurrentlyLoggedIn()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /*
    |---------------------------------------------
    | LOG A USER OUT
    |---------------------------------------------
    */
    public function logoutUser()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
