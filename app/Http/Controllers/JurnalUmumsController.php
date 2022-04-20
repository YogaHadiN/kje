<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Models\JurnalUmum;
use Carbon\Carbon;
use App\Models\Manual;
use App\Models\FakturBelanja;
use App\Models\Penyusutan;
use App\Models\BahanBangunan;
use App\Console\Command\JadwalPenyusutan;
use App\Models\GolonganPeralatan;
use App\Models\GoPay;
use App\Models\Pengeluaran;
use App\Models\PeraturanPenyusutan;
use App\Models\RingkasanPenyusutan;
use App\Models\Periksa;
use App\Models\KelompokCoa;
use App\Models\Modal;
use App\Models\BukanObat;
use App\Models\CheckoutKasir;
use App\Models\Classes\Yoga;
use App\Models\Coa;
use Session;
use App\Models\Ac;
use App\Models\ServiceAc;
use App\Models\BelanjaPeralatan;
use DB;


class JurnalUmumsController extends Controller
{


	public function __construct()
	 {
		 $this->middleware('super', ['only' => [
			 'index',
			 'show',
			 'edit',
			 'destroy',
			 'update'
		 ]]);
		 $this->middleware('notready', ['only' => [
			 'show',
			 'normalisasi'
		 ]]);
		 $this->middleware('normalisasi', ['only' => [
			 'normalisasi'
		 ]]);
	 }
	/**
	 * Display a listing of jurnalumums
	 *
	 * @return Response
	 */
    public function index(){
    	return view('jurnal_umums.index');
    }
    
	public function show()
	{

        $bulan = Input::get('bulan');
        $tahun = Input::get('tahun');
        $jurnalumums = JurnalUmum::with('coa')->groupBy('jurnalable_id')
            ->groupBy('jurnalable_type')
            ->orderBy('created_at', 'desc')
            ->where('created_at', 'like', $tahun . '-' . $bulan . '%')
            ->paginate(10);
		return view('jurnal_umums.show', compact(
			'bulan',
			'tahun',
			'jurnalumums'
		));
	}

	/**
	 * Show the form for creating a new jurnalumum
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('jurnalumums.create');
	}

	/**
	 * Store a newly created jurnalumum in storage.
	 *
	 * @return Response
	 */
	public function coa()
	{
		if (session()->has('route_coa')) {
			$route = session('route_coa');
		} else {
			$route = 'laporans';
		}

		$pengeluarans = JurnalUmum::with(
			'jurnalable.staf'
		)->where('jurnalable_type', 'App\Models\Pengeluaran')
		->whereNull('coa_id')
		->get();

		$pendapatans = JurnalUmum::with(
			'jurnalable.staf'
		)->where('jurnalable_type', 'App\Models\Pendapatan')
		->whereNull('coa_id')
		->get();

		$jurnalumums = JurnalUmum::with(
			'jurnalable.staf'
		)
			->whereNull('coa_id')
			->get();

		$jurnalumums = json_encode( $jurnalumums );
		$bebanCoaList = [null => '-pilih-'] + 
			['120001' => 'Belanja Peralatan'] +
			['112001' => 'Persediaan Pulsa Go Pay'] +
			['612345' => 'Biaya Operasional Gojek'] +
			['120010' => 'Peralatan Bahan Bangunan'] +
		Coa::whereIn('kelompok_coa_id', [5,6,8])->where('coa', 'not like', '%penyusutan%')->pluck('coa', 'id')->all();
		$pendapatanCoaList = [null => '-pilih-']+ Coa::whereIn('kelompok_coa_id', [4,7])->pluck('coa', 'id')->all();
        $kelompokCoaList = [ null => '- pilih -' ] + KelompokCoa::pluck('kelompok_coa', 'id')->all();
		return view('jurnal_umums.coa', compact(
			'kelompokCoaList', 
			'jurnalumums', 
			'route', 
			'pengeluarans', 
			'pendapatans', 
			'bebanCoaList',
			'pendapatanCoaList'
		));
	}

	/**
	 * Display the specified jurnalumum.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function coaPost()
	{
		//$p =  json_decode( Input::get('serviceAcTemp'), true ); 
		//return dd ( $p[0]['ac_id'] );

		//
		$rules  = [
			'temp'          => 'json|required',
			'peralatanTemp' => 'json|required',
			'serviceAcTemp' => 'json|required',
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		// parse Temp
        $temp = Input::get('temp');
        $temp = json_decode($temp, true);
		// parse peralatanTemp
        $peralatanTemp                = Input::get('peralatanTemp');
        $peralatanTemp                = json_decode($peralatanTemp, true);
		//parse service Ac
		$serviceAc = Input::get('serviceAcTemp');
		$serviceAc = json_decode($serviceAc, true);

		$timestamp               = date('Y-m-d H:i:s');
		$confirm                 = '';
		$gopays                 =[];
		$confirmFbImage          = '';
		$confirmFb               = '';
		$confirmJurnalUmumUpdate = '';
		$confirmPengeluaran      = '';
		$confirmBelanjaPeralatan = '';
		$confirmAc               = '';
		$acs                     = [];
		$totalNilai              = 0;
        foreach ($temp as $k => $tp) {
			//Jika terdapat input peralatan di Coa Array,
			if (  isset( $peralatanTemp[$k] )  || isset( $serviceAc[$k] ) ) {
				$ju                   = JurnalUmum::find($tp['id']);
				$jurnalable_type      = $ju->jurnalable_type;
				$jurnalable_id        = $ju->jurnalable_id;
				if ($jurnalable_type == 'App\Models\Pengeluaran') {

					$p                    = Pengeluaran::find($jurnalable_id);
					$fb                   = new FakturBelanja;
					$fb->tanggal          = $p->tanggal;
					if ( isset( $peralatanTemp[$k] ) ) {
						$fb->nomor_faktur = $peralatanTemp[$k]['nomor_faktur'];
						$fb->belanja_id   = 4;
					} else if ( isset( $serviceAc[$k] ) ){
						$fb->nomor_faktur = $serviceAc[$k]['nomor_faktur'];
						$fb->belanja_id   = 5;
					}
					$fb->supplier_id      = $p->supplier_id;
					$fb->sumber_uang_id   = $p->sumber_uang_id;
					$fb->petugas_id       = $p->staf_id;
					$confirm              = $fb->save();
					$confirmFb            = $confirm;

					$timestamp = date('Y-m-d H:i:s');
					$alats = [];
					$acs = [];
					$service_acs = [];
					if ( isset( $peralatanTemp[$k] ) ) {
						if (count(  $peralatanTemp[$k]['alat']  ) > 0) {
							foreach ($peralatanTemp[$k]['alat'] as $alat) {
								$totalNilai += $alat['harga_satuan'] * $alat['jumlah'];
								$alats[] = [
									 'faktur_belanja_id'	=> $fb->id,
									 'staf_id'				=> $p->staf_id,
									 'peralatan'			=> $alat['peralatan'],
									 'harga_satuan'			=> $alat['harga_satuan'],
									 'jumlah'				=> $alat['jumlah'],
									 'masa_pakai'			=> $alat['masa_pakai'],
									 'created_at'			=> $timestamp,
									 'updated_at'			=> $timestamp
								];

								if (count(  $alat['ac']  ) > 0) {
									foreach ($alat['ac'] as $ac) {
										$acs[] = [
											'merek'             => $ac['merek'],
											'keterangan'        => $ac['keterangan'],
											'faktur_belanja_id' => $fb->id,
											'created_at'        => $timestamp,
											'updated_at'        => $timestamp
										];
									}
								}
							}
						}
						// Masukkan AC
						//
						$confirmAc = Ac::insert($acs);
						// Masukkan BelanjaPeralatan
						$confirm     = BelanjaPeralatan::insert($alats);
					} else if ( isset( $serviceAc[$k] ) ){
							 
						if ( $serviceAc[$k]['ac_id'] > 0 ) {
							foreach ($serviceAc[$k]['ac_id'] as $ac_id) {
								$service_acs[] = [
									'ac_id'             => $ac_id,
									'tanggal'           => $p->tanggal,
									'faktur_belanja_id' => $fb->id,
									'created_at'        => $timestamp,
									'updated_at'        => $timestamp
								];
							}
							$totalNilai = $ju->nilai;
							$confirm = ServiceAc::insert( $service_acs );
						}
					}
					//$path_before = public_path() . DIRECTORY_SEPARATOR . 'img/belanja/lain/' . $p->faktur_image;
					//$ext         = pathinfo($path_before, PATHINFO_EXTENSION);
					//$filename    = 'faktur' . $fb->id . '.' . $ext;
					//if ( isset( $peralatanTemp[$k] ) ) {
						//$path_after  = public_path() . DIRECTORY_SEPARATOR . 'img/belanja/alat/' . $filename;
					//} else if( isset( $serviceAc[$k] )   ){
						//$path_after  = public_path() . DIRECTORY_SEPARATOR . 'img/belanja/serviceAc/' . $filename;
					//}

					$confirm = false;

					if (is_file($path_before)) {
						$confirm = rename( 
							$path_before,
							$path_after
						);
					}
					$confirmFbImage = '';
					if ($confirm) {
						$fb->faktur_image = $filename;
						$confirmFbImage = $fb->save();
					}
				}
				$confirmJurnalUmumUpdate = JurnalUmum::where('jurnalable_id', $jurnalable_id)
														->where('jurnalable_type', $jurnalable_type)
														->update([
														 'nilai'           => $totalNilai,
														 'jurnalable_id'   => $fb->id,
														 'jurnalable_type' => 'App\Models\FakturBelanja'
													]);
				JurnalUmum::where('jurnalable_id', $fb->id)
					->where('jurnalable_type', 'App\Models\FakturBelanja')
					->where('debit', 1)
					->update([
						 'coa_id' => $tp['coa_id'],
					 ]
				);
			} else {
				$ju = JurnalUmum::find($tp['id']);
				$ju->coa_id = $tp['coa_id'];
				$ju->save();            

				if ( $tp['coa_id']        == '112001' ) { // Penambahan Pulsa GoPay
					$gopays[] = [
						'nilai'          => $tp['nilai'],
						'pengeluaran_id' => $tp['jurnalable_id'],
						'menambah'       => 1,
						'created_at'     => $tp['created_at'],
						'updated_at'     => $tp['created_at']
					];
					GoPay::insert($gopays);
				}
			}
        }
		GoPay::insert($gopays);
		$pesan = Yoga::suksesFlash('Penyesuaian Chart Of Account (COA) sukses, silahkan coba lagi untuk melihat laporan');
		if (!empty( Input::get('route') )) {
			return redirect( Input::get('route') )->withPesan($pesan);
		}
		$path = Input::get('route');
        return redirect($path)->withPesan($pesan);
	}

	/**
	 * Show the form for editing the specified jurnalumum.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ju       = Jurnalumum::find($id);
		$coa_list = Coa::list();
		return view('jurnal_umums.edit', compact(
			'ju',
			'coa_list'
		));
	}

	/**
	 * Remove the specified jurnalumum from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Jurnalumum::destroy($id);

		return \Redirect::route('jurnalumums.index');
	}
    public function coa_list(){
         
        $coa_id = Input::get('coa_id');

        $coas = Coa::where('id', 'like', "%$coa_id%")
                    ->take(10)->get();
        return json_encode($coas);
    }
    public function coa_keterangan(){
         
        $keterangan = Input::get('keterangan');

        $coas = Coa::where('coa', 'like', "%$keterangan%")
                    ->take(10)->get();
        return json_encode($coas);
    }
    public function coa_entry(){
         $coa_id = Input::get('coa_id');
         $kelompok_coa_id = Input::get('kelompok_coa_id');
         $coa = Input::get('coa');

         $c                  = new Coa;
         $c->id              = $coa_id;
         $c->kelompok_coa_id = $kelompok_coa_id;
         $c->coa             = $coa;
         $c->save();

         return json_encode( [ null => '- pilih -' ] + Coa::pluck('coa', 'id')->all() );
    }
    
    public function hapus_jurnals(){
        $confirm = JurnalUmum::truncate();
        if ($confirm) {
            return 'Semua Jurnal Umum sudah terhapus, silahkan di RC sisa uang yang ada';
        } else {
             return 'Jurnal Umum telah gagal dihapus';
        }
    }
	
	public function update($id){

		$data = Input::get('temp');
		$data = json_decode( $data, true ); 


		$input = [
			 'data' => $data
		];
		$rules = [
			'data.*.nilai' => 'required|numeric',
			'data.*.created_at' => 'date',
			'data.*.updated_at' => 'date'
		];
		
		$validator = \Validator::make($input, $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		foreach ($data as $d) {
			$j             = JurnalUmum::find($d['id']);
			$j->coa_id     = $d['coa_id'];
			$j->nilai      = $d['nilai'];
			$j->created_at = $d['created_at'];
			$j->updated_at = $d['updated_at'];
			$j->save();
		}

		$pesan = Yoga::suksesFlash('Jurnal Umum <strong>BERHASIL</strong> diupdate');
		return redirect()->back()->withPesan($pesan);
	}
	
	public function inputManual(){
		return view('jurnal_umums.inputManual');

	}
	public function inputManualPost(){
		/* dd(Input::all()); */ 
		$rules           = [
			'temp'       => 'required',
			'tanggal'    => 'required',
			'keterangan' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}	
		$keterangan     = Input::get('keterangan');
		$temp           = Input::get('temp');
		$temp           = json_decode($temp, true);
		$tanggal_submit = Input::get('tanggal');
		$tanggal_submit = Carbon::createFromFormat('d-m-Y', $tanggal_submit)->format('Y-m-d');

		$m             = new Manual;
		$m->keterangan = Input::get('keterangan');
		$confirm       = $m->save();

		$jurnals = [];
		if ($confirm) {
			foreach ($temp as $t) {
				$jurnals[] = [
					'jurnalable_id'   => $m->id,
					'jurnalable_type' => 'App\Models\Manual',
					'debit'           => $t['debit'],
					'coa_id'          => $t['coa_id'],
					'nilai'           => $t['nilai'],
					'created_at'      => $tanggal_submit,
					'updated_at'      => $tanggal_submit
				];
			}
		}
		JurnalUmum::insert($jurnals);
		$pesan = Yoga::suksesFlash(count($jurnals) . ' baris jurnal telah berhasil masuk database' );
		return redirect()->back()->withPesan($pesan);
	}
	public function penyusutan(){
		$penyusutan = GolonganPeralatan::with('keteranganPenyusutan')->get();
		return view('jurnal_umums.penyusutan', compact(
			'penyusutan'
		));
	}

	public function peralatan(){
		if (session()->has('route_coa')) {
			$route = session('route_coa');
		} else {
			$route = 'laporans';
		}
		$penyusutan      = GolonganPeralatan::with('keteranganPenyusutan')->get();
		$faktur_belanjas = $this->queryKonfirmasiPeralatan();
		return view('jurnal_umums.konfirmasiPeralatan', compact(
			'faktur_belanjas',
			'penyusutan',
			'route'
		));

	}
	public function postPeralatan(){
		$temp         = Input::get('temp');
		$nomor_faktur = Input::get('nomor_faktur');
		$peralatans   = [];
		foreach ($temp as $t) {
		$data         = json_decode( $t, true );
			$peralatans[] = $data;
		}
		$faktur_belanjas = [];
		$last_fb_id      = FakturBelanja::orderBy('id', 'desc')->first()->id;
		$pg_ids          = [];
		$belanja_alats   = [];
		$penyusutans   = [];
		$last_belanja_alat_id = BelanjaPeralatan::orderBy('id', 'desc')->first()->id;
		foreach ($peralatans as $key => $alats) {

			$timestamp                   = $alats[0]['created_at'];
			$last_fb_id++;
			$nama_file                   = 'faktur' . $last_fb_id . '.jpg';
			$path                        = '/var/www/kje/public/img/belanja/lain/' . $alats[0]['faktur_image'];
			if (file_exists($path) && is_file($path)) {
				copy($path,'/var/www/kje/public/img/belanja/alat/' . $nama_file  );
			}
			$faktur_belanjas[]           = [
				'id'                    => $last_fb_id,
				'tanggal'               => $alats[0]['tanggal'],
				'nomor_faktur'          => $nomor_faktur[$key],
				'belanja_id'            => 4,
				'submit'                => 1,
				'petugas_id'            => $alats[0]['staf_id'],
				'diskon'                => 0,
				'supplier_id'           => $alats[0]['supplier_id'],
				'sumber_uang_id'        => $alats[0]['sumber_uang_id'],
				'faktur_image'          => $nama_file,
				'created_at'            => $timestamp,
				'updated_at'            => $timestamp
			];
			$pg_ids[]                    = [
				'jurnalable_id'         => $last_fb_id,
				'pg_id'                 => $alats[0]['pg_id']
			];
			foreach ($alats as $alat) {
				$last_belanja_alat_id++;
				$belanja_alats[]         = [
					'id'                => $last_belanja_alat_id,
					'peralatan'         => $alat['peralatan'],
					'harga_satuan'      => $alat['harga_satuan'],
					'faktur_belanja_id' => $last_fb_id,
					'masa_pakai'        => $alat['masa_pakai'],
					'created_at'        => $timestamp,
					'updated_at'        => $timestamp,
					'jumlah'            => $alat['jumlah']
				];
			}
		}
		$jurnals                         = [];
		$ringkasanPenyusutan             = [];
		$pernyusutans                    = [];
		$alat_by_bulan = [];
		foreach ($belanja_alats as $pp) {
			$alat_by_bulan[date('Y-m', strtotime( $pp['created_at'] ))][] = $pp;
		}
		foreach ($alat_by_bulan as $k => $aa) {
			$tanggalSatu      = $k . '-01';
			if ($tanggalSatu < date('Y-m-01')) {
				while ( $tanggalSatu < date('Y-m-01')) {
					$tanggalAkhir     = date('Y-m-t 23:59:59', strtotime($tanggalSatu));
					$bulan_penyusutan = date('Y-m', strtotime($tanggalSatu));

					/* return $bulan_penyusutan; */

					$jurnal = JurnalUmum::where('jurnalable_type', 'App\Models\RingkasanPenyusutan')
							->where('created_at', 'like', $bulan_penyusutan . '%')
							->where('debit', '0')
							->where('coa_id', '120002')
							->firstOrFail();
					$nilai_penyusutan = 0;

					foreach ($aa as $a) {
						$susut_ini = round( ( $a['harga_satuan'] * $a['jumlah'] ) / (12 * $a['masa_pakai']) );
						$penyusutans[] = [
							'created_at'              => $tanggalAkhir,
							'updated_at'              => $tanggalAkhir,
							'keterangan'              => 'Penyusutan ' . $a['peralatan'] . ' bulan ' . date('M y', strtotime($tanggalAkhir)) . ' sebanyak ' . $a['jumlah']. ' pcs',
							'susutable_id'            => $a['id'],
							'susutable_type'          => 'App\Models\BelanjaPeralatan',
							'nilai'                   => $susut_ini,
							'ringkasan_penyusutan_id' => $jurnal->jurnalable_id
						];
						$nilai_penyusutan += $susut_ini;
					}
					$nilai_sebelumnya = $jurnal->nilai;
					$nilai_total      = $nilai_sebelumnya + $nilai_penyusutan;
					JurnalUmum::where('jurnalable_type', 'App\Models\RingkasanPenyusutan')
								->where('jurnalable_id', $jurnal->jurnalable_id)
								->update([
									'nilai' =>$nilai_total
								]);
					$tanggalSatu = date('Y-m-d', strtotime( "+1 month", strtotime( $tanggalSatu ) )) ;
				}
			}
		}
		Penyusutan::insert($penyusutans);
		$inserted_faktur_belanjas    = FakturBelanja::insert($faktur_belanjas);
		$inserted_belanja_peralatans = BelanjaPeralatan::insert($belanja_alats);
		$pengeluaran_ids= [];
		$confirm = false;
		foreach ($pg_ids as $p) {
			$confirm = JurnalUmum::where('jurnalable_type', 'App\Models\Pengeluaran')
				->where('jurnalable_id', $p['pg_id'])
				->update([
					'jurnalable_type' => 'App\Models\FakturBelanja',
					'jurnalable_id' => $p['jurnalable_id']
			]);
		}
		$alat_by_bulan = [];

		$pesan = 'Konfirmasi Perlatan berhasil dilakukan<ul>';
		if ($inserted_faktur_belanjas) {
			$pesan .= '<li>Faktur Belanja masuk sebanyak ' . count( $faktur_belanjas ) . ' row</li>';
		}
		if ($inserted_belanja_peralatans) {
			$pesan .= '<li>Peralatan masuk sebanyak ' . count( $belanja_alats ) . ' row</li>';
		}
		if ($confirm) {
			$pesan .= '<li>Jurnal Umum berhasil di update</li>';
		}
		$pesan .= '</ul>';
		$pesan = Yoga::suksesFlash($pesan);
		$path = Input::get('route');
		return redirect($path)->withPesan($pesan);
	}
	public function serviceAc(){
		if (session()->has('route_coa')) {
			$route = session('route_coa');
		} else {
			$route = 'laporans';
		}
		$faktur_belanjas = $this->queryKonfirmasiServiceAc();
		return view('jurnal_umums.konfimasiServiceAc', compact(
			'faktur_belanjas',
			'route'
		));
	}
	public function postServiceAc(){
		$temp = Input::get('temp');
		$nomor_faktur = Input::get('nomor_faktur');

		$service_acs = [];
		foreach ($temp as $t) {
			$datas = json_decode($t, true);
			$service_acs[] = $datas;
		}
		$inputServiceAc = [];
		$faktur_belanjas = [];
		$last_fb_id = FakturBelanja::orderBy('id', 'desc')->first()->id;
		foreach ($service_acs as $key => $acs) {
			$timestamp = $acs[0]['created_at'];
			$last_fb_id++;
			$nama_file = 'faktur' . $last_fb_id . '.jpg';
			$path      = '/var/www/kje/public/img/belanja/lain/' . $acs[0]['faktur_image'];
			if (file_exists($path) && is_file($path)) {
				copy($path,'/var/www/kje/public/img/belanja/serviceAc/' . $nama_file  );
			}
			$faktur_belanjas[] = [
				'id'             => $last_fb_id,
				'tanggal'        => $acs[0]['tanggal'],
				'nomor_faktur'   => $nomor_faktur[$key],
				'belanja_id'     => 4,
				'submit'         => 1,
				'petugas_id'     => $acs[0]['staf_id'],
				'diskon'         => 0,
				'supplier_id'    => $acs[0]['supplier_id'],
				'sumber_uang_id' => $acs[0]['sumber_uang_id'],
				'faktur_image'   => $nama_file,
				'created_at'     => $timestamp,
				'updated_at'     => $timestamp
			];
			$pg_ids[] = [
				'jurnalable_id' => $last_fb_id,
				'pg_id' => $acs[0]['pg_id']
			];
			foreach ($acs as $ac) {
				$inputServiceAc[] = [
					'ac_id'      => $ac['ac_id'],
					'faktur_belanja_id' => $last_fb_id,
					'created_at'        => $timestamp,
					'updated_at'        => $timestamp,
					'tanggal'            => $ac['tanggal']
				];
			}
		}
		$inserted_faktur_belanjas = FakturBelanja::insert($faktur_belanjas);
		$inserted_service_ac      = ServiceAc::insert($inputServiceAc);
		$confirm = false;
		foreach ($pg_ids as $pg_id) {
			$confirm = JurnalUmum::where('jurnalable_type', 'App\Models\Pengeluaran')
				->where('jurnalable_id', $pg_id['pg_id'])
				->update([
					'jurnalable_id' => $pg_id['jurnalable_id'],
					'jurnalable_type' => 'App\Models\FakturBelanja'
				]);
		}
		$pesan = 'Service Ac berhasil dikonfirmasi <ul>';
		if ($inserted_faktur_belanjas) {
			$pesan .= '<li>Faktur Belanja masuk sebanyak ' . count( $faktur_belanjas ) . ' row</li>';
		}
		if ($inserted_service_ac) {
			$pesan .= '<li>Service Ac masuk sebanyak ' . count( $inputServiceAc ) . ' row</li>';
		}
		if ($confirm) {
			$pesan .= '<li>Jurnal Umum berhasil di update</li>';
		}
		$pesan .= '</ul>';
		$pesan = Yoga::suksesFlash($pesan);
		$path = Input::get('route');
		return redirect($path)->withPesan($pesan);
	}
	public function queryKonfirmasiServiceAc(){
		return $this->queryKonfirmasi(623433);
	}
	public function queryKonfirmasiPeralatan(){
		return $this->queryKonfirmasi(120001);
	}
	public function queryRenovasiBulanIni($bulanIni, $count = true){
		$query  = "SELECT ";
		$query .= "count(id) as jumlah ";
		$query .= "FROM bahan_bangunans ";
		$query .= "WHERE tanggal_renovasi_selesai is null ";
		$query .= "AND ( tanggal_terakhir_dikonfirmasi < '{$bulanIni}' or tanggal_terakhir_dikonfirmasi is null) ";
		return DB::select($query);
	}
	public function queryKonfirmasi($coa_id){
		$jurnals = JurnalUmum::where('jurnalable_type', 'App\Models\Pengeluaran')->where('coa_id',$coa_id)->get(['jurnalable_id']);
		$ids = [];
		foreach ($jurnals as $ju) {
			$ids[] = $ju->jurnalable_id;
		}
		return Pengeluaran::whereIn('id', $ids)->get();
	}
	public function omset_pajak(){

		$query  = "SELECT ";
		$query .= "DATE_FORMAT(ju.created_at, '%Y-%M') as bulan, ";
		$query .= "abs( sum( if ( debit = 0, nilai, 0 ) )";
		$query .= " - sum( if ( debit = 1, nilai, 0 ) )) as nilai ";
		$query .= "FROM jurnal_umums as ju ";
		$query .= "LEFT OUTER JOIN periksas as px on px.id = ju.jurnalable_id ";
		$query .= "WHERE ( coa_id like '4%' ) ";
		$query .= "AND ( px.asuransi_id > 0 or px.asuransi_id is null) ";
		$query .= "AND ( px.poli not like 'poli estetika' or poli is null) ";
		$query .= "AND ju.jurnalable_type not like 'App\\\Models\\\NotaJual' ";
		/* $query .= "AND ((  px.asuransi_id > 0 and ju.jurnalable_type = 'App\\\Periksa'  ) or ju.jurnalable_type not like 'App\\\Periksa') "; */
		$query .= "GROUP BY Year(ju.created_at), Month(ju.created_at) ";
		$query .= "ORDER BY ju.created_at desc;";
		$pajaks = DB::select($query);
		return view('jurnal_umums.omset_pajak', compact(
			'pajaks'
		));
	}
}
