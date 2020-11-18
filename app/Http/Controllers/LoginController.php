<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['usn'=>$request->email, 'password'=>$request->password])){
            return response()->json(Auth::user(), 200);
        }

        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
            return response()->json(Auth::user(), 200);
        }

        throw ValidationException::withMessage([
            'email' =>['The provided credentials are incorrect.']
        ]);
    }

    public function logout(){
        Auth::logout();
    }
}
