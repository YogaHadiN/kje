<?php

namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use App\Http\Controllers\SuratSakitsController;
use DB;
use App\Models\Rujukan;
use App\Models\RegisterHamil;
use App\Models\Classes\Yoga;
use App\Models\TujuanRujuk;
use App\Models\RumahSakit;
use App\Models\Periksa;
use App\Models\Diagnosa;


/**
* @param 
*/


class RujukansController extends Controller
{

    public $periksa;
	public function __construct()
	{
		$this->middleware('inhealthTidakBisaDirujukKalauAdaObat', ['only' => ['create', 'store', 'edit', 'update']]);
	}
	/**
	 * Display a listing of rujukans
	 *
	 * @return Response
	 */
	public function index()
	{
		$rujukans = Rujukan::orderBy('id', 'desc')->paginate(10);
		$count    = Rujukan::count();
		return view('rujukans.index', compact('rujukans', 'count'));
	}

	/**
	 * Show the form for creating a new rujukan
	 *
	 * @return Response
	 */
	public function create($id, $poli)
	{

		$periksa = Periksa::find($id);

		$isHamil = '0';
		$g       = null;
		$p       = null;
		$a       = null;
		$hpht    = null;

		if ($periksa->registerAnc) {
			$isHamil = '1';
			$g = $periksa->registerAnc->registerHamil->g;
			$p = $periksa->registerAnc->registerHamil->p;
			$a = $periksa->registerAnc->registerHamil->a;
			$hpht = $periksa->registerAnc->registerHamil->hpht;
		}

		$specs = TujuanRujuk::all(['tujuan_rujuk']);
  		
		$diagnosa     = \Cache::remember('diagnosa', 60, function(){
            return Diagnosa::with('icd10')->get()->pluck('diagnosa_icd', 'id')->all();
		});
		$ss            = new SuratSakitsController;
		$poli          = $ss->poli($poli);
        $tujuan_rujuk_list = TujuanRujuk::pluck('tujuan_rujuk', 'id');
		return view('rujukans.create', compact(
			'periksa', 
			'tujuan_rujuk_list', 
			'isHamil', 
			'g', 
			'p', 
			'a', 
			'hpht', 
			'poli', 
			'diagnosa'
		));
	}

	/**
	 * Store a newly created rujukan in storage.
	 *
	 * @return Response
	 */
	public function store($poli)
	{
		$rujuk = new Rujukan;
		$rules =[
			'tujuan_rujuk_id' => 'required',
			'rumah_sakit'  => 'required',
			'periksa_id'   => 'required',
			'diagnosa_id'   => 'required'
		];

		if (
				empty( Input::get('time') ) &&
				empty( Input::get('age') ) &&
				empty( Input::get('comorbidity') ) &&
				empty( Input::get('complication') )
			) {
			
				$rules['alasan_rujuk'] = 'required';
		}
		$validator = \Validator::make($data = Input::all(), $rules);


		if ($validator->fails() )
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

        $confirm = $this->inputData($rujuk);
		if ($confirm) {
			$this->updateInfoRS(Input::get('rumah_sakit_telepon'), Input::get('rumah_sakit_alamat'), Input::get('rumah_sakit_ugd'), $rujuk->rumah_sakit_id);
		}

		$jenis_antrian_id = 6;
		if (!is_null($this->periksa->antrian)) {
			$jenis_antrian_id = $this->periksa->antrian->jenis_antrian_id;
		}

		$ss = new SuratSakitsController;
		return redirect('ruangperiksa/' . $ss->jenis_antrian_id($poli))->withPesan(Yoga::suksesFlash('rujukan untuk <strong>' .$this->periksa->id. ' - ' .$this->periksa->pasien->nama. '</strong> berhasil dibuat'));
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
	public function edit($id, $poli)
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

		if ($rujukan->registerHamil) {
			$g    = $rujukan->registerHamil->g;
			$p    = $rujukan->registerHamil->p;
			$a    = $rujukan->registerHamil->a;
			$hpht = $rujukan->registerHamil->hpht;
		}
  
        $tujuan_rujuk_list = TujuanRujuk::pluck('tujuan_rujuk', 'id');

  		if ($rujukan->register_hamil_id != null) {
  			$hamil = '1';
  		} else {
  			$hamil = '0';
  		}

		$diagnosa     = \Cache::remember('diagnosa', 60, function(){
            return Diagnosa::with('icd10')->get()->pluck('diagnosa_icd', 'id')->all();
		});
		$ss = new SuratSakitsController;
		$poli = $ss->poli($poli);

		return view('rujukans.edit', compact(
			'rujukan', 
			'tujuan_rujuk_list', 
			'hamil', 
			'poli', 
			'g', 
			'p', 
			'a', 
			'hpht', 
			'diagnosa'
		));
	}

	/**
	 * Update the specified rujukan in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, $poli)
	{

		$rujuk = Rujukan::find($id);
		$rules =[
			'tujuan_rujuk_id' => 'required',
			'rumah_sakit'  => 'required',
			'periksa_id'   => 'required'
		];

		if (
				empty( Input::get('time') ) &&
				empty( Input::get('age') ) &&
				empty( Input::get('comorbidity') ) &&
				empty( Input::get('complication') )
			) {
			
				$rules['alasan_rujuk'] = 'required';
		}
		$validator = \Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

        $confirm = $this->inputData($rujuk);
		if ($confirm) {
			$this->updateInfoRS(Input::get('rumah_sakit_telepon'), Input::get('rumah_sakit_alamat'), Input::get('rumah_sakit_ugd'), $rujuk->rumah_sakit_id);
		}
		$jenis_antrian_id = '6';
		if (!is_null($this->periksa->antrian)) {
			$jenis_antrian_id = $this->periksa->antrian->jenis_antrian_id;
		}
		$ss            = new SuratSakitsController;
		return redirect('ruangperiksa/' . $ss->jenis_antrian_id($poli))->withPesan(Yoga::suksesFlash('Rujukan untuk <strong>' .$this->periksa->id. ' - ' .$this->periksa->pasien->nama. '</strong> berhasil diubah!'));
	}

	/**
	 * Remove the specified rujukan from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, $poli)
	{
		$rujukan = Rujukan::find($id);
		$periksa = $rujukan->periksa;
		$rujukan->delete();


		$jenis_antrian_id = '6';
		if (!is_null($periksa->antrian)) {
			$jenis_antrian_id = $periksa->antrian->jenis_antrian_id;
		}
		$ss = new SuratSakitsController;
		return redirect('ruangperiksa/'.$ss->jenis_antrian_id($poli))->withPesan(Yoga::suksesFlash('Rujukan untuk pasien <strong>' . $periksa->id . ' - '. $periksa->pasien->nama. '</strong> berhasil dihapus'));
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

    /**
     * undocumented function
     *
     * @return void
     */
    private function inputData($rujuk)
    {
		$periksa                   = Periksa::with('antrian', 'pasien')->where('id', Input::get('periksa_id'))->first();
        $this->periksa = $periksa;
		$rujuk->tujuan_rujuk_id = Input::get('tujuan_rujuk_id');
		$rujuk->complication    = Input::get('complication');
		if ( !empty( Input::get('time') ) ) {
			$rujuk->time = Input::get('time');
		}

		if ( !empty( Input::get('age') ) ) {
			$rujuk->age = Input::get('age');
		}

		if ( !empty( Input::get('comorbidity') ) ) {
			$rujuk->comorbidity = Input::get('comorbidity');
		}
		$rujuk->complication    = Input::get('complication');
		$rujuk->periksa_id      = $periksa->id;

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
			try {
				$cek = RegisterHamil::where('g', Input::get('G'))->where('pasien_id', $periksa->pasien_id)->firstOrFail();
				$regUpdate            = RegisterHamil::find($cek->id);
				$regUpdate->hpht      = Yoga::datePrep(Input::get('hpht'));
				$regUpdate->g         = Input::get('G');
				$regUpdate->p         = Input::get('P');
				$regUpdate->a         = Input::get('A');
				$regUpdate->pasien_id = $periksa->pasien_id;
				$regUpdate->save();

				$id = $cek->id;
				
			} catch (\Exception $e) {
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

		$rujuk->diagnosa_id = Input::get('diagnosa_id');
		return $rujuk->save();
    }
    


}
