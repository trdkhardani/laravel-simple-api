<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    public function authLogin(Request $request)
    {
        if(!Auth::attempt($request->only('email', 'password')))
        {
            return response()->json([
                'message' => "Invalid username or password"
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken(Auth::user()->name, ['view', 'create'], now()->addMinutes(2)); // expiry date adjusted to sanctum.php config


        return response()->json([
            'message' => "Welcome, " . Auth::user()->name . "!",
            'token' => $token->plainTextToken
        ], 200);
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
