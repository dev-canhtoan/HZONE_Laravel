<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function feedback(Request $request) {
        $feedback = $request->input('feedback');
        
        Mail::raw($feedback, function ($message) {
            $message->from(auth()->user()->email,auth()->user()->username );
            $message->to('hzoneshop2024@gmail.com');
            $message->subject(auth()->user()->email . ' Feedback');
        });
        return redirect()->back();
    }
}