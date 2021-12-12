<?php

namespace App\Console;

use App\Jobs\NewsletterJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new NewsletterJob())
            ->saturdays()
            ->at('08:00')
            ->description('Newsletter job')
            ->emailOutputOnFailure('admin@admin.com');

        $schedule->command('song:genre-clean')
            ->dailyAt('00:00')
            ->description('clean unused genre')
            ->emailOutputOnFailure('admin@admin.com');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
