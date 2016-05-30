<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\FakturBelanja;
use App\JenisPengeluaran;
use App\Classes\Yoga;
use App\BukanObat;
use App\BayarDokter;
use App\JurnalUmum;
use App\Staf;
use DB;
use App\Pengeluaran;

class PengeluaransController extends Controller
{
	/**
	 * Display a listing of the resource.
	 * GET /pengeluarans
	 *
	 * @return Response
	 */
	public function index($id)
	{
		$fakturbelanja = FakturBelanja::find($id);

		$jenis_pengeluarans = Yoga::jenisPengeluaranList();
		$bukanObat = BukanObat::all(['nama']);

		$temp = [];

		foreach ($bukanObat as $nama) {
			$temp[] = $nama->nama;
		}
		$bukanObat = json_encode($temp);
		return view('pengeluarans.index', compact('fakturbelanja', 'jenis_pengeluarans', 'bukanObat'));
	}

	public function store() {
		$messages = array(
			'required' => ':attribute harus diisi terlebih dahulu',
		);


		$rules = [
			'transaksi_beli' 	=> 'required',
		];
		$validator = \Validator::make($data = Input::all(), $rules, $messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator->messages());
		}

		$datas = Input::get('transaksi_beli');
		$nomor_faktur = Input::get('nomor_faktur');
		$supplier_id = Input::get('supplier_id');
		$staf_id = Input::get('staf_id');
		$faktur_belanja_id = Input::get('faktur_belanja_id');

		$datas = json_decode($datas, true);

		foreach ($datas as $data) {
			$pg_id = Yoga::customId('App\Pengeluaran');
			$pg = new Pengeluaran;
			$pg->id = $pg_id;
			$pg->faktur_belanja_id = $faktur_belanja_id;

			$keterangan = $data['keterangan'];
			$keterangan = str_replace(' ', '', $keterangan);

			$query = "select * from(select id, replace(nama , ' ','') as n from bukan_obats) as t where n like '" . $keterangan. "';";
			$query = DB::select($query);


			if (count($query) > 0) {
			 	$pg->bukan_obat_id = $query[0]->id;
					
					$bo                       = Bukanobat::find($query[0]->id);
					$bo->jenis_pengeluaran_id = $data['jenis_pengeluaran_id'];
					$bo->harga_beli           = $data['harga_satuan'];
					$bo->save();
			 } else {
					$bo                       = new Bukanobat;
					$bo->nama                 = $data['keterangan'];
					$bo->jenis_pengeluaran_id = $data['jenis_pengeluaran_id'];
					$bo->harga_beli           = $data['harga_satuan'];
					$bo->save();

			 	$id = $bo->id;

			 	$pg->bukan_obat_id = $id;
			 }

			$pg->jenis_pengeluaran_id = $data['jenis_pengeluaran_id'];
			$pg->harga_satuan = $data['harga_satuan'];
			$pg->jumlah = $data['jumlah'];
            $pg->staf_id = $staf_id;
			$confirm = $pg->save();

			if ($confirm) {
				$jurnal                  = new JurnalUmum;
				$jurnal->jurnalable_id   = $pg_id;
				$jurnal->jurnalable_type = 'App\Pengeluaran';
				if (!empty($bo->coa_id)) {
					$jurnal->coa_id = $bo->coa_id; //khusu untuk pengeluaran ini, coa belum dibuat
				}
				$jurnal->debit           = 1;
				$jurnal->nilai           = $data['harga_satuan'] * $data['jumlah'];
				$jurnal->save();

				$jurnal                  = new JurnalUmum;
				$jurnal->jurnalable_id   = $pg_id;
				$jurnal->jurnalable_type = 'App\Pengeluaran';
				$jurnal->coa_id          = 110000; // kas di tangan
				$jurnal->debit           = 0;
				$jurnal->nilai           = $data['harga_satuan'] * $data['jumlah'];
				$jurnal->save();
			}
		}

		$fb = FakturBelanja::find($faktur_belanja_id);
		$fb->submit = '1';
		$fb->save();

		return redirect('fakturbelanjas')->withPesan(Yoga::suksesFlash('<strong>Transaksi Uang Keluar</strong> berhasil dilakukan'));
	}

	public function lists() {
		// return Input::all();
		$mulai = Yoga::datePrep(Input::get('mulai'));
		$akhir = Yoga::datePrep(Input::get('akhir'));

		$notas = FakturBelanja::where('tanggal', '>=', $mulai)->where('tanggal', '<=', $akhir)->get();
		// return dd($notas);
		return view('pengeluarans.list', compact('notas', 'mulai', 'akhir'));

	}


	public function show($id){

		$pengeluarans = Pengeluaran::where('faktur_belanja_id', $id)->get();
		$nota = FakturBelanja::find($id);
		return view('pengeluarans.show', compact('pengeluarans', 'nota'));

	}

	public function ketkeluar(){
		$keterangan = Input::get('keterangan');

		$bukanObat = BukanObat::where('nama', $keterangan)->get();
		if ($bukanObat->count() > 0) {
			$result = [
				'confirm' => '1',
				'cont'    => [
					'jumlah'      => $bukanObat[0]->harga_beli,
					'jml_peng_id' => $bukanObat[0]->jenis_pengeluaran_id
				]
			];
		} else {
			$result = [
				'confirm' => '0'
			];
		}

		return json_encode($result);
    }

    public function bayardokterdetail(){
        $tanggal_mulai = Input::get('tanggal_mulai');
        $tanggal_akhir = Input::get('tanggal_akhir');
        $query = "select p.tanggal as tanggal, st.nama as nama_staf, ps.id as pasien_id, ps.nama as nama, asu.nama as nama_asuransi, tunai, piutang, nilai  from jurnal_umums as ju join periksas as p on p.id=ju.jurnalable_id join stafs as st on st.id= p.staf_id join pasiens as ps on ps.id=p.pasien_id join asuransis as asu on asu.id=p.asuransi_id where jurnalable_type='App\\\Periksa' and p.staf_id='{$id}' and ju.coa_id=200001 where p.tanggal between '{$tanggal_mulai}' and '{$tanggal_akhir}';";
        $hutangs = DB::select($query);
        $total = 0;
        foreach ($hutangs as $hutang) {
            $total += $hutang->nilai;
        }
        return view('bayardokterdetail', compact('hutangs', 'total'));

    }

    public function bayardokter($id){
         
        $staf = Staf::find($id);
        return view('bayardokter', compact('staf'));
    }

    public function dokterbayar(){
         
        $id = Input::get('staf_id');
        $nama_staf = Staf::find($id)->nama;
		$mulai = Input::get('mulai');
		$akhir = Input::get('akhir');

		$mulai = Yoga::nowIfEmptyMulai($mulai);
		$akhir = Yoga::nowIfEmptyAkhir($akhir);
         
        $query = "select p.tanggal as tanggal, st.nama as nama_staf, ps.id as pasien_id, ps.nama as nama, asu.nama as nama_asuransi, tunai, piutang, nilai  from jurnal_umums as ju join periksas as p on p.id=ju.jurnalable_id join stafs as st on st.id= p.staf_id join pasiens as ps on ps.id=p.pasien_id join asuransis as asu on asu.id=p.asuransi_id where jurnalable_type='App\\\Periksa' and p.staf_id='{$id}' and ju.coa_id=200001 and ( p.tanggal between '{$mulai}' and '{$akhir}' );";
        $hutangs = DB::select($query);
        $total = 0;
        foreach ($hutangs as $hutang) {
            $total += $hutang->nilai;
        }
        return view('dokterbayar', compact('hutangs', 'total', 'nama_staf', 'mulai', 'akhir', 'id'));
    }

    
    public function dokterdibayar(){
        $staf_id = Input::get('staf_id');
        $staf = Staf::find($staf_id);
        $jasa_dokter = Input::get('jasa_dokter');        
        $dibayar = Input::get('dibayar');
        if ($dibayar > 0) {
            $bayar = new BayarDokter;
            $bayar->staf_id = $staf_id;
            $bayar->bayar_dokter = $dibayar;
            $confirm = $bayar->save();
            if ($confirm) {
				$jurnal                  = new JurnalUmum;
				$jurnal->jurnalable_id   = $bayar->id;
				$jurnal->jurnalable_type = 'App\BayarDokter';
				$jurnal->coa_id          = 200001; // Kas di tangan
				$jurnal->debit           = 1;
				$jurnal->nilai           = $bayar->bayar_dokter;
				$jurnal->save();
                
				$jurnal                  = new JurnalUmum;
				$jurnal->jurnalable_id   = $bayar->id;
				$jurnal->jurnalable_type = 'App\BayarDokter';
				$jurnal->coa_id          = 110000; // Kas di tangan
				$jurnal->debit           = 0;
				$jurnal->nilai           = $bayar->bayar_dokter;
				$jurnal->save();

                $pesan = Yoga::suksesFlash('Gaji ' . $staf->nama . ' sebesar Rp. ' . $dibayar . ',- . Berhasil diinput' );
            } else {
                $pesan = Yoga::gagalFlash('Gaji ' . $staf->nama . ' sebesar Rp. ' . $dibayar . ',- . Gagal diinput' );
            }            
        }
        return redirect('stafs')->withPesan($pesan);
    }
}
