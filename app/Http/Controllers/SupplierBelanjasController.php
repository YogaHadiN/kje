<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Models\Supplier;
use App\Models\Classes\Yoga;
use App\Models\Belanja;
use App\Models\Sediaan;
use App\Models\KelasObat;
use App\Models\Merek;
use App\Models\Rak;
use App\Models\Formula;
use App\Models\Generik;
use App\Models\Pengeluaran;
use App\Models\FakturBelanja;
class SupplierBelanjasController extends Controller
{
    public function belanja_obat(){
		$rak     = Rak::first();
		$mereks  = Merek::with('rak.formula.komposisi.generik')->get();
		$formula = Formula::first();


		$sumber_uang = Yoga::sumberuang();

		$fornas = Yoga::fornas();
        $sediaan_list = Sediaan::pluck('sediaan', 'id');

		$alternatif_fornas = array('' => '- Pilih Merek -') + Merek::pluck('merek', 'id')->all();

		$dijual_bebas = array(
                        null        => '- Pilih -',
                        '0'         => 'Tidak Dijual Bebas',
                        '1'         => 'Dijual Bebas'
                    );

		$generik = array('0' => '- Pilih Generik -') + Generik::pluck('generik', 'id')->all();

		$signas = Yoga::signa_list();
		$aturan_minums = Yoga::aturan_minum_list();

		$pembelians = FakturBelanja::where('belanja_id', '1')->latest()->paginate(10);


        $kelas_obat_list = KelasObat::pluck('kelas_obat', 'id');
		return view('suppliers.belanja_obat', compact(
			 'sediaan_list'
			, 'generik'
			, 'pembelians'
			, 'mereks'
			, 'dijual_bebas'
			, 'kelas_obat_list'
			, 'signas'
			, 'rak'
			, 'formula'
			, 'fornas'
			, 'aturan_minums'
			, 'sumber_uang'
			, 'alternatif_fornas'
		));
    }
    public function belanja_bukan_obat(){
		$suppliers    = Supplier::all();
		$stafs        = Yoga::stafList();
		$sumber_uang  = Yoga::sumberuang();
		$pengeluarans = Pengeluaran::with('supplier', 'staf')->latest()->paginate(10);
		$belanjaList  = [ null => '- Jenis Belanja -']  + Belanja::pluck('belanja', 'id')->all();
		return view('suppliers.belanja_bukan_obat', compact(
			'suppliers', 
			'stafs', 
			'belanjaList', 
			'pengeluarans', 
			'sumber_uang'
		));
    }
}
