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
        // $schedule->command('inspire')->hourly();

        // Run the command to add pending contributions daily
        $schedule->command('contributions:add-pending')->daily();

        // Run the command to process accepted loan requests daily
        $schedule->command('loans:process-accepted')->daily();

        // Run the command to update loan amounts after payments daily
        $schedule->command('loans:update-after-payment')->daily();

        // Run the command to process share transfers daily
        $schedule->command('shares:process-transfers')->daily();

        // Run the command to check and mark completed loans daily
        $schedule->command('loans:check-and-mark-completed')->daily();
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
