<?php

namespace App\Jobs;

use App\Mail\BookReturnReminder;
use App\Mail\OverdueBookReminder;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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
        $isOverdue = Carbon::today()->gt($this->loan->due_date);

        $mailable = $isOverdue
            ? new OverdueBookReminder($this->loan)
            : new BookReturnReminder($this->loan);

        Mail::to($this->loan->user->email)->send($mailable);

        $this->loan->update(['last_reminder_sent_at' => now()]);
    }
}
