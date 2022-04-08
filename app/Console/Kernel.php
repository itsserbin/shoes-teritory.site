<?php

namespace App\Console;

use App\Console\Commands\ApiNovaPoshtaCommand;
use App\Console\Commands\OrdersStatisticCommand;
use App\Console\Commands\SumManagersSalary;
use App\Console\Commands\SumProfitCommand;
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
        SumManagersSalary::class,
        ApiNovaPoshtaCommand::class,
        SumProfitCommand::class,
        OrdersStatisticCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('orderStatistics:count')->everyFiveMinutes();
        $schedule->command('managers_salary:sum')->everyFiveMinutes();
        $schedule->command('api_nova_poshta:order_integration')->everyFiveMinutes();
        $schedule->command('profit:sum')->everyFiveMinutes();
        $schedule->command('marketing_statistic:sum')->everyFiveMinutes();
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
