<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Supplier;
use App\Classes\Yoga;
use App\Belanja;
use App\Merek;
use App\Rak;
use App\Formula;
use App\Generik;
use App\Pengeluaran;
use App\FakturBelanja;
class SupplierBelanjasController extends Controller
{
    public function belanja_obat(){
		$rak = Rak::first();
		$mereks = Merek::with('rak.formula.komposisi.generik')->get();
		$formula = Formula::first();
		$fornas = Yoga::fornas();
		$sediaan = [
			null 				=> '- pilih -',
			'tablet'  			=> 'tablet',
			'syrup'  			=> 'syrup',
			'drop'  			=> 'drop',
			'capsul' 			=> 'capsul',
			'ampul'  			=> 'ampul',
			'vial'  			=> 'vial',
			'tetes mata'  		=> 'tetes mata',
			'tetes telinga' 	=> 'tetes telinga',
			'salep'  			=> 'salep',
			'gel'  				=> 'gel',
			'tube'  			=> 'tube'
		];

		$alternatif_fornas = array('' => '- Pilih Merek -') + Merek::lists('merek', 'id')->all();

		$dijual_bebas = array(
                        null        => '- Pilih -',
                        '0'         => 'Tidak Dijual Bebas',
                        '1'         => 'Dijual Bebas'
                    );

		$generik = array('0' => '- Pilih Generik -') + Generik::lists('generik', 'id')->all();

		$signas = Yoga::signa_list();
		$aturan_minums = Yoga::aturan_minum_list();


		return view('suppliers.belanja_obat', compact(
			 'fakturbelanja'
			, 'sediaan'
			, 'generik'
			, 'exist'
			, 'mereks'
			, 'dijual_bebas'
			, 'signas'
			, 'rak'
			, 'formula'
			, 'fornas'
			, 'aturan_minums'
			, 'alternatif_fornas'
		));
    }
    public function belanja_bukan_obat(){
		$suppliers = Supplier::all();
		$stafs = Yoga::stafList();
		$pengeluarans = Pengeluaran::with('supplier', 'staf')->latest()->paginate(10);
		$belanjaList = [ null => '- Jenis Belanja -']  + Belanja::lists('belanja', 'id')->all();
		return view('suppliers.belanja_bukan_obat', compact('suppliers', 'stafs', 'belanjaList', 'pengeluarans'));
    }
}
