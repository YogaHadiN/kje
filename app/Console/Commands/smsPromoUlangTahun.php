<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pasien;
use App\Models\Sms;

class smsPromoUlangTahun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:promoUlangTahun';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promo Yang berulang Tahun Bulan ini';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$bulan = date('m');
		$tahun = date('Y');

		$tahunLahir =(int)$tahun -17;
		$pasiens = Pasien::where('tanggal_lahir', 'like', '%-' . $bulan . '-%')
							->where('tanggal_lahir', '<=', $tahunLahir . '-' . $bulan . '-' . date('t'))
							->where('no_telp' , 'like', '08%')
							->orderBy('tanggal_lahir')
							->groupBy('no_telp')
							->get();
		$count = $pasiens->count();
		$pesan = 'Diskon 20% Treatment Facial atau Microdermabrasi Diamond di ' . env("NAMA_KLINIK") . ' khusus Anda yang berulang tahun bulan ini.Berlaku bulan ini.S&K berlaku';

		foreach ($pasiens as $ps) {
			Sms::send( $ps->no_telp, $pesan );
		}
		Sms::send(env('NO_HP_OWNER'), $pesan);
		Sms::send(env('NO_HP_OWNER'), 'Tekirim sms promo ke ' . $count . ' pasien');
    }
}
