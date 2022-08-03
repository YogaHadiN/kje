<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\AntrianPoli;
use App\Models\Kontrol;
use App\Models\AntrianPeriksa;
use App\Models\Ac;
use DateTime;
use DB;
use Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected $commands = [
		 Commands\JadwalPenyusutan::class,
		 Commands\smsUndanganprolanis::class,
		 Commands\cronTest::class,
		 Commands\smsLaporanHarian::class,
		 Commands\refrestAntrianTiapHari::class,
		 Commands\smsDonnaruko::class,
		 Commands\smsIngatkanJanji::class,
		 Commands\smsIngatkanHariIni::class,
		 Commands\smsKontrol::class,
		 Commands\testcommand::class,
		 Commands\testConsole::class,
		 Commands\gammuSend::class,
		 Commands\smsCekInbox::class,
		 Commands\piutangAsuransiBelumDibayar3Bulan::class,
		 Commands\testJurnal::class,
		 /* Commands\dbBackup::class, */
		 Commands\refreshKunjunganPasien::class,
		 Commands\dbHapusdiskon::class,
		 Commands\sendMeLaravelLog::class,
		 Commands\imageResize::class,
		 Commands\imageAlat::class,
		 Commands\imageEstetika::class,
		 Commands\imageObat::class,
		 Commands\imageLain::class,
		 Commands\imageFit::class,
		 Commands\imagePasien::class,
		 Commands\imageStaf::class,
		 Commands\perbaikiJurnal::class,
		 /* Commands\smsPanggilTukanAc::class, */
		 Commands\testNeraca::class,
		 Commands\inputdata::class,
		 /* Commands\smsPromoUlangTahun::class, */
		 Commands\pphDokter::class,
		 Commands\undangProlanisDMTiapSabtu::class,
		 Commands\scheduleBackup::class,
		 Commands\multiPenyusutan::class,
		 Commands\cekMutasi::class,
		 Commands\cekMutasi19Terakhir::class,
		 Commands\susutDuaTahunLalu::class
		 /* Commands\smsAngkakontak::class, */
    ];

    protected function schedule(Schedule $schedule)
    {
		 $schedule->command('cek:mutasi20terakhir')
				  ->hourly();
		 $schedule->command('whatsapp:prolanis_dm')
					->weekly()
					->saturdays()
					->at('10:00');
		 $schedule->command('cek:mutasi')
				  ->dailyAt('23:50');
		 /* $schedule->command('cron:test') */
				  /* ->everyMinute(); */
		 $schedule->command('task:penyusutan')
				  ->monthlyOn(date('t'), '15:00');
		 $schedule->command('db:refreshKunjunganPasien')
				  ->monthlyOn(1, '01:00');
		 /* $schedule->command('sms:promoUlangTahun') */
				  /* ->monthlyOn('1', '14:00'); */
		 $schedule->command('db:hapusDiskon')
				  ->dailyAt('23:50');
		 $schedule->command('refresh:antrian')
				  ->dailyAt('23:59');
		 $schedule->command('test:neraca')
				  ->dailyAt('01:00');
		 $schedule->command('sms:piutangReminder')
				  ->cron('00 09 * * 1,3');
		 /* $schedule->command('sms:angkakontak') */
					/* ->dailyAt('15:30'); */ 
		 $schedule->command('test:jurnal')
					->dailyAt('23.30'); 
		 $schedule->command('sms:laporanharian')
					->dailyAt('23:00'); 
		 $schedule->command('send:melaravelLog')
					->dailyAt('01:00'); 
		 $schedule->command('db:scheduleBackup')
					->dailyAt('02:15'); 
		 $schedule->command('pph:dokter')
			 ->dailyAt('01:15')
			 ->when(function(){
				return date('d')  == '02';
			 }); 
		 $schedule->command('sms:ingatkanJanji')
			 ->dailyAt('13:00')
			 ->when(function(){
				$ap = new AntrianPoli;
				$antrianpolis = $ap->besokKonsulGigi();
				$count = $antrianpolis->count();
				return $count > 0;
		 }); 

		 $schedule->command('sms:panggilTukangAc')
			 ->dailyAt('13:30')
			 ->when(function(){
				$date			= new DateTime(date('Y-m-d'));
				$date->modify('-90 day');
				$query  = "SELECT max(created_at) as tanggal, ac_id ";
				$query .= "FROM service_acs ";
				/* $query .= "WHERE tenant_id = " . session()->get('tenant_id') . " "; */
				$query .= "GROUP BY ac_id ";
				$query .= "ORDER BY created_at desc";
				$data   = DB::select($query);
				$ids    = [];
				foreach ($data as $d) {
					if ($d->tanggal < $date->format('Y-m-d')) {
						$ids[] = $d->ac_id;
					}
				}
				$acs = Ac::all();
				foreach ($acs as $ac) {
					if ( $ac->serviceAc->count() == 0 && $ac->created_at < $date->format('Y-m-d H:i:s')) {
						$ids[] = $ac->id;	
					}
				}
				return count( $ids ) > 0;
		 }); 
		 $schedule->command('sms:ingatkanHariIni')
			 ->dailyAt('12:30')
			 ->when(function(){
                 $poli_gigi_id = Poli::where('poli', 'poli gigi')->first()->id;
				 $countAntrianPoli = AntrianPoli::where('poli_id', $poli_gigi_id)
					 ->where('tanggal', date('Y-m-d'))
					 ->count();
				 $countAntrianPeriksa = AntrianPeriksa::where('poli_id', $poli_gigi_id)
					 ->where('tanggal', date('Y-m-d'))
					 ->count();
				return ( (int)$countAntrianPoli + (int)$countAntrianPeriksa ) > 0;
			 }); 

		 $schedule->command('sms:kontrol')
			 ->dailyAt('13:01')
			 ->when(function(){
				$kontrol = new Kontrol;
				$kontrols = $kontrol->besokKontrol();
				$count = $kontrols->count();
				return $count > 0;
		 }); 
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
