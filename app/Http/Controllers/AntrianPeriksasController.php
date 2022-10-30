<?php

namespace App\Http\Controllers;

use Input;

use Illuminate\Http\Request;
use Log;
use Session;
use Carbon\Carbon;
use DB;
use Bitly;
use App\Models\Asuransi;
use App\Models\Antrian;
use App\Models\HubunganKeluarga;
use App\Models\VerifikasiWajah;
use App\Rules\cekGDSDiNurseStationRequired;
use App\Models\Generik;
use Rule;
use App\Models\Staf;
use App\Models\Poli;
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
	public $input_pasien;
	public $input_poli_id;
	public $input_staf_id;
	public $input_jam;
	public $input_antrianpoli;
	public $input_menyusui;
	public $input_bukan_peserta;
	public $input_sex;
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
    public $input_g;
    public $previous_complaint_resolved;

	public function __construct() {
		$this->input_antrian_id            = Input::get('antrian_id');
		$this->input_antrian_poli_id       = Input::get('antrian_poli_id');
		$this->input_sistolik              = Input::get('sistolik');
		$this->input_diastolik             = Input::get('diastolik');
		$this->input_kecelakaan_kerja      = Input::get('kecelakaan_kerja');
		$this->input_asuransi_id           = Input::get('asuransi_id');
		$this->input_berat_badan           = Input::get('berat_badan');
		$this->input_hamil                 = Input::get('hamil');
		$this->input_asisten_id            = Input::get('asisten_id');
		$this->input_pasien_id             = Input::get('pasien_id');
		$this->input_poli_id               = Input::get('poli_id');
		$this->input_staf_id               = Input::get('staf_id');
		$this->input_jam                   = Input::get('jam');
		$this->input_menyusui              = Input::get('menyusui');
		$this->input_bukan_peserta         = Input::get('bukan_peserta');
		$this->input_riwayat_alergi_obat   = Input::get('riwayat_alergi_obat');
		$this->input_suhu                  = Input::get('suhu');
		$this->input_G                     = Input::get('G');
		$this->input_P                     = Input::get('P');
		$this->input_A                     = Input::get('A');
		$this->input_sex                   = Input::get('sex');
		$this->input_hpht                  = Input::get('hpht');
	    $this->input_tanggal               = Input::get('tanggal');
		$this->input_tinggi_badan          = Input::get('tinggi_badan');
		$this->input_gds                   = Input::get('gds');
		$this->input_tekanan_darah         = Input::get('tekanan_darah');
		$this->input_perujuk_id            = Input::get('perujuk_id');
        $this->input_g                     = Input::get('G');
        $this->input_a                     = Input::get('A');
        $this->input_p                     = Input::get('P');
        $this->previous_complaint_resolved = Input::get('previous_complaint_resolved');
        /* $this->middleware('nomorAntrianUnik', ['only' => ['store']]); */
        /* $this->middleware('super', ['only' => ['delete','update']]); */
    }
	public function index()
	{
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
	public function store(Request $request, $id) {
        DB::beginTransaction();
        try {
            $antrianpoli = AntrianPoli::with('pasien', 'asuransi')->where( 'id',  $id )->where('submitted', '0')->first();
            if (is_null($antrianpoli)) {
                $pesan = Yoga::gagalFlash('Antrian sudah masuk antrian periksa');
                return redirect()->back()->withPesan($pesan);
            }
            $rules = [
                'asisten_id'             => 'required',
                'gds'                    => Rule::requiredIf( $this->cekGDSDiNurseStation($antrianpoli) ),
                'G'                      => Rule::requiredIf( Input::get('hamil') == 1  ),
                'P'                      => Rule::requiredIf( Input::get('hamil') == 1  ),
                'A'                      => Rule::requiredIf( Input::get('hamil') == 1  ),
                'hpht'                   => Rule::requiredIf( Input::get('hamil') == 1  ),
                'sistolik'               => Rule::requiredIf( $this->harusCekTekananDarah($antrianpoli) ),
                'diastolik'              => Rule::requiredIf( $this->harusCekTekananDarah($antrianpoli) ),
                'pengantars'             => Rule::requiredIf(  Input::get('pengantars') !== '[]'  ),
                'kecelakaan_kerja'       => 'required',
                'hamil'                  => 'required',
                'menyusui'               => 'required',
                'peserta_klinik'         => 'required',
                'verifikasi_wajah'       => 'required',
                'sex'                    => 'required',
                'verifikasi_alergi_obat' => 'required',
            ];

            $validator = \Validator::make(Input::all(), $rules, [
                'gds.required'       => 'Gula Darah Harus Diisi Karena pasien ini prolanis DM',
                'sistolik.required'  => 'Sistolik Harus Diisi Karena pasien ini prolanis HT',
                'diastolik.required' => 'Diastolik Harus Diisi Karena pasien ini prolanis HT',
            ]);

            if ($validator->fails())
            {
                return \Redirect::back()->withErrors($validator)->withInput();
            }
            
            //validate json

            $data = Input::get('pengantars');
            $data = json_decode( $data, true );

            $input = [
                'data'          => $data,
            ];

            $rules = [
                'data.*.pasien_id'            => 'required',
                'data.*.hubungan_keluarga_id' => 'required|numeric',
            ];
            
            $validator = \Validator::make($input, $rules);
            
            if ($validator->fails())
            {
                return \Redirect::back()->withErrors($validator)->withInput();
            }

            if ($antrianpoli == null) {
                $pesan = Yoga::gagalFlash('Pasien sudah hilang dari antrian poli, mungkin sudah dimasukkan sebelumnya');
                return redirect()->back()->withPesan($pesan);
            }

            $this->input_asuransi_id = $antrianpoli->asuransi_id;
            $this->input_pasien_id   = $antrianpoli->pasien_id;
            $this->input_poli_id     = $antrianpoli->poli_id;
            $this->input_staf_id     = $antrianpoli->staf_id;
            $this->input_jam         = $antrianpoli->jam;
            $this->input_tanggal     = !is_null($antrianpoli->tanggal)?Carbon::parse($antrianpoli->tanggal)->format('d-m-Y') : null;
            $this->input_pasien      = $antrianpoli->pasien;
            $this->input_antrianpoli = $antrianpoli;
            $this->inputData();

            DB::commit();
            return \Redirect::route('antrianpolis.index')->withPesan(Yoga::suksesFlash('<strong>' .$antrianpoli->pasien->id . ' - ' . $antrianpoli->pasien->nama . '</strong> berhasil masuk antrian periksa'));
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
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
        $p->poli_id = Poli::where('poli', 'Poli Estetika')->first()->id;
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
    public function create($id){
        $antrian_poli = AntrianPoli::with('pasien')->where('id',$id)->first();
        if (is_null($antrian_poli)) {
            $pesan = Yoga::gagalFlash('Nurse Station Poli Sudah dikerjakan dan sudah masuk antrian periksa');
            return redirect()->back()->withPesan($pesan);
        }
        $asuransi_list          = Asuransi::pluck('nama', 'id');
        $staf_list              = Staf::pluck('nama', 'id');
        $poli_list              = Poli::pluck('poli', 'id');
        $verifikasi_wajah_list  = VerifikasiWajah::pluck('verifikasi', 'id');
        $hubungan_keluarga_list = HubunganKeluarga::all();

        $cekGDSDiNurseStation = $this->cekGDSDiNurseStation($antrian_poli);

        $kecelakaan_kerja_list = [
            0 => 'Bukan Kecelakaan Kerja',
            1 => 'Kecelakaan Kerja',
        ];
        $generik_list = Generik::pluck('generik', 'id');
        return view('antrianperiksas.create', compact(
            'antrian_poli',
            'verifikasi_wajah_list',
            'hubungan_keluarga_list',
            'cekGDSDiNurseStation',
            'asuransi_list',
            'generik_list',
            'staf_list',
            'kecelakaan_kerja_list',
            'poli_list',
        ));
    }
    /**
     * undocumented function
     *
     * @return void
     */
    public function cekGDSDiNurseStation($antrian_poli) {
        if (
            $antrian_poli->asuransi->tipe_asuransi_id != 5 || 
            $antrian_poli->pasien->prolanis_dm < 1
        ) {
            return false;
        }
        $bulanIni = date('Y-m');
        $query  = "SELECT * ";
        $query .= "FROM transaksi_periksas as trx ";
        $query .= "JOIN jenis_tarifs as jtf on jtf.id = trx.jenis_tarif_id ";
        $query .= "JOIN periksas as prx on prx.id = trx.periksa_id ";
        $query .= "WHERE prx.pasien_id = {$antrian_poli->pasien_id} ";
        $query .= "AND prx.tanggal like '{$bulanIni}%' " ;
        $query .= "AND jtf.jenis_tarif = 'Gula Darah';" ;
        $data = DB::select($query);

        if (
            $antrian_poli->pasien->prolanis_dm && 
            $antrian_poli->asuransi->tipe_asuransi_id == 5 &&
            count($data) < 1 
        ){
            return true;
        }
    }

    public function harusCekTekananDarah($antrian_poli) {
        return $antrian_poli->pasien->prolanis_ht > 0 && $antrian_poli->asuransi->tipe_asuransi_id == 5;
    }
    public function salahIdentifikasiPasien($id){
        $antrian_poli                          = AntrianPoli::with('antrian')->where('id', $id)->first();
        $pasien                                = $antrian_poli->pasien;
        $antrian_poli->antrian->antriable_type = 'App\Models\Antrian';
        $antrian_poli->antrian->antriable_id   = $antrian_poli->antrian->id;
        $antrian_poli->antrian->save();
        $antrian_id = $antrian_poli->antrian->id;
        $antrian_poli->delete();

        Session::put('pesan',Yoga::gagalFlash( 'Pasien atas nama <strong></strong> dihapus dari antrian karena wajah dengan foto pasien di aplikasi tidak sama. Silahkan daftarkan ulang'));
        return $antrian_id;
    }
    public function updateFotoPasien(){
        Session::put('pesan',Yoga::gagalFlash( 'Foto pasien harus di update karena tidak jelas terlihat'));
    }
    public function getHubunganKeluargaId(){
        $pasien_id = Input::get('pasien_id');
        $pasien = Pasien::find($pasien_id);
        return [
            'hubungan_keluarga_id' => $pasien->hubungan_keluarga_id,
            'kepala_keluarga_id' => $pasien->kepala_keluarga_id
        ];
    }
    public function inputData(){
        $periksa_awal 			= Yoga::periksaAwal( 
                                                        $this->input_sistolik . '/' . $this->input_diastolik . ' mmHg', 
                                                        $this->input_berat_badan, 
                                                        $this->input_suhu, 
                                                        $this->input_tinggi_badan
                                                    );

        $ap = new AntrianPeriksa;
        $kecelakaan_kerja = $this->input_kecelakaan_kerja;
        $asuransi_id      = $this->input_asuransi_id;

        $ap->berat_badan  = $this->input_berat_badan;
        $ap->hamil        = $this->input_hamil;
        $ap->menyusui     = $this->input_menyusui;
        $ap->asisten_id   = $this->input_asisten_id;
        $ap->periksa_awal = $periksa_awal;
        if ($kecelakaan_kerja == '1' && $this->is_asuransi_bpjs()) {
            $asuransi_id = Asuransi::BiayaPribadi()->id;
            $ap->keterangan = 'Pasien ini tadinya pakai asuransi BPJS tapi diganti menjadi Biaya Pribadi karena Kecelakaan Kerja / Kecelakaan Lalu Lintas tidak ditanggung BPJS, tpi PT. Jasa Raharja';
        }
        $ap->asuransi_id       = $this->input_asuransi_id;
        $ap->pasien_id         = $this->input_pasien_id;
        $ap->poli_id           = $this->input_poli_id;
        $ap->staf_id           = $this->input_staf_id;
        $ap->jam               = $this->input_jam;
        if ( $this->is_asuransi_bpjs ) {
            $ap->bukan_peserta = $this->input_bukan_peserta;
        }
        $ap->suhu                        = $this->input_suhu;
        $ap->tanggal                     = convertToDatabaseFriendlyDateFormat($this->input_tanggal);
        $ap->kecelakaan_kerja            = $this->input_kecelakaan_kerja;
        $ap->sistolik                    = $this->input_sistolik;
        $ap->diastolik                   = $this->input_diastolik;
        $ap->tinggi_badan                = $this->input_tinggi_badan;
        $ap->gds                         = $this->input_gds;
        $ap->g                           = $this->input_g;
        $ap->p                           = $this->input_p;
        $ap->a                           = $this->input_a;
        $ap->hpht                        = !empty( $this->input_hpht ) ? Carbon::createFromFormat('d-m-Y', $this->input_hpht)->format('Y-m-d') :null;
        $ap->previous_complaint_resolved = $this->previous_complaint_resolved;
        $ap->perujuk_id                  = $this->input_perujuk_id;
        $ap->save();

        /* if (isset( $this->input_antrianpoli )) { */
        $pasien          = $this->input_pasien;
        $pasien->sex     = $this->input_sex;
        $pasien->save();

        $families = Pasien::where('kepala_keluarga_id', $pasien->kepala_keluarga_id)->get();
        $pasien_ids_anggota_keluarga = [];
        foreach ($families as $f) {
            $pasien_ids_anggota_keluarga[] = $f->id;
        }
        $pengantars = is_null(Input::get('pengantars'))? '[]': Input::get('pengantars');
        $pengantars = json_decode($pengantars, true);
        $masukkan_dalam_daftar_keluarga = [];
        $masukkan_sebagai_pengantar = [];
        foreach ($pengantars as $pengantar) {
            if (!in_array($pengantar['pasien_id'], $pasien_ids_anggota_keluarga)) {
                $masukkan_dalam_daftar_keluarga[] = $pengantar['pasien_id'];
            }
            $masukkan_sebagai_pengantar[] = [
                'pengantar_id' => $pengantar['pasien_id'],
                'kunjungan_sehat' => 1,
                'pcare_submit' => 0,
            ];
            $pengantar_pasien                       = Pasien::find( $pengantar['pasien_id'] );
            $pengantar_pasien->hubungan_keluarga_id = $pengantar['hubungan_keluarga_id'];
            $pengantar_pasien->save();
        }


        Pasien::whereIn('id', $masukkan_dalam_daftar_keluarga)->update([
            'kepala_keluarga_id' => $pasien->kepala_keluarga_id
        ]);

        $newKepalaKeluarga = Pasien::where('kepala_keluarga_id', $pasien->kepala_keluarga_id)->orderBy('hubungan_keluarga_id', 'asc')->first();

        Pasien::where('kepala_keluarga_id', $pasien->kepala_keluarga_id)->update([
            'kepala_keluarga_id' => $newKepalaKeluarga->id
        ]);

        $ap->antars()->createMany($masukkan_sebagai_pengantar);

        $antrian =!is_null( $this->input_antrianpoli)? $this->input_antrianpoli->antrian :Antrian::find( $this->input_antrian_id );  

        /* dd( $ap->id ); */
        if(isset($antrian)){
            $antrian->antriable_id   = $ap->id;
            $antrian->antriable_type = 'App\\Models\\AntrianPeriksa';
            $antrian->save();
        }

        if (!is_null( $this->input_antrianpoli )) {
            $this->input_antrianpoli->delete();
        }

        $antrian_poli_id = $this->input_antrian_poli_id;

        $promo = Promo::where('promoable_type' , 'App\Models\AntrianPoli')->where('promoable_id', $antrian_poli_id)->first() ;
        if ( $promo ) {
            $promo->promoable_type = 'App\Models\AntrianPeriksa';
            $promo->promoable_id = $ap->id;
            $promo->save();
        }
        return $ap;
        /* } */
    }

    /**
     * undocumented function
     *
     * @return void
     */
    private function is_asuransi_bpjs()
    {
        return !empty(Input::get('asuransi_id')) ? Asuransi::find( Input::get('asuransi_id') )->tipe_asuransi_id == 5: false;
;
    }
    
}
