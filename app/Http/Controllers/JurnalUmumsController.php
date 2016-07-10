<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\JurnalUmum;
use App\Pengeluaran;
use App\Periksa;
use App\KelompokCoa;
use App\Modal;
use App\BukanObat;
use App\CheckoutKasir;
use App\Classes\Yoga;
use App\Coa;
use DB;


class JurnalUmumsController extends Controller
{

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
				return redirect('jurnal_umums/coa')->withPesan(Yoga::gagalFlash('Ada beberapa Chart Of Account yang harus disesuaikan dulu'));
			}
		}

        $jurnalumums = JurnalUmum::with('coa')->groupBy('jurnalable_id')
            ->groupBy('jurnalable_type')
            ->orderBy('created_at', 'desc')
            ->where('created_at', 'like', $tahun . '-' . $bulan . '%')
            ->paginate(10);

        //$errors = [];
        //foreach ($jurnalumums as $ju) {
            //try {
                //$ju->jurnalable->ketJurnal;
            //} catch (\Exception $e) {
                //$errors[] = $ju->id;
            //}
        //}
        //return dd( $errors );
        

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

		$jurnals = JurnalUmum::with('coa')->get();
		$ids = [];
		foreach ($jurnals as $k => $ju) {
			try {
				$ju->coa->coa;
			} catch (\Exception $e) {
				$ids[] = $ju->id;
			}
		}

        $jurnalumums = JurnalUmum::whereIn('id', $ids)
                                ->get();

		$data_ids = '';
		foreach ($ids as $id) {
			$data_ids .= $id . ',';
		}
		$data_ids .= $ids[ count($ids) - 1 ];
		//return $data_ids;
		$query ="select * from jurnal_umums where id in ({$data_ids})";
		//$query = "select ju.id as jurnal_umum_id, ju.nilai as nilai, ju.coa_id as coa, ju.created_at as tanggal from jurnal_umums as ju join faktur_belanjas as fb on fb.id = ju.jurnalable_id where ju.id in ({$data_ids}) and jurnalable_type='App\\\FakturBelanja' group by jurnal_umum_id";
		$faktur_belanjas = DB::select($query);
		return $faktur_belanjas;
		$query = "SELECT *, ju.id as jurnal_umum_id FROM jurnal_umums as ju join pendapatans as pd on pd.id = ju.jurnalable_id where jurnalable_type='App\\\Pendapatan' and ju.id in ({$data_ids})";
		$pendapatans = DB::select($query);
		//return $pendapatans[0]->created_at;
		$bebanCoaList = [null => '-pilih-'] + Coa::whereIn('kelompok_coa_id', [5,6,8])->lists('coa', 'id')->all();
		$pendapatanCoaList = [null => '-pilih-'] + Coa::whereIn('kelompok_coa_id', [4,7])->lists('coa', 'id')->all();
        $kelompokCoaList = [ null => '- pilih -' ] + KelompokCoa::lists('kelompok_coa', 'id')->all();
		return view('jurnal_umums.coa', compact(
			'kelompokCoaList', 
			'jurnalumums', 
			'faktur_belanjas', 
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
        $temp = Input::get('temp');
        $temp = json_decode($temp, true);
        foreach ($temp as $tp) {

            $ju = JurnalUmum::find($tp['id']);
            $ju->coa_id = $tp['coa_id'];
            $ju->save();            

            if ($tp['jurnalable_type'] == 'App\Pengeluaran') {
                $bukan_obat_id = Pengeluaran::find($tp['jurnalable_id'])->bukan_obat_id;
                $bo = BukanObat::find($bukan_obat_id);
                $bo->coa_id = $tp['coa_id'];
                $bo->save();
            }

        }
        return redirect('jurnal_umums');
	}

	/**
	 * Show the form for editing the specified jurnalumum.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$jurnalumum = Jurnalumum::find($id);

		return view('jurnalumums.edit', compact('jurnalumum'));
	}

	/**
	 * Update the specified jurnalumum in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$jurnalumum = Jurnalumum::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Jurnalumum::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$jurnalumum->update($data);

		return \Redirect::route('jurnalumums.index');
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

         $c = new Coa;
         $c->id = $coa_id;
         $c->kelompok_coa_id = $kelompok_coa_id;
         $c->coa = $coa;
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
    
    

}
