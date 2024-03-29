<?php
namespace App\Http\Controllers;


use App\Http\Requests;
use Input;
use Log;
use DB;
use Moota;
use App\Models\Asuransi;
use App\Models\Antrian;
use App\Models\Telpon;
use App\Models\CheckoutKasir;
use App\Models\BayarGaji;
use App\Models\Pasien;
use App\Models\User;
use App\Models\Staf;
use App\Models\Rak;
use App\Models\JurnalUmum;
use App\Models\TransaksiPeriksa;
use App\Models\Terapi;
use App\Models\Dispensing;
use App\Models\Rujukan;
use App\Models\SuratSakit;
use App\Models\RegisterAnc;
use App\Models\Usg;
use App\Models\GambarPeriksa;
use App\Models\Periksa;
use App\Models\Merek;
use App\Models\BukanPeserta;
use App\Models\Formula;
use App\Models\Komposisi;
use App\Models\Classes\Yoga;
use App\Models\AkunBank;
use App\Models\Rekening;
use App\Http\Handler;
use App\Jobs\sendEmailJob;
use App\Console\Commands\sendMeLaravelLog;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Vultr\VultrClient;
use Vultr\Adapter\GuzzleHttpAdapter;
use App\Imports\PembayaranImport;
use Maatwebsite\Excel\Facades\Excel;


class TestController extends Controller
{

	public function index(){
        return view('tests.index');
	}
	public function post(){
		if (Input::hasFile('rekening')) {
			$file =Input::file('rekening'); //GET FILE
			$excel_pembayaran = Excel::toArray(new PembayaranImport, $file)[0];
			$data = [];
			$timestamp = date('Y-m-d H:i:s');
			foreach ($excel_pembayaran as $k => $e) {
				$data[] = [
					'id' => $k +1,
					'akun_bank_id' => 'wnazGyxGWGA',
					'tanggal'      => $e['tanggal'],
					'deskripsi'    => $e['deskripsi'],
					'nilai'        => $e['nilai'],
					'saldo_akhir'  => 0,
					'debet'        => 0,
							'tenant_id'  => session()->get('tenant_id'),
					'created_at' => $timestamp,
					'updated_at' => $timestamp
				];
			}
			Rekening::insert($data);
		}  
	}
	public function test(){

		dd( Antrian::orderBy('updated_at', 'desc')->first() );
		
	}
	public function testQueue(){
		$foos = [
			11,12,13,14,15,16,17,18,19,110
		];
		foreach ($foos as $foo) {
			sendEmailJob::dispatch($foo)->delay(now()->addSeconds(1));
		}
		return 'sukses!!';
	}
	public function pusher(){
		return view('pusher');
	}
	
	
}
