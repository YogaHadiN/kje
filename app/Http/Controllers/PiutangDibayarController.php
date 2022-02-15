<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Input;
use DB;
use App\Models\PiutangDibayar;
use App\Models\PembayaranAsuransi;
use App\Models\JurnalUmum;
use App\Models\Classes\Yoga;

class PiutangDibayarController extends Controller
{
	public function edit($id){
		$piutang_dibayar = PiutangDibayar::find( $id );

		return view('piutang_dibayars.edit', compact(
			'piutang_dibayar'
		));
	}
	public function update($id){
		$messages = [
			'required' => ':attribute Harus Diisi',
		];
		$rules = [
			'pembayaran' => 'required|numeric'
		];
		
		$validator = \Validator::make(Input::all(), $rules, $messages);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		DB::beginTransaction();
		try {
			$piutang_dibayar = PiutangDibayar::find($id);
		
			$pembayaran      = (int) Input::get('pembayaran');
			$perubahan       = $pembayaran - $piutang_dibayar->pembayaran;


			//update piutang_dibayar
			$piutang_dibayar->pembayaran = Input::get('pembayaran');
			$piutang_dibayar->save();

			//update pembayaran_asuransi
			$pembayaran_asuransi             = $piutang_dibayar->pembayaranAsuransi;
			$pembayaran_asuransi->pembayaran = $pembayaran_asuransi->pembayaran + $perubahan;
			$pembayaran_asuransi->save();

			//update jurnal_umum
			$jurnals = JurnalUmum::where('jurnalable_type', 'App\Models\NotaJual')
								->where('jurnalable_id', $pembayaran_asuransi->nota_jual_id)
								->get();

			foreach ($jurnals as $jurnal) {
				$jurnal->nilai =$jurnal->nilai + $perubahan;
				$jurnal->save();
			}
			//
			//update piutang_asuransi
			$prx                = Periksa::find($piutang_dibayar->periksa_id);
			$prx->sudah_dibayar = $prx->sudah_dibayar + $perubahan;
			$prx->save();

			DB::commit();
			$pesan = Yoga::suksesFlash("Piutang " . $piutang_dibayar->id . ' BERHASIL diupdate');
			return redirect()->back()->withPesan($pesan);

		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
	}
}
