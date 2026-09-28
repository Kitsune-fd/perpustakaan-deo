<?php

namespace App\Mail;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class BookLoanNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $loan;

    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('no-reply@smkn2-medan.go.id', 'Sistem Perpustakaan SMKN 2 Medan'),
            subject: 'Peminjaman Berhasil',
            // replyTo: [new Address('support@domainkamu.com', 'Support')],
            // cc: [...],
            // bcc: [...],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.loans.success',
            with: [
                'name' => $this->loan->user->name,
                'title' => $this->loan->book->title,
                'loan_date' => $this->loan->loaned_date->format('d M Y'),
                'due_date' => $this->loan->due_date->format('d M Y'),
                'code' => $this->loan->code,
                'id' => $this->loan->id,
                ]
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
            // Attachment::fromPath(storage_path('app/public/invoice.pdf'))
            //     ->as('faktur-'.time().'.pdf')
            //     ->withMime('application/pdf'),
            
            // atau dari storage:
            // Attachment::fromStorage('public/foto-profil.jpg'),
        ];
    }
}
