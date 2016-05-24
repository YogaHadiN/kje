<?php

namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use App\Rujukan;
use DB;
use App\RegisterHamil;
use App\Classes\Yoga;
use App\TujuanRujuk;
use App\RumahSakit;
use App\Periksa;

class RujukansController extends Controller
{

	/**
	 * Display a listing of rujukans
	 *
	 * @return Response
	 */
	public function index()
	{
		$rujukans = Rujukan::orderBy('id', 'desc')->paginate(10);
		$count = Rujukan::count();
		return view('rujukans.index', compact('rujukans', 'count'));
	}

	/**
	 * Show the form for creating a new rujukan
	 *
	 * @return Response
	 */
	public function create($id)
	{

		$periksa = Periksa::find($id);

		$isHamil = '0';
		$g = null;
		$p = null;
		$a = null;
		$hpht = null;

		if ($periksa->register_anc) {

			$isHamil = '1';
			$g = $periksa->register_anc->register_hamil->g;
			$p = $periksa->register_anc->register_hamil->p;
			$a = $periksa->register_anc->register_hamil->a;
			$hpht = $periksa->register_anc->register_hamil->hpht;
		}

		$specs = TujuanRujuk::all(['tujuan_rujuk']);
  		$tujuan_rujuks = [];
  
  		foreach ($specs as $sp) {
  			$tujuan_rujuks[] = $sp->tujuan_rujuk;
  		}
  		
  		$tujuan_rujuks = json_encode($tujuan_rujuks);
		return view('rujukans.create', compact('periksa', 'tujuan_rujuks', 'isHamil', 'g', 'p', 'a', 'hpht'));
	}

	/**
	 * Store a newly created rujukan in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rujuk = new Rujukan;
		$rules =[
			'tujuan_rujuk' => 'required',
			'rumah_sakit'  => 'required',
			'alasan_rujuk' => 'required',
			'periksa_id'   => 'required'
		];
		$validator = \Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}




		$periksa                   = Periksa::find(Input::get('periksa_id'));
		// INPUT RUJUKAN 
		// cek apakah rujukannya rujukan baru atay lama
		$tujuan_rujuk              = str_replace(' ', '', Input::get('tujuan_rujuk'));
		$query                     = DB::select("SELECT * FROM tujuan_rujuks WHERE replace(tujuan_rujuk,' ','') = '" . $tujuan_rujuk . "'");
		//jika rujukan cocok dengan rujukan yang lama, maka masukkan rujukan yang cocok
		if(count($query) > 0){
			$id                        = $query[0]->id;
		//jika tidak ada rujukan yang cocok, buat rujukan baru
		} else {
			//INPUT TUJUAN RUJUK BARU
			$tujuan_baru               = new TujuanRujuk;
			$tujuan_baru->tujuan_rujuk = Input::get('tujuan_rujuk');
			$tujuan_baru->save();
			$id                        = $tujuan_baru->id;
		}
		$rujuk->tujuan_rujuk_id = $id;
		$rujuk->alasan_rujuk    = Input::get('alasan_rujuk');
		$rujuk->periksa_id      = $periksa->id;
		// cek apakah rumah sakit baru atau lama 
		$rumah_sakit = str_replace(' ', '', Input::get('rumah_sakit'));
		$query = DB::select("SELECT * FROM rumah_sakits WHERE replace(nama,' ','') = '" . $rumah_sakit . "'");
		if(count($query) > 0){
			$id = $query[0]->id;
		//jika tidak ada rujukan yang cocok, buat rujukan baru
		} else {
			//INPUT RUMAH SAKIT BARU
			$rs_baru                    = new RumahSakit;
			$rs_baru->nama              = Input::get('rumah_sakit');
			$rs_baru->jenis_rumah_sakit = Input::get('jenis_rumah_sakit_id');
			$rs_baru->save();

			$id = $rs_baru->id;
		}
		$rujuk->rumah_sakit_id = $id;

		if (Input::get('hamil_id') == '1'){
			$cek = RegisterHamil::where('g', Input::get('G'))->where('pasien_id', $periksa->pasien_id)->first();
			if (count($cek) > 0) {
				$regUpdate            = RegisterHamil::find($cek->id);
				$regUpdate->hpht      = Yoga::datePrep(Input::get('hpht'));
				$regUpdate->g         = Input::get('G');
				$regUpdate->p         = Input::get('P');
				$regUpdate->a         = Input::get('A');
				$regUpdate->pasien_id = $periksa->pasien_id;
				$regUpdate->save();

				$id = $cek->id;
			// return $id;
			}  else {
				$hamil            = new RegisterHamil;
				$hamil->hpht      = Yoga::datePrep(Input::get('hpht'));
				$hamil->g         = Input::get('G');
				$hamil->p         = Input::get('P');
				$hamil->a         = Input::get('A');
				$hamil->pasien_id = $periksa->pasien_id;
				$hamil->save();

				$id = $hamil->id;
			}
			$rujuk->register_hamil_id = $id;
		}

		$confirm = $rujuk->save();
		if ($confirm) {
			$this->updateInfoRS(Input::get('rumah_sakit_telepon'), Input::get('rumah_sakit_alamat'), Input::get('rumah_sakit_ugd'), $rujuk->rumah_sakit_id);
		}

		return redirect('ruangperiksa/' . $periksa->poli)->withPesan(Yoga::suksesFlash('rujukan untuk <strong>' .$periksa->id. ' - ' .$periksa->pasien->nama. '</strong> berhasil dibuat'));
	}

	/**
	 * Display the specified rujukan.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{

		$mulai = Input::get('mulai');
		$akhir = Input::get('akhir');

		$mulai = Yoga::nowIfEmptyMulai($mulai);
		$akhir = Yoga::nowIfEmptyAkhir($akhir);

		$rujukans = Rujukan::where('created_at', '>=', $mulai . ' 00:00:00')->where('created_at', '<=', $akhir . ' 23:59:59')->get();

		// return $rujukan;
		return view('rujukans.show', compact('rujukans','mulai', 'akhir'));
	}

	/**
	 * Show the form for editing the specified rujukan.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

		$rujukan = Rujukan::find($id);

		// return $rujukan->rumah_sakit->jenis_rumah_sakit;

		$specs = TujuanRujuk::all(['tujuan_rujuk']);

		// return $specs;
		// 
		$g = null;
		$p = null;
		$a = null;
		$hpht = null;

		if ($rujukan->register_hamil) {
			$g    = $rujukan->register_hamil->g;
			$p    = $rujukan->register_hamil->p;
			$a    = $rujukan->register_hamil->a;
			$hpht = $rujukan->register_hamil->hpht;
		}
  
  		$tujuan_rujuk = [];
  
  		foreach ($specs as $sp) {
  			$tujuan_rujuk[] = $sp->tujuan_rujuk;
  		}
  		$tujuan_rujuks = json_encode($tujuan_rujuk);

  		if ($rujukan->register_hamil_id != null) {
  			$hamil = '1';
  		} else {
  			$hamil = '0';
  		}


  		// return $hamil;

		return view('rujukans.edit', compact('rujukan', 'tujuan_rujuks', 'hamil', 'g', 'p', 'a', 'hpht'));
	}

	/**
	 * Update the specified rujukan in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

		$rujuk = Rujukan::find($id);
		$rules =[
			'tujuan_rujuk' => 'required',
			'rumah_sakit'  => 'required',
			'alasan_rujuk' => 'required',
			'periksa_id'   => 'required'
		];
		$validator = \Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$periksa                   = Periksa::find(Input::get('periksa_id'));
		// INPUT RUJUKAN 
		// cek apakah rujukannya rujukan baru atay lama
		$tujuan_rujuk              = str_replace(' ', '', Input::get('tujuan_rujuk'));
		$query                     = DB::select("SELECT * FROM tujuan_rujuks WHERE replace(tujuan_rujuk,' ','') = '" . $tujuan_rujuk . "'");
		//jika rujukan cocok dengan rujukan yang lama, maka masukkan rujukan yang cocok
		if(count($query) > 0){
			$id                        = $query[0]->id;
		//jika tidak ada rujukan yang cocok, buat rujukan baru
		} else {
			//INPUT TUJUAN RUJUK BARU
			$tujuan_baru               = new TujuanRujuk;
			$tujuan_baru->tujuan_rujuk = Input::get('tujuan_rujuk');
			$tujuan_baru->save();
			$id                        = $tujuan_baru->id;
		}
		$rujuk->tujuan_rujuk_id = $id;
		$rujuk->alasan_rujuk    = Input::get('alasan_rujuk');
		$rujuk->periksa_id      = $periksa->id;
		// cek apakah rumah sakit baru atau lama 
		$rumah_sakit = str_replace(' ', '', Input::get('rumah_sakit'));
		$query = DB::select("SELECT * FROM rumah_sakits WHERE replace(nama,' ','') = '" . $rumah_sakit . "'");
		if(count($query) > 0){
			$id = $query[0]->id;
		//jika tidak ada rujukan yang cocok, buat rujukan baru
		} else {
			//INPUT RUMAH SAKIT BARU
			$rs_baru                    = new RumahSakit;
			$rs_baru->nama              = Input::get('rumah_sakit');
			$rs_baru->jenis_rumah_sakit = Input::get('jenis_rumah_sakit_id');
			$rs_baru->save();

			$id = $rs_baru->id;
		}
		$rujuk->rumah_sakit_id = $id;

		if (Input::get('hamil_id') == '1'){
			$cek = RegisterHamil::where('g', Input::get('G'))->where('pasien_id', $periksa->pasien_id)->first();
			if (count($cek) > 0) {
				// return $cek;
				// tapi jika ketemu GPA yang sama dengan pasien_id yang sama, di update aja yang ketemu
				$regUpdate            = RegisterHamil::find($cek->id);
				$regUpdate->hpht      = Yoga::datePrep(Input::get('hpht'));
				$regUpdate->g         = Input::get('G');
				$regUpdate->p         = Input::get('P');
				$regUpdate->a         = Input::get('A');
				$regUpdate->pasien_id = $periksa->pasien_id;
				$regUpdate->save();

				$id = $cek->id;
			}  else {
				//kalo gak ketemu juga gpa dan pasien_id yang sama, buat saja yang baru
				$hamil            = new RegisterHamil;
				$hamil->hpht      = Yoga::datePrep(Input::get('hpht'));
				$hamil->g         = Input::get('G');
				$hamil->p         = Input::get('P');
				$hamil->a         = Input::get('A');
				$hamil->pasien_id = $periksa->pasien_id;
				$hamil->save();

				$id = $hamil->id;
			}
			$rujuk->register_hamil_id = $id;
		}

		$confirm = $rujuk->save();
		if ($confirm) {
			$this->updateInfoRS(Input::get('rumah_sakit_telepon'), Input::get('rumah_sakit_alamat'), Input::get('rumah_sakit_ugd'), $rujuk->rumah_sakit_id);
		}
		return redirect('ruangperiksa/' . $periksa->poli)->withPesan(Yoga::suksesFlash('Rujukan untuk <strong>' .$periksa->id. ' - ' .$periksa->pasien->nama. '</strong> berhasil diubah!'));
	}

	/**
	 * Remove the specified rujukan from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$rujukan = Rujukan::find($id);
		$periksa = $rujukan->periksa;
		$rujukan->delete();


		return redirect('ruangperiksa/'.$periksa->poli)->withPesan(Yoga::suksesFlash('Rujukan untuk pasien <strong>' . $periksa->id . ' - '. $periksa->pasien->nama. '</strong> berhasil dihapus'));
	}

	private function updateInfoRS($telepon, $alamat, $ugd, $rumah_sakit_id){

		if (
			isset($telepon) &&
			isset($alamat) &&
			isset($ugd)
			) {
				$rs          = RumahSakit::find($rumah_sakit_id);
				$rs->telepon = $telepon;
				$rs->alamat  = $alamat;
				$rs->ugd     = $ugd;
				$rs->save();
		}

	}
	public function ini($id)
	{
		$periksa = Periksa::findOrFail($id);

		// return isset($periksa->rujukan->image);
		return view('rujukans.ini', compact('periksa'));
	}


}
