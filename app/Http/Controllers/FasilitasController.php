<?php

namespace App\Http\Controllers;

use Input;

use DB;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\PasiensController;
use App\Http\Controllers\AntrianPolisController;
use App\Http\Controllers\AntriansController;
use App\Http\Controllers\AntrianPeriksasController;
use App\Http\Controllers\QrCodeController;
use App\Http\Requests;
use App\Models\Fasilitas;
use App\Models\Asuransi;
use App\Models\Pasien;
use App\Models\Antrian;
use App\Models\Panggilan;
use App\Models\JurnalUmum;
use App\Models\Periksa;
use App\Models\AntrianPeriksa;
use App\Models\TransaksiPeriksa;
use App\Models\Kabur;
use App\Models\Staf;
use App\Models\Dispensing;
use App\Models\BukanPeserta;
use App\Models\AntrianPoli;
use App\Models\Classes\Yoga;
use App\Models\RumahSakit;
use App\Models\Terapi;
use App\Models\Rujukan;
use App\Models\SuratSakit;
use App\Models\RegisterAnc;
use App\Models\GambarPeriksa;
use App\Models\Usg;
use App\Models\Sms;
use App\Models\DeletedPeriksa;


class FasilitasController extends Controller
{
	public $input_nomor_bpjs;

	public function __construct(){
        $this->middleware('redirectBackIfIdAntrianNotFound', ['only' => ['prosesAntrian']]);
		$this->input_nomor_bpjs = Input::get('nomor_bpjs');
		$this->middleware('prolanisFlagging', ['only' => [
			 'postAntrianPoli'
		]]);
	}
	
    public function antrian_pasien(){
		$antrianperiksa = AntrianPeriksa::with('pasien')->take(10)->get(['pasien_id']);
		return view('fasilitas.antrian', compact('antrianperiksa'));
    }
    public function survey(){
		return view('surveys.survey');
    }

	public function input_telp(){
		return view('fasilitas.input_telp');
	}
	public function input_tgl_lahir($poli){
		return view('fasilitas.input_tgl_lahir', compact(
			'poli'
		));
	}
	public function post_tgl_lahir($poli){
		$tanggal = Yoga::datePrep( Input::get('tanggal_lahir') );
		$pasiens = Pasien::where('tanggal_lahir', $tanggal)->get();
		if ($pasiens->count() < 1) {
			$pesan = Yoga::gagalFlash('Tidak ada Pasien yang terdaftar dengan Tanggl Lahir ' . Input::get('tanggal_lahir') . '<br /><strong> Silahkan Ulangi Kembali </strong>');
			return redirect('fasilitas/antrian_pasien')->withPesan($pesan);
		}
		return view('fasilitas.cari_pasien', compact(
			'pasiens',
			'poli',
			'tanggal'
		));
	}
	public function cari_asuransi($poli, $pasien_id){
		$tanggal = Input::get('tanggal');
		$pasien  = Pasien::find($pasien_id);
		if (Poli::find($poli)->poli == 'Poli Estetika') {
			$pesan = $this->postAntrianPoli($poli, $pasien_id, 0);
			return redirect('fasilitas/antrian_pasien')->withPesan($pesan);
		}
		return view('fasilitas.cari_asuransi', compact(
			'tanggal',
			'poli',
			'pasien'
		));
	}
	public function submit_antrian($poli, $pasien_id, $asuransi_id){
		$pesan = $this->postAntrianPoli($poli, $pasien_id, $asuransi_id);
		return redirect('fasilitas/antrian_pasien')->withPesan($pesan);
	}
	public function postAntrianPoli($poli_id, $pasien_id, $asuransi_id){
		$antrianPoli = ( isset( AntrianPoli::latest()->first()->antrian ) )?  AntrianPoli::latest()->first()->antrian : null;
		$antrianPeriksa = ( isset( AntrianPeriksa::latest()->first()->antrian ) )? AntrianPeriksa::latest()->first()->antrian : null; 
		$antrian = [
			$antrianPeriksa,
			$antrianPoli
		];

        $asuransi             = Asuransi::find($asuransi_id);
		$antrian              = (int)max($antrian) + 1;
		$ap                   = new AntrianPoli;
		$ap->poli_id          = $poli_id;
		$ap->pasien_id        = $pasien_id;
		if ($asuransi_id     != 'x') {
			$ap->asuransi_id  = $asuransi_id;
		}
		$ap->tanggal       = date('Y-m-d');
		$ap->jam           = date('H:i:s');
		$ap->self_register = 1;
		$ap->asuransi_id   = $asuransi_id;
		$confirm           = $ap->save();
		if ($confirm) {
			$pesan = Yoga::suksesFlash( '<strong>' . $ap->pasien->id . ' - ' . $ap->pasien->nama . '</strong> Berhasil masuk antrian' );
			if ($asuransi_id != '0' && $asuransi->tipe_asuransi_id != 5) {
				$pesan .= " Mohon berikan kartu asuransi / pengantar berobat ke kasir";
			}
		} else {
			$pesan = Yoga::gagalFlash('<strong>' . $ap->pasien->id . ' - ' . $ap->pasien->nama . '</strong> Gagal masuk antrian');
		}			
		return $pesan;
	}
	
	
	public function konfirmasi(){
		$id = Input::get('konfirmasi_antrian_poli_id');
		$ap       = AntrianPoli::find($id);
		$ap->self_register   = null;
		$confirm = $ap->save();
		if ($confirm) {
			$pesan = Yoga::suksesFlash(''  . $ap->pasien_id . ' - ' . $ap->pasien->nama . ' <strong>BERHASIL</strong> ');
		} else {
			$pesan = Yoga::gagalFlash(''  . $ap->pasien_id . ' - ' . $ap->pasien->nama . ' <strong>GAGAL</strong> ');
		}
		return redirect()->back()->withPesan($pesan);
	}
	
	
	public function antrianPoliDestroy(){
		$rules = [
			'id'        => 'required',
			'pasien_id' => 'required',
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$kb            = new Kabur;
		$kb->pasien_id = Input::get('pasien_id');
		$kb->alasan    = Input::get('alasan_kabur');
		$kb->save();

		try {
			$ap = AntrianPoli::with('antrian')->findOrFail( Input::get('id') );
		} catch (\Exception $e) {
			$pesan = Yoga::gagalFlash('Antrian Tidak ditemukan, mungkin sudah dihapus sebelumnya');
			return redirect()->back()->withPesan($pesan);
		}

		$antrian = $ap->antrian;

		if ( isset($antrian) ) {
			$ac = new AntriansController;
		}

		$nama_pasien = $ap->pasien->nama;
		$confirm     = $ap->delete();

		if ($confirm) {
			$pesan = Yoga::suksesFlash('<strong>' . $nama_pasien . '</strong> Berhasil dihapus dari Antrian');
		} else {
			$pesan = Yoga::gagalFlash('<strong>' . $nama_pasien . '</strong> Gagal dihapus dari Antrian');
		}
		return redirect()->back()->withPesan($pesan);
	}
	public function antrianPeriksaDestroy(){
		$rules = [
			'id'           => 'required',
			'pasien_id'    => 'required',
			'alasan_kabur' => 'required',
			'staf_id'      => 'required'
		];
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		try {
			$last_kabur_id = (int)Kabur::orderBy('id', 'desc')->firstOrFail()->id + 1;
		} catch (\Exception $e) {
			$last_kabur_id = 1;
		}

		$send_sms            = false;
		$periksa_deleted_ids = [];
		$timestamp           = date('Y-m-d H:i:s');
		$deleted_periksas    = [];
		$id                  = Input::get('id');
		$ap                  = AntrianPeriksa::find($id);
		$pasien_id = $ap->pasien_id;
		$nama_pasien = $ap->pasien->nama_pasien;


		$kabur            = new Kabur;
		$kabur->pasien_id = Input::get('pasien_id');
		$kabur->staf_id   = Input::get('staf_id');
		$kabur->alasan    = Input::get('alasan_kabur');
		$terapi_deletes = [];
		DB::beginTransaction();
		try {
			$periksa = Periksa::with('pasien')->where('antrian_periksa_id', $id)->first();
			if($periksa != null && $periksa->lewat_kasir2 != 1){
				$terapis = Terapi::with('merek.rak')->where('periksa_id', $periksa->id)->get(); // Haput Terapi bila ada periksa id
				foreach ($terapis as $t) {
					$terapi_deletes[] = $t->id;
					$rak       = $t->merek->rak;
					$rak->stok = $rak->stok + $t->jumlah;
					$rak->save();
				}
				$periksa_deleted_ids[] = $periksa->id;
				$deleted_periksas[] = [
                    'staf_id'    => Input::get('staf_id'),
                    'pasien_id'  => $pasien_id,
                    'kabur_id'   => $last_kabur_id,
                    'periksa_id' => $periksa->id,
                    'tenant_id'  => session()->get('tenant_id'),
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
				];
			}
			$kabur->save();
			$antrian = $ap->antrian;

			$ac = new AntriansController;

			$ap->delete();
			DeletedPeriksa::insert($deleted_periksas);
			if ($periksa != null) {
				Sms::send(env('NO_HP_OWNER'), 'Telah dihapus pemeriksaan atas nama ' . $pasien_id . ' - ' . $nama_pasien . ' oleh ' . Staf::find( Input::get('staf_id') )->nama );
				TransaksiPeriksa::where('periksa_id', $periksa->id)->delete(); // Haput Transaksi bila ada periksa id
				Terapi::where('periksa_id', $periksa->id)->delete(); // Haput Terapi bila ada periksa id
				Dispensing::whereIn('dispensable_id', $terapi_deletes)
						->where('dispensable_type', 'App\Models\Terapi')
						->delete();
				BukanPeserta::where('periksa_id', $periksa->id)->delete(); // Haput Terapi bila ada periksa id
				Rujukan::where('periksa_id', $periksa->id)->delete(); //hapus rujukan yang memiliki id periksa ini
				SuratSakit::where('periksa_id', $periksa->id)->delete(); // hapus surat sakit yang memiliki id periksa ini
				RegisterAnc::where('periksa_id', $periksa->id)->delete(); // hapus surat sakit yang memiliki id periksa ini
				Usg::where('periksa_id', $periksa->id)->delete(); // hapus surat sakit yang memiliki id periksa ini
				GambarPeriksa::where('gambarable_id', $periksa->id)
							->where('gambarable_type', 'App\Models\Periksa')
							->delete(); // hapus gambar_periksas yang memiliki id periksa ini
				Periksa::destroy($periksa_deleted_ids);
			}
			DB::commit();
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
		return redirect()->back()->withPesan(Yoga::suksesFlash('Pasien <strong>' . $ap->pasien_id . ' - ' . $ap->pasien->nama . '</strong> Berhasil dihapus dari antrian'  ));
	}
	public function antrianPost($id){
		$antrians = Antrian::with('jenis_antrian')->where('created_at', 'like', date('Y-m-d') . '%')
							->where('jenis_antrian_id',$id)
							->where('tenant_id', 1)
							->orderBy('nomor', 'desc')
							->first();

		if ( is_null( $antrians ) ) {
			$antrian                   = new Antrian;
			$antrian->nomor            = 1 ;
			$antrian->tenant_id        = 1 ;
			$antrian->nomor_bpjs       = $this->input_nomor_bpjs;
			$antrian->jenis_antrian_id = $id ;

		} else {
			$antrian_terakhir          = $antrians->nomor + 1;
			$antrian                   = new Antrian;
			$antrian->tenant_id        = 1 ;
			$antrian->nomor            = $antrian_terakhir ;
			$antrian->nomor_bpjs       = $this->input_nomor_bpjs;
			$antrian->jenis_antrian_id = $id ;
		}
		$antrian->antriable_id   = $antrian->id;
		$antrian->kode_unik      = $this->kodeUnik();
		$antrian->antriable_type = 'App\\Models\\Antrian';
		$antrian->save();

		$apc                     = new AntrianPolisController;
		$apc->updateJumlahAntrian(false, null);
		return $antrian;
	}
	public function antrian($id){
		$antrian = $this->antrianPost( $id );
		/* return $antrian; */
		return redirect('fasilitas/antrian_pasien')
			->withPrint($antrian->id);
	}
	public function antrianAjax($id){

		$antrian       = $this->antrianPost( $id );
		$nomor_antrian = $antrian->jenis_antrian->prefix . $antrian->nomor;
        $kode_unik     = $antrian->kode_unik;
		$jenis_antrian = ucwords( $antrian->jenis_antrian->jenis_antrian );
		$timestamp     = date('Y-m-d H:i:s');

		$url    = url('/');
		$qr     = new QrCodeController;
        $qr_code = $qr->inPdf('https://wa.me/6282113781271?text=' . $kode_unik);


        return compact(
            'nomor_antrian', 
            'jenis_antrian', 
            'timestamp',
            'qr_code',
            'kode_unik'
        );
	}
	
	public function listAntrian(){
		$antrians = Antrian::with('jenis_antrian')->where('antriable_type', 'App\\Models\\Antrian')->get();
		return view('fasilitas.list_antrian', compact(
			'antrians'
		));
	}
    public function prosesAntrian($id)
    {
		$antrian              = Antrian::with('jenis_antrian.poli_antrian.poli')->where('id', $id )->first();
		$nama_pasien          = '';
		$pasien_id            = '';
		$tanggal_lahir_pasien = '';
		$asuransi_id          = '';
		$nama_asuransi        = '';
		$image                = '';
		$prolanis_dm          = '';
		$prolanis_ht          = '';

		try {

			$pasien               = Pasien::where('nomor_asuransi_bpjs', $antrian->nomor_bpjs)->firstOrFail();
			$nama_pasien          = $pasien->nama;
			$pasien_id            = $pasien->id;
			$tanggal_lahir_pasien = $pasien->tanggal_lahir;
			$asuransi_id          = $pasien->asuransi_id;
			$nama_asuransi        = $pasien->nama_asuransi;
			$image                = $pasien->image;
			$prolanis_dm          = $pasien->prolanis_dm;
			$prolanis_ht          = $pasien->prolanis_ht;

		} catch (\Exception $e) {
			
		}

		$p                                                    = new PasiensController;
		$polis[null]                                          = '-Pilih Poli-';
		foreach ($antrian->jenis_antrian->poli_antrian as $k => $poli) {
			$polis[ $poli->poli_id ]                          = $poli->poli->poli;
		}

		$p->dataIndexPasien['poli']                      = $polis;
		$p->dataIndexPasien['antrian']                   = $antrian;
		$p->dataIndexPasien['nama_pasien_bpjs']          = $nama_pasien;
		$p->dataIndexPasien['pasien_id_bpjs']            = $pasien_id;
		$p->dataIndexPasien['tanggal_lahir_pasien_bpjs'] = $tanggal_lahir_pasien;
		$p->dataIndexPasien['asuransi_id_bpjs']          = $asuransi_id;
		$p->dataIndexPasien['nama_asuransi_bpjs']        = $nama_asuransi;
		$p->dataIndexPasien['image_bpjs']                = $image;
		$p->dataIndexPasien['prolanis_dm_bpjs']          = $prolanis_dm;
		$p->dataIndexPasien['prolanis_ht_bpjs']          = $prolanis_ht;
		return $p->index();
	}
	public function antrianPoliPost($id, Request $request ){
		$apc = new AntrianPolisController;
		$apc->input_antrian_id   = $id;
		return $apc->store($request);
	}
	public function createPasien($id){
		$ps          = new PasiensController;
		$polis[null] = ' - Pilih Poli - ';
		$antrian     = Antrian::find( $id );
		foreach ($antrian->jenis_antrian->poli_antrian as $poli) {
			$polis[ $poli->poli_id ] = $poli->poli->poli;
		}
		$ps->dataCreatePasien['poli']    = $polis;
		$ps->dataCreatePasien['antrian'] = $antrian;
		return $ps->create();
	}
	public function storePasien(Request $request, $id){
		$pc = new PasiensController;
		$pc->input_antrian_id = $id;
		$pc->input_poli_id = Input::get('poli_id');
		return $pc->store($request);
	}
	public function getTambahAntrian($id){
		$antrian       = $this->antrianPost( $id );
		$nomor_antrian = $antrian->jenis_antrian->prefix . $antrian->nomor;
		$jenis_antrian = ucwords( $antrian->jenis_antrian->jenis_antrian );
		$pesan         = Yoga::suksesFlash(
			'Antrian baru <strong> ' . $nomor_antrian . '</strong> ke ' . $jenis_antrian . '	Berhasil ditambahkan'
		);
		return redirect()->back()->withPesan($pesan);
	}
    /**
     * undocumented function
     *
     * @return void
     */
    private function kodeUnik()
    {
        $kode_unik = substr(str_shuffle(MD5(microtime())), 0, 5);
        while (Antrian::where('created_at', 'like', date('Y-m-d') . '%')->where('kode_unik', $kode_unik)->exists()) {
            $kode_unik = substr(str_shuffle(MD5(microtime())), 0, 5);
        }
        return $kode_unik;
    }
    
}

