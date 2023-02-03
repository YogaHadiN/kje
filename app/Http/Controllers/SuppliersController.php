<?php




namespace App\Http\Controllers;

use Input;
use Image;
use Storage;
use App\Http\Requests;

use App\Models\Supplier;
use App\Models\Classes\Yoga;
use App\Models\Belanja;
use App\Models\Pengeluaran;
use App\Models\FakturBelanja;

class SuppliersController extends Controller
{
	public $input_nama;
	public $input_alamat;
	public $input_no_telp;
	public $input_hp_pic;
	public $input_pic;
	public $hasFileImage;
	public $fileImage;
	public $hasFileMukaImage;
	public $fileMukaImage;

	/**
	 * Display a listing of suppliers
	 *
	 * @return Response
	 */
	


  public function __construct()
    {
		$this->input_nama       = Input::get('nama');
		$this->input_alamat     = Input::get('alamat');
		$this->input_no_telp    = Input::get('no_telp');
		$this->input_hp_pic     = Input::get('hp_pic');
		$this->input_pic        = Input::get('pic');
		$this->hasFileImage     = Input::hasFile('image');
		$this->fileImage        = Input::file('image');
		$this->hasFileMukaImage = Input::hasFile('muka_image');
		$this->fileMukaImage    = Input::file('muka_image');
        $this->middleware('admin', ['except' => []]);
        $this->middleware('super', ['only' => 'delete']);
    }



	public function index()
	{
		$suppliers = Supplier::all();
		$stafs = Yoga::stafList();

		$belanjaList = [ null => '- Jenis Belanja -']  + Belanja::pluck('belanja', 'id')->all();

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

		$supplier = new Supplier;
		$supplier = $this->inputData($supplier);

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
        if (is_null( $supplier )) {
            $pesan = Yoga::gagalFlash('Supplier dengan id <strong>' . $id . '</strong> Tidak ditemukan');
            return redirect()->back()->withPesan($pesan);
        }

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

		$supplier = $this->inputData($supplier);

		$nama = $supplier->nama;

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
	public function inputData($supplier){
		$supplier->nama       = $this->input_nama;
		$supplier->alamat     = $this->input_alamat;
		$supplier->no_telp    = $this->input_no_telp;
		$supplier->hp_pic     = $this->input_hp_pic;
		$supplier->pic        = $this->input_pic;
		$supplier->save();
		$supplier->image      = $this->imageUpload('ktp_supplier', $this->hasFileImage, $this->fileImage, 'img/supplier', 'image', $supplier);
		$supplier->muka_image = $this->imageUpload('muka_supplier', $this->hasFileMukaImage, $this->fileMukaImage,'img/supplier', 'muka_image', $supplier);
		$supplier->save();
		return $supplier;
	}
	
	private function imageUpload($pre, $hasFile, $upload_cover, $folder, $fieldName, $staf){
		if( $hasFile ) {
			//
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			/* $upload_cover = Image::make($upload_cover); */
			/* $upload_cover->resize(1000, null, function ($constraint) { */
			/* 	$constraint->aspectRatio(); */
			/* 	$constraint->upsize(); */
			/* }); */
			//membuat nama file random + extension
			$filename =	 $folder . '/' .  $pre . $staf->id . '_' . time() . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			$destination_path = public_path() . DIRECTORY_SEPARATOR;

			// Mengambil file yang di upload
			/* $upload_cover->save($destination_path . '/' . $filename); */
			Storage::disk('s3')->put( $filename, file_get_contents($upload_cover));
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return $filename;
			
		} else {
			return $staf->$fieldName;
		}

	}

}
