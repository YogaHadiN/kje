<?php



namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use DB;


class TestController extends Controller
{

	public function rak(){
		$query = "select ";
		$query .= "id, alternatif_fornas, exp_date, fornas, harga_beli, harga_jual, formula_id, stok, stok_minimal ";
		$query .= "from raks ";

		return DB::select($query);
		
	}
	public function merek(){

		$query = "select ";
		$query .= "id, rak_id, merek ";
		$query .= "from mereks";

		return DB::select($query);		

		
	}
	public function formula(){

		$query = "select ";
		$query .= "id, dijual_bebas, efek_samping, golongan_obat, sediaan, indikasi, kontraindikasi ";
		$query .= "from formulas";

		return DB::select($query);

		
	}
	public function komposisi(){

		$query = "select ";
		$query .= "id, bobot, formula_id, generik_id ";
		$query .= "from komposisis";

		return DB::select($query);

		
	}
	public function dose(){

		$query = "select ";
		$query .= "id, dosis, berat_badan, formula_id ";
		$query .= "from doses ";

		return DB::select($query);

		
	}
	public function tarif(){

		

		$query = "select ";
		$query .= "id, biaya, dibayar_asuransi, bahan_habis_pakai, asuransi_id, jenis_tarif_id, tipe_tindakan_id, bhp_items, jasa_dokter ";
		$query .= "from tarifs ";

		return DB::select($query);

		
	}
	public function jenisTarif(){

		$query = "select ";
		$query .= "id, jenis_tarif ";
		$query .= "from jenis_tarifs ";

		return DB::select($query);

		
	}
	public function bhp(){

		$query = "select ";
		$query .= "id, merek_id, jenis_tarif_id, jumlah ";
		$query .= "from bahan_habis_pakais ";

		return DB::select($query);

		
	}

	public function coba(){
		return view('coba.coba');
	}

}