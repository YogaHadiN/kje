<?php

namespace App\Http\Controllers;

use Input;
use DB;
use App\Http\Requests;
use App\Models\Asuransi;
use App\Models\Tarif;
use App\Models\BayarDokter;
use App\Models\Classes\Yoga;

class BayarDoktersController extends Controller
{
    public function index(){
        $query  = "SELECT ";
        $query .= "bgj.id as id, ";
        $query .= "stf.nama as nama, ";
        $query .= "bgj.gaji_pokok + bgj.bonus as nilai, ";
        $query .= "DATE_FORMAT(bgj.created_at, '%Y-%m-%d') as created_at ";
        $query .= "FROM bayar_gajis as bgj ";
        $query .= "JOIN stafs as stf on stf.id = bgj.staf_id ";
        $query .= "WHERE titel = 'dr' ";
        $query .= "ORDER BY id DESC ";
        $query .= "LIMIT 15 ";
        $bayardokters = DB::select($query);
        return view('bayar_dokters.index', compact('bayardokters'));
    }
        
    //
}
