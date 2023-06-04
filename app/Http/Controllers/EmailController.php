<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\EventMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail()
{
    $maildata=[
        'title'=>'maailllll',
        'body'=>'yeaahhh'
    ];
    Mail::to('elsieaseda@gmail.com')->send(new EventMail($maildata));
    return $maildata;
}

}


