<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public static function showProfileImage(Request $request)
    {
        try {
            //Find the user with the email from the request
            $user = User::where('email', $request->email)->first();

            //Check if the user has a profile image path
            $path = public_path("profile-images")."\\". $user->profile_image;

            //If the path exists, return the image
            if (file_exists($path)) {
                return response()->file($path);
            }

            //Else return file not found
            else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File not found'
                ], 400);
            }
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

            //Store the image in the public folder
            $request->image->move(public_path('profile-images'), $imageName);

            //Update the profile_image column with the image name
            $user = User::where('email', $request->email)->first();
            $user->profile_image = $imageName;
            $user->save();

            //Return success response with image name
            return response()->json([
                'status' => 'success',
                'image' => $imageName
            ], 200);


        } catch (\Throwable $th) {
            //If error occurs, return the error message
            return $th->getMessage();
        }
    }
}
