<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BayarGaji;
use App\Models\JurnalUmum;
use App\Models\Config;
use App\Models\Periksa;
use App\Models\Pph21;
use App\Models\Staf;
use App\Models\Coa;
use App\Models\Classes\Yoga;
use DB;
use Input;
use Carbon\Carbon;

/** 
 * PPh::create() uncomment
 * uncomment  line 737 
 * delete line 738
 * */

class BayarGajiController extends Controller
{
	public $gaji_bruto_bulan_ini;
	public $perhitunganPph_ini;
	public $staf;
	public $bayar;

	public $input_staf_id;
	public $input_bulan;
	public $input_petugas_id;
	public $input_mulai;
	public $input_akhir;
	public $input_hutang;
	public $input_gaji_pokok;
	public $input_tanggal_dibayar;
	public $input_sumber_uang_id;
	public $input_bonus;

	public function __construct()
	 {
	     $this->middleware('super', ['only' => ['bayar_gaji_karyawan', 'nota_z']]);
		 $this->middleware('keuangan', ['only' => [
			 'gajiDokterGigi', 
			 'gajiDokterGigiBayar', 
			 'gajiDokterGigiEdit', 
		 ]]);
	     $this->middleware('notready', ['only' => ['nota_z']]);

		$this->input_container_gaji  = Input::get('container_gaji');

		$this->input_staf_id         = Input::get('staf_id');
		/* $this->input_tanggal_dibayar = Carbon::createFromFormat('d-m-Y', Input::get('tanggal_dibayar'))->format('Y-m-d'); */
		$this->input_tanggal_dibayar = Input::get('tanggal_dibayar');
		$this->input_petugas_id      = Input::get('petugas_id');
		$this->input_mulai           = Input::get('mulai');
		$this->input_bulan           = Input::get('bulan');
		$this->input_akhir           = Input::get('akhir');
		$this->input_hutang          = 0;
		if ( !empty( Input::get('hutang') ) ) {
			$this->input_hutang           = Input::get('hutang');
		}

		$this->input_gaji_pokok      = Input::get('gaji_pokok');
		$this->input_bonus           = 0;
		if ( !empty( Input::get('bonus') ) ) {
			$this->input_bonus           = Input::get('bonus');
		}

		$this->input_sumber_uang_id  = Input::get('sumber_uang_id');
		$this->gaji_bruto_bulan_ini = [];
		$this->perhitunganPph_ini = [];
		$this->staf;
	 }

    public function bayar(){
		$bayar_dokters = $this->query("stf.titel_id = 2 ");
        return view('formbayardokter', compact('bayar_dokters'));
    }
   public function bayar_gaji(){
	   DB::beginTransaction();
	   try {
		   $rules                = [
			 "sumber_uang_id"   => "required",
			  "bulan"           => "required",
			  "tanggal_dibayar" => "required",
		   ];
		   
		   $validator = \Validator::make(Input::all(), $rules);
		   
		   if ($validator->fails())
		   {
			return \Redirect::back()->withErrors($validator)->withInput();
		   }

		   $container_gaji    = $this->prepContainerGaji();
		   $sisa_hutang_bonus = $this->sisaHutangBonus();
		   $ptkp              = Config::where('config_variable', 'Penghasilan Tidak Kena Pajak')->first()->value;
		   $timestamp_jurnal  = date('Y-m-t 23:59:59', strtotime($this->input_bulan . '-01'));
		   $timestamp_now     = date('Y-m-d H:i:s');
		   $jurnals           = [];
		   $bayar_gajis       = [];
		   $pph            = [];

			$bulan             = Yoga::bulanTahun( Input::get('bulan') );
			$this->input_mulai = date("Y-m-d 00:00:00", strtotime($bulan . '-01'));
			$this->input_akhir = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));

			
			$coa_id_60101  = Coa::where('kode_coa', '60101')->first()->id;
			$coa_id_200002 = Coa::where('kode_coa', '200002')->first()->id;
			$coa_id_50205  = Coa::where('kode_coa', '50205')->first()->id;
			$coa_id_200004 = Coa::where('kode_coa', '200004')->first()->id;


		   foreach ($container_gaji as $cg) {
			   $this->gaji_bruto_bulan_ini = [];
				$this->staf             = Staf::find( $cg['staf_id'] );
				$this->input_staf_id    = $cg['staf_id'];
				$this->input_gaji_pokok = $cg['gaji_pokok'];
				$this->input_bonus      = $cg['jumlah_bonus'];
				$this->bayar            = $this->inputBayarGajiDanPph();
				$pph[]                  = $this->pph21Data();


			   if ($cg['gaji_pokok'] > 0) {
				   $jurnals[] = [
					   'jurnalable_id'   => $this->bayar->id,
					   'jurnalable_type' => 'App\Models\BayarGaji',
					   'coa_id'          => $coa_id_60101,
					   'debit'           => 1,
							'tenant_id'  => session()->get('tenant_id'),
					   'created_at'      => $timestamp_jurnal,
					   'updated_at'      => $timestamp_jurnal,
					   'nilai'           => $cg['gaji_pokok']
				   ];
			   }
			   // Hitung hutang kepada asisten dalam satu bulan, jika hutangnya masih lebih banyak lebih dari bonus dari pada yang sudah dibayarkan, maka jurnal masuk semua ke hutang
			   if ($sisa_hutang_bonus >= $cg['jumlah_bonus']) {
				   if ($cg['jumlah_bonus'] > 0) {
					   $jurnals[] = [
						   'jurnalable_id'   => $this->bayar->id,
						   'jurnalable_type' => 'App\Models\BayarGaji',
						   'coa_id'          => $coa_id_200002, // Hutang Kepada Asisten Dokte,
						   'debit'           => 1,
							'tenant_id'  => session()->get('tenant_id'),
						   'created_at'      => $timestamp_jurnal,
						   'updated_at'      => $timestamp_jurnal,
						   'nilai'           => $cg['jumlah_bonus']
					   ];
				   }
			   } else{
				   if ($sisa_hutang_bonus > 0) {
					   $beban_produksi_hutang_asisten = $cg['jumlah_bonus'] - $sisa_hutang_bonus;
				   }else{
					   $beban_produksi_hutang_asisten = $cg['jumlah_bonus'];
				   }
				   if ($sisa_hutang_bonus > 0) {
					   $jurnals[] = [
						   'jurnalable_id'   => $this->bayar->id,
						   'jurnalable_type' => 'App\Models\BayarGaji',
						   'coa_id'          => $coa_id_200002,// Hutang Kepada Asisten Dokte,
						   'debit'           => 1,
							'tenant_id'  => session()->get('tenant_id'),
						   'created_at'      => $timestamp_jurnal,
						   'updated_at'      => $timestamp_jurnal,
						   'nilai'           => $sisa_hutang_bonus,
					   ];
				   }

				   if ($beban_produksi_hutang_asisten > 0) {
					   $jurnals[] = [
						   'jurnalable_id'   => $this->bayar->id,
						   'jurnalable_type' => 'App\Models\BayarGaji',
						   'coa_id'          => $coa_id_50205,
							'tenant_id'  => session()->get('tenant_id'),
						   'created_at'      => $timestamp_jurnal,
						   'updated_at'      => $timestamp_jurnal,
						   'debit'           => 1,
						   'nilai'           => $beban_produksi_hutang_asisten,
					   ];
				   }
			   }

			   if ($cg['jumlah_bonus'] + $cg['gaji_pokok'] > 0) {
				   $jurnals[] = [
					   'jurnalable_id'   => $this->bayar->id,
					   'jurnalable_type' => 'App\Models\BayarGaji',
					   'coa_id'          => $this->input_sumber_uang_id, //Kas Sumbe,
						'tenant_id'      => session()->get('tenant_id'),
					   'created_at'      => $timestamp_jurnal,
					   'updated_at'      => $timestamp_jurnal,
					   'debit'           => 0,
					   'nilai'           => $cg['gaji_pokok'] + $cg['jumlah_bonus'] - $this->perhitunganPph_ini['pph21']
				   ];
				   if ( $this->perhitunganPph_ini['pph21'] > 0 ) {
					   $jurnals[] = [
						   'jurnalable_id'   => $this->bayar->id,
						   'jurnalable_type' => 'App\Models\BayarGaji',
						   'coa_id'          => $coa_id_200004, // Hutang pph21
						   'debit'           => 0,
						   'nilai'           => $this->perhitunganPph_ini['pph21'],
							'tenant_id'  => session()->get('tenant_id'),
						   'created_at'      => $timestamp_jurnal,
						   'updated_at'      => $timestamp_jurnal
					   ];
				   }
			   }
		   }
		   JurnalUmum::insert($jurnals);
		   Pph21::insert($pph);
		   $pesan = Yoga::suksesFlash('Pembayaran Gaji telah <strong>BERHASIL</strong>' );
		   DB::commit();
		   return redirect('pengeluarans/bayar_gaji_karyawan')
			   ->withPesan($pesan)
			   ->withPrint($this->bayar->id);
	   } catch (\Exception $e) {
		   DB::rollback();
		   throw $e;
	   }
   }
    public function bayar_gaji_karyawan(){
        $sumber_kas_lists = [null => '-Pilih-'] + Coa::where('kode_coa', 'like', '110%')->where('kode_coa', 'not like', '110000')->pluck('coa', 'id')->all();
        $pembayarans      = $this->query("(stf.titel_id not like 2 and stf.titel_id not like 3 )");
		return view('pengeluarans.bayar_gaji_karyawan', compact(  
			'pembayarans', 
			'sumber_kas_lists'
		));
    }
	public function gajiDokterGigi(){
		$gaji_gigis = $this->query("stf.titel_id = 3 ");
		return view('pengeluarans.bayar_dokter_gigi', compact('gaji_gigis'));
	}

	public function gajiDokterGigiEdit($id){
		$gaji_gigi = BayarGaji::find($id);
		return view('pengeluarans.bayar_dokter_gigi_edit', compact('gaji_gigi'));
	}

    
	public function gajiDokterGigiBayar(){
		$rules = [
			'staf_id'         => 'required',
			'petugas_id'      => 'required',
			'gaji_pokok'      => 'required',
			'bulan'           => 'required',
			'tanggal_dibayar' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$bulan             = Yoga::bulanTahun( Input::get('bulan') );
		$this->input_mulai = date("Y-m-d 00:00:00", strtotime($bulan . '-01'));
		$this->input_akhir = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));

		$this->bayar       = $this->inputBayarGajiDanPph();
		$pph               = $this->pph21Data();

		Pph21::create($pph);

		$jurnal                  = new JurnalUmum;
		$jurnal->jurnalable_id   = $this->bayar->id; // id referensi yang baru dibuat
		$jurnal->jurnalable_type = 'App\Models\BayarGaji';
		$jurnal->coa_id          = Coa::where('kode_coa', '610000')->first()->id; // biaya operasional gaji dokter gigi
		$jurnal->debit           = 1;
		$jurnal->nilai           = Yoga::clean( $this->input_gaji_pokok ) + $this->input_bonus;
		$jurnal->created_at      = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
		$jurnal->updated_at      = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
		$jurnal->save();
		
		$jurnal                  = new JurnalUmum;
		$jurnal->jurnalable_id   = $this->bayar->id;// id referensi yang baru dibuat
		$jurnal->jurnalable_type = 'App\Models\BayarGaji';
		$jurnal->coa_id          = $this->input_sumber_uang_id; // Kas di tangan 110004, Kas di kasir 110000,
		$jurnal->debit           = 0;
		$jurnal->nilai           = Yoga::clean( $this->input_gaji_pokok ) + $this->input_bonus - $this->perhitunganPph_ini['pph21'];
		$jurnal->created_at      = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
		$jurnal->updated_at      = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
		$jurnal->save();

		$jurnal                  = new JurnalUmum;
		$jurnal->jurnalable_id   = $this->bayar->id;// id referensi yang baru dibuat
		$jurnal->jurnalable_type = 'App\Models\BayarGaji';
		$jurnal->coa_id          = Coa::where('kode_coa', '200004')->first()->id;
		$jurnal->debit           = 0;
		$jurnal->nilai           = $this->perhitunganPph_ini['pph21'];
		$jurnal->created_at      = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
		$jurnal->updated_at      = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
		$jurnal->save();

		$pesan = 'Gaji Dokter Gigi <strong>' ;
		$pesan .= $this->bayar->staf->nama ;
		$pesan .=  '</strong> sebesar <strong>' ;
		$pesan .=  Yoga::buatrp( Yoga::clean($this->input_gaji_pokok) + $this->input_bonus ) ;
		$pesan .=  '</strong>, Telah berhasil diInput';
		$pesan = Yoga::suksesFlash($pesan);
		return redirect('pengeluarans/gaji_dokter_gigi')->withPesan($pesan);
	}

	public function gajiDokterGigiUpdate($id){


		$rules = [
			'staf_id'         => 'required',
			'petugas_id'      => 'required',
			'nilai'           => 'required',
			'bulan'           => 'required',
			'tanggal_dibayar' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$bulan =  Yoga::blnPrep( Input::get('bulan') );

		Yoga::clean( $this->input_gaji_pokok ) + $this->input_bonus                 = Yoga::clean( Input::get('nilai') );

		$gaji                  = BayarGaji::find($id);
		$gaji->staf_id         = Input::get('staf_id');
		$gaji->petugas_id      = Input::get('petugas_id');
		$gaji->nilai           = Yoga::clean( $this->input_gaji_pokok ) + $this->input_bonus;
	    $gaji->tanggal_mulai   = $bulan . '-01';
	    $gaji->tanggal_akhir   = date("Y-m-t", strtotime($bulan . '-01'));
		$gaji->tanggal_dibayar = Yoga::datePrep( Input::get('tanggal_dibayar') );
		$gaji->created_at      = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
		$gaji->updated_at      = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
		$confirm               = $gaji->save();

		JurnalUmum::where('jurnalable_type', 'App\Models\BayarGaji')
				->where('jurnalable_id', $id)
				->delete();

		if ($confirm) {
			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $this->bayar->id; // id referensi yang baru dibuat
			$jurnal->jurnalable_type = 'App\Models\BayarGaji';
			$jurnal->coa_id          = Coa::where('kode_coa', '610000')->first()->id; // biaya operasional gaji dokter gigi
			$jurnal->debit           = 1;
			$jurnal->nilai           = Yoga::clean( $this->input_gaji_pokok ) + $this->input_bonus;
			$jurnal->created_at = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
			$jurnal->updated_at = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
			$jurnal->save();
			
			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $this->bayar->id;// id referensi yang baru dibuat
			$jurnal->jurnalable_type = 'App\Models\BayarGaji';
			$jurnal->coa_id          = Input::get('sumber_coa_id'); // Kas di tangan 110004, Kas di kasir 110000, 
			$jurnal->debit           = 0;
			$jurnal->nilai           = Yoga::clean( $this->input_gaji_pokok ) + $this->input_bonus;
			$jurnal->created_at = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
			$jurnal->updated_at = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
			$jurnal->save();

			$pesan = Yoga::suksesFlash('Gaji Dokter Gigi <strong>' . $gaji->staf->nama . '</strong> sebesar <strong>' . Yoga::buatrp( $gaji->nilai ) . '</strong>, Telah berhasil diInput');
		} else {
			$pesan = Yoga::suksesFlash('Gaji Dokter Gagal diInput');
		}
		return redirect('pengeluarans/gaji_dokter_gigi')->withPesan($pesan);
	}
    public function dokterbayar(){
		$rules           = [
			'staf_id'   => 'required',
			'mulai'     => 'required',
			'jam_mulai' => 'required',
			'akhir'     => 'required',
			'jam_akhir' => 'required',
		];

		$validator = \Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
         
        $id              = Input::get('staf_id');
        $this->staf      = Staf::find($id);
		$mulai           = Input::get('mulai');
		$jam_mulai       = Input::get('jam_mulai');
		$tanggal_dibayar = Input::get('tanggal_dibayar');
		$akhir           = Input::get('akhir');
		$jam_akhir       = Input::get('jam_akhir');

		$mulai = Yoga::datePrep($mulai);
		$mulai = $mulai . ' ' . $jam_mulai;
		$akhir = Yoga::datePrep($akhir);
		$akhir = $akhir . ' ' . $jam_akhir;
         
		$hutangs = Periksa::with('transaksii.jenisTarif', 'pasien', 'asuransi', 'jurnals')
					->whereRaw("created_at between '" . $mulai . "' and '" . $akhir . "'")
					->where('staf_id', $id)
					->get();

        $total   = $this->total($mulai, $akhir);
		if ( $this->staf->ada_penghasilan_lain == '1' ) {
			$ada_penghasilan_lain = '1';
		} else {
			$ada_penghasilan_lain = null;
		}
		$staf = $this->staf;
		return view('dokterbayar', compact(
			'hutangs', 
			'total',
			'tanggal_dibayar',
			'ada_penghasilan_lain',
		   	'staf',
		   	'mulai',
		   	'akhir',
			'id'
		));
    }

    
    public function dokterdibayar(){
		$rules           = [
			'staf_id'        => 'required',
			'hutang'         => 'required',
			'gaji_pokok'     => 'required',
			'petugas_id'     => 'required',
			'sumber_uang_id' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);

		if ($validator->fails()){
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$this->bayar = $this->inputBayarGajiDanPph();
		$jurnals     = $this->collectJurnal();
		$pph         = $this->pph21Data();

		// tahun dihitung adalah tahun dimana dokter mulai bekerja
		DB::beginTransaction();
		try {
			JurnalUmum::insert($jurnals);
			Pph21::create($pph);
			DB::commit();
            $this->staf->plafon_bpjs = 0;
            $this->staf->save();
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
		$pesan = Yoga::suksesFlash('Gaji ' . $this->staf->nama . ' sebesar ' . Yoga::buatrp( Yoga::clean($this->input_gaji_pokok) + $this->input_bonus  > $this->input_hutang ) . '. Berhasil diinput' );
		return redirect('pengeluarans/bayardoker')->withPesan($pesan)->withPrint($this->bayar->id);
    }
    public function bayardokter($id){
        $staf = Staf::find($id);
        return view('bayardokter', compact('staf'));
    }
    public function bayardokterdetail(){
        $tanggal_mulai = Input::get('tanggal_mulai');
        $tanggal_akhir = Input::get('tanggal_akhir');
		$query = "select ";
		$query .= "p.tanggal as tanggal, ";
		$query .= "st.nama as nama_staf, ";
		$query .= "ps.id as pasien_id, ";
		$query .= "ps.nama as nama, ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "tunai, ";
		$query .= "piutang, ";
		$query .= "nilai ";
		$query .= "from jurnal_umums as ju ";
		$query .= "join coas as co on co.id=ju.coa_id ";
		$query .= "join periksas as p on p.id=ju.jurnalable_id ";
		$query .= "join stafs as st on st.id= p.staf_id ";
		$query .= "join pasiens as ps on ps.id=p.pasien_id ";
		$query .= "join asuransis as asu on asu.id=p.asuransi_id ";
		$query .= "where jurnalable_type='App\\\Models\\\Periksa' ";
		$query .= "and p.staf_id='{$id}' ";
		$query .= "and co.kode_coa = 200001 ";
		$query .= "AND ju.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "where date(p.tanggal) between '{$tanggal_mulai}' and '{$tanggal_akhir}' ";
        $hutangs = DB::select($query);
        $total = 0;
        foreach ($hutangs as $hutang) {
            $total += $hutang->nilai;
        }
        return view('bayardokterdetail', compact('hutangs', 'total'));
    }
	private function gajiBrutoBulanIniByModel($bayar){
		if (isset( $bayar->pph21s->pph21 )) {
			$pph21 = $bayar->pph21s->pph21;
		} else {
			$pph21 = 0;
		}
		$data = [
			'id'                => $bayar->id,
			'tanggal_dibayar'   => $bayar->tanggal_dibayar->format('Y-m-d'),
			'gaji_bruto'        => $bayar->gaji_pokok + $bayar->bonus,
			'pph21'             => $pph21
		];
		return $data;
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function pph21Data()
	{
		return [
				'pph21able_id'                   => $this->bayar->id,
				'pph21able_type'                 =>  'App\\Models\\BayarGaji',
				'pph21'                          => $this->perhitunganPph_ini['pph21'],
				'menikah'                        => $this->staf->menikah,
				'punya_npwp'                     => $this->perhitunganPph_ini['punya_npwp'],
				'jumlah_anak'                    => $this->staf->jumlah_anak,
				'biaya_jabatan'                  => $this->perhitunganPph_ini['biaya_jabatan'],
				'ptkp_dasar'                     => $this->perhitunganPph_ini['ptkp_dasar'],
				'ptkp_setahun'                   => $this->perhitunganPph_ini['ptkp_setahun'],
				'gaji_netto'                     => $this->perhitunganPph_ini['gaji_netto'],
				'gaji_bruto'                     => Yoga::clean($this->input_gaji_pokok)  + $this->input_bonus,
				'penghasilan_kena_pajak_setahun' => $this->perhitunganPph_ini['penghasilan_kena_pajak_setahun'],
				'potongan5persen_setahun'        => $this->perhitunganPph_ini['potongan5persen_setahun'],
				'potongan15persen_setahun'       => $this->perhitunganPph_ini['potongan15persen_setahun'],
				'potongan25persen_setahun'       => $this->perhitunganPph_ini['potongan25persen_setahun'],
				'potongan30persen_setahun'       => $this->perhitunganPph_ini['potongan30persen_setahun'],
				'potongan35persen_setahun'       => $this->perhitunganPph_ini['potongan35persen_setahun'],
				'ikhtisar_gaji_bruto'           => json_encode($this->gaji_bruto_bulan_ini),
				'pph21_setahun'                  => $this->perhitunganPph_ini['pph21_setahun']
			];
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function query($param)
	{
		$query  = "SELECT ";
		$query .= "bgj.tanggal_dibayar as tanggal_dibayar, ";
		$query .= "stf.nama as nama_staf, ";
		$query .= "bgj.mulai as mulai, ";
		$query .= "bgj.gaji_pokok as gaji_pokok, ";
		$query .= "bgj.bonus as bonus, ";
		$query .= "bgj.akhir as akhir, ";
		$query .= "bgj.gaji_pokok + bgj.bonus as nilai, ";
		$query .= "bgj.id  as id, ";
		$query .= "pph.pph21  as pph21, ";
		$query .= "pph.pph21able_type  as pph21_type ";
		$query .= "FROM bayar_gajis as bgj ";
		$query .= "JOIN stafs as stf on stf.id = bgj.staf_id ";
		$query .= "LEFT JOIN pph21s as pph on pph.pph21able_id = bgj.id ";
		$query .= "WHERE {$param} ";
		$query .= "AND (pph.pph21able_type = 'App\\\\\Models\\\\\BayarGaji' ";
		$query .= "AND bgj.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "OR pph.pph21able_type is null) ";
		$query .= "ORDER BY id desc ";
		$query .= "LIMIT 30";
		return DB::select($query);
		
	}
	private function prepContainerGaji()
	{
	   $container_gaji              = $this->input_container_gaji;
	   $container_gaji              = json_decode($container_gaji, true);
	   $bayar_gajis_container       = [];
	   $this->normalisasiTanggal();
	   return $container_gaji;
	}

	private function normalisasiTanggal()
	{
	   $this->input_bulan           = Yoga::blnPrep( $this->input_bulan );
	}
	
	private function sisaHutangBonus()
	{
		$coa_id_200002 = Coa::where('kode_coa', '200002')->first()->id;
		$jus = JurnalUmum::where('coa_id', $coa_id_200002 ) // coa_id 200002 adalah hutang kepada asisten dokter
		   ->where('debit', '0')
		   ->where('created_at', 'like', $this->input_bulan . '%')
		   ->get();// hitung total hutang kepada asisten dokter
		$total_bonus = 0;
		foreach ($jus as $ju) {
		   $total_bonus += $ju->nilai;
		}
		$jus = JurnalUmum::where('coa_id', $coa_id_200002)
		   ->where('debit', '1')
		   ->where('created_at', 'like', $this->input_bulan . '%')
		   ->get(); // hitung total hutang kepada asisten dokter yang sudah dibayar

		$total_bonus_sudah_dibayar = 0;
		foreach ($jus as $ju) {
		   $total_bonus_sudah_dibayar += $ju->nilai;
		}

		//return $total_bonus_sudah_dibayar . ' total bonys sudah dibayar';
		return $total_bonus - $total_bonus_sudah_dibayar;
	}
	private function pph21setahun( $penghasilan_kena_pajak ){
		$potongan5persen                      = 0;
		$potongan15persen                     = 0;
		$potongan15persen1                    = 0;
		$potongan15persen2                    = 0;
		$potongan15persen3                    = 0;
		$potongan25persen                     = 0;
		$potongan30persen                     = 0;
		$potongan35persen                     = 0;
		if ( $penghasilan_kena_pajak         <= 60000000) {
			$potongan5persen                  = $penghasilan_kena_pajak * 0.05;
		} else if(  $penghasilan_kena_pajak  <= 250000000 ){
			$potongan5persen                  = 60000000 * 0.05;
			$potongan15persen                += ( $penghasilan_kena_pajak - 60000000 ) * 0.15;
			$potongan15persen1               += ( $penghasilan_kena_pajak - 60000000 ) * 0.15;
		} else if(   $penghasilan_kena_pajak <= 500000000  ){
			$potongan5persen                  = 60000000 * 0.05;
			$potongan15persen                += 190000000 * 0.15;
			$potongan15persen2               += ( $penghasilan_kena_pajak - 60000000 ) * 0.15;
			$potongan25persen                += ( $penghasilan_kena_pajak - 250000000 ) * 0.25;
		} else if(    $penghasilan_kena_pajak <= 5000000000   ){
			$potongan5persen                  = 60000000 * 0.05;
			$potongan15persen                += 190000000 * 0.15;
			$potongan15persen3               += ( $penghasilan_kena_pajak - 60000000 ) * 0.15;
			$potongan25persen                += 250000000 * 0.25;
			$potongan30persen                += ( $penghasilan_kena_pajak - 500000000 ) * 0.30;
		} else if(    $penghasilan_kena_pajak > 5000000000   ){
			$potongan5persen                  = 60000000 * 0.05;
			$potongan15persen                += 190000000 * 0.15;
			$potongan15persen3               += ( $penghasilan_kena_pajak - 60000000 ) * 0.15;
			$potongan25persen                += 250000000 * 0.25;
			$potongan30persen                += 4500000000 * 0.30;
			$potongan35persen                += ( $penghasilan_kena_pajak - 5000000000 ) * 0.30;
		}
		$pph21setahun                         = $potongan5persen + $potongan15persen + $potongan25persen + $potongan30persen;
		if ( $pph21setahun < 0 ) {
			$pph21setahun                     = 0;
		}
		if ( $potongan5persen < 0 ) {
			$potongan5persen                  = 0;
		}
		if ( $potongan15persen < 0 ) {
			$potongan15persen                 = 0;
		}
		if ( $potongan25persen < 0 ) {
			$potongan25persen                 = 0;
		}
		if ( $potongan30persen < 0 ) {
			$potongan30persen                 = 0;
		}
		if ( $potongan35persen < 0 ) {
			$potongan35persen                 = 0;
		}
		return [
			'potongan15persen1' => $potongan15persen1,
			'potongan15persen2' => $potongan15persen2,
			'potongan15persen3' => $potongan15persen3,
			'pph21_setahun'     => $pph21setahun,
			'potongan5persen'   => $potongan5persen,
			'potongan15persen'  => $potongan15persen,
			'potongan25persen'  => $potongan25persen,
			'potongan30persen'  => $potongan30persen,
			'potongan35persen'  => $potongan35persen
		];
	}
	private function perhitunganPtkp($ptkp){
		if ($this->staf->jumlah_anak > 3) {
			$jumlah_anak_ptkp                 = 3;
		} else {
			$jumlah_anak_ptkp                 = $this->staf->jumlah_anak;
		}
		if ( $this->staf->jenis_kelamin                  == 0 ) {
			return $ptkp;
		} else {
			return $ptkp + $ptkp/12*$this->staf->menikah + $ptkp/12*$jumlah_anak_ptkp;
		}
	}
	private function parameterPtkp($tahun_pembayaran, $model, $mulai_parameter){
		$menikah             = $this->staf->menikah;
		$jumlah_anak         = $this->staf->jumlah_anak;

		try {
			$bagi_gigis      = $model::where($mulai_parameter, 'like',  $tahun_pembayaran . '%')
										->where('staf_id', $this->staf->id)
										->firstOrFail();
			if ( isset($bagi_gigis->menikah) ) {
				$menikah     = $bagi_gigis->menikah;
			}
			if ( isset($bagi_gigis->jumlah_anak) ) {
				$jumlah_anak = $bagi_gigis->jumlah_anak;
			}
			return $bagi_gigis;
		} catch (\Exception $e) {
		}

		return [
			'menikah' => $menikah,
			'jumlah_anak' => $jumlah_anak,
		];
	}
	public function pph21($total_gaji_bulan_ini, $total_pph_bulan_ini, $ptkp){

		 $pph21                  = 0;
		 $total_ptkp             = 0;
		 $biaya_jabatan          = 0;
		 $potongan5persen        = 0;
		 $potongan15persen       = 0;
		 $gaji_netto             = 0;
		 $gaji_netto_setahun     = 0;
		 $potongan25persen       = 0;
		 $potongan30persen       = 0;
		 $penghasilan_kena_pajak = 0;
		 $faktor_kali_pph        = 0;
		 $pph21_setahun          = 0;

		//jika total gaji bulan ini melebihi ptkp
		if ( $total_gaji_bulan_ini > $ptkp ) {
		   // biaya jabatan = 5% x gaji bulan ini;
			$biaya_jabatan      = (int)$total_gaji_bulan_ini * 0.05;
		   // biaya jabatan maksimal yang diperkenankan adalah 500rb;

			if ($biaya_jabatan > 500000) {
				$biaya_jabatan = 500000;
			}
		   // gaji netto adalah gaji yang diterima bulan ini dikurangi biaya jabatan
			/* dd( '$gaji_netto, $total_gaji_bulan_ini, $biaya_jabatan' , $gaji_netto, $total_gaji_bulan_ini, $biaya_jabatan ); */
			$gaji_netto         = $total_gaji_bulan_ini - $biaya_jabatan;
			$gaji_netto_setahun = $gaji_netto * 12;
			// total ptkp per tahun adalah ptkp ( 12 (bulan) + status pernikahan ( 1 bila menikah, 0 bila tidak menikah ) + jumlah anak );
			$total_ptkp         = 12 * $this->perhitunganPtkp($ptkp);
			//penghasilan kena pajak adalah gaji netto setahun dikurangi ptkp, ini yang akan diberlakukan tarif pph21
			$penghasilan_kena_pajak = $gaji_netto_setahun - $total_ptkp;

			// pengenaan tarif pph
			// 
			//WP dengan penghasilan tahunan sampai dengan Rp 50 juta adalah 5%
			//WP dengan penghasilan tahunan di atas Rp 50 juta - Rp 250 juta adalah 15%
			//WP dengan penghasilan tahunan di atas Rp 250 juta - Rp 500 juta adalah 25%
			//WP dengan penghasilan tahunan di atas Rp 500 juta adalah 30%
			$pph21_setahun_ini = $this->pph21setahun( $penghasilan_kena_pajak );
			$pph21_setahun     = $pph21_setahun_ini['pph21_setahun'];
			$potongan5persen   = $pph21_setahun_ini['potongan5persen'];
			$potongan15persen1 = $pph21_setahun_ini['potongan15persen1'];
			$potongan15persen2 = $pph21_setahun_ini['potongan15persen2'];
			$potongan15persen3 = $pph21_setahun_ini['potongan15persen3'];
			$potongan15persen  = $pph21_setahun_ini['potongan15persen'];
			$potongan25persen  = $pph21_setahun_ini['potongan25persen'];
			$potongan30persen  = $pph21_setahun_ini['potongan30persen'];
			$potongan35persen  = $pph21_setahun_ini['potongan35persen'];
			//Untuk Wajib Pajak yang tidak memiliki NPWP, dikenai tarif pph 21 sebesar 20% lebih tinggi dari mereka yang memiliki NPWP.
			$faktor_kali_pph              = 1;
			if (empty(trim( $this->staf->npwp ))) {
				$faktor_kali_pph          = 1.2;
			}
			$pph21_setahun                 = $pph21_setahun * $faktor_kali_pph;
			//pph21 yang dibayarkan bulan ini dibagi 12 dari pph21 setahun dikurangi pph21 yang sudah dibayarkan bulan ini
			$pph21                        = ( $pph21_setahun / 12 ) - $total_pph_bulan_ini;
		}


		if ( empty( $this->staf->npwp ) ) {
			$punya_npwp = 0;
		} else {
			$punya_npwp = 1;
		}


		return [
		   'ptkp_dasar'                     => $ptkp,
		   'ptkp_setahun'                   => $total_ptkp,
		   'total_gaji_bulan_ini'           => $total_gaji_bulan_ini,
		   'biaya_jabatan'                  => $biaya_jabatan,
		   'total_ptkp'                     => $total_ptkp,
		   'penghasilan_kena_pajak_setahun' => $penghasilan_kena_pajak,
		   'potongan5persen_setahun'        => $potongan5persen,
		   'potongan15persen_setahun'       => $potongan15persen,
		   'potongan25persen_setahun'       => $potongan25persen,
		   'potongan30persen_setahun'       => $potongan30persen,
		   'potongan35persen_setahun'       => $potongan35persen,
		   'pph21_setahun'                  => $pph21_setahun,
		   'punya_npwp'                     => $punya_npwp,
		   'pph21_setahun'                  => $pph21_setahun,
		   'gaji_netto'                     => $gaji_netto,
		   'gaji_netto_setahun'             => $gaji_netto_setahun,
		   'pph21'                          => $pph21
		];
	}
    private function total($mulai, $akhir){

        $coa_id200001 = Coa::where('kode_coa', '200001')->first()->id;
		$id = $this->staf->id;
		$query = "select ";
		$query .= "p.id as periksa_id, ";
		$query .= "p.tanggal as tanggal, ";
		$query .= "st.nama as nama_staf, ";
		$query .= "ps.id as pasien_id, ";
		$query .= "ps.nama as nama, ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "tunai, ";
		$query .= "piutang, ";
		$query .= "nilai ";
		$query .= " from ";
		$query .= "jurnal_umums as ju ";
		$query .= "join periksas as p on p.id=ju.jurnalable_id ";
		$query .= "join stafs as st on st.id= p.staf_id ";
		$query .= "join pasiens as ps on ps.id=p.pasien_id ";
		$query .= "join asuransis as asu on asu.id=p.asuransi_id ";
		$query .= "where jurnalable_type='App\\\Models\\\Periksa' ";
		$query .= "and p.staf_id='{$id}' ";
		$query .= "and ju.coa_id= " . $coa_id200001 . " "; //hutang kepada dokter
		$query .= "AND ju.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and ( date(p.created_at) between '{$mulai}' and '{$akhir}') ";
        $total = 0;

		

        $hutangs = DB::select($query);
        foreach ($hutangs as $hutang) {
            $total += $hutang->nilai;
        }
        return $total;
    }
	public function inputBayarGajiDanPph(){

		$this->staf              = Staf::find( $this->input_staf_id );
		$carbon_mulai            = Carbon::createFromFormat('d-m-Y', $this->input_tanggal_dibayar);
		$bayar_dokters_bulan_ini = BayarGaji::where('staf_id', $this->input_staf_id)
									->where('mulai', 'like', $carbon_mulai->format('Y-m') . '%' )
								    ->get();
		$total_gaji_bulan_ini    = Yoga::clean($this->input_gaji_pokok) + $this->input_bonus;
		$total_pph_bulan_ini     = 0;

		foreach ($bayar_dokters_bulan_ini as $bayar_dokter) {
			$total_gaji_bulan_ini += $bayar_dokter->gaji_pokok + $bayar_dokter->bonus;
			if (isset($bayar_dokter->pph21s->pph21)) {
				$pph21_ini = $bayar_dokter->pph21s->pph21;
			} else {
				$pph21_ini = 0;
			}
			$total_pph_bulan_ini          += $pph21_ini;
			$this->gaji_bruto_bulan_ini[] = $this->gajiBrutoBulanIniByModel($bayar_dokter);
		}
		$ptkp               = Config::where('config_variable', 'Penghasilan Tidak Kena Pajak')->first()->value; // penghasilann tidak kena pajak
	    $this->perhitunganPph_ini = $this->pph21($total_gaji_bulan_ini, $total_pph_bulan_ini, $ptkp);
		$bayar_dokters      = [];
		$pph                = [];
		$jurnals            = [];
		$bayar = BayarGaji::create([
			'staf_id'         => $this->input_staf_id,
			'petugas_id'      => $this->input_petugas_id,
			'gaji_pokok'      => Yoga::clean($this->input_gaji_pokok),
			'bonus'           => $this->input_bonus,
			'hutang'          => $this->input_hutang,
			'mulai'           => $this->input_mulai ,
			'akhir'           => $this->input_akhir ,
			'tanggal_dibayar' => Carbon::createFromFormat('d-m-Y', $this->input_tanggal_dibayar)->format('Y-m-d'),
			'sumber_uang_id'  => $this->input_sumber_uang_id
		]);
		$this->gaji_bruto_bulan_ini[] = [
			'id'              => $bayar->id,
			'tanggal_dibayar' => Carbon::createFromFormat('d-m-Y', $this->input_tanggal_dibayar)->format('Y-m-d'),
			'gaji_bruto'      => Yoga::clean($this->input_gaji_pokok) + $this->input_bonus,
			'pph21'           => round($this->perhitunganPph_ini['pph21'])
		];
		return $bayar;
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function collectJurnal() {
		$jurnals = [];
		$timestamp = date('Y-m-d H:i:s');

		$coa_id_200001 = Coa::where('kode_coa', '200001')->first()->id;
		$coa_id_200004 = Coa::where('kode_coa', '200004')->first()->id;
		$coa_id_50201 = Coa::where('kode_coa', '50201')->first()->id;
		if (Yoga::clean($this->input_gaji_pokok) + $this->input_bonus == $this->input_hutang) {
			$jurnals[]             = [
				'jurnalable_id'   => $this->bayar->id,
				'jurnalable_type' => 'App\Models\BayarGaji',
				'coa_id'          => $coa_id_200001, // Hutang Kepada Dokte,
				'debit'           => 1,
				'nilai'           => $this->input_hutang,
							'tenant_id'  => session()->get('tenant_id'),
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp
			];
			$jurnals[]             = [
				'jurnalable_id'   => $this->bayar->id,
				'jurnalable_type' => 'App\Models\BayarGaji',
				'coa_id'          => $this->input_sumber_uang_id,
				'debit'           => 0,
				'nilai'           => Yoga::clean($this->input_gaji_pokok) + $this->input_bonus  > $this->input_hutang - $this->perhitunganPph_ini['pph21'],
							'tenant_id'  => session()->get('tenant_id'),
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp
			];
			if ( $this->perhitunganPph_ini['pph21'] > 0 ) {
				$jurnals[]             = [
                    'jurnalable_id'   => $this->bayar->id,
                    'jurnalable_type' => 'App\Models\BayarGaji',
                    'coa_id'          => $coa_id_200004, // Hutang pph21
                    'debit'           => 0,
                    'nilai'           => $this->perhitunganPph_ini['pph21'],
                    'tenant_id'       => session()->get('tenant_id'),
                    'created_at'      => $timestamp,
                    'updated_at'      => $timestamp
				];
			}
		} else if(Yoga::clean($this->input_gaji_pokok) + $this->input_bonus  > $this->input_hutang){
			//Create Jurnal Umum untuk hutang saja
			$jurnals[]             = [
                'jurnalable_id'   => $this->bayar->id,
                'jurnalable_type' => 'App\Models\BayarGaji',
                'coa_id'          => $coa_id_200001, // Hutang Kepada Dokte,
                'debit'           => 1,
                'nilai'           => $this->input_hutang,
                'tenant_id'       => session()->get('tenant_id'),
                'created_at'      => $timestamp,
                'updated_at'      => $timestamp
			];
			$jurnals[]             = [
                'jurnalable_id'   => $this->bayar->id,
                'jurnalable_type' => 'App\Models\BayarGaji',
                'coa_id'          => $coa_id_50201, // B. Produksi Jasa Dokter,
                'debit'           => 1,
                'nilai'           => Yoga::clean($this->input_gaji_pokok) + $this->input_bonus - $this->input_hutang,
                'tenant_id'       => session()->get('tenant_id'),
                'created_at'      => $timestamp,
                'updated_at'      => $timestamp
			];
			$jurnals[]             = [
                'jurnalable_id'   => $this->bayar->id,
                'jurnalable_type' => 'App\Models\BayarGaji',
                'coa_id'          => $this->input_sumber_uang_id,
                'debit'           => 0,
                'nilai'           => Yoga::clean($this->input_gaji_pokok) + $this->input_bonus - $this->perhitunganPph_ini['pph21'],
                'tenant_id'       => session()->get('tenant_id'),
                'created_at'      => $timestamp,
                'updated_at'      => $timestamp
			];
			if ( $this->perhitunganPph_ini['pph21'] > 0 ) {
				$jurnals[]             = [
                    'jurnalable_id'   => $this->bayar->id,
                    'jurnalable_type' => 'App\Models\BayarGaji',
                    'coa_id'          => $coa_id_200004, // Hutang pph21
                    'debit'           => 0,
                    'nilai'           => $this->perhitunganPph_ini['pph21'],
                    'tenant_id'       => session()->get('tenant_id'),
                    'created_at'      => $timestamp,
                    'updated_at'      => $timestamp
				];
			}
			//Jurnal Umum untuk sisa dengan b. operasional jasa dokter
		} else if(Yoga::clean($this->input_gaji_pokok) + $this->input_bonus  < $this->input_hutang){
			//Jurnal Umum untuk sisa dengan b. operasional jasa dokter
			$jurnals[]             = [
                'jurnalable_id'   => $this->bayar->id,
                'jurnalable_type' => 'App\Models\BayarGaji',
                'coa_id'          => $coa_id_200001, // Hutang kepada dokte,
                'debit'           => 1,
                'nilai'           => $this->input_hutang,
                'tenant_id'       => session()->get('tenant_id'),
                'created_at'      => $timestamp,
                'updated_at'      => $timestamp
			];
			$jurnals[]             = [
                'jurnalable_id'   => $this->bayar->id,
                'jurnalable_type' => 'App\Models\BayarGaji',
                'coa_id'          => $coa_id_50201, // B. Produksi Jasa Dokte,
                'debit'           => 0,
                'nilai'           => $this->input_hutang- Yoga::clean($this->input_gaji_pokok) + $this->input_bonus,
                'tenant_id'       => session()->get('tenant_id'),
                'created_at'      => $timestamp,
                'updated_at'      => $timestamp
			];
			//end
			$jurnals[]             = [
                'jurnalable_id'   => $this->bayar->id,
                'jurnalable_type' => 'App\Models\BayarGaji',
                'coa_id'          => $this->input_sumber_uang_id,
                'debit'           => 0,
                'nilai'           => Yoga::clean($this->input_gaji_pokok) + $this->input_bonus - $this->perhitunganPph_ini['pph21'],
                'tenant_id'       => session()->get('tenant_id'),
                'created_at'      => $timestamp,
                'updated_at'      => $timestamp
			];
			if ( $this->perhitunganPph_ini['pph21'] > 0 ) {
				$jurnals[]             = [
                    'jurnalable_id'   => $this->bayar->id,
                    'jurnalable_type' => 'App\Models\BayarGaji',
                    'coa_id'          => $coa_id_200004, // Hutang pph21
                    'debit'           => 0,
                    'nilai'           => $this->perhitunganPph_ini['pph21'],
                    'tenant_id'       => session()->get('tenant_id'),
                    'created_at'      => $timestamp,
                    'updated_at'      => $timestamp
				];
			}
		}
		return $jurnals;
	}

    public function destroy($id){
        $bayar_gaji = BayarGaji::find( $id );
        $bayar_gaji->pph21s()->delete();
        $bayar_gaji->jurnals()->delete();
        $nama_staf = $bayar_gaji->staf->nama;
        $bayar_gaji->delete();
        $pesan = Yoga::suksesFlash('Pembayaran gaji ' . $nama_staf . ' Berhasil dihapus');
        return redirect()->back()->withPesan($pesan);
    }
    public function pembayaran_gaji_ajax(){
		$data          = $this->queryPembayaranGaji();
		$count         = $this->queryPembayaranGaji(true);
		$pages = ceil( $count/ Input::get('displayed_rows') );
		return [
			'data'  => $data,
			'pages' => $pages,
			'key'   => Input::get('key'),
			'rows'  => $count
		];
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function queryPembayaranGaji($count = false){
        $gaji_netto     = Input::get('gaji_netto');
        $gaji_pokok     = Input::get('gaji_pokok');
        $staf_id        = Input::get('staf_id');
        $bonus          = Input::get('bonus');
        $pph21          = Input::get('pph21');
        $displayed_rows = Input::get('displayed_rows');
        $key            = Input::get('key');
		$pass           = $key * $displayed_rows;

		$query  = "SELECT ";
		if (!$count) {
            $query .= "bgj.tanggal_dibayar as tanggal_dibayar, ";
            $query .= "stf.nama as nama_staf, ";
            $query .= "bgj.mulai as mulai, ";
            $query .= "bgj.gaji_pokok as gaji_pokok, ";
            $query .= "bgj.bonus as bonus, ";
            $query .= "bgj.akhir as akhir, ";
            $query .= "bgj.gaji_pokok + bgj.bonus as nilai, ";
            $query .= "bgj.id  as id, ";
            $query .= "pph.pph21  as pph21, ";
            $query .= "pph.pph21able_type  as pph21_type ";
		} else {
			$query .= "count(bgj.id) as jumlah ";
		}
		$query .= "FROM bayar_gajis as bgj ";
		$query .= "JOIN stafs as stf on stf.id = bgj.staf_id ";
		$query .= "LEFT JOIN pph21s as pph on pph.pph21able_id = bgj.id ";
		$query .= "WHERE '' = '' ";

        if (!empty( $staf_id )) {
            $query .= "AND bgj.staf_id = {$staf_id} ";
        }
        if (!empty( $gaji_pokok )) {
            $query .= "AND gaji_pokok like '{$gaji_pokok}%' ";
        }
        if (!empty( $bonus )) {
            $query .= "AND bonus like like '{$bonus}%' ";
        }
        if (!empty( $pph21 )) {
            $query .= "AND bonus like '{$pph21}%' ";
        }
        if (!empty( $gaji_netto )) {
            $query .= "AND gaji_pokok + bonus - pph21 like '{$gaji_netto}%' ";
        }

		$query .= "AND (pph.pph21able_type = 'App\\\\\Models\\\\\BayarGaji' ";
		$query .= "AND bgj.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "OR pph.pph21able_type is null) ";
		$query .= "ORDER BY bgj.id desc ";

		if (!$count) {
			$query .= " LIMIT {$pass}, {$displayed_rows}";
		}
		$query .= ";";

        if (!empty( $displayed_rows )) {
            $query_result = DB::select($query);
            if (!$count) {
                return $query_result;
            } else {
                return $query_result[0]->jumlah;
            }
        }
    }
    
    
}
