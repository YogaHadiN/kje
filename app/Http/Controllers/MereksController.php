<?php



namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Merek;
use App\Classes\Yoga;
use App\Rak;
use App\Formula;
use DB;
use App\Pembelian;

class MereksController extends Controller
{

	/**
	 * Display a listing of mereks
	 *
	 * @return Response
	 */
	public function index()
	{
		$mereks = Merek::with('rak.formula.komposisi.generik')->get();
		// $mereks = Merek::where('id', '>', '0')->get();

		return view('mereks.index', compact('mereks'));
	}

	/**
	 * Show the form for creating a new merek
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('mereks.create');
	}

	/**
	 * Store a newly created merek in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if (Input::ajax()) {
		} else {
			$validator = \Validator::make($data = Input::all(), Merek::$rules);

			if ($validator->fails())
			{
				return \Redirect::back()->withErrors($validator)->withInput();
			}
		}

		$merek_custom = ucwords(strtolower(Input::get('merek'))) . ' ' . Input::get('endfix');
		$merek_id_custom = Yoga::customId('App\Merek');
		$merek = new Merek;
		$merek->id= $merek_id_custom;
		$merek->merek = $merek_custom;
		$merek->rak_id = Input::get('rak_id');
		$merek->save();

		if (Input::ajax()) {
			$returnData = [
				'merek_id' => $merek_id_custom,
				'merek'	=> $merek_custom,
				'custom_value' => Merek::find($merek_id_custom)->custid
			];

			return json_encode($returnData);

		} else {
			return \Redirect::route('mereks.index')->withPesan(Yoga::suksesFlash('MEREK obat <strong>' . $merek_id_custom . ' - ' . $merek_custom . '</strong> telah <strong>BERHASIL</strong> dibuat'));
		}
	}

	/**
	 * Display the specified merek.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$merek = Merek::findOrFail($id);
		return view('mereks.show', compact('merek'));
	}

	/**
	 * Show the form for editing the specified merek.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$merek = Merek::find($id);

		$rak = Rak::find($merek->rak_id);
		$formula = Formula::find($rak->formula_id);
		$query = "SELECT mr.merek as merek, ";
		$query .= "rk.id as rak_id, ";
		$query .= "mr.id as merek_id, ";
		$query .= "sp.nama as nama, ";
		$query .= "pb.faktur_belanja_id as faktur_belanja_id, ";
		$query .= "sp.alamat as alamat, ";
		$query .= "sp.no_telp as no_telp, ";
		$query .= "sp.hp_pic as hp_pic, ";
		$query .= "sp.pic as pic, ";
		$query .= "fb.supplier_id as supplier_id, ";
		$query .= "pb.harga_beli, ";
		$query .= "max(fb.tanggal) as tanggal ";
		$query .= "from pembelians as pb ";
		$query .= "join faktur_belanjas as fb on fb.id = pb.faktur_belanja_id ";
		$query .= "join suppliers as sp on sp.id = fb.supplier_id ";
		$query .= "join mereks as mr on mr.id = pb.merek_id ";
		$query .= "join raks as rk on rk.id = mr.rak_id ";
		$query .= "where mr.id ='{$id}' ";
		$query .= "group by supplier_id ";
		$query .= "order by harga_beli asc;";
		$supplierprices = DB::select($query);

		// return var_dump($supplierprices);
		$pembelians = Pembelian::where('merek_id', $id)->latest()->get();


		return view('mereks.edit', compact('merek', 'rak', 'formula', 'pembelians', 'supplierprices'));
	}

	/**
	 * Update the specified merek in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$merek = Merek::findOrFail($id);
		$validator = \Validator::make($data = Input::all(), Merek::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$merek = Merek::find($id);
		$merek->merek = ucwords(strtolower(Input::get('merek')));
		$merek->save();

		return \Redirect::route('mereks.index')->withPesan(Yoga::suksesFlash('merek <strong>' . $id . ' - ' . $merek->merek . '</strong> berhasil Diubah'));
	}

	/**
	 * Remove the specified merek from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$merek = Merek::with('rak')->where('id', $id)->first();

		$nama = $merek->merek;
		$rak_id = $merek->rak_id;
		$formula_id = $merek->rak->formula_id;

		$nama = $merek->merek;
		$conf = $merek->delete();


		$rak_count = Merek::where('rak_id', $rak_id)->count();
		if ($rak_count < 1) {
			$confirm_rak_delete = Rak::destroy($rak_id);
		}

		$formula_count = Rak::where('formula_id', $formula_id)->count();
		if ( $formula_count < 1 ) {
			$confirm_formula_delete = Formula::destroy($formula_id);
		}

		if ($conf) {
			$pesan = 'Obat dengan merek <strong>' . $id . ' - '  . $nama . '</strong> telah <strong>BERHASIL</strong> dihapus';
			if ($confirm_rak_delete) {
				$pesan .= '<br />Rak <strong>' . $rak_id . ' - '  . $nama . '</strong> telah <strong>BERHASIL</strong> dihapus';
			}
			if ($confirm_formula_delete) {
				$pesan .= '<br />Formula <strong>' . $formula_id . ' - '  . $nama . '</strong> telah <strong>BERHASIL</strong> dihapus';
			}
		} else {
			$pesan = 'Obat dengan merek <strong>' . $id . ' - '  . $nama . '</strong> telah <strong>GAGAL</strong> dihapus';
		}

		return \Redirect::route('mereks.index')->withPesan(Yoga::suksesFlash($pesan));
	}

}
