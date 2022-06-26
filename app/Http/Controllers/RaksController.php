<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Models\Rak;
use App\Models\Classes\Yoga;
use App\Models\Formula;
use DB;
use App\Models\Merek;

class RaksController extends Controller
{

	public $input_alternatif_fornas;
	public $input_id;
	public $input_exp_date;
	public $input_fornas;
	public $input_harga_beli;
	public $input_harga_jual;
	public $input_formula_id;
	public $input_kelas_obat_id;
	public $input_stok;
	public $input_stok_minimal;
	/**
	 * Display a listing of raks
	 *
	 * @return Response
	 */
	/**
	* @param 
	*/
	public function __construct()
	{

		$this->input_alternatif_fornas = Input::get('alternatif_fornas');
		$this->input_id                = Input::get('id');
		$this->input_exp_date          = Input::get('exp_date');
		$this->input_fornas            = Input::get('fornas');
		$this->input_harga_beli        = Input::get('harga_beli');
		$this->input_harga_jual        = Input::get('harga_jual');
		$this->input_formula_id        = Input::get('formula_id');
		$this->input_kelas_obat_id     = Input::get('kelas_obat_id');
		$this->input_stok              = Input::get('stok');
		$this->input_stok_minimal      = Input::get('stok_minimal');

		/* dd( */
		/* 	'yuhuu', */
		/* 	$this->input_alternatif_fornas, */
		/* 	$this->input_id, */
		/* 	$this->input_exp_date, */
		/* 	$this->input_fornas, */
		/* 	$this->input_harga_beli, */
		/* 	$this->input_harga_jual, */
		/* 	$this->input_formula_id, */
		/* 	$this->input_kelas_obat_id, */
		/* 	$this->input_stok, */
		/* 	$this->input_stok_minimal */
		/* ); */

	}
	
	public function index()
	{
		$raks = Rak::all();
		return view('mereks.index', compact('raks'));
	}

	/**
	 * Show the form for creating a new rak
	 *
	 * @return Response
	 */
	public function create()
	{	
		return view('raks.create');
	}

	/**
	 * Store a newly created rak in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Input::ajax()) {
		} else {
			$rules = [

				'id' => 'required',
				'merek' => 'required',
				'exp_date' => 'required',
				'fornas' => 'required',
				'harga_beli' => 'numeric|required',
				'harga_jual' => 'numeric|required',
				'formula_id' => 'required'

			];
			$validator = \Validator::make($data = Input::all(), $rules);
			
			if ($validator->fails())
			{
				return \Redirect::back()->withErrors($validator)->withInput();
			}
		}

		$rak = new Rak;
		$rak = $this->inputData($rak);

		$formula = Formula::find($rak->formula_id);

		$sediaan = $formula->sediaan;

		if($formula->komposisi->count() >1){
			$merek = ucwords(strtolower(Input::get('merek'))) . ' ' . $sediaan;
		} else {
			$merek = ucwords(strtolower(Input::get('merek'))) . ' ' . $sediaan . ' ' . $formula->komposisi->first()->bobot;
		}

		$merek_id_custom = Yoga::customId('App\Models\Merek');
		$mrk             = new Merek;
		$mrk->id         = $merek_id_custom;
		$mrk->rak_id     = Input::get('id');
		$mrk->merek      = $merek;
		$mrk->save();

		// return $merek_id_custom;

		if (Input::ajax()) {
			$returnData = [
				'merek_id' => $merek_id_custom,
				'merek'	=> $merek,
				'custom_value' => Merek::find($merek_id_custom)->custid
			];

			return json_encode($returnData);

		} else {
			return \Redirect::route('mereks.index')->withPesan(Yoga::suksesFlash('RAK obat <strong>' . Input::get('id') . '</strong> telah <strong>BERHASIL</strong> dibuat'));
		}
		
	}

	/**
	 * Display the specified rak.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$rak = Rak::findOrFail($id);
		$formula_id = $rak->formula_id;
		$formula = Formula::find($formula_id);


		$query = "SELECT mr.merek as merek, ";
		$query .= "rk.id as rak_id, ";
		$query .= "mr.id as merek_id, ";
		$query .= "sp.nama as nama, ";
		$query .= "sp.alamat as alamat, ";
		$query .= "sp.no_telp as telepon, ";
		$query .= "sp.hp_pic as hp, ";
		$query .= "sp.pic as pic, ";
		$query .= "fb.supplier_id as supplier_id, ";
		$query .= "pb.harga_beli, ";
		$query .= "pb.faktur_belanja_id as faktur_belanja_id, ";
		$query .= "max(fb.tanggal) as tanggal ";
		$query .= "from pembelians as pb ";
		$query .= "join faktur_belanjas as fb on fb.id = pb.faktur_belanja_id ";
		$query .= "join suppliers as sp on sp.id = fb.supplier_id ";
		$query .= "join mereks as mr on mr.id = pb.merek_id ";
		$query .= "join raks as rk on rk.id = mr.rak_id ";
		$query .= "where rk.id ='{$id}' ";
		$query .= "AND pb.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by supplier_id ";
		$query .= "order by harga_beli asc ";
		$supplierprices = DB::select($query);

		return view('raks.show', compact('rak', 'formula', 'supplierprices'));
	}

	/**
	 * Show the form for editing the specified rak.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$rak = Rak::find($id);
		$rak->exp_date = Yoga::updateDatePrep($rak->exp_date);
		$formula = Formula::find($rak->formula_id);
		$fornas = Yoga::fornas();
		$alternatif_fornas = Yoga::alternatif_fornas();
		return view('raks.edit', compact('rak', 'formula', 'fornas', 'alternatif_fornas'));
	}

	/**
	 * Update the specified rak in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{	
		$rules = [
			'exp_date'     => 'required',
			'fornas'       => 'required',
			'harga_beli'   => 'required',
			'harga_jual'   => 'required',
			'formula_id'   => 'required',
			'stok'         => 'required',
			'stok_minimal' => 'required'
		];

		$validator = \Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$rak   = Rak::findOrFail($id);
		$rak   = $this->inputData($rak);
		$pesan = 'Rak <strong>' . $id . '</strong> telah <strong>BERHASIL</strong> diubah';

		return \Redirect::route('mereks.index')->withPesan(Yoga::suksesFlash($pesan));
	}

	/**
	 * Remove the specified rak from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Rak::destroy($id);
		return \Redirect::route('mereks.index');
		/* DB::beginTransaction(); */
		/* try { */
		/* 	$rak    = Rak::find($id); */
		/* 	if (!Rak::destroy($id)) { */
		/* 		return redirect()->back()->withPesan(Yoga::gagalFlash('Rak ' . $rak->id . ' GAGAL dihapus')); */
		/* 	} */
		/* 	$mereks = Merek::where('rak_id', $rak->id)->get(); */
		/* 	Merek::where('rak_id', $rak->id)->delete(); */
		/* 	$pesan  = 'Rak ' . $rak->id . ' <strong>BERHASIL</strong> dihapus, merek yang menaunginya yaitu : '; */
		/* 	if ($mereks->count()) { */
		/* 		$pesan .= '<ul>'; */
		/* 		foreach ($mereks as $merek) { */
		/* 			$pesan .= '<li>' . $merek->merek . '</li>'; */
		/* 		} */
		/* 		$pesan .= '</ul>'; */
		/* 		$pesan .= 'Juga telah <strong>BERHASIL</strong> dihapus'; */
		/* 	} */
		/* 	DB::commit(); */
		/* 	return \Redirect::route('mereks.index')->withPesan(Yoga::suksesFlash($pesan)); */
		/* } catch (\Exception $e) { */
		/* 	DB::rollback(); */
		/* 	throw $e; */
		/* } */
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function inputData($rak)
	{

		$rak->alternatif_fornas = $this->input_alternatif_fornas;
		$rak->id                = $this->input_id;
		$rak->exp_date          = Yoga::datePrep($this->input_exp_date);
		$rak->fornas            = $this->input_fornas;
		$rak->harga_beli        = $this->input_harga_beli;
		$rak->harga_jual        = $this->input_harga_jual;
		$rak->formula_id        = $this->input_formula_id;
		$rak->kelas_obat_id     = $this->input_kelas_obat_id;
		$rak->stok              = $this->input_stok;
		$rak->stok_minimal      = $this->input_stok_minimal;
		/* dd( $rak ); */
		$rak->save();

		return $rak;
	}
	

}
