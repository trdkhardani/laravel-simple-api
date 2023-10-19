<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        if($request->user()->currentAccessToken()){
            return response()->json([
                'greet' => "Hello, " . $user->name . "!",
                'status' => "Currently logged in"
            ]);
        }
        else{
            // return[
            //     'warning' => "You have to log in first!"
            // ];
        }
    }
}
