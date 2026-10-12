<?php

namespace App\Console\Commands;

use App\Enums\Status;
use App\Jobs\SendBookReturnReminder;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendDailyReturnReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:return';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim reminder pengembalian buku harian (1-3 hari lagi atau overdue)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        // Reminder 3 hari sebelum jatuh tempo
        $reminderDate = $today->copy()->addDays(3);

        // Reminder untuk yang mendekati jatuh tempo (H-3 s.d H-1)
        $nearDue = Loan::where('due_date', '>=', $today)
            ->where('due_date', '<=', $reminderDate)
            ->whereNull('returned_date')
            ->whereIn('status', [Status::LOANED, Status::OVERDUE])
            ->where(function ($q) use ($today) {
                $q->whereNull('last_reminder_sent_at')
                    ->orWhere('last_reminder_sent_at', '<', $today);
            })
            ->get();

        // Reminder untuk yang sudah lewat jatuh tempo (overdue)
        $overdue = Loan::where('due_date', '<', $today)
            ->whereNull('returned_date')
            ->whereIn('status', [Status::LOANED, Status::OVERDUE])
            ->where(function ($q) use ($today) {
                $q->whereNull('last_reminder_sent_at')
                    ->orWhere('last_reminder_sent_at', '<', $today);
            })
            ->get();

        $this->info("Mengirim reminder ke {$nearDue->count()} peminjaman mendekati jatuh tempo...");
        $this->info("Mengirim reminder overdue ke {$overdue->count()} peminjaman...");

        foreach ($nearDue->merge($overdue) as $loan) {
            SendBookReturnReminder::dispatch($loan);
        }

        $this->info('Semua reminder telah diproses!');
    }
}
