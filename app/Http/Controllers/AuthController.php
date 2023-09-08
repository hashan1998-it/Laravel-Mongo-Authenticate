<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;





class AuthController extends Controller
{
    public function register(Request $request)
    {
        //!You can change validation rules in below Validation Rules
       $validationRules = [
           'name' => 'required|string',
           'email' => 'required|email|unique:users',
           'password' => 'required|string'
       ];

        //!validate the request
       $validator = Validator::make($request->all(), $validationRules);

        //!if validation fails shows error
       if($validator->fails()){
           return response()->json([
               'status' => 'error',
               'errors' => $validator->errors()
           ], 400);
       }

        //!create user
         $user = User::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => Hash::make($request->password)
         ]);



        //!Create access Token
        $accessToken = $user->createToken('Personal Access Token')->accessToken;


        //!Return response with user data
            return response()->json([
                'status' => 'success',
                'user' => $user,
                'access_token' => $accessToken
            ], 200);

    }


    public function login(Request $request)
    {
        //!You can change validation rules in below Validation Rules
        $loginRules = [
            'email' => 'required|email',
            'password' => 'required|string'
        ];

        //!Validtae the request
        $request->validate($loginRules);

        //!Find user by email
        $user = User::where('email', $request->email)->first();

        //!if user found check password
        if($user){
            //!if password is correct
            if(Hash::check($request->password, $user->password)){
                //!Create access Token
                $accessToken = $user->createToken('Personal Access Token')->accessToken;

                //!Return response with user data
                return response()->json([
                    'status' => 'success',
                    'user' => $user,
                    'access_token' => $accessToken
                ], 200);
            }else{
                //!if password is incorrect
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password is incorrect'
                ], 400);
            }
        }



    }
}
