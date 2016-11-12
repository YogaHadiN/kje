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
		 Commands\JadwalPenyusutan::class,
		 Commands\LogDemo::class,
		 Commands\smsAngkakontak::class,
		 Commands\smsUndanganprolanis::class,
		 Commands\cronTest::class,
		 Commands\testPeriksahilang::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		 $schedule->command('task:penyusutan')
				  ->monthlyOn(date('t'), '15:00');
		 $schedule->command('sms:angkakontak')
					->dailyAt('15:30'); 
		 $schedule->command('cron:test')
				  ->everyhour();
		 $schedule->command('test:periksahilang')
					->dailyAt('22:00'); 
    }
}
