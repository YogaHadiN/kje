<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use App\Http\Controllers\PasiensAjaxController;
use App\Models\Pembelian;
use App\Models\BelanjaPeralatan;
use App\Models\FakturBelanja;
use App\Models\Merek;
use App\Models\Supplier;
use App\Models\Rak;
use App\Models\Formula;
use App\Models\JurnalUmum;
use App\Models\Classes\Yoga;
use App\Models\Generik;
use Image;
use DB;
use Storage;
use App\Models\Dispensing;

class PembeliansController extends Controller
{

	/**
	 * Display a listing of pembelians
	 *
	 * @return Response
	 */
	
	public function index(){

		$pembelians = Pembelian::with('fakturbelanja')->latest()->paginate(10);

		return view('pembelians.index', compact('pembelians'));

	}


	public function create($id)
	{
		$fakturbelanja = FakturBelanja::find($id);
		if ($fakturbelanja->pembelian->count() > 0) {
			return redirect('pembelians/' . $id . '/edit');
		}

		$mereks = Merek::with('rak.formula.komposisi.generik')->get();

		$rak = Rak::first();

		$formula = Formula::first();
		$fornas = Yoga::fornas();
		$sediaan = [
			null 				=> '- pilih -',
			'tablet'  			=> 'tablet',
			'syrup'  			=> 'syrup',
			'drop'  			=> 'drop',
			'capsul' 			=> 'capsul',
			'ampul'  			=> 'ampul',
			'vial'  			=> 'vial',
			'tetes mata'  		=> 'tetes mata',
			'tetes telinga' 	=> 'tetes telinga',
			'salep'  			=> 'salep',
			'gel'  				=> 'gel',
			'tube'  			=> 'tube'
		];

		$alternatif_fornas = array('' => '- Pilih Merek -') + Merek::pluck('merek', 'id')->all();

		$dijual_bebas = array(
                        null        => '- Pilih -',
                        '0'         => 'Tidak Dijual Bebas',
                        '1'         => 'Dijual Bebas'
                    );

		$generik = array('0' => '- Pilih Generik -') + Generik::pluck('generik', 'id')->all();

		$signas = Yoga::signa_list();
		$aturan_minums = Yoga::aturan_minum_list();
		return view('pembelians.create', compact(
			'mereks'
			, 'id' 
			, 'fakturbelanja'
			, 'sediaan'
			, 'generik'
			, 'exist'
			, 'dijual_bebas'
			, 'signas'
			, 'rak'
			, 'formula'
			, 'fornas'
			, 'aturan_minums'
			, 'alternatif_fornas'));
	}	

	public function store()
	{
		$messages          = array(
			'required'    => ':attribute harus diisi terlebih dahulu',
		);
		$rules = [
			'tanggal'      => 'required|date|date_format:d-m-Y',
			'nomor_faktur' => 'required',
			'belanja_id'   => 'required',
			'supplier_id'  => 'required',
			'diskon'       => 'required',
			'faktur_image' => 'required',
			'sumber_uang'  => 'required',
			'tempBeli'     => 'json|required'
		];

		$validator = \Validator::make($data = Input::all(), $rules, $messages);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$data = Input::get('tempBeli');
		$data = json_decode( $data, true );

		$input = [
			'data'          => $data,
		];

		$rules = [
			'data.*.merek_id'      => 'required',
			'data.*.jumlah'        => 'required|numeric',
			'data.*.harga_beli'    => 'required|numeric',
			'data.*.harga_jual'    => 'required|numeric',
			'data.*.exp_date'      => 'required|date_format:d-m-Y',
			'data.*.harga_berubah' => 'required',
		];
		
		$validator = \Validator::make($input, $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		try {
			$faktur_belanja_id = (int)FakturBelanja::orderBy('id', 'desc')->firstOrFail()->id + 1;
		} catch (\Exception $e) {
			$faktur_belanja_id = 1;
		}

		$timestamp          = date('Y-m-d H:i:s');
		$pembelians          = [];
		$dispensings        = [];
		$faktur_belanjas    = [];
		$jurnals            = [];
		$rak_updates        = [];
		$last_dispensing_id = (int)Yoga::customId('App\Models\Dispensing') - 1;

		$faktur_belanjas[]    = [
			'id'             => $faktur_belanja_id,
			'tanggal'        => Yoga::datePrep(Input::get('tanggal')),
			'nomor_faktur'   => Input::get('nomor_faktur'),
			'belanja_id'     => Input::get('belanja_id'),
			'supplier_id'    => Input::get('supplier_id'),
			'sumber_uang_id' => Input::get('sumber_uang'),
			'petugas_id'     => Input::get('staf_id'),
			'diskon'         => Yoga::clean( Input::get('diskon') ),
			'submit'         => 1,
			'faktur_image'   => $this->imageUpload('faktur','faktur_image', $faktur_belanja_id),
							'tenant_id'  => session()->get('tenant_id'),
			'created_at'     => $timestamp,
			'updated_at'     => $timestamp
		];


		try {
			$last_pembelian_id  = Pembelian::orderBy('id', 'desc')->firstOrFail()->id;
		} catch (\Exception $e) {
			$last_pembelian_id  = 0;
		}

		$total_pembelian    = 0;
		foreach ($data as $dt) {
			$last_pembelian_id++;
			$pembelians[]            = [
				'exp_date'          => Yoga::datePrep($dt['exp_date']),
				'harga_beli'        => $dt['harga_beli'],
				'harga_jual'        => $dt['harga_jual'],
				'staf_id'           => Input::get('staf_id'),
				'faktur_belanja_id' => $faktur_belanja_id,
				'merek_id'          => $dt['merek_id'],
				'harga_naik'        => $dt['harga_berubah'],
				'jumlah'            => $dt['jumlah'],
							'tenant_id'  => session()->get('tenant_id'),
				'created_at'        => $timestamp,
				'updated_at'        => $timestamp,
				'id'                => $last_pembelian_id
			];

			$total_pembelian += $dt['harga_beli']* $dt['jumlah'];
			$rak_id           = Merek::find($dt['merek_id'])->rak_id;

			$query  = "SELECT *, ";
			$query .= "p.exp_date as expiry ";
			$query .= "FROM pembelians as p left join mereks as m on m.id=p.merek_id ";
			$query .= "join raks as r on r.id=m.rak_id ";
			$query .= "where r.id='{$rak_id}' ";
			$query .= "AND p.exp_date > '" . date('Y-m-d') . "' ";
			$query .= "AND p.tenant_id = " . session()->get('tenant_id') . " ";
			$query .= "order by p.exp_date asc ";

			if (count(DB::select($query)) > 0) {
				$exp_date = DB::select($query)[0]->expiry;
			} else {
				$exp_date = Yoga::datePrep($dt['exp_date']);
			}

			$rak               = Rak::find($rak_id);

			if ($rak->exp_date < $exp_date) {
				$exp_date = $rak->exp_date;
			}
			if (Yoga::datePrep($dt['exp_date']) < $exp_date) {
				$exp_date = $dt['exp_date'];
			}

			$rak_updates[] = [
				'collection' => $rak,
				'updates' => [
					'harga_beli'   => $dt['harga_beli'],
					'harga_jual'   => $dt['harga_jual'],
					'exp_date'     => $exp_date,
					'stok'         => $rak->stok + $dt['jumlah']
				]
			];

			// jika tanggal kadaluarsa obat yang sekarang lebih awal dari yang ada di rak,
			// maka rubah tanggal kadaluarsa di rak menjadi lebih awal


			$last_dispensing_id++;
			$dispensings[] = [
				'tanggal'          => Yoga::datePrep( Input::get('tanggal') ),
				'merek_id'         => $dt['merek_id'],
				'masuk'            => $dt['jumlah'],
				'dispensable_id'   => $last_pembelian_id,
				'dispensable_type' => 'App\Models\Pembelian',
				'id'               => $last_dispensing_id,
							'tenant_id'  => session()->get('tenant_id'),
				'created_at'       => $timestamp,
				'updated_at'       => $timestamp
			];
		}
		$jurnals[] = [
			'jurnalable_id'   => $faktur_belanja_id,
			'jurnalable_type' => 'App\Models\FakturBelanja',
			'coa_id'          => Coa::where('kode_coa', '112000')->first()->id, // persediaan obat
			'debit'           => 1,
			'nilai'           => $total_pembelian,
							'tenant_id'  => session()->get('tenant_id'),
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp
		];
		$jurnals[] = [
			'jurnalable_id'   => $faktur_belanja_id,
			'jurnalable_type' => 'App\Models\FakturBelanja',
			'coa_id'          => Input::get('sumber_uang'),
			'debit'           => 0,
			'nilai'           => $total_pembelian - Yoga::clean( Input::get('diskon') ), // Kas di tangan,
							'tenant_id'  => session()->get('tenant_id'),
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp
		];

		if ( (int)Yoga::clean( Input::get('diskon') ) > 0 ) {
			$jurnals[] = [
				'jurnalable_id'   => $faktur_belanja_id,
				'jurnalable_type' => 'App\Models\FakturBelanja',
				'coa_id'          => Coa::where('kode_coa', '50204')->first()->id, // Biaya Produsi Obat (berkurang,
				'debit'           => 0,
				'nilai'           => Yoga::clean( Input::get('diskon') ), // Kas di tanga,
							'tenant_id'  => session()->get('tenant_id'),
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp
			];
		}
		DB::beginTransaction();
		try {
			FakturBelanja::insert($faktur_belanjas);
			$cs = new CustomController;
			JurnalUmum::insert($jurnals);
			Pembelian::insert($pembelians);
			Dispensing::insert($dispensings);
			$cs->massUpdate($rak_updates);
			

			DB::commit();
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
		return redirect('fakturbelanjas/obat')
			->withPesan(Yoga::suksesFlash('Transaksi pembelian untuk struk <strong>' . $faktur_belanja_id . '</strong> di <strong>' . Supplier::find( Input::get('supplier_id'))->nama  . '</strong> telah berhasil'))
			->withPrint($faktur_belanja_id);
	}


	public function show($faktur_belanja_id)
	{
		$fakturbelanja = FakturBelanja::find($faktur_belanja_id);
		$peralatans    = BelanjaPeralatan::where('faktur_belanja_id', $faktur_belanja_id)->get();
		$pembelians    = Pembelian::where('faktur_belanja_id', $faktur_belanja_id)->orderBy('harga_naik', 'asc')->get();
		$jurnalumums   = JurnalUmum::where('jurnalable_type', 'App\Models\FakturBelanja')
								->where('jurnalable_id', $faktur_belanja_id)
								->groupBy('jurnalable_type')
								->get();
		/* return $fakturbelanja; */
		return view('pembelians.show', compact(
			'pembelians', 
			'peralatans', 
			'jurnalumums', 
			'fakturbelanja'
		));
	}

	public function edit($id)
	{
		$sumber_uang = Yoga::sumberuang();
		$fakturbelanja = FakturBelanja::with('pembelian.merek')->where('id', $id)->first();
		$mereks = Merek::with('rak.formula.komposisi.generik')->get();
		$rak = Rak::first();
		$formula = Formula::first();
		$fornas = Yoga::fornas();
		$alternatif_fornas = array('0' => '- Pilih Merek -') + $mereks->pluck('merek', 'id')->all();
		$sediaan = [
			null 				=> '- pilih -',
			'tablet'  			=> 'tablet',
			'syrup'  			=> 'syrup',
			'drop'  			=> 'drop',
			'capsul' 			=> 'capsul',
			'ampul'  			=> 'ampul',
			'vial'  			=> 'vial',
			'tetes mata'  		=> 'tetes mata',
			'tetes telinga' 	=> 'tetes telinga',
			'salep'  			=> 'salep',
			'gel'  				=> 'gel',
			'tube'  			=> 'tube'
		];

		$alternatif_fornas = array('' => '- Pilih Merek -') + $mereks->pluck('merek', 'id')->all();
		$dijual_bebas = array(
                        null        => '- Pilih -',
                        '0'         => 'Tidak Dijual Bebas',
                        '1'         => 'Dijual Bebas'
                    );
		$generik = array('0' => '- Pilih Generik -') + Generik::pluck('generik', 'id')->all();
		$signas = Yoga::signa_list();
		$aturan_minums = Yoga::aturan_minum_list();

		$exist = [];

		foreach ($fakturbelanja->pembelian as $k => $v) {
			$exist[] = [
				'id'            => $v->id,
				'merek'         => $v->merek->merek,
				'staf_id'       => $v->staf_id,
				'merek_id'      => $v->merek_id,
				'harga_beli'    => $v->harga_beli,
				'harga_jual'    => $v->harga_jual,
				'harga_berubah' => $v->harga_naik,
				'exp_date'      => $v->exp_date,
				'jumlah'        => $v->jumlah,
							'tenant_id'  => session()->get('tenant_id'),
				'created_at'        => $v->created_at
			];
		}

		return view('pembelians.edit', compact(
			'mereks'
			, 'id' 
			, 'fakturbelanja'
			, 'sediaan'
			, 'generik'
			, 'sumber_uang'
			, 'exist'
			, 'dijual_bebas'
			, 'signas'
			, 'rak'
			, 'formula'
			, 'fornas'
			, 'aturan_minums'
			, 'alternatif_fornas'));
	}	

	public function stokopname() // id = stok control
	{
		return view('pembelians.stokopname');
	}


	public function update($id)
	{
		DB::beginTransaction();
		try {
			$messages          = array(
				'required'    => ':attribute harus diisi terlebih dahulu',
			);

			$rules           = [
				'staf_id'      => 'required',
				'tanggal'      => 'required',
				'supplier_id'  => 'required',
				'nomor_faktur' => 'required',
				'sumber_uang'  => 'required'
			];
			
			$validator = \Validator::make(Input::all(), $rules);
			
			if ($validator->fails())
			{
				return \Redirect::back()->withErrors($validator)->withInput();
			}

			$data = Input::get('tempBeli'); // data penjualan dalam bentuk Json

			$data = json_decode($data, true); // convert data transaksi ke php array

			$arrayHapus = '';

			$faktur_belanja_id = $id;

			$faktur_belanja = FakturBelanja::find($faktur_belanja_id);
			$dataBefore = Input::get('tempBefore'); // data sebelum di update
			$dataBefore = json_decode($dataBefore, true); // convert data transaksi sebelum di update ke php array


			//edit faktur Belanja
			
			$faktur_belanja->tanggal        = Yoga::datePrep(Input::get('tanggal'));
			$faktur_belanja->nomor_faktur   = Input::get('nomor_faktur');
			$faktur_belanja->supplier_id    = Input::get('supplier_id');
			$faktur_belanja->sumber_uang_id = Input::get('sumber_uang');
			$faktur_belanja->petugas_id     = Input::get('staf_id');
			$faktur_belanja->diskon         = Yoga::clean( Input::get('diskon') );
			$faktur_belanja->save();

			foreach ($dataBefore as $key => $db) {
				$hapus = true;
				foreach ($data as $k => $da) {
					if ($db['id'] == $da['id']) {
						$hapus = false;			// jika id yang sama ditemukan di data transaksi sebelumnya, jangan dihapus		
						break;
					}
				}
				if ($hapus) {
					$arrayHapus[] = $db['id'];
					//ambil pembelian yang mau dihapus
					$pembelian    = Pembelian::find($db['id']);
					//ambil jumlah dan rak_id dari pembelian yang mau dihapus
					$jumlah       = $pembelian->jumlah;
					$merek_id     = $pembelian->merek_id;
					$rak_id       = Merek::find($merek_id)->rak_id;
					//batalkan penambahan stok rak dengan mengurangi stok rak yang ada skearang dengan jumlah pembelian yang mau dihapus
					$rak          = Rak::find($rak_id);
					$rak->stok    = $rak->stok - $jumlah;
					$rak->save();
					//hapus dispensable id nanti dengan menggunakan arrayHapus
				}
			}

			//Hapus dispensing dan pembelian yang mau dihapus
			Dispensing::where('dispensable_type', 'App\Models\Pembelian')
				->whereIn('dispensable_id', $arrayHapus)
				->delete();
			Pembelian::destroy($arrayHapus);
			$pembelians = [];
			$dispensings = [];
			$timestamp = date('Y-m-d H:i:s');
			$last_pembelian_id = Pembelian::orderBy('id', 'desc')->first()->id;
			foreach ($data as $k => $dt) {
				$rak_id = Merek::find($dt['merek_id'])->rak_id;
				$rak    = Rak::find($rak_id);
				$query = "SELECT *, ";
				$query .= "p.exp_date as expiry ";
				$query .= "FROM pembelians as p ";
				$query .= "left join mereks as m on m.id=p.merek_id ";
				$query .= "join raks as r on r.id=m.rak_id ";
				$query .= "where r.id='{$rak_id}' ";
				$query .= "AND p.exp_date > '" . date('Y-m-d') . "' ";
				$query .= "AND p.tenant_id = " . session()->get('tenant_id') . " ";
				$query .= "order by p.exp_date asc ";

				if (count(DB::select($query)) > 0) {
					$exp_date = DB::select($query)[0]->expiry;
				} else {
					$exp_date = $dt['exp_date'];
				}

				if($dt['id'] == null){

					$last_pembelian_id++;
					$pembelians[] = [
						'id'          => $last_pembelian_id,
						'exp_date'          => $dt['exp_date'],
						'harga_beli'        => $dt['harga_beli'],
						'staf_id'           => Input::get('staf_id'),
						'harga_jual'        => $dt['harga_jual'],
						'faktur_belanja_id' => $faktur_belanja_id,
						'merek_id'          => $dt['merek_id'],
						'harga_naik'        => $dt['harga_berubah'],
						'jumlah'            => $dt['jumlah'],
							'tenant_id'  => session()->get('tenant_id'),
						'created_at'        => $timestamp,
						'updated_at'        => $timestamp
					];

					$stok_update = (int)Merek::find($dt['merek_id'])->rak->stok + (int)$dt['jumlah'];

					$rak->stok       = $stok_update;
					$rak->harga_beli = $dt['harga_beli'];
					$rak->harga_jual = $dt['harga_jual'];
					if ($rak->exp_date > $exp_date) {
						$rak->exp_date   = $exp_date;
					}
					$rak->save();

					$dispensings[] = [
						'tanggal'          => $faktur_belanja->tanggal,
						'merek_id'         => $dt['merek_id'],
						'masuk'            => $dt['jumlah'],
						'dispensable_id'   => $last_pembelian_id,
						'dispensable_type' => 'App\Models\Pembelian',
							'tenant_id'  => session()->get('tenant_id'),
						'created_at'       => $timestamp,
						'updated_at'       => $timestamp,
					];

				} else {
					 
					$pb             = Pembelian::find($dt['id']);
					$pb->harga_beli = $dt['harga_beli'];
					$pb->harga_jual = $dt['harga_jual'];
					$pb->merek_id   = $dt['merek_id'];
					$pb->harga_naik = $dt['harga_berubah'];
					$pb->jumlah     = $dt['jumlah'];
					$confirm        = $pb->save();

					$stok_update = (int) Rak::find($rak_id)->stok - (int) $dataBefore[$k]['jumlah'] + (int) $dt['jumlah'];
					if ($confirm) {
						$rak->stok = $stok_update;
						$rak->harga_beli = $dt['harga_beli'];
						$rak->harga_jual = $dt['harga_jual'];
						if ($rak->exp_date > $exp_date) {
							$rak->exp_date = $exp_date;
						}
						$rak->exp_date = $exp_date;
					}
					$db                    = Dispensing::where('dispensable_type', 'App\Models\Pembelian')->where('dispensable_id', $dt['id'])->first();
					$db->masuk             = $dt['jumlah'];
					$db->save();
				}
				$rak->save();
			}
			$supplier = FakturBelanja::find($faktur_belanja_id)->supplier->nama;

			$fb = FakturBelanja::find($faktur_belanja_id);
			$fb->submit = '1';
			if (!empty(Input::hasFile('faktur_image'))) {
				$fb->faktur_image   = $this->imageUpload('faktur','faktur_image', $faktur_belanja_id);
			}
			$fb->save();

			$nilai_baru = 0;
			foreach (Pembelian::where('faktur_belanja_id', $faktur_belanja_id)->get() as $pembelian) {
				$nilai_baru += $pembelian->harga_beli * $pembelian->jumlah;
			}

			//ganti nilai persediaan

			$coa_ids = [];

			$coas = Coa::where('kode_coa', 'like',  '11000%')->get();

			foreach ($coas as $c) {
				$coa_ids[] = $c->id;
			}
			$ju = JurnalUmum::where('jurnalable_id', $faktur_belanja_id)
				->where('jurnalable_type', 'App\Models\FakturBelanja')
				->whereIn('coa_id', $coa_ids) // 
				->where('debit', 0)
				->first();
			$ju->nilai =  ( $nilai_baru - Yoga::clean( Input::get('diskon') ));
			$ju->coa_id = Input::get('sumber_uang');
			$ju->save();
			//cari jurnal diskon
			//
			$coa_id_50204 = Coa::where('kode_coa', '50204')->first()->id;
			$jurnalDiskon = JurnalUmum::where('jurnalable_type', 'App\Models\FakturBelanja')
				->where('jurnalable_id', $faktur_belanja_id)
				->where('coa_id', $coa_id_50204 )
				->where('debit', 0)
				->first();

			if (Yoga::clean(  Input::get('diskon')  ) > 0) {
				if ($jurnalDiskon) {
					$jurnalDiskon->nilai = Yoga::clean( Input::get('diskon') );
					$jurnalDiskon->save();
				} else {
					$jrnl                  = new JurnalUmum;
					$jrnl->jurnalable_id   = $faktur_belanja_id;
					$jrnl->jurnalable_type = 'App\Models\FakturBelanja';
					$jrnl->coa_id          = $coa_id_50204; // Biaya Produsi Obat (berkurang)
					$jrnl->debit           = 0;
					$jrnl->nilai           = Yoga::clean( Input::get('diskon') ); // Kas di tangan
					$jrnl->save();
				}
			} else {
				JurnalUmum::where('jurnalable_type', 'App\Models\FakturBelanja')
					->where('jurnalable_id', $faktur_belanja_id)
					->where('coa_id', $coa_id_50204)
					->where('debit', 0)
					->delete();
			}
			Pembelian::insert($pembelians);
			Dispensing::insert($dispensings);
			DB::commit();
			return redirect('pembelians/show/' . $id)->withPesan(Yoga::suksesFlash('Transaksi pembelian untuk struk <strong>' . $pb->fakturbelanjas . '</strong> di <strong>' . $supplier . '</strong> telah berhasil'));
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
	}
	private function imageUpload($pre, $fieldName, $id){
		if(Input::hasFile($fieldName)) {

			$upload_cover = Input::file($fieldName);
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			/* $upload_cover = Image::make($upload_cover); */
			/* $upload_cover->resize(1000, null, function ($constraint) { */
			/* 	$constraint->aspectRatio(); */
			/* 	$constraint->upsize(); */
			/* }); */

			//membuat nama file random + extension
			$filename =	 $pre . $id . '_' . time() . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			$destination_path = 'img/belanja/obat/';
			/* $destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/belanja/obat/'; */

			// Mengambil file yang di upload
			/* $upload_cover->save($destination_path . '/' . $filename); */
			
			Storage::disk('s3')->put($destination_path. $filename, file_get_contents($upload_cover));
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return $filename;
			
		} else {
			return null;
		}

	}
	public function cariObat(){

		$tanggal       = Input::get('tanggal');
		$nama_supplier = Input::get('nama_supplier');
		$nomor_faktur  = Input::get('nomor_faktur');
		$petugas       = Input::get('petugas');
		$total_biaya   = Input::get('total_biaya');
		$key           = Input::get('key');


		$pecah = new PasiensAjaxController;

		$nama_supplier = $pecah->pecah($nama_supplier);
		$nomor_faktur  = $pecah->pecah($nomor_faktur);
		$petugas       = $pecah->pecah($petugas);
		$total_biaya   = $pecah->pecah($total_biaya);

		$displayed_rows = Input::get('displayed_rows');

		$data  = $this->queryCari($displayed_rows, $tanggal, $nama_supplier, $nomor_faktur, $petugas, $key);
		$count = $this->queryCari($displayed_rows, $tanggal, $nama_supplier, $nomor_faktur, $petugas, $key, true);

		$lines       = count($count);
		$pages       = ceil( $lines / $displayed_rows);
		return [
			'data'  => $data,
			'key'   => $key,
			'count' => $lines,
			'pages' => $pages
		];
	}
	private function queryCari($displayed_rows, $tanggal, $nama_supplier, $nomor_faktur, $petugas, $key, $count = false){

		$pass = $displayed_rows * $key;

		$query  = "SELECT ";
		if (!$count) {
			$query .= "fb.tanggal as tanggal, ";
			$query .= "sp.nama as nama_supplier, ";
			$query .= "fb.nomor_faktur as nomor_faktur, ";
			$query .= "fb.id as faktur_belanja_id, ";
			$query .= "st.nama as nama_petugas, ";
			$query .= "SUM(pb.harga_beli * pb.jumlah) as total_biaya ";
		} else {
			$query .= "count(pb.id) as jumlah ";
		}

		$query .= "FROM pembelians as pb ";
		$query .= "JOIN faktur_belanjas as fb on fb.id = pb.faktur_belanja_id ";
		$query .= "JOIN stafs as st on st.id = pb.staf_id ";
		$query .= "JOIN suppliers as sp on sp.id = fb.supplier_id ";
		$query .= "WHERE ";
		$query .= "(fb.tanggal like ? or ? = '') ";
		$query .= "AND (sp.nama like ? or ? = '') ";
		$query .= "AND (fb.nomor_faktur like ? or ? = '') ";
		$query .= "AND (st.nama like ? or ? = '') ";
		$query .= "AND pb.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "GROUP BY pb.faktur_belanja_id ";
		$query .= "ORDER BY pb.created_at ";
		if (!$count) {
			$query .= "DESC LIMIT {$pass}, {$displayed_rows}";
		}
		return DB::select($query, [
			$tanggal . '%',
			$tanggal ,
			'%' . $nama_supplier . '%',
			$nama_supplier ,
			'%' . $nomor_faktur . '%',
			$nomor_faktur ,
			'%' . $petugas . '%',
			$petugas
		]);


	}
	public function ajax(){

		$nomor_faktur   = Input::get('nomor_faktur');
		$merek          = Input::get('merek');
		$harga_beli     = Input::get('harga_beli');
		$harga_jual     = Input::get('harga_jual');
		$nama_supplier  = Input::get('nama_supplier');
		$displayed_rows = Input::get('displayed_rows');
		$key            = Input::get('key');
		$tanggal            = Input::get('tanggal');


		$psn           = new PasiensAjaxController;
		$merek         = $psn->pecah($merek);
		$nama_supplier = $psn->pecah($nama_supplier);
		$nomor_faktur  = $psn->pecah($nomor_faktur);
		$nama_supplier = $psn->pecah($nama_supplier);
		$harga_beli    = $psn->pecah($harga_beli);
		$harga_jual    = $psn->pecah($harga_jual);

		$pass = $key * $displayed_rows;

		$datas = $this->queryAjax($tanggal,$nomor_faktur, $merek, $harga_beli, $harga_jual, $nama_supplier, $pass, $displayed_rows);
		$counts = $this->queryAjax($tanggal,$nomor_faktur, $merek, $harga_beli, $harga_jual, $nama_supplier, $pass, $displayed_rows, true);

		$count = $counts[0]->jumlah;

		$pages = ceil($count / $displayed_rows);


		return [
			'data'  => $datas,
			'pages' => $pages,
			'key'   => $key,
			'rows'  => $count
		];

	}
	private function queryAjax($tanggal,$nomor_faktur, $merek, $harga_beli, $harga_jual, $nama_supplier, $pass, $displayed_rows, $count = false){

		$query  = "SELECT ";
		if ( !$count ) {
			$query .= "pb.id as id, ";
			$query .= "fb.tanggal as tanggal, ";
			$query .= "mr.merek as merek, ";
			$query .= "pb.harga_beli as harga_beli, ";
			$query .= "pb.harga_jual as harga_jual, ";
			$query .= "pb.exp_date as exp_date, ";
			$query .= "pb.jumlah as jumlah, ";
			$query .= "fb.nomor_faktur as nomor_faktur, ";
			$query .= "sp.nama as nama_supplier ";
		} else {
			$query .= "count(pb.id) as jumlah ";
		}
		$query .= "FROM pembelians as pb ";
		$query .= "JOIN mereks as mr on mr.id = pb.merek_id ";
		$query .= "JOIN faktur_belanjas as fb on fb.id = pb.faktur_belanja_id ";
		$query .= "JOIN suppliers as sp on sp.id = fb.supplier_id ";
		$query .= "WHERE ( mr.merek like ? or ? = '' ) ";
		$query .= "AND ( fb.nomor_faktur like ? or ? = '' ) ";
		$query .= "AND ( sp.nama like ? or ? = '' ) ";
		$query .= "AND ( pb.harga_beli like ? or ? = '' ) ";
		$query .= "AND ( pb.harga_jual like ? or ? = '' ) ";
		$query .= "AND ( fb.tanggal like ? or ? = '' ) ";
		$query .= "AND pb.tenant_id = " . session()->get('tenant_id') . " ";
		if (!$count) {
			$query .= "ORDER BY pb.created_at desc ";
			$query .= "LIMIT {$pass}, {$displayed_rows}";
		}
		$data = DB::select($query, [
			'%' . $merek . '%',
			$merek ,
			'%' . $nomor_faktur . '%',
			$nomor_faktur ,
			'%' . $nama_supplier . '%',
			$nama_supplier ,
			'%' . $harga_beli . '%',
			$harga_beli ,
			'%' . $harga_jual . '%',
			$harga_jual,
			 $tanggal . '%',
			$tanggal 
		]);
		return $data;

	}
}
