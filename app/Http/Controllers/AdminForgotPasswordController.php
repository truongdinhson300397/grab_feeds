<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Notifications\Messages\MailMessage;
use Password;

class AdminForgotPasswordController extends Controller
{

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('auth.passwords.admin_email');
    }

    protected function broker() {
        return Password::broker('admins');
    }

    public function __construct()
    {
        $this->middleware('guest:admins');
    }
}
