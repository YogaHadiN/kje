<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Pembelian;
use App\FakturBelanja;
use App\Merek;
use App\Rak;
use App\Formula;
use App\JurnalUmum;
use App\Classes\Yoga;
use App\Generik;
use Image;
use DB;
use App\Dispensing;

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

		$alternatif_fornas = array('' => '- Pilih Merek -') + Merek::lists('merek', 'id')->all();

		$dijual_bebas = array(
                        null        => '- Pilih -',
                        '0'         => 'Tidak Dijual Bebas',
                        '1'         => 'Dijual Bebas'
                    );

		$generik = array('0' => '- Pilih Generik -') + Generik::lists('generik', 'id')->all();

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
		$rules = [

			'tanggal'      => 'required|date|date_format:d-m-Y',
			'nomor_faktur' => 'required',
			'belanja_id'   => 'required',
			'supplier_id'  => 'required',
			'diskon'       => 'required',
			'sumber_uang'  => 'required',
			'tempBeli'     => 'json|required',

		];



		$validator = \Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$data = Input::get('tempBeli');
		$data = json_decode( $data, true );


		$input = [
			'data'          => $data
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

		$faktur                 = new FakturBelanja;
		$faktur->tanggal        = Yoga::datePrep(Input::get('tanggal'));
		$faktur->nomor_faktur   = Input::get('nomor_faktur');
		$faktur->belanja_id     = Input::get('belanja_id');
		$faktur->supplier_id    = Input::get('supplier_id');
		$faktur->sumber_uang_id = Input::get('sumber_uang');
		$faktur->petugas_id     = Input::get('staf_id');
		$faktur->diskon         = Yoga::clean( Input::get('diskon') );
		$faktur->save();
		$faktur->faktur_image   = $this->imageUpload('faktur','faktur_image', $faktur->id);
		$confirm                = $faktur->save();
		if ($confirm) {
			$faktur_belanja_id  = $faktur->id;
			$total_pembelian    = 0;

			foreach ($data as $dt) {

				$pb                    = new Pembelian;
				$pb->exp_date          = Yoga::datePrep($dt['exp_date']);
				$pb->harga_beli        = $dt['harga_beli'];
				$pb->harga_jual        = $dt['harga_jual'];
				$pb->staf_id           = Input::get('staf_id');
				$pb->faktur_belanja_id = $faktur_belanja_id;
				$pb->merek_id          = $dt['merek_id'];
				$pb->harga_naik        = $dt['harga_berubah'];
				$pb->jumlah            = $dt['jumlah'];
				$pb->save();

				$total_pembelian += $pb->harga_beli * $pb->jumlah;

				$rak_id = Merek::find($dt['merek_id'])->rak_id;
				$query = "SELECT *, p.exp_date as expiry FROM pembelians as p left join mereks as m on m.id=p.merek_id join raks as r on r.id=m.rak_id where r.id='{$rak_id}' AND p.exp_date > '" . date('Y-m-d') . "' order by p.exp_date asc;";
				if (count(DB::select($query)) > 0) {
					$exp_date = DB::select($query)[0]->expiry;
				} else {
					$exp_date = Yoga::datePrep($dt['exp_date']);
				}

				$rak = Rak::find($rak_id);
				$rak->harga_beli = $dt['harga_beli'];
				$rak->harga_jual = $dt['harga_jual'];
				if ($rak->exp_date > $exp_date) {
					$rak->exp_date = $exp_date;
				}
				$rak->exp_date = $exp_date;
				$rak->stok = $rak->stok + $dt['jumlah'];

				// jika tanggal kadaluarsa obat yang sekarang lebih awal dari yang ada di rak,
				// maka rubah tanggal kadaluarsa di rak menjadi lebih awal
				if (strtotime($pb->exp_date) < strtotime($rak->exp_date)) {
					$rak->exp_date = $dt['exp_date'];
				}

				$confirm = $rak->save();

				if ($confirm) {
					$db = new Dispensing;
					$db->tanggal = $faktur->tanggal;
					$db->rak_id = $rak->id;
					$db->masuk = $dt['jumlah'];
					$db->dispensable_id = $pb->id;
					$db->dispensable_type = 'App\Pembelian';
					$db->id = Yoga::customId('App\Dispensing');
					$db->save();
				}
			}
		}
		if ($confirm) {
			$supplier = FakturBelanja::find($faktur_belanja_id)->supplier->nama;
			$fb = FakturBelanja::find($faktur_belanja_id);
			$fb->submit = '1';
			$fb->save();

            $jurnal                  = new JurnalUmum;
            $jurnal->jurnalable_id   = $faktur_belanja_id;
            $jurnal->jurnalable_type = 'App\FakturBelanja';
            $jurnal->coa_id          = 112000; // Persediaan Obat
            $jurnal->debit           = 1;
            $jurnal->nilai           = $total_pembelian;
            $jurnal->save();

            $jurnal                  = new JurnalUmum;
            $jurnal->jurnalable_id   = $faktur_belanja_id;
            $jurnal->jurnalable_type = 'App\FakturBelanja';
            $jurnal->coa_id          = Input::get('sumber_uang');
            $jurnal->debit           = 0;
            $jurnal->nilai           = $total_pembelian - Yoga::clean( Input::get('diskon') ); // Kas di tangan;
            $jurnal->save();

			if ( (int)Yoga::clean( Input::get('diskon') ) > 0 ) {
				$jurnal                  = new JurnalUmum;
				$jurnal->jurnalable_id   = $faktur_belanja_id;
				$jurnal->jurnalable_type = 'App\FakturBelanja';
				$jurnal->coa_id          = 50204; // Biaya Produksi Obat (berkurang)
				$jurnal->debit           = 0;
				$jurnal->nilai           = Yoga::clean( Input::get('diskon') ); // Kas di tangan
				$jurnal->save();
			}

            return redirect('fakturbelanjas/obat')
                ->withPesan(Yoga::suksesFlash('Transaksi pembelian untuk struk <strong>' . $pb->fakturbelanjas . '</strong> di <strong>' . $supplier . '</strong> telah berhasil'))
                ->withPrint($faktur_belanja_id);
		} else {
			$supplier = FakturBelanja::find($faktur_belanja_id)->supplier->nama;
			return redirect('fakturbelanjas/cari')->withPesan(Yoga::suksesFlash('Transaksi pembelian untuk struk <strong>' . $pb->fakturbelanjas . '</strong> di <strong>' . $supplier . '</strong> telah GAGAL'));
		}

	}

	public function riwayat(){

		$bulanTahun = Yoga::blnPrep(Input::get('bulanTahun'));
		$faktur_beli = FakturBelanja::where('tanggal', 'like', $bulanTahun . '%')->where('belanja_id', '1')->get();
		$harga = 0;
		// return $faktur_beli;
		foreach ($faktur_beli as $fb) {
			$harga += $fb->harga;
		}
		// return $faktur_beli;
		// 
		$bulanTahun = Input::get('bulanTahun');
		
		return view('pembelians.riwayat')
		->withFaktur_beli($faktur_beli)
		->withHarga($harga)
		->withBth($bulanTahun);
	}

	public function show($faktur_belanja_id)
	{
		$pembelians = Pembelian::where('faktur_belanja_id', $faktur_belanja_id)->orderBy('harga_naik', 'asc')->get();
		$fakturbelanja = FakturBelanja::find($faktur_belanja_id);
		return view('pembelians.show', compact('pembelians', 'fakturbelanja'));
		// return $faktur_belanja_id;
	}

	public function edit($id)
	{
		$fakturbelanja = FakturBelanja::with('pembelian.merek')->where('id', $id)->first();
		$mereks = Merek::with('rak.formula.komposisi.generik')->get();
		$rak = Rak::first();
		$formula = Formula::first();
		$fornas = Yoga::fornas();
		$alternatif_fornas = array('0' => '- Pilih Merek -') + $mereks->lists('merek', 'id')->all();
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

		$alternatif_fornas = array('' => '- Pilih Merek -') + $mereks->lists('merek', 'id')->all();
		$dijual_bebas = array(
                        null        => '- Pilih -',
                        '0'         => 'Tidak Dijual Bebas',
                        '1'         => 'Dijual Bebas'
                    );
		$generik = array('0' => '- Pilih Generik -') + Generik::lists('generik', 'id')->all();
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
				'created_at'        => $v->created_at
			];
		}

		return view('pembelians.edit', compact(
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

	public function stokopname() // id = stok control
	{
		return view('pembelians.stokopname');
	}


	public function update($id)
	{
		$data = Input::get('tempBeli'); // data penjualan dalam bentuk Json

		$data = json_decode($data, true); // convert data transaksi ke php array

		$arrayHapus = '';

		$faktur_belanja_id = $id;

		$faktur_belanja = FakturBelanja::find($faktur_belanja_id);
		$dataBefore = Input::get('tempBefore'); // data sebelum di update
		$dataBefore = json_decode($dataBefore, true); // convert data transaksi sebelum di update ke php array

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
                $pembelian = Pembelian::find($db['id']);
                //ambil jumlah dan rak_id dari pembelian yang mau dihapus
                $jumlah = $pembelian->jumlah;
                $merek_id = $pembelian->merek_id;
                $rak_id = Merek::find($merek_id)->rak_id;
                //batalkan penambahan stok rak dengan mengurangi stok rak yang ada skearang dengan jumlah pembelian yang mau dihapus
                $rak = Rak::find($rak_id);
                $rak->stok = $rak->stok - $jumlah;
                $rak->save();
                //hapus dispensable id nanti dengan menggunakan arrayHapus
			}
		}

		//Hapus dispensing dan pembelian yang mau dihapus
		Dispensing::where('dispensable_type', 'App\Pembelian')
			->whereIn('dispensable_id', $arrayHapus)
			->delete();
		Pembelian::destroy($arrayHapus);

		foreach ($data as $k => $dt) {
			$rak_id = Merek::find($dt['merek_id'])->rak_id;
			$rak    = Rak::find($rak_id);
			$query = "SELECT *, p.exp_date as expiry FROM pembelians as p left join mereks as m on m.id=p.merek_id join raks as r on r.id=m.rak_id where r.id='{$rak_id}' AND p.exp_date > '" . date('Y-m-d') . "' order by p.exp_date asc;";

			if (count(DB::select($query)) > 0) {
				$exp_date = DB::select($query)[0]->expiry;
			} else {
				$exp_date = $dt['exp_date'];
			}

			if($dt['id'] == null){

				$pembelian_id = Yoga::customId('App\Pembelian');
				$pb = new Pembelian;
				$pb->exp_date = $dt['exp_date'];
				$pb->harga_beli = $dt['harga_beli'];
				$pb->harga_jual = $dt['harga_jual'];
				$pb->faktur_belanja_id = $faktur_belanja_id;
				$pb->merek_id = $dt['merek_id'];
				$pb->harga_naik = $dt['harga_berubah'];
				$pb->jumlah = $dt['jumlah'];
				$pb->id = $pembelian_id;
				$confirm = $pb->save();

				$stok_update = (int)Merek::find($dt['merek_id'])->rak->stok + (int)$dt['jumlah'];

				$rak->stok       = $stok_update;
				$rak->harga_beli = $dt['harga_beli'];
				$rak->harga_jual = $dt['harga_jual'];
				if ($rak->exp_date > $exp_date) {
					$rak->exp_date   = $exp_date;
				}
				$rak->save();

				$db          = new Dispensing;
				$db->tanggal = $faktur_belanja->tanggal;
				$db->rak_id  = $rak_id;
				$db->masuk   = $dt['jumlah'];
				$db->dispensable_id  = $pembelian_id;
				$db->dispensable_type  = 'App\Pembelian';
				$db->id      = Yoga::customId('App\Dispensing');
				$db->save();

			} else {
                //return $dt;
                //return 'masuk sini';
                 
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

				$db                    = Dispensing::where('dispensable_type', 'App\Pembelian')->where('dispensable_id', $dt['id'])->first();
				$db->masuk             = $dt['jumlah'];
				$db->save();
			}
			$rak->save();
		}

		if ($confirm) {
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

            $ju = JurnalUmum::where('jurnalable_id', $faktur_belanja_id)
                            ->where('jurnalable_type', 'App\FakturBelanja')
                            ->update(['nilai' => $nilai_baru]);

			return redirect('pembelians/show/' . $id)->withPesan(Yoga::suksesFlash('Transaksi pembelian untuk struk <strong>' . $pb->fakturbelanjas . '</strong> di <strong>' . $supplier . '</strong> telah berhasil'));
		} else {
			$supplier = FakturBelanja::find($faktur_belanja_id)->supplier->nama;
			return redirect('pembelians/show/' . $id)->withPesan(Yoga::suksesFlash('Transaksi pembelian untuk struk <strong>' . $pb->fakturbelanjas . '</strong> di <strong>' . $supplier . '</strong> telah GAGAL'));
		}
	}

	private function imageUpload($pre, $fieldName, $id){
		if(Input::hasFile($fieldName)) {

			$upload_cover = Input::file($fieldName);
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			$upload_cover = Image::make($upload_cover);
			$upload_cover->resize(1000, null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});

			//membuat nama file random + extension
			$filename =	 $pre . $id . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			$destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/belanja/obat';

			// Mengambil file yang di upload
			$upload_cover->save($destination_path . '/' . $filename);
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return $filename;
			
		} else {
			return null;
		}

	}
}
