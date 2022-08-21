<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;


use DB;
use Response;
use App\Models\Formula;
use App\Http\Controllers\RaksController;
use App\Models\KelasObat;
use App\Models\Merek;
use App\Models\Generik;
use App\Models\Classes\Yoga;
use App\Models\Rak;
use App\Models\Dose;
use App\Models\Komposisi;
use App\Models\Sediaan;



class FormulasController extends Controller
{

	/**
	 * Display a listing of formulas
	 *
	 * @return Response
	 */
	public function index()
	{
		$formulas = Formula::all();
		return view('formulas.index', compact('formulas'));
	}

	/**
	 * Show the form for creating a new formula
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Input::ajax()){
			$json = Input::get('json');
		//validasi merek jika ada merek yang sama gagalkan
			$merek_bool = false;
			$MyArray = json_decode($json, true);

			if(count($MyArray) == 1 ){
				$merek = ucwords(strtolower(Input::get('merek'))) . ' ' . Input::get('sediaan') . ' ' . $MyArray[0]['bobot'] ;
			} else {
				$merek = ucwords(strtolower(Input::get('merek'))) . ' ' . Input::get('sediaan');
			}

			if(Merek::where('merek', $merek)->get()){
				$merek_bool = true;
			}
		//validasi formula jika ada formula dengan komposisi yang sama gagalkan 
			$formula_bool = false;
			$formulas = Formula::all();
			foreach ($formulas as $formula) {
				if($formula->komposisi->count() == count($MyArray)){
					foreach ($formula->komposisi as $komposisi) {
						foreach ($MyArray as $array) {
							if($MyArray['generik_id'] . $MyArray['bobot'] == $komposisi->generik_id.$komposisi->bobot){
								$formula_bool = true;
							} else {
								$formula_bool = false;
							}
						}
						if($formula_bool){
							break;
						}
					}
				}
			}
			$data = [
				'merek' => $merek_bool,
				'formula' => $formula_bool
			];

			return json_encode($data);

		} else {

            $sediaan =  Sediaan::pluck('sediaan', 'id')->all();

            $alternatif_fornas = array('' => '- Pilih Merek -') + Merek::pluck('merek', 'id')->all();

            $dijual_bebas = array(
                            null        => '- Pilih -',
                            '0'         => 'Tidak Dijual Bebas',
                            '1'         => 'Dijual Bebas'
                        );

            $generik = array(null => '- Pilih Generik -') + Generik::pluck('generik', 'id')->all();

            $signas        = Yoga::signa_list();
            $aturan_minums = Yoga::aturan_minum_list();

            $template = [];

            $template['signa_kg6_7'] = null;
            $template['jumlah_kg6_7'] =  null;
            $template['jumlah_puyer_kg6_7'] = '3'; 
            $template['jumlah_kg6_7_bpjs'] = null;


            $template['signa_kg7_9'] = null;
            $template['jumlah_kg7_9'] =  null;
            $template['jumlah_puyer_kg7_9'] = '3'; 
            $template['jumlah_kg7_9_bpjs'] = null;

            $template['signa_kg9_13'] = null;
            $template['jumlah_kg9_13'] =  null;
            $template['jumlah_puyer_kg9_13'] = '4'; 
            $template['jumlah_kg9_13_bpjs'] = null;


            $template['signa_kg13_15'] = null;
            $template['jumlah_kg13_15'] =  null;
            $template['jumlah_puyer_kg13_15'] = '5'; 
            $template['jumlah_kg13_15_bpjs'] = null;


            $template['signa_kg15_19'] ='4';
            $template['jumlah_kg15_19'] = '6';
            $template['jumlah_puyer_kg15_19'] = '6';
            $template['jumlah_kg15_19_bpjs'] = '4';


            $template['signa_kg19_23'] ='4';
            $template['jumlah_kg19_23'] = '6';
            $template['jumlah_puyer_kg19_23'] = '7';
            $template['jumlah_kg19_23_bpjs'] = '4';


            $template['signa_kg23_26'] ='4';
            $template['jumlah_kg23_26'] = '6';
            $template['jumlah_puyer_kg23_26'] = '8';
            $template['jumlah_kg23_26_bpjs'] = '4';


            $template['signa_kg26_30'] ='12413';
            $template['jumlah_kg26_30'] = '6';
            $template['jumlah_puyer_kg26_30'] = '9';
            $template['jumlah_kg26_30_bpjs'] = '4';


            $template['signa_kg30_37'] ='12413';
            $template['jumlah_kg30_37'] = '6';
            $template['jumlah_puyer_kg30_37'] = '10';
            $template['jumlah_kg30_37_bpjs'] = '4';


            $template['signa_kg37_45'] ='1';
            $template['jumlah_kg37_45'] = '10';
            $template['jumlah_puyer_kg37_45'] = '11';
            $template['jumlah_kg37_45_bpjs'] = '6';


            $template['signa_kg45_50'] = '1';
            $template['jumlah_kg45_50'] = '10';
            $template['jumlah_puyer_kg45_50'] = '12';
            $template['jumlah_kg45_50_bpjs'] = '6';


            $template['signa_kg50'] = '1';
            $template['jumlah_kg50'] = '10';
            $template['jumlah_puyer_kg50'] = '12';
            $template['jumlah_kg50_bpjs'] = '6';
            $kelas_obat_list = KelasObat::pluck('kelas_obat', 'id')->all();

            return view('formulas.create', compact( 'sediaan', 'generik', 'kelas_obat_list', 'dijual_bebas', 'signas', 'aturan_minums', 'template', 'alternatif_fornas'));
        }
	}

        public function store() 
        {
		DB::beginTransaction();
		try {
			if(!Input::ajax()){
				$rules = [
					'merek'          => 'required',
					'dijual_bebas'   => 'required',
					'exp_date'       => 'date_format:d-m-Y',
					'kode_rak'         => 'required',
					'indikasi'       => 'required',
					'kontraindikasi' => 'required',
					'efek_samping'   => 'required',
					'harga_beli'     => 'numeric',
					'harga_jual'     => 'required|numeric',
					'fornas'         => 'required|numeric',
					'sediaan_id'        => 'required'
				];

				$validator = \Validator::make($data = Input::all(), $rules);

				if ($validator->fails())
				{
					return \Redirect::back()->withErrors($validator)->withInput();
				}
			}


				//isian formula
				$formula                  = new Formula;
				$formula->dijual_bebas    = Input::get('dijual_bebas');
				$formula->efek_samping    = Input::get('efek_samping');
				$formula->aturan_minum_id = Input::get('aturan_minum_id');
				$formula->sediaan_id      = Input::get('sediaan_id');
				$formula->indikasi        = Input::get('indikasi');
				$formula->kontraindikasi  = Input::get('kontraindikasi');
				$formula->peringatan      = Input::get('peringatan');
				$formula->boleh_dipuyer   = Input::get('boleh_dipuyer');
				$formula->save();

				//isian rak 
				$rak                    = new Rak;
				$rak->kode_rak          = Input::get('kode_rak');
				$rak->alternatif_fornas = Input::get('alternatif_fornas');
				$rak->kelas_obat_id     = Input::get('kelas_obat_id');
				$rak->fornas            = Input::get('fornas');
				$rak->stok              = Input::get('stok');
				$rak->stok_minimal      = Input::get('stok_minimal');
				$rak->harga_beli        = Input::get('harga_beli');
				$rak->harga_jual        = Input::get('harga_jual');
				$rak->exp_date          = Yoga::datePrep( Input::get('exp_date') );
				$rak->formula_id        = $formula->id;
				$rak->save();


				$doses = [];

				$doses[] = [
					'berat_badan_id'   => '1',
					'signa_id'         => Yoga::returnNull(Input::get('signa_kg6_7')),
					'jumlah'           => Yoga::returnNull(Input::get('jumlah_kg6_7')),
					'jumlah_puyer_add' => Yoga::returnNull(Input::get('jumlah_puyer_kg6_7')),
					'jumlah_bpjs'      => Yoga::returnNull(Input::get('jumlah_kg6_7_bpjs')),
				];
				//isian dosis
				$doses[] = [
					'berat_badan_id'   => '1',
					'signa_id'         => Yoga::returnNull(Input::get('signa_kg6_7')),
					'jumlah'           => Yoga::returnNull(Input::get('jumlah_kg6_7')),
					'jumlah_puyer_add' => Yoga::returnNull(Input::get('jumlah_puyer_kg6_7')),
					'jumlah_bpjs'      => Yoga::returnNull(Input::get('jumlah_kg6_7_bpjs')),
				];

				$doses[] = [
					'berat_badan_id'   => '2',
					'signa_id'         => Yoga::returnNull(Input::get('signa_kg7_9')),
					'jumlah'           => Yoga::returnNull(Input::get('jumlah_kg7_9')),
					'jumlah_puyer_add' => Yoga::returnNull(Input::get('jumlah_puyer_kg7_9')),
					'jumlah_bpjs'      => Yoga::returnNull(Input::get('jumlah_kg7_9_bpjs')),
				];

				$doses[] = [
					'berat_badan_id'   => '3',
					'signa_id'         => Yoga::returnNull(Input::get('signa_kg9_13')),
					'jumlah'           => Yoga::returnNull(Input::get('jumlah_kg9_13')),
					'jumlah_puyer_add' => Yoga::returnNull(Input::get('jumlah_puyer_kg9_13')),
					'jumlah_bpjs'      => Yoga::returnNull(Input::get('jumlah_kg9_13_bpjs')),
				];

				$doses[] = [
					'berat_badan_id'   => '4',
					'signa_id'         => Yoga::returnNull(Input::get('signa_kg13_15')),
					'jumlah'           => Yoga::returnNull(Input::get('jumlah_kg13_15')),
					'jumlah_puyer_add' => Yoga::returnNull(Input::get('jumlah_puyer_kg13_15')),
					'jumlah_bpjs'      => Yoga::returnNull(Input::get('jumlah_kg13_15_bpjs')),
				];

				$doses[] = [
					'berat_badan_id'   => '5',
					'signa_id'         => Yoga::returnNull(Input::get('signa_kg15_19')),
					'jumlah'           => Yoga::returnNull(Input::get('jumlah_kg15_19')),
					'jumlah_puyer_add' => Yoga::returnNull(Input::get('jumlah_puyer_kg15_19')),
					'jumlah_bpjs'      => Yoga::returnNull(Input::get('jumlah_kg15_19_bpjs')),
				];

				$doses[] = [
					'berat_badan_id'   => '6',
					'signa_id'         => Yoga::returnNull(Input::get('signa_kg19_23')),
					'jumlah'           => Yoga::returnNull(Input::get('jumlah_kg19_23')),
					'jumlah_puyer_add' => Yoga::returnNull(Input::get('jumlah_puyer_kg19_23')),
					'jumlah_bpjs'      => Yoga::returnNull(Input::get('jumlah_kg19_23_bpjs')),
				];

				$doses[] = [
					'berat_badan_id'   => '7',
					'signa_id'         => Yoga::returnNull(Input::get('signa_kg23_26')),
					'jumlah'           => Yoga::returnNull(Input::get('jumlah_kg23_26')),
					'jumlah_puyer_add' => Yoga::returnNull(Input::get('jumlah_puyer_kg23_26')),
					'jumlah_bpjs'      => Yoga::returnNull(Input::get('jumlah_kg23_26_bpjs')),
				];

				$doses[] = [
					'berat_badan_id'   => '8',
					'signa_id'         => Yoga::returnNull(Input::get('signa_kg26_30')),
					'jumlah'           => Yoga::returnNull(Input::get('jumlah_kg26_30')),
					'jumlah_puyer_add' => Yoga::returnNull(Input::get('jumlah_puyer_kg26_30')),
					'jumlah_bpjs'      => Yoga::returnNull(Input::get('jumlah_kg26_30_bpjs')),
				];

				$doses[] = [
					'berat_badan_id'   => '9',
					'signa_id'         => Yoga::returnNull(Input::get('signa_kg30_37')),
					'jumlah'           => Yoga::returnNull(Input::get('jumlah_kg30_37')),
					'jumlah_puyer_add' => Yoga::returnNull(Input::get('jumlah_puyer_kg30_37')),
					'jumlah_bpjs'      => Yoga::returnNull(Input::get('jumlah_kg30_37_bpjs')),
				];

				$doses[] = [
					'berat_badan_id'   => '10',
					'signa_id'         => Yoga::returnNull(Input::get('signa_kg37_45')),
					'jumlah'           => Yoga::returnNull(Input::get('jumlah_kg37_45')),
					'jumlah_puyer_add' => Yoga::returnNull(Input::get('jumlah_puyer_kg37_45')),
					'jumlah_bpjs'      => Yoga::returnNull(Input::get('jumlah_kg37_45_bpjs')),
				];

				$doses[] = [
					'berat_badan_id'   => '11',
					'signa_id'         => Yoga::returnNull(Input::get('signa_kg45_50')),
					'jumlah'           => Yoga::returnNull(Input::get('jumlah_kg45_50')),
					'jumlah_puyer_add' => Yoga::returnNull(Input::get('jumlah_puyer_kg45_50')),
					'jumlah_bpjs'      => Yoga::returnNull(Input::get('jumlah_kg45_50_bpjs')),
				];

				$doses[] = [
					'berat_badan_id'   => '12',
					'signa_id'         => Yoga::returnNull(Input::get('signa_kg50')),
					'jumlah'           => Yoga::returnNull(Input::get('jumlah_kg50')),
					'jumlah_puyer_add' => Yoga::returnNull(Input::get('jumlah_puyer_kg50')),
					'jumlah_bpjs'      => Yoga::returnNull(Input::get('jumlah_kg50_bpjs')),
				];

				$formula->dose()->createMany($doses);

				$MyArray = json_decode(Input::get('json'), true);

				$komposisis = [];
                $timestamp = date('Y-m-d H:i:s');
				if (isset($MyArray)) {
					for($i = 0; $i < count($MyArray); $i++) {
						$komposisis[] = [
							'formula_id' => $formula->id,
							'bobot'      => $MyArray[$i]['bobot'],
							'generik_id' => $MyArray[$i]['generik_id'],
                            'tenant_id' => session()->get('tenant_id'),
                            'created_at' => $timestamp,
                            'updated_at' => $timestamp
						];
					}
				}

				Komposisi::insert($komposisis);

				$merek         = new Merek;
                $rc = new RaksController;
				$merek->rak_id = $rak->id;
				$merek->merek = $rc->customMerek($formula, Input::get('merek'));
				$merek->save();
				DB::commit();
			} catch (\Exception $e) {
				DB::rollback();
				throw $e;
			}
		if (Input::ajax()) {
			$returnData = [
				'merek_id' => $merek_id_custom,
				'merek'	=> $merekCustom,
				'custom_value' => Merek::find($merek_id_custom)->custid
			];
			return json_encode($returnData);
		} else {
			return \Redirect::route('mereks.index')->withPesan(Yoga::suksesFlash('Formula obat <strong>' . $formula->id . '</strong> telah <strong>BERHASIL</strong> dibuat'));
		}
	}

	/**
	 * Display the specified formula.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$formula = Formula::findOrFail($id);
		$raks = Rak::where('formula_id', '=', $id)->get();
		/* dd( $formula->dose ); */

		// return $formula->dose;
		$query = "SELECT mr.merek as merek, ";
		$query .= "sp.nama as nama, ";
		$query .= "rk.id as rak_id, ";
		$query .= "sp.alamat as alamat, ";
		$query .= "sp.no_telp as telepon, ";
		$query .= "sp.hp_pic as hp, ";
		$query .= "mr.id as merek_id, ";
		$query .= "sp.pic as pic, ";
		$query .= "fb.supplier_id as supplier_id, ";
		$query .= "pb.harga_beli, ";
		$query .= "pb.faktur_belanja_id as faktur_belanja_id, ";
		$query .= "max(fb.tanggal) as tanggal ";
		$query .= "from pembelians as pb ";
		$query .= "join faktur_belanjas as fb on fb.id = pb.faktur_belanja_id ";
		$query .= "join suppliers as sp on sp.id = fb.supplier_id ";
		$query .= "join mereks as mr on mr.id = pb.merek_id ";
		$query .= "join raks as rk on rk.id = mr.rak_id ";
		$query .= "join formulas as fr on fr.id = rk.formula_id ";
		$query .= "where fr.id='{$id}' ";
		$query .= "AND fr.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by supplier_id ";
		$query .= "order by fb.tanggal desc ";
		$supplierprices = DB::select($query);

		return view('formulas.show', compact('formula', 'raks', 'supplierprices'));
	}

	/**
	 * Show the form for editing the specified formula.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$formula = Formula::find($id);

		
		// return Dose::where('formula_id', $id)->where('berat_badan_id', '1')->first();

		// return 
		$json = Response::json($formula->existing_komposisi($id))->getContent();
		// $json = $formula->existing_komposisi($id);

		// return $formula;

		$sediaan = Sediaan::pluck('id', 'sediaan');

		$dijual_bebas = array(
                        null        => '- Pilih -',
                        '0'         => 'Tidak Dijual Bebas',
                        '1'         => 'Dijual Bebas'
                    );

		$generik = array( null => '- Pilih Generik -') + Generik::pluck('generik', 'id')->all();


		$signas = Yoga::signa_list();
		$aturan_minums = Yoga::aturan_minum_list();

		$doses = Dose::where('formula_id', $id)->get();

		$formula->json = json_encode($formula->existing_komposisi($id));

		$formula->signa_kg6_7          = $doses[0]->signa_id;
		$formula->jumlah_kg6_7         = $doses[0]->jumlah;
		$formula->jumlah_puyer_kg6_7   = $doses[0]->jumlah_puyer_add;
		$formula->jumlah_kg6_7_bpjs    = $doses[0]->jumlah_bpjs;


		$formula->signa_kg7_9          = $doses[1]->signa_id;
		$formula->jumlah_kg7_9         = $doses[1]->jumlah;
		$formula->jumlah_puyer_kg7_9   = $doses[1]->jumlah_puyer_add;
		$formula->jumlah_kg7_9_bpjs    = $doses[1]->jumlah_bpjs;

		$formula->signa_kg9_13         = $doses[2]->signa_id;
		$formula->jumlah_kg9_13        = $doses[2]->jumlah;
		$formula->jumlah_puyer_kg9_13  = $doses[2]->jumlah_puyer_add;
		$formula->jumlah_kg9_13_bpjs   = $doses[2]->jumlah_bpjs;


		$formula->signa_kg13_15        = $doses[3]->signa_id;
		$formula->jumlah_kg13_15       = $doses[3]->jumlah;
		$formula->jumlah_puyer_kg13_15 = $doses[3]->jumlah_puyer_add;
		$formula->jumlah_kg13_15_bpjs  = $doses[3]->jumlah_bpjs;


		$formula->signa_kg15_19        = $doses[4]->signa_id;
		$formula->jumlah_kg15_19       = $doses[4]->jumlah;
		$formula->jumlah_puyer_kg15_19 = $doses[4]->jumlah_puyer_add;
		$formula->jumlah_kg15_19_bpjs  = $doses[4]->jumlah_bpjs;


		$formula->signa_kg19_23        = $doses[5]->signa_id;
		$formula->jumlah_kg19_23       = $doses[5]->jumlah;
		$formula->jumlah_puyer_kg19_23 = $doses[5]->jumlah_puyer_add;
		$formula->jumlah_kg19_23_bpjs  = $doses[5]->jumlah_bpjs;


		$formula->signa_kg23_26        = $doses[6]->signa_id;
		$formula->jumlah_kg23_26       = $doses[6]->jumlah;
		$formula->jumlah_puyer_kg23_26 = $doses[6]->jumlah_puyer_add;
		$formula->jumlah_kg23_26_bpjs  = $doses[6]->jumlah_bpjs;


		$formula->signa_kg26_30        = $doses[7]->signa_id;
		$formula->jumlah_kg26_30       = $doses[7]->jumlah;
		$formula->jumlah_puyer_kg26_30 = $doses[7]->jumlah_puyer_add;
		$formula->jumlah_kg26_30_bpjs  = $doses[7]->jumlah_bpjs;


		$formula->signa_kg30_37        = $doses[8]->signa_id;
		$formula->jumlah_kg30_37       = $doses[8]->jumlah;
		$formula->jumlah_puyer_kg30_37 = $doses[8]->jumlah_puyer_add;
		$formula->jumlah_kg30_37_bpjs  = $doses[8]->jumlah_bpjs;


		$formula->signa_kg37_45        = $doses[9]->signa_id;
		$formula->jumlah_kg37_45       = $doses[9]->jumlah;
		$formula->jumlah_puyer_kg37_45 = $doses[9]->jumlah_puyer_add;
		$formula->jumlah_kg37_45_bpjs  = $doses[9]->jumlah_bpjs;


		$formula->signa_kg45_50        = $doses[10]->signa_id;
		$formula->jumlah_kg45_50       = $doses[10]->jumlah;
		$formula->jumlah_puyer_kg45_50 = $doses[10]->jumlah_puyer_add;
		$formula->jumlah_kg45_50_bpjs  = $doses[10]->jumlah_bpjs;


		$formula->signa_kg50           = $doses[11]->signa_id;
		$formula->jumlah_kg50          = $doses[11]->jumlah;
		$formula->jumlah_puyer_kg50    = $doses[11]->jumlah_puyer_add;
		$formula->jumlah_kg50_bpjs     = $doses[11]->jumlah_bpjs;

		return view('formulas.edit', compact('formula', 'doses', 'sediaan', 'generik', 'json', 'dijual_bebas', 'signas', 'aturan_minums'));
	}

	/**
	 * Update the specified formula in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{



		$rules = [];

		$validator = \Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		//isian formula
		$formula = Formula::find($id);
		$formula->dijual_bebas = Input::get('dijual_bebas'); 
		$formula->efek_samping = Input::get('efek_samping'); 
		$formula->aturan_minum_id = Input::get('aturan_minum_id'); 
		$formula->sediaan_id = Input::get('sediaan_id'); 
		$formula->indikasi = Input::get('indikasi'); 
		$formula->kontraindikasi = Input::get('kontraindikasi'); 
		$formula->save();

		//isian dosis

		$dose = Dose::where('formula_id', $id)->where('berat_badan_id', '1')->first();
		$dose->signa_id = Yoga::returnNull(Input::get('signa_kg6_7'));
		$dose->jumlah = Yoga::returnNull(Input::get('jumlah_kg6_7'));
		$dose->jumlah_puyer_add = Yoga::returnNull(Input::get('jumlah_puyer_kg6_7'));
		$dose->jumlah_bpjs = Yoga::returnNull(Input::get('jumlah_kg6_7_bpjs'));
		$dose->save();

		$dose = Dose::where('formula_id', $id)->where('berat_badan_id', '2')->first();
		$dose->signa_id = Yoga::returnNull(Input::get('signa_kg7_9'));
		$dose->jumlah = Yoga::returnNull(Input::get('jumlah_kg7_9'));
		$dose->jumlah_puyer_add = Yoga::returnNull(Input::get('jumlah_puyer_kg7_9'));
		$dose->jumlah_bpjs = Yoga::returnNull(Input::get('jumlah_kg7_9_bpjs'));
		$dose->save();

		$dose = Dose::where('formula_id', $id)->where('berat_badan_id', '3')->first();
		$dose->signa_id = Yoga::returnNull(Input::get('signa_kg9_13'));
		$dose->jumlah = Yoga::returnNull(Input::get('jumlah_kg9_13'));
		$dose->jumlah_puyer_add = Yoga::returnNull(Input::get('jumlah_puyer_kg9_13'));
		$dose->jumlah_bpjs = Yoga::returnNull(Input::get('jumlah_kg9_13_bpjs'));
		$dose->save();

		$dose = Dose::where('formula_id', $id)->where('berat_badan_id', '4')->first();
		$dose->signa_id = Yoga::returnNull(Input::get('signa_kg13_15'));
		$dose->jumlah = Yoga::returnNull(Input::get('jumlah_kg13_15'));
		$dose->jumlah_puyer_add = Yoga::returnNull(Input::get('jumlah_puyer_kg13_15'));
		$dose->jumlah_bpjs = Yoga::returnNull(Input::get('jumlah_kg13_15_bpjs'));
		$dose->save();

		$dose = Dose::where('formula_id', $id)->where('berat_badan_id', '5')->first();
		$dose->signa_id = Yoga::returnNull(Input::get('signa_kg15_19'));
		$dose->jumlah = Yoga::returnNull(Input::get('jumlah_kg15_19'));
		$dose->jumlah_puyer_add = Yoga::returnNull(Input::get('jumlah_puyer_kg15_19'));
		$dose->jumlah_bpjs = Yoga::returnNull(Input::get('jumlah_kg15_19_bpjs'));
		$dose->save();

		$dose = Dose::where('formula_id', $id)->where('berat_badan_id', '6')->first();
		$dose->signa_id = Yoga::returnNull(Input::get('signa_kg19_23'));
		$dose->jumlah = Yoga::returnNull(Input::get('jumlah_kg19_23'));
		$dose->jumlah_puyer_add = Yoga::returnNull(Input::get('jumlah_puyer_kg19_23'));
		$dose->jumlah_bpjs = Yoga::returnNull(Input::get('jumlah_kg19_23_bpjs'));
		$dose->save();

		$dose = Dose::where('formula_id', $id)->where('berat_badan_id', '7')->first();
		$dose->signa_id = Yoga::returnNull(Input::get('signa_kg23_26'));
		$dose->jumlah = Yoga::returnNull(Input::get('jumlah_kg23_26'));
		$dose->jumlah_puyer_add = Yoga::returnNull(Input::get('jumlah_puyer_kg23_26'));
		$dose->jumlah_bpjs = Yoga::returnNull(Input::get('jumlah_kg23_26_bpjs'));
		$dose->save();

		$dose = Dose::where('formula_id', $id)->where('berat_badan_id', '8')->first();
		$dose->signa_id = Yoga::returnNull(Input::get('signa_kg26_30'));
		$dose->jumlah = Yoga::returnNull(Input::get('jumlah_kg26_30'));
		$dose->jumlah_puyer_add = Yoga::returnNull(Input::get('jumlah_puyer_kg26_30'));
		$dose->jumlah_bpjs = Yoga::returnNull(Input::get('jumlah_kg26_30_bpjs'));
		$dose->save();

		$dose = Dose::where('formula_id', $id)->where('berat_badan_id', '9')->first();
		$dose->signa_id = Yoga::returnNull(Input::get('signa_kg30_37'));
		$dose->jumlah = Yoga::returnNull(Input::get('jumlah_kg30_37'));
		$dose->jumlah_puyer_add = Yoga::returnNull(Input::get('jumlah_puyer_kg30_37'));
		$dose->jumlah_bpjs = Yoga::returnNull(Input::get('jumlah_kg30_37_bpjs'));
		$dose->save();

		$dose = Dose::where('formula_id', $id)->where('berat_badan_id', '10')->first();
		$dose->signa_id = Yoga::returnNull(Input::get('signa_kg37_45'));
		$dose->jumlah = Yoga::returnNull(Input::get('jumlah_kg37_45'));
		$dose->jumlah_puyer_add = Yoga::returnNull(Input::get('jumlah_puyer_kg37_45'));
		$dose->jumlah_bpjs = Yoga::returnNull(Input::get('jumlah_kg37_45_bpjs'));
		$dose->save();

		$dose = Dose::where('formula_id', $id)->where('berat_badan_id', '11')->first();
		$dose->signa_id = Yoga::returnNull(Input::get('signa_kg45_50'));
		$dose->jumlah = Yoga::returnNull(Input::get('jumlah_kg45_50'));
		$dose->jumlah_puyer_add = Yoga::returnNull(Input::get('jumlah_puyer_kg45_50'));
		$dose->jumlah_bpjs = Yoga::returnNull(Input::get('jumlah_kg45_50_bpjs'));
		$dose->save();

		$dose = Dose::where('formula_id', $id)->where('berat_badan_id', '12')->first();
		$dose->signa_id = Yoga::returnNull(Input::get('signa_kg50'));
		$dose->jumlah = Yoga::returnNull(Input::get('jumlah_kg50'));
		$dose->jumlah_puyer_add = Yoga::returnNull(Input::get('jumlah_puyer_kg50'));
		$dose->jumlah_bpjs = Yoga::returnNull(Input::get('jumlah_kg50_bpjs'));
		$dose->save();

		//isian komposisi

		$bobot = null;

		if($formula->komposisi->count() > 0){
			$bobot = $formula->komposisi->first()->bobot;
		}

		// return $bobot;

		$deleteKomp = Komposisi::where('formula_id', $id)->get();

		foreach($deleteKomp as $komp){
			$komp->delete();
		}



		$komposisis = Input::get('json');

		$MyArray = json_decode($komposisis, true);

		for($i = 0; $i < count($MyArray); $i++) {
			$komposisi = New Komposisi;
			$komposisi->formula_id = $formula->id;
			$komposisi->bobot = $MyArray[$i]['bobot'];
			$komposisi->generik_id = $MyArray[$i]['generik_id'];
			$komposisi->save();
		}


		foreach ($formula->rak as $rak) {
			foreach ($rak->merek as $mrk) {
				$merek = Merek::find($mrk->id);
				$merek_asli = Yoga::merekAsli($mrk->merek, $formula, $bobot);

				if( count($MyArray) == 1 ){
					$merek->merek = $merek_asli . ' ' . Input::get('sediaan') . ' ' . $MyArray[0]['bobot'] ;
				} else {
					$merek->merek = $merek_asli . ' ' . Input::get('sediaan');
				}



				$merek->save();
			}
		}
		return \Redirect::route('mereks.index')->withPesan(Yoga::suksesFlash('Formula obat <strong>' . $id . '</strong> telah <strong>BERHASIL</strong> diubah'));
	}

	/**
	 * Remove the specified formula from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Formula::destroy($id);
		return \Redirect::route('mereks.index');
	}

}
