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
use App\Coa;
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
		$asuransis = '';
		foreach(Asuransi::where('id', '>', 0)->get() as $ass){
			if (count( explode(".", $ass->nama ) ) > 1) {
				$text =  explode(".", $ass->nama )[1] ;
			} else {
				$text = $ass->nama;
			}
			$text = str_replace(")","",$text);
			$text = str_replace("(","",$text);
			$text = trim($text);
			if ($text) {
				$asuransis .= strtolower($text) . ' ';
			}
		}
		$asuransis = explode(" ", $asuransis);
		//$asuransis = json_encode($arrays);
		$pendapatans = Pendapatan::with('staf')->latest()->paginate(10);
		return view('pendapatans.create', compact('pendapatans','asuransis'));
	}

	/**
	 * Store a newly created pendapatan in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = [

			'sumber_uang' => 'required',
			'nilai' => 'required',
			'staf_id' => 'required',
			'keterangan' => 'required',
		];
		$validator = \Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		//return Input::all();
		$pendapatan             = new Pendapatan;
		$pendapatan->sumber_uang = Input::get('sumber_uang');
		$pendapatan->nilai = Input::get('nilai');
		$pendapatan->keterangan = Input::get('keterangan');
		$pendapatan->staf_id = Input::get('staf_id');
		$confirm                = $pendapatan->save();

		if ($confirm) {
			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $pendapatan->id; // kenapa ini nilainya empty / null padahal di database ada id
			$jurnal->jurnalable_type = 'App\Pendapatan';
			$jurnal->coa_id          = 110000;
			$jurnal->debit           = 1;
			$jurnal->nilai           = Input::get('nilai');
			$jurnal->save();

			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $pendapatan->id;
			$jurnal->jurnalable_type = 'App\Pendapatan';
			$jurnal->debit           = 0;
			$jurnal->nilai           = Input::get('nilai');
			$jurnal->save();
		}

		return redirect('pendapatans/create')->withPesan(Yoga::suksesFlash('Pendapatan telah berhasil dimasukkan'))
			->withPrint($pendapatan->id);
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
        $asuransi_list = [null => '-pilih-'] + Asuransi::lists('nama', 'id')->all();
        $pembayarans = PembayaranAsuransi::latest()->paginate(10);
		return view('pendapatans.pembayaran_asuransi', compact('asuransi_list', 'pembayarans'));
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

        return view('pendapatans.pembayaran_show', compact('asuransi', 'periksas', 'mulai', 'akhir'));
    }
    public function lihat_pembayaran_asuransi(){
         //return Input::all();
        $asuransi_id = Input::get('asuransi_id');
        $mulai = Yoga::datePrep( Input::get('mulai') );
        $akhir = Yoga::datePrep(Input::get('akhir'));

        $kasList = [ null => '-Pilih-' ] + Coa::where('id', 'like', '110%')->lists('coa', 'id')->all();

        $query = "SELECT pu.id as piutang_id, px.id as periksa_id, ps.nama as nama_pasien, pu.tunai as tunai, pu.piutang as piutang, pu.sudah_dibayar as pembayaran, 0 as akan_dibayar FROM piutang_asuransis as pu join periksas as px on px.id=pu.periksa_id join pasiens as ps on ps.id = px.pasien_id where px.tanggal between '{$mulai}' and '{$akhir}' and px.asuransi_id = '{$asuransi_id}';";


        $pembayarans = DB::select($query);
        foreach ($pembayarans as $k => $pemb) {
            if ($pemb->pembayaran == null) {
                $pembayarans[$k]->pembayaran = 0;
            }
        }
        $asuransi = Asuransi::find($asuransi_id)->nama;
        return view('pendapatans.pembayaran_show', compact('pembayarans', 'asuransi', 'mulai', 'akhir', 'asuransi_id', 'kasList'));
    }
    
    public function asuransi_bayar(){
		$rules = [
			 'tanggal_dibayar' => 'date|required',
			 'mulai' => 'date|required',
			 'akhir' => 'date|required',
			 'staf_id' => 'required',
			 'asuransi_id' => 'required',
			 'coa_id' => 'required'
		];

		$validator = \Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}


        $dibayar = Input::get('dibayar');
        $mulai = Input::get('mulai');
        $staf_id = Input::get('staf_id');
        $akhir = Input::get('akhir');
        $tanggal = Yoga::datePrep( Input::get('tanggal_dibayar') );
        $asuransi_id = Input::get('asuransi_id');
        $temp = Input::get('temp');
        $coa_id = Input::get('coa_id');
        
        
        $temp = json_decode($temp, true);

        $nota_jual_id = Yoga::customId('App\NotaJual');
        $nj = new NotaJual;
        $nj->id = $nota_jual_id;
        $nj->tipe_jual_id = 2;
        $nj->tanggal = $tanggal;
        $nj->staf_id = $staf_id;
        $nj->save();
        

        $pb = new PembayaranAsuransi;
        $pb->asuransi_id = $asuransi_id;
        $pb->mulai = $mulai;
        $pb->staf_id = $staf_id;
        $pb->nota_jual_id = $nota_jual_id;
        $pb->akhir = $akhir;
        $pb->pembayaran = $dibayar;
        $pb->tanggal_dibayar = $tanggal;
        $pb->kas_coa_id = $coa_id;
        $confirm = $pb->save();

        $coa_id_asuransi = Asuransi::find($asuransi_id)->coa_id;// Piutang Asuransi

        //coa_kas_di_bank_mandiri = 110001;
        if ($confirm) {
            $jurnal                  = new JurnalUmum;
            $jurnal->jurnalable_id   = $nota_jual_id;
            $jurnal->jurnalable_type = 'App\NotaJual';
            $jurnal->coa_id          = $coa_id;
            $jurnal->debit           = 1;
            $jurnal->nilai           = $dibayar;
            $jurnal->save();

            $jurnal                  = new JurnalUmum;
            $jurnal->jurnalable_id   = $nota_jual_id;
            $jurnal->jurnalable_type = 'App\NotaJual';
            $jurnal->coa_id          = $coa_id_asuransi;
            $jurnal->debit           = 0;
            $jurnal->nilai           = $dibayar;
            $jurnal->save();
        }
        

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
        $pesan = Yoga::suksesFlash('Asuransi <strong>' . Asuransi::find($asuransi_id)->nama . '</strong> tanggal <strong>' . Yoga::updateDatePrep($mulai). '</strong> sampai dengan <strong>' . Yoga::updateDatePrep($akhir) . ' BERHASIL</strong> dibayarkan sebesar <strong><span class="uang">' . $dibayar . '</span></strong>');
        if ($coa_id == '110000') {
            return redirect('pendapatans/pembayaran/asuransi')->withPesan($pesan)->withPrint($pb->id);
        } else {
            return redirect('pendapatans/pembayaran/asuransi')->withPesan($pesan);
        }
    }
}
