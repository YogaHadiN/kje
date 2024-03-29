<?php
namespace App\Http\Controllers;

use Input;
use Auth;
use Storage;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\AntrianPolisController;
use App\Http\Controllers\AntrianPeriksasController;
use App\Models\Classes\Yoga;
use App\Models\Poli;
use App\Models\Antrian;
use App\Models\Generik;
use App\Models\DenominatorBpjs;
use App\Rules\CekNomorBpjsSama;
use App\Rules\CekNomorKtpSama;
use App\Models\Alergi;
use App\Models\Periksa;
use App\Models\VerifikasiProlanis;
use App\Models\Pasien;
use App\Models\JenisPeserta;
use App\Models\Asuransi;
use App\Models\AntrianPoli;
use App\Models\Staf;
use DB;

class PasiensController extends Controller
{

	public $input_alamat;
	public $input_asuransi_id;
	public $input_sex;
	public $input_jenis_peserta_id;
	public $input_nama_ayah;
	public $input_nama_ibu;
	public $input_nama;
	public $input_poli_id;
	public $input_nama_peserta;
	public $input_nomor_asuransi;
	public $input_nomor_ktp;
	public $input_nomor_asuransi_bpjs;
	public $input_no_telp;
	public $input_tanggal_lahir;
	public $input_jangan_disms;
	public $input_antrian_id;
	public $input_punya_asuransi;
	public $input_bpjs_image;
	public $input_kartu_asuransi_image;
	public $input_ktp_image;
	public $input_image;
	public $input_prolanis_dm;
	public $input_prolanis_ht;
	public $dataIndexPasien;
	public $dataCreatePasien;
	public $input_verifikasi_prolanis_dm_id;
	public $input_verifikasi_prolanis_ht_id;
	public $input_meninggal;
	public $input_penangguhan_pembayaran_bpjs;
	public $rules;

    public $input_poli;
    public $input_antrian;
    public $input_nama_pasien_bpjs;
    public $input_pasien_id_bpjs;
    public $input_tanggal_lahir_pasien_bpjs;
    public $input_asuransi_id_bpjs;
    public $input_nama_asuransi_bpjs;
    public $input_image_bpjs;
    public $input_prolanis_dm_bpjs;
    public $input_prolanis_ht_bpjs;


   public function __construct(){
		$this->input_prolanis_ht                  = Input::get('prolanis_ht');
		$this->input_verifikasi_prolanis_dm_id    = Input::get('verifikasi_prolanis_dm_id');
		$this->input_verifikasi_prolanis_ht_id    = Input::get('verifikasi_prolanis_ht_id');
		$this->input_meninggal                    = Input::get('meninggal');
		$this->input_penangguhan_pembayaran_bpjs  = Input::get('penangguhan_pembayaran_bpjs');

        $this->middleware('super', ['only'       => 'delete']);
    }

	/**
	 * Display a listing of pasiens
	 *
	 * @return Response
	 */
	public function index()	{
        $this->populateDataIndexPasien();
		return view('pasiens.index', $this->dataIndexPasien);
	}

	/**
	 * Store a newly created pasien in storage.
	 *
	 * @return Response
	 */
	public function create(){
        $ps = new Pasien;
        $poli_gawat_darurat = Poli::gawatDarurat();

        $this->dataCreatePasien['asuransi_id_biaya_pribadi']= Asuransi::BiayaPribadi()->id;
        $this->dataCreatePasien['asuransi_id_bpjs']= Asuransi::Bpjs()->id;
        $this->dataCreatePasien['statusPernikahan']= $ps->statusPernikahan();
        $this->dataCreatePasien['asuransi']= Yoga::asuransiList();
        $this->dataCreatePasien['jenis_peserta']= JenisPeserta::pluck('jenis_peserta');
        $nursestation_available = \Auth::user()->tenant->nursestation_availability;
        if (
             !isset($this->dataCreatePasien['antrian']) &&
             $nursestation_available
        ) {
            $this->dataCreatePasien['poli']= [
                $poli_gawat_darurat->id => $poli_gawat_darurat->poli
            ];
        } else if ( !$nursestation_available ) {
            $this->dataCreatePasien['poli']= Poli::pluck('poli', 'id');
        }
        $this->dataCreatePasien['verifikasi_prolanis_options']= VerifikasiProlanis::pluck( 'verifikasi_prolanis', 'id');
        $this->dataCreatePasien['pasienSurvey']= $this->pasienSurvey();

		return view('pasiens.create', $this->dataCreatePasien);
	}
	
	public function store(Request $request){
        DB::beginTransaction();
        try {
            
            $dataNomorBpjs = [
                'asuransi_id'         => $request->asuransi_id,
                'nomor_asuransi'      => $request->nomor_asuransi,
                'nomor_asuransi_bpjs' => $request->nomor_asuransi_bpjs,
                'pasien_id'           => $request->pasien_id
            ];
            
            $rules["poli_id"]             = "required";
            $validator = \Validator::make(Input::all(), $this->rules( $rules, $dataNomorBpjs ));
            
            if ($validator->fails())
            {
                return \Redirect::back()->withErrors($validator)->withInput();
            }

            $pasien         = new Pasien;
            $pasien         = $this->inputDataPasien($pasien);
            if ( Auth::user()->tenant->nursestation_availability ) {
                $ap = $this->inputDataAntrianPoli($pasien);
                $pesan = Yoga::suksesFlash( '<strong>' . $pasien->id . ' - ' . $pasien->nama . '</strong> Berhasil dibuat dan berhasil masuk antrian Nurse Station' );
            } else {
                $ap = $this->inputDataAntrianPeriksa($pasien);
                $pesan = Yoga::suksesFlash( '<strong>' . $pasien->id . ' - ' . $pasien->nama . '</strong> Berhasil dibuat dan berhasil masuk antrian Periksa di ' . $ap->poli->poli  );
            }

            $apc                = new AntrianPolisController;
            $apc->input_antrian = Antrian::find( $this->input_antrian_id );
            $apc->updateAntrianDanKirimWa($ap);

			$apc->updateJumlahAntrian(false, null);
            DB::commit();

            if ( $this->input_antrian_id ) {
                return redirect('antrians/proses/' . $this->input_antrian_id)->withPesan($pesan);
            }

            return redirect('pasiens')->withPesan($pesan);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
	}
	
	public function show($id)
	{
        $periksas = Periksa::with(
            'pasien', 
            'staf' ,
            'asuransi', 
            'suratSakit', 
            'gambars', 
            'usg', 
            'registerAnc', 
            'rujukan.tujuanRujuk', 
            'terapii.merek', 
            'diagnosa.icd10'
        )->where('pasien_id', $id)->orderBy('tanggal', 'desc')->paginate(10);

        if($periksas->count() > 0){
            return view('pasiens.show', compact('periksas'));
        }else {
            return redirect('pasiens')->withPesan(Yoga::gagalFlash('Tidak ada Riwayat Untuk Ditampilkan'));
        }
	}

	/**
	 * Show the form for editing the specified pasien.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editAtAntrian($id, $antrian_id){
		$data = $this->editForm($id);
		$data['antrian_id'] = $antrian_id;
		return view('pasiens.edit', $data );
	}
	
	/**
	* undocumented function
	*
	* @return void
	*/
	private function editForm($id)
	{
		$pasien = Pasien::find($id);

		$statusPernikahan = array( null => '- Status Pernikahan -',
									'Pernah' => 'Pernah Menikah',
									'Belum' => 'Belum Menikah'
									);

		$asuransi =  Asuransi::list();

		$jenis_peserta = array(
			null => ' - pilih asuransi -',  
			"P" => 'Peserta',
			"S" => 'Suami',
			"I" => 'Istri',
			"A" => 'Anak'
		);

		$antrian_id = null;

		$staf = array('0' => '- Pilih Staf -') + Staf::pluck('nama', 'id')->all();
		$pasienSurvey = $this->pasienSurvey();
		$poli = Yoga::poliList();
		$verifikasi_prolanis_options = VerifikasiProlanis::pluck( 'verifikasi_prolanis', 'id');
		return compact(
			'pasien',
			'asuransi',
			'statusPernikahan',
			'verifikasi_prolanis_options',
			'pasienSurvey',
			'jenis_peserta',
			'antrian_id',
			'staf',
			'poli'
		);
	}
	
	
	public function edit($id)
	{
		return view('pasiens.edit', $this->editForm($id) );
	}

	/**
	 * Update the specified pasien in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request){
		$pasien = Pasien::findOrFail($id);

		$dataNomorBpjs = [
			'asuransi_id'         => $request->asuransi_id,
			'nomor_asuransi'      => $request->nomor_asuransi,
			'nomor_asuransi_bpjs' => $request->nomor_asuransi_bpjs,
			'pasien_id'           => $request->pasien_id
		];
		
		$validator = \Validator::make(Input::all(), $this->rules( [], $dataNomorBpjs, $id ));
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$pn = new Pasien;
		if (empty(trim(Input::get('asuransi_id')))) {
			$asuransi_id = 0;
		} else {
			$asuransi_id = Input::get('asuransi_id');
		}

		$pasien         = Pasien::find($id);
		$pasien         = $this->inputDataPasien($pasien);

		$antrian_id =  Input::get('antrian_id');
		if ( !empty( $antrian_id ) ) {
			return redirect("antrians/proses/" . $antrian_id)->withPesan(Yoga::suksesFlash('Data pasien <strong>' . $pasien->id . ' - ' . $pasien->nama . '</strong> berhasil dirubah'));
		} 

		if ( !empty( Input::get('back') ) ) {
			return redirect( Input::get('back') )->withPesan(Yoga::suksesFlash('Data pasien <strong>' . $pasien->id . ' - ' . $pasien->nama . '</strong> berhasil dirubah'));
		} 
		return \Redirect::route('pasiens.index')->withPesan(Yoga::suksesFlash('Data pasien <strong>' . $pasien->id . ' - ' . $pasien->nama . '</strong> berhasil dirubah'));
	}
	/**
	 * Remove the specified pasien from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$pasien = Pasien::find($id);
		if (!Pasien::destroy($id)) return redirect()->back();
		$pesan = Yoga::suksesFlash('Pasien ' . $id . ' - ' . $pasien->nama . ' berhasil dihapus');
		return \Redirect::route('pasiens.index')->withPesan($pesan);
	}
	
	private function pasienSurvey(){
		 return [ 
			'0' => 'Pasien tidak keberatan menerima SMS survey',
			'1' => 'Pasien keberatan menerima SMS survey'
	   	];
	}
	public function alergi($id){
		$alergies = Alergi::where('pasien_id', $id)->get();
		$pasien   = Pasien::find($id);
		return view('pasiens/alergi', compact(
			'alergies',
			'pasien'
		));
	}

	public function alergiCreate($id){
		$generiks = Generik::list();
		$pasien = Pasien::find($id);
		return view('pasiens/alergiCreate', compact(
			'generiks',
			'pasien'
		));
	}
	
	
	public function alergiDelete($id){
		$alergies = Alergi::where('pasien_id', $id)->get();
		return view('pasiens/alergi', compact(
			'alergies',
			'pasien'
		));
	}
	public function inputDataPasien($pasien){
        DB::beginTransaction();
        try {
            $pasien->alamat                      = Input::get('alamat');
            $pasien->prolanis_dm                 = Input::get('prolanis_dm');
            $pasien->prolanis_ht                 = $this->input_prolanis_ht;
            $pasien->asuransi_id                 = $this->asuransiId( Input::get('asuransi_id') );
            $pasien->sex                         = Input::get('sex');
            $pasien->jenis_peserta_id            = Input::get('jenis_peserta_id');
            $pasien->nama_ayah                   = Input::get('nama_ayah');
            $pasien->nama_ibu                    = Input::get('nama_ibu');
            $pasien->nama                        = Input::get('nama');
            $pasien->nama_peserta                = Input::get('nama_peserta');
            $pasien->nomor_asuransi              = Input::get('nomor_asuransi');
            $pasien->nomor_ktp                   = Input::get('nomor_ktp');
            $pasien->nomor_asuransi_bpjs         = Input::get('nomor_asuransi_bpjs');
            $pasien->no_telp                     = Input::get('no_telp');
            $pasien->verifikasi_prolanis_dm_id   = $this->input_verifikasi_prolanis_dm_id;
            $pasien->verifikasi_prolanis_ht_id   = $this->input_verifikasi_prolanis_ht_id;
            $pasien->hubungan_keluarga_id   = 4;
            $pasien->meninggal                   = $this->input_meninggal;
            $pasien->penangguhan_pembayaran_bpjs = $this->input_penangguhan_pembayaran_bpjs;
            $pasien->tanggal_lahir               = Yoga::datePrep(Input::get('tanggal_lahir'));
            $pasien->jangan_disms                = Input::get('jangan_disms');
            $pasien->save();


            $this->input_bpjs_image                 = $this->imageUpload('bpjs','bpjs_image', $pasien->id);
            $this->input_ktp_image                  = $this->imageUpload('ktp','ktp_image', $pasien->id);
            $this->input_kartu_asuransi_image       = $this->imageUpload('kartu_asuransi','kartu_asuransi_image', $pasien->id);
            $this->input_prolanis_dm_flagging_image = $this->imageUpload('prolanis_dm','prolanis_dm_flagging_image', $pasien->id);
            $this->input_prolanis_ht_flagging_image = $this->imageUpload('prolanis_ht','prolanis_ht_flagging_image', $pasien->id);
            $this->input_image                      = $this->imageUploadWajah('img', 'image', $pasien->id);

            if (!empty( $this->input_bpjs_image )) {
                $pasien->bpjs_image          = $this->input_bpjs_image;
            }
            if (!empty( $this->input_prolanis_dm_flagging_image )) {
                $pasien->prolanis_dm_flagging_image = $this->input_prolanis_dm_flagging_image;
            }
            if (!empty( $this->input_prolanis_ht_flagging_image )) {
                $pasien->prolanis_ht_flagging_image = $this->input_prolanis_ht_flagging_image;
            }
            if (!empty($this->input_ktp_image)) {
                $pasien->ktp_image           = $this->input_ktp_image;
            }
            if (!empty($this->input_kartu_asuransi_image)) {
                $pasien->kartu_asuransi_image           = $this->input_kartu_asuransi_image;
            }
            if (!empty($this->input_image)) {
                $pasien->image               = $this->input_image;
            }
            $pasien->save();
            DB::commit();
            return $pasien;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
	}

	public function asuransiId($asu_id){
		if (empty(trim($asu_id))) {
			$asuransi_id =  Asuransi::where('tipe_asuransi_id', 1)->first()->id;
            return $asuransi_id;
		} else {
			return $asu_id;
		}
	}
	public function nomorAsuransiBpjs($nomor_asuransi, $asur_id){
        $asuransi_bpjs = Asuransi::Bpjs();
		if ($asur_id == $asuransi_bpjs->id) {
			return Input::get('nomor_asuransi');
		}
		return null;
	}
	public function prolanisTerkendali(){
		return view('pasiens.prolanis_terkendali');
	}
	public function prolanisTerkendaliPerBulan(){
		$bulan      = Input::get('bulan');
		$tahun      = Input::get('tahun');

		$bulanTahun = $bulan . '-' . $tahun;
		$tahunBulan = $tahun . '-' . $bulan;

		$data = $this->queryDataProlanisPerBulan($tahunBulan);

		$prolanis_dm = [];
		$prolanis_ht = [];

		foreach ($data as $d) {
			$prolanis_ht = $this->templateProlanisPeriksa($prolanis_ht, $d, 'prolanis_ht');
			$prolanis_dm = $this->templateProlanisPeriksa($prolanis_dm, $d, 'prolanis_dm');
		}
		/* dd( compact('prolanis_dm', 'prolanis_ht') ); */
		return view('pasiens.prolanis_perbulan', compact(
			'prolanis_ht',
			'bulanTahun',
			'tahunBulan',
			'prolanis_dm'
		));
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	public function templateProlanisPeriksa($prolanis, $d, $jenis_prolanis)
	{
		$mperiksa = new Periksa;
		if ( $d->$jenis_prolanis ) {
			$prolanis[$d->periksa_id]['nama']                       = $d->nama;
			$prolanis[$d->periksa_id]['tanggal']                    = $d->tanggal;
			$prolanis[$d->periksa_id]['periksa_id']                 = $d->periksa_id;
			$prolanis[$d->periksa_id]['pasien_id']                  = $d->pasien_id;
			$prolanis[$d->periksa_id]['tanggal_lahir']              = $d->tanggal_lahir;
			$prolanis[$d->periksa_id]['alamat']                     = $d->alamat;
			$prolanis[$d->periksa_id]['sistolik']                   = $this->adaptSistolikToRppt($d->sistolik);
			$prolanis[$d->periksa_id]['diastolik']                  = $this->adaptDiastolikToRppt($d->diastolik);
			$prolanis[$d->periksa_id]['nama_asuransi']              = $d->nama_asuransi;
			$prolanis[$d->periksa_id]['nomor_asuransi']             = $d->nomor_asuransi;
			$prolanis[$d->periksa_id]['prolanis_ht_flagging_image'] = $d->prolanis_ht_flagging_image;
			if ( 
				$d->jenis_tarif_id == JenisTarif::where('jenis_tarif', 'Gula Darah')->first()->id
			) {
				$prolanis[$d->periksa_id]['gula_darah'] = $d->keterangan_pemeriksaan;
			}
		}
		return $prolanis;
	}

    public function adaptSistolikToRppt($value) {
        if (
            $value >= '140'
        ){
            return '130';
        } else {
           return $value;
        }
    }

    public function adaptDiastolikToRppt($value) {
        if (
            $value >= '80'
        ){
            return '70';
        } else {
           return $value;
        }
    }

	public function queryDataProlanisPerBulan($tahunBulan){
		$query  = "SELECT ";
		$query .= "prx.tanggal as tanggal, ";
		$query .= "psn.nama as nama, ";
		$query .= "jtf.jenis_tarif as jenis_tarif, ";
		$query .= "psn.prolanis_dm as prolanis_dm, ";
		$query .= "psn.id as pasien_id, ";
		$query .= "psn.prolanis_ht as prolanis_ht, ";
		$query .= "psn.tanggal_lahir as tanggal_lahir, ";
		$query .= "psn.prolanis_ht_flagging_image as prolanis_ht_flagging_image, ";
		$query .= "psn.alamat as alamat, ";
		$query .= "trx.keterangan_pemeriksaan as keterangan_pemeriksaan, ";
		$query .= "prx.sistolik as sistolik, ";
		$query .= "prx.diastolik as diastolik, ";
		$query .= "prx.nomor_asuransi as nomor_asuransi, ";
		$query .= "prx.id as periksa_id, ";
		$query .= "prx.prolanis_ht as prolanis_ht, ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "jtf.id as jenis_tarif_id ";
		$query .= "FROM periksas as prx ";
		$query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
		$query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
		$query .= "LEFT JOIN transaksi_periksas as trx on prx.id = trx.periksa_id ";
		$query .= "JOIN jenis_tarifs as jtf on jtf.id = trx.jenis_tarif_id ";
		$query .= "WHERE prx.tanggal like '{$tahunBulan}%' ";
		$query .= "AND prx.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND (prx.prolanis_ht = 1 or prx.prolanis_dm = 1) ";
		$query .= "AND asu.tipe_asuransi_id = 5 ";
		$query .= "ORDER BY ";
		$query .= "prx.sistolik DESC, ";
		$query .= "prx.diastolik DESC ";
		return DB::select($query);

	}
	public function inputDataAntrianPoli($pasien){
        DB::beginTransaction();
        try {
            
            $ap                    = new AntrianPolisController;
            $ap->input_pasien_id   = $pasien->id;
            $ap->input_asuransi_id = $pasien->asuransi_id;
            $ap->input_antrian_id  = $this->input_antrian_id;
            $ap->input_poli_id     = $this->poliId();
            $ap->input_tanggal     = date('Y-m-d');
            $ap->input_jam         = date("H:i:s");

            $data = $ap->inputDataAntrianPoli();
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
	}
	public function denominatorDm(){
		$pasiens  = Pasien::where('prolanis_dm', '1')->get();
		$prolanis = 'Diabetes Melitus';
		return view('prolanis.denominator', compact(
			'pasiens',
			'prolanis'
		));
	}
	public function denominatorHt(){
		$pasiens  = Pasien::where('prolanis_ht', '1')->get();
		$prolanis = 'Hipertensi';
		return view('prolanis.denominator', compact(
			'pasiens',
			'prolanis'
		));
	}
	public function imageUpload($pre, $fieldName, $id){
		if(Input::hasFile($fieldName)) {
            return $this->fileNameUploaded($pre, Input::file($fieldName), $id);
		} else {
			return null;
		}
	}
	private function imageUploadWajah($pre, $fieldName, $id){
		if(Input::hasFile($fieldName)) {

			$upload_cover = Input::file($fieldName);
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			/* $upload_cover = Image::make($upload_cover); */
			/* $upload_cover->fit(800, 600, function ($constraint) { */
			/* 	$constraint->upsize(); */
			/* }); */

			//membuat nama file random + extension
			$filename =	 $pre . $id . '_' . time() . '.' . $extension;

			/* dd( $filename ); */
			//menyimpan bpjs_image ke folder public/img
			$destination_path = 'img/pasien/';
			/* $destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/pasien/'; */
			// Mengambil file yang di upload

			/* $upload_cover->save($destination_path . '/' . $filename); */

			/* dd( $destination_path . $filename ); */
			Storage::disk('s3')->put( $destination_path. $filename, file_get_contents($upload_cover));
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return 'img/pasien/'. $filename;
			
		} else {
			return null;
		}
	}
	public function transaksi($id){
		$pasien = Pasien::find( $id );
		return view('pasiens.transaksi', compact('pasien'));
	}
	public function getTransaksi($id){
		$nama_asuransi = Input::get('nama_asuransi');
		$tanggal       = Input::get('tanggal');
		$piutang       = Input::get('piutang');
		$tunai         = Input::get('tunai');

		$query  = "SELECT ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "prx.tunai as tunai, ";
		$query .= "prx.id as id, ";
		$query .= "prx.pasien_id as pasien_id, ";
		$query .= "prx.piutang as piutang, ";
		$query .= "prx.tanggal as tanggal, ";
		$query .= "COALESCE(sum(pdb.pembayaran),0) as sudah_dibayar, ";
		$query .= "(prx.tunai + prx.piutang) as total ";
		$query .= "FROM periksas as prx ";
		$query .= "JOIN piutang_dibayars as pdb on pdb.periksa_id = prx.id ";
		$query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
		$query .= "WHERE (asu.nama like '%{$nama_asuransi}%' or '{$nama_asuransi}' = '') ";
		$query .= "AND prx.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND (prx.piutang like '{$piutang}%' or '{$piutang}' = '') ";
		$query .= "AND (prx.tunai like '{$tunai}%' or '{$tunai}' = '') ";
		$query .= "AND (prx.tanggal like '{$tanggal}%' or '{$tanggal}' = '') ";
		$query .= "AND prx.pasien_id = '{$id}' ";
		$query .= "GROUP BY prx.id ";
		$query .= "ORDER BY prx.tanggal desc ";
		$query .= "LIMIT 20";
		return DB::select($query);
	}
	public function dobel(){

		$query  = "SELECT ";
		$query .= "id, ";
		$query .= "updated_at, ";
		$query .= "nomor_asuransi_bpjs, ";
		$query .= "count(nomor_asuransi_bpjs) ";
		$query .= "FROM pasiens as psn ";
		$query .= "WHERE nomor_asuransi_bpjs not like '' ";
		$query .= "AND psn.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND nomor_asuransi_bpjs is not null ";
		$query .= "AND LENGTH(nomor_asuransi_bpjs) > 11 ";
		$query .= "GROUP BY nomor_asuransi_bpjs ";
		$query .= "HAVING count(nomor_asuransi_bpjs) > 1";
		$data = DB::select($query);

		$nomor_asuransi_bpjs = [];
		foreach ($data as $d) {
			$nomor_asuransi_bpjs[] = $d->nomor_asuransi_bpjs;
		}
		$nama = [];
		$pasiens = Pasien::whereIn('nomor_asuransi_bpjs', $nomor_asuransi_bpjs)
			->orderBy('nomor_asuransi_bpjs')
			->get();

		return view('pasiens.dobel', compact(
			'pasiens'
		));
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function rules($rules, $dataNomorBpjs, $id = null)
	{
			$rules["nama"]                = "required";
			$rules["nomor_asuransi_bpjs"] = new CekNomorBpjsSama($dataNomorBpjs);
			$rules["nomor_asuransi"]      = new CekNomorBpjsSama($dataNomorBpjs);
			$rules["nomor_ktp"]           = new CekNomorKtpSama($dataNomorBpjs['pasien_id']);
			$rules["sex"]                 = "required";

		if ( Input::get('punya_asuransi') == '1' ) {
			  $rules["asuransi_id"]    = "required";
			  $rules["jenis_peserta"]  = "required";
			  $rules["nomor_asuransi"] = "required";
		}

		/* dd( 'binggo', isset($id) , Storage::disk('s3')->exists( Pasien::find($id)->ktp_image ) ); */
		if (
			 Input::hasFile('ktp_image') ||
			 ( isset($id) && Storage::disk('s3')->exists( Pasien::find($id)->ktp_image ) )
		) {
			  $rules["nomor_ktp"]    =  ["required", new CekNomorKtpSama($dataNomorBpjs['pasien_id'])];
		}
		return $rules;
	}
	public function riwayat_pemeriksaan_gula_darah($id){
		$query  = "SELECT ";
		$query .= "psn.nama as nama_pasien, ";
		$query .= "prx.tanggal as tanggal, ";
		$query .= "trp.keterangan_pemeriksaan as gula_darah ";
		$query .= "FROM transaksi_periksas as trp ";
		$query .= "JOIN jenis_tarifs as jtf on jtf.id = trp.jenis_tarif_id ";
		$query .= "JOIN periksas as prx on prx.id = trp.periksa_id ";
		$query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
		$query .= "WHERE ";
		$query .= "prx.pasien_id = '{$id}' ";
		$query .= "AND trp.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND jtf.jenis_tarif = 'Gula Darah' "; // gula darah 
		$query .= "AND trp.keterangan_pemeriksaan REGEXP '^[0-9]+$' ";  // keterangan_pemeriksaan berbentuk number
		$query .= "ORDER BY prx.id desc";  // keterangan_pemeriksaan berbentuk number
		$data = DB::select($query);

        $pasien = Pasien::find($id);

		return view('pasiens.riwayat_pemeriksaan_gula_darah', compact(
            'data',
            'pasien'
		));
	}

    /**
     * undocumented function
     *
     * @return void
     */
    public function fileNameUploaded($pre, $upload_cover, $id)
    {
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			/* $upload_cover = Image::make($upload_cover); */
			/* $upload_cover->resize(1000, null, function ($constraint) { */
			/* 	$constraint->aspectRatio(); */
			/* 	$constraint->upsize(); */
			/* }); */

			//membuat nama file random + extension
			$filename =	 $pre . $id . '_' .  time().'.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			$destination_path =  'img/pasien/';

			//destinasi s3
			//
			Storage::disk('s3')->put($destination_path. $filename, file_get_contents($upload_cover));
			// Mengambil file yang di upload

			/* $upload_cover->save($destination_path . '/' . $filename); */
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return 'img/pasien/'. $filename;
    }

    /**
     * undocumented function
     *
     * @return void
     */
    private function dataIndexPasien()
    {
        $ps = new Pasien;
        $poli_gawat_darurat = Poli::gawatDarurat();
		return [
			'statusPernikahan'                   => $ps->statusPernikahan(),
			'asuransi_id_biaya_pribadi'                   => Asuransi::BiayaPribadi()->id,
			'asuransi'                           => Yoga::asuransiList(),
			'jenis_peserta'                      => JenisPeserta::pluck('jenis_peserta'),
			'poli'                               => [
                                                        null                    => '- Pilih Poli -',
                                                        $poli_gawat_darurat->id => $poli_gawat_darurat->poli
                                                    ],
            'peserta'                            => [ 
                                                        null => '- Pilih -', 
                                                        '0' => 'Peserta Klinik', 
                                                        '1' => 'Bukan Peserta Klinik'
                                                    ]
		];
    }
    
	
    /**
     * undocumented function
     *
     * @return void
     */
    private function dataCreatePasien()
    {
        $ps = new Pasien;
        $poli_gawat_darurat = Poli::gawatDarurat();
		return [
			'asuransi_id_biaya_pribadi'                   => Asuransi::BiayaPribadi()->id,
			'statusPernikahan'                   => $ps->statusPernikahan(),
			'asuransi'                           => Yoga::asuransiList(),
			'jenis_peserta'                      => JenisPeserta::pluck('jenis_peserta'),
			'poli'                               => [
				null                    => '- Pilih Poli -',
				$poli_gawat_darurat->id => $poli_gawat_darurat->poli
			],
			'verifikasi_prolanis_options'        => VerifikasiProlanis::pluck( 'verifikasi_prolanis', 'id'),
			'pasienSurvey'                       => $this->pasienSurvey()
		];
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function poliId()
    {
        return is_null( Input::get('poli_id') ) ? Poli::gawatDarurat()->id : Input::get('poli_id');
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function inputDataAntrianPeriksa($pasien)
    {
        DB::beginTransaction();
        try {
            $apcon                              = new AntrianPeriksasController;
            $apcon->input_sistolik              = '';
            $apcon->input_diastolik             = '';
            $apcon->input_berat_badan           = '';
            $apcon->input_tanggal               = date('d-m-Y');
            $apcon->input_suhu                  = '';
            $apcon->input_tinggi_badan          = '';
            $apcon->input_kecelakaan_kerja      = 0;
            $apcon->input_asuransi_id           = $pasien->asuransi_id;
            $apcon->input_hamil                 = 0;
            $apcon->input_menyusui              = 0;
            $apcon->input_asisten_id            = Input::get('staf_id');
            $apcon->input_asuransi_id           = $pasien->asuransi_id;
            $apcon->input_pasien_id             = $pasien->id;
            $apcon->input_pasien                = $pasien;
            $apcon->input_poli_id               = Input::get('poli_id');
            $apcon->input_staf_id               = Input::get('staf_id');
            $apcon->input_jam                   = date('H:i:s');
            $apcon->input_bukan_peserta         = 0;
            $apcon->input_tanggal               = date('d-m-Y');
            $apcon->input_gds                   = '';
            $apcon->input_sex                   = $pasien->sex;
            $apcon->g                           = '';
            $apcon->p                           = '';
            $apcon->a                           = '';
            $apcon->input_hpht                  = '';
            $apcon->previous_complaint_resolved = 1;
            $apcon->input_perujuk_id            = '';
            $apcon->input_alergi_obat           = 0;
            $apcon->input_memilih_obat_paten    = 1;
            $apcon->previous_complaint_resolved = 1;
            DB::commit();
            return $apcon->inputData();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    public function daftarkan($id){
        $this->populateDataIndexPasien();
        $this->dataIndexPasien['pasien'] = Pasien::find($id);
        return view('antrianpolis.create', $this->dataIndexPasien );
    }
    /**
     * undocumented function
     *
     * @return void
     */
    public function populateDataIndexPasien()
    {
        $ps = new Pasien;
        $this->dataIndexPasien['statusPernikahan']           = $ps->statusPernikahan();
        $this->dataIndexPasien['asuransi_id_biaya_pribadi' ] = Asuransi::BiayaPribadi()->id;
        $this->dataIndexPasien['asuransi_id_bpjs' ] = Asuransi::Bpjs()->id;
        $this->dataIndexPasien['asuransi']                   = Yoga::asuransiList();
        $this->dataIndexPasien['jenis_peserta']              = JenisPeserta::pluck('jenis_peserta');
        $this->dataIndexPasien['peserta']                    = [
                                                null => '- Pilih -',
                                                '0'  => 'Peserta Klinik',
                                                '1'  => 'Bukan Peserta Klinik'
                                            ];
        $poli_gawat_darurat = Poli::gawatDarurat();
        $nursestation_available = Auth::user()->tenant->nursestation_availability ;
        if (
            !isset($this->dataIndexPasien['antrian']) 
            &&  $nursestation_available
        ) {
            $this->dataIndexPasien['poli'] = [
                $poli_gawat_darurat->id => $poli_gawat_darurat->poli
            ];
        } else if ( !$nursestation_available) {
            $this->dataIndexPasien['poli'] = Poli::pluck('poli', 'id');
        } 
    }
    
    
    
    
    

    
			
	
	
}
