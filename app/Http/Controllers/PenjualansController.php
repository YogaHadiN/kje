<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Merek;
use App\User;
use Hash;
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
		$mereks = [null => '--pilih--'] + Merek::with('rak.formula')->get()->lists('merek', 'custid')->all();
		$stafs = [null => '- pilih -'] + Staf::lists('nama', 'id')->all();
		// return $stafs;
		// return $mereks;
		$nota_juals = NotaJual::with('penjualan.merek', 'staf', 'tipeJual')->latest()->paginate(10);
		return view('penjualans.index', compact('mereks', 'stafs', 'suppliers', 'nota_juals'));
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
        $biaya_obat = 0;
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
                $biaya_obat += $data['harga_beli'] * $data['jumlah'];
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

			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $nota_jual_id;
			$jurnal->jurnalable_type = 'App\NotaJual';
			$jurnal->coa_id          = 50200; // Beban Biaya Obat
			$jurnal->debit           = 1;
			$jurnal->nilai           = $biaya_obat;
			$jurnal->save();

			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $nota_jual_id;
			$jurnal->jurnalable_type = 'App\NotaJual';
			$jurnal->coa_id          = 112000; // Persediaan obat
			$jurnal->debit           = 0;
			$jurnal->nilai           = $biaya_obat;
			$jurnal->save();
		}

		// return 'oke';
        $pesan = '<strong>Transaksi Penjualan Tanpa Resep</strong> Berhasil dilakukan';
        return redirect('nota_juals')->withPesan(Yoga::suksesFlash($pesan))
            ->withPrint($nota_jual_id);
	}
    public function obat_buat_karyawan(){
		$nota_juals = NotaJual::with('penjualan', 'tipeJual', 'staf')->where('tipe_jual_id', 1)->latest()->paginate(10);
		$mereks = [null => '--pilih--'] + Merek::with('rak.formula')->get()->lists('merek', 'custid')->all();
		$stafs = [null => '- pilih -'] + Staf::lists('nama', 'id')->all();
        return view('penjualans.obat_buat_karyawan', compact('mereks', 'stafs', 'nota_juals'));
    }
    public function obat_buat_karyawan_post(){
        $email = Input::get('email');
        $password = Input::get('password');

        $user = User::where('email', $email)->first();
        if ($user) {
           $hashedPassword = $user->password; 
        } else {
            $pesan = Yoga::gagalFlash('User belum terdaftar');
            return redirect('pasiens')->withPesan($pesan);
        }


        $staf = Staf::where('email', $email)->first();
        $staf_id = $staf->id;

		if( Hash::check($password, $hashedPassword) ){
            $tanggal = Input::get('tanggal');
            $tempBeli = Input::get('tempBeli');
            $datas = json_decode($tempBeli, true);

            $nota_jual_id = Yoga::customId('App\NotaJual');
            $nj = new NotaJual;
            $nj->id = $nota_jual_id;
            $nj->tanggal = Yoga::datePrep(Input::get('tanggal'));
            $nj->staf_id = $staf_id;
            $nj->save();

            $biaya_obat = 0;
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
                $dispensing->save();

                $biaya_obat += $data['harga_beli'] * $data['jumlah'];
            }

			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $nota_jual_id;
			$jurnal->jurnalable_type = 'App\NotaJual';
			$jurnal->coa_id          = 50200; // Beban Biaya Obat
			$jurnal->debit           = 1;
			$jurnal->nilai           = $biaya_obat;
			$jurnal->save();

			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $nota_jual_id;
			$jurnal->jurnalable_type = 'App\NotaJual';
			$jurnal->coa_id          = 112000; // Persediaan obat
			$jurnal->debit           = 0;
			$jurnal->nilai           = $biaya_obat;
			$jurnal->save();
		}else {
            $pesan = Yoga::gagalFlash('Kombinasi email / password <strong>salah</strong>');
			return redirect('pasiens')
			->withPesan($pesan);
		}
        $pesan = Yoga::suksesFlash('Dispensing obat oleh ' . $staf->nama . ' telah <strong>BERHASIL</strong>');
        return redirect('penjualans/obat_buat_karyawan')->withPesan($pesan)->withPrint($nota_jual_id);
    }
}
