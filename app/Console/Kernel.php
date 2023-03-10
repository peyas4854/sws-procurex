<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        $schedule->command('fetch:costcenter')
        ->dailyAt('05:00');
        $schedule->command('fetch:department')
        ->dailyAt('06:00');
        $schedule->command('fetch:designation')
        ->dailyAt('07:00');
        $schedule->command('fetch:employee')
        ->dailyAt('08:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
