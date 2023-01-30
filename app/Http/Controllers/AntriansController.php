<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Input;
use App\Models\Antrian;
use App\Models\JenisAntrian;
use App\Models\Classes\Yoga;
use App\Models\WhatsappRegistration;

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
    public function edit($id){
        $antrian = Antrian::find($id);
        return view('antrians.edit', compact(
            'antrian'
        ));
    }
    public function update($id){
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'tanggal_lahir' =>'nullable|date_format:d-m-Y',
        ];

        $validator = \Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        $antrian = Antrian::find( $id );
        $antrian = $this->prosesData($antrian);

        $pesan = Yoga::suksesFlash('Antrian berhasil di update');
        return redirect()->back()->withPesan($pesan);
    }

    /**
     * undocumented function
     *
     * @return void
     */
    private function prosesData($antrian)
    {
        $antrian->nama = Input::get('nama');
        $antrian->tanggal_lahir = !empty( Input::get('tanggal_lahir')) ? Carbon::CreateFromFormat('d-m-Y', Input::get('tanggal_lahir'))->format('Y-m-d') : null;
        $antrian->nomor_bpjs = Input::get('nomor_bpjs');
        $antrian->no_telp = convertToWablasFriendlyFormat( Input::get('no_telp') );
        $antrian->save();
        return $antrian;
    }
	public function destroy($id){
		$antrian               = Antrian::with('jenis_antrian')->where('id', $id)->first();
        if (is_null($antrian)) {
            $pesan = Yoga::gagalFlash('Antrian tidak ditemukan');
            return redirect()->back()->withPesan($pesan);
        }
		$nomor_antrian         = $antrian->nomor_antrian;
		$pesan                 = Yoga::suksesFlash('Antrian ' . $nomor_antrian . ' BERHASIL dihapus');
		$whatsapp_registration = $antrian->whatsapp_registration;

		if ( isset( $$whatsapp_registration ) ) {
			$message = 'Mohon maaf antrian pendaftaran anda melalui whatsapp telah dihapus, Anda dapat mengulangi lagi pada saat anda sudah tiba di klinik' ;
			Sms::send( $$whatsapp_registration->no_telp, $message);
			$whatsapp_registration->delete();
		}
		$apc              = new AntrianPolisController;
		$apc->updateJumlahAntrian(false, null);
		$antrian->delete();
		return redirect()->back()->withPesan($pesan);
	}
}
