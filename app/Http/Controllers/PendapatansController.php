<?php

namespace App\Http\Controllers;

use Input;
use App\Classes\Yoga;

use App\Http\Requests;

use App\Pendapatan;
use App\PembayaranAsuransi;
use App\PiutangDibayar;
use App\PiutangAsuransi;
use App\NotaJual;
use App\Asuransi;
use App\JurnalUmum;
use DB;

class PendapatansController extends Controller
{

	/**
	 * Display a listing of pendapatans
	 *
	 * @return Response
	 */
	public function index()
	{
		$pendapatans = Pendapatan::all();
		return view('pendapatans.index', compact('pendapatans'));
	}

	/**
	 * Show the form for creating a new pendapatan
	 *
	 * @return Response
	 */
	public function create()
	{
		// return 'create';
		return view('pendapatans.create');
	}

	/**
	 * Store a newly created pendapatan in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$array = json_decode(Input::get('array'), true);
		$biaya = 0;


		$nota_jual_id = Yoga::customId('App\NotaJual');

		$nj = new NotaJual;
		$nj->id = $nota_jual_id;
        $nj->tanggal = date('Y-m-d');
		$nj->staf_id = Input::get('staf_id');
		$nj->tipe_jual_id = '2';
		$confirm = $nj->save();

        if ($confirm) {
            foreach ($array as $key => $arr) {

                $pendapatan             = new Pendapatan;
                $pendapatan->pendapatan = $arr['pendapatan'];
                $pendapatan->biaya      = $arr['jumlah'];
                $pendapatan->staf_id    = $arr['staf_id'];
                $pendapatan->nota_jual_id    = $nota_jual_id;
                $pendapatan->keterangan = $arr['keterangan'];
                $confirm                = $pendapatan->save();
                

                if ($confirm) {
                    $jurnal                  = new JurnalUmum;
                    $jurnal->jurnalable_id   = $pendapatan->id; // kenapa ini nilainya empty / null padahal di database ada id
                    $jurnal->jurnalable_type = 'App\Pendapatan';
                    $jurnal->coa_id          = 110000;
                    $jurnal->debit           = 1;
                    $jurnal->nilai           = $arr['jumlah'];
                    $jurnal->save();

                    $jurnal                  = new JurnalUmum;
                    $jurnal->jurnalable_id   = $pendapatan->id;
                    $jurnal->jurnalable_type = 'App\Pendapatan';
                    $jurnal->debit           = 0;
                    $jurnal->nilai           = $arr['jumlah'];
                    $jurnal->save();
                }
            }
            return redirect('nota_juals')->withPesan(Yoga::suksesFlash('<strong>Pendapatan</strong> telah berhasil dimasukkan'))
                ->withPrint($nota_jual_id);
        } else {
            return redirect('nota_juals')->withPesan(Yoga::gagalFlash('<strong>Pendapatan</strong> telah GAGAL dimasukkan'));
        }
	}

	/**
	 * Display the specified pendapatan.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$pendapatan = Pendapatan::findOrFail($id);

		return view('pendapatans.show', compact('pendapatan'));
	}

	/**
	 * Show the form for editing the specified pendapatan.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$pendapatan = Pendapatan::find($id);

		return view('pendapatans.edit', compact('pendapatan'));
	}

	/**
	 * Update the specified pendapatan in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$pendapatan = Pendapatan::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Pendapatan::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$pendapatan->update($data);

		return \Redirect::route('pendapatans.index');
	}

	/**
	 * Remove the specified pendapatan from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Pendapatan::destroy($id);

		return \Redirect::route('pendapatans.index');
	}
    public function pembayaran_asuransi(){
        $asuransi_list = ['null' => '-pilih-'] + Asuransi::lists('nama', 'id')->all();
		return view('pendapatans.pembayaran_asuransi', compact('asuransi_list'));
    }
    public function pembayaran_asuransi_by_id($id){
        return 'asuransi '. $id;
         return 'pembayaran_asuransi';
    }

    public function pembayaran_asuransi_show($id){
        $pembayarans = NotaJual::find($id)->pembayaranAsuransi; 
        return view('pendapatans.pembayaran_show', compact('pembayarans'));

        $asuransi_id = Input::get('asuransi_id');
        $asuransi = Asuransi::find($asuransi_id);
        $mulai = Yoga::nowIfEmptyMulai(Input::get('mulai'));
        $akhir = Yoga::nowIfEmptyMulai(Input::get('akhir'));
        $query = "select px.id as id, ps.nama as nama, asu.nama as nama_asuransi, asu.id as asuransi_id, px.tanggal as tanggal, pa.piutang as piutang, px.piutang_dibayar as piutang_dibayar , px.piutang_dibayar as piutang_dibayar_awal from piutang_asuransis as pa join periksas as px on px.id = pa.periksa_id join pasiens as ps on ps.id = px.pasien_id join asuransis as asu on asu.id=px.asuransi_id where px.asuransi_id='{$asuransi_id}' and px.tanggal between '{$mulai}' and '{$akhir}';";
        $periksas = DB::select($query);
        
		$query = "SELECT px.id as id, p.nama as nama, asu.nama as nama_asuransi, asu.id as asuransi_id, px.tanggal as tanggal, px.piutang as piutang, px.piutang_dibayar as piutang_dibayar , px.piutang_dibayar as piutang_dibayar_awal from periksas as px join pasiens as p on px.pasien_id = p.id join asuransis as asu on asu.id = px.asuransi_id where px.piutang > 0 and px.piutang > px.piutang_dibayar and px.asuransi_id = '{$id}';";
		$periksas = DB::select($query);

        return view('pendapatans.pembayaran_show', compact('asuransi', 'periksas'));
    }
    public function lihat_pembayaran_asuransi(){
         //return Input::all();
        $asuransi_id = Input::get('asuransi_id');
        $mulai = Yoga::datePrep( Input::get('mulai') );
        $akhir = Yoga::datePrep(Input::get('akhir'));

        $query = "SELECT pu.id as piutang_id, px.id as periksa_id, ps.nama as nama_pasien, pu.tunai as tunai, pu.piutang as piutang, pu.sudah_dibayar as pembayaran, 0 as akan_dibayar FROM piutang_asuransis as pu join periksas as px on px.id=pu.periksa_id join pasiens as ps on ps.id = px.pasien_id where px.tanggal between '{$mulai}' and '{$akhir}' and px.asuransi_id = '{$asuransi_id}';";


        $pembayarans = DB::select($query);
        foreach ($pembayarans as $k => $pemb) {
            if ($pemb->pembayaran == null) {
                $pembayarans[$k]->pembayaran = 0;
            }
        }
        $asuransi = Asuransi::find($asuransi_id)->nama;
        return view('pendapatans.pembayaran_show', compact('pembayarans', 'asuransi', 'mulai', 'akhir', 'asuransi_id'));
    }
    
    public function asuransi_bayar(){
        $dibayar = Input::get('dibayar');
        $mulai = Input::get('mulai');
        $akhir = Input::get('akhir');
        $asuransi_id = Input::get('asuransi_id');
        $temp = Input::get('temp');
        
        $temp = json_decode($temp, true);

        $pb = new PembayaranAsuransi;
        $pb->asuransi_id = $asuransi_id;
        $pb->mulai = $mulai;
        $pb->akhir = $akhir;
        $pb->save();

        foreach ($temp as $tmp) {
            if ($tmp['akan_dibayar'] > 0) {
                $pt = PiutangAsuransi::find($tmp['piutang_id']);
                $pt->sudah_dibayar = $pt->sudab_dibayar + $tmp['akan_dibayar'];
                $each_confirm = $pt->save();

                if ($each_confirm) {
                    $pt = new PiutangDibayar;
                    $pt->periksa_id = $tmp['periksa_id'];
                    $pt->pembayaran = $tmp['akan_dibayar'];
                    $pt->pembayaran_asuransi_id = $pb->id;
                    $pt->save();
                }
            }
        }
        $pesan = Yoga::suksesFlash('Asuransi ' . Asuransi::find($asuransi_id)->nama . ' tanggal ' . Yoga::updateDatePrep($mulai). ' sampai dengan ' . Yoga::updateDatePrep($akhir) . ' <strong>BERHASIL</strong> dibayarkan');
        return redirect('laporans')->withPesan($pesan);
    }
}
