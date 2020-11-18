<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'full_name' => ['required'],
            'usn' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'max:20'],
            'semester' => ['required'],
            'branch' => ['required'],
            'is_faculty' => ['required']
        ]);

        User::create([
            'full_name' => $request->full_name,
            'usn' => $request->usn,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'semester' => $request->semester,
            'branch' => $request->branch,
            'is_faculty' => $request->is_faculty,
        ]);

    }
}
