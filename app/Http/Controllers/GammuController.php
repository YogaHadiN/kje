<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Input;
use App\Models\Inbox;
use App\Models\Sms;
use App\Models\Outbox;
use App\Models\PesanMasuk;
use App\Models\PesanKeluar;
use App\Models\Sentitem;
use App\Models\Classes\Yoga;

class GammuController extends Controller
{
    public function inbox(){

		$mulai = date("d/m/Y", strtotime("-1 month"));
		$akhir = date('d/m/Y');
		$url   = 'http://kje.zenziva.co.id/api/getinbox/?userkey=tlksgeo4nl9g3ujky2b8&passkey=4ur4y17q4xw0y2fam31l&start_date=' . $mulai . '&end_date=' . $akhir;
		$inbox = json_decode(file_get_contents($url), true);

		return $inbox;
		$message = $inbox['msg'];

		$no_telp_in_a_month = [];

		foreach($message as $m){
			$no_telp_in_a_month[] = $m['dari'];
		}

		return $no_telp_in_a_month;

		$mulai = date("d/m/Y", strtotime("-3 day"));
		$akhir = date('d/m/Y');
		$url   = 'http://kje.zenziva.co.id/api/getinbox/?userkey=tlksgeo4nl9g3ujky2b8&passkey=4ur4y17q4xw0y2fam31l&start_date=' . $mulai . '&end_date=' . $akhir;
		$inbox = json_decode(file_get_contents($url), true);
		$message = $inbox['msg'];
		return $message;
		return view('gammu.inbox', compact('message', 'mulai', 'akhir'));
    }

    public function pesanMasuk(){
		$inbox = PesanMasuk::paginate(20);
		return view('gammu.pesanMasuk', compact('inbox'));
    }

    public function pesanKeluar(){
		$outbox = PesanKeluar::paginate(20);
		return view('gammu.pesanKeluar', compact('outbox'));
    }
	public function outbox(){
		$outbox = Outbox::paginate(20);
		return view('gammu.outbox', compact('outbox'));
	}
	public function sentitem(){
		$sentitem = Sentitem::paginate(20);
		return view('gammu.sentitem', compact('sentitem'));
	}
	public function createSms(){
		return view('gammu.createSms');
	}
	public function reply($SenderNumber){
		return view('gammu.createSms', compact('SenderNumber'));
	}
	public function sendSms(){
		$rules = [
			'text'    => 'required',
			'no_telp' => 'required|numeric'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}	

		$text   = Input::get('text');
		$noTelp = Input::get('no_telp');

		$result = Sms::send($noTelp, $text);


		$pesan = Yoga::suksesFlash('Pengiriman Pesan <strong>BERHASIL</strong> dilakukan');
		return redirect('gammu/outbox')->withPesan($pesan);	
	}
	public function destroy($id){
		$confirm = Inbox::destroy($id);
		if ($confirm) {
			$pesan = Yoga::suksesFlash("Pesan berhasil dihapus");
		} else {
			$pesan = Yoga::gagalFlash("Pesan gagal dihapus");
		}
		return redirect('gammu/inbox')->withPesan($pesan);	
	}
}
