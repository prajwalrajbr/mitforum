<?php

namespace App\Http\Controllers;

//use App\ApiCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class VerificationController extends Controller {

    public function __construct() {
        $this->middleware('auth:sanctum')->except(['verify']);
    }

    /**
     * Verify email
     *
     * @param $user_id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function verify($user_id, Request $request) {
        if (! $request->hasValidSignature()) {
            return Redirect::to('https://mitforum.herokuapp.com/page-not-found');
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            return Redirect::to('https://mitforum.herokuapp.com/verify-email-or-reset');
        }

        return Redirect::to('https://mitforum.herokuapp.com/verify-email-or-reset');
    }

    /**
     * Resend email verification link
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resend() {
        if (auth()->user()->hasVerifiedEmail()) {
            return $this->respondBadRequest('emails');
        }

        auth()->user()->sendEmailVerificationNotification();

        return $this->respondWithMessage("Email verification link sent on your email id");
    }
}