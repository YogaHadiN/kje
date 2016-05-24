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
		$mereks = Merek::all();
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
				return Redirect::back()->withErrors($validator)->withInput();
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
		$query = "SELECT mr.merek as merek, sp.nama as nama, sp.alamat as alamat, sp.no_telp as no_telp, sp.hp_pic as hp_pic, sp.pic as pic, fb.supplier_id as supplier_id, pb.harga_beli, max(fb.tanggal) as tanggal from pembelians as pb join faktur_belanjas as fb on fb.id = pb.faktur_belanja_id join suppliers as sp on sp.id = fb.supplier_id join mereks as mr on mr.id = pb.merek_id join raks as rk on rk.id = mr.rak_id  where mr.id ='{$id}' group by supplier_id order by harga_beli asc;";
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
			return Redirect::back()->withErrors($validator)->withInput();
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
		$merek = Merek::findOrFail($id);

		$nama = $merek->merek;

		$conf = $merek->delete();

		if ($conf) {
			$pesan = 'Obat dengan merek <strong>' . $id . ' - '  . $nama . '</strong> telah <strong>BERHASIL</strong> dihapus';
		} else {
			$pesan = 'Obat dengan merek <strong>' . $id . ' - '  . $nama . '</strong> telah <strong>GAGAL</strong> dihapus';

		}

		return \Redirect::route('mereks.index')->withPesan(Yoga::suksesFlash($pesan));
	}

}
