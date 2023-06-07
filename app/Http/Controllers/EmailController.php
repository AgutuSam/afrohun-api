<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\EventMail;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail()
{
    $url= "http://127.0.0.1:8000/";
    $maildata=(new MailMessage)
    ->subject('Afrohun Email')
    ->line('we have a new event on.')
    ->action('click this link to view more', $url);

    Mail::to('elsieaseda@gmail.com')->send(new EventMail($maildata));
    return $maildata;
}

}


