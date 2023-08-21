<?php

namespace App\Mail;

use App\Models\Member;
use Faker\Provider\ar_EG\Address;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address as MailablesAddress;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use PharIo\Manifest\Email;
use User;

class EventMail extends Mailable
{
    use Queueable, SerializesModels;

    public $maildata;
    
    // public $path;
    public $address;
    
    
    /**
     * Create a new message instance.
     */
    // public function __construct($maildata, $address, $path)
    public function __construct($maildata, $address)
    {
        $this->maildata=$maildata;
        // $this->path=$path;
        $this->address=$address;
        
       
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            
            from: new MailablesAddress($this->address),
            subject: "Event Mail",
            
            
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.eventmail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            // Attachment::fromPath($this->path)
        ];
    }
}
