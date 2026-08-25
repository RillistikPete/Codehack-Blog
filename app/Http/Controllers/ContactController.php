<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Auth;
use Mail;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use App\Mail\ContactMessage;

class ContactController extends Controller
{
    public function contact()
    {
        $user = Auth::user();
        return view('email/contact', compact('user'));
    }

    public function submitContactEmail(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'msg'   => 'required|string|max:2000',
        ]);

        $to = config('mail.contact_to') ?: config('mail.from.address');

        if (! $to) {
            throw new \RuntimeException(
                'No contact recipient configured. Set MAIL_CONTACT_TO in .env.'
            );
        }

        Mail::to($to)->send(
            new ContactMessage($validated['name'], $validated['email'], $validated['msg'])
        );

        return redirect()->route('home')->with('success', 'Your message has been sent.');
    }
}
