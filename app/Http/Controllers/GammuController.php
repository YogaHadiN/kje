<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Inbox;
use App\Outbox;
use App\PesanMasuk;
use App\PesanKeluar;
use App\Sentitem;
use App\Classes\Yoga;

class GammuController extends Controller
{
    public function inbox(){
		$inbox = Inbox::paginate(20);
		return view('gammu.inbox', compact('inbox'));
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
			'text' => 'required',
			'no_telp' => 'required|numeric'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}	

		$o       = new Outbox;
		$o->Text   = Input::get('text');
		$o->DestinationNumber   = Input::get('no_telp');
		$confirm = $o->save();
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Pengiriman Pesan <strong>BERHASIL</strong> dilakukan');
		} else {
			$pesan = Yoga::gagalFlash('Pengiriman Pesan <strong>GAGAL</strong> dilakukan');
		}
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
