<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Inbox;
use App\Periksa;
use App\PesanMasuk;
use DB;

class smsCekInbox extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:cekInbox';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek Inbox sms tiap 5 menit sekali';

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
		$timestamp = date('Y-m-d H:i:s');
		$inbox = Inbox::all();
		$countInbox = $inbox->count();
		if ( $countInbox > 0 ) {
			$nomors = [];
			$deletes_ids = [];
			$masuks = [];
			foreach ($inbox as $i) {

				$nomor = $i->SenderNumber;
				$nomor = str_replace('+62', '0', $nomor);

				$TextDecoded = $i->TextDecoded;
				$TextDecoded = trim(strtolower(  $TextDecoded  ));
				if (substr($TextDecoded, 0, 1) === 't' || substr($TextDecoded, 0, 1) === 'n' || substr($TextDecoded, 0, 1) === 'g') {
					$satisfaction_index = 1;
				} else if(substr($TextDecoded, 0, 1) === 'p'){
					$satisfaction_index = 3;
				} else if(substr($TextDecoded, 0, 1) === 'k'){
					$Keberatan				= new Keberatan;
					$Keberatan->no_telp		= $nomor;
					$Keberatan->save();
					$Pasien					= Pasien::find(Periksa::find($periksa_id)->pasien_id);
					$Pasien->jangan_disms   = 1;
					$Pasien->save();
				} else {
					$satisfaction_index = 2;
				}

				if ( isset( $satisfaction_index ) ) {

					$query  = "SELECT pk.periksa_id FROM pesan_keluars as pk ";
					$query .= "join periksas as px on px.id = pk.periksa_id ";
					$query .= "join pasiens as ps on ps.id = px.pasien_id ";
					$query .= "where ps.no_telp ='" .$nomor. "' ";
					$query .= "ORDER BY px.created_at desc ";
					$query .= "LIMIT 1";
					$periksa_id = DB::select($query)[0]->periksa_id;

					$px						  = Periksa::find($periksa_id);
					$px->satisfaction_index   = $satisfaction_index;
					$px->save();
				}
				$masuks[] = [
					'pesan' => $message,
					'no_telp' => $nomor,
					'periksa_id' => $periksa_id,
					'created_at' => $timestamp,
					'updated_at' => $timestamp,
				];
				$deletes_ids[] = $i->id;
			}
			$confirm = PesanMasuk::insert($masuks);
			if ($confirm) {
				Inbox::destroy($deletes_ids);
			}
		}
    }
}
