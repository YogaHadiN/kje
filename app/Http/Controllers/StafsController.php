<?php


namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use App\Staf;
use App\Classes\Yoga;

class StafsController extends Controller
{


	  public function __construct()
    {
        $this->middleware('super', ['only' => ['delete','update']]);
    }

	/**
	 * Display a listing of stafs
	 *
	 * @return Response
	 */
	public function index()
	{
		$stafs = Staf::all();
		// return 'oke';
		return view('stafs.index', compact('stafs'));
	}

	/**
	 * Show the form for creating a new staf
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('stafs.create');
	}

	/**
	 * Store a newly created staf in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make(Input::all(), Staf::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$nama = ucwords(strtolower(Input::get('nama'))) . ', ' . Input::get('titel');

		$staf_id                = Yoga::customId('App\Staf');
		$staf                   = new Staf;
		$staf->id               = $staf_id;
		$staf->alamat_domisili  = Input::get('alamat_domisili'); 
		$staf->alamat_ktp       = Input::get('alamat_ktp'); 
		$staf->email            = Input::get('email'); 
		$staf->titel            = Input::get('titel'); 
		$staf->ktp              = Input::get('ktp'); 
		$staf->nama             = $nama; 
		$staf->no_hp            = Input::get('no_hp'); 
		$staf->no_telp          = Input::get('no_telp'); 
		$staf->str              = Input::get('str'); 
		$staf->ktp_image              = $this->imageUpload('ktp', 'ktp_image', $staf_id); 
		$staf->str_image              = $this->imageUpload('str', 'str_image', $staf_id); 
		$staf->sip_image              = $this->imageUpload('sip', 'sip_image', $staf_id); 
		$staf->tanggal_lahir    = Yoga::datePrep( Input::get('tanggal_lahir') ); 
		$staf->tanggal_lulus    = Yoga::datePrep( Input::get('tanggal_lulus') ); 
		$staf->tanggal_mulai    = Yoga::datePrep( Input::get('tanggal_mulai') ); 
		$staf->universitas_asal = Input::get('universitas_asal'); 
		
		if (!empty(Input::get('image'))) {
			$staf->image      	= Yoga::inputStafImageIfNotEmpty(Input::get('image'), $staf_id);
		}

		$staf->save();


		return redirect('stafs')->withPesan(Yoga::suksesFlash('Staf baru <strong>' . $nama . '</strong> Berhasil <strong>Dimasukkan</strong>'));
	}

	/**
	 * Display the specified staf.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$staf = Staf::findOrFail($id);

		return view('stafs.show', compact('staf'));
	}

	/**
	 * Show the form for editing the specified staf.
	 *
	 * @param  int  $id
     * @return Response
	 */
	public function edit($id)
	{
		$staf = Staf::find($id);

		return view('stafs.edit', compact('staf'));
	}

	/**
	 * Update the specified staf in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//return dd( Input::all() );
		//return dd( Input::hasFile('ktp_image') );
		$staf = Staf::findOrFail($id);

		$staf = Staf::find($id);
		$staf->alamat_domisili = Input::get('alamat_domisili'); 
		$staf->alamat_ktp = Input::get('alamat_ktp'); 
		$staf->email = Input::get('email'); 
		$staf->titel = Input::get('titel'); 
		$staf->ktp = Input::get('ktp'); 
		$staf->nama = Input::get('nama'); 
		$staf->no_hp = Input::get('no_hp'); 
		$staf->no_telp = Input::get('no_telp'); 
		$staf->str = Input::get('str'); 
		if (Input::hasFile('ktp_image')) {
			$staf->ktp_image              = $this->imageUpload('ktp', 'ktp_image', $id); 
		}

		if (Input::hasFile('str_image')) {
			$staf->str_image              = $this->imageUpload('str', 'str_image', $id); 
		}

		if (Input::hasFile('sip_image')) {
			$staf->sip_image              = $this->imageUpload('sip', 'sip_image', $id); 
		}
		$staf->tanggal_lahir = Yoga::datePrep(Input::get('tanggal_lahir')); 
		$staf->tanggal_lulus = Yoga::datePrep(Input::get('tanggal_lulus')); 
		$staf->tanggal_mulai = Yoga::datePrep(Input::get('tanggal_mulai')); 
		$staf->universitas_asal = Input::get('universitas_asal');

		if (!empty(Input::get('image'))) {
			$staf->image      	= Yoga::inputStafImageIfNotEmpty(Input::get('image'), $id);
		}

		$staf->save();

		return redirect('stafs')->withPesan(Yoga::suksesFlash('Staf <strong>' . Input::get('nama') . '</strong> Berhasil <strong>Diubah</strong>'));
	}

	/**
	 * Remove the specified staf from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$staf = Staf::find($id);
		$nama = $staf->nama;
		if (!$staf->delete()) {
			return redirect()->back();
		}

		return redirect('stafs')->withPesan(Yoga::suksesFlash('Staf <strong>' . $nama . '</strong> Berhasil <strong>Dihapus</strong>'));
	}


	private function imageUpload($pre, $fieldName, $id){
		if(Input::hasFile($fieldName)) {

			$upload_cover = Input::file($fieldName);
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			//membuat nama file random + extension
			$filename =	 $pre . $id . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			$destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/staf';

			if (gethostname() == 'kje') {
				$dropbox_path = '/home/kje/Dropbox/backup11/img/staf';
				$upload_cover->move($dropbox_path, $filename);
			}

			// Mengambil file yang di upload
			$upload_cover->move($destination_path, $filename);
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return 'img/staf/'. $filename;
			
		} else {
			return null;
		}

	}
}
