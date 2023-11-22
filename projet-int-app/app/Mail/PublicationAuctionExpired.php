<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Publication;

class PublicationAuctionExpired extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected Publication $publication, 
    )
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Enchère terminée: {$this->publication->title}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        //dd(url(`publication/detail/{$this->publication->id}`));
        //dd($this->changedAttributesArray);
        return new Content(
            view: 'emails.auction-expired',
            with:[
                'title' => $this->publication->title,
                'url' => url("publication/detail/{$this->publication->id}"),
            ],
            //text:'emails.publication.changed-text'
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
