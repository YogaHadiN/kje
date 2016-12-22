<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Rak;
use App\Classes\Yoga;
use App\Formula;
use DB;
use App\Merek;

class RaksController extends Controller
{

	/**
	 * Display a listing of raks
	 *
	 * @return Response
	 */
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
		$rak->alternatif_fornas = Input::get('alternatif_fornas');
		$rak->id = Input::get('id');
		$rak->exp_date = Yoga::datePrep(Input::get('exp_date'));
		$rak->fornas = Input::get('fornas');
		$rak->harga_beli = Input::get('harga_beli');
		$rak->harga_jual = Input::get('harga_jual');
		$rak->formula_id = Input::get('formula_id');
		$rak->save();

		$formula = Formula::find($rak->formula_id);

		$sediaan = $formula->sediaan;

		if($formula->komposisi->count() >1){
			$merek = ucwords(strtolower(Input::get('merek'))) . ' ' . $sediaan;
		} else {
			$merek = ucwords(strtolower(Input::get('merek'))) . ' ' . $sediaan . ' ' . $formula->komposisi->first()->bobot;
		}

		$merek_id_custom = Yoga::customId('App\Merek');
		$mrk = new Merek;
		$mrk->id = $merek_id_custom;
		$mrk->rak_id = Input::get('id');
		$mrk->merek = $merek;
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
		$query .= "group by supplier_id ";
		$query .= "order by harga_beli asc;";
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
		$rak = Rak::findOrFail($id);

		$rules = [

			'exp_date' => 'required',
			'fornas' => 'required',
			'harga_beli' => 'required',
			'harga_jual' => 'required',
			'formula_id' => 'required',
			'stok' => 'required',
			'stok_minimal' => 'required'

		];

		$validator = \Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		// return Input::all();
		
		$rak->id = Input::get('id');
		$rak->alternatif_fornas = Input::get('alternatif_fornas');
		$rak->exp_date = Yoga::datePrep(Input::get('exp_date'));
		$rak->fornas = Input::get('fornas');
		$rak->harga_beli = Input::get('harga_beli');
		$rak->harga_jual = Input::get('harga_jual');
		$rak->formula_id = Input::get('formula_id');
		$rak->stok = Input::get('stok');
		$rak->stok_minimal = Input::get('stok_minimal');
		$confirm = $rak->save();
		if ($confirm) {
			$pesan = 'Rak <strong>' . $id . '</strong> telah <strong>BERHASIL</strong> diubah';
		} else {
			$pesan = 'Rak <strong>' . $id . '</strong> telah <strong>GAGAL</strong> diubah';
		}

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
		if (!Rak::destroy($id)) {
			return redirect()->back();
		}
		return \Redirect::route('mereks.index')->withPesan(Yoga::suksesFlash('Rak <strong>' . $id . '</strong> dan seluruh Merek <strong>' . $merek_terhapus . '</strong> di bawah nya <strong>BERHASIL</strong> dihapus'));
	}

}
