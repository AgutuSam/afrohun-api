<?php

namespace App\Mail;

use App\Models\Member;
use Faker\Provider\ar_EG\Address;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use PharIo\Manifest\Email;

class EventMail extends Mailable
{
    use Queueable, SerializesModels;

    public $maildata;
    
    /**
     * Create a new message instance.
     */
    public function __construct($maildata)
    {
        $this->maildata=$maildata;
        
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Event Mail",
            // from: new Member($this->from),
            // replyTo: [
            //     new Member($this->to),
            // ],
            // using: [
            //     function (Email $message) {
            //         return $this->message;
            //     },
            // ]
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
        return [];
    }
}
