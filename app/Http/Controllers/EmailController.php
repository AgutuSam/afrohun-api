<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\EventMail;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    use HttpResponses;
    public function sendEmail(Request $request)
{

      $data= $request->validate([
        'to' => 'required|string',
        // 'to.*' => 'required|array|exists:users,email',
        'address' => 'required|exists:users,email',
        'subject' => 'required',
        'message' => 'required',
        // 'path'=> 'required',
    ]);
 
 
// Log the received data
        \Illuminate\Support\Facades\Log::info('Received email data:', [
            'to' => $request->input('to'),
            'address' => $request->input('address'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]);
    
    // $filename=$request->file('path')->store('Mail','public');
    // public_path('/storage/' . $filename)
    
    // $file= $request->input('path');

    $url= "http://afrohun-api.codetangle.com/";
    $to= $request->input('to');
    // $path= public_path('/storage/Mail/' . $file);
    $subject= $request->input('subject');
    $message=$request->input('message');
    
    $address=$request->input('address');
    

    $maildata=(new MailMessage)
    ->subject($subject)
    ->line($message)
    ->action('click this link to view more', $url);
    $toEmails = explode(',', $to);
    foreach($toEmails as $t){
   Mail::to($t)->send(new EventMail($maildata, $address));
//   Mail::to($t)->send(new EventMail($maildata, $address, $path));
    
    }

    return $this->success([
        'data' => $data,
        'message'=>'donation created'
        ]);

    
}

}


