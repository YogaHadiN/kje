<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use Illuminate\Http\Request;
use Bitly;
use App\Http\Controllers\AntrianPeriksasController;
use App\Events\FormSubmitted;
use App\Models\Antrian;
use App\Models\JenisAntrian;
use App\Models\Sms;
use App\Models\Asuransi;
use App\Models\AntrianPeriksa;
use App\Models\Promo;
use App\Models\Periksa;
use App\Models\Perujuk;
use App\Models\Pasien;
use App\Models\AntrianPoli;
use App\Models\Complain;
use App\Models\Kabur;
use App\Models\Classes\Yoga;
use DB;

class AntrianPolisController extends Controller
{
	public $input_pasien_id;
	public $input_asuransi_id;
	public $input_poli;
	public $input_staf_id;
	public $input_tanggal;
	public $input_jam;
	public $input_kecelakaan_kerja;
	public $input_self_register;
	public $input_bukan_peserta;
	public $input_antrian_id;

	public function __construct() {
		$this->input_pasien_id     = Input::get('pasien_id');
		$this->input_asuransi_id   = Input::get('asuransi_id');
		$this->input_poli          = Input::get('poli');
		$this->input_staf_id       = Input::get('staf_id');
		$this->input_tanggal       = Yoga::datePrep( Input::get('tanggal') );
		$this->input_bukan_peserta = Input::get('bukan_peserta');
        /* $this->middleware('nomorAntrianUnik', ['only' => ['store']]); */
    }
	/**
	 * Display a listing of antrianpolis
	 *
	 * @return Response
	 */
	public function index()
	{
		$asu = array(null => '- Pilih Asuransi -') + Asuransi::pluck('nama', 'id')->all();
		$jenis_peserta = array(
			null => ' - pilih asuransi -',  
			"P"  => 'Peserta',
			"S"  => 'Suami',
			"I"  => 'Istri',
			"A"  => 'Anak'
		);
		$usg = array(
			null => ' - pilih -',  
			0    => 'Bukan USG',
			1    => 'USG'
		);

		$peserta = [ null => '- Pilih -', '0' => 'Peserta Klinik', '1' => 'Bukan Peserta Klinik'];
		$perujuks_list = [null => ' - pilih perujuk -'] + Perujuk::pluck('nama', 'id')->all();

		$antrianpolis  = AntrianPoli::with('pasien', 'asuransi', 'antars', 'antrian')
								->where('submitted', 0)
								->get();

		$perjanjian = [];
		$staf = Yoga::stafList();
		foreach ($antrianpolis as $p) {
			$perjanjian[$p->tanggal->format('d-m-Y')][] = $p;
		}

		foreach ($antrianpolis as $a) {
			if (empty( $a->pasien->tanggal_lahir )) {
				dd( $a->pasien->tanggal_lahir );
			}
		}

		return view('antrianpolis.index')
			->withAntrianpolis($antrianpolis)
			->with('perujuks_list', $perujuks_list)
			->withUsg($usg)
			->withAsu($asu)
			->withStaf($staf)
			->withPeserta($peserta)
			->withPerjanjian($perjanjian);
	}

	/**
	 * Show the form for creating a new antrianpoli
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('antrianpolis.create');
	}

	/**
	 * Store a newly created antrianpoli in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		DB::beginTransaction();
		try {
			$pasien = Pasien::find(Input::get('pasien_id'));

			if (
				empty($pasien->image)
			) {
				$pesan = Yoga::gagalFlash('Gambar <strong>Foto pasien</strong> harus dimasukkan terlebih dahulu');
				return redirect('pasiens/' . Input::get('pasien_id') . '/edit')
					->withPesan($pesan);
			}
			if (
				Input::get('asuransi_id') == '32' && // pasien bpjs
				(empty($pasien->ktp_image) || empty($pasien->bpjs_image)) && //jika ktp atau bpjs tidak bawa suruh bawa dulu
				$pasien->usia >= 18
			) {
				$pesan = Yoga::gagalFlash('Gambar <strong>gambar KTP pasien (bila DEWASA) </strong> untuk peserta asuransi harus dimasukkan terlebih dahulu');
				return redirect('pasiens/' . Input::get('pasien_id') . '/edit')
					->withPesan($pesan);
			}

			$rules = [
				'tanggal'   => 'required',
				'pasien_id' => 'required',
				'poli'      => 'required'
			];
			
			$validator = \Validator::make(Input::all(), $rules);
			
			if ($validator->fails())
			{
				return \Redirect::back()->withErrors($validator)->withInput();
			}

			//jika pasien memilih poli rapid test gak usah masuk nurse station
			//
			//
			$ap = $this->inputDataAntrianPoli();
			DB::commit();
			if (!is_null( $this->input_antrian_id )) {
				$antrian = Antrian::find( $this->input_antrian_id );
				if (
					$antrian->jenis_antrian_id == 7 ||
					$antrian->jenis_antrian_id == 8
				) {
					$request->merge([
						'hamil'            => 0,
						'kecelakaan_kerja' => 0,
						'asisten_id'       => 16
					]);
					$apx                            = new AntrianPeriksasController;
					$apx->input_jam                 = date('H:i:s');
					$apx->input_antrian_poli_id     = $ap->id;
					return $apx->store($request);
				}
			}
			return $this->arahkanAP($ap);
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
	}

	/**
	 * Display the specified antrianpoli.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$antrianpoli = AntrianPoli::findOrFail($id);
		return view('antrianpolis.show', compact('antrianpoli'));
	}

	/**
	 * Show the form for editing the specified antrianpoli.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$antrianpoli = AntrianPoli::find($id);

		return view('antrianpolis.edit', compact('antrianpoli'));
	}

	/**
	 * Update the specified antrianpoli in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$antrianpoli = AntrianPoli::findOrFail($id);

		$antrianpoli->update($data);

		return \Redirect::route('antrianpolis.index');
	}

	/**
	 * Remove the specified antrianpoli from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		$antrianpoli = AntrianPoli::find($id);
		$pasien_id = $antrianpoli->pasien_id;
		$nama = $antrianpoli->pasien->nama;

		$kabur            = new Kabur;
		$kabur->pasien_id = $pasien_id;
		$kabur->alasan    = Input::get('alasan_kabur');
		$conf             = $kabur->save();

		if ($conf) {
			$antrianpoli->delete();
		}



		return \Redirect::route('antrianpolis.index')->withPesan(Yoga::suksesFlash('pasien <strong>' .$pasien_id . ' -  ' . $nama .'</strong> berhasil dihapus dari Antrian'));
	}

    protected $morphClass = 'App\Models\AntrianPoli';
    public function promos(){
        return $this->morphMany('App\Models\Promo', 'jurnalable');
    }

	public function sendWaAntrian($totalAntrian, $ap){

		$tanggal            = $ap->tanggal;
		$antrian            = $ap->antrian;
		$no_telp            = $ap->pasien->no_telp;
		$no_telp_string     = $no_telp;
		$antrian_pasien_ini = array_search($antrian, $totalAntrian['antrians']) +1;
		/* if ( gethostname() == 'Yogas-Mac' ) { */
		$no_telp = '081381912803';
		/* } */
		$sisa_antrian =   $antrian_pasien_ini - $totalAntrian['antrian_saat_ini'] ;

		$text = 'Pasien Yth. Nomor Antrian Anda adalah \n\n *' . $antrian_pasien_ini ;
	    $text .=	'* \n\nAntrian yang diperiksa saat ini adalah\n\n *' . $totalAntrian['antrian_saat_ini'];
		$text .= '* \n\nSaat ini (' . date('d M y H:i:s'). ') Masih ada\n\n *';
		$text .= $sisa_antrian . ' antrian lagi*\n\n';
		$text .= 'Sebelum giliran anda dipanggil. ';
		$text .= 'Mohon agar dapat membuka link berikut untuk mengetahui antrian terakhir secara berkala: \n\n';
		$text .= Bitly::getUrl('http://45.76.186.44/antrianperiksa/' . $ap->id);
		/* $text .= '\n\n.'; */
		/* $text .= $no_telp_string; */
		/* $text .= '\n\n.'; */
		/* $text .= '\nBapak/Ibu dapat menunggu antrian periksa di rumah, dan datang kembali ke klinik saat antrian sudah dekat, untuk mencegah menunggu terlalu lama, dan mencegah penularan penyakit. Terima kasih'; */
		/* $text .= 'Sistem akan mengirimkan whatsapp untuk mengingatkan anda jika tersisa 5 antrian lagi dan 1 antrian lagi sebelum anda dipanggil. Terima kasih' ; */

		Sms::send($no_telp, $text);

	}
	public function totalAntrian($ap){
		/* $tanggal = $ap->tanggal; */
		/* $antrian = $ap->antrian; */
		/* $no_telp = $ap->pasien->no_telp; */
		/* $antrians = []; */
		/* $apx_per_tanggal = AntrianPeriksa::where('tanggal',  $tanggal) */
		/* 								->whereIn('poli', ['umum', 'sks', 'luka']) */
		/* 								->get(); */
		/* $apl_per_tanggal = AntrianPoli::where('tanggal',  $tanggal) */
		/* 								->whereIn('poli', ['umum', 'sks', 'luka']) */
		/* 								->get(); */
		/* $px_per_tanggal = Periksa::where('tanggal',  $tanggal) */
		/* 								->whereIn('poli', ['umum', 'sks', 'luka']) */
		/* 								->orderBy('antrian', 'desc') */
		/* 								->get(); */

		/* foreach ($apx_per_tanggal as $apx) { */
		/* 	$antrians[$apx->pasien_id] = $apx->antrian; */
		/* } */

		/* foreach ($apl_per_tanggal as $apx) { */
		/* 	$antrians[$apx->pasien_id] = $apx->antrian; */
		/* } */
		/* foreach ($px_per_tanggal as $apx) { */
		/* 	$antrians[$apx->pasien_id] = $apx->antrian; */
		/* } */

		/* sort($antrians); */
		/* if ( $px_per_tanggal->count() >2 ) { */
		/* 	$antrian_saat_ini   = array_search($px_per_tanggal->first()->antrian, $antrians); */
		/* } else { */
		/* 	$antrian_saat_ini   = 0; */
		/* } */

		/* $result = compact( */
		/* 	'antrians', */
		/* 	'antrian_saat_ini' */
		/* ); */
		/* return $result; */
	}
	public function inputDataAntrianPoli(){
		$ap                            = new AntrianPoli;
		$ap->asuransi_id               = $this->input_asuransi_id;
		$ap->pasien_id                 = $this->input_pasien_id;
		$ap->poli                      = $this->input_poli;
		$ap->staf_id                   = $this->input_staf_id;
		if ( $this->input_asuransi_id == '32' ) {
			$ap->bukan_peserta         = $this->input_bukan_peserta;
		}
		$ap->jam                       = date("H:i:s");
		$ap->tanggal                   = $this->input_tanggal;
		$ap->save();

		if ( isset($this->input_antrian_id) ) {
			$antrian_id         = $this->input_antrian_id;
			$an                 = Antrian::find($antrian_id);
			$an->antriable_id   = $ap->id;
			$an->antriable_type = 'App\\Models\\AntrianPoli';

			$an->save();
		}
		return $ap;

	}

	public function arahkanAP($ap){
		$pasien = Pasien::find($this->input_pasien_id);
		$pesan = Yoga::suksesFlash('<strong>' . $pasien->id . ' - ' . $pasien->nama . '</strong> Berhasil masuk antrian Nurse Station Dan <strong>Komplain berhasil didokumentasikan</strong>');
		if ($this->input_asuransi_id == '32') {
			return redirect('antrianpolis/pengantar/' . $ap->id)->withPesan(Yoga::suksesFlash('Harap Isi dulu pengantar pasien sebagai data kunjungan sehat'));
		}

		if ( $ap->poli == 'usg' ) {
			return redirect('antrianpolis')
				->withPrint($ap)
				->withPesan($pesan);
		}
		return redirect('antrianpolis')
			->withPesan($pesan);
	}
	public function updateJumlahAntrian($panggil_pasien = true){
		/* $antrians       = Antrian::with( */
		/* 							'jenis_antrian.poli_antrian', */ 
		/* 							'antriable', */ 
		/* 							'jenis_antrian.antrian_terakhir' */
		/* 						) */
		/* 						->where('created_at', 'like', date('Y-m-d') . '%') */
		/* 						->where('antriable_type', 'not like', 'App\\\Periksa') */
		/* 						->orderBy('id') */
		/* 						->get(); */
		/* $jenis_antrian  = JenisAntrian::with('antrian_terakhir.jenis_antrian', 'antrian_terakhir.antriable')->orderBy('updated_at', 'desc')->get(); */

		/* $antriable_type = $jenis_antrian->first()->antrian_terakhir->antriable_type; */
		/* $jenis_antrians = JenisAntrian::all(); */
		/* foreach ($jenis_antrians as $jt) { */
		/* 	$data['antrian_terakhir_per_poli'][$jt->id] = '-'; */
		/* } */
		/* $exclude_from_type                                    = []; */
		/* $reversed_antrians                                    = $antrians->reverse(); */
		/* $data['antrian_terakhir_per_poli']['antrian_kasir']   = '-'; */
		/* $data['antrian_terakhir_per_poli']['antrian_farmasi'] = '-'; */

		/* foreach ($antrians as $ant) { */
		/* 	if ( */
		/* 		$ant->antriable_type !== 'App\AntrianApotek' && */
		/* 		$ant->antriable_type !== 'App\Antrian' && */
		/* 		$ant->antriable_type !== 'App\AntrianKasir' && */
		/* 		$ant->antriable_type !== 'App\AntrianFarmasi' && */
		/* 		$ant->antriable->dipanggil > 0 */
		/* 	) { */
		/* 		$data['antrian_terakhir_per_poli'][$ant->jenis_antrian_id] = $ant->nomor_antrian; */
		/* 	} */

		/* 	if ( */
		/* 		( */ 
		/* 			$ant->antriable_type == 'App\AntrianApotek' || */ 
		/* 			$ant->antriable_type == 'App\AntrianKasir' */ 
		/* 		) && */
		/* 		$ant->antriable->dipanggil > 0 */
		/* 	) { */
		/* 		$data['antrian_terakhir_per_poli']['antrian_kasir'] =  $ant->nomor_antrian; */
		/* 	} */

		/* 	if ( */
		/* 		( $ant->antriable_type == 'App\AntrianFarmasi' ) && */
		/* 		$ant->antriable->dipanggil > 0 */
		/* 	) { */
		/* 		/1* dd( $ant ); *1/ */
		/* 		$data['antrian_terakhir_per_poli']['antrian_farmasi'] =  $ant->nomor_antrian; */
		/* 	} */
		/* } */
		/* /1* dd('data'); *1/ */
		/* /1* dd($data['antrian_terakhir_per_poli']); *1/ */
		/* if ( $panggil_pasien ) { */
		/* 	$antrian_dipanggil = $antrians->sortByDesc('updated_at')->first(); */
		/* 	$data['panggilan']['nomor_antrian'] = $antrian_dipanggil->nomor_antrian; */
		/* 	if ( */
		/* 		$antrian_dipanggil->antriable_type == 'App\Antrian' */
		/* 	) { */
		/* 		$data['panggilan']['poli'] = 'Pendaftaran'; */
		/* 	} else if ( */
		/* 		$antrian_dipanggil->antriable_type == 'App\AntrianApotek' || */ 
		/* 		$antrian_dipanggil->antriable_type == 'App\AntrianKasir' */
		/* 	) { */
		/* 		$data['panggilan']['poli']                          = 'Antrian Kasir'; */
		/* 	} else if ( */
		/* 		$antrian_dipanggil->antriable_type == 'App\AntrianFarmasi' */
		/* 	){ */
		/* 		$data['panggilan']['poli'] = 'Antrian Farmasi'; */
		/* 	} else { */
		/* 		$data['panggilan']['poli'] = ucwords($antrian_dipanggil->jenis_antrian->jenis_antrian); */
		/* 	} */
		/* } */

		/* foreach ($antrians as $antrian) { */
		/* 	if ( */
		/* 		$antrian->antriable_type !== 'App\Antrian' && */
		/* 		$antrian->antriable_type !== 'App\AntrianApotek' && */
		/* 		$antrian->antriable_type !== 'App\AntrianKasir' && */
		/* 		$antrian->antriable_type !== 'App\AntrianFarmasi' */
		/* 	) { */
		/* 		if ( */
		/* 			isset($antrian->jenis_antrian->antrian_terakhir) */
		/* 		) { */
		/* 			$data['data'][ $antrian->jenis_antrian_id ]['nomor_antrian_terakhir'] = $antrian->jenis_antrian->antrian_terakhir->nomor_antrian; */
		/* 		} else { */
		/* 			$data['data'][ $antrian->jenis_antrian_id ]['nomor_antrian_terakhir'] = '-'; */
		/* 		} */
		/* 	} */
		/* } */

		/* foreach ($antrians as $antrian) { */
		/* 	if ( */
		/* 		$antrian->antriable_type == 'App\Antrian' */
		/* 	) { */
		/* 		if ( */
		/* 			isset($antrian->jenis_antrian->antrian_terakhir) */
		/* 		) { */
		/* 			$data['data']['antrian_pendaftaran']['nomor_antrian_terakhir'] = $antrian->jenis_antrian->antrian_terakhir->nomor_antrian; */
		/* 		} else { */
		/* 			$data['data']['antrian_pendaftaran']['nomor_antrian_terakhir'] = '-'; */
		/* 		} */
		/* 	} else if ( */
		/* 		$antrian->antriable_type == 'App\AntrianApotek' && */
		/* 		$antrian->antriable_type == 'App\AntrianKasir' */
		/* 	){ */
		/* 		if ( */
		/* 			isset($antrian->jenis_antrian->antrian_terakhir) */
		/* 		) { */
		/* 			$data['data']['antrian_kasir']['nomor_antrian_terakhir'] = $antrian->jenis_antrian->antrian_terakhir->nomor_antrian; */
		/* 		} else { */
		/* 			$data['data']['antrian_kasir']['nomor_antrian_terakhir'] = '-'; */
		/* 		} */
		/* 	} else if ( */
		/* 		$antrian->antriable_type == 'App\AntrianFarmasi' */
		/* 	){ */
		/* 		if ( */
		/* 			isset($antrian->jenis_antrian->antrian_terakhir) */
		/* 		) { */
		/* 			$data['data']['antrian_farmasi']['nomor_antrian_terakhir'] = $antrian->jenis_antrian->antrian_terakhir->nomor_antrian; */
		/* 		} else { */
		/* 			$data['data']['antrian_farmasi']['nomor_antrian_terakhir'] = '-'; */
		/* 		} */
		/* 	} */
		/* } */

		/* foreach ($jenis_antrian as $ja) { */
		/* 	if (!isset($data['data'][$ja->id]) && $ja->id <5) { */
		/* 		$data['data'][$ja->id]['nomor_antrian_terakhir'] = '-'; */
		/* 		$data['data'][$ja->id]['jumlah']                 = 0; */
		/* 	} */
		/* } */
		/* $bisa                 = []; */
		/* $tidak_bisa           = []; */
		/* $antrian_terkahir_ids = []; */
		/* foreach ($jenis_antrians as $j) { */
		/* 	if ( isset( $j->antrian_terakhir_id ) ) { */
		/* 		$antrian_terkahir_ids[] = $j->antrian_terakhir->nomor_antrian; */
		/* 		$data['jenis_antrian_ids'][] = */ 
		/* 			[ */
		/* 				'id'                     => $j->id, */
		/* 				'nomor_antrian_terakhir' => $j->antrian_terakhir->nomor_antrian, */
		/* 				'antriable_type' => $j->antrian_terakhir->antriable_type */
		/* 			]; */
		/* 	} */
		/* } */

		/* $data['antrian_by_type']['antrian_kasir']   = []; */
		/* $data['antrian_by_type']['antrian_farmasi']   = []; */
		/* $data['antrian_by_type']['antrian_periksa'] = []; */


		/* /1* dd( $data['antrian_terakhir_per_poli'] ); *1/ */
		/* $include_only = $data['antrian_terakhir_per_poli']; */
		/* /1* dd('include_only1', $include_only ); *1/ */
		/* unset( $include_only['antrian_pendaftaran'] ); */
		/* /1* dd('include_only', $include_only ); *1/ */

		/* foreach ($antrians as $ant) { */
		/* 	if (!in_array( $ant->nomor_antrian, $include_only)) { */
		/* 		if ( */
		/* 			$ant->antriable_type == 'App\Antrian' || */
		/* 			$ant->antriable_type == 'App\AntrianPeriksa' || */
		/* 			$ant->antriable_type == 'App\AntrianPoli' */
		/* 		) { */
		/* 			$data['antrian_by_type']['antrian_periksa'][$ant->jenis_antrian_id][] = [ */
		/* 				'nomor_antrian'  => $ant->nomor_antrian, */
		/* 				'antriable_type' => $ant->antriable_type */
		/* 			]; */
		/* 		} else if ( */
		/* 			( */
		/* 				$ant->antriable_type == 'App\AntrianApotek' || */
		/* 				$ant->antriable_type == 'App\AntrianKasir' */
		/* 			) && $ant->antriable->periksa->asuransi_id == '0' */
		/* 		) { */
		/* 			$data['antrian_by_type']['antrian_kasir'][] = [ */
		/* 				'nomor_antrian'   => $ant->nomor_antrian, */
		/* 				'antriable_type'  => $ant->antriable_type, */
		/* 				'selesai_periksa' => $ant->antriable->periksa->created_at */
		/* 			]; */
		/* 		} else if ( */
		/* 			$ant->antriable_type == 'App\AntrianFarmasi' */
		/* 		) { */
		/* 			$data['antrian_by_type']['antrian_farmasi'][] = [ */
		/* 				'nomor_antrian'   => $ant->nomor_antrian, */
		/* 				'antriable_type'  => $ant->antriable_type, */
		/* 				'selesai_periksa' => $ant->antriable->periksa->created_at */
		/* 			]; */
		/* 		} else { */
		/* 			if (!isset($data['antrian_by_type'][$ant->antriable_type])) { */
		/* 				$data['antrian_by_type'][$ant->antriable_type] = []; */
		/* 			} */
		/* 			$data['antrian_by_type'][$ant->antriable_type][] = [ */
		/* 				'nomor_antrian'  => $ant->nomor_antrian, */
		/* 				'antriable_type' => $ant->antriable_type */
		/* 			]; */
		/* 		} */
		/*     } */
		/* } */
		/* $columns = array_column($data['antrian_by_type']['antrian_kasir'], 'selesai_periksa'); */
		/* array_multisort($columns, SORT_ASC, $data['antrian_by_type']['antrian_kasir']); */

		/* $columns = array_column($data['antrian_by_type']['antrian_farmasi'], 'selesai_periksa'); */
		/* array_multisort($columns, SORT_ASC, $data['antrian_by_type']['antrian_farmasi']); */

		event(new FormSubmitted($panggil_pasien));
	}
}
