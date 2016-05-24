<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\JurnalUmum;
use App\Coa;


class JurnalUmumsController extends Controller
{

	/**
	 * Display a listing of jurnalumums
	 *
	 * @return Response
	 */
	public function index()
	{

		$jurnalumums = JurnalUmum::all();

		foreach ($jurnalumums as $k => $ju) {
			try {
				$ju->coa->coa;
			} catch (\Exception $e) {
				return redirect('jurnal_umums/coa')->withPesan(Yoga::gagalFlash('Ada beberapa Chart Of Account yang harus disesuaikan dulu'));
			}
		}
		$jurnalumums = JurnalUmum::groupBy('created_at')->orderBy('created_at', 'desc')->paginate(10);

		return view('jurnal_umums.index', compact('jurnalumums'));
	}

	/**
	 * Show the form for creating a new jurnalumum
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('jurnalumums.create');
	}

	/**
	 * Store a newly created jurnalumum in storage.
	 *
	 * @return Response
	 */
	public function coa()
	{

		$jurnals = JurnalUmum::all();
		$ids = [];
		foreach ($jurnals as $k => $ju) {
			try {
				$ju->coa->coa;
			} catch (\Exception $e) {
				$ids[] = $ju->id;
			}
		}


		// return $ids;
		$jurnalumums = JurnalUmum::whereIn('id', $ids)->get();
		$bebanCoaList = [null => '-pilih-'] + Coa::whereIn('kelompok_coa_id', [5,6,8])->lists('coa', 'id')->all();
		$pendapatanCoaList = [null => '-pilih-'] + Coa::whereIn('kelompok_coa_id', [4,7])->lists('coa', 'id')->all();

		return view('jurnal_umums.coa', compact(
			'jurnalumums', 
			'bebanCoaList',
			'pendapatanCoaList'
		));
		// return $jurnalumums;

	}

	/**
	 * Display the specified jurnalumum.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$jurnalumum = Jurnalumum::findOrFail($id);

		return view('jurnalumums.show', compact('jurnalumum'));
	}

	/**
	 * Show the form for editing the specified jurnalumum.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$jurnalumum = Jurnalumum::find($id);

		return view('jurnalumums.edit', compact('jurnalumum'));
	}

	/**
	 * Update the specified jurnalumum in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$jurnalumum = Jurnalumum::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Jurnalumum::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$jurnalumum->update($data);

		return \Redirect::route('jurnalumums.index');
	}

	/**
	 * Remove the specified jurnalumum from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Jurnalumum::destroy($id);

		return \Redirect::route('jurnalumums.index');
	}

}
