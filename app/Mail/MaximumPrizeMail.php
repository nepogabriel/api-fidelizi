<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MaximumPrizeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public $customer,
        public $prize
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Aproveite! Resgate nosso maior prêmio.',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.maximum-prize',
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
