<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function login(Request $request){
        $request->validate([
            "email" => ["required","email"],
            "password" => ["required"]
        ]);

        $user = User::where("email",$request->email)->first();
        if(!$user){
            throw ValidationException::withMessages([
                "email" => ["The provided credentials are incorrect"]
            ]);
        }
        if(!Hash::check($request->password, $user->password))
        {
            throw ValidationException::withMessages([
                "password" => ["The provided credentials are incorrect"]
            ]);
        }
        $token = $user->createToken("tokenforemsuser")->plainTextToken;
        return response()->json([
            "token" => $token
        ]);
    }

    public function logout(Request $request){
       $request->user()->tokens()->delete();
       return response()->json([
        "message" => "Logged Out successfully"
       ]);
    }

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
