<?php

namespace App\Http\Controllers;

use App\Mail\ExampleMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail(Request $request){
        $request->validate([
            'title' => 'required|min:5|max:255|string',
            'body' => 'required|min:10|max:5000|string',
        ]);


        
    }
}
