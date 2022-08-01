<?php

namespace App\Http\Controllers;

use Input;

use Illuminate\Http\Request;
use Log;
use Bitly;
use App\Models\Asuransi;
use App\Models\Staf;
use App\Models\Promo;
use App\Models\Sms;
use App\Models\BukanPeserta;
use App\Models\Classes\Yoga;
use App\Models\AntrianPeriksa;
use App\Models\Pasien;
use App\Models\AntrianPoli;
use App\Models\Kabur;
use App\Models\Periksa;
use App\Models\Terapi;
use App\Models\JurnalUmum;
use App\Models\TransaksiPeriksa;
use App\Models\Rujukan;
use App\Models\PengantarPasien;
use App\Models\SuratSakit;
use App\Models\RegisterAnc;
use App\Models\Usg;



class AntrianPeriksasController extends Controller
{
	/**
	 * Display a listing of antrianperiksas
	 *
	 * @return Response
	 */

	public $input_antrian_id;
	public $input_antrian_poli_id;
	public $input_sistolik;
	public $input_diastolik;
	public $input_kecelakaan_kerja;
	public $input_asuransi_id;
	public $input_berat_badan;
	public $input_hamil;
	public $input_asisten_id;
	public $input_pasien_id;
	public $input_poli_id;
	public $input_staf_id;
	public $input_jam;
	public $input_menyusui;
	public $input_bukan_peserta;
	public $input_riwayat_alergi_obat;
	public $input_suhu;
	public $input_G;
	public $input_P;
	public $input_A;
	public $input_hpht;
	public $input_tanggal;
	public $input_tinggi_badan;
	public $input_gds;
	public $input_tekanan_darah;
	public $input_perujuk_id;
	public $is_asuransi_bpjs;

	public function __construct() {
		$this->input_antrian_id          = Input::get('antrian_id');
		$this->input_antrian_poli_id     = Input::get('antrian_poli_id');
		$this->input_sistolik            = Input::get('sistolik');
		$this->input_diastolik           = Input::get('diastolik');
		$this->input_kecelakaan_kerja    = Input::get('kecelakaan_kerja');
		$this->input_asuransi_id         = Input::get('asuransi_id');
		$this->input_berat_badan         = Input::get('berat_badan');
		$this->input_hamil               = Input::get('hamil');
		$this->input_asisten_id          = Input::get('asisten_id');
		$this->input_pasien_id           = Input::get('pasien_id');
		$this->input_poli_id                = Input::get('poli_id');
		$this->input_staf_id             = Input::get('staf_id');
		$this->input_jam                 = Input::get('jam');
		$this->input_menyusui            = Input::get('menyusui');
		$this->input_bukan_peserta       = Input::get('bukan_peserta');
		$this->input_riwayat_alergi_obat = Input::get('riwayat_alergi_obat');
		$this->input_suhu                = Input::get('suhu');
		$this->input_G                   = Input::get('G');
		$this->input_P                   = Input::get('P');
		$this->input_A                   = Input::get('A');
		$this->input_hpht                = Input::get('hpht');
	    $this->input_tanggal             = Input::get('tanggal');
		$this->input_tinggi_badan        = Input::get('tinggi_badan');
		$this->input_gds                 = Input::get('gds');
		$this->input_tekanan_darah       = Input::get('tekanan_darah');
		$this->input_perujuk_id       = Input::get('perujuk_id');
        $this->is_asuransi_bpjs = !empty(Input::get('asuransi_id')) ? Asuransi::find( Input::get('asuransi_id') )->tipe_asuransi_id == 5: false;
        /* $this->middleware('nomorAntrianUnik', ['only' => ['store']]); */
        /* $this->middleware('super', ['only' => ['delete','update']]); */
    }
	public function index()
	{
        dd( 'o' );
		$asu = array('0' => '- Pilih Asuransi -') + Asuransi::pluck('nama', 'id')->all();

		$jenis_peserta = array(

			null => ' - pilih asuransi -',
            "P" => 'Peserta',
            "S" => 'Suami',
            "I" => 'Istri',
            "A" => 'Anak'

					);

		$staf            = array('0' => '- Pilih Staf -') + Staf::pluck('nama', 'id')->all();
		$poli            = Yoga::poliList();
		$staf_list       = Staf::list();
		$antrianperiksas = AntrianPeriksa::with('periksa.pasien', 'periksa.staf', 'antrian')->get();

		return view('antrianperiksas.index', compact(
			'antrianperiksas',
			'poli',
			'staf_list'
		));
	}


	/**
	 * Store a newly created antrianperiksa in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$rules = [
			'staf_id'          => 'required',
			'asisten_id'       => 'required',
			'kecelakaan_kerja' => 'required',
			'hamil'            => 'required',
			'staf_id'          => 'required',
			'pasien_id'        => 'required',
			'asuransi_id'      => 'required',
			'poli_id'             => 'required'
		];

		$validator = \Validator::make(Input::all(), $rules);

        /* dd( $validator->errors()->first() ); */
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		if (AntrianPoli::where( 'id',  $this->input_antrian_poli_id )->where('submitted', '0')->first() == null) {
			$pesan = Yoga::gagalFlash('Pasien sudah hilang dari antrian poli, mungkin sudah dimasukkan sebelumnya');
			return redirect()->back()->withPesan($pesan);
		}

		$periksa_awal 			= Yoga::periksaAwal( 
														$this->input_sistolik . '/' . $this->input_diastolik . ' mmHg', 
														$this->input_berat_badan, 
														$this->input_suhu, 
														$this->input_tinggi_badan
													);

		$ap = new AntrianPeriksa;
		
		$kecelakaan_kerja = $this->input_kecelakaan_kerja;
		$asuransi_id      = $this->input_asuransi_id;

		$ap->berat_badan         = $this->input_berat_badan;
		$ap->hamil               = $this->input_hamil;
		$ap->asisten_id          = $this->input_asisten_id;
		$ap->periksa_awal        = $periksa_awal;
		if ($kecelakaan_kerja == '1' && $this->is_asuransi_bpjs) {
			$asuransi_id = '0';
			$ap->keterangan = 'Pasien ini tadinya pakai asuransi BPJS tapi diganti menjadi Biaya Pribadi karena Kecelakaan Kerja / Kecelakaan Lalu Lintas tidak ditanggung BPJS, tpi PT. Jasa Raharja';
		}
		$ap->asuransi_id         = $asuransi_id;
		$ap->pasien_id           = $this->input_pasien_id;
		$ap->poli_id                = $this->input_poli_id;
		$ap->staf_id             = $this->input_staf_id;
		$ap->jam                 = $this->input_jam;
		$ap->menyusui            = $this->input_menyusui;
		if ( $this->is_asuransi_bpjs ) {
			$ap->bukan_peserta            = $this->input_bukan_peserta;
		}
		$ap->riwayat_alergi_obat = $this->input_riwayat_alergi_obat;
		$ap->suhu                = $this->input_suhu;
		$ap->g                   = Yoga::returnNull($this->input_G);
		$ap->p                   = Yoga::returnNull($this->input_P);
		$ap->a                   = Yoga::returnNull($this->input_A);
		$ap->hpht                = Yoga::datePrep($this->input_hpht);
		$ap->tanggal             = Yoga::datePrep( $this->input_tanggal );
		$ap->kecelakaan_kerja    = $kecelakaan_kerja;
		$ap->sistolik            = $this->input_sistolik;
		$ap->diastolik           = $this->input_diastolik;
		$ap->tinggi_badan        = $this->input_tinggi_badan;
		$ap->gds                 = $this->input_gds;
		$ap->perujuk_id                 = $this->input_perujuk_id;


		$ap->save();

		$antrian_poli_id         = $this->input_antrian_poli_id;
		$pasien                  = Pasien::find($this->input_pasien_id);
		$antrian_poli            = AntrianPoli::find($antrian_poli_id);
		$antrian                 = $antrian_poli->antrian;
		if(isset($antrian)){
			$antrian->antriable_id   = $ap->id;
			$antrian->antriable_type = 'App\\Models\\AntrianPeriksa';
			$antrian->save();
		}
		$antrian_poli->delete();

		$promo = Promo::where('promoable_type' , 'App\Models\AntrianPoli')->where('promoable_id', $antrian_poli_id)->first() ;
		if ( $promo ) {
			$promo->promoable_type = 'App\AntrianPeriksa';
			$promo->promoable_id = $ap->id;
			$promo->save();
		}

		PengantarPasien::where('antarable_id', $antrian_poli_id)
			->where('antarable_type', 'App\Models\AntrianPoli')
			->update([
				'antarable_id' => $ap->id,
				'antarable_type' => 'App\Models\AntrianPeriksa'
			]);


		return \Redirect::route('antrianpolis.index')->withPesan(Yoga::suksesFlash('<strong>' .$pasien->id . ' - ' . $pasien->nama . '</strong> berhasil masuk antrian periksa'));
	}


	/**
	 * Remove the specified antrianperiksa from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$ap               = AntrianPeriksa::with('antrian', 'pasien')->where('id',$id)->first();
        $jenis_antrian_id = $this->getJenisAntrianId($ap);
		$pasien_id        = $ap->pasien_id;
		$nama_pasien      = $ap->pasien->nama;

		$kabur            = new Kabur;
		$kabur->pasien_id = $ap->pasien_id;
		$kabur->alasan    = Input::get('alasan');
		$conf             = $kabur->save();

		$periksa = Periksa::where('antrian_periksa_id', $id)->first();
		if(isset($periksa)){
			TransaksiPeriksa::where('periksa_id', $periksa->id)->delete(); // Haput Transaksi bila ada periksa id
			Terapi::where('periksa_id', $periksa->id)->delete(); // Haput Terapi bila ada periksa id
			BukanPeserta::where('periksa_id', $periksa->id)->delete(); // Haput Terapi bila ada periksa id
			Rujukan::where('periksa_id', $periksa->id)->delete(); //hapus rujukan yang memiliki id periksa ini
			SuratSakit::where('periksa_id', $periksa->id)->delete(); // hapus surat sakit yang memiliki id periksa ini
			RegisterAnc::where('periksa_id', $periksa->id)->delete(); // hapus surat sakit yang memiliki id periksa ini
			Usg::where('periksa_id', $periksa->id)->delete(); // hapus surat sakit yang memiliki id periksa ini
			JurnalUmum::where('jurnalable_id', $periksa->id)
				->where('jurnalable_type', 'App\Models\Periksa')
				->delete(); // hapus jurnalumum yang dimiliki pasien ini
			Periksa::destroy($periksa->id);
		}
		$ap->delete();

		return redirect('ruangperiksa/' . $jenis_antrian_id)->withPesan(Yoga::suksesFlash('Pasien <strong>' . $pasien_id . ' - ' . $nama_pasien . '</strong> Berhasil dihapus dari antrian'  ));
	}

	private function periksaKosong($pasien_id, $staf_id, $asisten_id, $ap_id, $antrian, $jamdatang){
  		 $p       = new Periksa;
		  $p->asuransi_id = Asuransi::BiayaPribadi()->id;
		  $p->pasien_id =$pasien_id;
		  $p->berat_badan = "";
		  $p->poli = Poli::where('poli', 'Poli Estetika')->first()->id;
		  $p->staf_id =$staf_id;
		  $p->asisten_id =$asisten_id;
		  $p->periksa_awal = "[]";
		  $p->jam =$jamdatang;
		  $p->jam_resep = date('H:i:s');
		  $p->keterangan_diagnosa = "";
		  $p->antrian_periksa_id =$ap_id;
		  $p->resepluar = "";
		  $p->pemeriksaan_fisik = "";
		  $p->pemeriksaan_penunjang = "";
		  $p->tanggal =date('Y-m-d');
		  $p->terapi = "[]";
		  $p->antrian =$antrian;
		  $p->jam_periksa =date('H:i:s');
		  $p->jam_selesai_periksa =date('H:i:s');
		  $p->keterangan = "";
          $jt_jasa_dokter = JenisTarif::where('jenis_tarif', 'Jasa Dokter')->first();
          $jt_biaya_obat = JenisTarif::where('jenis_tarif', 'Biaya Obat')->first();
		  $p->transaksi = '[{"jenis_tarif_id":"' . $jt_jasa_dokter->id. '","jenis_tarif":"Jasa Dokter","biaya":0},{"jenis_tarif_id":"' .$jt_biaya_obat->id. '","jenis_tarif":"Biaya Obat","biaya":0}]';
		  $p->save();
	}

    protected $morphClass = 'App\Models\AntrianPeriksa';
    public function promos(){
        return $this->morphMany('App\Models\Promo', 'jurnalable');
    }
	public function editPoli($id){
		$messages = [
			'required' => ':attribute Harus Diisi',
		];

		$rules = [
			'poli_id' => 'required',
		];
		
		$validator = \Validator::make(Input::all(), $rules, $messages);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$ap       = AntrianPeriksa::find( $id );
		$ap->poli_id = Input::get('poli_id');
		$ap->save();

		$pesan = Yoga::suksesFlash('Pasien atas nama ' . $ap->pasien->nama . ' <strong>BERHASIL</strong> dipindah ke ' . $ap->poli->poli);
		return redirect()->back()->withPesan($pesan);
	}
	public function updateStaf(){
		$antrian_periksa_id      = Input::get('antrian_periksa_id');
		$staf_id                 = Input::get('staf_id');

		$antrianPeriksa          = AntrianPeriksa::find($antrian_periksa_id);
		$antrianPeriksa->staf_id = $staf_id;
		$antrianPeriksa->save();
	}
    public function getJenisAntrianId($ap){
		$jenis_antrian_id = '6';
		if (!is_null( $ap->antrian )) {
			$jenis_antrian_id = $ap->antrian->jenis_antrian_id;
		}
    }
    
}
