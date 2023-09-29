<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;





class UserController extends Controller
{
    /////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response([
            'status' => 'success',
            'users' => $users
        ], 200);
    }

    ////////////////////////////////////////////////////////////////
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(String $email)
    {
        $user = User::where('email', $email)->first();
        return response()->json([
            'status' => 'success',
            'user' => $user,
        ], 200);
    }


    ///////////////////////////////////////////////////////

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    //Update user profile details
    public function update(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'password' => 'string|min:6',
                'phone' => 'string',
                'address' => 'string',
                'city' => 'string',
                'state' => 'string',
                'country' => 'string',
                'pincode' => 'string',
                'status' => 'string',
                'role' => 'string',
                'dob'=>'date',
                'bio'=> 'string'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            if ($request->has('name')) {
                $user->name = $request->name;
            }
            if ($request->has('password')) {
                $user->password = $request->password;
            }
            if ($request->has('phone')) {
                $user->phone = $request->phone;
            }
            if ($request->has('address')) {
                $user->address = $request->address;
            }
            if ($request->has('city')) {
                $user->city = $request->city;
            }
            if ($request->has('state')) {
                $user->state = $request->state;
            }
            if ($request->has('country')) {
                $user->country = $request->country;
            }
            if ($request->has('pincode')) {
                $user->pincode = $request->pincode;
            }
            if ($request->has('status')) {
                $user->status = $request->status;
            }
            if ($request->has('role')) {
                $user->role = $request->role;
            }
            $user->save();

            return response()->json($user, 200);
            //code...
        } catch (\Exception $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    ///////////////////////////////////////////////////////////////////////

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 204);
    }


    ///////////////////////////////////////////////////////////



    public static function showProfileImage(Request $request)
    {
        try {
            //Find the user with the email from the request
            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => 'success',
                'image' => $user->profile_image
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }





    public static function uploadProfileImage(Request $request)
    {
        try {
            //Validate the image request
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg',
            ]);

            //Create a unique name for the image
            $imageName = time() . '.' . $request->image->extension();


            //Update the profile_image column with the image name
            $user = User::where('email', $request->email)->first();
            $user->profile_image = $request->image;
            $user->save();

            //Return success response with image name
            return response()->json([
                'status' => 'success',
                'image' => $imageName
            ], 200);
        } catch (\Exception $th) {
            //If error occurs, return the error message
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
