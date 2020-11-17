<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class registerController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'full_name' => ['required'],
            'usn' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'max:20', 'confirmed'],
            'semester' => ['required'],
            'branch' => ['required'],
            'is_faculty' => ['required']
        ]);

        User::create([
            'full_name' => $request->fullName,
            'usn' => $request->usn,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'semester' => $request->sem,
            'branch' => $request->branch,
            'is_faculty' => $request->isFaculty,
        ]);

    }
}
