<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    public function authRegister(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $token = $user->createToken('Register-API TOKEN');

        return response()->json([
            'message' => "User registered",
            'token' => $token->plainTextToken
        ], 200);
    }

    public function authLogin(Request $request)
    {
        if(!Auth::attempt($request->only('email', 'password')))
        {
            return response()->json([
                'message' => "Invalid username or password"
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken(Auth::user()->name);
        return response()->json([
            'message' => "User Logged in",
            'token' => $token->plainTextToken
        ], 200);
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();
        if($request->user()->currentAccessToken()){
            return response()->json([
                'greet' => "Welcome, " . $user->name . "!",
                'status' => "Currently logged in"
            ]);
        }
        else{
            // return[
            //     'warning' => "You have to log in first!"
            // ];
        }
    }

    public function authLogout(Request $request)
    {
        $user = Auth::user();
        // $token = PersonalAccessToken::where('token', 'test');
        // PersonalAccessToken::where('tokenable_id', 2)->delete();

        $request->user()->currentAccessToken()->delete();

        // Auth::logout();
        return[
            "status" => "Logged out!",
            "say_bye" => "Goodbye, " . $user->name . "!",
            response(200),
            // "apaansi" => $test
        ];
    }
}
