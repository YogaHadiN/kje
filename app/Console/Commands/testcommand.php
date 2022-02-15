<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\Outbox;
use App\Models\Ht;
use App\Models\AntrianKelengkapanDokumen;
use App\Models\PembayaranBpjs;
use App\Models\PiutangAsuransi;
use App\Models\BelanjaPeralatan;
use App\Models\Dm;
use App\Models\HomeVisit;
use App\Models\User;
use App\Models\Pengeluaran;
use App\Models\Woowa;
use App\Models\Antrian;
use App\Models\BayarDokter;
use App\Models\GajiGigi;
use App\Models\BayarGaji;
use App\Models\PengantarPasien;
use App\Models\Role;
use App\Models\Panggilan;
use App\Models\Rekening;
use App\Models\BahanBangunan;
use App\Models\Asuransi;
use App\Models\Sms;
use App\Models\StatusBpjs;
use App\Models\AntrianPoli;
use App\Models\KunjunganSakit;
use App\Models\PembayaranAsuransi;
use App\Models\CatatanAsuransi;
use App\Models\AbaikanTransaksi;
use App\Models\PiutangDibayar;
use App\Models\NotaJual;
use App\Models\PoliAntrian;
use App\Models\KirimBerkas;
use App\Models\PasienRujukBalik;
use App\Models\JenisTarif;
use App\Models\Pasien;
use App\Models\Invoice;
use App\Models\Terapi;
use App\Models\AntrianPeriksa;
use App\Models\Tarif;
use App\Models\DataDuplikat;
use App\Models\FakturBelanja;
use App\Models\JurnalUmum;
use App\Models\Periksa;
use App\Models\JenisAntrian;
use App\Models\Telpon;

use App\Jobs\sendEmailJob;
use App\Http\Controllers\PeriksasController;
use App\Http\Controllers\WablasController;
use Mail;
use App\Mail\MailToInsuranceForDetails;
use Carbon\Carbon;
use Storage;
use DB;
use Artisan;
use Log;
use Input;

class testcommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:command';
	public $jumlah_piutang_asuransi;
	public $jumlah_invoice;
	public $akumulasi_periksa_ids;
	public $jumlah_rekening;
	public $jumlah_nota_jual;
	public $jumlah_jurnal_umum;
	public $jumlah_piutang_dibayar;
	public $jumlah_pembayaran_asuransi;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is spartaaaa';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

		$this->jumlah_piutang_asuransi    = 0;
		$this->jumlah_invoice             = 0;
		$this->jumlah_rekening            = 0;
		$this->jumlah_nota_jual           = 0;
		$this->jumlah_jurnal_umum         = 0;
		$this->jumlah_piutang_dibayar     = 0;
		$this->jumlah_pembayaran_asuransi = 0;
		$this->akumulasi_periksa_ids      = [];
    }

	public $estetika_buka = true;
	public $gigi_buka = true;


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$antrians = Antrian::where('created_at', 'like', '2022-02-14%')
							->where('antriable_type', 'App\\Models\\Periksa')
							->get();
		$errors = [];
		foreach ($antrians as $antrian) {
			try {
				$asuransi_id = $antrian->antriable->asuransi_id;
			} catch (\Exception $e) {
				$errors[] = $antrian->id;
			}
		}

		dd( $errors );
		/* $this->removeBpjsFromAntrianKelengkapan(); */
		/* $this->tuningPiutangdibayarSudahdibayar(); */
		/* $this->cariTransaksi(); */
		/* $this->apiBPJS(); */
		/* $this->resetPembayaranAsuransiYangRekeningNull(); */
		/* $this->normalisasi_coa_id_dan_nama_asuransi(); */
		/* $this->normalisasi_jurnal_periksas(); */
		/* $this->resetPembayaranAsuransis([ */
		/* 	1124, */
		/* 	1090, */
		/* 	1241, */
		/* 	1253, */
		/* 	1251, */
		/* 	1250, */
		/* 	1236, */
		/* 	1237, */
		/* 	1245, */
		/* 	915, */
		/* 	1281, */
		/* 	1275, */
		/* 	1276, */
		/* 	1174, */
		/* 	921, */
		/* 	1231, */
		/* 	1186, */
		/* 	1187, */
		/* 	1271, */
		/* 	1182, */
		/* 	1185, */
		/* 	1175, */
		/* 	976, */
		/* 	1181, */
		/* 	961, */
		/* 	884, */
		/* 	1183, */
		/* 	1189, */
		/* 	1168, */
		/* 	992, */
		/* 	1188, */
		/* 	1257, */
		/* 	993, */
		/* 	1012, */
		/* 	1223, */
		/* 	1184, */
		/* 	885, */
		/* 	999, */
		/* 	895, */
		/* 	1015, */
		/* 	1051, */
		/* 	1190, */
		/* 	1191, */
		/* 	1109, */
		/* 	1155, */
		/* 	1212, */
		/* 	850, */
		/* 	1192, */
		/* 	881, */
		/* 	882, */
		/* 	1240, */
		/* 	883, */
		/* 	849, */
		/* 	1017, */
		/* 	1233, */
		/* 	1180, */
		/* 	1117, */
		/* 	1176, */
		/* 	1072, */
		/* 	1200, */
		/* 	1282, */
		/* 	1177, */
		/* 	1020, */
		/* 	1205, */
		/* 	1154, */
		/* 	1234, */
		/* 	1163, */
		/* 	1213, */
		/* 	1172, */
		/* 	1266, */
		/* 	1261, */
		/* 	1280, */
		/* 	1269, */
		/* 	1267, */
		/* 	1249, */
		/* 	1244, */
		/* 	1260, */
		/* 	1217 */
		/* ]); */
	}
	
	/**
	* undocumented function
	*
	* @return void
	*/
	private function revisiPembayaranBpjs()
	{
		$pembayaran_bpjs = PembayaranBpjs::all();
		$data = [];
		foreach ($pembayaran_bpjs as $p) {
			/* dd( $p ); */
			$tanggal_pembayaran = $p->tanggal_pembayaran;
			$tanggal_mulai      = $p->mulai_tanggal;
			/* dd( $tanggal_mulai->format('1-m-Y') == $tanggal_pembayaran->format('1-m-Y') ); */
			if ( 
				$tanggal_mulai->format('1-m-Y') == $tanggal_pembayaran->format('1-m-Y')
			) {
				$p->mulai_tanggal = $p->mulai_tanggal->firstOfMonth()->subMonth()->format('Y-m-1');
				$p->akhir_tanggal = $p->akhir_tanggal->firstOfMonth()->subMonth()->format('Y-m-t');
				$p->save();

				$jus       = JurnalUmum::where('jurnalable_type', 'App\\Models\\PembayaranBpjs')->where('jurnalable_id', $p->id)->get();
				foreach ($jus as $ju) {
					$ju->created_at   =  $p->mulai_tanggal->format('Y-m-t 23:59:59');
					$ju->updated_at   =  $p->mulai_tanggal->format('Y-m-t 23:59:59');
					$ju->save();
				}
			}
		}
	}
	
	/**
	* undocumented function
	*
	* @return void
	*/
	private function testAdmedika()
	{
		$uri="https://mobile.admedika.co.id/admedgateway/services/api/?method=CustomerHost"; //url web service bpjs;
		/* $uri="https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/provider/0/3"; //url web service bpjs; */
		/* $uri="https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/peserta/0001183422677"; //url web service bpjs; */

		$tokenAuth          = env('ADMEDIKA_TOKEN_AUTH'); //Admedika Token Auth
		$serviceID          = env('ADMEDIKA_SERVICE_ID'); //Admedika Token Auth
		$customerID         = env('ADMEDIKA_CUSTOMER_ID'); //Admedika Token Auth
		$requestID          = env('ADMEDIKA_REQUEST_ID'); //Admedika Token Auth
		$txnData            = env('ADMEDIKA_TXN_DATA'); //Admedika Token Auth
		$txnRequestDateTime = env('ADMEDIKA_TXN_REQUEST_DATE_TIME'); //Admedika Token Auth

		$headers = array( 
					"Accept: application/json", 
					"tokenAuth: ".$tokenAuth,
					"serviceID: ".$serviceID,
					"customerID: ".$customerID,
					"requestID: ".$requestID,
					"txnData: ".$txnData,
					"txnRequestDateTime: ".$txnRequestDateTime
				); 

		$ch = curl_init($uri);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
		$data = curl_exec($ch);
		curl_close($ch);
		dd($data);
	}
	
	private function webhook(){
		$data["license"]="5c286f1ed7121";
		$data["url"]    ="https://yourwebsite.com/listen.php"; // message data will push to this url
		$data["no_wa"]  = "6289648615564";    //sender number registered in woowa
		$data["action"] = "set";

		$url="http://api.woo-wa.com/v2.0/webhook";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$err = curl_error($ch);
		curl_close ($ch);
		if ($err) {
			dd("cURL Error #:" . $err);
		} else {
			dd( $result);
		}
	}
	private function thisCoba(){
		$client->request('GET', '/get', [
			'headers' => [
				'User-Agent' => 'testing/1.0',
				'Accept'     => 'application/json',
				'X-Foo'      => ['Bar', 'Baz']
			]
		]);
	}


    private function apiBPJS()
    {

		$uri                  = "https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0/peserta/000079381408"; //url web service bpjs;
		$consID               = env('BPJS_CONSID'); //customer ID anda
		$secretKey            = env('BPJS_SECRET_KEY'); //secretKey anda

		$pcareUname           = env('BPJS_PCARE_UNAME'); //username pcare
		$pcarePWD             = env('BPJS_PCARE_PWD'); //password pcare anda
		$kdAplikasi           = env('BPJS_KD_APLIKASI'); //kode aplikasi

		$stamp                = time();
		$data                 = $consID.'&'.$stamp;

		$signature            = hash_hmac('sha256', $data, $secretKey, true);
		$encodedSignature     = base64_encode($signature);
		$encodedAuthorization = base64_encode($pcareUname.':'.$pcarePWD.':'.$kdAplikasi);

		/* dd($pcareUname, $pcarePWD); */
		/* dd($secretKey, $signature, $kdAplikasi, $consID); */

		$headers = array( 
					"Accept: application/json", 
					"X-cons-id:".$consID, 
					"X-timestamp: ".$stamp, 
					"X-signature: ".$encodedSignature, 
					"X-authorization: Basic " .$encodedAuthorization 
				); 

		$ch = curl_init($uri);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
		$data = curl_exec($ch);
		curl_close($ch);
		dd(
			$data, 
			env('BPJS_CONSID'),
			env('BPJS_SECRET_KEY'),
			env('BPJS_PCARE_UNAME'),
			env('BPJS_PCARE_PWD'),
			env('BPJS_KD_APLIKASI')
		);
		/* return $data; */
	}
	private function errorLog(){
		DB::statement("delete from coas where id in (select co.id from coas as co left join jurnal_umums as ju on ju.coa_id = co.id where ju.coa_id is null and co.id like '12%')");
		DB::statement("delete from coas where id in (select co.id from coas as co left join jurnal_umums as ju on ju.coa_id = co.id where ju.coa_id is null and co.id like '10%')");
		DB::statement("update jurnal_umums set nilai = 20000 where id = 226687;");
		DB::statement("update jurnal_umums set nilai = 35000 where id = 393460;");
		DB::statement("update jurnal_umums set nilai = 20000 where id = 459209;");
		DB::statement("update jurnal_umums set nilai = 35000 where id = 520931;");
		DB::statement("update jurnal_umums set nilai = 115000 where id = 721494;");
		DB::statement("update jurnal_umums set nilai = 35000 where id = 758562;");
		DB::statement("update jurnal_umums set nilai = 15000 where id = 768188;");
		DB::statement("update jurnal_umums set nilai = 35000 where id = 819723;");
		DB::statement("update jurnal_umums set nilai = 20000 where id = 964228;");
		DB::statement("update jurnal_umums set nilai = 35000 where id = 983506;");
		DB::statement("update jurnal_umums set nilai = 85000 where id = 307335;");
		DB::statement("delete from jurnal_umums where jurnalable_type = 'App\\\Models\\\Pengeluaran' and jurnalable_id = 5182;");
		DB::statement("delete from pengeluarans where id = 5182;");
	}

	public function resetPembayaranAsuransis($pembayaran_asuransi_ids){

		foreach ($pembayaran_asuransi_ids as $pembayaran_asuransi_id) {
			$this->resetPembayaranAsuransi($pembayaran_asuransi_id);
		}

		/* dd( */
		/* 	'piutang_asuransis = ' . $this->jumlah_piutang_asuransi, */
		/* 	'invoice = ' .$this->jumlah_invoice, */
		/* 	'rekening = ' .$this->jumlah_rekening, */
		/* 	'nota_jual = ' .$this->jumlah_nota_jual, */
		/* 	'jurnal_umum = ' .$this->jumlah_jurnal_umum, */
		/* 	'piutang_dibayar = ' .$this->jumlah_piutang_dibayar, */
		/* 	'pembayaran_asuransi = ' .$this->jumlah_pembayaran_asuransi, */
		/* 	json_encode( $this->akumulasi_periksa_ids ) */
		/* ); */

	}
	/**
	* undocumented function
	*
	* @return void
	*/
	public function resetPembayaranAsuransi($pembayaran_asuransi_id)
	{
		$pembayaran_asuransi = PembayaranAsuransi::find( $pembayaran_asuransi_id );

		$piutang_dibayars    = PiutangDibayar::where('pembayaran_asuransi_id', $pembayaran_asuransi_id)->get();

		$periksa_ids         = [];

		foreach ($piutang_dibayars as $piutang) {
			$this->akumulasi_periksa_ids[] = $piutang->periksa_id;
			$periksa_ids[]                 = $piutang->periksa_id;
		}

		//
		// piutang dibayar di delete
		$this->jumlah_invoice = $this->jumlah_invoice + Invoice::where('pembayaran_asuransi_id', $pembayaran_asuransi_id)->update([
			'pembayaran_asuransi_id' => null
		]);

		// update rekenings
		$this->jumlah_rekening = $this->jumlah_rekening + Rekening::where('pembayaran_asuransi_id', $pembayaran_asuransi_id)->update([
			'pembayaran_asuransi_id' => null
		]);

		// delete nota_jual
		if ( !isset( $pembayaran_asuransi->nota_jual_id ) ) {
			dd( $pembayaran_asuransi->id );
		}
		$this->jumlah_nota_jual = $this->jumlah_nota_jual + NotaJual::destroy( $pembayaran_asuransi->nota_jual_id );

		// delete jurnal_umum
		$this->jumlah_jurnal_umum = $this->jumlah_jurnal_umum + JurnalUmum::where('jurnalable_id', $pembayaran_asuransi->nota_jual_id)
					->where('jurnalable_type', 'App\\Models\\NotaJual')
					->delete();

		$this->jumlah_piutang_dibayar = $this->jumlah_piutang_dibayar + PiutangDibayar::where('pembayaran_asuransi_id', $pembayaran_asuransi_id)->delete();

		$this->jumlah_pembayaran_asuransi = $this->jumlah_pembayaran_asuransi + $pembayaran_asuransi->delete();
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function testAsuransi()
	{
		 dd( [ null => 'Tidak' ] + Asuransi::list() );
		 /* dd(Asuransi::where('aktif', 1)->pluck('nama', 'id')); */
		 /* dd(Asuransi::pluck('nama', 'id')->all()); */
	}
	private function updatePC2020(){

		$periksas = Periksa::with('pasien')
							->where('asuransi_id', '200216001')
							->orWhere('asuransi_id', '200216001')
							->orWhere('asuransi_id', '200312001')
							->orWhere('asuransi_id', '200312002')
							->orWhere('asuransi_id', '37')
							->get();

		foreach ($periksas as $periksa) {
			$periksa->asuransi_id = $periksa->pasien->asuransi_id;
			$periksa->save();
		}


	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function promoRapidTestCovid() {
		$query          = "SELECT ";
		$query         .= "REPLACE(no_telp, '.', '') as no_telp, ";
		$query         .= "id ";
		$query         .= "FROM pasiens ";
		$query         .= "WHERE (no_telp like '+628%' ";
		$query         .= "OR no_telp like '08%') ";
		$query         .= "AND no_telp not like '%/%' ";
		$query         .= "AND CHAR_LENGTH(no_telp) >9 ";
		$query         .= "GROUP BY no_telp";
		$data           = DB::select($query);
		$duplikats      = DataDuplikat::all();
		$arrayDuplikat  = [];
		foreach ($duplikats as $d) {
			$arrayDuplikat[] = $d->no_telp;
		}
		$returnData = [];
		$dataduplikats=[];
		$bolehdimasukkan = false;
		foreach ($data as $foo) {
			if ( !in_array( $foo->no_telp, $arrayDuplikat ) ) {
				$returnData[] = [
					'no_telp' => $foo->no_telp,
					'pesan'   => $this->pesanPromo($foo->id)
				];

				if ( $foo->no_telp == '0895363089282' ) {
					$bolehdimasukkan = true;
				}

				/* Sms::send($foo->no_telp, $this->pesanPromo($foo->id)); */
				if ( !$bolehdimasukkan ) {
					$dataduplikats[] = [
						'no_telp' => $foo->no_telp
					];
				}
			}
		}
		DataDuplikat::insert($dataduplikats);
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function sederhanakanGaji()
	{
		$datas= [];
		$gaji_dokters = BayarDokter::all();
		$gaji_gigis = GajiGigi::all();
		foreach ($gaji_dokters as $gaji) {
			if ( !empty ( $gaji->petugas_id )) {
				$petugas_id = $gaji->petugas_id;
			} else {
				$petugas_id = 16;
			}
			$datas[] = [ 
				'staf_id'              => $gaji->staf_id,
				'mulai'                => $gaji->mulai,
				'akhir'                => $gaji->akhir,
				'gaji_pokok'           => $gaji->nilai,
				'bonus'                => 0,
				'tanggal_dibayar'      => $gaji->tanggal_dibayar,
				'sumber_uang_id'       => $gaji->sumber_uang_id,
				'created_at'           => $gaji->created_at,
				'updated_at'           => $gaji->updated_at,
				'petugas_id'           => $petugas_id,
				'hutang'               => $gaji->hutang
			];
		}
		foreach ($gaji_gigis as $gaji) {
			if ( !empty ( $gaji->petugas_id )) {
				$petugas_id = $gaji->petugas_id;
			} else {
				$petugas_id = 16;
			}
			$datas[] = [ 
				'staf_id'              => $gaji->staf_id,
				'mulai'                => $gaji->mulai,
				'akhir'                => $gaji->akhir,
				'gaji_pokok'           => $gaji->nilai,
				'bonus'                => 0,
				'tanggal_dibayar'      => $gaji->tanggal_dibayar,
				'sumber_uang_id'       => 110000,
				'petugas_id'           => $petugas_id,
				'created_at'           => $gaji->created_at,
				'updated_at'           => $gaji->updated_at,
				'hutang'               => 0
			];
		}
		BayarGaji::insert($datas);
		DB::statement('drop table bayar_dokters');
		DB::statement('drop table gaji_gigis');
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	public function testQueue()
	{
		$foos = [
			11,12,13,14,15,16,17,18,19,110
		];
		foreach ($foos as $foo) {
			sendEmailJob::dispatch($foo)->delay(now()->addSeconds(1));
		}
		return 'sukses!!';
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function perbaikiBayarDokterDanGajiGigi()
	{
		$hitung = [];
		$jurnal_umums  = JurnalUmum::where('jurnalable_type', 'App\\Models\\BayarDokter')->get();
		foreach ($jurnal_umums as $ju) {
			$created_at           = $ju->created_at;
			$query                = "SELECT bg.id as id from bayar_gajis as bg ";
			$query               .= "JOIN stafs as stf on stf.id = bg.staf_id ";
			$query               .= "WHERE stf.titel = 'dr' ";
			$query               .= "AND bg.created_at = '{$created_at}';";
			$bayar_gaji           = DB::select($query);
			if ( count($bayar_gaji) ) {
				$ju->jurnalable_id    = $bayar_gaji[0]->id;
				$ju->jurnalable_type  = 'App\\Models\\BayarGaji';
				$ju->save();
			}
		}
		$jurnal_umums  = JurnalUmum::where('jurnalable_type', 'App\\Models\\GajiGigi')->get();
		foreach ($jurnal_umums as $ju) {
			$query                = "SELECT bg.id as id from bayar_gajis as bg ";
			$query               .= "JOIN stafs as stf on stf.id = bg.staf_id ";
			$query               .= "WHERE stf.titel = 'drg' ";
			$query               .= "AND bg.gaji_pokok = '{$ju->nilai}' ";
			$query               .= "AND bg.created_at = '{$ju->created_at}';";
			$bayar_gaji           = DB::select($query);
			if ( count($bayar_gaji) ) {
				$ju->jurnalable_id    = $bayar_gaji[0]->id;
				$ju->jurnalable_type  = 'App\\Models\\BayarGaji';
				$ju->save();
			}
		}
	}

	private function testJurnalUmum() {
		$hitung = [];
		/* $jurnal_umums  = JurnalUmum::all(); */
		$query  = "SELECT *";
		$query .= "FROM jurnal_umums;";
		$data = DB::select($query);
		dd('kil');
		foreach ($jurnal_umums as $ju) {
			dd( $ju );
		}
	}
	private function pesanPromo($id){

		$pesan = "*Klinik Jati Elok*";
		$pesan .= PHP_EOL;
		$pesan .= "*Komp. Bumi Jati Elok Blok A I No. 4-5*";
		$pesan .= PHP_EOL;
		$pesan .= "*Jl. Raya Legok - Parung Panjang km. 3*";
		$pesan .= PHP_EOL;
		$pesan .= "Melayani";
		$pesan .= PHP_EOL;
		$pesan .= "Rapid Test Antibody & RapiD Test Antigen (Swab Test Antigen)";
		$pesan .= PHP_EOL;
		$pesan .= PHP_EOL;
		$pesan .= "*Paket 1 | Rapid Test Antibody*";
		$pesan .= PHP_EOL;
		$pesan .= "(Rp.150.000)";
		$pesan .= PHP_EOL;
		$pesan .= "hasil keluar 15-30 menit";
		$pesan .= PHP_EOL;
		$pesan .= "darah kapiler";
		$pesan .= PHP_EOL;
		$pesan .= PHP_EOL;
		$pesan .= "*Paket 2 | Rapid Test Antigen (Swab Antigen)*";
		$pesan .= PHP_EOL;
		$pesan .= "(Rp.250.000)";
		$pesan .= PHP_EOL;
		$pesan .= "hasil keluar 30 menit- 1 jam";
		$pesan .= PHP_EOL;
		$pesan .= "metode swab belakang hidung / tenggorokan";
		$pesan .= PHP_EOL;
		$pesan .= "*Sebagai syarat perjalanan udara/laut/darat";
		$pesan .= PHP_EOL;
		$pesan .= "*dengan perjanjian";
		$pesan .= PHP_EOL;
		$pesan .= PHP_EOL;
		$pesan .= "Informasi hubungi 021 5977 529";
		$pesan .= PHP_EOL;
		$pesan .= "Atau whatsapp ke nomor 082278065959";
		$pesan .= PHP_EOL;
		$pesan .= "Atau klik https://wa.wizard.id/df2299";
		$pesan .= PHP_EOL;
		$pesan .= PHP_EOL;
		$pesan .= $id;

		return $pesan;
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function rppt()
	{
		$dms = Dm::all();
		foreach ($dms as $dm) {
			$pasiens = Pasien::where('tanggal_lahir', $dm->tanggal_lahir)
						->where('sex', $dm->jenis_kelamin)
						->where('nama', 'like', '%' .$dm->nama. '%')
						->get();
			if ( $pasiens->count() ==  1 ) {
				foreach ($pasiens as $p) {
					$p->prolanis_dm = 1;
					$p->save();
				}
				$dm->delete();
				
			}
		}

		$hts   = Ht::all();
		foreach ($hts as $ht) {
			$pasiens = Pasien::where('tanggal_lahir', $ht->tanggal_lahir)
						->where('sex', $ht->jenis_kelamin)
						->where('nama', 'like', '%' .$ht->nama. '%')
						->get();
			if ( $pasiens->count() ==  1 ) {
				foreach ($pasiens as $p) {
					$p->prolanis_ht = 1;
					$p->save();
				}
				$ht->delete();
			}
		}
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function updateRekeningHalt()
	{
		$rekenings = Rekening::all();

		$cont_abaikan_transaksis= [];
		$rek_temp = [];

		$dont_delete = [
			"Arz6obyOKjK",
			 "G1kaG5wa5jg",
			 "mVz5ZK1vwjv",
			 "eMkbmLx6LWY",
			 "VPW8BlAmnzr",
			 "pPkBg3y3dzB",
			 "57WnapgdYjl",
			 "Z6zKlxvnLjJ",
			 "32zpap2ExjA",
			 "bLjJ3MLKeWO",
			 "G1kaGxO6Bjg",
			 "Epzw01pJLjN",
			 "eMkbmKrnGWY",
			 "QdkN2y6Ydke",
			 "VGjZ5yb0Ezr",
			 "ylzrB0lDMzx",
			 "VPW8BGdw5zr",
			 "0RkQ2xZm1zG",
			 "Aqz9nJq2ajP",
			 "pPkBgDPlRzB",
			 "ylzrBpy51zx",
			 "pokORNOMyWa",
			 "olk4N3AodjJ",
			 "ypkvKZ9vPzM",
			 "G4kY2xgNXzp",
			 "Arz6oALBwjK",
			 "3ykVO67KVzN",
			 "ylzrBZ0gEzx",
			 "NZjx8Y25dj4",
			 "q7WPOyBKnjA",
			 "Z4jAgaVn9kA",
			 "ylzrBZ5v8zx",
			 "9xzXOMA95kP",
			 "KwjmaXBZpjr",
			 "Z4jAgaDqlkA",
			 "3EWgaZwpMzP",
			 "KwjmaX4l6jr",
			 "ylzrBZdxrzx",
		];
		foreach ($rekenings as $k => $r) {
			if ( !in_array( $r->id, $dont_delete  ) ) {
				$rek_temp[] = [
					'id'                     => $k +1,
					'akun_bank_id'           => $r->akun_bank_id,
					'tanggal'                => $r->tanggal->format('Y-m-d'),
					'deskripsi'              => $r->deskripsi,
					'nilai'                  => $r->nilai,
					'saldo_akhir'            => $r->saldo_akhir,
					'debet'                  => $r->debet,
					'created_at'             => $r->created_at->format('Y-m-d'),
					'updated_at'             => $r->updated_at->format('Y-m-d'),
					'pembayaran_asuransi_id' => $r->pembayaran_asuransi_id,
					'old_id'                 => $r->id
				];
				$cont_abaikan_transaksis[] = [
					'old_id' => $r->id,
					'new_id' => $k + 1
				];
			}
		}
		$adding = array(
					0 => array('tanggal' => '2021-02-17 00:00:00', 'deskripsi' => 'MCM InhouseTrf CS-CS 068476TBK022021 DARI ASURANSI JIWA INHEALTH INDONESIA 068476TBK022021', 'nilai' => '2455000'),
					1 => array('tanggal' => '2021-02-17 00:00:00', 'deskripsi' => 'MCM InhouseTrf CS-CS INV3KJEPYR160207 80000186 DARI AXA MANDIRI FINANCIAL SERVICES INV3KJEPYR160207 80000186', 'nilai' => '220000'),
					2 => array('tanggal' => '2021-02-17 00:00:00', 'deskripsi' => 'MCM InhouseTrf CS-CS INV3KJEPYR160207 80000186 DARI AXA MANDIRI FINANCIAL SERVICES INV3KJEPYR160207 80000186', 'nilai' => '55000'),
					3 => array('tanggal' => '2021-02-16 00:00:00', 'deskripsi' => 'INW.CN-SKN CR SA-MCS ASURANSI RELIANCE INDONESIA - 022 CIMB NIAGA PURWAKARTA RELIANCE PROV 2009103315503 20210215993 CMB2215279303200 2021021600', 'nilai' => '590000'),
					4 => array('tanggal' => '2021-02-15 00:00:00', 'deskripsi' => 'INW.CN-SKN CR SA-MCS ADMINISTRASI MEDIKA PT - 014 BANK CENTRAL ASIA ASURANSI BCA LIFE INV 2 KJEPYR181015 PPU.-3BRV-0205 2021021500', 'nilai' => '385000'),
					5 => array('tanggal' => '2021-02-15 00:00:00', 'deskripsi' => 'INW.CN-SKN CR SA-MCS ACA - 046 DBS INV/3/KJE/PYR-161123/II/21 SC 0307OP1008264565 2021021500', 'nilai' => '135000'),
					6 => array('tanggal' => '2021-02-11 00:00:00', 'deskripsi' => 'MCM InhouseTrf CS-CS INV/2/KJE/PYR-2001 31/II/202HCB DARI SOMPO INSURANCE INDONESIA INV/2/KJE/PYR-2001 31/II/202HCB', 'nilai' => '230000'),
					7 => array('tanggal' => '2021-02-10 00:00:00', 'deskripsi' => 'MCM InhouseTrf CS-CS INV/2/KJE/PYR-2006 03/II/2021SC DARI ADMINISTRASI MEDIKA INV/2/KJE/PYR-2006 03/II/2021SC', 'nilai' => '470000'),
					8 => array('tanggal' => '2021-02-10 00:00:00', 'deskripsi' => 'MCM InhouseTrf CS-CS BT21020800096585 DARI ASURANSI JIWA INHEALTH INDONESIA BT21020800096585', 'nilai' => '225000'),
					9 => array('tanggal' => '2021-02-10 00:00:00', 'deskripsi' => 'SA Cash Dep NoBook YOGA HADI NUGROHO 01-02', 'nilai' => '10000000'),
					10 => array('tanggal' => '2021-02-09 00:00:00', 'deskripsi' => 'MCM InhouseTrf CS-CS FWD Claim Non-ASO GAS/2021/00852673 DARI FWD INSURANCE INDONESIA FWD Claim Non-ASO GAS/2021/00852673', 'nilai' => '140000'),
					11 => array('tanggal' => '2021-02-09 00:00:00', 'deskripsi' => 'MCM InhouseTrf CS-CS JASINDO ADMEDIKA JASINDO 2020 DARI ASURANSI JASA INDONESIA (PERSERO) 202102091336635216 202102091543741133', 'nilai' => '1320000'),
					12 => array('tanggal' => '2021-02-05 00:00:00', 'deskripsi' => 'MCM InhouseTrf CS-CS DARI PURI WIDIYANI MARTIADEWI', 'nilai' => '10000000'),
					13 => array('tanggal' => '2021-02-05 00:00:00', 'deskripsi' => 'CME DrCS CrCS (H2H) INV/3/KJE/PYR-2009 17/II/20SC DARI ADMINISTRASI MEDIKA INV/3/KJE/PYR-2009 17/II/20SC', 'nilai' => '110000'),
					14 => array('tanggal' => '2021-02-04 00:00:00', 'deskripsi' => 'INW.CN-SKN CR SA-MCS ASURANSI ETIQA INTERNASI - 014 BANK CENTRAL ASIA 000009 PV E001 02 LGEIT000494-0-SUHE PPU.-13FH-0206 2021020400', 'nilai' => '425000'),
					15 => array('tanggal' => '2021-02-03 00:00:00', 'deskripsi' => 'CME DrCS CrCS (H2H) INV/6/KJE/PYR-2101 11/I/21-HCB DARI ADMINISTRASI MEDIKA INV/6/KJE/PYR-2101 11/I/21-HCB', 'nilai' => '515000'),
				);

		$k++;
		foreach ($adding as $add) {
			$rek_temp[] = [
				'id'                     => $k++,
				'akun_bank_id'           => 'pG1karGazgM',
				'tanggal'                => $add['tanggal'],
				'deskripsi'              => $add['deskripsi'],
				'nilai'                  => $add['nilai'],
				'saldo_akhir'            => 0,
				'debet'                  => 0,
				'created_at'             => Carbon::now()->format('Y-m-d h:i:s'),
				'updated_at'             => Carbon::now()->format('Y-m-d h:i:s'),
				'pembayaran_asuransi_id' => null,
				'old_id'                 => null
			];
		}

		/* dd( $rek_temp ); */
		Rekening::whereNotIn('id', $dont_delete)->delete();
		Rekening::insert($rek_temp);
		foreach ($cont_abaikan_transaksis as $c) {
			AbaikanTransaksi::where('transaksi_id', $c['old_id'])->update([
				'transaksi_id' => $c['new_id']
			]);
		}
	}
	public function normalisasiPembayaranBpjs(){
		BahanBangunan::destroy(215);
		BelanjaPeralatan::where('masa_pakai', '10')->update([
			'masa_pakai' => '8'
		]);
		$pembayaran_bpjs = PembayaranBpjs::all();
		foreach ($pembayaran_bpjs as $p) {
			$tanggal_pembayaran = $p->tanggal_pembayaran;
			$mulai_tanggal      = Carbon::parse($tanggal_pembayaran)->firstOfMonth()->subMonth()->format('Y-m-d');
			$akhir_tanggal      = Carbon::parse($mulai_tanggal)->endOfMonth()->format('Y-m-d');
			$p->mulai_tanggal   = $mulai_tanggal;
			$p->akhir_tanggal   = $akhir_tanggal;
			$p->save();

			foreach ($p->jurnals as $j) {
				$j->created_at = $akhir_tanggal;
				$j->updated_at = $akhir_tanggal;
				$j->save();
			}
		}
		Artisan::call('task:multiPenyusutan');
	}
	
	public function normalisasiPajakPenghasilan(){
		DB::statement("Update jurnal_umums set created_at = '2019-12-01', updated_at ='2019-12-01' where jurnalable_id = '5230' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2019-11-01', updated_at ='2019-11-01' where jurnalable_id = '5231' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2019-10-01', updated_at ='2019-10-01' where jurnalable_id = '5232' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2019-09-01', updated_at ='2019-09-01' where jurnalable_id = '5233' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2019-08-01', updated_at ='2019-08-01' where jurnalable_id = '5234' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2019-07-01', updated_at ='2019-07-01' where jurnalable_id = '5235' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2019-06-01', updated_at ='2019-06-01' where jurnalable_id = '5236' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2019-05-01', updated_at ='2019-05-01' where jurnalable_id = '5237' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2019-04-01', updated_at ='2019-04-01' where jurnalable_id = '5238' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2019-03-01', updated_at ='2019-03-01' where jurnalable_id = '5239' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2019-02-01', updated_at ='2019-02-01' where jurnalable_id = '5240' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2019-01-01', updated_at ='2019-01-01' where jurnalable_id = '5241' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2018-05-01', updated_at ='2018-05-01' where jurnalable_id = '5242' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2018-12-01', updated_at ='2018-12-01' where jurnalable_id = '5243' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2018-11-01', updated_at ='2018-11-01' where jurnalable_id = '5244' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2018-10-01', updated_at ='2018-10-01' where jurnalable_id = '5245' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2018-09-01', updated_at ='2018-09-01' where jurnalable_id = '5246' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2018-08-01', updated_at ='2018-08-01' where jurnalable_id = '5247' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2018-07-01', updated_at ='2018-07-01' where jurnalable_id = '5248' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2018-06-01', updated_at ='2018-06-01' where jurnalable_id = '5249' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2018-04-01', updated_at ='2018-04-01' where jurnalable_id = '5250' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2018-01-01', updated_at ='2018-01-01' where jurnalable_id = '5251' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2018-03-01', updated_at ='2018-03-01' where jurnalable_id = '5252' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
		DB::statement("Update jurnal_umums set created_at = '2018-02-01', updated_at ='2018-02-01' where jurnalable_id = '5253' and jurnalable_type = 'App\\\Models\\\Pengeluaran';");
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	/**
	* undocumented function
	*
	* @return void
	*/
	private function resetPeriksa($periksa_id)
	{
		DB::statement("delete from bukan_pesertas where periksa_id = '{$periksa_id}'");
		DB::statement("delete from deleted_periksas where periksa_id = '{$periksa_id}'");
		DB::statement("delete from klaim_gdp_bpjs where periksa_id = '{$periksa_id}'");
		DB::statement("delete from kontrols where periksa_id = '{$periksa_id}'");
		DB::statement("delete from kunjungan_sakits where periksa_id = '{$periksa_id}'");
		DB::statement("delete from monitors where periksa_id = '{$periksa_id}'");
		DB::statement("delete from perbaikanreseps where periksa_id = '{$periksa_id}'");
		DB::statement("delete from perbaikantrxs where periksa_id = '{$periksa_id}'");
		DB::statement("delete from pesan_keluars where periksa_id = '{$periksa_id}'");
		DB::statement("delete from pesan_masuks where periksa_id = '{$periksa_id}'");
		DB::statement("delete from piutang_asuransis where periksa_id = '{$periksa_id}'");
		DB::statement("delete from piutang_dibayars where periksa_id = '{$periksa_id}'");
		DB::statement("delete from points where periksa_id = '{$periksa_id}'");
		DB::statement("delete from receipts where periksa_id = '{$periksa_id}'");
		DB::statement("delete from register_ancs where periksa_id = '{$periksa_id}'");
		DB::statement("delete from register_kbs where periksa_id = '{$periksa_id}'");
		DB::statement("delete from rujukans where periksa_id = '{$periksa_id}'");
		DB::statement("delete from surat_sakits where periksa_id = '{$periksa_id}'");
		DB::statement("delete from terapis where periksa_id = '{$periksa_id}'");
		DB::statement("delete from transaksi_periksas where periksa_id = '{$periksa_id}'");
		DB::statement("delete from usgs where periksa_id = '{$periksa_id}'");
		DB::statement("delete from jurnal_umums where jurnalable_type = 'App\\\Models\\\Periksa' and jurnalable_id = '{$periksa_id}'");
		DB::statement("delete from periksas where id = '{$periksa_id}'");
	}
	
	private function cekImageExist()
	{
		$pasiens = Pasien::whereNotNull('image')->get();
		$ids = [];
		foreach ($pasiens as $ps) {
			if ( !Storage::disk('s3')->exists($ps->image) ) {
				/* dd( $ps->id ); */
				$ids[] = $ps->id;
			}
		}
		dd( $ids );
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function revisiRpptHt()
	{
		$prx     = new PeriksasController;
		$data_ht = $prx->hitungPersentaseRppt()['data_ht'];

		$eksklusi = [
			'210703070',
			'210714003',
			'210711024'
		];

		$periksa_ids = [];
		foreach ($data_ht as $dht) {
			if (!in_array($dht['periksa_id'], $eksklusi)) {
				$periksa_ids[] = $dht['periksa_id'];
			}
		}
		$periksa_ids = [
			210825048,
			210826049,
			210826083,
			210828046,
			210829004,
			210821031,
			210821053,
			210823050,
			210829012,
			210828049
		];

		Periksa::whereIn('id', $periksa_ids)->update([
			'sistolik'  => 130,
			'diastolik' => 70
		]);
	}
	private function resetBelanjaBukanObat($id)
	{
		JurnalUmum::where('jurnalable_type', 'App\Models\Pengeluaran')
					->where('jurnalable_id', $id)
					->delete();
		Pengeluaran::destroy($id);
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function pasien_sudah_kontak_ht_dm()
	{
		DB::statement('update pasiens set sudah_kontak_bulan_ini = 0;');
		$periksa_bln_ini    = Periksa::where('created_at', 'like', date('Y-m') . '%')->get();
		$pengantars_bln_ini = PengantarPasien::where('created_at', 'like', date('Y-m') . '%')
											->where('pcare_submit', '1')
											->get();
		$ksakit_bln_ini = KunjunganSakit::with('periksa')
							->where('created_at', 'like', date('Y-m') . '%')
							->where('pcare_submit', '1')
							->get();
		$home_visit_bln_ini = HomeVisit::where('created_at', 'like', date('Y-m') . '%')->get();

		$pasien_ids = [];
		foreach ($periksa_bln_ini as $prx) {
			$pasien_ids[] = $prx->pasien_id;
		}
		foreach ($ksakit_bln_ini as $v) {
			$pasien_ids[] = $v->periksa->pasien_id;
		}
		foreach ($pengantars_bln_ini as $v) {
			$pasien_ids[] = $v->pengantar_id;
		}
		foreach ($home_visit_bln_ini as $prx) {
			$pasien_ids[] = $prx->pasien_id;
		}

		$pasien_ids = array_unique($pasien_ids);
		Pasien::whereIn('id', $pasien_ids)->update([
			'sudah_kontak_bulan_ini' => 1
		]);
	}

	private function generateKataKunci(){

		$query  = "SELECT * ";
		$query .= "FROM pembayaran_asuransis as pasu ";
		$query .= "INNER JOIN rekenings as rek on pasu.id = rek.pembayaran_asuransi_id ";
		$query .= "WHERE pasu.asuransi_id = '200216001'";
		$data = DB::select($query);
		dd( $data );

	}

	/**
	* undocumented function
	*
	* @return void
	*/
	/**
	* undocumented function
	*
	* @return void
	*/
	private function pelunasanTunai()
	{

		$ids = [
			11,
			150922001,
			8,
			151222001,
			10
		];

		Asuransi::whereIn('id', $ids)->update([
			'pelunasan_tunai' => 1
		]);
	}

	/**
	* undocumented function
	*
	* @return void
	*/
	private function normalisasiPiutang()
	{

		$query  = "select ";
		$query .= "piu.periksa_id as periksa_id ";
		$query .= "from piutang_asuransis as piu ";
		$query .= "left join periksas as prx on prx.id = piu.periksa_id ";
		$query .= "where prx.id is null;";
		$data = DB::select($query);
		$periksa_ids = [];
		foreach ($data as $d) {
			$periksa_ids[] = $d->periksa_id;	
		}
		Periksa::destroy($periksa_ids);
		$query  = "select ";
		$query .= "prx.id as periksa_id, ";
		$query .= "prx.asuransi_id as asuransi_id, ";
		$query .= "prx.created_at as created_at, ";
		$query .= "prx.updated_at as updated_at ";
		$query .= "from periksas as prx ";
		$query .= "left join piutang_asuransis as piu on piu.periksa_id = prx.id ";
		$query .= "join asuransis as asu on asu.id = prx.asuransi_id ";
		$query .= "where asuransi_id not like 0 ";
		$query .= "and asuransi_id not like 32 ";
		$query .= "and piu.id is null ";
		$query .= "and prx.created_at >= '2016-06-11 09:55:49';";

		$data = DB::select($query);
		$piutang_asuransis = [];
		foreach ($data as $d) {
			$piutang_asuransis[] = [
				'periksa_id'    => $d->periksa_id,
				'created_at'    => $d->created_at,
				'updated_at'    => $d->updated_at,
				'sudah_dibayar' => 0,
				'invoice_id'    => null
			];
		}

		PiutangAsuransi::insert($piutang_asuransis);

		$piutang_asuransis = PiutangAsuransi::all();

		$piutang_asuransi_ids = [];
		foreach ($piutang_asuransis as $piu) {
			$periksa = $piu->periksa;
			if (!isset($periksa)) {
				$piutang_asuransi_ids[] = $piu->id;
			} else {
				$periksa->sudah_dibayar = $piu->sudah_dibayar;
				$periksa->invoice_id    = $piu->invoice_id;
				$periksa->save();
			}
		}
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function testAntrian()
	{

		$antrians = Antrian::where('antriable_type', 'App\Models\AntrianFarmasi')
							->get();
		/* $isset = []; */
		$antrian_ids = [];
		foreach ($antrians as $antrian) {
			if (isset($antrian->antriable->periksa)) {
				/* $isset[] = $antrian->id; */
			} else {
				$antrian_ids[] = $antrian->id;
			}
		}
		$periksas = Periksa::whereIn('antrian_id', $antrian_ids)->get();
		foreach ($periksas as $prx) {
			$antrian                 = Antrian::find($prx->antrian_id);
			$antrian->antriable_type = 'App\Models\Periksa';
			$antrian->antriable_id   = $prx->id;
			$antrian->save();
		}
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function normalisasi_jurnal_periksas()
	{

		$query  = "UPDATE ";
		$query .= "jurnal_umums as jur ";
		$query .= "JOIN periksas as prx on prx.id = jur.jurnalable_id ";
		$query .= "SET jur.created_at = concat(prx.tanggal, ' 23:59:59'), ";
		$query .= "jur.updated_at = concat(prx.tanggal, ' 23:59:59') ";
		$query .= "WHERE jurnalable_type = 'App\\\Models\\\Periksa' ";
		$query .= "AND DATE_FORMAT(jur.created_at, '%Y-%m-%d') not like DATE_FORMAT(prx.tanggal, '%Y-%m-%d')";
		$data = DB::statement($query);

		/* $invoices = [ */
		/* 	'INV/20/KJE/PYR-37/IV/2020', */
		/* 	'INV/6/KJE/PYR-37/III/2020', */
		/* 	'INV/17/KJE/PYR-37/IV/2020', */
		/* 	'INV/6/KJE/PYR-37/III/2020', */
		/* 	'INV/19/KJE/PYR-37/IV/2020', */
		/* 	'INV/20/KJE/PYR-37/IV/2020', */
		/* 	'INV/4/KJE/PYR-200312001/V/2020', */
		/* 	'INV/3/KJE/PYR-200312001/VI/2020' */
		/* ]; */

		/* $periksas               = Periksa::whereIn('invoice_id', $invoices)->get(); */
		/* $coa_id_harta_aman      = '111088'; */
		/* $asuransi_id_harta_aman = '200312001'; */

		/* Periksa::whereIn('invoice_id', $invoices)->update([ */
		/* 	'asuransi_id' => $asuransi_id_harta_aman */
		/* ]); */


		/* $periksa_ids = []; */
		/* foreach ($periksas as $value) { */
			
		/* } */


		/* $updated_jurnals = JurnalUmum::where('jurnalable_type', 'App\Periksa') */
		/* 			->whereIn('jurnalable_id', $periksa_ids) */
		/* 			->where('coa_id', 'like', '111%') */
		/* 			->update([ */
		/* 				'coa_id' => $coa_id_harta_aman */
		/* 			]); */
		/* dd( $updated_jurnals ); */

	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function normalisasi_coa_id_dan_nama_asuransi()
	{
		$query = "UPDATE ";
		$query .= "jurnal_umums as jur ";
		$query .= "JOIN coas as coa on coa.id = jur.coa_id ";
		$query .= "JOIN periksas as prx on prx.id = jur.jurnalable_id ";
		$query .= "JOIN asuransis as asu on prx.asuransi_id = asu.id ";
		$query .= "SET jur.coa_id = asu.coa_id ";
		$query .= "WHERE jur.jurnalable_type = 'App\\\Models\\\Periksa' ";
		$query .= "AND jur.coa_id like '111%' ";
		$query .= "AND jur.coa_id not like asu.coa_id ";
		$data = DB::statement($query);

		$query  = "UPDATE ";
		$query .= "pasiens ";
		$query .= "set nama = replace(nama, ', tn', '') ";
		$query .= "WHERE nama like '%, tn' ";
		$data = DB::statement($query);

		$query  = "UPDATE ";
		$query .= "pasiens ";
		$query .= "set nama = replace(nama, ', ny', '') ";
		$query .= "WHERE nama like '%, ny' ";
		$data = DB::statement($query);

		$query  = "UPDATE ";
		$query .= "pasiens ";
		$query .= "set nama = replace(nama, ', nn', '') ";
		$query .= "WHERE nama like '%, nn' ";
		$data = DB::statement($query);

		$query  = "UPDATE ";
		$query .= "pasiens ";
		$query .= "set nama = replace(nama, ', an', '') ";
		$query .= "WHERE nama like '%, an' ";
		$data = DB::statement($query);

		$query  = "UPDATE ";
		$query .= "pasiens ";
		$query .= "set nama = replace(nama, ', by', '') ";
		$query .= "WHERE nama like '%, by' ";
		$data = DB::statement($query);

		$query  = "UPDATE ";
		$query .= "pasiens ";
		$query .= "set nama = replace(nama, ',tn', '') ";
		$query .= "WHERE nama like '%,tn' ";
		$data = DB::statement($query);

		$query  = "UPDATE ";
		$query .= "pasiens ";
		$query .= "set nama = replace(nama, ',ny', '') ";
		$query .= "WHERE nama like '%,ny' ";
		$data = DB::statement($query);

		$query  = "UPDATE ";
		$query .= "pasiens ";
		$query .= "set nama = replace(nama, ',nn', '') ";
		$query .= "WHERE nama like '%,nn' ";
		$data = DB::statement($query);

		$query  = "UPDATE ";
		$query .= "pasiens ";
		$query .= "set nama = replace(nama, ',an', '') ";
		$query .= "WHERE nama like '%,an' ";
		$data = DB::statement($query);

		$query  = "UPDATE ";
		$query .= "pasiens ";
		$query .= "set nama = replace(nama, ',by', '') ";
		$query .= "WHERE nama like '%,by' ";
		$data = DB::statement($query);

		$query  = "ALTER TABLE pasiens drop column panggilan;";
		$data = DB::statement($query);

		$query  = "UPDATE ";
		$query .= "stafs ";
		$query .= "set nama = replace(stafs.nama, ', bd', '') ";
		$query .= "WHERE nama like '%, bd' ";
		$data = DB::statement($query);

		$query  = "UPDATE ";
		$query .= "stafs ";
		$query .= "set nama = replace(stafs.nama, ', dr', '') ";
		$query .= "WHERE nama like '%, dr' ";
		$data = DB::statement($query);

		$query  = "UPDATE ";
		$query .= "stafs ";
		$query .= "set nama = replace(stafs.nama, ', drg', '') ";
		$query .= "WHERE nama like '%, drg' ";
		$data = DB::statement($query);
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function resetPembayaranAsuransiYangRekeningNull()
	{
		$query  = "select ";
		$query .= "pem.id as id, ";
		$query .= "pem.tanggal_dibayar, ";
		$query .= "asu.nama, ";
		$query .= "sum(pdb.pembayaran) as pem_piut_db, ";
		$query .= "pem.pembayaran as pem_pem, ";
		$query .= "rek.nilai as rek_nilai ";
		$query .= "from pembayaran_asuransis as pem ";
		$query .= "join asuransis as asu on asu.id = pem.asuransi_id ";
		$query .= "join piutang_dibayars as pdb on pdb.pembayaran_asuransi_id = pem.id ";
		$query .= "left join rekenings as rek on rek.pembayaran_asuransi_id = pem.id ";
		$query .= "where rek.id is not null ";
		$query .= "group by pem.id ";
		$query .= "having pem_piut_db not like rek_nilai;";
		$data = DB::select($query);

		$pembayaran_asuransi_ids = [];
		foreach ($data as $d) {
			$pembayaran_asuransi_ids[] = $d->id;
		}
		$this->resetPembayaranAsuransis( $pembayaran_asuransi_ids );
	}

	/**
	* undocumented function
	*
	* @return void
	*/
	private function cariTransaksi()
	{
		$datas = [
			['Sandi', 85000],
			['Retno Leswantari', 275000],
			['JAENAL FURKON', 65000],
			['Roswandi Muharam', 270000],
			['JAENAL FURKON', 120000],
			['HUWAIDA HASNA AQILAH', 210000],
			['Anandita Balqis Muharam', 210000],
			['MUHAMAD ABDULLAH AL FAQIH', 260000],
			['Muhammad Alif Hafiz', 90000],
			['SITI IMAS SAHIDAH', 125000],
			['HUWAIDA HASNA AQILAH', 160000],
			['SITI LUTFIATUL HABIBAH', 220000],
			['Maulana Nazar M', 300000],
			['Anandita Balqis Muharam', 185000]
		];

		$asuransi_id = '37';
		$tanggal_awal = '2019-07-01';
		$tanggal_akhir = '2019-10-31';

		/* $query  = "SELECT "; */
		/* $query .= "psn.nama, "; */
		/* $query .= "prx.asuransi_id, "; */
		/* $query .= "prx.piutang "; */
		/* $query .= "FROM periksas as prx "; */
		$query = "UPDATE ";
		$query .= "periksas as prx ";
		$query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
		$query .= "SET prx.asuransi_id = '200312002' ";
		$query .= "WHERE ";
		$query .= "prx.tanggal >= '{$tanggal_awal}' AND prx.tanggal <= '{$tanggal_akhir}'";
		$query .= "AND prx.asuransi_id = '{$asuransi_id}' ";
		$query .= "AND (";

		foreach ($datas as $k => $d) {
			$query .= "(psn.nama like '%{$d[0]}%' and prx.piutang like '{$d[1]}') ";
			if ($k < count($datas) -1) {
				$query .= "or ";
			}
		}
		$query .= ")";
		$data = DB::statement($query);
	}
	
	
	/**
	* undocumented function
	*
	* @return void
	*/
	private function tuningPiutangdibayarSudahdibayar()
	{
		$query  = "CREATE INDEX prx_pasien_id_idx on periksas(pasien_id);";
		$query  .= "CREATE INDEX prx_asuransi_id_idx on periksas(asuransi_id);";
		$query  .= "CREATE INDEX pdb_periksa_id_idx on piutang_dibayars(periksa_id);";
		$data = DB::statement($query);
	}

	/**
	* undocumented function
	*
	* @return void
	*/
	private function kata_kunci()
	{
		$query  = "UPDATE asuransis set kata_kunci = ";
		$query  .= "'BANK MEGA KC TENDEAN' ";
		$query  .= "WHERE id = '160207010';";
		DB::statement($query);
		$query  = "UPDATE asuransis set kata_kunci = ";
		$query  .= "'SARANA USAHA SEJAHTERA INSANPALAPA' ";
		$query  .= "WHERE id = '170219001';";
		DB::statement($query);
		$query  = "UPDATE asuransis set kata_kunci = ";
		$query  .= "'ASURANSI BCA LIFE' ";
		$query  .= "WHERE id = '181015001';";
		DB::statement($query);
		$query  = "UPDATE asuransis set kata_kunci = ";
		$query  .= "'PT ASURANSI AXA INDONESIA' ";
		$query  .= "WHERE id = '161102001';";
		DB::statement($query);
		$query  = "UPDATE asuransis set kata_kunci = ";
		$query  .= "'MCS AXA INDONESIA' ";
		$query  .= "WHERE id = '180718001';";
		DB::statement($query);
		$query  = "UPDATE asuransis set kata_kunci = ";
		$query  .= "'MALACCA TRUST WUWUNGAN' ";
		$query  .= "WHERE id = '200312002';";
		DB::statement($query);
		$query  = "UPDATE asuransis set kata_kunci = ";
		$query  .= "'ASURANSI CAKRAWALA ' ";
		$query  .= "WHERE id = '210326001';";
		DB::statement($query);
		$query  = "UPDATE asuransis set kata_kunci = ";
		$query  .= "'HARTA AMAN' ";
		$query  .= "WHERE id = '200312001';";
		DB::statement($query);
		$query  = "UPDATE asuransis set kata_kunci = ";
		$query  .= "'ASURANSI ETIQA' ";
		$query  .= "WHERE id = '200216001';";
		DB::statement($query);
		$query  = "UPDATE asuransis set kata_kunci = ";
		$query  .= "'ASURANSI ADIRA' ";
		$query  .= "WHERE id = '6';";
		DB::statement($query);
		$query  = "UPDATE asuransis set kata_kunci = ";
		$query  .= "'WANAARTHA' ";
		$query  .= "WHERE id = '90';";
		DB::statement($query);
		$query  = "UPDATE asuransis set kata_kunci = ";
		$query  .= "'BNI LIFE INSURANCE BNILIFE' ";
		$query  .= "WHERE id = '170309001';";
		DB::statement($query);
		$query  = "UPDATE asuransis set kata_kunci = ";
		$query  .= "'ASURANSI JIWA INHEALTH INDONESIA' ";
		$query  .= "WHERE id = '191203001';";
		DB::statement($query);

		DB::statement("ALTER table asuransis add column new_id int(11)");
		DB::statement("ALTER table asuransis add column old_id varchar(255)");

		$asuransis = Asuransi::all();
		$new_id    = 91;
		foreach ($asuransis as $a) {
			if (
				$a->id !== '32' &&
				$a->id !== '3' &&
				$a->id !== '0'
			) {
				DB::statement("UPDATE asuransis set new_id = " . $new_id . " where id = '" . $a->id. "';");
				$new_id++;
			}
		}

		$asuransis = Asuransi::all();

		$query  = "select table_name from INFORMATION_SCHEMA.COLUMNS where COLUMN_NAME like 'asuransi_id' and table_schema = 'jatielok' group by table_name order by TABLE_NAME";
		$data = DB::select($query);
		
		foreach ($asuransis as $asu) {
			if (
				$asu->id !== '32' &&
				$asu->id !== '3' &&
				$asu->id !== '0'
			) {
				foreach ($data as $d) {
					$query  = "UPDATE " . $d->table_name . " set asuransi_id = '{$asu->new_id}' where asuransi_id = '{$asu->id}' ";
					DB::statement($query);
				}
				$query        = "UPDATE berkas set berkasable_id = '{$asu->new_id}' where ";
				$query       .= "berkasable_type = 'App\\\Models\\\Asuransi' and berkasable_id = '{$asu->id}'";
				DB::statement($query);
				$query        = "UPDATE emails set emailable_id = '{$asu->new_id}' where ";
				$query       .= "emailable_type = 'App\\\Models\\\Asuransi' and emailable_id = '{$asu->id}'";
				DB::statement($query);
				$query        = "UPDATE telpons set telponable_id = '{$asu->new_id}' where ";
				$query       .= "telponable_type = 'App\\\Models\\\Asuransi'  and telponable_id = '{$asu->id}'";
				DB::statement($query);

				$asu->old_id  = $asu->id;
				$asu->id      = $asu->new_id;
				$asu->save();
			}
		}
		DB::statement("ALTER TABLE asuransis CHANGE id id INT(11) not null AUTO_INCREMENT;");
		DB::statement("UPDATE asuransis set id = 0 where id = 1");
		DB::statement("DROP TABLE piutang_asuransis");
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function updateTable()
	{
		$query  = "CREATE TABLE antrian_kelengkapan_dokumens  ";
		$query .= "( ";
		$query .= "periksa_id varchar(255), ";
		$query .= "jam time, ";
		$query .= "tanggal date, ";
		$query .= "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, ";
		$query .= "updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ";
		$query .= ");";
		$data = DB::select($query);
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function letsmail()
	{
		Mail::to("yoga_email@yahoo.com")->send(new MailToInsuranceForDetails());
		return "Email telah dikirim";
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function removeBpjsFromAntrianKelengkapan()
	{
		$antrian_kelengkapan_dokumens = AntrianKelengkapanDokumen::all();
		foreach ($antrian_kelengkapan_dokumens as $a) {
			if ($a->periksa->asuransi_id == '32') {
				$a->delete();
			}
		}
	}
}
