<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use Carbon\Carbon;
use DB;

use App\Models\Promo;
use App\Models\Antrian;
use App\Models\AntrianKasir;
use App\Models\AntrianApotek;
use App\Models\AntrianFarmasi;
use App\Models\PesertaBpjsPerbulan;
use App\Models\Berkas;
use App\Models\Periksa;
use App\Models\Classes\Yoga;
use App\Models\Merek;
use App\Models\Pasien;
use App\Models\RegisterHamil;
use App\Models\BukanPeserta;
use App\Models\AntrianPeriksa;
use App\Models\Asuransi;
use App\Models\Terapi;
use App\Models\Staf;
use App\Models\Usg;
use App\Models\RegisterAnc;
use App\Models\GambarPeriksa;
use App\Models\PengantarPasien;
use App\Models\Tarif;
use App\Http\Controllers\CustomController;
use App\Http\Controllers\AntrianPeriksasController;
use Storage;

class PeriksasController extends Controller
{

	/**
	 * Display a listing of periksas
	 *
	 * @return Response
p */
	public $input_sistolik;
	public $input_diastolik;
	public $input_asuransi_id;
	public $input_pasien_id;
	public $input_prolanis_ht;
	public $persenRpptTerkendali;
	public $belum_ada_tekanan_darah_terkontrol;
	

  public function __construct()
    {
        $this->middleware('selesaiPeriksa', ['only' => ['update']]);
		$this->input_sistolik                     = Input::get('sistolik');
		$this->input_diastolik                    = Input::get('diastolik');
		$this->input_asuransi_id                  = Input::get('asuransi_id');
		$this->input_tanggal                      = Input::get('tanggal');
		$this->input_prolanis_ht                  = Input::get('prolanis_ht');
		$this->input_pasien_id                    = Input::get('pasien_id');
		$this->belum_ada_tekanan_darah_terkontrol = false;
   }
	public function index()
	{
		
		$periksas = Periksa::all();
		return view('periksas.index', compact('periksas'));
	}

	/**
	 * Show the form for creating a new periksa
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('periksas.create');
	}

	/**
	 * Store a newly created periksa in storage.
	 * 	
	 * @return Response
	 */
	public function store()
	{
		$rules = [
		  "kecelakaan_kerja"   => "required",
		  "asuransi_id"        => "required",
		  "hamil"              => "required",
		  "staf_id"            => "required",
		  "kali_obat"          => "required",
		  "pasien_id"          => "required",
		  "jam"                => "required",
		  "jam_periksa"        => "required",
		  "tanggal"            => "required",
		  "poli"               => "required",
		  "adatindakan"        => "required",
		  "asisten_id"         => "required",
		  "antrian_periksa_id" => "required",
		  "anamnesa"           => "required",
		  "diagnosa_id"        => "required"
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		//jika pasien sudah hilang dari antrian periksa, mungkin dia sudah diproses ke apotek
		$antrianperiksa = AntrianPeriksa::find( Input::get('antrian_periksa_id') );
		if( $antrianperiksa == null || Periksa::where('antrian_periksa_id', Input::get('antrian_periksa_id'))->count() > 0){
			$pesan = Yoga::gagalFlash('Pasien sudah tidak ada di antrianperiksa, mungkin sudah dimasukkan atau buatlah antrian yang baru');
			return redirect()->back()->withPesan($pesan);
		}
		//
		// return var_dump(json_decode(Input::get('terapi'), true));
		//Pada tahap ini ada beberapa yang perlu ditambahkan
		//BHP (Bahan Habis Pakai) ditambahkan dalam json transaksis bila tindakan tidak kosong
		//Biaya Obat ditambahkan ke dalam komponen transaksis bila terapis tidak kosonsg
		//Jasa dokter ditambahkan ke transaksis
		//Resep disesuaikan menurut formula dengan harga obat sesuai dengan jenis asuransi nya.
		//
		$periksa_id = Yoga::customId('App\Models\Periksa');
		$periksa = new Periksa;


		$pasien          = Pasien::find(Input::get('pasien_id'));
		//kumpulkan array yang akan di insert, delete atau update
		//

		$staf_updates    = [];
		$usgs            = [];
		$register_hamils = [];
		$register_ancs   = [];
		$gambar_updates  = [];
		$pasien_updates  = [];
		$hamil_updates   = [];
		$bukan_pesertas  = [];
		$terapiInserts   = [];
		$promo_updates   = [];
		$timestamp       = date('Y-m-d H:i:s');

		//
		//Bila asuransi adalah BPJS dan staf belum notified, maka buat notified = 1, supaya tidak muncul peringatan berulang2
		//

		if ( Input::get('asuransi_id') == '32' && Input::get('notified') == '0' ) {
			$st       = Staf::find( Input::get('staf_id') );
			$staf_updates[] = [
				'collection' => $st,
				'updates' => [
					'notified' => 1
				]
			];
		}

		//Buat collection tabel asuransi
		$asuransi = Asuransi::find(Input::get('asuransi_id'));

		//UBAH RESEP MENURUT JENIS ASURANSI
		//sebelum terapi dimasukkan ke dalam periksa, obat harus disesuaikan dahulu, menurut asuransi nya.
		// untuk asuransi BPJS, obat akan dikonversi ke dalam merek yang paling murah yang memiliki formula yang sama
		// untuk asuransi admedika, obat akan dikonversi ke dalam merek paling mahal dalam formula yang sama
		// return var_dump(json_decode(Input::get('terapi'), true));
		
		$terapis = $this->sesuaikanResep(Input::get('terapi'), $asuransi);
		//sesuaikan Transaksi
		//
		$transaksis = $this->sesuaikanTransaksi(Input::get('transaksi'), $asuransi, $terapis, Input::get('poli'));

		//INPUT TRANSAKSI JAM MALAM
		//JIKA PASIEN DATANG > JAM 10 MALAM, untuk pasien umum dan admedika, maka ditambah 10 ribu untuk jam malam
		if ((Input::get('jam') > '22:00:00' || Input::get('jam') < '06:00:00') && ($asuransi->id == 0 || $asuransi->tipe_asuransi == '3')) {
			//tambahkan komponen jam malam sebesar 10 ribu
			$plus = [
				'jenis_tarif_id' => '120',
				'jenis_tarif'    => 'Jam Malam',
				'biaya'          => 20000
			];
			array_push($transaksis, $plus);
		}

		// INPUT DATA PERIKSA FINAL!!!!!
		//
		//
		//
		$this->input_pasien = $pasien;
		$this->cekSudahAdaYangTerkontrolBulanIni();
		/* $this->hitungPersentaseRppt(); */
		$antrian_id = Input::get('antrian_id');

		/* $this->belum_ada_tekanan_darah_terkontrol = */ 
		//
		$periksa->id                    = $periksa_id;
		$periksa->anamnesa              = Input::get('anamnesa');
		$periksa->asuransi_id           = $asuransi->id;
		$periksa->diagnosa_id           = Input::get('diagnosa_id');
		$periksa->pasien_id             = Input::get('pasien_id');
		$periksa->berat_badan           = Input::get('berat_badan');
		$periksa->poli                  = Input::get('poli');
		$periksa->staf_id               = Input::get('staf_id');
		$periksa->asisten_id            = Input::get('asisten_id');
		$periksa->periksa_awal          = Input::get('periksa_awal');
		$periksa->jam                   = Input::get('jam');
		$periksa->jam_resep             = date('H:i:s');
		$periksa->keterangan_diagnosa   = Input::get('keterangan_diagnosa');
		$periksa->antrian_periksa_id    = Input::get('antrian_periksa_id');
		$periksa->resepluar             = Input::get('resepluar');
		$periksa->pemeriksaan_fisik     = Input::get('pemeriksaan_fisik');
		$periksa->pemeriksaan_penunjang = Input::get('pemeriksaan_penunjang');
		$periksa->tanggal               = Input::get('tanggal');
		$periksa->sistolik              = Yoga::returnNull( $this->sesuaikanSistolikBPJS() );
		$periksa->diastolik             = Yoga::returnNull( $this->sesuaikanDiastolikBPJS() );
		$periksa->terapi                = $this->terapisBaru($terapis);
		$periksa->jam_periksa           = Input::get('jam_periksa');
		$periksa->jam_selesai_periksa   = date('H:i:s');
		$periksa->keterangan            = Input::get('keterangan_periksa');
		$periksa->transaksi             = json_encode($transaksis);
		$periksa->prolanis_dm           = $pasien->prolanis_dm;
		$periksa->prolanis_ht           = $pasien->prolanis_ht;
		$periksa->antrian_id            = $antrian_id;

		$promo = Promo::where('promoable_type' , 'App\Models\AntrianPeriksa')->where('promoable_id', Input::get('antrian_periksa_id'))->first() ;
		if ( $promo ) {
			$promo_updates[] = [
				'collection' => $promo,
				'updates' => [
					'promoable_type' => 'App\Models\Periksa',
					'promoable_id'   => $periksa_id,
				]
			];
		}

		if ( Input::get('bukan_peserta') == '1' ) {

			$bukan_pesertas[] = [
				'periksa_id'         => $periksa_id,
				'antrian_periksa_id' => Input::get('antrian_periksa_id'),
				'created_at'         => $timestamp,
				'updated_at'         => $timestamp,
			];
		}

		//INPUT DATA UNTUK TERAPI
		//
		// return $terapis;
		$timestamp     = date('Y-m-d H:i:s');
		$merek_ids     = [];
		foreach (json_decode($terapis, true) as $k => $t) {
			$merek_ids[] = $t['merek_id'];
		}
		$merekArray = Merek::with('rak')->whereIn('id', $merek_ids)->get();
		$array = [];
		foreach ($merekArray as $v) {
			$array[$v->id] = $v;
		}

		foreach (json_decode($terapis, true) as $k => $t) {
			$terapiInserts[] = [
				'merek_id'          => $t['merek_id'],
				'signa'             => $t['signa'],
				'aturan_minum'      => $t['aturan_minum'],
				'jumlah'            => $t['jumlah'],
				'periksa_id'        => $t['jumlah'],
				'periksa_id'        => $periksa_id,
				'harga_beli_satuan' => $array[$t['merek_id']]->rak->harga_beli,
				'harga_jual_satuan' => Yoga::hargaJualSatuan($asuransi, $t['merek_id']),
				'created_at'        => $timestamp,
				'updated_at'        => $timestamp,
			];
		}

	if(Input::get('poli') == 'usg'){
		$usg_id = Yoga::customId('App\Models\Usg');
		
		$usgs[] = [
			'id'             => $usg_id,
			'periksa_id'     => $periksa_id,
			'perujuk_id'     => Input::get('perujuk_id'),
			'hpht'           => Yoga::datePrep(Input::get('hpht')),
			'umur_kehamilan' => Input::get('umur_kehamilan'),
			'gpa'            => Input::get('gpa'),
			'bpd'            => Input::get('BPD_w') . 'w ' . Input::get('BPD_d') . 'd',
			'hc'             => Input::get('HC_w') . 'w ' . Input::get('HC_d') . 'd',
			'ltp'            => Input::get('LTP'),
			'djj'            => Input::get('FHR'),
			'ac'             => Input::get('AC_w') . 'w ' . Input::get('AC_d') . 'd',
			'efw'            => Input::get('EFW') . ' gr',
			'fl'             => Input::get('FL_w') . 'w ' . Input::get('FL_d') . 'd',
			'bpd_mm'         => Input::get('BPD_mm'),
			'ac_mm'          => Input::get('AC_mm'),
			'FL_mm'          => Input::get('FL_mm'),
			'HC_mm'          => Input::get('HC_mm'),
			'sex'            => Input::get('Sex'),
			'ica'            => Input::get('total_afi'),
			'plasenta'       => Input::get('Plasenta'),
			'presentasi'     => Input::get('presentasi'),
			'kesimpulan'     => Input::get('kesimpulan'),
			'saran'          => Input::get('saran'),
		];

		$pasien_updates[] = [
			'collection' => $pasien,
			'updates' => [
				'riwayat_kehamilan_sebelumnya' => Input::get('riwayat_kehamilan_sebelumnya')
			]
		];
	}
	if (Input::get('poli') == 'anc' || Input::get('poli') == 'usg') {
		$hamil = RegisterHamil::where('g', Input::get('G'))->where('pasien_id', Input::get('pasien_id'))->first();

		if (!$hamil) {
			try {
				$last_register_hamil = (int)RegisterHamil::orderBy('id', 'desc')->first()->id + 1;
			} catch (\Exception $e) {
				$last_register_hamil = 1;
			}
			$register_hamils[] = [
				'id'                            => $last_register_hamil,
				'pasien_id'                     => Input::get('pasien_id'),
				'nama_suami'                    => Input::get('nama_suami'),
				'tb'                            => Input::get('tb'),
				'buku_id'                       => Input::get('buku'),
				'golongan_darah'                => Input::get('golongan_darah'),
				'tinggi_badan'                  => Input::get('tb'),
				'bb_sebelum_hamil'              => Input::get('bb_sebelum_hamil'),
				'g'                             => Input::get('G'),
				'p'                             => Input::get('P'),
				'a'                             => Input::get('A'),
				'riwayat_persalinan_sebelumnya' => Input::get('riwayat_kehamilan'),
				'hpht'                          => Yoga::datePrep(Input::get('hpht')),
				'status_imunisasi_tt_id'        => Input::get('status_imunisasi_tt_id'),
				'rencana_penolong'              => Input::get('rencana_penolong'),
				'jumlah_janin'                  => Input::get('jumlah_janin'),
				'rencana_tempat'                => Input::get('rencana_tempat'),
				'rencana_pendamping'            => Input::get('rencana_pendamping'),
				'rencana_transportasi'          => Input::get('rencana_transportasi'),
				'rencana_pendonor'              => Input::get('rencana_pendonor'),
				'tanggal_lahir_anak_terakhir'   => Yoga::datePrep(Input::get('tanggal_lahir_anak_terakhir')),
			];
		} else {
			$last_register_hamil = $hamil->id;
			$hamil_updates[] = [
				'collection' => $hamil,
				'updates' => [
					'pasien_id'                     => Input::get('pasien_id'),
					'nama_suami'                    => Input::get('nama_suami'),
					'tb'                            => Input::get('tb'),
					'buku_id'                       => Input::get('buku'),
					'golongan_darah'                => Input::get('golongan_darah'),
					'tinggi_badan'                  => Input::get('tb'),
					'bb_sebelum_hamil'              => Input::get('bb_sebelum_hamil'),
					'g'                             => Input::get('G'),
					'p'                             => Input::get('P'),
					'a'                             => Input::get('A'),
					'riwayat_persalinan_sebelumnya' => Input::get('riwayat_kehamilan'),
					'jumlah_janin'                  => Input::get('jumlah_janin'),
					'status_imunisasi_tt_id'        => Input::get('status_imunisasi_tt_id'),
					'hpht'                          => Yoga::datePrep(Input::get('hpht')),
					'rencana_penolong'              => Input::get('rencana_penolong'),
					'rencana_tempat'                => Input::get('rencana_tempat'),
					'rencana_pendamping'            => Input::get('rencana_pendamping'),
					'rencana_transportasi'          => Input::get('rencana_transportasi'),
					'rencana_pendonor'              => Input::get('rencana_pendonor'),
					'tanggal_lahir_anak_terakhir'   => Yoga::datePrep(Input::get('tanggal_lahir_anak_terakhir'))
				]
			];
		}
		$register_ancs[] = [
			'periksa_id'               => $periksa_id,
			'register_hamil_id'        => $last_register_hamil,
			'td'                       => Input::get('td'),
			'tfu'                      => Input::get('tfu'),
			'lila'                     => Input::get('lila'),
			'bb'                       => Input::get('bb'),
			'refleks_patela_id'        => Input::get('refleks_patela'),
			'djj'                      => Input::get('djj'),
			'kepala_terhadap_pap_id'   => Input::get('kepala_terhadap_pap_id'),
			'presentasi_id'            => Input::get('presentasi_id'),
			'catat_di_kia'             => Input::get('catat_di_kia'),
			'inj_tt'                   => Input::get('inj_tt'),
			'fe_tablet'                => Input::get('fe_tablet'),
			'periksa_hb'               => Input::get('periksa_hb'),
			'protein_urin'             => Input::get('protein_urin'),
			'gula_darah'               => Input::get('gula_darah'),
			'thalasemia'               => Input::get('thalasemia'),
			'sifilis'                  => Input::get('sifilis'),
			'hbsag'                    => Input::get('hbsag'),
			'pmtct_konseling'          => Input::get('pmtct_konseling'),
			'pmtct_periksa_darah'      => Input::get('pmtct_periksa_darah'),
			'pmtct_serologi'           => Input::get('pmtct_serologi'),
			'pmtct_arv'                => Input::get('pmtct_arv'),
			'malaria_periksa_darah'    => Input::get('malaria_periksa_darah'),
			'malaria_positif'          => Input::get('malaria_positif'),
			'malaria_dikasih_obat'     => Input::get('malaria_dikasih_obat'),
			'malaria_dikasih_kelambu'  => Input::get('malaria_dikasih_kelambu'),
			'tbc_periksa_dahak'        => Input::get('tbc_periksa_dahak'),
			'tbc_positif'              => Input::get('tbc_positif'),
			'tbc_dikasih_obat'         => Input::get('tbc_dikasih_obat'),
			'komplikasi_hdk'           => Input::get('komplikasi_hdk'),
			'komplikasi_abortus'       => Input::get('komplikasi_abortus'),
			'komplikasi_perdarahan'    => Input::get('komplikasi_perdarahan'),
			'komplikasi_infeksi'       => Input::get('komplikasi_infeksi'),
			'komplikasi_kpd'           => Input::get('komplikasi_kpd'),
			'komplikasi_lain_lain'     => Input::get('komplikasi_lain_lain'),
			'rujukan_tiba_masih_hidup' => Input::get('rujukan_tiba_masih_hidup'),
			'rujukan_tiba_meninggal'   => Input::get('rujukan_tiba_meninggal'),
			'rujukan_puskesmas'        => '2',
			'rujukan_RB'               => '2',
			'rujukan_RSIA_RSB'         => '2',
			'rujukan_RS'               => '2',
			'rujukan_lain'             => '2',
			'rujukan_tiba_masih_hidup' => '1',
			'rujukan_tiba_meninggal'   => '1',
		];
	}

		//UPDATE pengantar tambahkan periksa_id
		//
		//

		$poli = Input::get('poli');
		if ($poli == 'sks' || $poli == 'luka') {
			$poli = 'umum';
		} else if ($poli == 'KB 1 Bulan' || $poli == 'KB 3 Bulan' ){
			$poli='kandungan';
		}
		$cs = new CustomController;

		DB::beginTransaction();
		try {
			RegisterHamil::insert($register_hamils);
			Terapi::insert($terapiInserts);
			Usg::insert($usgs);
			RegisterAnc::insert($register_ancs);
			BukanPeserta::insert($bukan_pesertas);
			$cs->massUpdate($staf_updates);
			$cs->massUpdate($hamil_updates);
			$antrian = $antrianperiksa->antrian;
			$cs->massUpdate($promo_updates);
			$cs->massUpdate($pasien_updates);
			$periksa->save();
			$this->updateTemplate(
				Input::get('antrian_periksa_id'), 
				$periksa_id, 
				$periksa
			);

			if ( Input::get('asuransi_id') == '32' ) { // jika asuransi BPJS
				$pasien                          = $periksa->pasien;
				$pasien->sudah_kontak_bulan_ini = 1;
				$pasien->save();
			}
			DB::commit();
			if($antrian){
				$ruang_periksa_id = $antrian->jenis_antrian_id;
			} else {
				$ruang_periksa_id = 5;
			}
			return redirect('ruangperiksa/' . $ruang_periksa_id)->withPesan(Yoga::suksesFlash('<strong>' . $pasien->id . ' - ' . $pasien->nama . '</strong> Selesai Diperiksa' ));
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
	}

	/**
	 * Display the specified periksa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{	
		$periksa = Periksa::with('terapii.merek', 'jurnals.coa', 'transaksii.jenisTarif', 'berkas')->where('id',$id)->first();
		/* return $periksa->pembayarans; */
		$cs = new CustomController;
		$warna = $cs->warna;

		return view('periksas.show', compact(
			'warna',
			'periksa'
		));
	}

	/**
	 * Show the form for editing the specified periksa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$periksa = Periksa::find($id);
		return view('periksas.edit', compact('periksa'));
	}

	/**
	 * Update the specified periksa in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		DB::beginTransaction();
		try {
			$antrian_periksa_id = Input::get('antrian_periksa_id');
			$antrianperiksa     = AntrianPeriksa::find($antrian_periksa_id);
			if (!is_null($antrianperiksa)) {
				$periksa = Periksa::find($id);
				//Buat collection tabel asuransi
				//
				$asuransi =Asuransi::find(Input::get('asuransi_id'));
				//UBAH RESEP MENURUT JENIS ASURANSI
				//sebelum terapi dimasukkan ke dalam periksa, obat harus disesuaikan dahulu, menurut asuransi nya.
				// untuk asuransi BPJS, obat akan dikonversi ke dalam merek yang paling murah yang memiliki formula yang sama
				// untuk asuransi admedika, obat akan dikonversi ke dalam merek paling mahal dalam formula yang sama
				$terapis = $this->sesuaikanResep(Input::get('terapi'), $asuransi);


				//sesuaikan Transaksi
				$transaksis = $this->sesuaikanTransaksi(Input::get('transaksi'), $asuransi, $terapis, Input::get('poli'));
			

				// INPUT DATA PERIKSA FINAL!!!!!
				//

				$pasien = Pasien::find(Input::get('pasien_id'));
				$this->input_pasien = $pasien;
				$this->cekSudahAdaYangTerkontrolBulanIni($id);
				$this->hitungPersentaseRppt();
				
				$periksa->anamnesa              = Input::get('anamnesa');
				$periksa->asuransi_id           = $asuransi->id;
				$periksa->diagnosa_id           = Input::get('diagnosa_id');
				$periksa->berat_badan           = Input::get('berat_badan');
				$periksa->staf_id               = Input::get('staf_id');
				$periksa->jam_resep             = date('H:i:s');
				$periksa->keterangan_diagnosa   = Input::get('keterangan_diagnosa');
				$periksa->antrian_periksa_id    = Input::get('antrian_periksa_id');
				$periksa->sistolik              = Yoga::returnNull( $this->sesuaikanSistolikBPJS() );
				$periksa->diastolik             = Yoga::returnNull( $this->sesuaikanDiastolikBPJS() );
				$periksa->resepluar             = Input::get('resepluar');
				$periksa->pemeriksaan_fisik     = Input::get('pemeriksaan_fisik');
				$periksa->pemeriksaan_penunjang = Input::get('pemeriksaan_penunjang');
				$periksa->terapi                = $this->terapisBaru($terapis);
				$periksa->transaksi             = json_encode($transaksis);
				$periksa->jam_selesai_periksa   = date('H:i:s');
				$periksa->antrian_id            = Input::get('antrian_id');
				$confirm = $periksa->save();


				Terapi::where('periksa_id', $id)->delete();

				$timestamp = date('Y-m-d H:i:s');
				$terapis   = json_decode($terapis, true);
				$merek_ids = [];

				foreach ($terapis as $k => $t) {
					$merek_ids[] = $t['merek_id'];
				}

				$merekArray = Merek::with('rak')->whereIn('id', $merek_ids)->get();
				$array      = [];

				foreach ($merekArray as $v) {
					$array[$v->id] = $v;
				}

				$terapiInserts = [];

				foreach ($terapis as $k => $t) {
					$terapiInserts[] = [
						'merek_id'          => $t['merek_id'],
						'signa'             => $t['signa'],
						'aturan_minum'      => $t['aturan_minum'],
						'jumlah'            => $t['jumlah'],
						'periksa_id'        => $t['jumlah'],
						'periksa_id'        => $id,
						'harga_beli_satuan' => $array[$t['merek_id']]->rak->harga_beli,
						'harga_jual_satuan' => Yoga::hargaJualSatuan($asuransi, $t['merek_id']),
						'created_at'        => $timestamp,
						'updated_at'        => $timestamp,
					];
				}

				if(Input::get('poli') == 'usg'){
					
					$usg                 = Usg::where('periksa_id', $id)->first();
					$usg->perujuk_id     = Input::get('perujuk_id');
					$usg->hpht           = Yoga::datePrep(Input::get('hpht'));
					$usg->umur_kehamilan = Input::get('umur_kehamilan');
					$usg->gpa            = Input::get('gpa');
					$usg->bpd            = Input::get('BPD_w') . 'w ' . Input::get('BPD_d') . 'd';
					$usg->ltp            = Input::get('LTP');
					$usg->djj            = Input::get('FHR');
					$usg->ac             = Input::get('AC_w') . 'w ' . Input::get('AC_d') . 'd';
					$usg->hc             = Input::get('HC_w') . 'w ' . Input::get('HC_d') . 'd';
					$usg->efw            = Input::get('EFW') . ' gr';
					$usg->bpd_mm         = Input::get('BPD_mm');
					$usg->ac_mm          = Input::get('AC_mm');
					$usg->hc_mm          = Input::get('HC_mm');
					$usg->FL_mm          = Input::get('FL_mm');
					$usg->fl             = Input::get('FL_w') . 'w ' . Input::get('FL_d') . 'd';
					$usg->sex            = Input::get('Sex');
					$usg->ica            = Input::get('total_afi');
					$usg->plasenta       = Input::get('Plasenta');
					$usg->presentasi     = Input::get('presentasi');
					$usg->kesimpulan     = Input::get('kesimpulan');
					$usg->saran          = Input::get('saran');
					$usg->save();

					$pasien->riwayat_kehamilan_sebelumnya = Input::get('riwayat_kehamilan_sebelumnya');
					$pasien->save();

				}

				if (Input::get('poli') == 'anc' || Input::get('poli') == 'usg') {

					if (RegisterHamil::where('g', Input::get('G'))->where('pasien_id', Input::get('pasien_id'))->count() < 1) {
						
						$hamil                                = new RegisterHamil;
						$hamil->pasien_id                     = Input::get('pasien_id');
						$hamil->nama_suami                    = Input::get('nama_suami');
						$hamil->tb                            = Input::get('tb');
						$hamil->buku_id                       = Input::get('buku');
						$hamil->golongan_darah                = Input::get('golongan_darah');
						$hamil->tinggi_badan                  = Input::get('tb');
						$hamil->bb_sebelum_hamil              = Input::get('bb_sebelum_hamil');
						$hamil->g                             = Input::get('G');
						$hamil->p                             = Input::get('P');
						$hamil->a                             = Input::get('A');
						$hamil->riwayat_persalinan_sebelumnya = Input::get('riwayat_kehamilan');
						$hamil->hpht                          = Yoga::datePrep(Input::get('hpht'));
						$hamil->status_imunisasi_tt_id        = Input::get('status_imunisasi_tt_id');
						$hamil->rencana_penolong              = Input::get('rencana_penolong');
						$hamil->jumlah_janin                  = Input::get('jumlah_janin');
						$hamil->rencana_tempat                = Input::get('rencana_tempat');
						$hamil->rencana_pendamping            = Input::get('rencana_pendamping');
						$hamil->rencana_transportasi          = Input::get('rencana_transportasi');
						$hamil->rencana_pendonor              = Input::get('rencana_pendonor');
						$hamil->tanggal_lahir_anak_terakhir   = Yoga::datePrep(Input::get('tanggal_lahir_anak_terakhir'));
						$hamil->save();
					} else {

						$hamil                                = RegisterHamil::where('g', Input::get('G'))->where('pasien_id', Input::get('pasien_id'))->first();
						$hamil->pasien_id                     = Input::get('pasien_id');
						$hamil->nama_suami                    = Input::get('nama_suami');
						$hamil->tb                            = Input::get('tb');
						$hamil->buku_id                       = Input::get('buku');
						$hamil->golongan_darah                = Input::get('golongan_darah');
						$hamil->tinggi_badan                  = Input::get('tb');
						$hamil->bb_sebelum_hamil              = Input::get('bb_sebelum_hamil');
						$hamil->g                             = Input::get('G');
						$hamil->p                             = Input::get('P');
						$hamil->a                             = Input::get('A');
						$hamil->riwayat_persalinan_sebelumnya = Input::get('riwayat_kehamilan');
						$hamil->jumlah_janin                  = Input::get('jumlah_janin');
						$hamil->status_imunisasi_tt_id        = Input::get('status_imunisasi_tt_id');
						$hamil->hpht                          = Yoga::datePrep(Input::get('hpht'));
						$hamil->rencana_penolong              = Input::get('rencana_penolong');
						$hamil->rencana_tempat                = Input::get('rencana_tempat');
						$hamil->rencana_pendamping            = Input::get('rencana_pendamping');
						$hamil->rencana_transportasi          = Input::get('rencana_transportasi');
						$hamil->tanggal_lahir_anak_terakhir   = Yoga::datePrep(Input::get('tanggal_lahir_anak_terakhir'));
						$hamil->rencana_pendonor              = Input::get('rencana_pendonor');
						$hamil->save();
					}

					$anc                           = RegisterAnc::where('periksa_id', $id)->first();
					$anc->register_hamil_id        = $hamil->id;
					$anc->td                       = Input::get('td');
					$anc->tfu                      = Input::get('tfu');
					$anc->lila                     = Input::get('lila');
					$anc->bb                       = Input::get('bb');
					$anc->refleks_patela_id        = Input::get('refleks_patela');
					$anc->djj                      = Input::get('djj');
					$anc->kepala_terhadap_pap_id   = Input::get('kepala_terhadap_pap_id');
					$anc->presentasi_id            = Input::get('presentasi_id');
					$anc->catat_di_kia             = Input::get('catat_di_kia');
					$anc->inj_tt                   = Input::get('inj_tt');
					$anc->fe_tablet                = Input::get('fe_tablet');
					$anc->periksa_hb               = Input::get('periksa_hb');
					$anc->protein_urin             = Input::get('protein_urin');
					$anc->gula_darah               = Input::get('gula_darah');
					$anc->thalasemia               = Input::get('thalasemia');
					$anc->sifilis                  = Input::get('sifilis');
					$anc->hbsag                    = Input::get('hbsag');
					$anc->pmtct_konseling          = Input::get('pmtct_konseling');
					$anc->pmtct_periksa_darah      = Input::get('pmtct_periksa_darah');
					$anc->pmtct_serologi           = Input::get('pmtct_serologi');
					$anc->pmtct_arv                = Input::get('pmtct_arv');
					$anc->malaria_periksa_darah    = Input::get('malaria_periksa_darah');
					$anc->malaria_positif          = Input::get('malaria_positif');
					$anc->malaria_dikasih_obat     = Input::get('malaria_dikasih_obat');
					$anc->malaria_dikasih_kelambu  = Input::get('malaria_dikasih_kelambu');
					$anc->tbc_periksa_dahak        = Input::get('tbc_periksa_dahak');
					$anc->tbc_positif              = Input::get('tbc_positif');
					$anc->tbc_dikasih_obat         = Input::get('tbc_dikasih_obat');
					$anc->komplikasi_hdk           = Input::get('komplikasi_hdk');
					$anc->komplikasi_abortus       = Input::get('komplikasi_abortus');
					$anc->komplikasi_perdarahan    = Input::get('komplikasi_perdarahan');
					$anc->komplikasi_infeksi       = Input::get('komplikasi_infeksi');
					$anc->komplikasi_kpd           = Input::get('komplikasi_kpd');
					$anc->komplikasi_lain_lain     = Input::get('komplikasi_lain_lain');
					$anc->rujukan_tiba_masih_hidup = Input::get('rujukan_tiba_masih_hidup');
					$anc->rujukan_tiba_meninggal   = Input::get('rujukan_tiba_meninggal');
					$anc->rujukan_puskesmas        = '2';
					$anc->rujukan_RB               = '2';
					$anc->rujukan_RSIA_RSB         = '2';
					$anc->rujukan_RS               = '2';
					$anc->rujukan_lain             = '2';
					$anc->rujukan_tiba_masih_hidup = '1';
					$anc->rujukan_tiba_meninggal   = '1';
					$anc->save();
				}
				$antrian = $antrianperiksa->antrian;
				$this->updateTemplate( $antrian_periksa_id, $id, $periksa);
				Terapi::insert($terapiInserts);
				$pasien = $periksa->pasien;
				DB::commit();

				$jenis_antrian_id = '5';
				if (!is_null($antrian)) {
					$jenis_antrian_id = $antrian->jenis_antrian_id;
				}
				return redirect('ruangperiksa/' . $jenis_antrian_id)->withPesan(Yoga::suksesFlash('<strong>' . $pasien->id . ' - ' . $pasien->nama . '</strong> Selesai Diperiksa' ));
			} else {
				$pesan = Yoga::gagalFlash('Pasien sudah tidak ada di antrian');
				return redirect()->back()->withPesan($pesan);
			}
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
	}

	/**
	 * Remove the specified periksa from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Periksa::destroy($id);
		Terapi::where('periksa_id', $id)->delete();
		return \Redirect::route('periksas.index');
	}

	private function terapisBaru($terapis)
	{
		$terapis_baru = [];
		$terapis = json_decode($terapis, true);
		foreach ($terapis as $k => $v) {
			$merek_id   = $v['merek_id'];
			$formula_id = Merek::find($merek_id)->rak->formula_id;
			$signa = $v['signa'];
			$jumlah = $v['jumlah'];

			$terapis_baru[] = [
				'formula_id' => $formula_id,
				'signa' => $signa,
				'jumlah' => $jumlah
			];
		}
		return json_encode($terapis_baru);
	}

	private function bhp($transaksi){
		$transaksis = json_decode($transaksi, true);
		if(!empty($transaksi) && $transaksi != '[]'){
			$transaksis[] = [
				"jenis_tarif_id" => '140',
				"jenis_tarif" => 'BHP',
				"biaya"	=> '0'
			];
		} else {
			$transaksis = [];
		}
		return $transaksis;
	}


	private function sesuaikanResep($terapis, $asuransi){
		if($asuransi->id == '32' || $asuransi->tipe_asuransi == '4') { // asuransi_id 32 = BPJS atau tipe_asuransi 4 == flat
			if ($terapis != '' && $terapis != '[]') {
				$terapis = Yoga::sesuaikanResep($terapis, 'asc');
				// return $terapis;
			}
		} elseif($asuransi->tipe_asuransi == '3'){ //tipe_asuransi 1 = admedika
			if ($terapis != '' && $terapis != '[]') {
				$terapis = Yoga::sesuaikanResep($terapis, 'desc');
			}
        } else {
			if ($terapis != '' && $terapis != '[]') {
				$terapis = Yoga::sesuaikanResepPasienUmum($terapis);
			}
        }
		return $terapis;
	}

	private function inputJasaDokter($transaksis, $asuransi){
		$paket_tindakan = false;
		foreach ($transaksis as $key => $trx) {
			$tipe_tindakan_id = Tarif::where('asuransi_id', $asuransi->id)->where('jenis_tarif_id', $trx['jenis_tarif_id'])->first()->tipe_tindakan_id;
			if ($tipe_tindakan_id != 1) {
				$paket_tindakan = true;
				break;
			}
		}
		if (!$paket_tindakan) {  // jika tidak ada transaksi paket tindakan, masukkan komponen transaksi jasa dokter

			$tarif = Tarif::where('jenis_tarif_id', '1')->where('asuransi_id', $asuransi->id)->first();
			// masukkan komponen jasa dokter di transaksi
			$plus = [
				'jenis_tarif_id' => $tarif->jenis_tarif_id,
				'jenis_tarif'    => $tarif->jenisTarif->jenis_tarif,
				'biaya'          => $tarif->biaya
			];

			array_unshift($transaksis, $plus);
		}
		return $transaksis;
	}

	public function sesuaikanTransaksi($transaksi, $asuransi, $terapis, $poli){
		// INPUT TRANSAKSI BHP
		// Jika input transaksi tidak kosong DAN input transaksi tidak sama dengan json kosng,
		// maka buat transaksi BHP dengan nilai 0 yang akan dimasukkan belakangan
		$transaksis = $this->bhp($transaksi);
		// INPUT TRANSAKSI OBAT
		//Jika terapi tidak kosong, maka hitung biaya obat
		$ifflat = Yoga::dispensingObatBulanIni($asuransi);
		$plafonFlat = null;
		if ( !is_null( $plafonFlat ) ){
			$plafonFlat = $ifflat['plafon'];
		}
		// return $plafonFlat;
		// return $plafon;
		$transaksis = Yoga::kaliObat($transaksis, $terapis, $asuransi, $plafonFlat, $poli);
		//INPUT TRANSAKSI JASA DOKTER
		//jenis tarif id = 1 adalah jasa dokter
		//jika ada tindakan surat keterangan sehat, maka jasa dokter adalah 0
		return $this->inputJasaDokter($transaksis, $asuransi);
	}
	private function updateTemplate($antrian_periksa_id, $periksa_id, $periksa){
		GambarPeriksa::where('gambarable_type', 'App\Models\AntrianPeriksa')
								->where('gambarable_id', $antrian_periksa_id)
								->update([
									'gambarable_type' => 'App\Models\Periksa',
									'gambarable_id' => $periksa_id
								]);
		$antrianperiksa = AntrianPeriksa::find($antrian_periksa_id);
		if (
			!AntrianApotek::where('periksa_id', $periksa_id)->exists() &&
			$antrianperiksa->exists()
	   	) {
			if (
				$periksa->terapi !== '' &&
				$periksa->terapi !== '[]'
			) {
				$antrianapotek             = new AntrianApotek;
				$antrianapotek->periksa_id = $periksa_id;
				$antrianapotek->jam        = date('H:i:s');
				$antrianapotek->tanggal    = date('Y-m-d');
				$antrianapotek->save();

				PengantarPasien::where('antarable_id', $antrian_periksa_id)
					->where('antarable_type', 'App\Models\AntrianPeriksa')
					->update([
						'antarable_id' => $antrianapotek->id,
						'antarable_type' => 'App\Models\AntrianApotek'
					]);

				Antrian::where('antriable_id', $antrian_periksa_id)
					->where('antriable_type', 'App\Models\AntrianPeriksa')
					->update([
						'antriable_id' => $antrianapotek->id,
						'antriable_type' => 'App\Models\AntrianApotek'
					]);

			} else {

				$antriankasir             = new AntrianKasir;
				$antriankasir->periksa_id = $periksa_id;
				$antriankasir->jam        = date('H:i:s');
				$antriankasir->tanggal    = date('Y-m-d');
				$antriankasir->save();

				PengantarPasien::where('antarable_id', $antrian_periksa_id)
					->where('antarable_type', 'App\Models\AntrianPeriksa')
					->update([
						'antarable_id' => $antriankasir->id,
						'antarable_type' => 'App\Models\AntrianKasir'
					]);

				Antrian::where('antriable_id', $antrian_periksa_id)
					->where('antriable_type', 'App\Models\AntrianPeriksa')
					->update([
						'antriable_id' => $antriankasir->id,
						'antriable_type' => 'App\Models\AntrianKasir'
					]);
			}
			$antrianperiksa->delete();
		}
		$apc = new AntrianPolisController;
		$apc->updateJumlahAntrian(false);
	}
	public function uploadBerkas($id){

		if(Input::hasFile('file')) {

			$nama_file               = Input::get('nama_file');
			$upload_cover            = Input::file('file');
			$extension               = $upload_cover->getClientOriginalExtension();

			$berkas                  = new Berkas;
			$berkas->berkasable_id   = $id;
			$berkas->berkasable_type = 'App\\Models\\Periksa';
			$berkas->nama_file       = $nama_file;
			$berkas->save();

			$destination_path =  'berkas/pemeriksaan/' . $id . '/';
			$filename =	 $berkas->id . '_' . time() . '.' . $extension;

			$berkas->url             = $destination_path . $filename;
			$berkas->save();



			//menyimpan bpjs_image ke folder public/img
			//
			/* $destination_path = public_path() . DIRECTORY_SEPARATOR . 'berkas/pemeriksaan/' . $id . '/'; */

			// Mengambil file yang di upload
			//
			//
			/* return [$filename, $destination_path]; */

			/* $upload_cover->move($destination_path , $filename); */

			Storage::disk('s3')->put($destination_path. $filename, file_get_contents($upload_cover));

			return [
				'url' => $destination_path. $filename,
				'id' => $berkas->id
			];
			
		} else {
			return null;
		}
	}
	public function hapusBerkas(){
		$berkas_id = Input::get('berkas_id');
		if ( Berkas::destroy( $berkas_id ) ) {
			return '1';
		} else {
			return '0';
		}
	}
	public function jumlahBerkas($id){
		return Periksa::find($id)->berkas->count();
	}
	public function updateAntrian($periksa){


		
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function sesuaikanSistolikBPJS()
	{
		if ( 
			$this->input_asuransi_id == '32' &&
			$this->belum_ada_tekanan_darah_terkontrol
	   	) {
			$tanggal_object       = Carbon::parse( $this->input_tanggal );
			$tanggal_lahir_object = Carbon::parse( $this->input_pasien->tanggal_lahir );
			if ( 
				// jika target terkendali 10 % belum tercapai
				$this->persenRpptTerkendali < 10 &&
				// jika pasien masuk dalam kategori prolanis ht
				$this->input_pasien->prolanis_ht == '1' &&
				// jika nilai sistolik < 140  dan diastolik < 90
				$this->input_sistolik <= 140 &&
				$this->input_diastolik <= 90 &&
				!empty($this->input_sistolik)  &&
				( 
					// jika sistolik tidak diantara 120 dan 130 untuk pasien kurang dari 64 tahun
					(!in_array($this->input_sistolik, range(120, 130)) && $tanggal_lahir_object->diffInYears( $tanggal_object ) <65  ) ||
					// atau jika sistolik tidak diantara 130 dan 139 untuk pasien lebih dari 65 tahun
					(!in_array($this->input_sistolik, range(130, 139)) && $tanggal_lahir_object->diffInYears( $tanggal_object ) >=65  )
				)
			) {
				if ($tanggal_lahir_object->diffInYears( $tanggal_object ) >= 65) {
					return 130;
				} else {
					return 120;
				}
			} else {
				return $this->input_sistolik;
			}
		} else {
			return $this->input_sistolik;
		}
	}

	private function sesuaikanDiastolikBPJS()
	{
		if (
			$this->input_asuransi_id == '32' &&
			$this->belum_ada_tekanan_darah_terkontrol
		) {
			if ( 
				// jika target terkendali 10 % belum tercapai
				$this->persenRpptTerkendali < 10 &&
				// jika pasien masuk dalam kategori prolanis ht
				$this->input_pasien->prolanis_ht == '1' &&
				// jika nilai sistolik =< 140  dan diastolik =< 90
				$this->input_sistolik <= 140 &&
				$this->input_diastolik <= 90 &&
				!empty($this->input_diastolik)  &&
				// jika diastolik tidak diantara 70 dan 79
				(!in_array($this->input_diastolik, range(70, 79)))
			) {
				return 70;
			} else {
				return $this->input_diastolik;
			}
		} else {
			return $this->input_diastolik;
		}
	}

	/**
	* undocumented function
	*
	* @return void
	*/
	public function hitungPersentaseRppt($bulanThn = null)
	{
		if (is_null($bulanThn)) {
			$tanggal_object        = Carbon::parse( $this->input_tanggal );
		} else {
			$tanggal_object = Carbon::parse($bulanThn . '-01');
		}
		$peserta_bpjs_perbulan    = PesertaBpjsPerbulan::orderBy('bulanTahun', 'desc')->latest()->first();
		$jumlah_denominator_ht    = $peserta_bpjs_perbulan->jumlah_ht;
		$jumlah_denominator_dm    = $peserta_bpjs_perbulan->jumlah_dm;
		$data_ht                  = $this->queryDataHt($tanggal_object);
		$data_ht_terkendali       = $this->dataHtTerkendali($data_ht);
		$jumlah_ht_terkendali     = count( $data_ht_terkendali );
		$persentase_ht_terkendali = $jumlah_ht_terkendali / $jumlah_denominator_ht * 100;

		$data_dm                  = $this->queryDataDm($tanggal_object);
		$data_dm_terkendali       = $this->dataDmTerkendali($data_dm);
		$jumlah_dm_terkendali     = count($data_dm_terkendali);
		$persentase_dm_terkendali = $jumlah_dm_terkendali / $jumlah_denominator_dm * 100;
		$this->persenRpptTerkendali = ($persentase_dm_terkendali + $persentase_ht_terkendali) /2;
		return [
			'rppt'                     => round($this->persenRpptTerkendali, 2),
			'jumlah_denominator_dm'    => $jumlah_denominator_dm,
			'jumlah_denominator_ht'    => $jumlah_denominator_ht,
			'jumlah_dm_terkendali'     => $jumlah_dm_terkendali,
			'jumlah_ht_terkendali'     => $jumlah_ht_terkendali,
			'persentase_dm_terkendali' => round($persentase_dm_terkendali),
			'persentase_ht_terkendali' => round($persentase_ht_terkendali),
			'data_ht'                  => $data_ht,
			'data_ht_terkendali'       => $data_ht_terkendali,
			'data_dm'                  => $data_dm,
			'data_dm_terkendali'       => $data_dm_terkendali
		];
	}
	
	public function surveyKepuasan(){
		$surveyable_id   = Input::get('surveyable_id');
		$surveyable_type = Input::get('surveyable_type');
		$periksa_id      = Input::get('periksa_id');
		$index           = Input::get('index');

		if ($surveyable_type == 'App\\Models\\AntrianKasir') {
			$surveyable =  AntrianKasir::find($surveyable_id);
		} else if ($surveyable_type == 'App\\Models\\AntrianFarmasi'){
			$surveyable =  AntrianFarmasi::find($surveyable_id);
		}

		$periksa                     = $surveyable->periksa;
		$periksa->satisfaction_index = $index;
		if ($periksa->save()) {
			return 1;
		} else {
			return 0;
		}
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function cekSudahAdaYangTerkontrolBulanIni($id = false)
	{
		$tanggal_object       = Carbon::parse( $this->input_tanggal );
		$tanggal_lahir_object = Carbon::parse( $this->input_pasien->tanggal_lahir );

		$query  = "SELECT * ";
		$query .= "FROM periksas as prx ";
		// dimana pasien ini
		$query .= "WHERE pasien_id = '{$this->input_pasien_id}' ";
		// dengan asuransi bpjs (32)
		$query .= "AND asuransi_id = '32' ";
		// apabila pasien masuk dalam kategori prolanis_ht
		$query .= "AND prolanis_ht = '1' ";
		// dengan tanggal pemeriksaan bulan ini
		$query .= "AND tanggal like '{$tanggal_object->format('Y-m')}%' ";
		// jika usia pasien lebih sama dengan 65 tahun
		if ($tanggal_lahir_object->diffInYears( $tanggal_object ) >= 65) {
			// dan sistolik diantara 130 dan 139 untuk diatas sama dengan 65 tahun
			$query .= "AND sistolik >= 130 and sistolik <= 139 ";
		} else {
			// dan sistolik diantara 120 dan 130 untuk pasien dibawah 65 tahun
			$query .= "AND sistolik >= 120 and sistolik <= 130 ";
		}
		// dengan diastolik antara 70 hingga 79
		$query .= "AND diastolik >= 70 and diastolik <= 79 ";
		if ($id) {
			$query .= "AND id not like '{$id}';";
		}
		$data = DB::select($query);

		if ( count($data) == 0 ) {
			$this->belum_ada_tekanan_darah_terkontrol = true;
		}
	}
	public function kembali($id){
		DB::beginTransaction();
		try {
			$periksa = Periksa::find( $id );

			if (is_null($periksa)) {
				$pesan = Yoga::gagalFlash('antrian periksa tidak ditemukan');
				return redirect()->back()->withPesan($pesan);
			}
			$antrian              = new AntrianPeriksa;
			$antrian->poli        = $periksa->poli;
			$antrian->periksa_id  = $periksa->periksa_id;
			$antrian->staf_id     = $periksa->staf_id;
			$antrian->asuransi_id = $periksa->asuransi_id;
			$antrian->asisten_id  = $periksa->asisten_id;
			$antrian->pasien_id   = $periksa->pasien_id;
			$antrian->jam         = $periksa->jam;
			$antrian->tanggal     = $periksa->tanggal;
			$antrian->save();
			$periksa->antrian_periksa_id = $antrian->id;
			$periksa->save();


			$antriankasir =  AntrianKasir::where('periksa_id', $id)->first();
			if ( isset($antriankasir) ) {
				$antarable_type = 'App\Models\AntrianKasir';
				$antarable_id   = $antriankasir->id;
			}
			$antrianapotek =  AntrianApotek::where('periksa_id', $id)->first();
			if ( isset($antrianapotek) ) {
				$antarable_type = 'App\Models\AntrianApotek';
				$antarable_id   = $antrianapotek->id;
			}

			if (is_null($antarable_type)) {
				$pesan = Yoga::gagalFlash('Pasien sudah pulang dan tidak bisa diedit lagi');
				return redirect()->back()->withPesan($pesan);
			}

			Antrian::where('antriable_type', $antarable_type)
					->where('antriable_id', $antarable_id)
					->update([
						 'antriable_type' => 'App\Models\AntrianPeriksa',
						 'antriable_id' => $antrian->id
				]);

			PengantarPasien::where('antarable_type', $antarable_type)
				->where('antarable_id', $antarable_id)
				->update([
					 'antarable_type' => 'App\Models\AntrianPeriksa',
					 'antarable_id' => $antrian->id
			]);

			DB::commit();
			
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
		AntrianKasir::where('periksa_id', $id)->delete();
		AntrianApotek::where('periksa_id', $id)->delete();

		$nama = $periksa->pasien_id . '-'. $periksa->pasien->nama;

		$pesan = Yoga::suksesFlash('Pasien <strong> ' . $nama . '</strong> berhasil dikembalikan ke ruang periksa');
		return redirect()->back()->withPesan($pesan);
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function queryDataHt($tanggal_object){

		$query  = "SELECT ";
		$query .= "psn.nama as nama, ";
		$query .= "psn.alamat as alamat, ";
		$query .= "psn.nomor_asuransi_bpjs as nomor_asuransi_bpjs, ";
		$query .= "psn.tanggal_lahir as tanggal_lahir, ";
		$query .= "prx.tanggal as tanggal, ";

		/* $query .= "CASE when "; */
		/* $query .= "diastolik between 70 and 79 "; */
		/* $query .= "and sistolik between 120 and 130 "; */
		/* $query .= "and (TIMESTAMPDIFF(YEAR, psn.tanggal_lahir, prx.tanggal) between 18 and 64) "; */
		/* $query .= "or "; */
		/* $query .= "diastolik between 70 and 79 "; */
		/* $query .= "and sistolik between 130 and 139 "; */
		/* $query .= "and (TIMESTAMPDIFF(YEAR, psn.tanggal_lahir, prx.tanggal) >64 ) "; */
		/* $query .= "then sistolik else null END as sistolik, "; */

		/* $query .= "CASE when "; */
		/* $query .= "diastolik between 70 and 79 "; */
		/* $query .= "and sistolik between 120 and 130 "; */
		/* $query .= "and (TIMESTAMPDIFF(YEAR, psn.tanggal_lahir, prx.tanggal) between 18 and 64) "; */
		/* $query .= "or "; */
		/* $query .= "diastolik between 70 and 79 "; */
		/* $query .= "and sistolik between 130 and 139 "; */
		/* $query .= "and (TIMESTAMPDIFF(YEAR, psn.tanggal_lahir, prx.tanggal) >64 ) "; */
		/* $query .= "then diastolik else null END as diastolik, "; */

		$query .= "prx.sistolik as sistolik, ";
		$query .= "prx.diastolik as diastolik, ";
		$query .= "prx.id as periksa_id, ";
		$query .= "psn.id as pasien_id, ";
		$query .= "psn.no_telp as no_telp, ";
		$query .= "psn.prolanis_ht_flagging_image as prolanis_ht_flagging_image, ";
		$query .= "psn.prolanis_dm_flagging_image as prolanis_dm_flagging_image ";
		/* $query .= "CAST(trx.keterangan_pemeriksaan AS UNSIGNED) as gula_darah, "; */
		$query .= "FROM periksas as prx ";
		$query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
		//asuransi = bpjs
		$query .= "WHERE prx.asuransi_id = '32' ";
		//pada bulan dimana pemeriksaan dilakukan
		$query .= "AND prx.tanggal between '" . $tanggal_object->format('Y-m-01'). "' and '" . $tanggal_object->format('Y-m-t'). "' ";
		//pemeriksaan terflagging prolanis_ht
		$query .= "AND prx.prolanis_ht = '1' ";
		// dengan diastolik antara 70 dan 79
		/* $query .= "AND diastolik between 70 and 79 "; */
		/* $query .= "AND (( "; */
		// dan jika usia 18 - 64 tahun dan sistolik 120 - 130
		/* $query .= "(sistolik between 120 and 130 ) and "; */
		/* $query .= "(TIMESTAMPDIFF(YEAR, psn.tanggal_lahir, prx.tanggal) between 18 and 64) "; */
		/* $query .= ") "; */
		/* $query .= "OR ( "; */
		// atau jika usia diatas 64 tahun dan sistolik 130 - 139
		/* $query .= "(sistolik between 130 and 139 ) and "; */
		/* $query .= "(TIMESTAMPDIFF(YEAR, psn.tanggal_lahir, prx.tanggal) > 64) "; */
		/* $query .= ")) "; */
		$data_ht = DB::select($query);

		/* dd( $data_ht ); */
		$arr = [];
		$acep = [];
		foreach ($data_ht as $data) {
			$arr[$data->pasien_id]["nama"]                       = $data->nama;
			$arr[$data->pasien_id]["alamat"]                     = $data->alamat;
			$arr[$data->pasien_id]["usia"]                       = Yoga::umurSaatPeriksa($data->tanggal_lahir, $data->tanggal);
			$arr[$data->pasien_id]["nomor_asuransi_bpjs"]        = $data->nomor_asuransi_bpjs;
			$arr[$data->pasien_id]["tanggal_lahir"]              = $data->tanggal_lahir;
			$arr[$data->pasien_id]["no_telp"]                    = $data->no_telp;
			$arr[$data->pasien_id]["pasien_id"]                  = $data->pasien_id;
			$arr[$data->pasien_id]["prolanis_ht_flagging_image"] = $data->prolanis_ht_flagging_image;
			$arr[$data->pasien_id]["prolanis_dm_flagging_image"] = $data->prolanis_dm_flagging_image;

			$umur      = Yoga::umurSaatPeriksa($data->tanggal_lahir, $data->tanggal);
			$sistolik  = $data->sistolik;
			$diastolik = $data->diastolik;

			$tekanan_darah_terkendali =  tekananDarahTerkendali($umur, $sistolik, $diastolik);

			if (!isset( $arr[$data->pasien_id]["tekanan_darah"] )) {
				 $arr[$data->pasien_id]['tekanan_darah']["sistolik"] = $sistolik;
				 $arr[$data->pasien_id]['tekanan_darah']["diastolik"] = $diastolik;
			} else if ( $tekanan_darah_terkendali ) {
				 $arr[$data->pasien_id]['tekanan_darah']["sistolik"]  = $sistolik;
				 $arr[$data->pasien_id]['tekanan_darah']["diastolik"] = $diastolik;
			}

			if (!isset( $arr[$data->pasien_id]["periksa_id"] )) {
				 $arr[$data->pasien_id]['periksa_id'] = $data->periksa_id;
			} else if ( $tekanan_darah_terkendali ) {
				 $arr[$data->pasien_id]['periksa_id'] = $data->periksa_id;
			}

			if (!isset( $arr[$data->pasien_id]["tanggal"] )) {
				 $arr[$data->pasien_id]['tanggal'] = $data->tanggal;
			} else if ( $tekanan_darah_terkendali ) {
				 $arr[$data->pasien_id]['tanggal'] = $data->tanggal;
			}
		}
		/* dd( $acep ); */
		return collect($arr);
	}

	/**
	* undocumented function
	*
	* @return void
	*/
	private function dataHtTerkendali($data)
	{
		$data_ht_terkendali = [];
		foreach ($data as $dt) {
			$sistolik  = $dt['tekanan_darah']['sistolik'];
			$diastolik = $dt['tekanan_darah']['diastolik'];
			$umur      = Yoga::umurSaatPeriksa( $dt['tanggal_lahir'], $dt['tanggal'] );
			if ( tekananDarahTerkendali($umur, $sistolik, $diastolik)) {
				$data_ht_terkendali[] = $dt;
			}
		}
		return $data_ht_terkendali;
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function queryDataDm($tanggal_object)
	{
		$query  = "SELECT ";
		$query .= "psn.nama as nama, ";
		$query .= "psn.alamat as alamat, ";
		$query .= "psn.id as pasien_id, ";
		$query .= "psn.nomor_asuransi_bpjs as nomor_asuransi, ";
		$query .= "psn.tanggal_lahir as tanggal_lahir, ";
		$query .= "psn.prolanis_dm_flagging_image as prolanis_dm_flagging_image, ";
		$query .= "prx.tanggal as tanggal, ";
		$query .= "prx.sistolik, ";
		$query .= "prx.id as periksa_id, ";
		$query .= "CAST(trx.keterangan_pemeriksaan AS UNSIGNED) as gula_darah, ";
		$query .= "prx.diastolik ";
		$query .= "FROM periksas as prx ";
		$query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
		$query .= "JOIN transaksi_periksas as trx on prx.id = trx.periksa_id ";
		//asuransi = bpjs
		$query .= "WHERE prx.asuransi_id = '32' ";
		//pada bulan dimana pemeriksaan dilakukan
		$query .= "AND prx.tanggal between '" . $tanggal_object->format('Y-m-01') . "' and  '" . date("Y-m-t", strtotime($tanggal_object->format('Y-m-t') )) . "' ";
		//pemeriksaan terflagging prolanis_dm
		$query .= "AND prx.prolanis_dm = '1'";
		$query .= "AND trx.jenis_tarif_id = '116' ";
		/* $query .= "AND CAST(trx.keterangan_pemeriksaan AS UNSIGNED) between 80 and 130 "; */
		$query .= "GROUP BY pasien_id;";

		$data_dm = DB::select($query);
		$arr = [];
		foreach ($data_dm as $ddm) {
			$arr[$ddm->pasien_id]["nama"] = $ddm->nama;
			$arr[$ddm->pasien_id]["alamat"] = $ddm->alamat;
			$arr[$ddm->pasien_id]["pasien_id"] = $ddm->pasien_id;
			$arr[$ddm->pasien_id]["nomor_asuransi"] = $ddm->nomor_asuransi;
			$arr[$ddm->pasien_id]["tanggal_lahir"] = $ddm->tanggal_lahir;
			$arr[$ddm->pasien_id]["prolanis_dm_flagging_image"] = $ddm->prolanis_dm_flagging_image;
			$arr[$ddm->pasien_id]["tanggal"] = $ddm->tanggal;
			$arr[$ddm->pasien_id]["sistolik"] = $ddm->sistolik;
			$arr[$ddm->pasien_id]["periksa_id"] = $ddm->periksa_id;
			$arr[$ddm->pasien_id]["diastolik"] = $ddm->diastolik;
			$arr[$ddm->pasien_id]["gula_darah"] = null;
			if (!isset($arr[$ddm->pasien_id]["gula_darah"])){
				$arr[$ddm->pasien_id]["gula_darah"] = $ddm->gula_darah;
			} else if (
				 $ddm->gula_darah >= 80 &&
				 $ddm->gula_darah <= 130
			){ 
				$arr[$ddm->pasien_id]["gula_darah"] = $ddm->gula_darah;
			}
		}
		return $arr;
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function dataDmTerkendali($data_dm)
	{
		$data_dm_terkendali = [];
		foreach ($data_dm as $ddm) {
			if (
				$ddm['gula_darah'] >= 80
				&& $ddm['gula_darah'] <= 130
			) {
				$data_dm_terkendali[] = $ddm;
			}
		}
		return $data_dm_terkendali;
	}
	public function cekCustomerServiceSudahDiisi(){
		$periksa_id = Input::get('periksa_id');
		$periksa    = Periksa::find( $periksa_id );
		if (!is_null($periksa->satisfaction_index)) {
			return 1;
		}
	}
	public function cariByAsuransiByPeriode($asuransi_id, $from, $until){
		$periksas = Periksa::with('pasien', 'asuransi')
			->where('asuransi_id', $asuransi_id)
			->whereBetween('tanggal',[ $from, $until ])
			->get();
		$asuransi = Asuransi::find( $asuransi_id );
		return view('periksas.cari_by_asuransi_and_periode', compact(
			'periksas',
			'from',
			'until',
			'asuransi'
		));
	}
	
	
	
	
	
	
	
	
	
	
	
	
	/* public function kirimWaAntrianBerikutnya($periksa){ */
	/* 	$antrianPeriksa = new AntrianPeriksasController; */
	/* 	$totalAntrian   = $antrianPeriksa->totalAntrian($periksa->tanggal); */
	/* 	$antrian        = $periksa->antrian; */

	/* 	$antrian_periksas = AntrianPeriksa::where('antrian', '<', $periksa->antrian) */
	/* 						->where('tanggal', 'like', $periksa->tanggal . '%') */
	/* 						->get(); */

	/* 	$nomor_antrian_periksas = []; */
	/* 	foreach ($antrian_periksas as $ap) { */
	/* 		$nomor_antrian_periksas[] = $ap->antrian; */
	/* 	} */

	/* 	rsort($antrians); */
	/* 	$new_antrians = array_slice($antrians, 0, 5, true); */

	/* 	return */ 


	/* 	$antrianPeriksa->sendWaAntrian(); */
	/* } */
	
	
}
