<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Models\StokOpname;
use DB;
use App\Models\Rak;
use App\Models\Classes\Yoga;

class StokOpnamesController extends Controller
{

	/**
	 * Display a listing of stokopnames
	 *
	 * @return Response
	 */
	public function index()
	{	
		$lists = $this->soOption(date('Y-m'));
		return view('stokopnames.index', compact('lists'));
	}

	/**
	 * Show the form for creating a new stokopname
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('stokopnames.create');
	}

	/**
	 * Store a newly created stokopname in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
		$validator = \Validator::make($data = Input::all(), StokOpname::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$date = Input::get('bulanTahun');
		$rak_id = Input::get('rak_id');

		$query = "SELECT * ";
		$query .= ", r.kode_rak as kode_rak";
		$query .= "FROM stok_opnames as sto ";
		$query .= "JOIN raks as rak on rak.id = sto.rak_id ";
		$query .= "where created_at like '{$date}%' ";
		$query .= "and rak_id = '{$rak_id}'";
		$query .= "AND tenant_id = " . session()->get('tenant_id') . " ";
		$count = count(DB::select($query));
		if ($count < 1) {

			$rk       = Rak::find( Input::get('rak_id') );

			$so                = new StokOpname;
			$so->id            = Input::get('id');
			$so->rak_id        = Input::get('rak_id');
			$so->staf_id       = Input::get('staf_id');
			$so->stok_komputer = $rk->stok;
			$so->stok_fisik    = Input::get('stok_fisik');
			$so->exp_date      = Yoga::datePrep(Input::get('exp_date'));
			$ok = $so->save();
			if ($ok) {
				$rk->stok   = Input::get('stok_fisik');
				$rk->exp_date   = Yoga::datePrep(Input::get('exp_date'));
				$rk->save();
			}
			$confirm = '1';
		} else {
			$confirm = '0';
		}

		return json_encode([
					'confirm' => $confirm,
					'array'   => $this->data(Yoga::bulanTahun(Input::get('bulanTahun'))),
					'option'  => $this->option(Yoga::bulanTahun(Input::get('bulanTahun'))),
					'sisa'	  => $this->soOption(Yoga::bulanTahun(Input::get('bulanTahun')))
				]);
	}

	/**
	 * Display the specified stokopname.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function awal()
	{
		return json_encode([
			'array' 	=> $this->data(Yoga::bulanTahun(Input::get('bulanTahun'))),
			'sisa'	  	=> $this->soOption(Yoga::bulanTahun(Input::get('bulanTahun'))),
			'option'    => $this->option(Yoga::bulanTahun(Input::get('bulanTahun')))
		]);
	}

	public function change()
	{
		$rak_id = Input::get('rak_id');
		$stok = Rak::find($rak_id)->stok;
		return $stok;
	}

	/**
	 * Show the form for editing the specified stokopname.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$stokopname = StokOpname::find($id);
		return view('stokopnames.edit', compact('stokopname'));
	}

	/**
	 * Update the specified stokopname in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$stokopname = StokOpname::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), StokOpname::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$stokopname->update($data);

		return \Redirect::route('stokopnames.index');
	}

	/**
	 * Remove the specified stokopname from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{

		$so = StokOpname::find( Input::get('id') );
		$rak_id = $so->rak_id;
		$stok_komputer = $so->stok_komputer;
		$confirm = $so->delete();
		if ($confirm) {
			$confirm = '1';
			$rk       = Rak::find($rak_id);
			$rk->stok   = $stok_komputer;
			$rk->save();
		} else {
			$confirm = '0';
		}

		return json_encode([
			'confirm' => $confirm,
			'array'   => $this->data(Yoga::bulanTahun(Input::get('bulanTahun'))),
			'option'  => $this->option(Yoga::bulanTahun(Input::get('bulanTahun'))),
			'sisa'	  => $this->soOption(Yoga::bulanTahun(Input::get('bulanTahun')))
		]);

	}

	private function data($date){
		$query = "SELECT so.id as so_id, ";
		$query .= "m.merek as merek, ";
		$query .= "so.exp_date as exp_date, ";
		$query .= "so.stok_komputer as stok_komputer, ";
		$query .= "so.stok_fisik as stok_fisik, ";
		$query .= "r.id as rak_id, ";
		$query .= "r.kode_rak as kode_rak ";
		$query .= "FROM stok_opnames as so ";
		$query .= "join raks as r on r.id = so.rak_id ";
		$query .= "join mereks as m on m.rak_id = r.id ";
		$query .= "where so.created_at like '{$date}%' ";
		$query .= "AND so.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by so.id";
		$data = DB::select($query);
		return $data;
	}

	private function soOption($date){
		$query = "SELECT m.merek as merek, ";
		$query .= "r.id as rak_id, ";
		$query .= "r.kode_rak as kode_rak, ";
		$query .= "m.id as merek_id, ";
		$query .= "r.stok as stok ";
		$query .= "from mereks as m ";
		$query .= "join raks as r on r.id = m.rak_id ";
		$query .= "where r.id not in ";
		$query .= "(";
		$query .= "select rak_id ";
		$query .= "from stok_opnames ";
		$query .= "where created_at like '{$date}%'";
		$query .= "AND tenant_id = " . session()->get('tenant_id') . " ";
		$query .= ") ";
		$query .= "order by stok_minimal desc";
		$mereks = DB::select($query);
		return $mereks;
	}

	private function option($date){
		$option = '<option value="">- pilih -</option>';
		$Array = $this->soOption($date);
		foreach ($Array as $k => $v) {
			$option .= '<option value="' . $v->rak_id . '">' . $v->kode_rak . ' - ' .$v->merek . '</option>';
		}

		return $option;
	}
}
