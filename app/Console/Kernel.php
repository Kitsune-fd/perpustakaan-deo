<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Jalankan setiap hari jam 08:00 pagi (WIB)
        $schedule->command('reminders:return')
                ->everyMinute()
                // ->dailyAt('00:00')
                ->timezone('Asia/Jakarta');

        // Optional: cek setiap jam untuk overdue baru (kalau mau lebih agresif)
        // $schedule->command('reminders:return')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
