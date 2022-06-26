<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Classes\Yoga;
use App\Models\Penyusutan;
use App\Models\FakturBelanja;
use App\Models\Pengeluaran;
use App\Models\JurnalUmum;
use App\Models\BahanBangunan;
use DB;
use Log;
use Input;
use App\Http\Controllers\JurnalUmumsController;
use App\Console\Commands\JadwalPenyusutan;

class BahanBangunansController extends Controller
{
	public function konfirmasi($bulan, $tahun){
		$bulanIni = $tahun . '-' . $bulan . '-01';
		
		if (session()->has('route_coa')) {
			$route = session('route_coa');
		} else {
			$route = 'laporans';
		}
		$datas = BahanBangunan::whereNull('tanggal_renovasi_selesai')
			->whereRaw("tanggal_terakhir_dikonfirmasi < '{$bulanIni}' or tanggal_terakhir_dikonfirmasi is null")
			->get();

		return view('bahan_bangunans.konfirmasi', compact(
			'datas',
			'route',
			'bulan',
			'tahun'
		));
	}
	public function konfirmasiPost($bulan, $tahun){
		$rules           = [
			'konfirmasi'        => 'required',
			'bangunan_permanen' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$konfirmasi               = Input::get('konfirmasi');
		$bangunan_permanen        = Input::get('bangunan_permanen');
		$tanggal_renovasi_selesai = Yoga::datePrep( Input::get('tanggal_renovasi_selesai') );
		$hariIni                  = date('Y-m-d H:i:s');
		$bulanIni                 = $tahun . '-' . $bulan . '-01';
		$updateParameter          = [ 'tanggal_terakhir_dikonfirmasi' => $hariIni ];

		if ($konfirmasi) {

			$updateParameter['tanggal_renovasi_selesai'] = $tanggal_renovasi_selesai;
			$updateParameter['bangunan_permanen']        = $bangunan_permanen;
		}

		BahanBangunan::whereRaw("tanggal_renovasi_selesai is null and (  tanggal_terakhir_dikonfirmasi < '{$bulanIni}' or tanggal_terakhir_dikonfirmasi is null )")
			->update($updateParameter);
		$bahans = BahanBangunan::whereRaw("tanggal_renovasi_selesai is null and (  tanggal_terakhir_dikonfirmasi < '{$bulanIni}' or tanggal_terakhir_dikonfirmasi is null )")
			->get();

		$monthPassed = Yoga::diffMonth($tanggal_renovasi_selesai, date('Y-m-d'));
		if ($monthPassed) {
			$susut = new JadwalPenyusutan;
			$jurnals = [];
			$penyusutans  = [];
			$penyusutan_last_id = Penyusutan::orderBy('id', 'desc')->first()->id;
			for ($i = 0; $i < $monthPassed ; $i++) {
				$final = $this->xMonthAfter($tanggal_renovasi_selesai, ( (int)$i +1 ));
				$penyusutan_last_id++;
				$bayarPenyusutan = $susut->penyusutanBahanBangunan($bahans);
				$rekam = $susut->rekamPenyusutan(
					$penyusutan_last_id, 
					$bayarPenyusutan,  // nilai penyusutan
					'Penyusutan Bahan Bangunan',
					$final,
					120003, // Akumulasi Penyusutan Bahan Bangunan
					$penyusutans, // array penyusutans
					$jurnals// array jurnal_umum
				);
				$jurnals     = $rekam['jurnals'];
				$penyusutans = $rekam['penyusutans'];
			}
			Penyusutan::insert($penyusutans);
			JurnalUmum::insert($jurnals);
		}
		$pesan = Yoga::suksesFlash('Konfirmasi Bahan Bangunan Berhasil dilakukan');
		$path = Input::get('route');
		return redirect($path)->withPesan($pesan);
	}
	private function xMonthAfter($date, $x){
		$time = strtotime($date);
		return date("Y-m-d H:i:s", strtotime("+" . $x . " month", $time));
	}
	public function ikhtisarkan(){
		if (session()->has('route_coa')) {
			$route = session('route_coa');
		} else {
			$route = 'laporans';
		}
		$ju = new JurnalUmumsController;
		$pengeluarans = $ju->queryKonfirmasi(120010);
		return view('bahan_bangunans.ikhtisarkan', compact(
			'pengeluarans',
			'route'
		));
	}
	public function ikhtisarkanPost(){
		$temp = Input::get('temp');
		$route = Input::get('route');
		$nomor_faktur = Input::get('nomor_faktur');
		$arr = [];
		foreach ($temp as $t) {
			$t     = json_decode($t, true);
			$arr[] = $t;
		}
		$arr_by_fb_id = [];
		foreach ($arr as $ar) {
			foreach ($ar as $r) {
				$arr_by_fb_id[ $r['pg_id'] ][] = $r;
			}
		}
		$bahan_bangunans = [];
		$faktur_belanjas = [];
		$pengeluaran_ids = [];
		$jurnals         = [];
		$key         = 0;
		$last_fb_id      = FakturBelanja::orderBy('id', 'desc')->first()->id;
		$last_bb_id      = BahanBangunan::orderBy('id', 'desc')->first()->id;

		foreach ($arr_by_fb_id as $k => $aa) {
			$last_fb_id++;
			$timestamp = $aa[0]['created_at'];
			$nilai     = 0;
			foreach ($aa as $a) {
				$last_bb_id++;
				$bahan_bangunans[] = [
					'id'                => $last_bb_id,
					'created_at'        => $timestamp,
					'updated_at'        => $timestamp,
							'tenant_id'  => session()->get('tenant_id'),
					'faktur_belanja_id' => $last_fb_id,
					'keterangan'        => $a['keterangan'],
					'harga_satuan'      => $a['harga_satuan'],
					'jumlah'            => $a['jumlah']
				];
				$nilai += (int) $a['harga_satuan'] * (int) $a['jumlah'];
			}
			$faktur_belanjas[] = [
				'id'             => $last_fb_id,
				'tanggal'        => $a['created_at'],
				'supplier_id'    => $a['supplier_id'],
				'submit'         => 1,
				'nomor_faktur'   => Input::get('nomor_faktur')[$key],
				'belanja_id'     => 6,
							'tenant_id'  => session()->get('tenant_id'),
				'created_at'     => $a['created_at'],
				'updated_at'     => $a['created_at'],
				'sumber_uang_id' => $a['sumber_uang_id'],
				'faktur_image'   => $a['faktur_image'],
				'petugas_id'     => $a['staf_id'],
				'pengeluaran_id' => $a['pg_id']
			];
			$pengeluaran_ids[] = $a['pg_id'];
			$key++;
		}

		DB::beginTransaction();
		try {
			foreach ($faktur_belanjas as $fb) {
				$faktur_belanja                 = new FakturBelanja;
				$faktur_belanja->tanggal        = $fb['tanggal'];
				$faktur_belanja->supplier_id    = $fb['supplier_id'];
				$faktur_belanja->submit         = $fb['submit'];
				$faktur_belanja->nomor_faktur   = $fb['nomor_faktur'];
				$faktur_belanja->belanja_id     = $fb['belanja_id'];
				$faktur_belanja->created_at     = $fb['created_at'];
				$faktur_belanja->updated_at     = $fb['updated_at'];
				$faktur_belanja->sumber_uang_id = $fb['sumber_uang_id'];
				$faktur_belanja->faktur_image   = $fb['faktur_image'];
				$faktur_belanja->petugas_id     = $fb['petugas_id'];
				$faktur_belanja->save();
				JurnalUmum::where('jurnalable_type', 'App\Models\Pengeluaran')->where('jurnalable_id', $fb['pengeluaran_id'])->update([
					'jurnalable_type' => 'App\Models\FakturBelanja',
					'jurnalable_id'   => $faktur_belanja->id
				]);
				Pengeluaran::destroy($fb['pengeluaran_id']);
			}
			BahanBangunan::insert($bahan_bangunans);
			DB::commit();
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
		$pesan = Yoga::suksesFlash('Ikhtisarkan Bahan Banguna Berhasil');
		return redirect($route)->withPesan($pesan);
	}
}
