<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use Hash;
use App\Models\Merek;
use App\Models\User;
use App\Models\Staf;
use App\Models\Coa;
use App\Models\Penjualan;
use App\Models\Dispensing;
use App\Models\NotaJual;
use App\Models\JurnalUmum;
use App\Models\Classes\Yoga;
use App\Models\Rak;
use DB;

class PenjualansController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * GET /penjualans
	 *
	 * @return Response
	 */
	public function index()
	{
		$mereks     = [null => '--pilih--'] + Merek::with('rak.formula')->where('discontinue', 0)->get()->pluck('merek', 'custid')->all();
		$stafs      = [null => '- pilih -'] + Staf::pluck('nama', 'id')->all();
		$nota_juals = NotaJual::with('penjualan.merek', 'staf', 'tipeJual')->latest()->paginate(10);

		return view('penjualans.index', compact('mereks', 'stafs', 'nota_juals'));
		/* return view('penjualans.index', compact('mereks', 'stafs', 'suppliers', 'nota_juals')); */
	}
	public function indexPost()
	{
		DB::beginTransaction();
		try {
			$messages = [
				'required' => ':attribute Harus diisi.',
			];
			$rules = [
				'tanggal'     => 'required',
				'staf_id'     => 'required',
				'total_harga' => 'required'
			];
			$validator = \Validator::make($data = Input::all(), $rules, $messages);

			if ($validator->fails())
			{
				return \Redirect::back()->withErrors($validator)->withInput();
			}

			$datas             = Input::get('tempBeli');
			$datas             = json_decode($datas, true);
			$biaya             = 0;
			$biaya_obat        = 0;
			$last_penjualan_id = Penjualan::orderBy('id', 'desc')->first()->id;
			$penjualans        = [];
			$dispensings       = [];
			$jurnals           = [];
			$timestamp         = date('Y-m-d H:i:s');

			$nj          = new NotaJual;
			$nj->tanggal = Yoga::datePrep(Input::get('tanggal'));
			$nj->staf_id = Input::get('staf_id');
			$confirm     = $nj->save();

			foreach ($datas as $data) {
				$last_penjualan_id++;
				$penjualans[]       = [
					'id'           => $last_penjualan_id,
					'nota_jual_id' => $nj->id,
					'merek_id'     => $data['merek_id'],
					'harga_jual'   => $data['harga_jual'],
					'jumlah'       => $data['jumlah'],
							'tenant_id'  => session()->get('tenant_id'),
					'created_at'   => $timestamp,
					'updated_at'   => $timestamp
				];
				$rak_id    = Merek::find($data['merek_id'])->rak_id;
				$rak       = Rak::find($rak_id);
				$rak->stok = $rak->stok - $data['jumlah'];
				$rak->save();

				$dispensings[] = [
					'tanggal'          => Yoga::datePrep(Input::get('tanggal')),
					'merek_id'         => $data['merek_id'],
					'keluar'           => $data['jumlah'],
					'dispensable_id'   => $last_penjualan_id,
					'dispensable_type' => 'App\Models\Penjualan',
							'tenant_id'  => session()->get('tenant_id'),
					'created_at'       => $timestamp,
					'updated_at'       => $timestamp
				];

				$biaya += $data['harga_jual'] * $data['jumlah'];
				$biaya_obat += $data['harga_beli'] * $data['jumlah'];
			}


			$biaya = Input::get('total_harga');

			if ($confirm) {

				$jurnals[] = [
					'jurnalable_id'   => $nj->id,
					'jurnalable_type' => 'App\Models\NotaJual',
					'coa_id'          => Coa::where('kode_coa',  '110000')->first()->id,
					'debit'           => 1,
					'nilai'           => $biaya,
							'tenant_id'  => session()->get('tenant_id'),
					'created_at'      => $timestamp,
					'updated_at'      => $timestamp
				];

				$jurnals[] = [
					'jurnalable_id'   => $nj->id,
					'jurnalable_type' => 'App\Models\NotaJual',
					'coa_id'          => Coa::where('kode_coa',  '400002')->first()->id,
					'debit'           => 0,
					'nilai'           => $biaya,
							'tenant_id'  => session()->get('tenant_id'),
					'created_at'      => $timestamp,
					'updated_at'      => $timestamp
				];
				

				$jurnals[] = [
					'jurnalable_id'   => $nj->id,
					'jurnalable_type' => 'App\Models\NotaJual',
					'coa_id'          => Coa::where('kode_coa',  '50200')->first()->id,
					'debit'           => 1,
					'nilai'           => $biaya_obat,
							'tenant_id'  => session()->get('tenant_id'),
					'created_at'      => $timestamp,
					'updated_at'      => $timestamp
				];

				$jurnals[] = [
					'jurnalable_id'   => $nj->id,
					'jurnalable_type' => 'App\Models\NotaJual',
					'coa_id'          => Coa::where('kode_coa',  '112000')->first()->id,
					'debit'           => 0,
					'nilai'           => $biaya_obat,
							'tenant_id'  => session()->get('tenant_id'),
					'created_at'      => $timestamp,
					'updated_at'      => $timestamp
				];
			}

			JurnalUmum::insert($jurnals);
			Penjualan::insert($penjualans);
			Dispensing::insert($dispensings);
			$pesan = '<strong>Transaksi Penjualan Tanpa Resep</strong> Berhasil dilakukan';
			DB::commit();
			return redirect('penjualans')->withPesan(Yoga::suksesFlash($pesan))
				->withPrint($nj->id);
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
	}
    public function obat_buat_karyawan(){

		$nota_juals = NotaJual::with('penjualan', 'tipeJual', 'staf')->where('tipe_jual_id', 1)->latest()->paginate(10);
		$mereks = [null => '--pilih--'] + Merek::with('rak.formula')->get()->pluck('merek', 'custid')->all();
		$stafs = [null => '- pilih -'] + Staf::pluck('nama', 'id')->all();
        return view('penjualans.obat_buat_karyawan', compact('mereks', 'stafs', 'nota_juals'));

    }
    public function obat_buat_karyawan_post(){
		DB::beginTransaction();
		try {
			$email    = Input::get('email');
			$password = Input::get('password');

			$user = User::where('email', $email)->first();
			if ($user) {
			   $hashedPassword = $user->password; 
			} else {
				$pesan = Yoga::gagalFlash('User belum terdaftar');
				return redirect('pasiens')->withPesan($pesan);
			}

			$staf    = Staf::where('email', $email)->first();
			if ( is_null($staf) ) {
				$pesan = Yoga::gagalFlash('email tersebut tidak ditemukan dalam data staf');
				return redirect()->back()->withPesan($pesan);
			}
			$staf_id = $staf->id;

			if( Hash::check($password, $hashedPassword) ){

				$tanggal  = Input::get('tanggal');
				$tempBeli = Input::get('tempBeli');
				$datas    = json_decode($tempBeli, true);

				$nj           = new NotaJual;
				$nj->tanggal  = Yoga::datePrep(Input::get('tanggal'));
				$nj->staf_id  = $staf_id;
				$nj->save();

				$dispensings            = [];
				$penjualans             = [];
				$last_penjualan_id      = Penjualan::orderBy('id', 'desc')->first()->id;
				$biaya_obat             = 0;
				$timestamp              = date('Y-m-d H:i:s');
				foreach ($datas as $data) {
					$last_penjualan_id++;
					$penjualans[]       = [
						'id'           => $last_penjualan_id,
						'nota_jual_id' => $nj->id,
						'merek_id'     => $data['merek_id'],
						'harga_jual'   => $data['harga_jual'],
						'jumlah'       => $data['jumlah'],
							'tenant_id'  => session()->get('tenant_id'),
						'created_at'   => $timestamp,
						'updated_at'   => $timestamp
					];

					$rak_id = Merek::find($data['merek_id'])->rak_id;

					$rak = Rak::find($rak_id);
					$rak->stok = $rak->stok - $data['jumlah'];
					$rak->save();

					$dispensings[]          = [
						'tanggal'          => Yoga::datePrep(Input::get('tanggal')),
						'merek_id'         => $data['merek_id'],
						'keluar'           => $data['jumlah'],
						'dispensable_id'   => $last_penjualan_id,
						'dispensable_type' => 'App\Models\Penjualan',
							'tenant_id'  => session()->get('tenant_id'),
						'created_at'       => $timestamp,
						'updated_at'       => $timestamp
					];

					$biaya_obat += $data['harga_beli'] * $data['jumlah'];
				}

				$timestamp = date('Y-m-d H:i:s');
				$jurnals[] = [
					'jurnalable_id'   => $nota_jual_id,
					'jurnalable_type' => 'App\Models\NotaJual',
					'coa_id'          => Coa::where('kode_coa',  '50200')->first()->id, // Beban Biaya Obat
					'debit'           => 1,
					'nilai'           => $biaya_obat,
							'tenant_id'  => session()->get('tenant_id'),
					'created_at'      => $timestamp,
					'updated_at'      => $timestamp
				];
				$jurnals[] = [
					'jurnalable_id'   => $nota_jual_id,
					'jurnalable_type' => 'App\Models\NotaJual',
					'coa_id'          => Coa::where('kode_coa',  '112000')->first()->id, // Persediaan obat
					'debit'           => 0,
					'nilai'           => $biaya_obat,
							'tenant_id'  => session()->get('tenant_id'),
					'created_at'      => $timestamp,
					'updated_at'      => $timestamp
				];

				JurnalUmum::insert($jurnals);
				Dispensing::insert($dispensings);
				Penjualan::insert($penjualans);
			}else {
				$pesan = Yoga::gagalFlash('Kombinasi email / password <strong>salah</strong>');
				return redirect()->back()->withPesan($pesan);
			}
			$pesan = Yoga::suksesFlash('Dispensing obat oleh ' . $staf->nama . ' telah <strong>BERHASIL</strong>');
			DB::commit();
			return redirect('penjualans/obat_buat_karyawan')->withPesan($pesan)->withPrint($nota_jual_id);
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
    }
}
