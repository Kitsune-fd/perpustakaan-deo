<?php

namespace App\Mail;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OverdueBookReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $loan;

    /**
     * Create a new message instance.
     */
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
            subject: 'Pemberitahuan: Buku Telat Dikembalikan - ' . $this->loan->book->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $overdueDays = max(1, (int) Carbon::today()->diffInDays($this->loan->due_date));
        $dailyFine = 1000;

        return new Content(
            view: 'emails.reminder.overdue',
            with: [
                'name' => $this->loan->user->name,
                'title' => $this->loan->book->title,
                'loan_date' => $this->loan->loaned_date->format('d M Y'),
                'due_date' => $this->loan->due_date->format('d M Y'),
                'code' => $this->loan->code,
                'overdue_days' => $overdueDays,
                'daily_fine' => $dailyFine,
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
        return [];
    }
}
