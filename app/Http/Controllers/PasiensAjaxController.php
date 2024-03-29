<?php

namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use DB;
use Auth;
use Hash;
use App\Models\AntrianPoli;
use App\Models\Odontogram;
use App\Models\Promo;
use App\Models\TaksonomiGigi;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Periksa;
use App\Models\Staf;
use App\Models\AntrianPeriksa;
use App\Models\Pasien;
use App\Models\Classes\Yoga;

class PasiensAjaxController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * GET /pasiensajax
	 *
	 * @return Response
	 */
	public $input_pasien_id;

	/**
	* @param 
	*/
	public function __construct()
	{
		$this->input_pasien_id = Input::get('pasien_id');
	}
	
	
	public function ajaxpasiens(){

		if(Input::ajax()){

			$ID_PASIEN     = Input::get('id');
		    $nama          = Input::get('nama');
			$namaPasien    = $this->pecah($nama);
		    $alamats       = Input::get('alamat');
            $array         = str_split($alamats);
			$alamat        = $this->pecah($alamats);
		    $tanggalLahir  = Input::get('tanggal_lahir');
		    $noTelp        = Input::get('no_telp');
		    $namaIbu       = Input::get('nama_ibu');
		    $namaAyah      = Input::get('nama_ayah');
		    $namaPeserta   = Input::get('nama_peserta');
		    $namaAsuransi  = Input::get('nama_asuransi');
		    $nomorAsuransi = Input::get('nomorAsuransi');
		    $sudah_kontak  = Input::get('sudah_kontak');

		    $displayed_rows = Input::get('displayed_rows');
		    $key = Input::get('key');
			$data = $this->queryData($ID_PASIEN, $namaPasien, $alamat, $tanggalLahir, $noTelp, $namaAsuransi, $nomorAsuransi, $namaPeserta, $namaIbu, $namaAyah, $sudah_kontak, $displayed_rows, $key);
			$count = $this->queryData($ID_PASIEN, $namaPasien, $alamat, $tanggalLahir, $noTelp, $namaAsuransi, $nomorAsuransi, $namaPeserta, $namaIbu, $namaAyah, $sudah_kontak, $displayed_rows, $key, true)[0]->jumlah;
			$pages = ceil( $count/ $displayed_rows );

			return [
				'data'  => $data,
				'pages' => $pages,
				'key'   => $key,
				'rows'  => $count
			];
		}
	}

	public function ajaxpasien(){


			$antrian = Input::get('antrian');
			$tanggal = Yoga::datePrep( Input::get('tanggal') );
			$pasien_id = Input::get('pasien_id');

			$nama = $this->countAntrian($antrian, $tanggal)['nama'];
			$pasien_pesan = $this->countPasien($pasien_id, $tanggal)['pasien_pesan'];

			$data = [
				'antrian' => $nama,
				'pasien' => $pasien_pesan
			];

			return json_encode($data);

	}

	public function create()
	{
		if(Input::ajax()){
			// return Yoga::inputKtpIfNotEmpty(Input::get('ktp_image'), $id);
			// return Yoga::inputImageIfNotEmpty(Input::get('image'), $id);
			// return Input::get('image');
			if (empty(trim(Input::get('asuransi_id')))) {
				$asuransi_id = 0;
			} else {
				$asuransi_id = Input::get('asuransi_id');
			}
			$pasien                 = new Pasien;
			$pasien->alamat         = Input::get('alamat');
			$pasien->asuransi_id    = $asuransi_id;
			$pasien->sex            = Input::get('sex');
			$pasien->jenis_peserta  = Input::get('jenis_peserta');
			$pasien->nama_ayah      = ucwords(strtolower(Input::get('nama_ayah')));
			$pasien->nama_ibu       = ucwords(strtolower(Input::get('nama_ibu')));
			$pasien->nama           = ucwords(strtolower(Input::get('nama')))  . ', ' . Input::get('panggilan');
			$pasien->nama_peserta   = ucwords(strtolower(Input::get('nama_peserta')));
			$pasien->nomor_asuransi = Input::get('nomor_asuransi');
            $asurnsi_bpjs = Asuransi::Bpjs();
			if ($asuransi_id == $asurnsi_bpjs->id) {
				$pasien->nomor_asuransi_bpjs = Input::get('nomor_asuransi');
			}
			$pasien->no_telp        = Input::get('no_telp');
			$pasien->tanggal_lahir  = Yoga::datePrep(Input::get('tanggal_lahir'));
			$pasien->bpjs_image     = $pasien->imageUpload('bpjs','bpjs_image', $id);
			$pasien->ktp_image      = $pasien->imageUpload('ktp', 'ktp_image', $id);
			$pasien->image          = Yoga::inputImageIfNotEmpty(Input::get('image'), $id);
		
			$pasien->save();

			$query = "SELECT asu.nama as nama_asuransi, ";
			$query .= "p.* ";
			$query .= "FROM pasiens as p ";
			$query .= "LEFT OUTER JOIN asuransis as asu on p.asuransi_id = asu.id ";
			$query .= "WHERE p.id = '" . $pasien->id . "' ";
			$query .= "AND tenant_id = " . session()->get('tenant_id') . " ";
			return DB::SELECT($query);

		} else {

			$validator = \Validator::make($data = Input::all(), Pasien::$rules);

			if ($validator->fails())

			{
				return \Redirect::back()->withErrors($validator)->withInput();
			}

			Pasien::create($data);

			return \Redirect::route('pasiens.index');
		}

	}

	public function cekbpjskontrol()
	{

		$pasien_id   = Input::get('pasien_id');
		$pasien = Pasien::find($pasien_id);
		$asuransi_id = $pasien->asuransi_id;
		$cekGDSBulanIni = Yoga::cekGDSBulanIni($pasien, null);
		$tanggal = $cekGDSBulanIni['tanggal'];
		$pemeriksaanTerakhir = Periksa::where('pasien_id', $pasien_id)->latest()->first();
		$pakaiBayarPribadi = Yoga::pakaiBayarPribadi($asuransi_id, $pasien_id, $pemeriksaanTerakhir);

		$tanggal_lahir = Yoga::datediff($pasien->tanggal_lahir, date('Y-m-d'));


		if(
			$pakaiBayarPribadi	 &&
			$cekGDSBulanIni['bayar'])
		{
			$kembali = [
				'kode' => '3', 
				'tanggal' => Yoga::updateDatePrep( $tanggal ),
				'tanggal_lahir' => $tanggal_lahir
			];
		} elseif($pakaiBayarPribadi){
			$kembali = [
				'kode' => '2',
				'tanggal' => Yoga::updateDatePrep($tanggal),
				'tanggal_lahir' => $tanggal_lahir
			];
		} elseif($cekGDSBulanIni['bayar']) {
			$kembali = [
				'kode' => '1', 
				'tanggal' => Yoga::updateDatePrep($tanggal),
				'tanggal_lahir' => $tanggal_lahir
			];
		} else {
			$kembali = [
				'kode' => '0', 
				'tanggal' => Yoga::updateDatePrep($tanggal),
				'tanggal_lahir' => $tanggal_lahir
			];
		}

		return json_encode($kembali);
	}

    public function confirm_staf(){
        $email = Input::get('email');
        $password = Input::get('password');
        $pasien_id = Input::get('pasien_id');
        //return Input::all();

        $user = User::where('email', $email)->first();
        if ($user) {
           $hashedPassword = $user->password; 
        } else {
            $pesan = Yoga::gagalFlash('User belum terdaftar');
            return redirect('pasiens')->withPesan($pesan);
        }

		if( Hash::check($password, $hashedPassword) ){
            $staf= Staf::where('email', $email)->first();
            //return $staf->id;
            $count = Periksa::where('pasien_id', $pasien_id)
                            ->where('staf_id', $staf->id)
                            ->count();
            if ($count > 0 || $email == 'yoga_email@yahoo.com') {
                $pesan = Yoga::suksesFlash('Anda diizinkan untuk melihat status pasien ini <strong>harap jaga kerahasiannya</strong>');
                return redirect('pasiens/' . Input::get('pasien_id'))->withPesan($pesan);
            }else{
                $pesan = Yoga::gagalFlash('Anda tidak memiliki wewenang untuk melihat riwayat pasien ini');
                return redirect('pasiens')->withPesan($pesan);
            }
		}else {
            $pesan = Yoga::gagalFlash('Kombinasi email / password <strong>salah</strong>');
			return redirect('pasiens')
			->withPesan($pesan);
		}

    }
    
	public function cariPasien(){

		$param = Input::get('q');
		
		$param = trim($param);


		$params = explode(" ", $param);

		$query = "SELECT * FROM pasiens where ";
		foreach ($params as $k => $param) {

			$data = '%';
			$arr = str_split($param, 1);

			foreach ($arr as $value) {
				$data .= $value . '%';
			}

			if ($k == 0) {
				$query .= "nama like '{$data}' and ";
			} else if( $k == 1 ){
				$query .= "DATE_FORMAT( tanggal_lahir, '%d-%m-%Y' ) like '{$data}' and ";
			} else if ($k == 2){
				$query .= "alamat like '{$data}' and ";
			}
		}

		$query = substr($query, 0, -5);
		$query .= "AND tenant_id = " . session()->get('tenant_id') . " ";
		$query .= ' limit 15;';
			
		$pasiens = DB::select($query);

		$data = [];

		foreach ($pasiens as $ps) {
			$data['items'][] = [
				 'id' => $ps->id,
				 'text' => $ps->nama,
				 'alamat' => $ps->alamat,
				 'tanggal_lahir' => Yoga::updateDatePrep( $ps->tanggal_lahir ),
				 'image' => $ps->image
			];
		}

		return json_encode($data);


	}
	public function cekAntrianPerTanggal(){
		$tanggal = Yoga::datePrep( Input::get('tanggal') );
		$antrian = Input::get('antrian');
		return Yoga::antrianTerakhir($tanggal);
	}
	
	private function countAntrian($antrian, $tanggal){
			/* $count_antrian_poli =  AntrianPoli::where('antrian', $antrian) */
			/* 						->where('tanggal', $tanggal) */
			/* 						->count(); */
			/* $count_antrian_periksa = AntrianPeriksa::where('antrian', $antrian) */
			/* 							->where('tanggal', $tanggal) */
			/* 							->count(); */
			/* $count = $count_antrian_poli + $count_antrian_periksa; */
			/* $nama = ''; */

			/* if($count_antrian_poli > 0){ */
			/* 	$nama = AntrianPoli::where('antrian', $antrian) */
			/* 			->where('tanggal', $tanggal) */
			/* 			->first()->pasien->nama; */
			/* 	$antrian = AntrianPoli::where('antrian', $antrian) */
			/* 			->where('tanggal', $tanggal) */
			/* 			->first()->antrian; */
				
			/* } else if ($count_antrian_periksa > 0){ */
			/* 	$nama = AntrianPeriksa::where('antrian', $antrian) */
			/* 			->where('tanggal', $tanggal) */
			/* 			->first()->pasien->nama; */

			/* 	$antrian = AntrianPeriksa::where('antrian', $antrian) */
			/* 			->where('tanggal', $tanggal) */
			/* 			->first()->antrian; */
			/* } */

			/* $antrian_pesan = ''; */
			/* if($count > 0){ */
			/* 	$antrian_pesan = $nama; */
			/* } else { */
			/* 	$antrian_pesan = ''; */
			/* } */
			/* return [ */
			/* 	 'count' => $count_antrian_poli + $count_antrian_periksa, */
			/* 	 'nama' => $nama */
			/* ]; */
	}


	private function countPasien($pasien_id, $tanggal){
		$count_pasien_poli = AntrianPoli::where('pasien_id', $pasien_id)
								->where('tanggal', $tanggal)
								->count();

		$count_pasien_poli = AntrianPeriksa::where('pasien_id', $pasien_id)
								->where('tanggal', $tanggal)
								->count();
		$count = $count_pasien_poli + $count_pasien_poli;

		$pasien_pesan = '';

		if($count > 0){
			$pasien_pesan = Pasien::find($pasien_id)->nama;
		}
		return [
			'pasien_pesan' => $pasien_pesan,
			'count' => $count
		];
	}
	public function cekPromo(){
		$no_ktp = Input::get('no_ktp');
		$tahun = date('Y');
		$count = Promo::where('tahun', $tahun)->where('no_ktp', $no_ktp)->count();
		return $count;
	}
	public function dataPasien(){
		$pasien_id = Input::get('pasien_id');
		$pasiens = Pasien::find($pasien_id);
		return $pasiens;
	}
	public function pecah($nama){
		$array = str_split($nama);
		$namaPasien = '';
		foreach ($array as $arr) {
			$namaPasien .= $arr . '%';
		}
		return $namaPasien;
	}
	private function queryData($ID_PASIEN, $namaPasien, $alamat, $tanggalLahir, $noTelp, $namaAsuransi, $nomorAsuransi, $namaPeserta, $namaIbu, $namaAyah, $sudah_kontak, $displayed_rows, $key, $count = false){
			$pass = $key * $displayed_rows;

			$query  = "SELECT ";
			if (!$count) {
				$query .= "p.asuransi_id, p.id as ID_PASIEN, ";
				$query .= "p.nama as namaPasien, ";
				$query .= "p.sudah_kontak_bulan_ini as sudah_berobat_bulan_ini, ";
				$query .= "p.alamat, ";
				$query .= "p.tanggal_lahir as tanggalLahir, ";
				$query .= "p.no_telp as noTelp, ";
				$query .= "asu.nama as namaAsuransi, ";
				$query .= "asu.tipe_asuransi_id as tipe_asuransi_id, ";
				$query .= "p.nomor_asuransi as nomorAsuransi, ";
				$query .= "p.nama_peserta as namaPeserta, ";
				$query .= "p.nama_ibu as namaIbu, ";
				$query .= "p.nama_ayah as namaAyah, ";
				$query .= "p.prolanis_dm as prolanis_dm, ";
				$query .= "p.prolanis_ht as prolanis_ht, ";
				$query .= "p.image as image ";
			} else {
				$query .= "count(p.id) as jumlah ";
			}
			$query .= "FROM pasiens as p left outer join asuransis as asu on p.asuransi_id = asu.id ";
			$query .= "WHERE ";
			$query .= "(p.id like ? or ? = '') ";
			$query .= "AND (p.nama like ? or ? = '') ";
			$query .= "AND (p.alamat like ? or ? = '') ";
			$query .= "AND (p.tanggal_lahir like ? or ? = '') ";
			$query .= "AND (p.no_telp like ? or ? = '') ";
			$query .= "AND (asu.nama like ? or ? = '') ";
			$query .= "AND (p.nomor_asuransi like ? or ? = '') ";
			$query .= "AND (p.nama_peserta like ? or ? = '') ";
			$query .= "AND (p.nama_ibu like ? or ? = '') ";
			$query .= "AND (p.nama_ayah like ? or ? = '') ";
			$query .= "AND (p.sudah_kontak_bulan_ini like ? or ? = '') ";
			$query .= "AND p.tenant_id = " . session()->get('tenant_id') . " ";
			$query .= "ORDER BY p.created_at DESC ";
			if (!$count) {
				$query .= "LIMIT {$pass}, {$displayed_rows} ";
			}
			$data = DB::select($query, [
				'%' . $ID_PASIEN . '%',
				$ID_PASIEN ,
				'%' . $namaPasien . '%',
				$namaPasien ,
				'%' . $alamat . '%',
				$alamat ,
				'%' . $tanggalLahir . '%',
				$tanggalLahir ,
				'%' . $noTelp . '%',
				$noTelp ,
				'%' . $namaAsuransi . '%',
				$namaAsuransi ,
				'%' . $nomorAsuransi . '%',
				$nomorAsuransi ,
				'%' . $namaPeserta . '%',
				$namaPeserta ,
				'%' . $namaIbu . '%',
				$namaIbu ,
				'%' . $namaAyah . '%',
				$namaAyah ,
				'%' . $sudah_kontak . '%',
				$sudah_kontak
			]);
			return $data;
	}
	public function ajaxTanggalLahir(){
		$tanggal_lahir = Input::get('tanggal_lahir_cek');
		$tanggal_lahir = Carbon::CreateFromFormat('d-m-Y', $tanggal_lahir)->format('Y-m-d');
		return Pasien::where('tanggal_lahir', $tanggal_lahir)->get(['nama', 'no_telp', 'alamat', 'id']);
	}
	public function cekNomorBpjsSama(){
		$nomor_bpjs = Input::get('nomor_bpjs');
		$pasien_id  = !is_null(Input::get('pasien_id')) ? Input::get('pasien_id') : '';
		$pasien     = Pasien::where('nomor_asuransi_bpjs', $nomor_bpjs)
											->where('id' , 'not like', $pasien_id)
											->first();
		if ( !is_null( $pasien ) && !empty($nomor_bpjs) ) {
			return [
				'duplikasi' => 1,
				'pasien'    => $pasien
			]; 
		} else {
			return [
				'duplikasi' => 0,
				'pasien'    => null
			]; 
		}
	}
	public function statusCekGDSBulanIni(){
		$bulanThn = date('Y-m');
		$query  = "SELECT count(*) as jumlah ";
		$query .= "FROM periksas as prx ";
		$query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
		$query .= "JOIN klaim_gdp_bpjs as kgd on kgd.periksa_id = prx.id ";
		$query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
		$query .= "JOIN transaksi_periksas as trx on trx.periksa_id = prx.id ";
		$query .= "JOIN jenis_tarifs as jtf on jtf.id = trx.jenis_tarif_id ";
		$query .= "WHERE prx.tanggal like '{$bulanThn}%' ";
		$query .= "AND prx.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND psn.id = '{$this->input_pasien_id}' ";
		$query .= "AND jtf.jenis_tarif ='Gula Darah' "; //gula darah
		$query .= "AND asu.tipe_asuransi_id =5 "; //bpjs
		$data = DB::select($query);
		return $data[0]->jumlah;
	}
    public function ajaxOdontogram(){
        $pasien_id         = Input::get('pasien_id');
        $taksonomi_gigi_id = Input::get('taksonomi_gigi_id');
        $taksonomi_gigi = TaksonomiGigi::find( $taksonomi_gigi_id );
        $odontogram       = Odontogram::with(
                                            'keadaanGigi.odontogramAbbreviation',
                                            'keadaanGigi.permukaanGigi',
                                            'keadaanGigi.odontogram.taksonomiGigi',
                                            'tindakanGigi',
                                            'taksonomiGigi'
                                        )
                                    ->where('pasien_id', $pasien_id)
                                    ->where('taksonomi_gigi_id', $taksonomi_gigi_id)
                                    ->first();
        if (is_null($odontogram)) {
            $odontogram = Odontogram::create([
                'pasien_id'         => $pasien_id,
                'taksonomi_gigi_id' => $taksonomi_gigi_id,
            ]);
            $odontogram = Odontogram::with(
                                            'keadaanGigi.odontogramAbbreviation',
                                            'keadaanGigi.permukaanGigi',
                                            'keadaanGigi.odontogram.taksonomiGigi',
                                            'tindakanGigi',
                                            'taksonomiGigi'
                                        )
                                    ->where('id', $odontogram->id)
                                    ->first();
        }

        $odontogram_id = $odontogram->id;
        $tenant_id = session()->get('tenant_id');
        $query  = "SELECT ";
        $query .= "prx.tanggal as tanggal, ";
        $query .= "jtf.jenis_tarif as jenis_tarif, ";
        $query .= "pmg.extension as permukaan_gigi, ";
        $query .= "trp.keterangan_pemeriksaan as keterangan_pemeriksaan ";
        $query .= "FROM periksas as prx ";
        $query .= "JOIN transaksi_periksas as trp on trp.periksa_id = prx.id ";
        $query .= "JOIN jenis_tarifs as jtf on trp.jenis_tarif_id = jtf.id ";
        $query .= "JOIN tindakan_gigis as tdg on tdg.transaksi_periksa_id = trp.id ";
        $query .= "JOIN permukaan_gigis as pmg on pmg.id = tdg.permukaan_gigi_id ";
        $query .= "WHERE prx.pasien_id = {$pasien_id} ";
        $query .= "AND tdg.odontogram_id = {$odontogram_id} ";
        $query .= "AND prx.tenant_id = {$tenant_id} ";
        $data = DB::select($query);

        $dd = [];
        foreach ($data as $d) {
            $dd[$d->tanggal]['tanggal'] = $d->tanggal;
            $dd[$d->tanggal]['tindakan'][] = [
                'jenis_tarif'            => $d->jenis_tarif,
                'keterangan_pemeriksaan' => $d->keterangan_pemeriksaan,
                'permukaan_gigi'         => $d->permukaan_gigi
            ];
        }

        $diagnosa_dan_tindakan = [];
        foreach ($dd as $da) {
            $diagnosa_dan_tindakan[] = $da;
        }

        $keadaanGigi = $this->keadaanGigi($pasien_id);
        return compact(
            'odontogram',
            'keadaanGigi',
            'taksonomi_gigi',
            'diagnosa_dan_tindakan',
        );
    }
    public function ajaxOdontogram2(){
        $pasien_id         = Input::get('pasien_id');
        $taksonomi_gigi_id = Input::get('taksonomi_gigi_id');
        $odontograms       = Odontogram::with(
                                            'keadaanGigi.odontogramAbbreviation',
                                            'keadaanGigi.permukaanGigi'
                                        )
                                    ->where('pasien_id', $pasien_id)
                                    ->where('taksonomi_gigi_id', $taksonomi_gigi_id)
                                    ->get();
        $taksonomi_gigis   = TaksonomiGigi::all();
        $odontogram_pasien = [];

        foreach ($taksonomi_gigis as $tak) {
            $exists = false;
            $keadaan_gigi = '';
            foreach ($odontograms as $odo) {
                if ($odo->taksonomi_gigi_id == $tak->id) {
                    $exists = true;
                    //
                    // keadaan gigi
                    //
                    foreach ($odo->keadaanGigi as $kg) {
                        $keadaan_gigi .= $kg->permukaanGigi->abbreviation . ': ';
                        $keadaan_gigi .= $kg->odontogramAbbreviation->abbreviation;
                    }
                }
            }
            if ( $exists ) {
                $odontogram_pasien[] = [
                    'taksonomi_gigi_id' => $tak->id,
                    'keadaan_gigi' => $keadaan_gigi
                ];
            } else {
                $odontogram_pasien[] = [
                    'taksonomi_gigi_id' => $tak->id,
                    'keadaan_gigi' => null
                ];
            }
        }
        return $odontogram_pasien;
    }
    /**
     * undocumented function
     *
     * @return void
     */
    public function keadaanGigi($pasien_id)
    {
        $odontograms = Odontogram::with(
                            'keadaanGigi.odontogramAbbreviation',
                            'keadaanGigi.permukaanGigi',
                            'keadaanGigi.odontogram',
                            'taksonomiGigi',
                            'tindakanGigi'
                        )->where('pasien_id', $pasien_id)
                         ->get();
        $taksonomis = TaksonomiGigi::all();
        $odontogram_by_taksonomi_id = [];
        foreach ($taksonomis as $tak) {
            $taksonomi_exist = false;
            foreach ($odontograms as $odo) {
                if ($tak->id == $odo->taksonomi_gigi_id) {
                    //tentukan taksonomi gigi
                    if (
                         !empty(  $tak->taksonomi_gigi_anak  ) && // jika tg anak tidak kosong
                         is_null( $odo->matur ) // dan odo matur null
                    ) {
                        // maka tampilkan keduanya
                        $taksonomi_gigi = $odo->taksonomiGigi->taksonomi_gigi . "/". $odo->taksonomiGigi->taksonomi_gigi_anak;
                    } else if (
                         !$odo->matur && // jika odo tidak matur
                         !empty(  $tak->taksonomi_gigi_anak  ) // dan ta g tidak kosong
                    ){
                        $taksonomi_gigi = '<s>'.$odo->taksonomiGigi->taksonomi_gigi . "</s>/". $odo->taksonomiGigi->taksonomi_gigi_anak; // maka tampilkan tg anak
                    } else if (
                         $odo->matur // jika odo matur
                    ) {
                        $taksonomi_gigi = !empty($odo->taksonomiGigi->taksonomi_gigi_anak) ? $odo->taksonomiGigi->taksonomi_gigi . "/<s>". $odo->taksonomiGigi->taksonomi_gigi_anak . '</s>' : $odo->taksonomiGigi->taksonomi_gigi; // maka tampilkan tg anak
                    } else if (
                         !$odo->matur && // jika odo tidak matur
                         empty(  $tak->taksonomi_gigi_anak  ) // dan ta g tidak kosong
                    ) {
                        $odo->matur = 1; // rubah menjadi matur
                        $odo->save();
                        $taksonomi_gigi = $odo->taksonomiGigi->taksonomi_gigi . "/<s>". $odo->taksonomiGigi->taksonomi_gigi_anak . '</s>'; // maka tampilkan tg anak
                    }

                    // resume keadaan gigi
                    $resume_keadaan_gigi = '';
                    $o = 0;
                    foreach ($odo->keadaanGigi as $k => $kg) {
                        if ( $kg->matur == $odo->matur ) {
                            if ($o > 0) {
                                $resume_keadaan_gigi .= ', ';
                            }
                            $resume_keadaan_gigi .= $kg->permukaanGigi->abbreviation . ': ' . $kg->odontogramAbbreviation->abbreviation;
                            $o++;
                        }
                    }

                    $odontogram_by_taksonomi_id[] = [
                        'matur'                => $odo->matur,
                        'taksonomi_gigi_id'    => $tak->id,
                        'jumlah_tindakan_gigi' => $odo->tindakanGigi->count(),
                        'taksonomi_gigi'       => $taksonomi_gigi,
                        'resume_keadaan_gigi'  => $resume_keadaan_gigi,
                        'keadaanGigi'          => $odo->keadaanGigi
                    ];
                    $taksonomi_exist = true;
                }
            }
            if (!$taksonomi_exist) {
                $odontogram_by_taksonomi_id[] = [
                    'matur'                => null,
                    'taksonomi_gigi_id'    => $tak->id,
                    'jumlah_tindakan_gigi' => 0,
                    'resume_keadaan_gigi'  => '',
                    'taksonomi_gigi'       => !empty($tak->taksonomi_gigi_anak) ? $tak->taksonomi_gigi . '/' . $tak->taksonomi_gigi_anak : $tak->taksonomi_gigi,
                    'keadaanGigi'          => []
                ];
            }
        }
        return  $odontogram_by_taksonomi_id ;
    }
    
}
