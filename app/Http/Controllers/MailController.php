<?php

namespace App\Http\Controllers;

use App\Mail\UserEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail()
    {
        $details = [
            'title' => 'Mail from PKG Faculty',
            'body' => 'Mail message',
        ];

        Mail::to("pkgFaculty@gmail.com")->send(new UserEmail($details));
        return "Email sent";
    }
}
