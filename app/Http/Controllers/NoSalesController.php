<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\NoSale;
use App\Models\Classes\Yoga;
use Input;

class NoSalesController extends Controller
{
    public function index(){
	        $no_sales = NoSale::with('staf')->latest()->paginate(30);
		    return view('no_sales.index', compact('no_sales'));
    }
   public function store(){
        $tujuan = Input::get('tujuan');
        $staf_id = Input::get('staf_id');
        $uang_masuk = Yoga::clean( Input::get('uang_masuk') );
        $uang_keluar = Yoga::clean( Input::get('uang_keluar') );

        $ns = new NoSale;
        $ns->staf_id = $staf_id;
        $ns->tujuan = $tujuan;
        $ns->uang_masuk = $uang_masuk;
        $ns->uang_keluar = $uang_keluar;
        $confirm = $ns->save();

        if ($confirm) {
            $pesan = Yoga::suksesFlash("Transaksi Tanpa Sales <strong>BERHASIL</strong> dilakukan" );
            
        }else{
            $pesan = Yoga::gagalFlash("Transaksi Tanpa Sales <strong>GAGAL</strong> dilakukan" );
        }
        return redirect('no_sales')->withPesan($pesan)->withPrint($ns->id);
   }
}
