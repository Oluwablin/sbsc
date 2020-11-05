<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use App\User;

class RegistrationController extends Controller
{
    /*
    |-----------------------------------------
    | REGISTER A USER
    |-----------------------------------------
    */
    public function registerUser(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator                  = Validator::make($request->all(), [
	        'first_name'                => 'required|string|max:255',
	        'last_name'                 => 'required|string|max:255',
	        'email'                     => 'required|string|email|max:255|unique:users',
	        'password'                  => 'required|string|min:4|confirmed',
            ]);
            
		    if ($validator->fails()) {
		        return response()->json($validator->errors(), 400);
            }
            $user                       = new User;
		    $user->first_name           = $request->first_name;
		    $user->last_name            = $request->last_name;
		    $user->email                = $request->email;
		    $user->password             = bcrypt($request->password);
		    $user->code                 = uniqid();
		    if($user->save()){
                $data = [
                    "status"            => "success",
                    "message"           => 'User account has been created successfully.',
                ];
            }else{
                $data = [
                    "status"            => "Failed",
                    "message"           => "Error Encountered while trying to create new account",
                ];
            }
            DB::commit();
            return response()->json($data, 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status'=> 'error' , 'message' => $e->getMessage(). ',' . ' Sorry, could not create account'], 400);
        }
    }
}
