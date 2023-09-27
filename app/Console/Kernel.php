<?php

namespace App\Console;

use App\Console\Commands\ProcessProducts;
use App\Console\Commands\ProductsRating;
use App\Console\Commands\SynchroPhotos;
use App\Console\Commands\SynchroSmartup;
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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command(SynchroPhotos::class)->everyFifteenMinutes();
        // $schedule->command(ProcessProducts::class)->hourly();
        // $schedule->command(ProductsRating::class)->twiceDaily();
        // $schedule->command(ProcessProducts::class)->everyMinute();
        // $schedule->command(SynchroSmartup::class)->everyTwoHours();
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
