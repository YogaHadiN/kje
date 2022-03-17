<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AsuransisController;
use DB;
use Carbon\Carbon;
use App\Models\Classes\Yoga;
use App\Models\Sms;

class piutangAsuransiBelumDibayar3Bulan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:piutangReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder untuk piutang yang belum dibayar';

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
		\Log::info('==============================================================================');
		\Log::info('================MEMULAI SMS Reminder Piutang Asuransi=========================');
		\Log::info('==============================================================================');
        $asuransi = new AsuransisController;
		$query = $asuransi->queryHutang([
			'waktu' => '3bulan',
			'param' => date('Y-m-d')
		]);

		$data_piutang = DB::select($query);

        $pesan = "Data piutang yang belum dibayarkan hingga " . Carbon::createFromFormat('m-Y', date('m-Y'))->subMonths(3)->format('F Y') . ":";
        $pesan .= PHP_EOL;
        $pesan .= PHP_EOL;
        foreach ($data_piutang as $dp) {
			$pesan .= Carbon::createFromFormat('m-Y', $dp->bulan . '-' . $dp->tahun)->format('F Y');
			$pesan .= " ";
			$pesan .= Yoga::buatrp( $dp->piutang - $dp->sudah_dibayar );
            $pesan .= PHP_EOL;
        }
        Sms::send('081381912803', $pesan);
        Sms::send('085721012351', $pesan);
		\Log::info('==============================================================================');
		\Log::info('================Mengakhiri SMS Reminder Piutang Asuransi======================');
		\Log::info('==============================================================================');
    }
}
