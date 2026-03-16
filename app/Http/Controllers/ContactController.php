<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Auth;
use Mail;
use App\Post;
use App\Comment;
use App\Category;

class ContactController extends Controller
{
    public function contact()
    {
        $user = Auth::user();
        return view('email/contact', compact('user'));
    }

    public function submitContactEmail(Request $request)
    {
        $user = Auth::user();

        Mail::send('email.sendemail',[
            'name' => $request->name,
            'email' => $request->email,
            'msg' => $request->msg,
            'user' => $user
        ], function($mail) use ($request){
            $mail->from(env('MAIL_FROM_ADDRESS'), $request->name);
            $mail->to(env('MAIL_USERNAME'))->subject('User Contact Email');
        });

        flash('Your email has been sent successfully.');

        return view('email/contact', compact('user'));
    }
}
