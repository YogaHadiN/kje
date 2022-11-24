<?php


namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use Carbon\Carbon;
use DB;
use Log;
use App\Models\Promo;
use App\Models\JenisTarif;
use App\Models\DenominatorBpjs;
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
use App\Models\Poli;
use App\Models\Staf;
use App\Rules\StafHarusDiDalamTenant;
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
 */
	public $input_sistolik;
	public $input_diastolik;
	public $input_asuransi_id;
	public $input_pasien_id;
	public $input_kecelakaan_kerja;
	public $input_prolanis_ht;
	public $persenRpptTerkendali;
	public $belum_ada_tekanan_darah_terkontrol;
    public $antrian;
    public $pasien;
    public $antrianperiksa;
    public $periksa;
    public $asuransi;
	

  public function __construct(){
        $this->middleware('selesaiPeriksa', ['only' => ['update']]);
		$this->input_sistolik                        = Input::get('sistolik');
		$this->input_diastolik                       = Input::get('diastolik');
		$this->input_asuransi_id                     = Input::get('asuransi_id');
		$this->input_tanggal                         = Input::get('tanggal');
		$this->input_kecelakaan_kerja                = Input::get('kecelakaan_kerja');
		$this->input_prolanis_ht                     = Input::get('prolanis_ht');
		$this->input_pasien_id                       = Input::get('pasien_id');
		$this->belum_ada_tekanan_darah_terkontrol    = false;
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
        /* dd(Input::all()); */ 
		DB::beginTransaction();
        $before_transact = Periksa::count();
		try {
            $rules = [
              "kecelakaan_kerja"   => "required",
              "asuransi_id"        => "required",
              "hamil"              => "required",
              "staf_id"            => [ "required", new StafHarusDiDalamTenant],
              "kali_obat"          => "required",
              "pasien_id"          => "required",
              "jam"                => "required",
              "jam_periksa"        => "required",
              "tanggal"            => "required",
              "poli_id"            => "required",
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

            if ($this->redirectBackIfAntrianPeriksaNotFound()) {
                return $this->redirectBackIfAntrianPeriksaNotFound();
            }

            $periksa = new Periksa;
            $periksa = $this->inputData($periksa);
			DB::commit();

            $after_transact = Periksa::count();
			$banner_button = $this->banner_button($periksa);

			return redirect('ruangperiksa/' . $this->ruang_periksa($this->antrian))->withPesan(Yoga::suksesFlash('<strong>' . $this->pasien->id . ' - ' . $this->pasien->nama . '</strong> Selesai Diperiksa ' . $banner_button ));
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
        foreach ($periksa->jurnals as $jur) {
            if ( !$jur->coa ) {
                dd( $jur );
            }
        }
		$cs      = new CustomController;
		$warna   = $cs->warna;

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

            $rules = [
              "kecelakaan_kerja"   => "required",
              "asuransi_id"        => "required",
              "hamil"              => "required",
              "staf_id"            => [ "required", new StafHarusDiDalamTenant],
              "kali_obat"          => "required",
              "pasien_id"          => "required",
              "jam"                => "required",
              "jam_periksa"        => "required",
              "tanggal"            => "required",
              "poli_id"            => "required",
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

            if ($this->redirectBackIfAntrianPeriksaNotFound()) {
                return $this->redirectBackIfAntrianPeriksaNotFound();
            }

            $periksa = Periksa::with('transaksii.jenisTarif')->where('id',$id)->first();
            if (is_null($periksa)) {
                $pesan = Yoga::gagalFlash('Mohon maaf pemeriksaan pasien tidak ditemukan, mohon dapat diulangi dari pendaftaran');
                return redirect()->back()->withPesan($pesan);
            }

            $periksa = $this->inputData($periksa);
            DB::commit();

            $banner_button = $this->banner_button($periksa);
            return redirect('ruangperiksa/' . $this->ruang_periksa($this->antrian))->withPesan(Yoga::suksesFlash('<strong>' . $this->pasien->id . ' - ' . $this->pasien->nama . '</strong> Selesai Diperiksa' . $banner_button ));
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

	private function terapisBaru($terapis)
	{
		$terapis_baru = [];
		$terapis = json_decode($terapis, true);
		foreach ($terapis as $k => $v) {
			$merek_id   = $v['merek_id'];
			$formula_id = Merek::find($merek_id)->rak->formula_id;
			$signa      = $v['signa'];
			$jumlah     = $v['jumlah'];

			$terapis_baru[] = [
				'formula_id' => $formula_id,
				'signa'      => $signa,
				'jumlah'     => $jumlah
			];
		}
		return json_encode($terapis_baru);
	}

	private function bhp($transaksi){
		$transaksis = json_decode($transaksi, true);
		if(!empty($transaksi) && $transaksi != '[]'){
			$transaksis[] = [
				"jenis_tarif_id" => JenisTarif::where('jenis_tarif', 'BHP')->first()->id,
				"jenis_tarif" => 'BHP',
				"biaya"	=> '0'
			];
		} else {
			$transaksis = [];
		}
		return $transaksis;
	}


	private function sesuaikanResep($terapis, $asuransi){
		if($asuransi->tipe_asuransi_id ==  5|| $asuransi->tipe_asuransi_id == '4') { // asuransi_id 32 = BPJS atau tipe_asuransi 4 == flat
			if ($terapis != '' && $terapis != '[]') {
				$terapis = Yoga::sesuaikanResep($terapis, 'asc');
			}
		} elseif($asuransi->tipe_asuransi_id == '3'){ //tipe_asuransi 1 = admedika
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

			$tarif = Tarif::queryTarif( $asuransi->id, 1);
			// masukkan komponen jasa dokter di transaksi
			$plus = [
				'jenis_tarif_id'      => $tarif->jenis_tarif_id,
				'tipe_jenis_tarif_id' => $tarif->tipe_jenis_tarif_id,
				'jenis_tarif'         => $tarif->jenis_tarif,
				'biaya'               => $tarif->biaya
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
		$transaksis = $this->kaliObat($transaksis, $terapis, $asuransi, $plafonFlat, $poli);

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

			$antrianperiksa->delete();
		}
		$apc = new AntrianPolisController;
		$apc->updateJumlahAntrian(false, null);
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
		/* if ( */ 
		/* 	Asuransi::find($this->input_asuransi_id)->tipe_asuransi_id ==  5&& */
		/* 	$this->belum_ada_tekanan_darah_terkontrol */
	   	/* ) { */
		/* 	$tanggal_object       = Carbon::parse( $this->input_tanggal ); */
		/* 	$tanggal_lahir_object = Carbon::parse( $this->input_pasien->tanggal_lahir ); */
		/* 	if ( */ 
		/* 		// jika target terkendali 10 % belum tercapai */
		/* 		$this->persenRpptTerkendali < 10 && */
		/* 		// jika pasien masuk dalam kategori prolanis ht */
		/* 		$this->input_pasien->prolanis_ht == '1' && */
		/* 		// jika nilai sistolik < 140  dan diastolik < 90 */
		/* 		$this->input_sistolik <= 140 && */
		/* 		$this->input_diastolik <= 90 && */
		/* 		!empty($this->input_sistolik)  && */
		/* 		( */ 
		/* 			// jika sistolik tidak diantara 120 dan 130 untuk pasien kurang dari 64 tahun */
		/* 			(!in_array($this->input_sistolik, range(120, 130)) && $tanggal_lahir_object->diffInYears( $tanggal_object ) <65  ) || */
		/* 			// atau jika sistolik tidak diantara 130 dan 139 untuk pasien lebih dari 65 tahun */
		/* 			(!in_array($this->input_sistolik, range(130, 139)) && $tanggal_lahir_object->diffInYears( $tanggal_object ) >=65  ) */
		/* 		) */
		/* 	) { */
		/* 		if ($tanggal_lahir_object->diffInYears( $tanggal_object ) >= 65) { */
		/* 			return 130; */
		/* 		} else { */
		/* 			return 120; */
		/* 		} */
		/* 	} else { */
		/* 		return $this->input_sistolik; */
		/* 	} */
		/* } else { */
			return $this->input_sistolik;
		/* } */
	}

	private function sesuaikanDiastolikBPJS()
	{
		/* if ( */
		/* 	Asuransi::find($this->input_asuransi_id)->tipe_asuransi_id ==  5&& */
		/* 	$this->belum_ada_tekanan_darah_terkontrol */
		/* ) { */
		/* 	if ( */ 
		/* 		// jika target terkendali 10 % belum tercapai */
		/* 		$this->persenRpptTerkendali < 10 && */
		/* 		// jika pasien masuk dalam kategori prolanis ht */
		/* 		$this->input_pasien->prolanis_ht == '1' && */
		/* 		// jika nilai sistolik =< 140  dan diastolik =< 90 */
		/* 		$this->input_sistolik <= 140 && */
		/* 		$this->input_diastolik <= 90 && */
		/* 		!empty($this->input_diastolik)  && */
		/* 		// jika diastolik tidak diantara 70 dan 79 */
		/* 		(!in_array($this->input_diastolik, range(70, 79))) */
		/* 	) { */
		/* 		return 70; */
		/* 	} else { */
		/* 		return $this->input_diastolik; */
		/* 	} */
		/* } else { */
			return $this->input_diastolik;
		/* } */
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
		$denominaor_bpjs          = DenominatorBpjs::orderBy('bulanTahun', 'desc')->first();
		$peserta_bpjs_perbulan    = PesertaBpjsPerbulan::orderBy('bulanTahun', 'desc')->latest()->first();
		$jumlah_denominator_ht    = !is_null($denominaor_bpjs) ? $denominaor_bpjs->denominator_ht :0;
		$jumlah_denominator_dm    = !is_null($denominaor_bpjs) ? $denominaor_bpjs->denominator_dm :0;;
		$data_ht                  = $this->queryDataHt($tanggal_object);
		$data_ht_terkendali       = $this->dataHtTerkendali($data_ht);
		$jumlah_ht_terkendali     = count( $data_ht_terkendali );
		$persentase_ht_terkendali = !is_null($denominaor_bpjs) ? $jumlah_ht_terkendali / $jumlah_denominator_ht * 100 : 0;

		$data_dm                  = $this->queryDataDm($tanggal_object);
		$data_dm_terkendali       = $this->dataDmTerkendali($data_dm);
		$jumlah_dm_terkendali     = count($data_dm_terkendali);
		$persentase_dm_terkendali = !is_null($denominaor_bpjs) ? $jumlah_dm_terkendali / $jumlah_denominator_dm * 100 : 0;
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
		$query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
		// dimana pasien ini
		$query .= "WHERE pasien_id = '{$this->input_pasien_id}' ";
		// dengan asuransi bpjs (32)
		$query .= "AND asu.tipe_asuransi_id =  5 ";
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
			$query .= "AND prx.id not like '{$id}' ";
		}

		$query .= "AND prx.tenant_id = " . session()->get('tenant_id') . " ";
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
			$antrian->poli_id     = $periksa->poli_id;
			$antrian->periksa_id  = $periksa->periksa_id;
			$antrian->staf_id     = $periksa->staf_id;
			$antrian->asuransi_id = $periksa->asuransi_id;
			$antrian->asisten_id  = $periksa->asisten_id;
			$antrian->hamil       = $periksa->hamil;
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

			if (!isset($antarable_type)) {
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
		$query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
		//asuransi = bpjs
		$query .= "WHERE asu.tipe_asuransi_id =  5 ";
		//pada bulan dimana pemeriksaan dilakukan
		$query .= "AND prx.tanggal between '" . $tanggal_object->format('Y-m-01'). "' and '" . $tanggal_object->format('Y-m-t'). "' ";
		//pemeriksaan terflagging prolanis_ht
		$query .= "AND prx.prolanis_ht = '1' ";
		$query .= "AND prx.tenant_id = " . session()->get('tenant_id') . " ";
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
		$query .= "MIN(CAST(trx.keterangan_pemeriksaan AS UNSIGNED)) as gula_darah, ";
		$query .= "prx.diastolik ";
		$query .= "FROM periksas as prx ";
		$query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
		$query .= "JOIN transaksi_periksas as trx on prx.id = trx.periksa_id ";
		$query .= "JOIN jenis_tarifs as jtf on jtf.id = trx.jenis_tarif_id ";
		$query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
		//asuransi = bpjs
		$query .= "WHERE asu.tipe_asuransi_id =  5 ";
		//pada bulan dimana pemeriksaan dilakukan
		$query .= "AND prx.tanggal between '" . $tanggal_object->format('Y-m-01') . "' and  '" . date("Y-m-t", strtotime($tanggal_object->format('Y-m-t') )) . "' ";
		//pemeriksaan terflagging prolanis_dm
		$query .= "AND prx.prolanis_dm = '1'";
		$query .= "AND jtf.jenis_tarif = 'Gula Darah' ";
		$query .= "AND trx.keterangan_pemeriksaan > 0 ";
		$query .= "AND prx.tenant_id = " . session()->get('tenant_id') . " ";
		/* $query .= "AND CAST(trx.keterangan_pemeriksaan AS UNSIGNED) between 80 and 130 "; */
		$query .= "GROUP BY pasien_id ";
		$query .= "ORDER BY prx.id ";

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
	/**
	* undocumented function
	*
	* @return void
	*/
	private function banner_button(Periksa $periksa)
	{
		if (is_null($periksa->suratSakit)) {
			$banner_button = "<span> <button type=\"button\" onclick=\"cekMasihAda(this, " . $periksa->id. ");return false;\" class=\"btn btn-success btn-sm\">Buat Surat Sakit</button> <a href=" . url('suratsakits/create/' . $periksa->id . '/' . $periksa->poli_id ) . " class=\"btn btn-success btn-sm rujukan hide\">Buat Surat Sakit2</a> </span>" ;
		} else {
			$banner_button = "<span> <button type=\"button\" onclick=\"cekMasihAda(this, " . $periksa->id. ");return false;\" class=\"btn btn-warning btn-sm\">Edit Surat Sakit</button> <a href=" . url('suratsakits/' . $periksa->suratSakit->id . '/edit'. '/' . $periksa->poli_id ) . " class=\"btn btn-warning btn-sm rujukan hide\">Edit Surat Sakit</a> </span>" ;
		}

		if (is_null($periksa->rujukan)) {
			$banner_button .= "<span> <button type=\"button\" onclick=\"cekMasihAda(this, " . $periksa->id. ");return false;\" class=\"btn btn-success btn-sm\">Buat Rujukan</button> <a href=". url('rujukans/create/' . $periksa->id . '/' . $periksa->poli_id ). " class=\"btn btn-success btn-sm rujukan hide\">Buat Rujukan2</a> </span>";
		} else {
			$banner_button .= " <span> <button type=\"button\" onclick=\"cekMasihAda(this, " . $periksa->id. ");return false;\" class=\"btn btn-warning btn-sm\">Edit Rujukan</button> <a href=" . url('rujukans/' . $periksa->rujukan->id . '/edit/' . $periksa->poli_id )." class=\"btn btn-warning btn-sm rujukan hide\">Edit Rujukan2</a> </span>" ;
		}
		return $banner_button;
	}
    /**
     * undocumented function
     *
     * @return void
     */
    public static function kaliObat($transaksis, $terapi, $asuransi, $plafon, $poli){
        $transaksi_array = $transaksis;
        $non_paket       = true;
        foreach ($transaksi_array as $k => $v) {
            $tarif_ini = Tarif::where('jenis_tarif_id', $v['jenis_tarif_id'])->where('asuransi_id', $asuransi->id)->first();
            if ($tarif_ini->tipe_tindakan_id == 2) {
                $non_paket = false;
                $tarif_ini = $v;
                break;	
            }
        }
        $tarif = Tarif::queryTarif($asuransi->id, 3);
        if ($non_paket) {
            if($terapi != '' && $terapi != '[]'){
                /* $tarif = Tarif::where('jenis_tarif_id', '9')->where('asuransi_id', $asuransi->id)->first();//jenis tarif id = 9 adalah biaya obat */
                $terapis = json_decode($terapi, true);
                $merek = Merek::all();
                $biaya = 0;
                foreach ($terapis as $terapi) {
                    if ($asuransi->tipe_asuransi_id == 5) { //pembayaran BPJS
                        if ($terapi['fornas'] == '0') { // jika obat tidak tergolong fornas
                            $biaya += $merek->find($terapi['merek_id'])->rak->harga_jual * (int) $terapi['jumlah'];
                        } else {
                            $biaya += 0;
                        }
                    } else {
                        $biaya += $merek->find($terapi['merek_id'])->rak->harga_jual * (int) $terapi['jumlah'] * (int) $asuransi->kali_obat;
                    }
                }
                if ($asuransi->tipe_asuransi_id == 4) { //tipe asuransi pembayaran flat
                    $selisihPlafon = $plafon - $biaya;
                    if ( $selisihPlafon > 0) {
                        $biaya = $tarif->biaya;
                    } else {
                        $biaya = Tarif::queryTarif($asuransi->id, 3)->biaya - $selisihPlafon;
                    }
                }
                if (
                    $biaya < 30000 && 
                    str_contains($asuransi->nama, 'Cibadak') &&
                    $asuransi->tenant_id == 1
                ) {
                    $biaya = 30000;
                } else {
                    if ($poli != 'Poli Estetika') {
                        $biaya = Yoga::rataAtas5000($biaya);
                    }
                }
                $plus = [
                    'jenis_tarif_id' => $tarif->jenis_tarif_id,
                    'tipe_jenis_tarif_id' => $tarif->tipe_jenis_tarif_id,
                    'jenis_tarif'    => $tarif->jenis_tarif,
                    'biaya'          => $biaya
                ];
                array_unshift($transaksis, $plus);
            } else {
                $plus = [
                    'jenis_tarif_id' => $tarif->jenis_tarif_id,
                    'tipe_jenis_tarif_id' => $tarif->tipe_jenis_tarif_id,
                    'jenis_tarif'    => $tarif->jenis_tarif,
                    'biaya' => 0
                ];
                array_unshift($transaksis, $plus);
            }
        } else {
            $plus = [
                'jenis_tarif_id' => $tarif->jenis_tarif_id,
                'tipe_jenis_tarif_id' => $tarif->tipe_jenis_tarif_id,
                'jenis_tarif'    => $tarif->jenis_tarif,
                'biaya' => 0
            ];
            array_unshift($transaksis, $plus);
        }
        return $transaksis;
    }
    public function ruang_periksa($antrian){
        if($antrian){
            $ruang_periksa_id = $antrian->jenis_antrian_id;
        } else {
            $ruang_periksa_id = 5;
        }
        return $ruang_periksa_id;
    }

    /**
     * undocumented function
     *
     * @return void
     */
    private function inputData(Periksa $periksa)
    {
        //jika pasien sudah hilang dari antrian periksa, mungkin dia sudah diproses ke apotek
        //
        // return var_dump(json_decode(Input::get('terapi'), true));
        //Pada tahap ini ada beberapa yang perlu ditambahkan
        //BHP (Bahan Habis Pakai) ditambahkan dalam json transaksis bila tindakan tidak kosong
        //Biaya Obat ditambahkan ke dalam komponen transaksis bila terapis tidak kosonsg
        //Jasa dokter ditambahkan ke transaksis
        //Resep disesuaikan menurut formula dengan harga obat sesuai dengan jenis asuransi nya.
        //


        $pasien          = Pasien::find(Input::get('pasien_id'));
        $this->pasien = $pasien;
        //kumpulkan array yang akan di insert, delete atau update
        //

        $staf_updates    = [];
        $usgs            = [];
        $register_hamils = [];
        $register_ancs   = [];
        $gambar_updates  = [];
        $hamil_updates   = [];
        $bukan_pesertas  = [];
        $terapiInserts   = [];
        $promo_updates   = [];
        $timestamp       = date('Y-m-d H:i:s');

        //
        //Bila asuransi adalah BPJS dan staf belum notified, maka buat notified = 1, supaya tidak muncul peringatan berulang2
        //

        $asuransi = Asuransi::find(Input::get('asuransi_id'));

        $st       = Staf::find( Input::get('staf_id') );

        if (is_null($st)) {
            Log::info("==================================");
            Log::info("error nya disini");
            Log::info( Input::all() );
            Log::info("==================================");
        }
        if ( $asuransi->tipe_asuransi_id == 5 && Input::get('notified') == '0' ) {
            $st->notified = 1;
            $st->save();
        }


        //Buat collection tabel asuransi
        //UBAH RESEP MENURUT JENIS ASURANSI
        //sebelum terapi dimasukkan ke dalam periksa, obat harus disesuaikan dahulu, menurut asuransi nya.
        // untuk asuransi BPJS, obat akan dikonversi ke dalam merek yang paling murah yang memiliki formula yang sama
        // untuk asuransi admedika, obat akan dikonversi ke dalam merek paling mahal dalam formula yang sama
        // return var_dump(json_decode(Input::get('terapi'), true));
        
        $terapis = $this->sesuaikanResep(Input::get('terapi'), $asuransi);
        //sesuaikan Transaksi
        //
        $nama_poli = Poli::find( Input::get('poli_id') )->poli;
        $transaksis = $this->sesuaikanTransaksi(Input::get('transaksi'), $asuransi, $terapis, $nama_poli);

        //INPUT TRANSAKSI JAM MALAM
        //JIKA PASIEN DATANG > JAM 11 MALAM, untuk pasien umum dan admedika, maka ditambah 10 ribu untuk jam malam
        $this->periksa = $periksa;
        $this->asuransi = $asuransi;

        /* if ( $this->termasukPasienJamMalam()) { */
        /*     //tambahkan komponen jam malam sebesar 10 ribu */
        /*     $plus = [ */
        /*         'jenis_tarif_id' => JenisTarif::where('jenis_tarif', 'Jam Malam')->first()->id, */
        /*         'jenis_tarif'    => 'Jam Malam', */
        /*         'biaya'          => 10000 */
        /*     ]; */
        /*     array_push($transaksis, $plus); */
        /* } */

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
        $periksa->anamnesa              = Input::get('anamnesa');
        $periksa->asuransi_id           = $asuransi->id;
        $periksa->diagnosa_id           = Input::get('diagnosa_id');
        $periksa->pasien_id             = Input::get('pasien_id');
        $periksa->berat_badan           = Input::get('berat_badan');
        $periksa->poli_id               = Input::get('poli_id');
        $periksa->staf_id               = Input::get('staf_id');
        $periksa->asisten_id            = Input::get('asisten_id');
        $periksa->periksa_awal          = Input::get('periksa_awal');
        $periksa->jam                   = Input::get('jam');
        $periksa->hamil                 = Input::get('hamil');
        $periksa->jam_resep             = date('H:i:s');
        $periksa->keterangan_diagnosa   = Input::get('keterangan_diagnosa');
        $periksa->nomor_asuransi        = $pasien->nomor_asuransi;
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
        $periksa->kecelakaan_kerja      = $this->input_kecelakaan_kerja;
        $periksa->keterangan            = Input::get('keterangan_periksa');
        $periksa->transaksi             = json_encode($transaksis);
        $periksa->prolanis_dm           = $pasien->prolanis_dm;
        $periksa->prolanis_ht           = $pasien->prolanis_ht;
        $periksa->antrian_id            = $antrian_id;
        $periksa->save();


        $promo = Promo::where('promoable_type' , 'App\Models\AntrianPeriksa')->where('promoable_id', Input::get('antrian_periksa_id'))->first() ;
        if ( $promo ) {
            $promo->update([
                'promoable_type' => 'App\Models\Periksa',
                'promoable_id'   => $periksa->id,
            ]);
        }

        // jika ada bukan peserta
        if (!is_null($periksa->bukanPeserta)) {
            $periksa->bukanPeserta()->delete();
        }

        if ( Input::get('bukan_peserta') == '1' && is_null($periksa->bukanPeserta)) {
            $periksa->bukanPeserta()->create();
        } 

        //INPUT DATA UNTUK TERAPI
        //
        // return $terapis;
        $merek_ids     = [];
        foreach (json_decode($terapis, true) as $k => $t) {
            $merek_ids[] = $t['merek_id'];
        }
        $merekArray = Merek::with('rak.merek','rak.formula')->whereIn('id', $merek_ids)->get();

        $array = [];
        foreach ($merekArray as $v) {
            $array[$v->id] = $v;
        }

        // jika sudah ada terapi untuk pasien ini, hapuskan dan buat yang baru
        if ($periksa->terapii->count()) {
            $periksa->terapii()->delete();
        }

        foreach (json_decode($terapis, true) as $k => $t) {
            $submitted_merek_id = !is_null($array[$t['merek_id']]->rak->merek_default_id) ? $array[$t['merek_id']]->rak->merek_default_id : $t['merek_id'];
            $periksa->terapii()->create([
                'merek_id'          => $submitted_merek_id,
                'signa'             => $t['signa'],
                'cunam_id'          => $array[$t['merek_id']]->rak->formula->cunam_id,
                'aturan_minum'      => $t['aturan_minum'],
                'jumlah'            => $t['jumlah'],
                'harga_beli_satuan' => $array[$t['merek_id']]->rak->harga_beli,
                'harga_jual_satuan' => Yoga::hargaJualSatuan($asuransi, $t['merek_id']),
            ]);
        }

        if($nama_poli == 'Poli USG Kebidanan'){
            if (!is_null($periksa->usg)) {
                $periksa->usg()->delete();
            }
            $periksa->usg()->create([
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
            ]);

            $pasien->update([
                'riwayat_kehamilan_sebelumnya' => Input::get('riwayat_kehamilan_sebelumnya')
            ]);
        }

        if ($nama_poli == 'Poli ANC' || $nama_poli == 'Poli USG Kebidanan') {
            $hamil = RegisterHamil::where('g', Input::get('G'))->where('pasien_id', Input::get('pasien_id'))->first();

            if (is_null($hamil)) {
                $hamil = $pasien->registerHamil()->create($this->inputRegisterHamil());
            } else {
                $hamil->update($this->inputRegisterHamil());
            }

            $anc = RegisterAnc::where('periksa_id', $periksa->id)->where('register_hamil_id', $hamil->id)->first();

            if ( is_null($anc) ) {
                $hamil->registerAnc()->create( $this->inputRegisterAnc($periksa) );
            } else {
                $anc->update( $this->inputRegisterAnc($periksa) );
            }

        }

        //UPDATE pengantar tambahkan periksa_id
        //
        //

        $this->antrian = $this->antrianperiksa->antrian;
        $periksa->save();
        $this->updateTemplate(
            Input::get('antrian_periksa_id'), 
            $periksa->id, 
            $periksa
        );

        if ( $asuransi->tipe_asuransi_id ==  5) { // jika asuransi BPJS
            $pasien                          = $periksa->pasien;
            $pasien->sudah_kontak_bulan_ini = 1;
            $pasien->save();
            if (
                !is_null( Input::get('obat_dibayar_bpjs') )
            ) {
                $st->plafon_bpjs = Input::get('obat_dibayar_bpjs');
                $st->save();
            }
        }


        return $periksa;
    }

    /**
     * undocumented function
     *
     * @return void
     */
    private function inputRegisterHamil()
    {
        return [
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
    }
    
    /**
     * undocumented function
     *
     * @return void
     */
    private function inputRegisterAnc($periksa)
    {
        return [
                'periksa_id'               => $periksa->id,
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
    /**
     * undocumented function
     *
     * @return void
     */
    private function redirectBackIfAntrianPeriksaNotFound(){
        $this->antrianperiksa = AntrianPeriksa::find( Input::get('antrian_periksa_id') );
        if( is_null( $this->antrianperiksa) ){
            $pesan = Yoga::gagalFlash('Pasien sudah tidak ada di antrianperiksa, mungkin sudah dimasukkan atau buatlah antrian yang baru');
            return redirect()->back()->withPesan($pesan);
        }
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
    /**
     * undocumented function
     *
     * @return void
     */
    private function termasukPasienJamMalam()
    {
        $jam_malam_belum_diinput = true;
        foreach ($this->periksa->transaksii as $tr) {
            if ( $tr->jenisTarif->jenis_tarif == 'Jam Malam' ) {
                $jam_malam_belum_diinput = false;
                break;
            }
        }

        return Input::get('jam') > '23:00:00' || Input::get('jam') < '06:00:00' &&  // diantara jam 11 dan jam 6 pagi
            ($this->asuransi->id == 0 || $this->asuransi->tipe_asuransi_id == '3') && // dengan tipe asuransi biaya pribadi dan admedika
            $jam_malam_belum_diinput;
    }
    
}
