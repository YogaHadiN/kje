<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\AntrianPoli;
use App\Kontrol;
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
		 Commands\smsLaporanHarian::class,
		 Commands\smsDonnaruko::class,
		 Commands\smsIngatkanJanji::class,
		 Commands\smsKontrol::class,
		 Commands\testcommand::class,
		 Commands\testConsole::class,
		 Commands\gammuSend::class,
		 Commands\smsCekInbox::class,
		 Commands\resetAntrian::class,
		 Commands\testJurnal::class,
		 Commands\dbBackup::class,
		 Commands\dbHapusdiskon::class,
		 Commands\dbInsertDiskon::class,

    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		 if (gethostname() != 'dell') {
			 $schedule->command('task:penyusutan')
					  ->monthlyOn(date('t'), '15:00');
			 $schedule->command('db:hapusDiskon')
					  ->dailyAt('23:50');
			 $schedule->command('sms:angkakontak')
						->dailyAt('15:30'); 
			 $schedule->command('test:jurnal')
						->dailyAt('23.30'); 
			 $schedule->command('cron:test')
					  ->hourly();
			 $schedule->command('sms:laporanharian')
						->dailyAt('23:00'); 
			 $schedule->command('reset:antrian')
						->dailyAt('00:00'); 
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
			 $schedule->command('sms:ingatkanHariIni')
				 ->dailyAt('13:30')
				 ->when(function(){
					 $count = AntrianPoli::where('poli', 'gigi')
						 ->where('tanggal', date('Y-m-d'))
						 ->count();
					return $count > 0;
				 }); 

			 $schedule->command('sms:kontrol')
				 ->dailyAt('13:00')
				 ->when(function(){
					$kontrol = new Kontrol;
					$kontrols = $kontrol->besokKontrol();
					$count = $kontrols->count();
					return $count > 0;
			 }); 
		}
    }
}
