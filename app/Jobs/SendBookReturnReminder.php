<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\BookReturnReminder;       // Mailable yang sudah kamu buat
use App\Models\Loan;
use Illuminate\Support\Facades\Mail;

class SendBookReturnReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $loan;
    /**
     * Create a new job instance.
     */
    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->loan->user->email)
            ->queue(new BookReturnReminder($this->loan));

        $this->loan->update(['last_reminder_sent_at' => now()]);
    }
}
