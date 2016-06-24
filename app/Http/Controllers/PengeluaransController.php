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
use App\BayarGaji;
use App\User;
use App\Coa;
use App\Penjualan;
use App\TransaksiPeriksa;
use App\CheckoutKasir;
use App\BayarDokter;
use App\Periksa;
use App\JurnalUmum;
use App\Staf;
use DB;
use Hash;
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

        return redirect('fakturbelanjas/cari')->withPesan(Yoga::suksesFlash('<strong>Transaksi Uang Keluar</strong> berhasil dilakukan'))
            ->withPrint($faktur_belanja_id);
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
        $petugas_id = Input::get('petugas_id');
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
                $bayar->petugas_id = $petugas_id;
                $bayar->bayar_dokter = $dibayar;
                $bayar->hutang = $hutang;
                $bayar->mulai =  $mulai ;
                $bayar->akhir =  $akhir ;
                $confirm = $bayar->save();
                if ($confirm) {

                    if ($dibayar == $hutang) {
                        $jurnal                  = new JurnalUmum;
                        $jurnal->jurnalable_id   = $bayar->id;
                        $jurnal->jurnalable_type = 'App\BayarDokter';
                        $jurnal->coa_id          = 200001; // Hutang Kepada Dokter
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
                        $jurnal->coa_id          = 200001; // Hutang Kepada Dokter
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

                        
                        //Jurnal Umum untuk sisa dengan b. operasional jasa dokter
                        $jurnal                  = new JurnalUmum;
                        $jurnal->jurnalable_id   = $bayar->id;
                        $jurnal->jurnalable_type = 'App\BayarDokter';
                        $jurnal->coa_id          = 200001; // Hutang kepada dokter
                        $jurnal->debit           = 1;
                        $jurnal->nilai           = $hutang- $dibayar;
                        $jurnal->save();

                        $jurnal                  = new JurnalUmum;
                        $jurnal->jurnalable_id   = $bayar->id;
                        $jurnal->jurnalable_type = 'App\BayarDokter';
                        $jurnal->coa_id          = 50201; // B. Produksi Jasa Dokter
                        $jurnal->debit           = 0;
                        $jurnal->nilai           = $hutang- $dibayar;
                        $jurnal->save();

                        //Create Jurnal Umum untuk hutang saja
                        $jurnal                  = new JurnalUmum;
                        $jurnal->jurnalable_id   = $bayar->id;
                        $jurnal->jurnalable_type = 'App\BayarDokter';
                        $jurnal->coa_id          = 200001; // Hutang kepada dokter
                        $jurnal->debit           = 1;
                        $jurnal->nilai           = $dibayar;
                        $jurnal->save();

                        $jurnal                  = new JurnalUmum;
                        $jurnal->jurnalable_id   = $bayar->id;
                        $jurnal->jurnalable_type = 'App\BayarDokter';
                        $jurnal->coa_id          = 110000; // Kas di kasir
                        $jurnal->debit           = 0;
                        $jurnal->nilai           = $dibayar;
                        $jurnal->save();
                }
            }
            $pesan = Yoga::suksesFlash('Gaji ' . $staf->nama . ' sebesar Rp. ' . $dibayar . ',- . Berhasil diinput' );
            return redirect('stafs')->withPesan($pesan)->withPrint($bayar->id);
        } else {
            $pesan = Yoga::gagalFlash('Gaji ' . $staf->nama . ' sebesar Rp. ' . $dibayar . ',- . Gagal diinput' );
            return redirect('stafs')->withPesan($pesan);
        }
    }
    public function bayar(){
        $bayar_dokters = BayarDokter::latest()->paginate(30);
        return view('formbayardokter', compact('bayar_dokters'));
    }
    
    public function nota_z(){
        $jurnalumums = JurnalUmum::all();
		foreach ($jurnalumums as $k => $ju) {
			try {
				$ju->coa->coa;
			} catch (\Exception $e) {
				return redirect('jurnal_umums/coa')->withPesan(Yoga::gagalFlash('Ada beberapa Chart Of Account yang harus disesuaikan dulu'));
			}
		}
        $checkout = CheckoutKasir::latest()->first();
        $tanggal = $checkout->created_at;
        $jurnal_umum_id = $checkout->jurnal_umum_id;
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
        $table = $this->table();
        $all_id = [];


        foreach ($table as $tbl) {
            foreach ($tbl['jurnalable_id'] as $tbl_id) {
                $all_id[] = $tbl_id;
            }
        }


        $checkouts = CheckoutKasir::latest()->paginate(20);
        $uang_di_kasir = $modal_awal + $total_uang_masuk - $total_uang_keluar;
        $query = "select min( jt.jenis_tarif ) as jenis_tarif, count(tp.biaya) as jumlah  from transaksi_periksas as tp join periksas as px on px.id=tp.periksa_id join jenis_tarifs as jt on jt.id = tp.jenis_tarif_id where px.tanggal >= '{$tanggal}' group by tp.jenis_tarif_id";
        $transaksis = DB::select($query);
        return view('pengeluarans.notaz', compact('checkouts','transaksis', 'tanggal', 'asuransis', 'total_uang_masuk', 'total_uang_keluar', 'uang_di_kasir', 'modal_awal', 'table', 'all_id'));
    }
    public function notaz_post(){
        $table = $this->table();
        //return $table;

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
    

        foreach ($table as $transaksi) {
            $detail = new CheckoutDetail; 
            $detail->coa_id = $transaksi['coa_id'];
            $detail->jumlah = $transaksi['jumlah'];
            $detail->nilai = $transaksi['nilai'];
            $detail->checkout_kasir_id = $new_z->id;
            $detail->save();
        }
        //tambah semua komponen yang masuk kas, retrieve semua last id nya
        $pesan = Yoga::suksesFlash('Transaksi Checkout ( Nota Z ) tanggal ' . $new_z->created_at . ' <strong>Berhasil</strong> dilakukan');
        return redirect('pengeluarans/nota_z')->withPesan($pesan)->withPrint($new_z->id);
    }

    public function erce(){
        $modals = Modal::latest()->paginate(20);
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
        $modal->staf_id = Input::get('staf_id');
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
        return redirect('pengeluarans/rc')->withpesan($pesan)->withPrint($modal->id);

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
    public function notaz_detail($id){
         $ids = json_decode($id, true);
         $periksas = Periksa::whereIn('id', $ids)->paginate(4);
		return view('pengeluarans.detail_transaksi', compact('periksas'));
    }
    public function confirm_staf(){
        $email = Input::get('email');
        $password = Input::get('password');

        $user = User::where('email', $email)->first();
        if ($user) {
            $hashedPassword = $user->password; 
        } else {
            return '0';// user belum terdaftar
        }

        if( Hash::check($password, $hashedPassword) ){
            if ($email == 'yoga_email@yahoo.com') {
                return '1'; // user berhasil confirm
            }else{
                return '2';// user tidak punya otoritas
            }
        }else {
            return '3'; // kombinasi email / password salah
        }

    }
    public function bayar_gaji_karyawan(){
        $sumber_kas_lists = [null => '-Pilih-'] + Coa::where('id', 'like', '110%')->lists('coa', 'id')->all();
        $pembayarans = BayarGaji::latest()->paginate(20);
        return view('pengeluarans.bayar_gaji_karyawan', compact(  'pembayarans' , 'sumber_kas_lists'));
    }
    
   public function bayar_gaji(){
       $staf_id = Input::get('staf_id');
       $coa_id = Input::get('coa_id');
       $bulan = Input::get('bulan');
       $bulan = Yoga::blnPrep($bulan);
       $gaji_pokok = Input::get('gaji_pokok');
       $bonus = Input::get('bonus');
       $tanggal_dibayar = Input::get('tanggal_dibayar');

           $jus = JurnalUmum::where('coa_id', '200002' )
               ->where('debit', '0')
               ->where('created_at', 'like', $bulan . '%')
               ->get();
           $total_bonus = 0;
           foreach ($jus as $ju) {
               $total_bonus += $ju->nilai;
           }

           $jus = JurnalUmum::where('coa_id', '200002' )
               ->where('debit', '1')
               ->where('created_at', 'like', $bulan . '%')
               ->get();

           $total_bonus_sudah_dibayar = 0;
           foreach ($jus as $ju) {
               $total_bonus_sudah_dibayar += $ju->nilai;
           }
           //return $total_bonus_sudah_dibayar . ' total bonys sudah dibayar';
           $sisa_hutang_bonus = $total_bonus - $total_bonus_sudah_dibayar;
           $data =  'total_bonus = ' . $total_bonus . '<br />';
           $data .=  'total_bonus_sudah_dibayar = ' . $total_bonus_sudah_dibayar . '<br />';
           $data .=  'sisa_hutang_bonus = ' . $sisa_hutang_bonus . '<br />';
           $data .=  'bonus = ' . $bonus . '<br />';

       $bg = new BayarGaji;
       $bg->staf_id = $staf_id;
       $bg->mulai = $bulan . '-01';
       $bg->akhir = date("Y-m-t", strtotime($bulan . '-01'));
       $bg->tanggal_dibayar = Yoga::datePrep($tanggal_dibayar);
       $bg->gaji_pokok = $gaji_pokok;
       $bg->bonus = $bonus;
       $bg->kas_coa_id = $coa_id;
       $confirm = $bg->save();

       if ($confirm) {
           if ($gaji_pokok > 0) {
                $jurnal                  = new JurnalUmum;
                $jurnal->jurnalable_id   = $bg->id;
                $jurnal->jurnalable_type = 'App\BayarGaji';
                $jurnal->coa_id          = 60101;
                $jurnal->debit           = 1;
                $jurnal->nilai           = $gaji_pokok;
                $jurnal->save();
           }
           //return $jus;
           // Hitung hutang kepada asisten dalam satu bulan, jika hutangnya masih lebih banyak lebih dari bonus dari pada yang sudah dibayarkan, maka jurnal masuk semua ke hutang
           if ($sisa_hutang_bonus >= $bonus) {
               if ($bonus > 0) {
                    $jurnal                  = new JurnalUmum;
                    $jurnal->jurnalable_id   = $bg->id;
                    $jurnal->jurnalable_type = 'App\BayarGaji';
                    $jurnal->coa_id          = 200002; // Hutang Kepada Asisten Dokter
                    $jurnal->debit           = 1;
                    $jurnal->nilai           = $bonus;
                    $jurnal->save();
               }
           } else{
               $beban_produksi_hutang_asisten = $bonus - $sisa_hutang_bonus;
               if ($sisa_hutang_bonus > 0) {
                    $jurnal                  = new JurnalUmum;
                    $jurnal->jurnalable_id   = $bg->id;
                    $jurnal->jurnalable_type = 'App\BayarGaji';
                    $jurnal->coa_id          = 200002;// Hutang Kepada Asisten Dokter
                    $jurnal->debit           = 1;
                    $jurnal->nilai           = $sisa_hutang_bonus;
                    $jurnal->save();
               }
               if ($beban_produksi_hutang_asisten > 0) {
                    $jurnal                  = new JurnalUmum;
                    $jurnal->jurnalable_id   = $bg->id;
                    $jurnal->jurnalable_type = 'App\BayarGaji';
                    $jurnal->coa_id          = 50205;
                    $jurnal->debit           = 1;
                    $jurnal->nilai           = $beban_produksi_hutang_asisten;
                    $jurnal->save();
               }
           }

           if ($bonus + $gaji_pokok > 0) {
                $jurnal                  = new JurnalUmum;
                $jurnal->jurnalable_id   = $bg->id;
                $jurnal->jurnalable_type = 'App\BayarGaji';
                $jurnal->coa_id          = $coa_id; //Kas Sumber
                $jurnal->debit           = 0;
                $jurnal->nilai           = $gaji_pokok + $bonus;
                $jurnal->save();
           }
                        
           $pesan = Yoga::suksesFlash('Pembayaran Gaji kepada <strong>' . Staf::find($staf_id)->nama . '</strong> sebesar <strong class="uang">' . ( $gaji_pokok + $bonus ) . '</strong> telah <strong>BERHASIL</strong>' );
               return redirect('pengeluarans/bayar_gaji_karyawan')
                            ->withPesan($pesan)
                            ->withPrint($bg->id);
       }else {
           $pesan = Yoga::gagalFlash('Pembayaran Gaji kepada <strong>' . Staf::find($staf_id)->nama . '</strong> sebesar <strong class="uang">' . $gaji_pokok + $bonus . '</strong> telah <strong>GAGAL</strong>' );
               return redirect('pengeluarans/bayar_gaji_karyawan')
                            ->withPesan($pesan);
       }


   }
    private function table(){
        $checkout = CheckoutKasir::latest()->first();
        $jurnal_umum_id = $checkout->jurnal_umum_id;
        $query = "select min(jurnalable_type) as jurnalable_type, min(ju.id) as id, jurnalable_id as jurnalable_id, min( coa_id ) as coa_id from jurnal_umums as ju where coa_id=110000 and debit = 1 and ju.id > {$jurnal_umum_id} group by jurnalable_id;";
        $rinci = DB::select($query);
        $table = [];
        foreach ($rinci as $rc) {
            $arrs = $rc->jurnalable_type::find($rc->jurnalable_id)->jurnals;
            $valid = false;
            foreach ($arrs as $key => $ar) {
                if ( $key > 0 && $arrs[$key-1]->coa_id == 110000 && $arrs[$key-1]->debit == 1 ){
                    $valid = true;
                }
                if ($valid && $ar->debit == 0) {
                    $sama = false;
                    foreach ($table as $k=> $tab) {
                        if( $tab['coa_id'] == $ar->coa_id){
                            $table[$k]['nilai'] = $tab['nilai'] + $ar->nilai;
                            $table[$k]['jumlah'] = $tab['jumlah'] + 1;
                            $sama = true;
                            $id_sama = false;
                            foreach ($tab['jurnalable_id'] as $jurnl) {
                                if ($jurnl == $rc->jurnalable_id) {
                                    $id_sama = true;
                                }
                            }
                            if (!$id_sama) {
                                $table[$k]['jurnalable_id'][] = $rc->jurnalable_id;
                            }
                        }
                    }
                    if (!$sama) {
                        $table[] =[
                            'coa_id' => $ar->coa_id,
                            'coa'    => $ar->coa->coa,
                            'nilai'  => $ar->nilai,
                            'jumlah' => 1,
                            'jurnalable_id' => [
                                 $rc->jurnalable_id
                            ]

                        ]; 
                    }
                } else if ($ar->debit == 1 && $ar->coa_id != 110000 ) {
                        break;
                }
            }
        }
        return $table;
    }
    
    

}
