<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AdminResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = 'admin';

    public function __construct()
    {
        $this->middleware('guest:admins');
    }

    public function showResetForm(Request $request, $token = null) {
        return view('auth.passwords.admin_reset')
            ->with(['token' => $token, 'email' => $request->email]
            );
    }

    protected function guard()
    {
        return Auth::guard('admins');
    }

    protected function broker() {
        return Password::broker('admins');
    }

}
