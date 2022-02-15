<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Antrian;
use App\Models\JenisAntrian;
use App\Models\Classes\Yoga;
use Carbon\Carbon;

class AntriansController extends Controller
{
	public function create(){
		return view('antrians.create');
	}
	public function store(){
		try {
			$antrian = Antrian::where('created_at', date('Y-m-d') . '%')->firstOfFail();
			$a->antrian_terakhir = (int) $a->antrian_terakhir + 1;
			$a->save();
		} catch (\Exception $e) {
			$antrian                   = new Antrian;
			$antrian->antrian_terakhir = 1;
			$antrian->save();
		}
		return $a->antrian_terakhir;
	}
	public function whatsappRegistration(){
		return $this->belongsTo('App\Models\WhatsappRegistration');
	}

	public function destroy($id){
		$antrian               = Antrian::with('jenis_antrian')->where('id', $id)->first();
		$nomor_antrian         = $antrian->nomor_antrian;
		$pesan                 = Yoga::suksesFlash('Antrian ' . $nomor_antrian . ' BERHASIL dihapus');
		$whatsapp_registration = $antrian->whatsapp_registration;

		if ( isset( $$whatsapp_registration ) ) {
			$message = 'Mohon maaf antrian pendaftaran anda melalui whatsapp telah dihapus, Anda dapat mengulangi lagi pada saat anda sudah tiba di klinik' ;
			Sms::send( $$whatsapp_registration->no_telp, $message);
			$whatsapp_registration->delete();
		}
		$apc              = new AntrianPolisController;
		$apc->updateJumlahAntrian(false);
		$antrian->delete();
		return redirect()->back()->withPesan($pesan);
	}
}
