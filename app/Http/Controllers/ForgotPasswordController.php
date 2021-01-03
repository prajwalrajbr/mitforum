<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash; 


class ForgotPasswordController extends Controller
{
    public function forgot() {
        $credentials = request()->validate(['email' => 'required|email']);

        Password::sendResetLink($credentials);

        return "dd";
    }


    public function reset(ResetPasswordRequest $request) {
        $reset_password_status = Password::reset($request->validated(), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });


        return "Password has been successfully changed";
    }
}