<?php

namespace App\Console;

use App\Console\Commands\ApiNovaPoshtaCommand;
use App\Console\Commands\DailyStatisticsCommand;
use App\Console\Commands\SumManagersSalary;
use App\Console\Commands\SumProfitCommand;
use App\Models\Bookkeeping\Costs;
use App\Models\Bookkeeping\OrdersDay;
use App\Models\Bookkeeping\Profit;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use App\Models\Enum\OrderStatus;

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
        DailyStatisticsCommand::class,
        SumProfitCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('daily_statistics:run')->everyMinute();
        $schedule->command('managers_salary:sum')->everyMinute();
        $schedule->command('profit:sum')->everyMinute();
        $schedule->command('api_nova_poshta:order_integration')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected
    function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
