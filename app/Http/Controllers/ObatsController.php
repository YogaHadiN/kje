<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use DB;
use Carbon\Carbon;
use App\Models\Rak;

class ObatsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * GET /obats
	 *
	 * @return Response
	 */
	public function index()
	{	

		

		$days_ago = date('Y-m-d', strtotime('-10 days', strtotime(date('Y-m-d'))));
		$now = date('Y-m-d');

		$query = "SELECT ";
		$query .= "sum(r.keluar) as keluar, ";
		$query .= "rk.id as rak_id ";
		$query .= "from dispensings as r ";
		$query .= "join mereks as mr on mr.id = r.merek_id ";
		$query .= "join raks as rk on rk.id = mr.rak_id ";
		$query .= "where date(tanggal) between '{$days_ago}' ";
		$query .= "and '{$now}' ";
		$query .= "AND r.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by rk.id";

		$dispensings = DB::select($query);
		foreach ($dispensings as $dispensing) {
			$rak_id = $dispensing->rak_id;
			$jumlah = $dispensing->keluar;
			$rak = Rak::find($rak_id);

			if($rak->stok_minimal < $jumlah){
				$rak->stok_minimal = $jumlah;
				$rak->save();
			}
		}

		$raks = Rak::orderBy('stok_minimal', 'desc')->get();


		return view('Dispensings.stokmin')->withRaks($raks);
	}
    public function fast_moving(){
        return view('mereks.fast_moving');
    }
    
    /**
     * undocumented function
     *
     * @return void
     */
    public function fast_moving_ajax()
    {
        $bulanTahun = Input::get('bulanTahun');
        $bulanTahun = Carbon::createFromFormat('m-Y', $bulanTahun)->format('Y-m');
        $query  = "SELECT ";
        $query .= "mrk.merek, ";
        $query .= "rak.kode_rak, ";
        $query .= "rak.harga_beli, ";
        $query .= "rak.harga_jual, ";
        $query .= "sum(trp.jumlah) as jumlah ";
        $query .= "FROM terapis as trp ";
        $query .= "JOIN mereks as mrk on mrk.id = trp.merek_id ";
        $query .= "JOIN raks as rak on rak.id = mrk.rak_id ";
        $query .= "JOIN periksas as prx on prx.id = trp.periksa_id ";
        $query .= "WHERE prx.tanggal like '{$bulanTahun}%' ";
        $query .= "AND mrk.merek not like '%Puyer%' ";
        $query .= "AND mrk.merek not like 'Add Sirup' ";
        $query .= "GROUP BY mrk.id ";
        $query .= "ORDER BY sum(trp.jumlah) desc ";

        $data = DB::select($query);
        return $data;
    }
    
    

	/**
	 * Show the form for creating a new resource.
	 * GET /obats/create
	 *
	 * @return Response
	 */
	
}
