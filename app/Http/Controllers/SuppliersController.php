<?php




namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Supplier;
use App\Classes\Yoga;
use App\Belanja;
use App\Pengeluaran;
use App\FakturBelanja;

class SuppliersController extends Controller
{

	/**
	 * Display a listing of suppliers
	 *
	 * @return Response
	 */
	


  public function __construct()
    {
        $this->middleware('super', ['only' => 'delete']);
    }



	public function index()
	{
		$suppliers = Supplier::all();
		$stafs = Yoga::stafList();

		$belanjaList = [ null => '- Jenis Belanja -']  + Belanja::lists('belanja', 'id')->all();

		return view('suppliers.index', compact('suppliers', 'stafs', 'belanjaList'));
	}

	/**
	 * Show the form for creating a new supplier
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('suppliers.create');
	}

	/**
	 * Store a newly created supplier in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = [
			'nama' => 'required'
		];
		$validator = \Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		} 

		Supplier::create($data);

		$nama = Input::get('nama');
		if (Input::ajax()) {
			$options = [];
			foreach (Yoga::supplierList() as $k => $v) {
				$options[] = [
					'value' => $k,
					'text' => $v
				];
			}
			return json_encode([
				'confirm' => '1',
				'last_id' => Supplier::latest()->first()->id,
				'options' =>  $options
			]);
		}

		return \Redirect::route('suppliers.index')->withPesan(Yoga::suksesFlash('Supplier <strong>' . $nama . '</strong> telah <strong>BERHASIL</strong> dibuat'));
	}

	/**
	 * Display the specified supplier.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$supplier = Supplier::find($id);
		$belanja_obats = FakturBelanja::with('belanja', 'pembelian')
			->where('supplier_id', $id)
			->where('belanja_id', '1')
			->latest()
			->paginate(20);

		$belanja_obats_count = FakturBelanja::with('belanja', 'pembelian')
			->where('supplier_id', $id)
			->where('belanja_id', '1')
			->count();

		$belanja_alats = FakturBelanja::with('belanja', 'pembelian')
			->where('supplier_id', $id)
			->where('belanja_id', '4')
			->latest()
			->paginate(20);

		$belanja_alats_count = FakturBelanja::with('belanja', 'pembelian')
			->where('supplier_id', $id)
			->where('belanja_id', '4')
			->count();

		$pengeluarans = Pengeluaran::with('staf')
			->where('supplier_id', $id)
			->latest()
			->paginate(20);

		$pengeluarans_count = Pengeluaran::with('staf')
			->where('supplier_id', $id)
			->count();

		return view('suppliers.show', compact(
			'belanja_obats', 
			'belanja_alats', 
			'pengeluarans', 
			'belanja_obats_count', 
			'belanja_alats_count', 
			'pengeluarans_count', 
			'supplier'
		));
	}

	/**
	 * Show the form for editing the specified supplier.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$supplier = Supplier::find($id);

		return view('suppliers.edit', compact('supplier'));
	}

	/**
	 * Update the specified supplier in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$supplier = Supplier::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Supplier::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$supplier->update($data);

		
		$nama = Input::get('nama');

		return \Redirect::route('suppliers.index')->withPesan(Yoga::suksesFlash('Supplier <strong>' . $nama . '</strong> telah <strong>BERHASIL</strong> diubah'));
	}

	/**
	 * Remove the specified supplier from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Supplier::destroy($id);

				
		$nama = Input::get('nama');

		return \Redirect::route('suppliers.index')->withPesan(Yoga::suksesFlash('Supplier <strong>' . $nama . '</strong> telah <strong>BERHASIL</strong> dihapus'));
	}

}
