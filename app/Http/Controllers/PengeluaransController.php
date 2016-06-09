<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\FakturBelanja;
use App\JenisPengeluaran;
use App\Classes\Yoga;
use App\BukanObat;
use App\CheckoutDetail;
use App\Pembelian;
use App\Diagnosa;
use App\Modal;
use App\Coa;
use App\Penjualan;
use App\TransaksiPeriksa;
use App\CheckoutKasir;
use App\BayarDokter;
use App\Periksa;
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
        $kas_keluar = 0;
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
					
					$bo                       = BukanObat::find($query[0]->id);
					$bo->jenis_pengeluaran_id = $data['jenis_pengeluaran_id'];
					$bo->harga_beli           = $data['harga_satuan'];
					$bo->save();
			 } else {
					$bo                       = new BukanObat;
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
				$jurnal->jurnalable_id   = $faktur_belanja_id;
				$jurnal->jurnalable_type = 'App\FakturBelanja';
				if (!empty($bo->coa_id)) {
					$jurnal->coa_id = $bo->coa_id; //khusu untuk pengeluaran ini, coa belum dibuat
				}
				$jurnal->debit           = 1;
				$jurnal->nilai           = $data['harga_satuan'] * $data['jumlah'];
				$jurnal->save();
                
                $kas_keluar += $data['harga_satuan'] * $data['jumlah'];

			}
		}

        $jurnal                  = new JurnalUmum;
        $jurnal->jurnalable_id   = $faktur_belanja_id;
        $jurnal->jurnalable_type = 'App\FakturBelanja';
        $jurnal->coa_id          = 110000; // kas di tangan
        $jurnal->debit           = 0;
        $jurnal->nilai           = $kas_keluar;
        $jurnal->save();

		$fb = FakturBelanja::find($faktur_belanja_id);
		$fb->submit = '1';
		$fb->save();

		return redirect('fakturbelanjas')->withPesan(Yoga::suksesFlash('<strong>Transaksi Uang Keluar</strong> berhasil dilakukan'));
	}

	public function lists() {
		$mulai = Yoga::datePrep(Input::get('mulai'));
		$akhir = Yoga::datePrep(Input::get('akhir'));

		$notas = FakturBelanja::where('tanggal', '>=', $mulai)->where('tanggal', '<=', $akhir)->get();
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
         
        $hutangs = $this->hutangs($id, $mulai, $akhir);
        $total = $this->total($id, $mulai, $akhir);
        return view('dokterbayar', compact('hutangs', 'total', 'nama_staf', 'mulai', 'akhir', 'id'));
    }

    
    public function dokterdibayar(){
        $staf_id = Input::get('staf_id');
        $mulai = Input::get('mulai');
        $akhir = Input::get('akhir');
        $total = $this->total($staf_id, $mulai, $akhir);
        $hutang = Input::get('hutang');
        $staf = Staf::find($staf_id);
        $jasa_dokter = Input::get('jasa_dokter');        
        $dibayar = Input::get('dibayar');
        if ($dibayar > 0) {
                $bayar = new BayarDokter;
                $bayar->staf_id = $staf_id;
                $bayar->bayar_dokter = $dibayar;
                $bayar->hutang = $hutang;
                $confirm = $bayar->save();
                if ($confirm) {

                    if ($dibayar == $hutang) {
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
                    } else if($dibayar  > $hutang){
                        //Create Jurnal Umum untuk hutang saja
                        $jurnal                  = new JurnalUmum;
                        $jurnal->jurnalable_id   = $bayar->id;
                        $jurnal->jurnalable_type = 'App\BayarDokter';
                        $jurnal->coa_id          = 200001; // Kas di tangan
                        $jurnal->debit           = 1;
                        $jurnal->nilai           = $hutang;
                        $jurnal->save();

                        $jurnal                  = new JurnalUmum;
                        $jurnal->jurnalable_id   = $bayar->id;
                        $jurnal->jurnalable_type = 'App\BayarDokter';
                        $jurnal->coa_id          = 110000; // Kas di kasir
                        $jurnal->debit           = 0;
                        $jurnal->nilai           = $hutang;
                        $jurnal->save();
                        //Jurnal Umum untuk sisa dengan b. operasional jasa dokter
                        $jurnal                  = new JurnalUmum;
                        $jurnal->jurnalable_id   = $bayar->id;
                        $jurnal->jurnalable_type = 'App\BayarDokter';
                        $jurnal->coa_id          = 50201; // B. Produksi Jasa Dokter
                        $jurnal->debit           = 1;
                        $jurnal->nilai           = $dibayar - $hutang;
                        $jurnal->save();

                        $jurnal                  = new JurnalUmum;
                        $jurnal->jurnalable_id   = $bayar->id;
                        $jurnal->jurnalable_type = 'App\BayarDokter';
                        $jurnal->coa_id          = 110000; // Kas di kasir
                        $jurnal->debit           = 0;
                        $jurnal->nilai           = $dibayar - $hutang;
                        $jurnal->save();
                        

                } else if($dibayar  < $hutang){

                        $jurnal                  = new JurnalUmum;
                        $jurnal->jurnalable_id   = $bayar->id;
                        $jurnal->jurnalable_type = 'App\BayarDokter';
                        $jurnal->coa_id          = 50201; // B. Produksi Jasa Dokter
                        $jurnal->debit           = 1;
                        $jurnal->nilai           = $hutang- $dibayar;
                        $jurnal->save();
                        
                        //Jurnal Umum untuk sisa dengan b. operasional jasa dokter
                        $jurnal                  = new JurnalUmum;
                        $jurnal->jurnalable_id   = $bayar->id;
                        $jurnal->jurnalable_type = 'App\BayarDokter';
                        $jurnal->coa_id          = 200001; // Hutang kepada dokter
                        $jurnal->debit           = 0;
                        $jurnal->nilai           = $hutang- $dibayar;
                        $jurnal->save();

                        //Create Jurnal Umum untuk hutang saja
                        $jurnal                  = new JurnalUmum;
                        $jurnal->jurnalable_id   = $bayar->id;
                        $jurnal->jurnalable_type = 'App\BayarDokter';
                        $jurnal->coa_id          = 200001; // Hutang kepada dokter
                        $jurnal->debit           = 1;
                        $jurnal->nilai           = $hutang;
                        $jurnal->save();

                        $jurnal                  = new JurnalUmum;
                        $jurnal->jurnalable_id   = $bayar->id;
                        $jurnal->jurnalable_type = 'App\BayarDokter';
                        $jurnal->coa_id          = 110000; // Kas di kasir
                        $jurnal->debit           = 0;
                        $jurnal->nilai           = $hutang;
                        $jurnal->save();
                }
            }
            $pesan = Yoga::suksesFlash('Gaji ' . $staf->nama . ' sebesar Rp. ' . $dibayar . ',- . Berhasil diinput' );
        } else {
            $pesan = Yoga::gagalFlash('Gaji ' . $staf->nama . ' sebesar Rp. ' . $dibayar . ',- . Gagal diinput' );
        }
        return redirect('stafs')->withPesan($pesan);
    }
    public function bayar(){
         
        return view('formbayardokter');
    }
    
    public function nota_z(){
        $checkout = CheckoutKasir::latest()->first();
        $tanggal = $checkout->created_at;
        $tindakans = [];
        $asuransis = Periksa::where('created_at', '>=', $tanggal)->groupBy('asuransi_id')->get();
        $uang_masuks = JurnalUmum::where('created_at', '>=', $tanggal)
                                    ->where('coa_id', 110000)
                                    ->where('jurnalable_type', '!=', 'App\Modal')
                                    ->where('jurnalable_type', '!=', 'App\CheckoutKasir')
                                    ->where('debit', '1')
                                    ->get();

        $modal_awals = JurnalUmum::where('created_at', '>=', $tanggal)
                                    ->where('coa_id', 110000)
                                    ->where('jurnalable_type', 'App\Modal')
                                    ->where('debit', '1')
                                    ->get();

        $uang_keluar = JurnalUmum::where('created_at', '>=', $tanggal)
                                    ->where('coa_id', 110000)
                                    ->where('jurnalable_type', '!=', 'App\Modal')
                                    ->where('jurnalable_type', '!=', 'App\CheckoutKasir')
                                    ->where('debit', '0')
                                    ->get();
        $modal_awal = 0;
        foreach ($modal_awals as $md) {
            $modal_awal += $md->nilai;
        }

        $total_uang_masuk = 0;
        foreach ($uang_masuks as $penjualan) {
            $total_uang_masuk += $penjualan->nilai;
        }
        $total_uang_keluar = 0;
        foreach ($uang_keluar as $penjualan) {
            $total_uang_keluar += $penjualan->nilai;
        }
        $checkouts = CheckoutKasir::latest()->paginate(20);
        $uang_di_kasir = $modal_awal + $total_uang_masuk - $total_uang_keluar;
        $query = "select min( jt.jenis_tarif ) as jenis_tarif, count(tp.biaya) as jumlah  from transaksi_periksas as tp join periksas as px on px.id=tp.periksa_id join jenis_tarifs as jt on jt.id = tp.jenis_tarif_id where px.tanggal >= '{$tanggal}' group by tp.jenis_tarif_id";
        $transaksis = DB::select($query);
        return view('pengeluarans.notaz', compact('checkouts','transaksis', 'tanggal', 'asuransis', 'total_uang_masuk', 'total_uang_keluar', 'uang_di_kasir', 'modal_awal'));
    }
    public function notaz_post(){

        $last_chekcout = CheckoutKasir::latest()->first();
        $uang_di_tangan = $last_chekcout->uang_di_tangan;
        $jurnal_umum_id_last_cehckout = $last_chekcout->jurnal_umum_id;
        $tanggal = $last_chekcout->created_at;
        //return 'jurnal umum terakhir id = ' .$jurnal_umum_id_last_cehckout;
        //Modal awal dihitung dari id jurnal umum terakhir checkout
        $jurnal_umums = JurnalUmum::where('id', '>=', $jurnal_umum_id_last_cehckout)
                        ->where('jurnalable_type', 'App\Modal')
                        ->get();
        $modal_awal = 0;
        foreach ($jurnal_umums as $ju) {
            if (
                $ju->debit == 0 && 
                ($ju->coa_id == 301000 || $ju->coa_id == 110004)
            ) {
               $modal_awal +=  $ju->nilai;
            }
        }
        $uang_masuks = JurnalUmum::where('id', '>', $jurnal_umum_id_last_cehckout)
                                ->where('coa_id', 110000) 
                                ->where('jurnalable_type', '!=', 'App\Modal')
                                ->where('debit', '1')
                                ->get();
        $total_uang_masuk = 0;
        foreach ($uang_masuks as $masuk) {
            $total_uang_masuk += $masuk->nilai;
        }
        $uang_keluars = JurnalUmum::where('id', '>', $jurnal_umum_id_last_cehckout)
                                ->where('coa_id', 110000) 
                                ->where('jurnalable_type', '!=', 'App\Modal')
                                ->where('debit', '0')
                                ->get();
        $total_uang_keluar = 0;
        foreach ($uang_keluars as $keluar) {
            $total_uang_keluar += $keluar->nilai;
        }
        //return dd( $uang_masuks );
        //return dd( $uang_keluars );
        //return 'total_uang_masuk = ' . $total_uang_masuk;
        //return 'total_uang_keluar = ' . $total_uang_keluar;
        $uang_di_kasir = $modal_awal + $total_uang_masuk - $total_uang_keluar;
        $query = "select min(jenis_tarif_id) as jenis_tarif_id, min( jt.jenis_tarif ) as jenis_tarif, count(tp.biaya) as jumlah  from transaksi_periksas as tp join periksas as px on px.id=tp.periksa_id join jenis_tarifs as jt on jt.id = tp.jenis_tarif_id where tp.created_at >= '{$tanggal}' group by tp.jenis_tarif_id";
        $transaksis = DB::select($query);
        //pindahkan semua kas di kasir menjadi kas di tangan
        $new_z = new CheckoutKasir;
        $new_z->modal_awal = $modal_awal;
        $new_z->uang_di_kasir = $uang_di_kasir;
        $new_z->uang_di_tangan = $uang_di_tangan + $uang_di_kasir;
        $new_z->jurnal_umum_id = JurnalUmum::all()->last()->id;
        $new_z->uang_masuk = $total_uang_masuk;
        $new_z->uang_keluar = $total_uang_keluar;
        $confirm = $new_z->save();
        if ($confirm) {
            $jurnal                  = new JurnalUmum;
            $jurnal->jurnalable_id   = $new_z->id;
            $jurnal->jurnalable_type = 'App\CheckoutKasir';
            $jurnal->coa_id          = 110004; // Kas di tangan
            $jurnal->debit           = 1;
            $jurnal->nilai           = $uang_di_kasir;
            $jurnal->save();

            $jurnal                  = new JurnalUmum;
            $jurnal->jurnalable_id   = $new_z->id;
            $jurnal->jurnalable_type = 'App\CheckoutKasir';
            $jurnal->coa_id          = 110000; // Kas di kasir
            $jurnal->debit           = 0;
            $jurnal->nilai           = $uang_di_kasir;
            $jurnal->save();
        }
    
        foreach ($transaksis as $transaksi) {
            $detail = new CheckoutDetail; 
            $detail->jenis_tarif_id = $transaksi->jenis_tarif_id;
            $detail->jumlah = $transaksi->jumlah;
            $detail->checkout_kasir_id = $new_z->id;
            $detail->save();
        }
        //tambah semua komponen yang masuk kas, retrieve semua last id nya
        $pesan = Yoga::suksesFlash('Transaksi Checkout ( Nota Z ) tanggal ' . $new_z->created_at . ' <strong>Berhasil</strong> dilakukan');
        return redirect('pengeluarans/nota_z')->withPesan($pesan);
    }

    public function erce(){
        $modals = Modal::paginate(20);
        $sumberUangList = [
            null => '-pilih-',
            301000 => 'Modal',
            110004 => 'Kas di tangan'
        ];
         return view('pengeluarans.rc', compact('modals', 'sumberUangList'));
    }
    public function erce_post(){
        //menambah modal
        $modal = new Modal;
        $modal->coa_kas_id = Input::get('sumber_uang');
        $modal->modal = Input::get('kas_masuk');
        $modal->save();
        
        $jurnal                  = new JurnalUmum;
        $jurnal->jurnalable_id   = $modal->id;
        $jurnal->jurnalable_type = 'App\Modal';
        $jurnal->coa_id          = 110000; // Kas di kasir
        $jurnal->debit           = 1;
        $jurnal->nilai           = $modal->modal;
        $jurnal->save();

        if ( Input::get('sumber_uang') == 301000 ) {
            $sumberModal = true;
        } else {
            $sumberModal = false;
        }
        //return dd( $sumberModal );
        if ($sumberModal) {
            $jurnal                  = new JurnalUmum;
            $jurnal->jurnalable_id   = $modal->id;
            $jurnal->jurnalable_type = 'App\Modal';
            $jurnal->coa_id          = 301000; // modal
            $jurnal->debit           = 0;
            $jurnal->nilai           = $modal->modal;
            $jurnal->save();
        }else {
            $jurnal                  = new JurnalUmum;
            $jurnal->jurnalable_id   = $modal->id;
            $jurnal->jurnalable_type = 'App\Modal';
            $jurnal->coa_id          = 110004; // kas di tangan
            $jurnal->debit           = 0;
            $jurnal->nilai           = $modal->modal;
            $jurnal->save();
        }
        $pesan = Yoga::suksesFlash('Modal senilai <strong><span class="uang">' . $modal->modal. '</span></strong> telah <strong>BERHASIL</strong> ditambahkan dengan sumber modal dari <strong>'. $jurnal->coa->coa .'</strong>');
        return redirect('pengeluarans/rc')->withpesan($pesan);
    }

    public function show_checkout($id){
        $checkout = CheckoutKasir::find($id);
        return view('pengeluarans.show_checkout', compact('checkout'));
    }
    
    
    private function hutangs($id, $mulai, $akhir){
         
        $query = "select p.id as periksa_id, p.tanggal as tanggal, st.nama as nama_staf, ps.id as pasien_id, ps.nama as nama, asu.nama as nama_asuransi, tunai, piutang, nilai  from jurnal_umums as ju join periksas as p on p.id=ju.jurnalable_id join stafs as st on st.id= p.staf_id join pasiens as ps on ps.id=p.pasien_id join asuransis as asu on asu.id=p.asuransi_id where jurnalable_type='App\\\Periksa' and p.staf_id='{$id}' and ju.coa_id=200001 and ( p.tanggal between '{$mulai}' and '{$akhir}' );";
        $hutangs = DB::select($query);

        return $hutangs;
    }
    private function total($id, $mulai, $akhir){
         
        $query = "select p.id as periksa_id, p.tanggal as tanggal, st.nama as nama_staf, ps.id as pasien_id, ps.nama as nama, asu.nama as nama_asuransi, tunai, piutang, nilai  from jurnal_umums as ju join periksas as p on p.id=ju.jurnalable_id join stafs as st on st.id= p.staf_id join pasiens as ps on ps.id=p.pasien_id join asuransis as asu on asu.id=p.asuransi_id where jurnalable_type='App\\\Periksa' and p.staf_id='{$id}' and ju.coa_id=200001 and ( p.tanggal between '{$mulai}' and '{$akhir}' );";
        $hutangs = DB::select($query);
        $total = 0;
        foreach ($hutangs as $hutang) {
            $total += $hutang->nilai;
        }
        return $total;
    }

}
