<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\requestMail;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $mailData = [
            'title' => 'Dear teacher,',
            'body' => 'Hello teacher.I hope your day is going well. I am writing for ask permission from you'
        ];
         
        Mail::to("sreyne.ven@student.passerellesnumeriques.org")->send(new requestMail($mailData));
           
        return("Email is sent successfully.");
    }
}
