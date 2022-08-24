<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\TransaksiPeriksa;
use App\Models\Pasien;
use App\Models\Classes\Yoga;
use App\Models\Periksa;
use App\Models\Asuransi;
use App\Models\Sms;
use App\Models\Coa;
use App\Models\JurnalUmum;
use Input;
use DB;

class PeriksaCustomController extends Controller
{

	  public function __construct()
    {
		$this->middleware('super', ['only' => [
			'updateTransaksiPeriksa'
		]]);

		$this->middleware('allowifnotcash', ['only' => [
			'editTransaksiPeriksa'
		]]);
    }
	public function editJurnal($id){
		$periksa = Periksa::find($id);
		return view('jurnal_umums.editJurnal', compact('periksa'));
	}
	
	public function editTransaksiPeriksa($id){
		$periksa       = Periksa::with('jurnals.coa', 'transaksii')->where('id', $id)->first();
		$coa_list      = Coa::list();
		$list_asuransi = Asuransi::list();
		return view('periksas.editTransaksiPeriksa', compact(
			'periksa',
			'list_asuransi',
			'coa_list'
		));
	}
	public function updateTransaksiPeriksa(){

		$transaksis = json_decode( Input::get('transaksis'), true );
		$periksa    = json_decode( Input::get('periksa'), true );
		$jurnals    = json_decode( Input::get('jurnals'), true );
		$temp       = json_decode( Input::get('temp'), true );

		$timestamp  = date('Y-m-d H:i:s');
		$jurnal     = [];

		DB::beginTransaction();
		try {
			foreach ($transaksis as $t) {
				$trans        = TransaksiPeriksa::find($t['id']);
				$trans->biaya = $t['biaya'];
				$trans->save();
			}

			$prx                 = Periksa::find($periksa['id']);

			if ($periksa['asuransi_id'] == '0') // jika asuransi diubah menjadi biaya pribadi
			{
				$pesan = Yoga::gagalFlash('Tidak boleh merubah nama asuransi menjadi biaya pribadi');
				return \Redirect::back()->withPesan($pesan);
			}


			$prx->tunai          = $periksa['tunai'];
			$prx->asuransi_id    = $periksa['asuransi_id'];
			$prx->nomor_asuransi = Input::get('nomor_asuransi');
			$prx->piutang        = $periksa['piutang'];
			$confirm             = $prx->save();

			if ( $prx->asuransi_id == $prx->pasien->asuransi_id ) {
				$pasien                 = Pasien::find( $prx->pasien_id );
				$pasien->nomor_asuransi = Input::get('nomor_asuransi');
				$pasien->save();
			}

			if ( $prx->piutang > 0 ) {
					$prx->tunai   = $periksa['tunai'];
					$prx->piutang = $periksa['piutang'];
					$prx->save();
			} 

			foreach ($jurnals as $j) {
				if ( $j['nilai'] > 0 ) {
					$jurnal[] = [
						'jurnalable_id'   => $periksa['id'],
						'jurnalable_type' => 'App\Models\Periksa',
						'debit'           => $j['debit'],
						'coa_id'          => $j['coa_id'],
						'nilai'           => $j['nilai'],
							'tenant_id'  => session()->get('tenant_id'),
						'created_at'      => $prx->tanggal . ' 23:59:59',
						'updated_at'      => $prx->tanggal . ' 23:59:59'
					];
				}
			}
			foreach ($temp as $t) {
				if ( $t['nilai'] > 0 ) {
					$jurnal[] = [
						'jurnalable_id'   => $periksa['id'],
						'jurnalable_type' => 'App\Models\Periksa',
						'debit'           => $t['debit'],
						'coa_id'          => $t['coa_id'],
						'nilai'           => $t['nilai'],
							'tenant_id'  => session()->get('tenant_id'),
						'created_at'      => $prx->tanggal . ' 23:59:59',
						'updated_at'      => $prx->tanggal . ' 23:59:59'
					];
				}
			}
			JurnalUmum::insert($jurnal);
			Sms::send('081381912803', 'Telah dilakukan update transaksi dengan id periksa ' . $prx->id . ' , nama pasien ' . $prx->pasien->nama);
			$pesan = Yoga::suksesFlash('Berhasil mengedit Transaksi Periksa');
			DB::commit();
			return redirect('periksas/' . $prx->id)->withPesan($pesan);
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
	}
}
