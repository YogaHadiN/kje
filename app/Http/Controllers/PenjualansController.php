<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Merek;
use App\Staf;
use App\Penjualan;
use App\Dispensing;
use App\NotaJual;
use App\JurnalUmum;
use App\Classes\Yoga;
use App\Rak;

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
		// return 'penjualan index';
		$mereks = [null => '--pilih--'] + Merek::get()->lists('merek', 'custid')->all();
		$stafs = [null => '- pilih -'] + Staf::lists('nama', 'id')->all();
		// return $stafs;
		// return $mereks;
		return view('penjualans.index', compact('mereks', 'stafs', 'suppliers'));
		// return $faktur_beli_id;
	}
	public function indexPost()
	{
                                
        $messages = [
            'required' => ':attribute Harus diisi.',
        ];
		$rules = [
			'tanggal' => 'required',
			'staf_id' => 'required'
		];
		$validator = \Validator::make($data = Input::all(), $rules, $messages);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$datas = Input::get('tempBeli');
		$datas = json_decode($datas, true);
		$nota_jual_id = Yoga::customId('App\NotaJual');
		$biaya = 0;
		foreach ($datas as $data) {
			$pj = new Penjualan;
			$pj->id = Yoga::customId('App\Penjualan');
			$pj->nota_jual_id = $nota_jual_id;
			$pj->merek_id = $data['merek_id'];
			$pj->harga_jual = $data['harga_jual'];
			$pj->jumlah = $data['jumlah'];
			$conf1 = $pj->save();
			$rak_id = Merek::find($data['merek_id'])->rak_id;

			$rak = Rak::find($rak_id);
			$rak->stok = $rak->stok - $data['jumlah'];
			$rak->save();

			$dispensing = new Dispensing;
			$dispensing->id = Yoga::customId('App\Dispensing');
			$dispensing->tanggal = Yoga::datePrep(Input::get('tanggal'));
			$dispensing->rak_id = $rak_id;
			$dispensing->keluar = $data['jumlah'];
			$dispensing->dispensable_id = $nota_jual_id;
			$dispensing->dispensable_type = 'App\Penjualan';
			$conf2 = $dispensing->save();

			if ($conf1 && $conf2) {
				$biaya += $data['harga_jual'] * $data['jumlah'];
			}
		}

		$nj = new NotaJual;
		$nj->id = $nota_jual_id;
		$nj->tanggal = Yoga::datePrep(Input::get('tanggal'));
		$nj->staf_id = Input::get('staf_id');
		$confirm = $nj->save();

		if ($confirm) {
			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $nota_jual_id;
			$jurnal->jurnalable_type = 'App\NotaJual';
			$jurnal->coa_id          = 110000; // kas
			$jurnal->debit           = 1;
			$jurnal->nilai           = $biaya;
			$jurnal->save();

			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $nota_jual_id;
			$jurnal->jurnalable_type = 'App\NotaJual';
			$jurnal->coa_id          = 400002; // pendapatan obat
			$jurnal->debit           = 0;
			$jurnal->nilai           = $biaya;
			$jurnal->save();
		}

		// return 'oke';
        $pesan = '<strong>Transaksi Penjualan Tanpa Resep</strong> Berhasil dilakukan';
        return redirect('nota_juals')->withPesan(Yoga::suksesFlash($pesan))
            ->withPrint($nota_jual_id);
	}

}
