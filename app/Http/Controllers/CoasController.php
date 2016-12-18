<?php

namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use App\Coa;
use App\KelompokCoa;
use App\Classes\Yoga;

class CoasController extends Controller
{

	/**
	 * Display a listing of coas
	 *
	 * @return Response
	 */
	public function index()
	{
		$coas = Coa::with('kelompokCoa')->latest()->get();
		$kelompokCoa = KelompokCoa::all();
		return view('coas.index', compact('coas', 'kelompokCoa'));
	}

	/**
	 * Show the form for creating a new coa
	 *
	 * @return Response
	 */
	public function create()
	{

		$kelompokCoaList = $this->kelompokCoaList();
		return view('coas.create', compact('kelompokCoaList'));
	}

	/**
	 * Store a newly created coa in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$coa       = new Coa;
		$coa->id   = Input::get('coa_id');
		$coa->coa   = Input::get('coa');
		$coa->kelompok_coa_id   = Input::get('kelompok_coa_id');
		$confirm = $coa->save();
		
		if ($confirm) {
			$pesan = Yoga::suksesFLash('Input Coa <strong>' . $coa->coa . '</strong> telah berhasil');
		} else {
			$pesan = Yoga::gagalFLash('Input Coa <strong>' . $coa->coa . '</strong> telah gagal');
		}
		
		return redirect('coas')->withPesan($pesan);
	}

	/**
	 * Display the specified coa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$coa = Coa::findOrFail($id);
		return view('coas.show', compact('coa'));
	}

	/**
	 * Show the form for editing the specified coa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$coa = Coa::find($id);
		$kelompokCoaList = $this->kelompokCoaList();
		return view('coas.edit', compact('coa', 'kelompokCoaList'));
	}

	/**
	 * Update the specified coa in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$coa = Coa::findOrFail($id);
		$rules = [
			'coa_id' => 'unique:coas,id,' . $id . '|required',
			'coa' => 'unique:coas,coa,' .$coa->id .'|required',
			'kelompok_coa_id' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		
		$coa->id   = Input::get('coa_id');
		$coa->coa   = Input::get('coa');
		$coa->kelompok_coa_id   = Input::get('kelompok_coa_id');
		$confirm = $coa->save();
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Chart Of Account '  . $coa->id . ' - '. $coa->coa . ' berhasil di Update');
		} else {
			$pesan = Yoga::gagalFlash('Chart Of Account '  . $coa->id . ' - '. $coa->coa . ' gagal di Update');
		}

		return redirect('coas')->withPesan($pesan);
	}

	/**
	 * Remove the specified coa from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function destroy($id)
	{
		Coa::destroy($id);
		return \Redirect::route('coas.index');
	}

	public function cekCoaSama(){
		$kode_coa_id = Input::get('kode_coa_id');

		if (Coa::find($kode_coa_id) == null) {
			return '0';
		}

		return '1';
	}
	public function kelompokCoaList(){
		return [ null => ' - pilih - ' ] + KelompokCoa::orderBy('id')->get()->lists('ccoa', 'id')->all();
	}
	public function cekCoaSamaEdit(){
		$kode_coa_id = Input::get('kode_coa_id');
		$coa_asal = Input::get('coa_asal');

		if (Coa::where('id', $kode_coa_id)->where('id', '!=', $coa_asal)->count() == 0) {
			return '0';
		}

		return '1';
		
	}
	
	
	
}
