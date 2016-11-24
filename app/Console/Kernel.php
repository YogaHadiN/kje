<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\AntrianPoli;
use DateTime;

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
		 Commands\smsLaporanHarian::class,
		 Commands\smsDonnaruko::class,
		 Commands\smsIngatkanJanji::class,

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
				  ->hourly();
		 $schedule->command('test:periksahilang')
					->dailyAt('22:00'); 
		 $schedule->command('sms:laporanharian')
					->dailyAt('23:00'); 
		 $schedule->command('sms:donnaruko')
			 ->dailyAt('13:00')
			 ->when(function(){
				return date('Y-m-d')  == '2017-09-30';
			 }); 
		 $schedule->command('sms:ingatkanJanji')
			 ->dailyAt('13:00')
			 ->when(function(){
				$ap = new AntrianPoli;
				$antrianpolis = $ap->besokKonsulGigi();
				$count = $antrianpolis->count();
				return $count > 0;
			 }); 
    }
}
