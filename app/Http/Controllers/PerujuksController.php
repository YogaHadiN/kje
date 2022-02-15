<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Models\Perujuk;

class PerujuksController extends Controller
{

	/**
	 * Display a listing of perujuks
	 *
	 * @return Response
	 */
	public function index()
	{
		$perujuks = Perujuk::all();

		return view('perujuks.index', compact('perujuks'));
	}

	/**
	 * Show the form for creating a new perujuk
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('perujuks.create');
	}

	/**
	 * Store a newly created perujuk in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Perujuk::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		
		Perujuk::create($data);

		return redirect('perujuks')->withPesan('Perujuk dengan nama <strong>' . Input::get('nama') . '</strong> berhasil dimasukkan');
	}

	/**
	 * Display the specified perujuk.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$perujuk = Perujuk::findOrFail($id);

		return view('perujuks.show', compact('perujuk'));
	}

	/**
	 * Show the form for editing the specified perujuk.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$perujuk = Perujuk::find($id);

		return view('perujuks.edit', compact('perujuk'));
	}

	/**
	 * Update the specified perujuk in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$perujuk = Perujuk::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Perujuk::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$perujuk->update($data);

		return redirect('perujuks')->withPesan('Perujuk dengan nama <strong>' . Input::get('nama') .'</strong> berhasil diubah');;
	}

	/**
	 * Remove the specified perujuk from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$perujuk = Perujuk::find($id);
		$perujuk->delete();

		return redirect('perujuks')->withPesan('Perujuk dengan nama <strong>' . $perujuk->id . ' - ' . $perujuk->nama . '</strong> berhasil dihapus');;
	}

	public function ajaxcreate(){

		 $nama = Input::get('nama');
		 $alamat = Input::get('alamat');
		 $no_telp = Input::get('no_telp');

		 $data = [
			  'nama' => $nama,
			  'alamat' => $alamat,
			  'no_telp' => $no_telp
		 ];

		$confirm = Perujuk::create($data);
		 if ($confirm) {
			 $options =  Perujuk::pluck('nama', 'id');
			 $temp = '<option value="">-pilih-</option>';
			 foreach ($options as $k => $opt) {
			 	$temp .= '<option value="' . $k . '">' . $opt . '</option>';
			 }
			 return [
				 'result' => '1',
				 'value' => $confirm->id,
				 'options' => $temp
			 ];
		 } else {
			 return [
				 'result' => '0',
				'options' => []
			 ];
		 }
		 
	}

}
