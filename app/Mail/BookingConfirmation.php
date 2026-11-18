<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/** Confirmation sent to the visitor so they know the request arrived. */
class BookingConfirmation extends Mailable
{
    public function __construct(public array $data)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'We received your request, '.explode(' ', trim($this->data['name']))[0].' ✓',
            replyTo: [new Address(config('progix.contact.email'), config('mail.from.name'))],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.confirmation');
    }
}