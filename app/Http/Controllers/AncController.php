<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Models\RegisterHamil;

use App\Models\Classes\Yoga;

class AncController extends Controller
{

	public function registerhamil(){

		$g = Input::get('G');
		$pasien_id = Input::get('pasien_id');

		$data = null;

		try {
			$reg = RegisterHamil::where('G', $g)->where('pasien_id', $pasien_id)->firstOrFail();
			$hpht = $reg->hpht;
			$data = [
				'hpht'                         => Yoga::updateDatePrep($hpht),
				'uk'                           => Yoga::umurKehamilan($hpht, date('Y-m-d')),
				'tanggal_lahir_anak_terakhir'  => Yoga::updateDatePrep($reg->tanggal_lahir_anak_terakhir),
				'golongan_darah'               => $reg->golongan_darah,
				'rencana_penolong'             => $reg->rencana_penolong,
				'rencana_tempat'               => $reg->rencana_tempat,
				'rencana_pendamping'           => $reg->rencana_pendamping,
				'rencana_transportasi'         => $reg->rencana_transportasi,
				'rencana_pendonor'             => $reg->rencana_pendonor,
				'riwayat_kehamilan_sebelumnya' => $reg->riwayat_persalinan_sebelumnya,
				'tb'                           => $reg->tinggi_badan,
				'jumlah_janin'                 => $reg->jumlah_janin,
				'status_imunisasi_tt_id'       => $reg->status_imunisasi_tt_id,
				'nama_suami'                   => $reg->nama_suami,
				'g'                            => $reg->g,
				'p'                            => $reg->p,
				'a'                            => $reg->a,
				'buku'                         => $reg->buku,
				'bb_sebelum_hamil'             => $reg->bb_sebelum_hamil
			];
		} catch (\Exception $e) {
			
		}
		return $data;

	}

	public function perujx(){
		// $data = Input::all();

		$pr 			= new Perujuk;
		$pr->nama 		= Input::get('nama');
		$pr->alamat 	= Input::get('alamat');
		$pr->no_telp 	= Input::get('no_telp');
		$pr->save();

		// return $pr->id;

		if ($pr->id) {
			$data = [
				'success' => '1',
				'id'	  => $pr->id
			];
		} else {

			$data = [
				'success' => '0',
				'id'	  => 'false'
			];
		}

		return json_encode($data);
	}


	public function uk(){
		
		$hpht = Input::get('hpht');

		$hpht = Yoga::datePrep($hpht);


		$umur_kehamilan = Yoga::umurKehamilan($hpht, date('Y-m-d'));

		return $umur_kehamilan;

	}

}
