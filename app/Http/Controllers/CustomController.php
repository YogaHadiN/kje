<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Input;
use Auth;
use Image;
use DB;
use Storage;
use App\Http\Requests;
use App\Models\Classes\Yoga;
use App\Models\Antrian;
use App\Models\KlaimGdpBpjs;
use App\Models\Asuransi;
use App\Models\AntrianKasir;
use App\Models\AntrianApotek;
use App\Models\AntrianFarmasi;
use App\Models\Perbaikantrx;
use App\Models\GambarPeriksa;
use App\Models\Keberatan;
use App\Models\BukanPeserta;
use App\Http\Controllers\PasiensAjaxController;
use App\Http\Controllers\AntrianPolisController;
use App\Models\Formula;
use App\Models\Merek;
use App\Models\Rak;
use App\Models\KunjunganSakit;
use App\Models\BahanHabisPakai;
use App\Models\PengantarPasien;
use App\Models\JenisTarif;
use App\Models\Periksa;
use App\Models\Rujukan;
use App\Models\Pasien;
use App\Models\AntrianPeriksa;
use App\Models\Tarif;
use App\Models\Monitor;
use App\Models\Dispensing;
use App\Models\Point;
use App\Models\SmsJangan;
use App\Models\Sms;
use App\Models\TransaksiPeriksa;
use App\Models\JurnalUmum;
use App\Models\Fakturbeli;
use App\Models\Pembelian;
use App\Models\Receipt;

class CustomController extends Controller
{

  public $warna;
  public function __construct()
    {
        $this->middleware('belum_masuk_kasir', ['only' => ['kembali2']]);
        $this->middleware('selesai', ['only' => ['kembali','kembali2', 'kembali3']]);
		$this->warna =[
			'primary',
			'info',
			'warning',
			'danger'
		];
    }
	public function create_rak($id)
	{
		$formula = Formula::find($id);
		$fornas = Yoga::fornas();
		$alternatif_fornas = array('0' => '- Pilih Merek -') + Merek::pluck('merek', 'id')->all();

		return view('raks.create')
			->withFormula($formula)
			->with('alternatif_fornas', $alternatif_fornas)
			->withFornas($fornas);
	}

	public function create_merek($id){
		$rak = Rak::find($id);

		return view('mereks.create')
				->withRak($rak);
	}

	public function updtrf(){

		$asuransi_id    = Input::get('asuransi_id');
		$jenis_tarif_id = Input::get('jenis_tarif_id');
		$tarif          = Tarif::where('jenis_tarif_id', $jenis_tarif_id)->where('asuransi_id', $asuransi_id)->first();

		$tarif->biaya            = Input::get('biaya');
		$tarif->tipe_tindakan_id = Input::get('tipe_tindakan_id');
		$tarif->jasa_dokter      = Input::get('jasa_dokter');
		$tarif->save();

		$input_bhps = [];
		$delete_bhps = [];

		$bhps = json_decode(Input::get('bhp_items'), true);
		$timestamps = date('Y-m-d H:i:s');
		foreach ($bhps as $bhp) {
			if (!isset($bhp['id'])) {
				$input_bhps[] = [
					'merek_id'       => $bhp['merek_id'],
					'jumlah'         => $bhp['jumlah'],
					'jenis_tarif_id' => $jenis_tarif_id,
					'created_at'     => $timestamps,
					'updated_at'     => $timestamps
				];
			}
		}

		foreach (JenisTarif::find($jenis_tarif_id)->bhp as $bp) {
			$hapus = true;
			foreach ($bhps as $bhp) {
				if (isset($bhp['id']) && $bp->id == $bhp['id']) {
					$hapus = false;
					break;
				}
			}
			if ($hapus) {
				$delete_bhps[] = $bp->id;
			}
		}
		BahanHabisPakai::destroy($delete_bhps);
		BahanHabisPakai::insert($input_bhps);

		$jt                           = JenisTarif::find($jenis_tarif_id);
		$jt->jenis_tarif              = Input::get('jenis_tarif');
		$jt->tipe_laporan_admedika_id = Input::get('tipe_laporan_admedika_id');
		$jt->murni_jasa_dokter        = Input::get('murni_jasa_dokter');
		$jt->save();

		if($jt->save() && $tarif->save()){
            $kembali = [
                'id'             => $tarif->id,
                'jenis_tarif_id' => $jt->id
            ];
			return $jenis_tarif_id;
		} else {
			return '0';
		}

	}

	public function kembali($id){
		dd( 'kembali' );
		$periksa = Periksa::find($id);
		if ($periksa->lewat_kasir2 == '1') {
		 	$pesan = Yoga::gagalFlash('Tidak bisa dilakukan karena pasien sudah disubmit sebelumnya');
			return redirect()->back()->withPesan($pesan);
		}
		$periksa = $this->formKembali($periksa);
		return redirect()->back()->withPesan(Yoga::suksesFlash('<strong>' . $periksa->pasien_id . ' - ' . $periksa->pasien->nama . ' </strong>Berhasil dikembalikan ke Ruang Periksa <strong>Poli ' . ucwords(strtolower($periksa->poli)) . '</strong>'));

	}
	public function kembali2(Request $request, $id){
		$periksa = $this->formKembali($request->periksa);
		return redirect()->back()->withPesan(Yoga::suksesFlash('<strong>' . $periksa->pasien->id . ' - ' . $periksa->pasien->nama . ' </strong>Berhasil dikembalikan ke Ruang Periksa <strong>Poli ' . ucwords(strtolower($periksa->poli)) . '</strong>'));
	}

	public function kembali3($id){
		$periksa = Periksa::find($id);
		if ($periksa->lewat_kasir2 == '1') {
		 	$pesan = Yoga::gagalFlash('Tidak bisa dilakukan karena pasien sudah disubmit sebelumnya');
			return redirect()->back()->withPesan($pesan);
		}
		$periksa->lewat_poli   = '1';
		$periksa->lewat_kasir  = '0';
		$periksa->save();

		$pasien = Pasien::find($periksa->pasien_id);

		return redirect()->back()->withPesan(Yoga::suksesFlash('<strong>' . $pasien->id . ' - ' . $pasien->nama . ' </strong>Berhasil dikembalikan ke <strong>Apotek</strong>'));

	}

	public function survey($id){
        $periksa = Periksa::with('terapii.merek.rak')->where('id', $id)->first();
		$antriankasir =AntrianKasir::where('periksa_id', $id)->first();
		if (
			!isset($antriankasir)
		) {
            return redirect('antriankasirs')->withPesan( Yoga::gagalFlash('Pasien sedang diedit oleh dokter, mohon tunggu sampai selesai lalu ulangi lagi cek obat') );
		}

		$user                  = Auth::user();
		$user->surveyable_type = 'App\Models\AntrianKasir';
		$user->surveyable_id   = $antriankasir->id;
		$user->save();

		$sudah = false;
		$periksaBulanIni = Periksa::where('pasien_id', $periksa->pasien_id)->where('tanggal', 'like', date('Y-m') . '%')->where('asuransi_id', '32')->where('id', '<', $id)->get();
		foreach ($periksaBulanIni as $prx) {
			if(preg_match('/Gula Darah/',$prx->pemeriksaan_penunjang)){
				$sudah = true;
				break;				
			}
		}
   		$tindakans = [null => '- Pilih -'] + Tarif::where('asuransi_id', $periksa->asuransi_id)->with('jenisTarif')->get()->pluck('jenis_tarif_list', 'tarif_jual')->all();
   		$reseps     = Yoga::masukLagi($periksa->terapii);
   		$biayatotal = Yoga::biayaObatTotal($periksa->transaksi);

		$monitor = Monitor::find(1);

		// cek apakah ada diskon untuk tindakan tertentu
		$tindakanPeriksa  = $periksa->transaksi;
		$tindakanPeriksa  = json_decode( $tindakanPeriksa, true );
		$jenisTarifDiskon = [];

		foreach ($tindakanPeriksa as $t) {
			$jenisTarifDiskon[] = $t['jenis_tarif_id'];
		}

		$query  = "SELECT dc.id as discount_id, ";
		$query .= "dc.diskon_persen as persen, ";
		$query .= "dc.jenis_tarif_id as jenis_tarif_id ";
		$query .= "from discounts as dc ";
		$query .= "JOIN discount_asuransis as da ";
		$query .= "WHERE dc.jenis_tarif_id in (";
		$query .= $jenisTarifDiskon[0];
		foreach ($jenisTarifDiskon as $jt) {
			$query .=  ', ' . $jt;
		}
		$query .= ") AND da.asuransi_id = '" . $periksa->asuransi_id . "' ";
		$query .= "GROUP BY dc.id;";
		$data = DB::select($query);
		if ( count( $data )  > 0) {
			$insterted = [];
			foreach ($tindakanPeriksa as $k => $t) {
				foreach ($data as $ky => $d) {
					if ($d->jenis_tarif_id == $t['jenis_tarif_id']) {
						$inserted[] = [

							'jenis_tarif_id'        => '0',
							'jenis_tarif'           => 'Diskon ' . $t['jenis_tarif'] . ' '. $d->persen . ' %',
							'jenis_tarif_id_diskon' => $t['jenis_tarif_id'],
							'keterangan'            => 'Diskon ' . $t['jenis_tarif'] . ' '. $d->persen . ' %',
							'biaya'                 => -1 * abs( $d->persen * $t['biaya'] / 100 )

						];
					}
				}
			}
			foreach ($inserted as $i) {
				array_push($tindakanPeriksa, $i);
			}
		}
		$tindakanPeriksa = json_encode( $tindakanPeriksa, true ); 
        $dibayar = null;
        if ( $periksa->asuransi->tipe_asuransi== '4') {
        	$jasa_dokter = Tarif::where('asuransi_id', $periksa->asuransi_id)->where('jenis_tarif_id', '1')->first()->biaya;
        	$obat = Tarif::where('asuransi_id', $periksa->asuransi_id)->where('jenis_tarif_id', '9')->first()->biaya;
        	$dibayar = $jasa_dokter + $obat;
        }
		$warna = $this->warna;

		$asuransi_list = Asuransi::list();

		$pjx                  = new PasiensAjaxController;
		$pjx->input_pasien_id = $periksa->pasien_id;
		$prolanis_periksa_gdp = $pjx->statusCekGDSBulanIni() == 0 && $periksa->asuransi_id == '32' && $periksa->prolanis_dm == '1' ? true :false;

		return view('surveys.index', compact(
			'reseps',
			'warna',
			'prolanis_periksa_gdp',
			'asuransi_list',
			'periksa',
			'tindakanPeriksa',
			'sudah',
			'biayatotal',
			'dibayar',
			'monitor',
			'tindakans'
		));
	}
	public function survey_post(){
		$periksa_id               = Input::get('periksa_id');
		$nama_file_klaim_gdp_bpjs = $this->uploadKlaimGDP(  'klaim_gdp' , $periksa_id,'klaim_gdp_bpjs') ;

		if ( !is_null($nama_file_klaim_gdp_bpjs) ) {
			$Klaim             = new KlaimGdpBpjs;
			$Klaim->nama_file  = $nama_file_klaim_gdp_bpjs;
			$Klaim->periksa_id = $periksa_id;
			$Klaim->save();
		}

		if ( 
			JurnalUmum::where('jurnalable_type', 'App\Models\Periksa')
						->where('jurnalable_id', $periksa_id)
						->count() > 0
	   	) {
			AntrianKasir::where('periksa_id', $periksa_id)->delete();
            return redirect('antriankasirs')->withPesan( Yoga::gagalFlash('Pasien sudah selesai masuk kasir sebelumnya. Tidak perlu diinput ulang') );
			Sms::send(env("NO_HP_OWNER"),'Kejadian LAGI!!! Kasir input 2 kali!!! Tanyakan!!!' );
		}

		//get pasien dengan id tertentu
		$periksa = Periksa::with(
						'pasien', 
						'staf', 
						'asuransi', 
						'rujukan', 
						'terapii.merek.rak'
					)
					->where('id', Input::get('periksa_id') )
					->first();

		
		// Kembalikan jika pasien sudah tidak diperiksa lagi
		$antriankasir = AntrianKasir::where('periksa_id', $periksa->id)->first();
        if ( !isset($antriankasir) ) {
			$pesan =  Yoga::gagalFlash('Pasien atas nama <strong>' . $periksa->pasien->nama . '</strong> sudah pernah diinput sebelumnya <strong>TIDAK PERLU DIULANGI LAGI</strong>');
            return redirect('antriankasirs')->withPesan($pesan);
        }
		// Kita cek dulu apakah ada yang diedit dalam transaksi sebelum masuk kasir dan setelah masuk kasir
		//JIKA ADA KOREKSI DALAM transaksi, maka masukkan ke dalam tabel perbaikantrxs
		$tarif         = Input::get('tarif');
		$sebelum       = Input::get('sebelum');
		$sebelum_array = json_decode($sebelum, true);
		$tarif_array   = json_decode($tarif, true);
		//HILANGKAN elemen BHP dari tarif
		foreach ($sebelum_array as $key => $value) {
			if ($value['jenis_tarif'] == 'BHP') {
				array_splice($sebelum_array, $key, 1);
			}
		}

		$rak_updates               = [];
		$bukan_peserta_updates     = [];
		$rujukan_updates           = [];
		$perbaikans                = [];
		$points                    = [];
		$jurnals                   = [];
		$dispensings               = [];
		$transaksi_periksas        = [];
		$tindakan_periksas         = [];
		$receipts                  = [];
		$kunjungan_sakits          = [];
		$timestamp                 = $periksa->tanggal . ' 23:59:59';
		$last_dispensing_id        = Dispensing::orderBy('id', 'desc')->first()->id;
		$last_transaksi_periksa_id = TransaksiPeriksa::orderBy('id', 'desc')->first()->id;

		//HILANGKAN elemen BHP dari sebelum
		foreach ($tarif_array as $key => $value) {
			if ($value['jenis_tarif'] == 'BHP') {
				array_splice($tarif_array, $key, 1);
			}
		}
		$fix = false;
		//JIKA ADA KOREKSI DALAM transaksi, maka masukkan ke dalam tabel perbaikantrxs
		if (json_encode($sebelum_array) == json_encode($tarif_array)) {
		} else {
			$fix                   = true;
			$perbaikans[] = [
				'periksa_id' => Input::get('periksa_id'),
				'sebelum'    => Input::get('sebelum'),
				'created_at' => $timestamp,
				'updated_at' => $timestamp
			];
		}

		// Yoga::clean untuk menghilangkan Mata uang supaya bisa dalam bentuk integer
		$dibayar_pasien   = Yoga::clean(Input::get('dibayar_pasien'));
		$dibayar_asuransi = Yoga::clean(Input::get('dibayar_asuransi'));
		$pembayaran       = Yoga::clean(Input::get('pembayaran'));
		$kembalian        = Yoga::clean(Input::get('kembalian'));

		$periksa->tunai              = $dibayar_pasien;
		$periksa->piutang            = $dibayar_asuransi;
		$periksa->pembayaran         = $pembayaran;
		$periksa->kembalian          = $kembalian;
		$periksa->antrian_periksa_id = null;
		$periksa->transaksi          = $tarif;
		$periksa->nomor_asuransi     = $periksa->pasien->nomor_asuransi;

		if ($periksa->asuransi_id == 32 && !empty($periksa->keterangan)) {
			$periksa->keterangan = null;
		}
		//Jika pembayaran yang digunakan saat ini adalah bpjs dan pasien berada dalam list jangan sms, maka hapus list tersebut, karena
		//ternyata pasien tersebut sekarang aktif
		if ($periksa->asuransi_id == 32) {
			 $smsJangan = SmsJangan::where('pasien_id', $periksa->pasien_id)->get();
			if ($smsJangan->count() > 0) {
				SmsJangan::where('pasien_id', $periksa->pasien_id)->delete();
			}
		}
		$periksa->terapi          = $this->terapisBaru($periksa->terapii);
		$periksa->jam_terima_obat = date('H:i:s');
		// Jika ada rujukan untuk pasien ini, masukkan dalam rujukan
		if ($periksa->rujukan && Input::hasFile('image')) {
			$ps = new Pasien;
			$image = $ps->imageUpload('rjk', 'image', Input::get('periksa_id') );

			$rujukan_updates[] = [
				'collection'    => $periksa->rujukan,
				'updates' => [
					'image' => $image
				]
			];
		}

		$resep                 = $periksa->terapii;

		foreach ($resep as $key => $value) {
			$rak  = $value->merek->rak;
			$stok = $rak->stok - $value->jumlah;
			$rak_id = $rak->id;

			$rak_updates[] = [
				'collection' => $rak,
				'updates'    => [
					'stok'   => $stok
				]
			];
			$last_dispensing_id++; 
			$dispensings[] = [
				'id'               => $last_dispensing_id,
				'merek_id'         => $value->merek_id,
				'keluar'           => $value->jumlah,
				'dispensable_id'   => $value->id,
				'dispensable_type' => 'App\Models\Terapi',
				'tanggal'          => $periksa->tanggal,
				'created_at'       => $timestamp,
				'updated_at'       => $timestamp
			];
		}

		$mess                        = '';
		$bp                          = BukanPeserta::where('periksa_id',  Input::get('periksa_id') )->first();
		if ( $bp                    != null ) {
			$bukan_peserta_updates[] = [
				'collection'                 => $bp,
				'updates' => [
					'antrian_periksa_id' => null
				]
			];
		}
		$gammu_survey = false;
		if ( 
			$periksa->poli                                                  == 'estetika' &&
			Keberatan::where('no_telp', $periksa->pasien->no_telp)->first() == null &&
			$periksa->pasien->jangan_disms                                  == 0
		) {
			$gammu_survey = true;
		}
		
		$terapis           = $periksa->terapii;
		$biayaProduksiObat = 0;
		foreach ($terapis as $terapi) {
			$biayaProduksiObat += $terapi->harga_beli_satuan * $terapi->jumlah;
		}
		// Input jurnal umum kas di tangan bila tunai > 0
		if ($periksa->tunai>0) {
			$jurnals[] = [
				'jurnalable_id'   => $periksa->id,
				'jurnalable_type' => 'App\Models\Periksa',
				'coa_id'          => 110000, // Kas di tangan
				'debit'           => 1,
				'nilai'           => $periksa->tunai,
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp,
			];
		}
		// Input jurnal umum kas di tangan bila piutang > 0
		if ($periksa->piutang>0) {
			$jurnals[] = [
				'jurnalable_id'   => $periksa->id,
				'jurnalable_type' => 'App\Models\Periksa',
				'debit'           => 1,
				'coa_id'          => $periksa->asuransi->coa_id, // Piutang berdasarkan masing2 asuransi
				'nilai'           => $periksa->piutang,
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp,
			];
		}

		$transaksis    = $periksa->transaksi;
		$transaksis    = json_decode($transaksis, true);
		$adaJasaDokter = false;
		$feeDokter     = 0;

		$hutang_asisten_tindakan = 0;
		// cek dulu apakah ada diskon di transaksis
		//
		$diskonArray= [];
		$nilaiDiskon= 0;
		foreach ($transaksis as $t) {
			if ( $t['jenis_tarif_id'] == '0' ) {
				$diskonArray[] = $t;
				$nilaiDiskon += abs( $t['biaya'] );
			}
		}

		foreach ($transaksis as $k => $transaksi) {
			$adaBiaya = false;

			$last_transaksi_periksa_id++;
			$transaksi_periksas[] = [
				'id'             => $last_transaksi_periksa_id,
				'periksa_id'     => $periksa_id,
				'jenis_tarif_id' => $transaksi['jenis_tarif_id'],
				'biaya'          => $transaksi['biaya'],
				'keterangan_pemeriksaan'          => null,
				'created_at'     => $timestamp,
				'updated_at'     => $timestamp
			];
			if (isset( $transaksi['keterangan_tindakan'] )) {
				$transaksi_periksas[ count( $transaksi_periksas ) -1 ]['keterangan_pemeriksaan'] = $transaksi['keterangan_tindakan'];
			}

			if ( !($transaksi['jenis_tarif_id'] == '116' && $transaksi['biaya'] == 0) ) {
				$feeDokter += Tarif::where('asuransi_id', $periksa->asuransi_id)->where('jenis_tarif_id', $transaksi['jenis_tarif_id'])->first()->jasa_dokter;
			}

			$jenis_tarif = JenisTarif::with('bahanHabisPakai.merek.rak')->where('id', $transaksi['jenis_tarif_id'])->first();

			if ($transaksi['biaya'] > 0 && $transaksi['jenis_tarif_id'] != '0') { // jika biaya > 0 dan jenis_tarif_id bukan 0 (diskon)
				//cek apakah jenis_tarif ini ada diskon;
				// jika ada kurangi nilai di jurnal umum;
				$diskon = 0;
				foreach ($diskonArray as $d) {
					if ($d['jenis_tarif_id_diskon'] == $transaksi['jenis_tarif_id'] ) {
						$diskon = $d['biaya'];
						break;
					}
				}

				$jurnals[] = [
					'jurnalable_id'   => $periksa->id,
					'jurnalable_type' => 'App\Models\Periksa',
					'coa_id'          => $jenis_tarif->coa_id,
					'debit'           => 0,
					'nilai'           => $transaksi['biaya'] - abs( $diskon ),
					'created_at'      => $timestamp,
					'updated_at'      => $timestamp,
				];

				$adaBiaya = true;
			}

			if ($jenis_tarif->dengan_asisten == '1') {
				$hutang_asisten_tindakan += $this->biayaJasa($transaksi['jenis_tarif_id'], $transaksi['biaya']);
			}

			foreach ($jenis_tarif->bahanHabisPakai as $key => $bhp) {

				$rak  = $bhp->merek->rak;
				$stok = $rak->stok - $bhp->jumlah;

				$rak_updates[] = [
					'collection'   => $rak,
					'updates' => [
						'stok' => $stok
					]
				];

				$last_dispensing_id++;
				$dispensings[] = [
					'id'               => $last_dispensing_id,
					'merek_id'         => $bhp->merek_id,
					'keluar'           => $bhp->jumlah,
					'dispensable_id'   => $last_transaksi_periksa_id,
					'dispensable_type' => 'App\Models\TransaksiPeriksa',
					'tanggal'          => $periksa->tanggal,
					'created_at'       => $timestamp,
					'updated_at'       => $timestamp
				];
			}
			
			//Jika ada biaya untuk tindakan Nebulizer baik anak maupun dewasa, masukkan beban jasa dokter 
			if ($adaBiaya && ($transaksi['jenis_tarif_id'] == '102' || $transaksi['jenis_tarif_id'] == '103')) {
				$feeDokter += 3000;
			}
		}

		//Masukkan pembayaran ke dalam Transaksi
		if ($hutang_asisten_tindakan > 0) {
			$jurnals[] = [
				'jurnalable_id'   => $periksa->id,
				'jurnalable_type' => 'App\Models\Periksa',
				'coa_id'          => 50205, // Biaya Produksi : Bonus per pasien Jasa TIndakan untuk Asisten
				'debit'           => 1,
				'nilai'           => $hutang_asisten_tindakan,
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp,
			];
			$jurnals[] = [
				'jurnalable_id'   => $periksa->id,
				'jurnalable_type' => 'App\Models\Periksa',
				'coa_id'          => 200002, // Hutang Kepada Asisten Dokter
				'debit'           => 0,
				'nilai'           => $hutang_asisten_tindakan,
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp,
			];
		}
		//
		// Input hutang kepada dokter
		// 
		if ($feeDokter > 0 && $periksa->staf->gaji_tetap == 0 ) {
			$jurnals[] = [
				'jurnalable_id'   => $periksa->id,
				'jurnalable_type' => 'App\Models\Periksa',
				'coa_id'          => 50201, //Beban Jasa Dokter
				'debit'           => 1,
				'nilai'           => $feeDokter,
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp,
			];
			$jurnals[] = [
				'jurnalable_id'   => $periksa->id,
				'jurnalable_type' => 'App\Models\Periksa',
				'coa_id'          => 200001, // Hutang Kepada dokter
				'debit'           => 0,
				'nilai'           => $feeDokter,
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp,
			];
		}
		//
		// Input Transaksi ini untuk pengurangan persediaan obat tiap transaksi pasien
		//
		if ($biayaProduksiObat > 0) {
			$jurnals[] = [
				'jurnalable_id'   => $periksa->id,
				'jurnalable_type' => 'App\Models\Periksa',
				'coa_id'          => 50204, // Biaya Produksi : Obat
				'debit'           => 1,
				'nilai'           => $biayaProduksiObat,
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp,
			];
			$jurnals[] = [
				'jurnalable_id'   => $periksa->id,
				'jurnalable_type' => 'App\Models\Periksa',
				'coa_id'          => 112000, // Persediaan Obat
				'debit'           => 0,
				'nilai'           => $biayaProduksiObat,
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp,
			];
		}
		//INPUT points untuk tim bidan
		//jika tidak ada tekanan_dara, berat_badan, suhu, dan tingggi badan yang diisi, tidak ada point\
		if ($periksa->periksa_awal != '[]') {
			$arr = $periksa->periksa_awal;
			$arr = json_decode($arr, true);

			$tekanan_darah = $arr['tekanan_darah'];
			$berat_badan   = $arr['berat_badan'];
			$suhu          = $arr['suhu'];
			$tinggi_badan  = $arr['tinggi_badan'];
			$periksa_id    = $periksa->id;


			$points[]            = [
				'periksa_id'    => Yoga::returnNull($periksa_id),
				'tekanan_darah' => Yoga::returnNull($tekanan_darah),
				'berat_badan'   => Yoga::returnNull($berat_badan),
				'suhu'          => Yoga::returnNull($suhu),
				'tinggi_badan'  => Yoga::returnNull($tinggi_badan),
				'created_at'    => $timestamp,
				'updated_at'    => $timestamp,
			];
			$jurnals[] = [
				'jurnalable_id'   => $periksa->id,
				'jurnalable_type' => 'App\Models\Periksa',
				'coa_id'          => 50202, // Biaya Produksi : Bonus per pasien
				'debit'           => 1,
				'nilai'           => 1530,
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp,
			];
				
			$jurnals[] = [
				'jurnalable_id'   => $periksa->id,
				'jurnalable_type' => 'App\Models\Periksa',
				'coa_id'          => 200002, // Hutang Kepada Asisten Dokter
				'debit'           => 0,
				'nilai'           => 1530,
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp,
			];
		}
        if ( Input::get('dibayar_pasien') > 0 ) {
            $data = [
                'pembayaran' => Input::get('pembayaran'),
                'kembalian' => Input::get('kembalian')
            ];
			$receipts[] = [
				'periksa_id' => $periksa_id,
				'receipt' => json_encode($data),
				'created_at' => $timestamp,
				'updated_at' => $timestamp,
			];
        }

		if ($fix) {
			$mess =  '<strong> dan Perbaikan Sudah Didokumentasi </strong>';
		}

		if ( $periksa->asuransi_id != '32' && !empty(trim(  $periksa->pasien->nomor_asuransi_bpjs  )) ) {
			$countPeriksaPakaiBpjs = Periksa::where('pasien_id', $periksa->pasien_id)
				->where('asuransi_id', '32')
				->where('tanggal', 'like', date('Y-m') . '%')
				->count();
			$countAntarPakaiBpjs = PengantarPasien::where('pengantar_id', $periksa->pasien_id)
				->where('created_at', 'like', date('Y-m') . '%')
				->where('pcare_submit',1)
				->count();

			$query = "SELECT count(ks.id) as jumlah FROM kunjungan_sakits as ks join periksas as px on ks.periksa_id = px.id join pasiens as ps on ps.id = px.pasien_id ";
			$query .= "WHERE ks.created_at like '" . date('Y-m') . "%' ";
			$query .= "AND ks.pcare_submit = 1 ";
			$query .= "AND px.pasien_id = '" . $periksa->pasien_id . "';";

			$countKunjunganSakit = DB::select($query)[0]->jumlah;
			$hitung = $countPeriksaPakaiBpjs + $countAntarPakaiBpjs + $countKunjunganSakit;
			if ($hitung < 1) {
				$kunjungan_sakits[] = [
					'periksa_id'   => $periksa_id,
					'created_at'   => $timestamp,
					'updated_at'   => $timestamp,
				];
			}
		}
		DB::beginTransaction();
		try {
			if ( 
				$periksa->terapi !== '' &&
				$periksa->terapi !== '[]'
		   	) {
				$antrianfarmasi             = new AntrianFarmasi;
				$antrianfarmasi->periksa_id = $periksa->id;
				$antrianfarmasi->jam        = date('H:i:s');
				$antrianfarmasi->tanggal    = date('Y-m-d');
				$antrianfarmasi->save();

				PengantarPasien::where('antarable_type', 'App\Models\AntrianKasir')
					->where('antarable_id', $antriankasir->id)
					->update([
						'antarable_type' => 'App\Models\Periksa',
						'antarable_id'   => $antriankasir->periksa_id
					]);

				if (isset($antriankasir->antrian)) {
					$antrian                 = Antrian::find($antriankasir->antrian->id);
					$antrian->antriable_type = 'App\Models\AntrianFarmasi' ;
					$antrian->antriable_id   = $antrianfarmasi->id;
					$antrian->save();

				}
			} else {
				if (isset( $antriankasir->antrian)) {
					$antrian                 = Antrian::find($antriankasir->antrian->id);
					$antrian->antriable_type = 'App\Models\Periksa' ;
					$antrian->antriable_id   = $periksa->id;
					$antrian->save();
				}
			}

			$apc = new AntrianPolisController;
			$apc->updateJumlahAntrian(false);

			JurnalUmum::insert($jurnals);
			$antriankasir->delete();

			$user                  = Auth::user();
			$user->surveyable_id   = null;
			$user->surveyable_type = null;
			$user->save();

			Dispensing::insert($dispensings);
			TransaksiPeriksa::insert($transaksi_periksas);
			Perbaikantrx::insert($perbaikans);
			Point::insert($points);
			Receipt::insert($receipts);
			KunjunganSakit::insert($kunjungan_sakits);
			$periksa->save();
			$this->massUpdate($rak_updates);
			$this->massUpdate($bukan_peserta_updates);
			$this->massUpdate($rujukan_updates);
			if ($gammu_survey) {
				$message = "Yth Pelanggan " . env("NAMA_KLINIK") . ", untuk meningkatkan pelayanan kami, bagaimana pelayanan kami hari ini? Reply Puas / Tidak Puas / Keberatan jika tidak ingin menerima sms tiap habis berobat";
				Sms::gammuSurvey($periksa->pasien->no_telp, $message, $periksa->id);
			}
			DB::commit();
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
		if ( !empty( Yoga::normalisasiNoHp( $periksa->pasien->no_telp ) ) ) {
			Yoga::smsCenter(Yoga::normalisasiNoHp($periksa->pasien->no_telp), 'Mohon memberikan nilai kepuasan pengalaman layanan Klinik Jati Elok. Balas dengan nomor antara 1 sampai 5. 1 untuk sangat tidak puas dan 5 untuk sangat puas.');
		}
		return redirect('antriankasirs')
			->withPesan(Yoga::suksesFlash('Transaksi pasien <strong>' . $periksa->pasien_id . '-' . $periksa->pasien->nama . '</strong> telah selesai' . $mess))
			->withPrint($periksa->id);
	}

	public function monitor($id){

		return view('monitor');
	}

	public function del_fak_beli(){
		$id = Input::get('id');

		$confirm = Fakturbeli::destroy($id);

		if ($confirm) {
			return '1';
		} else {
			return '0';
		}
	}

	public function send_id(){

		$periksa_id = Input::get('periksa_id');

		$monitor = Monitor::find('1');
		$monitor->periksa_id = $periksa_id;
		$confirm = $monitor->save();

		if($confirm){
			return '1';
		} else {
			return '0';
		}

	}
	public function confirmed(){

		$periksa_id = Input::get('periksa_id');

		$satisfaction_index = Periksa::find($periksa_id)->satisfaction_index;

		if($satisfaction_index != '0'){
			return '1';
		} else {
			return '0';
		}

	}

	public function mon_avail(){
		$periksa_id = Monitor::find(1)->periksa_id;
		if ($periksa_id == '0') {
			$nama = '';
		}else{
			$nama = Monitor::find(1)->periksa->pasien->nama;
		}

		$data = [
			'periksa_id' => $periksa_id,
			'nama' => $nama
		];

		return json_encode($data);
	}

	public function buyhistory($id){

		$query = "SELECT sp.nama as nama, sp.alamat as alamat, sp.no_telp as telepon, sp.hp_pic as hp, sp.pic as pic, fb.supplier_id as supplier_id, pb.harga_beli, max(fb.tanggal) as tanggal from pembelians as pb join faktur_belanjas as fb on fb.id = pb.faktur_belanja_id join suppliers as sp on sp.id = fb.supplier_id where merek_id='{$id}' group by supplier_id order by harga_beli asc;";
		$supplierprices = DB::select($query);

		$pembelians = Pembelian::where('merek_id', $id)->get();
		return view('mereks.buyhistory', compact('pembelians','supplierprices'));

	}


	public function terapi($id)
	{
		$query = "SELECT p.id as id, terapi, s.nama as staf, count(p.id) as jumlah from periksas as p join stafs as s on s.id= p.staf_id where staf_id='{$id}' and terapi not like '[]' and p.created_at > 0 group by terapi order by jumlah desc";
		$periksas = DB::select($query);
		return view('stafs.terapi', compact('periksas'));
		// return $faktur_belanja_id;
	}

	private function terapisBaru($terapis){
		$terapis_baru = [];
		foreach ($terapis as $k => $v) {
			$formula_id = $v->merek->rak->formula_id;
			$signa = $v->signa;
			$jumlah = $v->jumlah;

			$terapis_baru[] = [
				'formula_id' => $formula_id,
				'signa' => $signa,
				'jumlah' => $jumlah
			];
		}
		return json_encode($terapis_baru);
	}

	private function biayaJasa($jenis_tarif_id, $biaya){
		if ($jenis_tarif_id == '104') {
			return 30000;
		} elseif($jenis_tarif_id == '105' || $jenis_tarif_id == '106'){
			return 35000;
		} elseif ($jenis_tarif_id == '102') {
			return 5000;
		} else {
			return $biaya * 0.1;
		}
	}
    public function test(){
    }
    public function getmereks(){
        $qs = str_split( Input::get('q') );
        $temp = '';
        foreach ($qs as $q) {
            $temp .= $q . '%';
        }
        $query = "select min(mr.id) as merek_id, min(mr.merek) as merek, min(rk.fornas) as fornas, min(atu.aturan_minum) as aturan_minum, min(rk.stok) as stok from mereks as mr join raks as rk on rk.id = mr.rak_id join formulas as fr on fr.id = rk.formula_id join komposisis as kp on kp.formula_id = fr.id join generiks as gk on gk.id=kp.generik_id join aturan_minums as atu on atu.id = fr.aturan_minum_id where merek like '%$temp' or gk.generik like '%$temp' or atu.aturan_minum like '%$temp' group by mr.id limit 20;";
        $mereks = DB::select($query);
        $data = [];
        foreach ($mereks as $mrk) {
            $komposisis = Merek::find( $mrk->merek_id )->rak->formula->komposisi;
            $fornas_id = $mrk->fornas;
            if ($fornas_id == 1) {
                $fornas = 'fornas';
            } else {
                $fornas = 'non fornas';
            }
            $komposisi = '<ul>';
            foreach ($komposisis as $komp) {
                $komposisi .= '<li>' . $komp->generik->generik . ' ' . $komp->bobot . '</li>';
            }
            $komposisi .= '</ul>';
            $data[]= [
                 'id' => $mrk->merek_id,
                 'merek' => $mrk->merek,
                 'komposisi' => $komposisi,
                 'stok' => $mrk->stok,
                 'aturan_minum' => $mrk->aturan_minum,
                 'fornas' => $fornas
            ];
        }
         return json_encode($data);
    }
    public function test_post(){
         return 'this post';
    }
	public function survey_available(){
		$periksa_id = Monitor::find(1)->periksa_id;
		if ($periksa_id == '0') {
			return '0';
		}else{
			return '1';
		}

	}
	private function formKembali($periksa){


		$antrian              = new AntrianPeriksa;
		$antrian->poli        = $periksa->poli;
		$antrian->periksa_id  = $periksa->periksa_id;
		$antrian->staf_id     = $periksa->staf_id;
		$antrian->asuransi_id = $periksa->asuransi_id;
		$antrian->asisten_id  = $periksa->asisten_id;
		$antrian->pasien_id   = $periksa->pasien_id;
		$antrian->jam         = $periksa->jam;
		$antrian->tanggal     = $periksa->tanggal;

		DB::beginTransaction();
		try {

			$antrian->save();
			$periksa->antrian_periksa_id = $antrian->id;
			$periksa->save();

			PengantarPasien::where('antarable_type', 'App\Models\Periksa')
				->where('antarable_id', $periksa->id)
				->update([
					 'antarable_type' => 'App\Models\AntrianPeriksa',
					 'antarable_id' => $antrian->id
			]);
			GambarPeriksa::where('gambarable_type', 'App\Models\Periksa')
				->where('gambarable_id', $periksa->id)
				->update([
					 'gambarable_type' => 'App\Models\AntrianPeriksa',
					 'gambarable_id' => $antrian->id
			]);
			Antrian::where('antriable_type', 'App\Models\Periksa')
				->where('antriable_id', $periksa->id)
				->update([
					 'antriable_type' => 'App\Models\AntrianPeriksa',
					 'antriable_id' => $antrian->id
			]);
			DB::commit();
			
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
		AntrianKasir::where('periksa_id', $periksa_id)->delete();
		AntrianApotek::where('periksa_id', $periksa_id)->delete();

		return $periksa;
	}

	public function massUpdate($updates){
		$arrays = array_chunk($updates, 500);
		foreach ($arrays as $array) {
			$this->updateChunk($array);
		}
	}

	private function updateChunk($updates){
		//buat array id yang akan diupdate
		$ids = [];
		foreach ($updates as $upd) {
			$ids[] = $upd['collection']->id;
		}

		//buat array parameter update
		$update_parameter = [];
		foreach ($updates as $up) {
			foreach (array_keys( $up['updates'] ) as $k) {
				$update_parameter[ $k ][] = [
					'value' => $up['updates'][$k],
					'id'    => $up['collection']->id
				];
			}
		}

		$table  = $updates[0]['collection']->getTable();
		$query  = "update ";
		$query .= $table . " ";
		$kedua  = false;
		$timestamp = date('Y-m-d H:i:s');
		foreach ($update_parameter as $key => $upd) {
			if ($kedua) {
				$query .= "," . $key  . " = ( CASE id ";
			} else {
				$query .= "SET " . $key  . " = ( CASE id ";
			}
			foreach ($upd as $up) {
				$query .= "WHEN '" . $up['id'] . "' THEN '" . $up['value'] . "' ";
			}
			$query .= "END) ";
			$kedua = true;
		}

		$query .= ", updated_at = '$timestamp' ";
		$query .= "WHERE id in ";
		foreach ($ids as $k => $id) {
			if ($k == 0) {
				$query .= "('" .  $id . "'";
			} else {
				$query .= " ,'" .  $id ."'";
			}
		}
		$query .= ")";
		DB::statement($query);
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function uploadKlaimGDP($pre, $id, $fieldName)
	{
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
			$destination_path = 'img/klaim_gdp_bpjs/';
			/* $destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/klaim_gdp_bpjs/'; */
			// Mengambil file yang di upload

			Storage::disk('s3')->put($destination_path. $filename, file_get_contents($upload_cover));
			/* $upload_cover->save($destination_path . '/' . $filename); */
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return $destination_path. $filename;
			
		} else {
			return null;
		}
	}
	
}


