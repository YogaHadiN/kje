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
use App\Models\WhatsappRegistration;
use App\Models\Poli;
use App\Models\Coa;
use App\Models\KlaimGdpBpjs;
use App\Models\Asuransi;
use App\Models\WablasController;
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
                    'tenant_id'      => session()->get('tenant_id'),
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
		return redirect()->back()->withPesan(Yoga::suksesFlash('<strong>' . $periksa->pasien_id . ' - ' . $periksa->pasien->nama . ' </strong>Berhasil dikembalikan ke Ruang Periksa <strong>' . ucwords(strtolower($periksa->poli->poli)) . '</strong>'));

	}
	public function kembali2(Request $request, $id){
		$periksa = $this->formKembali($request->periksa);
		return redirect()->back()->withPesan(Yoga::suksesFlash('<strong>' . $periksa->pasien->id . ' - ' . $periksa->pasien->nama . ' </strong>Berhasil dikembalikan ke Ruang Periksa <strong>' . ucwords(strtolower($periksa->poli->poli)) . '</strong>'));
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
        $periksa      = Periksa::with('terapii.merek.rak', 'asuransi')->where('id', $id)->first();
		$antriankasir = AntrianKasir::where('periksa_id', $id)->first();
		if (
			!isset($antriankasir)
		) {
            return redirect('antriankasirs')->withPesan( Yoga::gagalFlash('Pasien sedang diedit oleh dokter, mohon tunggu sampai selesai lalu ulangi lagi cek obat') );
		}

		$user                  = Auth::user();
		$user->surveyable_type = 'App\Models\AntrianKasir';
		$user->surveyable_id   = $antriankasir->id;
		$user->save();

        $sudah = Pasien::sudahPeriksaGDSBulanIniPakaiBPJS($periksa->pasien_id, $periksa->id);

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
		$query .= "AND dc.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "GROUP BY dc.id ";
		$data = DB::select($query);
		if ( count( $data )  > 0) {
			$insterted = [];
			foreach ($tindakanPeriksa as $k => $t) {
				foreach ($data as $ky => $d) {
					if ($d->jenis_tarif_id == $t['jenis_tarif_id']) {
                        $jt_diskon = JenisTarif::where('jenis_tarif', 'Diskon')->first();
						$inserted[] = [
							'jenis_tarif_id'        => $jt_diskon->id,
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
        if ( $periksa->asuransi->tipe_asuransi_id== '4') {
        	$jasa_dokter = Tarif::queryTarif($periksa->asuransi_id, 'Jasa Dokter')->biaya;
        	$obat        = Tarif::queryTarif($periksa->asuransi_id, 'Biaya Obat')->biaya;
        	$dibayar     = $jasa_dokter + $obat;
        }
		$warna = $this->warna;

		$asuransi_list = Asuransi::list();

		$pjx                  = new PasiensAjaxController;
		$pjx->input_pasien_id = $periksa->pasien_id;
		$prolanis_periksa_gdp = $pjx->statusCekGDSBulanIni() == 0 && $periksa->asuransi->tipe_asuransi_id ==  5 && $periksa->prolanis_dm == '1' ? true :false;

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
    /**
     * @group failing
     */
    public function survey_post()
    {

		DB::beginTransaction();
		try {
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
			$tindakan_periksas         = [];
			$receipts                  = [];
			$kunjungan_sakits          = [];
			$timestamp                 = $periksa->tanggal . ' 23:59:59';

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
                    'sebelum'    => Input::get('sebelum'),
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

			if ($periksa->asuransi->tipe_asuransi_id == 5 && !empty($periksa->keterangan)) {
				$periksa->keterangan = null;
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
				$rak    = $value->merek->rak;
				$stok   = $rak->stok - $value->jumlah;
				$rak_id = $rak->id;

				$rak_updates[] = [
					'collection' => $rak,
					'updates'    => [
						'stok'   => $stok
					]
				];
                $value->dispens()->create([
					'merek_id'         => $value->merek_id,
					'keluar'           => $value->jumlah,
					'tanggal'          => $periksa->tanggal
                ]);
			}

			$mess         = '';
			$gammu_survey = false;
			if ( 
				$periksa->poli_id                                                  == Poli::where('poli', 'Poli Estetika')->first()->id &&
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
			$coa_id_110000 = Coa::where('kode_coa', '110000')->first()->id;
			if ($periksa->tunai > 0) {
				$periksa->jurnals()->create([
                    'coa_id'          => $coa_id_110000, // Kas di tangan
                    'debit'           => 1,
                    'nilai'           => $periksa->tunai
				]);
			}
			// Input jurnal umum kas di tangan bila piutang > 0
			if ($periksa->piutang>0) {
				$periksa->jurnals()->create([
					'debit'           => 1,
					'coa_id'          => $periksa->asuransi->coa_id, // Piutang berdasarkan masing2 asuransi
					'nilai'           => $periksa->piutang,
				]);
			}

			$transaksis    = $periksa->transaksi;
			$transaksis    = json_decode($transaksis, true);
			$adaJasaDokter = false;
			$feeDokter     = 0;

			$hutang_asisten_tindakan = 0;
            $jt_gula_darah = JenisTarif::where('jenis_tarif', 'Gula Darah')->first();
            $jt_diskon = JenisTarif::where('jenis_tarif', 'Diskon')->first();
			foreach ($transaksis as $k => $transaksi) {
				$adaBiaya = false;
                $tp = $periksa->transaksii()->create([
                    'jenis_tarif_id'         => $transaksi['jenis_tarif_id'],
                    'biaya'                  => $transaksi['biaya'],
                    'keterangan_pemeriksaan' => isset($transaksi['keterangan_tindakan'])?$transaksi['keterangan_tindakan']:null
                ]);


				if ( !($transaksi['jenis_tarif_id'] ==  $jt_gula_darah->id || $transaksi['biaya'] == 0) ) {
					$feeDokter += Tarif::where('asuransi_id', $periksa->asuransi_id)->where('jenis_tarif_id', $transaksi['jenis_tarif_id'])->first()->jasa_dokter;
				}

				$jenis_tarif = JenisTarif::with('bahanHabisPakai.merek.rak')->where('id', $transaksi['jenis_tarif_id'])->first();

				if ($transaksi['biaya'] > 0 && $transaksi['jenis_tarif_id'] != $jt_diskon->id) { // jika biaya > 0 dan jenis_tarif_id bukan 0 (diskon)
                    $periksa->jurnals()->create([
                        'coa_id' => $jenis_tarif->coa_id,
                        'debit'  => 0,
                        'nilai'  => $transaksi['biaya']
                    ]);
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

					$tp->dispens()->create([
                        'merek_id'         => $bhp->merek_id,
                        'keluar'           => $bhp->jumlah,
                        'tanggal'          => $periksa->tanggal,
					]);
				}
				
				//Jika ada biaya untuk tindakan Nebulizer baik anak maupun dewasa, masukkan beban jasa dokter 
				if ($adaBiaya && JenisTarif::where('jenis_tarif', 'like', 'Nebulizer%')->where('id', $transaksi['jenis_tarif_id'])->exists()) {
					$feeDokter += 3000;
				}
			}

			//Masukkan pembayaran ke dalam Transaksi
			$coa_id_50201  = Coa::where('kode_coa', '50201')->first()->id;
			$coa_id_50202  = Coa::where('kode_coa', '50202')->first()->id;
			$coa_id_50204  = Coa::where('kode_coa', '50204')->first()->id;
			$coa_id_50205  = Coa::where('kode_coa', '50205')->first()->id;
			$coa_id_200002 = Coa::where('kode_coa', '200002')->first()->id;
			$coa_id_200001 = Coa::where('kode_coa', '200001')->first()->id;
			$coa_id_112000 = Coa::where('kode_coa', '112000')->first()->id;

			if ($hutang_asisten_tindakan > 0) {
				$periksa->jurnals()->create([
					'coa_id'          => $coa_id_50205, // Biaya Produksi : Bonus per pasien Jasa TIndakan untuk Asisten
					'debit'           => 1,
					'nilai'           => $hutang_asisten_tindakan,
				]);
				$periksa->jurnals()->create([
					'coa_id'          => $coa_id_200002, // Hutang Kepada Asisten Dokter
					'debit'           => 0,
					'nilai'           => $hutang_asisten_tindakan,
				]);
			}
			//
			// Input hutang kepada dokter
			// 
			if ($feeDokter > 0 && $periksa->staf->gaji_tetap == 0 ) {
				$periksa->jurnals()->create([
					'coa_id'          => $coa_id_50201, //Beban Jasa Dokter
					'debit'           => 1,
					'nilai'           => $feeDokter,
				]);
				$periksa->jurnals()->create([
					'coa_id'          => $coa_id_200001, // Hutang Kepada dokter
					'debit'           => 0,
					'nilai'           => $feeDokter,
				]);
			}
			//
			// Input Transaksi ini untuk pengurangan persediaan obat tiap transaksi pasien
			//
			if ($biayaProduksiObat > 0) {
				$periksa->jurnals()->create([
					'coa_id'          => $coa_id_50204, // Biaya Produksi : Obat
					'debit'           => 1,
					'nilai'           => $biayaProduksiObat,
				]);
				$periksa->jurnals()->create([
					'coa_id'          => $coa_id_112000, // Persediaan Obat
					'debit'           => 0,
					'nilai'           => $biayaProduksiObat,
				]);
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
                    'tekanan_darah' => Yoga::returnNull($tekanan_darah),
                    'berat_badan'   => Yoga::returnNull($berat_badan),
                    'suhu'          => Yoga::returnNull($suhu),
                    'tinggi_badan'  => Yoga::returnNull($tinggi_badan),
				];
				$periksa->jurnals()->create([
					'coa_id'          => $coa_id_50202, // Biaya Produksi : Bonus per pasien
					'debit'           => 1,
					'nilai'           => 1530,
				]);
					
				$periksa->jurnals()->create([
					'coa_id'          => $coa_id_200002, // Hutang Kepada Asisten Dokter
					'debit'           => 0,
					'nilai'           => 1530,
				]);
			}
			if ( Input::get('dibayar_pasien') > 0 ) {
				$data = [
					'pembayaran' => Input::get('pembayaran'),
					'kembalian' => Input::get('kembalian')
				];
				$receipts[] = [
					'receipt' => json_encode($data),
				];
			}

			if ($fix) {
				$mess =  '<strong> dan Perbaikan Sudah Didokumentasi </strong>';
			}

			if ( $periksa->asuransi->tipe_asuransi_id !=  5 && !empty(trim(  $periksa->pasien->nomor_asuransi_bpjs  )) ) {

                $bulanIni = date('Y-m');
                $query  = "SELECT count(prx.id) as jumlah ";
                $query .= "FROM periksas as prx ";
                $query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
                $query .= "WHERE asu.tipe_asuransi_id =  5 ";
                $query .= "AND prx.tanggal like '{$bulanIni}%' ";
                $query .= "AND prx.tenant_id = " . session()->get('tenant_id') . " ";
                $query .= "AND prx.pasien_id = {$periksa->pasien_id} ";

                $countPeriksaPakaiBpjs = DB::select($query)[0]->jumlah;
				/* $countPeriksaPakaiBpjs = Periksa::where('pasien_id', $periksa->pasien_id) */
				/* 	->where('asuransi_id', '32') */
				/* 	->where('tanggal', 'like', date('Y-m') . '%') */
				/* 	->count(); */
				$countAntarPakaiBpjs = PengantarPasien::where('pengantar_id', $periksa->pasien_id)
					->where('created_at', 'like', date('Y-m') . '%')
					->where('pcare_submit',1)
					->count();

				$query = "SELECT count(ks.id) as jumlah FROM kunjungan_sakits as ks join periksas as px on ks.periksa_id = px.id join pasiens as ps on ps.id = px.pasien_id ";
				$query .= "WHERE ks.created_at like '" . date('Y-m') . "%' ";
				$query .= "AND ks.pcare_submit = 1 ";
				$query .= "AND ks.tenant_id = " . session()->get('tenant_id') . " ";
				$query .= "AND px.pasien_id = '" . $periksa->pasien_id . "' ";

				$countKunjunganSakit = DB::select($query)[0]->jumlah;
				$hitung = $countPeriksaPakaiBpjs + $countAntarPakaiBpjs + $countKunjunganSakit;
				if ($hitung < 1) {
					$kunjungan_sakits[] = [
                        'periksa_id'   => $periksa_id,
                        'tenant_id'  => session()->get('tenant_id'),
                        'created_at'   => $timestamp,
                        'updated_at'   => $timestamp,
					];
				}
			}
			if ( 
				$periksa->terapi !== '' &&
				$periksa->terapi !== '[]'
		   	) {
				PengantarPasien::where('antarable_type', 'App\Models\AntrianKasir')
					->where('antarable_id', $antriankasir->id)
					->update([
						'antarable_type' => 'App\Models\Periksa',
						'antarable_id'   => $antriankasir->periksa_id
					]);
			}
			if (isset( $antriankasir->antrian)) {
				$antrian                 = $antriankasir->antrian;
				$antrian->antriable_type = 'App\Models\Periksa' ;
				$antrian->antriable_id   = $periksa->id;
				$antrian->save();
			}

			$apc = new AntrianPolisController;
			/* $apc->updateJumlahAntrian(false, null); */

			// masukkan kembali whatsapp_registration dengan periksa_id untuk customer surveyable_id
			//
			if (
				isset($antrian) &&
				!is_null($antrian->no_telp)
			) {
				$whatsapp_registration             = new WhatsappRegistration;
				$whatsapp_registration->no_telp    = $antrian->no_telp;
				$whatsapp_registration->periksa_id = $antriankasir->periksa_id;
				$whatsapp_registration->save();

				$message = "Terima kasih telah berobat di Klinik Jati Elok";
				$message .= PHP_EOL;
				$message .= "=======================";
				$message .= PHP_EOL;
				$message .= PHP_EOL;
				$message .= "Mohon agar dapat memberikan penilaian pelayanan kami";
				$message .= PHP_EOL;
				$message .= PHP_EOL;
				$message .= "Balas %1% jika %Sangat Baik%";
				$message .= PHP_EOL;
				$message .= "Balas %2% jika %Baik%";
				$message .= PHP_EOL;
				$message .= "Balas %3% jika %Biasa%";
				$message .= PHP_EOL;
				$message .= "Balas %4% jika %Buruk%";
				$message .= PHP_EOL;
				$message .= "Balas %5% jika %Sangat Buruk%";
				$message .= PHP_EOL;

				$data = [
					[
						'phone'    => $antrian->no_telp,
						'message'  => $message,
						'secret'   => false, // or true
						'priority' => false, // or true
					]
				];
				$wa = new WablasController;
				$wa->bulkSend($data);
			}
			$antriankasir->delete();

			$user                  = Auth::user();
			$user->surveyable_id   = null;
			$user->surveyable_type = null;
			$user->save();

			$periksa->perbaikans()->createMany($perbaikans);
            $periksa->points()->createMany($points);
			$periksa->receipts()->createMany($receipts);
			KunjunganSakit::insert($kunjungan_sakits);

			$periksa->save();
			$this->massUpdate($rak_updates);
			$this->massUpdate($bukan_peserta_updates);
			$this->massUpdate($rujukan_updates);

            /* dd( */ 
            /*     $periksa->tunai, */
            /*     JurnalUmum::where('nilai', $periksa->tunai)->count() */
            /* ); */

			DB::commit();

		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
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

		$query = "SELECT ";
		$query .= "sp.nama as nama, ";
		$query .= "sp.alamat as alamat, ";
		$query .= "sp.no_telp as telepon, ";
		$query .= "sp.hp_pic as hp, ";
		$query .= "sp.pic as pic, ";
		$query .= "fb.supplier_id as supplier_id, ";
		$query .= "pb.harga_beli, ";
		$query .= "max(fb.tanggal) as tanggal ";
		$query .= "from pembelians as pb ";
		$query .= "join faktur_belanjas as fb on fb.id = pb.faktur_belanja_id ";
		$query .= "join suppliers as sp on sp.id = fb.supplier_id ";
		$query .= "where merek_id='{$id}' ";
		$query .= "AND pb.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by supplier_id ";
		$query .= "order by harga_beli asc ";
		$supplierprices = DB::select($query);

		$pembelians = Pembelian::where('merek_id', $id)->get();
		return view('mereks.buyhistory', compact('pembelians','supplierprices'));

	}


	public function terapi($id)
	{
		$query = "SELECT p.id as id, ";
		$query .= "terapi, ";
		$query .= "s.nama as staf, ";
		$query .= "count(p.id) as jumlah ";
		$query .= "from periksas as p ";
		$query .= "join stafs as s on s.id= p.staf_id ";
		$query .= "where staf_id='{$id}' ";
		$query .= "and terapi not like '[]' ";
		$query .= "and p.created_at > 0 ";
		$query .= "AND p.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by terapi ";
		$query .= "order by jumlah desc";
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

	public function biayaJasa($jenis_tarif_id, $biaya){
		if ($jenis_tarif_id == JenisTarif::where('jenis_tarif', 'Sirkumsisi Anak-anak')->first()->id) { //sirkumsisi anak-anak
			return 20000;
		} elseif(JenisTarif::where('jenis_tarif', 'Sirkumsisi Dewasa')->first()->id || JenisTarif::where('jenis_tarif', 'Sirkumsisi Anak Gendut')->first()->id){
			return 15000;
		} elseif (JenisTarif::where('jenis_tarif', 'Nebulizer Anak-anak')->first()->id) {
			return 3000;
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
		$query = "select min(mr.id) as merek_id, ";
		$query .= "min(mr.merek) as merek, ";
		$query .= "min(rk.fornas) as fornas, ";
		$query .= "min(atu.aturan_minum) as aturan_minum, ";
		$query .= "min(rk.stok) as stok ";
		$query .= "from mereks as mr ";
		$query .= "join raks as rk on rk.id = mr.rak_id ";
		$query .= "join formulas as fr on fr.id = rk.formula_id ";
		$query .= "join komposisis as kp on kp.formula_id = fr.id ";
		$query .= "join generiks as gk on gk.id=kp.generik_id ";
		$query .= "join aturan_minums as atu on atu.id = fr.aturan_minum_id ";
		$query .= "WHERE mr.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "where merek like '%$temp' ";
		$query .= "or gk.generik like '%$temp' ";
		$query .= "or atu.aturan_minum like '%$temp' ";
		$query .= "group by mr.id limit 20 ";
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
		$antrian->poli_id     = $periksa->poli_id;
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


