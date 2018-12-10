<?php

namespace App\Console;

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
        // $schedule->command('inspire')
        //          ->hourly();

        // spatie/laravel-backup 数据备份定时任务
        if (app()->environment('production')) {
            $schedule->command('backup:run')->cron('0 */4 * * *'); // 每 4 个小时执行一次备份
            $schedule->command('backup:monitor')->dailyAt('03:00'); // 每天凌晨 3 点执行一次环境监控
            $schedule->command('backup:clean')->dailyAt('03:10'); // 每天凌晨 3 点10 分执行一次备份清理
        }


        // 一小时执行一次 「活跃用户」 数据生成的命令
        $schedule->command('larabbs::calculate-actice-user')->hourly();
        // 每日零时执行一次
        $schedule->command('larabbs:sync-user-actived-at')->dailyAt('00:00');
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
