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

    public function getAllEmailAndUSN(){
        return User::latest()->get(['email','usn']);
    }

    public function getAllUsers(){
        return User::latest()->orderBy('full_name')->get(['id','full_name','usn','semester','branch','is_faculty']);
    }

    public function getFullname(Request $request){
        $id = $request->id;
        return User::where('id',$id)->get(['full_name']);
    }
}
