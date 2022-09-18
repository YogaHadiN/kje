<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\TransaksiPeriksa;
use App\Models\Pasien;
use App\Models\JenisTarif;
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
		$periksa       = Periksa::with('jurnals.coa', 'transaksii.jenisTarif')->where('id', $id)->first();
		$coa_list      = Coa::list();
		$list_asuransi = Asuransi::list();
		return view('periksas.editTransaksiPeriksa', compact(
			'periksa',
			'list_asuransi',
			'coa_list'
		));
	}
	public function updateTransaksiPeriksa(){
		DB::beginTransaction();
		try {
            $transaksis = json_decode( Input::get('transaksis'), true );
            $periksa    = json_decode( Input::get('periksa'), true );
            $jurnals    = json_decode( Input::get('jurnals'), true );
            $temp       = json_decode( Input::get('temp'), true );

            $timestamp  = date('Y-m-d H:i:s');
            $jurnal     = [];

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
            // jika jurnals memiliki kode coa dengan awalan 111 
            // maka cocokkan dengan coa_id asuransi
            if ( $this->coaIdPiutangAsuransiTidakCocokDenganJurnal($jurnals, $periksa)  ) {
				$pesan = Yoga::gagalFlash('COA di jurnal tidak cocok dengan jenis asuransi');
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
						'debit'           => $j['debit'],
						'coa_id'          => $j['coa_id'],
						'nilai'           => $j['nilai']
					];
				}
			}
			foreach ($temp as $t) {
				if ( $t['nilai'] > 0 ) {
					$jurnal[] = [
						'debit'           => $t['debit'],
						'coa_id'          => $t['coa_id'],
						'nilai'           => $t['nilai'],
					];
				}
			}

            $prx->jurnals()->delete();
            $prx->jurnals()->createMany($jurnal);
			$pesan = Yoga::suksesFlash('Berhasil mengedit Transaksi Periksa');
			DB::commit();
			return redirect('periksas/' . $prx->id)->withPesan($pesan);
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
	}
    public function getCoaId(){
        $jenis_tarif = JenisTarif::with('coa')->where('id', Input::get('jenis_tarif_id') )->first();
        $asuransi = Asuransi::find( Input::get('asuransi_id') );
        return [
            'coa_id'           => $jenis_tarif->coa_id,
            'tipe_asuransi_id' => $asuransi->tipe_asuransi_id,
            'coa_id_asuransi'  => $asuransi->coa_id,
            'coa'              => $jenis_tarif->coa,
        ];
    }
    public function getCoaList(){
        return Coa::pluck('coa_id', 'coa');
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function coaIdPiutangAsuransiTidakCocokDenganJurnal($jurnals, $periksa) {
        $asuransi = Asuransi::find($periksa['asuransi_id']);
        foreach ($jurnals as $jurnal) {
            if (
                substr($jurnal['coa']['kode_coa'], 0, 3) == '111' &&// jika kode coa pada jurnal diawali dengan 111
                $asuransi->coa_id != $jurnal['coa_id']
            ) {
                return true;
                break;
            } 
        }
        return false;
    }
}
