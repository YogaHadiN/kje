<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Monitor;
use App\Periksa;

class MonitorsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * GET /monitors
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('monitor');
		
	}
	public function puas()
	{
		$periksa_id = Monitor::find(1)->periksa_id;


		if($periksa_id == '0'){
			return '0';
		}

		$periksa = Periksa::find($periksa_id);
		$periksa->satisfaction_index = '3';
		$confirm = $periksa->save();

		if ($confirm){
			$this->buatNol();

			return '1';
		}

	}
	public function biasa()
	{
		$periksa_id = Monitor::find(1)->periksa_id;


		if($periksa_id == '0'){
			return '0';
		}

		$periksa = Periksa::find($periksa_id);
		$periksa->satisfaction_index = '2';
		$confirm = $periksa->save();

		if ($confirm){
			$this->buatNol();

			return '1';
		}
				
	}
	public function kecewa()
	{
		$periksa_id = Monitor::find(1)->periksa_id;


		if($periksa_id == '0'){
			return '0';
		}

		$periksa = Periksa::find($periksa_id);
		$periksa->satisfaction_index = '1';
		$confirm = $periksa->save();

		if ($confirm){
			$this->buatNol();
			return '1';
		}
				
	}
	public function buatIdPeriksaNol(){
		$this->buatNol();
	}
	private function buatNol(){
		$mtr = Monitor::find(1);
		$mtr->periksa_id = '0';
		$mtr->save();
	}
		

	

}
