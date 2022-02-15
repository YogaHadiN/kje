<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Input;
use App\Models\Mesabot;
use App\Models\Sms;
use App\Models\SmsJangan;
use App\Models\SmsGagal;
use App\Models\Pasien;
use App\Models\Config;
use App\Models\Classes\Yoga;
use App\Models\SmsKontak;
use App\Models\Staf;
use DB;
use twilio\rest\client;
use twilio\exceptions\twilioexception;
class SmsController extends Controller
{

	public function sms(){
		//return env('TWILLIO_NUMBER');
		return view('sms.index');
	}
	public function smsPost(){
		$rules = [
			'nomor' => 'required',
			'pesan' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Sms::send( Input::get('nomor'), Input::get('pesan'));

		$pesan = Yoga::suksesFlash('Pengiriman pesan ke nomor ' . Input::get('nomor'). ' berhasil');
		return redirect()->back()->withPesan($pesan);
	}
	public function smsBpjs($id){
		Sms::smsBpjs(Pasien::find($id), 'okelah kalau begitu');
	}

	public function smsSingle( $number, $message ){
		try {
			// 1 phone number
			$data = [
				'destination' => $number,
				'text' => $message
			];

			// boradcast

			$mesabot = new Mesabot;
			$mesabot->sms($data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function smsBroadcast( $number_array, $message ){
		try {
			// boradcast
			$data = [
				'destination' => $number_array,
				'text' => $message
			];

			$mesabot = new Mesabot;
			$mesabot->sms($data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	
	public function laporan(){

		$tanggall = Input::get('bulanTahun');
		$tanggal  = Yoga::blnPrep($tanggall);
		$sms_kontak = SmsKontak::where('created_at', $tanggal . '%')
								->where('pcare_submit', '0')
								->get();
		$sms_masuk = SmsKontak::where('created_at', $tanggal . '%')
								->where('pcare_submit', '1')
								->get();
		$sms_kontak = SmsGagal::where('created_at', $tanggal . '%')->get();
		return view('sms/laporan', compact(
			'sms_kontak', 
			'sms_gagal', 
			'sms_masuk'
		));
	}

	public function kontakulangi($id){

		$smskontak = SmsKontak::find($id);
		$nama = $smskontak->pasien->nama;
		$id = $smskontak->pasien_id;

		$confirm = $smskontak->delete();

		if ($confirm) {
			$pesan = Yoga::suksesFlash('Pasien bernama ' . $id . ' - ' . $nama . ' Berhasil masuk kembali ke list pengiriman');
		} else {
			$pesan = Yoga::gagalFlash('Pasien bernama ' . $id . ' - ' . $nama . ' Gagal masuk kembali ke list pengiriman');
		}

		return redirect()->back()->withPesan($pesan);
	}

	public function kontakgagal($id){
		$smskontak = SmsKontak::find($id);
		$smskontak->pcare_submit = '2';
		$confirm = $smskontak->save();
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Pasien bernama ' . $id . ' - ' . $nama . ' Gagal diinput di pcare');
		} else {
			$pesan = Yoga::gagalFlash('Pasien bernama ' . $id . ' - ' . $nama . ' Gagal diinput di pcare');
		}
		return redirect()->back()->withPesan($pesan);
	}

	public function kontakpcare_submit($id){
		$smskontak = SmsKontak::find($id);
		$smskontak->pcare_submit = '1';
		$confirm = $smskontak->save();
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Pasien bernama ' . $id . ' - ' . $nama . ' Gagal diinput di pcare');
		} else {
			$pesan = Yoga::gagalFlash('Pasien bernama ' . $id . ' - ' . $nama . ' Gagal diinput di pcare');
		}
		return redirect()->back()->withPesan($pesan);
	}
	public function smsKontakPost(){
		//return Input::get('pcare_submit');
		$rules = [
		  "id" => "required",
		  "pcare_submit" => "required"
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$sms               = SmsKontak::find( Input::get('id') );
		$sms->pcare_submit = Input::get('pcare_submit');
		$confirm = $sms->save();

		$this->smsJangan( Input::get('pcare_submit'), Input::get('id') );
		if ($confirm) {
			$pesan = Yoga::suksesFlash('SMS SUDAH di submit di pcare ');
		} else {
			$pesan = Yoga::gagalFlash('SMS BELUM di submit di pcare');
		}
		return redirect()->back()->withPesan($pesan);
	}
	public function smsGagalPost(){
		$rules = [
		  "id" => "required",
		  "pcare_submit" => "required"
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$sms               = SmsGagal::find( Input::get('id') );
		$sms->pcare_submit = Input::get('pcare_submit');
		$confirm = $sms->save();

		$this->smsJangan( Input::get('pcare_submit'), Input::get('id') );

		if ($confirm) {
			$pesan = Yoga::suksesFlash('SMS SUDAH di submit di pcare ');
		} else {
			$pesan = Yoga::gagalFlash('SMS BELUM di submit di pcare');
		}
		return redirect()->back()->withPesan($pesan);
	}
	public function smsMasukPost(){
		$rules = [
		  "id" => "required",
		  "pcare_submit" => "required"
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$sms               = SmsKontak::find( Input::get('id') );
		$sms->pcare_submit = Input::get('pcare_submit');
		$confirm = $sms->save();

		$this->smsJangan( Input::get('pcare_submit'), Input::get('id') );
		if ($confirm) {
			$pesan = Yoga::suksesFlash('SMS SUDAH di submit di pcare ');
		} else {
			$pesan = Yoga::gagalFlash('SMS BELUM di submit di pcare');
		}
		return redirect()->back()->withPesan($pesan);
	}
	
	
	private function smsJangan($pcare_submit, $id){
		$confirm = false;
		if ($pcare_submit > 1) {
			$coungSmsJangan = SmsJangan::where('pasien_id', $id)->count();
			if ($coungSmsJangan == 0) {
				$sms       = new SmsJangan;
				$sms->pasien_id   = $id;
				$confirm = $sms->save();
			}
		}
		return $confirm;
	}
}



    
