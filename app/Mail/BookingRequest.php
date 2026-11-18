<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/** Notification sent to the Progix team when a visitor submits the booking form. */
class BookingRequest extends Mailable
{
    public string $submittedAt;

    public function __construct(public array $data, public ?string $page = null)
    {
        $this->submittedAt = now()->timezone('Asia/Karachi')->format('M j, Y · g:i A').' PKT';
    }

    public function envelope(): Envelope
    {
        // From stays on our authenticated domain (SPF/DKIM); Reply-To is the visitor, so
        // pressing "Reply" in the inbox writes straight back to the person who submitted the form.
        return new Envelope(
            from: new Address(config('mail.from.address'), $this->data['name'].' via '.config('mail.from.name')),
            subject: '🔔 New lead: '.$this->data['name'].(! empty($this->data['service']) ? ' — '.$this->data['service'] : ''),
            replyTo: ! empty($this->data['email']) ? [new Address($this->data['email'], $this->data['name'])] : [],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.booking');
    }
}