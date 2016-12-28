<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\JurnalUmum;
use App\FakturBelanja;
use App\Pengeluaran;
use App\Periksa;
use App\KelompokCoa;
use App\Modal;
use App\BukanObat;
use App\CheckoutKasir;
use App\Classes\Yoga;
use App\Coa;
use App\Ac;
use App\BelanjaPeralatan;
use DB;


class JurnalUmumsController extends Controller
{


	public function __construct()
	 {
		 $this->middleware('super', ['only' => [
			 'edit',
			 'update'
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

        $bulan  = Input::get('bulan');
        $tahun  = Input::get('tahun');
		$jurnalumums = JurnalUmum::with('coa')->where('created_at', 'like', $tahun . '-'. $bulan . '%')->get();
		foreach ($jurnalumums as $k => $ju) {
			try {
				$ju->coa->coa;
			} catch (\Exception $e) {
				session([ 'route_coa' => 'jurnal_umums' ]);
				return redirect('jurnal_umums/coa')->withPesan(Yoga::gagalFlash('Ada beberapa Chart Of Account yang harus disesuaikan dulu'));
			}
		}

        $jurnalumums = JurnalUmum::with('coa')->groupBy('jurnalable_id')
            ->groupBy('jurnalable_type')
            ->orderBy('created_at', 'desc')
            ->where('created_at', 'like', $tahun . '-' . $bulan . '%')
            ->paginate(10);

		return view('jurnal_umums.show', compact('jurnalumums'));
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
		$route = null;

		if (session()->has('route_coa')) {
			$route = session('route_coa');
		}

		$jurnalumums = JurnalUmum::whereNull('coa_id')->get();
		$ids = [];
		foreach ($jurnalumums as $ju) {
			$ids[] = $ju->id;
		}
		$data_ids = '';

		foreach ($ids as $id) {
			$data_ids .= $id . ',';
		}

		$data_ids .= $ids[ count($ids) - 1 ];
		$query = "select ju.jurnalable_id as jurnalable_id, ju.jurnalable_type as jurnalable_type, ju.id as jurnal_umum_id, ju.nilai as nilai, ju.coa_id as coa, ju.created_at as tanggal, pg.keterangan as nama, st.nama as nama_staf, pg.faktur_image from jurnal_umums as ju join pengeluarans as pg on pg.id = ju.jurnalable_id join stafs as st on st.id=pg.staf_id where ju.id in ({$data_ids}) and jurnalable_type='App\\\Pengeluaran' group by jurnal_umum_id";
		$pengeluarans = DB::select($query);
		$query = "SELECT *, ju.id as jurnal_umum_id, st.nama as nama_staf FROM jurnal_umums as ju join pendapatans as pd on pd.id = ju.jurnalable_id join stafs as st on st.id = pd.staf_id where jurnalable_type='App\\\Pendapatan' and ju.id in ({$data_ids})";
		$pendapatans = DB::select($query);
		$bebanCoaList = [null => '-pilih-'] + ['120001' => 'Belanja Peralatan'] + Coa::whereIn('kelompok_coa_id', [5,6,8])->lists('coa', 'id')->all();
		$pendapatanCoaList = [null => '-pilih-']+ Coa::whereIn('kelompok_coa_id', [4,7])->lists('coa', 'id')->all();
        $kelompokCoaList = [ null => '- pilih -' ] + KelompokCoa::lists('kelompok_coa', 'id')->all();

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
		$rules  = [
			'temp'          => 'json|required',
			'peralatanTemp' => 'json|required',
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
		$timestamp                    = date('Y-m-d H:i:s');
		$confirmFbImage = '';
		$confirmFb = '';
		$confirmJurnalUmumUpdate = '';
		$confirmPengeluaran = '';
		$confirmBelanjaPeralatan = '';
		$confirmAc = '';
		$acs                          = [];
		$totalNilai = 0;
        foreach ($temp as $k         => $tp) {
			//Jika terdapat input peralatan di Coa Array,
			if ( isset( $peralatanTemp[$k] ) ) {
				$ju                   = JurnalUmum::find($tp['id']);
				// ganti coa id menjadi Belanja Peralatan
				$ju->coa_id           = $tp['coa_id'];
				$jurnalable_type      = $ju->jurnalable_type;
				$jurnalable_id        = $ju->jurnalable_id;
				if ($jurnalable_type == 'App\Pengeluaran') {

					$p = Pengeluaran::find($jurnalable_id);
					$fb                 = new FakturBelanja;
					$fb->tanggal        = $p->tanggal;
					$fb->nomor_faktur   = $peralatanTemp[$k]['nomor_faktur'];
					$fb->belanja_id     = 4;
					$fb->supplier_id    = $p->supplier_id;
					$fb->sumber_uang_id = $p->sumber_uang_id;
					$fb->petugas_id     = $p->staf_id;
					$confirm            = $fb->save();
					$confirmFb = $confirm;

					$timestamp = date('Y-m-d H:i:s');
					$alats = [];
					$acs = [];
					$service_acs = [];
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
					$confirmBelanjaPeralatan     = BelanjaPeralatan::insert($alats);
					if ($confirm) {
						$confirmPengeluaran = Pengeluaran::destroy( $jurnalable_id );
					}
					$path_before = public_path() . DIRECTORY_SEPARATOR . 'img/belanja/lain/' . $p->faktur_image;
					$ext         = pathinfo($path_before, PATHINFO_EXTENSION);
					$filename    = 'faktur' . $fb->id . '.' . $ext;
					$path_after  = public_path() . DIRECTORY_SEPARATOR . 'img/belanja/alat/' . $filename;

					$confirm = false;

					if (file_exists($path_before)) {
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
				$confirmJurnalUmumUpdate = JurnalUmum::where('jurnalable_id', $jurnalable_id)->where('jurnalable_type', $jurnalable_type)->update([
					 'nilai' => $totalNilai,
					 'coa_id' => $tp['coa_id'],
					 'jurnalable_id' => $fb->id,
					 'jurnalable_type' => 'App\FakturBelanja'
				]);
			} else {
				$ju = JurnalUmum::find($tp['id']);
				$ju->coa_id = $tp['coa_id'];
				$ju->save();            
			}
			//return dd( [
				//'confirmfb' => $confirmFb,
				//'confirmfbImage' => $confirmFbImage,
				//'confirmPengeluaranDelete' => $confirmPengeluaran,
				//'confirmJurnalUmumUpdate' => $confirmJurnalUmumUpdate,
				//'confirmBelanjaPeralatan' => $confirmBelanjaPeralatan,
				//'confirmAc' => $confirmAc
			//] ); 
        }
		$pesan = Yoga::suksesFlash('Penyesuaian Chart Of Account (COA) sukses, silahkan coba lagi untuk melihat laporan');
		if (!empty( Input::get('route') )) {
			return redirect( Input::get('route') )->withPesan($pesan);
		}
        return redirect('jurnal_umums')->withPesan($pesan);
	}

	/**
	 * Show the form for editing the specified jurnalumum.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ju = Jurnalumum::find($id);
		return view('jurnal_umums.edit', compact('ju'));
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

         return json_encode( [ null => '- pilih -' ] + Coa::lists('coa', 'id')->all() );
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
		];
		
		$validator = \Validator::make($input, $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		foreach ($data as $d) {
			$j        = JurnalUmum::find($d['id']);
			$j->nilai = $d['nilai'];
			$j->save();
		}

		$pesan = Yoga::suksesFlash('Jurnal Umum <strong>BERHASIL</strong> diupdate');
		return redirect()->back()->withPesan($pesan);
	}
	
    
    

}
