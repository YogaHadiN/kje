<?php
namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\FakturBelanja;
use App\JenisPengeluaran;
use App\Classes\Yoga;
use App\BukanObat;
use App\BagiGigi;
use App\CheckoutDetail;
use App\Pembelian;
use App\Pasien;
use App\BelanjaPeralatan;
use App\Pendapatan;
use App\Diagnosa;
use App\PembayaranAsuransi;
use App\Modal;
use App\Supplier;
use App\BayarGaji;
use App\User;
use App\Coa;
use App\GajiGigi;
use App\Penjualan;
use App\TransaksiPeriksa;
use App\CheckoutKasir;
use App\BayarDokter;
use App\Periksa;
use App\JurnalUmum;
use App\Ac;
use App\Staf;
use Image;
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
	public function __construct()
	 {
	     $this->middleware('super', ['only' => ['bayar_gaji_karyawan', 'nota_z']]);
	 }
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
		$messages          = array(
			'required'    => ':attribute harus diisi terlebih dahulu',
		);
		$rules             = [
			'staf_id'     => 'required',
			'supplier_id' => 'required',
			'nilai'       => 'required',
			'tanggal'     => 'required|date_format:d-m-Y',
			'sumber_uang' => 'required',
			'keterangan'  => 'required'
		];
		$validator         = \Validator::make($data = Input::all(), $rules, $messages);
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator->messages());
		}
		$staf_id           = Input::get('staf_id');
		$supplier_id       = Input::get('supplier_id');
		$nilai             = Yoga::clean( Input::get('nilai') );
		$tanggal           = Input::get('tanggal');
		$keterangan        = Input::get('keterangan');

		$peng                 = new Pengeluaran;
		$peng->staf_id        = $staf_id;
		$peng->supplier_id    = $supplier_id;
		$peng->nilai          = $nilai;
		$peng->tanggal        = Yoga::datePrep( $tanggal );
		$peng->sumber_uang_id = Input::get('sumber_uang');
		$peng->keterangan     = $keterangan;
		$peng->save();
		$peng->faktur_image   = $this->imageUpload('faktur', 'faktur_image', $peng->id);
		$confirm              = $peng->save();

		if ($confirm) {
			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $peng->id;
			$jurnal->jurnalable_type = 'App\Pengeluaran';
			$jurnal->debit           = 1;
			$jurnal->nilai           = $peng->nilai;
			$jurnal->save();

			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $peng->id;
			$jurnal->jurnalable_type = 'App\Pengeluaran';
			$jurnal->coa_id          = Input::get('sumber_uang'); // Kas di tangan
			$jurnal->debit           = 0;
			$jurnal->nilai           = $peng->nilai;
			$jurnal->save();
		}
		$nama_supplier = Supplier::find($supplier_id)->nama;
		if ($confirm) {
			return redirect('suppliers/belanja_bukan_obat')->withPesan(Yoga::suksesFlash('Transaksi Uang Keluar kepada ' . $nama_supplier . ' senilai <span class=uang>' . $nilai .'</span> berhasil dilakukan'))->withPrint($peng->id);

		}else {
			return redirect('suppliers/belanja_bukan_obat')->withPesan(Yoga::gagalFlash('Transaksi Uang Keluar kepada ' . $nama_supplier . ' senilai <span class=uang>' . $nilai .'</span> gagal dilakukan'));
		}
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
		//return Input::all();
		$rules           = [
			'staf_id'   => 'required',
			'mulai'     => 'required',
			'jam_mulai' => 'required',
			'akhir'     => 'required',
			'jam_akhir' => 'required',
		];

		$validator = \Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

         
        $id = Input::get('staf_id');
        $nama_staf = Staf::find($id)->nama;
		$mulai = Input::get('mulai');
		$jam_mulai = Input::get('jam_mulai');
		$akhir = Input::get('akhir');
		$jam_akhir = Input::get('jam_akhir');

		$mulai = Yoga::datePrep($mulai);
		$mulai = $mulai . ' ' . $jam_mulai;
		$akhir = Yoga::datePrep($akhir);
		$akhir = $akhir . ' ' . $jam_akhir;
         
        $hutangs = $this->hutangs($id, $mulai, $akhir);
        $total   = $this->total($id, $mulai, $akhir);

        return view('dokterbayar', compact('hutangs', 'total', 'nama_staf', 'mulai', 'akhir', 'id'));
    }

    
    public function dokterdibayar(){

        $staf_id                       = Input::get('staf_id');
        $petugas_id                    = Input::get('petugas_id');
        $mulai                         = Input::get('mulai');
        $akhir                         = Input::get('akhir');
        $total                         = $this->total($staf_id, $mulai, $akhir);
        $hutang                        = Input::get('hutang');
        $staf                          = Staf::find($staf_id);
        $jasa_dokter                   = Input::get('jasa_dokter');
        $dibayar                       = Yoga::clean( Input::get('dibayar') );
        $sumber_uang_id                = Input::get('sumber_uang_id');
        if ($dibayar > 0) {
                $bayar                 = new BayarDokter;
                $bayar->staf_id        = $staf_id;
                $bayar->petugas_id     = $petugas_id;
                $bayar->bayar_dokter   = $dibayar;
                $bayar->hutang         = $hutang;
                $bayar->mulai          = $mulai ;
                $bayar->akhir          = $akhir ;
                $bayar->sumber_uang_id = $sumber_uang_id ;
                $confirm               = $bayar->save();
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
            return redirect('pengeluarans/bayardoker')->withPesan($pesan)->withPrint($bayar->id);
        } else {
            $pesan = Yoga::gagalFlash('Gaji ' . $staf->nama . ' sebesar Rp. ' . $dibayar . ',- . Gagal diinput' );
            return redirect('pengeluarans/bayardoker')->withPesan($pesan);
        }

    }
    public function bayar(){
        $bayar_dokters = BayarDokter::with('staf', 'petugas')->latest()->paginate(30);
        return view('formbayardokter', compact('bayar_dokters'));
    }
    
    public function nota_z(){

        $checkout = CheckoutKasir::latest()->first();
		//return dd( $checkout );

        $tanggal = $checkout->created_at;
		//return $tanggal;

        $jurnal_umum_id = $checkout->jurnal_umum_id;

        $tindakans = [];

		$modals = Modal::where('created_at', '>', $tanggal)->get();

		$totalModal = 0;
		foreach ($modals as $modal) {
			$totalModal += $modal->modal;
		}

		$pengeluarans = JurnalUmum::with('jurnalable')
									->where('coa_id', 110000)
                                    ->where('debit', '0')
                                    ->where('id', '>=', $checkout->jurnal_umum_id)
                                    ->where('jurnalable_type', 'not like', 'App\\\CheckoutKasir')
                                    ->get();

        $totalPengeluarans = 0;
        foreach ($pengeluarans as $peng) {
            $totalPengeluarans += $peng->nilai;
        }
        $jurnalumums = JurnalUmum::with('coa')->where('id', '>=', $checkout->jurnal_umum_id)->get();;

		foreach ($jurnalumums as $k => $ju) {
			try {
				$ju->coa->coa;
			} catch (\Exception $e) {
				return redirect('jurnal_umums/coa')->withPesan(Yoga::gagalFlash('Ada beberapa Chart Of Account yang harus disesuaikan dulu'));
			}
		}

        $asuransis = Periksa::where('created_at', '>=', $tanggal)->groupBy('asuransi_id')->get();

		$uang_masuks = JurnalUmum::with('jurnalable')->where('id', '>=', $checkout->jurnal_umum_id)
									->where('coa_id', 110000)
									->where('jurnalable_type', '!=', 'App\Modal')
									->where('jurnalable_type', '!=', 'App\CheckoutKasir')
									->where('debit', '1')
									->get();

        $modal_awals = JurnalUmum::where('id', '>=', $checkout->jurnal_umum_id)
                                    ->where('coa_id', 110000)
                                    ->where('jurnalable_type', 'App\Modal')
                                    ->where('debit', '1')
                                    ->get();

        $uang_keluar = JurnalUmum::where('id', '>=', $checkout->jurnal_umum_id)
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

		$pembayaran_asuransis = PembayaranAsuransi::where('created_at', '>', $tanggal)->get();
		$total_pembayaran_asuransi = 0;
		foreach ($pembayaran_asuransis as $p) {
			$total_pembayaran_asuransi += $p->pembayaran;
		}

		$periksas = DB::select("SELECT *, p.id as periksa_id, ps.nama as nama_pasien, asu.nama as nama_asuransi, p.id as periksa_id, p.poli as poli FROM periksas as p LEFT OUTER JOIN pasiens as ps on ps.id = p.pasien_id LEFT OUTER JOIN asuransis as asu on asu.id = p.asuransi_id where p.created_at > '{$tanggal}' AND p.lewat_kasir = '1'");
		$tunai_periksa = 0;
		foreach ($periksas as $p) {
			$tunai_periksa += $p->tunai;
		}

		$tunai_beli_obat = 0;
		$penjualans = Penjualan::where('created_at', '>', $tanggal)->get();
		foreach ($penjualans as $p) {
			$tunai_beli_obat += $p->harga_jual * $p->jumlah;
		}
		$pendapatans = Pendapatan::where('created_at', '>', $tanggal)->get();
		$total_pendapatan_lain = 0;
		foreach ($pendapatans as $p) {
			$total_pendapatan_lain += $p->nilai;
		}

		return view('pengeluarans.notaz', compact(
			'checkouts', 
			'tanggal', 
			'total_pendapatan_lain', 
			'pendapatans', 
			'tunai_beli_obat', 
			'tunai_periksa', 
			'asuransis', 
			'pembayaran_asuransis', 
			'total_uang_masuk', 
			'total_pembayaran_asuransi', 
			'total_uang_keluar', 
			'uang_di_kasir', 
			'modal_awal', 
			'checkout', 
			'pengeluarans', 
			'totalPengeluarans', 
			'modals', 
			'totalModal'
		));
    }
    public function notaz_post(){

		if (gethostname() == 'kje') {
			exec("mysqldump -u root -pYogaman89 jatielok | gzip > /home/kje/Dropbox/backup11/database_`date '+%m-%d-%Y_%H:%M:%S'`.sql.gz");
		} else {
			exec("mysqldump -u root -pYogaman89 jatielok | gzip > /home/dell/Documents/backup11/database_`date '+%m-%d-%Y_%H:%M:%S'`.sql.gz");
		}
		$uang_di_kasir     = $this->parameterKasir()['uang_di_kasir'];
		$total_uang_keluar = $this->parameterKasir()['total_uang_keluar'];
		$uang_di_tangan    = $this->parameterKasir()['uang_di_tangan'];
		$modal_awal        = $this->parameterKasir()['modal_awal'];
		$modal_ids         = $this->parameterKasir()['modal_ids'];
		$tanggal           = $this->parameterKasir()['tanggal'];
		$total_uang_masuk  = $this->parameterKasir()['total_uang_masuk'];
        $query = "select min(jenis_tarif_id) as jenis_tarif_id, min( jt.jenis_tarif ) as jenis_tarif, count(tp.biaya) as jumlah  from transaksi_periksas as tp join periksas as px on px.id=tp.periksa_id join jenis_tarifs as jt on jt.id = tp.jenis_tarif_id where tp.created_at >= '{$tanggal}' group by tp.jenis_tarif_id";
        $transaksis = DB::select($query);
        $pengeluarans = JurnalUmum::where('coa_id', 110000)
                                    ->where('debit', '0')
                                    ->where('created_at', '>=', $tanggal)
                                    ->where('jurnalable_type', '!=', 'App\CheckoutKasir')
                                    ->get(['id']);
        $detail_pengeluarans = [];
        foreach ($pengeluarans as $peng) {
            $detail_pengeluarans[] = $peng->id;
        } 
        $pengeluarans_tangan = JurnalUmum::where('coa_id', 110004)
                                    ->where('debit', '0')
                                    ->where('created_at', '>=', $tanggal)
                                    ->where('jurnalable_type', '!=', 'App\CheckoutKasir')
                                    ->where('jurnalable_type', '!=', 'App\Modal')
                                    ->get(['id']);
        $detail_pengeluarans_tangan = [];
        foreach ($pengeluarans_tangan as $peng) {
            $detail_pengeluarans_tangan[] = $peng->id;
        } 
        $detail_pengeluarans = json_encode( $detail_pengeluarans );
        //pindahkan semua kas di kasir menjadi kas di tangan

        $new_z                 = new CheckoutKasir;
        $new_z->modal_awal     = $modal_awal;
        $new_z->uang_di_kasir  = $uang_di_kasir;
        $new_z->uang_di_tangan = $uang_di_tangan + $uang_di_kasir;
		$last_jurnal_id        = JurnalUmum::orderBy('id', 'desc')->first()->id;

        if (isset($last_jurnal_id)) {
			$new_z->jurnal_umum_id = $last_jurnal_id;
		} else {
            $new_z->jurnal_umum_id = 1;
        }

        $new_z->uang_masuk               = $total_uang_masuk;
        $new_z->uang_keluar              = $total_uang_keluar;
        $new_z->detil_pengeluarans       = $detail_pengeluarans;
        $new_z->detil_pengeluaran_tangan = json_encode( $detail_pengeluarans_tangan );
        $new_z->detil_modals             = json_encode($modal_ids);

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
        //tambah semua komponen yang masuk kas, retrieve semua last id nya
        $pesan = Yoga::suksesFlash('Transaksi Checkout ( Nota Z ) tanggal ' . $new_z->created_at . ' <strong>Berhasil</strong> dilakukan');
		return redirect('pengeluarans/nota_z')
			->withPesan($pesan)
			->withModals($modal_awal)
			->withPrint($new_z->id);
    }

    public function erce(){
        $modals = Modal::with('coa')->latest()->paginate(20);
        $sumberUangList = [
            null => '-pilih-',
            301000 => 'Modal',
            110004 => 'Kas di tangan'
        ];
         return view('pengeluarans.rc', compact('modals', 'sumberUangList'));
    }
    public function erce_post(){
        //menambah modal
		
		$rules = [
			'sumber_uang' => 'required',
			'kas_masuk' => 'required',
			'staf_id' => 'required'
		];

		$validator = \Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
        $modal = new Modal;
        $modal->coa_kas_id = Input::get('sumber_uang');
        $modal->modal = Yoga::clean( Input::get('kas_masuk') );
        $modal->staf_id = Input::get('staf_id');
        $modal->keterangan = Input::get('keterangan');
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

        $notaz = CheckoutKasir::find($id);
		$buka_kasir = CheckoutKasir::find($id - 1)->created_at;
        $detils = json_decode( $notaz->detil_pengeluarans, true );
        $detils_tangan = json_decode( $notaz->detil_pengeluaran_tangan, true );
        $modals = json_decode( $notaz->detil_modals, true );
        $pengeluarans = JurnalUmum::whereIn('id', $detils)->get();
        $pengeluarans_tangan = JurnalUmum::whereIn('id', $detils_tangan)->get();
        $modals = JurnalUmum::whereIn('id', $modals)->get();
		$total_modal = 0;
		foreach ($modals as $mdl) {
			$total_modal += $mdl->nilai;
		}

		$total_pengeluaran = 0;
		foreach ($pengeluarans as $mdl) {
			$total_pengeluaran += $mdl->nilai;
		}

		$total_pengeluaran_tangan = 0;
		foreach ($pengeluarans_tangan as $mdl) {
			$total_pengeluaran_tangan += $mdl->nilai;
		}
        $total_pemasukan = 0;
        foreach ($notaz->checkoutDetail as $cd) {
            $total_pemasukan += $cd->nilai;
        }
		return view('pengeluarans.show_checkout', compact(
			'notaz', 
			'pengeluarans',
			'pengeluarans_tangan',
			'modals', 
			'buka_kasir', 
			'total_modal', 
			'total_pengeluaran',
			'total_pengeluaran_tangan',
			'total_pemasukan',
			'checkout'
		));
    }
    
    
    private function hutangs($id, $mulai, $akhir){
         
        $query = "select p.id as periksa_id, p.tanggal as tanggal, st.nama as nama_staf, ps.id as pasien_id, ps.nama as nama, asu.nama as nama_asuransi, tunai, piutang, nilai  from jurnal_umums as ju join periksas as p on p.id=ju.jurnalable_id join stafs as st on st.id= p.staf_id join pasiens as ps on ps.id=p.pasien_id join asuransis as asu on asu.id=p.asuransi_id where jurnalable_type='App\\\Periksa' and p.staf_id='{$id}' and ju.coa_id=200001 and ( p.created_at between '{$mulai}' and '{$akhir}' );";
        $hutangs = DB::select($query);

        return $hutangs;
    }
    private function total($id, $mulai, $akhir){
        $query = "select p.id as periksa_id, p.tanggal as tanggal, st.nama as nama_staf, ps.id as pasien_id, ps.nama as nama, asu.nama as nama_asuransi, tunai, piutang, nilai  from jurnal_umums as ju join periksas as p on p.id=ju.jurnalable_id join stafs as st on st.id= p.staf_id join pasiens as ps on ps.id=p.pasien_id join asuransis as asu on asu.id=p.asuransi_id where jurnalable_type='App\\\Periksa' and p.staf_id='{$id}' and ju.coa_id=200001 and ( p.created_at between '{$mulai}' and '{$akhir}' );";
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
        $pembayarans = BayarGaji::latest()->paginate(10);
        return view('pengeluarans.bayar_gaji_karyawan', compact(  'pembayarans' , 'sumber_kas_lists'));
    }
    
   public function bayar_gaji(){
	   $rules                = [
		 "coa_id"           => "required",
		  "staf_id"         => "required",
		  "bulan"           => "required",
		  "tanggal_dibayar" => "required",
		  "gaji_pokok"      => "required",
		  "bonus"           => "required"
	   ];
	   
	   $validator = \Validator::make(Input::all(), $rules);
	   
	   if ($validator->fails())
	   {
	   	return \Redirect::back()->withErrors($validator)->withInput();
	   }

       $staf_id = Input::get('staf_id');
       $coa_id = Input::get('coa_id');
       $bulan = Input::get('bulan');
       $bulan = Yoga::blnPrep($bulan);
       $gaji_pokok = Yoga::clean( Input::get('gaji_pokok') );
       $bonus = Yoga::clean( Input::get('bonus'));
	   $tanggal_dibayar = Yoga::datePrep( Input::get('tanggal_dibayar') );

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
       $bg->tanggal_dibayar = $tanggal_dibayar;
       $bg->gaji_pokok = $gaji_pokok;
       $bg->bonus = $bonus;
       $bg->kas_coa_id = $coa_id;
       $confirm = $bg->save();

       if ($confirm) {

		   if ((int)strtotime( date('Y-m-d H:i:s') ) > (int)strtotime( date($bulan . '-t 23:59:59') ) ) {
			    $a_date = $bulan. '-01';
				$timestamp = date('Y-m-t', strtotime($a_date)) . ' 23:59:59';
		   } else {
				$timestamp = date('Y-m-d H:i:s');
		   }
           if ($gaji_pokok > 0) {
                $jurnal                  = new JurnalUmum;
                $jurnal->jurnalable_id   = $bg->id;
                $jurnal->jurnalable_type = 'App\BayarGaji';
                $jurnal->coa_id          = 60101;
                $jurnal->debit           = 1;
				$jurnal->created_at      = $timestamp;
				$jurnal->updated_at      = $timestamp;
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
					$jurnal->created_at      = $timestamp;
					$jurnal->updated_at      = $timestamp;
                    $jurnal->nilai           = $bonus;
                    $jurnal->save();
               }
           } else{
			   if ($sisa_hutang_bonus > 0) {
				   $beban_produksi_hutang_asisten = $bonus - $sisa_hutang_bonus;
			   }else{
				   $beban_produksi_hutang_asisten = $bonus;
			   }
               if ($sisa_hutang_bonus > 0) {
                    $jurnal                  = new JurnalUmum;
                    $jurnal->jurnalable_id   = $bg->id;
                    $jurnal->jurnalable_type = 'App\BayarGaji';
                    $jurnal->coa_id          = 200002;// Hutang Kepada Asisten Dokter
                    $jurnal->debit           = 1;
					$jurnal->created_at      = $timestamp;
					$jurnal->updated_at      = $timestamp;
                    $jurnal->nilai           = $sisa_hutang_bonus;
                    $jurnal->save();
               }

               if ($beban_produksi_hutang_asisten > 0) {
                    $jurnal                  = new JurnalUmum;
                    $jurnal->jurnalable_id   = $bg->id;
                    $jurnal->jurnalable_type = 'App\BayarGaji';
                    $jurnal->coa_id          = 50205;
					$jurnal->created_at      = $timestamp;
					$jurnal->updated_at      = $timestamp;
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
				$jurnal->created_at      = $timestamp;
				$jurnal->updated_at      = $timestamp;
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
    private function table($checkout){
        $jurnal_umum_id = $checkout->jurnal_umum_id;
		$query = "select jurnalable_type, jurnalable_id from jurnal_umums as ju ";
		$query .= "where coa_id=110000 and ";
		$query .= "debit = 1 and ";
		$query .= "ju.id > {$jurnal_umum_id} ";
		$query .= "group by jurnalable_type, jurnalable_id;";
		$type_and_id = DB::select($query);
        $text = "select ju.debit, jurnalable_type, ju.id, ju.coa_id, co.coa, ju.nilai, ju.jurnalable_id from jurnal_umums as ju join coas as co on co.id = ju.coa_id where ju.id > {$jurnal_umum_id} ";
		if (count($type_and_id)) {
			$text .= "and ( ";
		}
		foreach ($type_and_id as $k => $value) {
			$type = $value->jurnalable_type;
			$type = explode("\\", $type);
			$jurnalable_type = $type[0] . '\\\\\\' . $type[1];

			$text .= "( jurnalable_type = '" . $jurnalable_type. "' and jurnalable_id = '" . $value->jurnalable_id. "' ) ";
			if ($k < count($type_and_id) -1) {
				$text .= "or ";
			}
		}

		if (count($type_and_id)) {
			$text .= ")";
		}

        $rinci = DB::select($text);
		$array=[];
		foreach ($rinci as $key => $r) {
			$sama = false;
			foreach ($array as $k=>$rr) { 
				foreach ($rr as $rrr) {
					if (
						$r->jurnalable_id == $rrr['jurnalable_id'] && 
						$r->jurnalable_type == $rrr['jurnalable_type']
					) {
						$sama = true;
						$count = count($array[$k]);
						$data = [
							'jurnalable_id' => $r->jurnalable_id,
							'jurnalable_type' => $r->jurnalable_type,
							'id' => $r->id,
							'debit' => $r->debit,
							'coa_id' => $r->coa_id,
							'coa' => $r->coa,
							'nilai' => $r->nilai,
						];

						$array[$k][count( $array[$k] )] = $data;
						break;
					}
				}
			}

			if (!$sama) {
				$count = count( $array );
				$data = [
					'jurnalable_id' => $r->jurnalable_id,
					'jurnalable_type' => $r->jurnalable_type,
					'id' => $r->id,
					'debit' => $r->debit,
					'coa_id' => $r->coa_id,
					'coa' => $r->coa,
					'nilai' => $r->nilai,
				];
				$array[$count][] = $data;
			}
		}
		
        $table = [];
		$errors = [];

        foreach ($array as $rc) {
            $valid = false;
            foreach ($rc as $key => $ar) {
				if (  $ar['coa_id'] == 110000 && $ar[ 'debit' ] == 1 ){
                    $valid = true;
				} else if(  $ar['coa_id'] != 110000 && $ar[ 'debit' ] == 1 ){
                    $valid = false;
				}
                if ($valid && $ar['debit']== 0) {
                    $sama = false;
                    foreach ($table as $k=> $tab) {
                        if( $tab['coa_id'] == $ar[ 'coa_id' ]){
                            $table[$k]['nilai'] = $tab['nilai'] + $ar[ 'nilai' ];
                            $table[$k]['jumlah'] = $tab['jumlah'] + 1;
                            $sama = true;
                            $id_sama = false;
                            foreach ($tab['jurnalable_id'] as $jurnl) {
                                if ($jurnl == $ar[ 'jurnalable_id' ]) {
                                    $id_sama = true;
                                }
                            }
                            if (!$id_sama) {
                                $table[$k]['jurnalable_id'][] = $ar[ 'jurnalable_id' ];
                            }
                        }
                    }
                    if (!$sama) {
                        $table[] =[
                            'id' => $ar[ 'id' ],
                            'coa_id' => $ar[ 'coa_id' ],
                            'coa'    => $ar[ 'coa' ],
                            'nilai'  => $ar[ 'nilai' ],
                            'jumlah' => 1,
                            'jurnalable_id' => [
                                 $ar[ 'jurnalable_id' ]
                            ]
                        ]; 
                    }
                } else if ($ar[ 'debit'  ]== 1 && $ar[ 'coa_id'  ]!= 110000 ) {
                        break;
                }
            }
        }
        return $table;
    }
	public function bagiHasilGigi(){
		$bagi_gigi = BagiGigi::latest()->paginate(10);
		return view('pengeluarans.bagi_hasil_gigi', compact('bagi_gigi'));
	}
	
	public function gajiDokterGigi(){
		$gaji_gigis = GajiGigi::latest()->paginate(10);
		return view('pengeluarans.bayar_dokter_gigi', compact('gaji_gigis'));
	}
    
	public function gajiDokterGigiBayar(){

		$rules = [
			'staf_id' => 'required',
			'petugas_id' => 'required',
			'nilai' => 'required',
			'bulan' => 'required',
			'tanggal_dibayar' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$bulan =  Yoga::blnPrep( Input::get('bulan') );

		$nilai = Yoga::clean( Input::get('nilai') );
		$gaji = new GajiGigi;
		$gaji->staf_id = Input::get('staf_id');
		$gaji->petugas_id = Input::get('petugas_id');
		$gaji->nilai = $nilai;
	    $gaji->tanggal_mulai = $bulan . '-01';
	    $gaji->tanggal_akhir = date("Y-m-t", strtotime($bulan . '-01'));
		$gaji->tanggal_dibayar = Yoga::datePrep( Input::get('tanggal_dibayar') );
		$gaji->created_at = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
		$gaji->updated_at = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
		$confirm = $gaji->save();

		if ($confirm) {
			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $gaji->id; // id referensi yang baru dibuat
			$jurnal->jurnalable_type = 'App\GajiGigi';
			$jurnal->coa_id          = 610000; // biaya operasional gaji dokter gigi
			$jurnal->debit           = 1;
			$jurnal->nilai           = $nilai;
			$jurnal->created_at = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
			$jurnal->updated_at = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
			$jurnal->save();
			
			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $gaji->id;// id referensi yang baru dibuat
			$jurnal->jurnalable_type = 'App\GajiGigi';
			$jurnal->coa_id          = Input::get('sumber_coa_id'); // Kas di tangan 110004, Kas di kasir 110000, 
			$jurnal->debit           = 0;
			$jurnal->nilai           = $nilai;
			$jurnal->created_at = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
			$jurnal->updated_at = date("Y-m-t 23:59:59", strtotime($bulan . '-01'));
			$jurnal->save();

			$pesan = Yoga::suksesFlash('Gaji Dokter Gigi <strong>' . $gaji->staf->nama . '</strong> sebesar <strong>' . Yoga::buatrp( $gaji->nilai ) . '</strong>, Telah berhasil diInput');
		} else {
			$pesan = Yoga::suksesFlash('Gaji Dokter Gagal diInput');
		}
		return redirect('pengeluarans/gaji_dokter_gigi')->withPesan($pesan);
	}
	public function peralatans(){
		$belanja_peralatans = BelanjaPeralatan::latest()->paginate(30);
		return view('pengeluarans.peralatans', compact('belanja_peralatans'));
	}
	
	public function belanjaPeralatan(){
		$masa_pakai = Yoga::masaPakai();
		return view('pengeluarans.belanja_peralatan', compact('masa_pakai'));
	}

	public function belanjaPeralatanBayar(){

		$rules = [
			'sumber_uang'       => 'required',
			'supplier_id'       => 'required',
			'nomor_faktur'      => 'required',
			'tanggal_pembelian' => 'required',
			'staf_id'           => 'required',
			'temp'              => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		

		$supplier_id       = Input::get('supplier_id');
		$tanggal_pembelian = Input::get('tanggal_pembelian');
		$nomor_faktur      = Input::get('nomor_faktur');
		$staf_id           = Input::get('staf_id');
		$temp              = Input::get('temp');
		$temp              = json_decode($temp, true);

		$data = [];
		$total_nilai = 0;

		$fb                 = new FakturBelanja;
		$fb->tanggal        = Yoga::datePrep(Input::get('tanggal_pembelian'));
		$fb->nomor_faktur   = Input::get('nomor_faktur');
		$fb->belanja_id     = 4;
		$fb->supplier_id    = Input::get('supplier_id');
		$fb->sumber_uang_id = Input::get('sumber_uang');
		$fb->petugas_id     = $staf_id;
		$fb->save();
		$fb->faktur_image   = $this->imageUploadAlat('faktur', 'faktur_image', $fb->id);
		$confirm = $fb->save();

		$timestamp                    = date('Y-m-d H:i:s');
		$acs                          = [];
		foreach ($temp as $t) {
			$data[]                   = [
				 'faktur_belanja_id' => $fb->id,
				 'staf_id'           => $staf_id,
				 'peralatan'         => $t['peralatan'],
				 'harga_satuan'      => $t['nilai'],
				 'jumlah'            => $t['jumlah'],
				 'masa_pakai'        => $t['masa_pakai'],
				 'created_at'        => $timestamp,
				 'updated_at'        => $timestamp
			];

			foreach ($t['ac'] as $ac) {
				$acs[]             = [

					'merek'             => $ac['merek'],
					'keterangan'        => $ac['keterangan_lokasi'],
					'faktur_belanja_id' => $fb->id,
					'created_at'        => $timestamp,
					'updated_at'        => $timestamp

				];
			}
			$total_nilai += $t['nilai'] * $t['jumlah'];
		}

		$confirm = BelanjaPeralatan::insert($data);
		Ac::insert($acs);

		if ($confirm) {

			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $fb->id; // id referensi yang baru dibuat
			$jurnal->jurnalable_type = 'App\FakturBelanja';
			$jurnal->coa_id          = 120001; // Peralatan
			$jurnal->debit           = 1;
			$jurnal->nilai           = $total_nilai;
			$jurnal->save();
			
			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $fb->id;// id referensi yang baru dibuat
			$jurnal->jurnalable_type = 'App\FakturBelanja';
			$jurnal->coa_id          = Input::get('sumber_uang'); // Kas di tangan 110004, Kas di kasir 110000, 
			$jurnal->debit           = 0;
			$jurnal->nilai           = $total_nilai;
			$jurnal->save();

			$pesan = Yoga::suksesFlash('Input Peralatan telah berhasil');
		} else {
			$pesan = Yoga::suksesFlash('Input Peralatan telah gagal');
		}
		return redirect('pengeluarans/peralatans')
			->withPrint($fb->id)
			->withPesan($pesan);
	}
	public function data(){

		$peng =  Pengeluaran::latest()->get();
		return view('pengeluarans.bukan_obat', compact('peng'));

	}
	
	private function imageUpload($pre, $fieldName, $id){
		if(Input::hasFile($fieldName)) {

			$upload_cover = Input::file($fieldName);
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			$upload_cover = Image::make($upload_cover);
			$upload_cover->resize(1000, null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});


			//membuat nama file random + extension
			$filename =	 $pre . $id . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			$destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/belanja/lain';

			// Mengambil file yang di upload
			$upload_cover->save($destination_path . '/' . $filename);
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return $filename;
			
		} else {
			return null;
		}
	}
	

	private function imageUploadAlat($pre, $fieldName, $id){
		if(Input::hasFile($fieldName)) {

			$upload_cover = Input::file($fieldName);
			//mengambil extension
			$extension    = $upload_cover->getClientOriginalExtension();

			$upload_cover = Image::make($upload_cover);
			$upload_cover->resize(1000, null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});
			//membuat nama file random + extension
			$filename =	 $pre . $id . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			$destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/belanja/alat';

			// Mengambil file yang di upload
			$upload_cover->save($destination_path . '/' . $filename);
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return $filename;
			
		} else {
			return null;
		}
	}
	public function peralatan_detail($id){
		$fakturbelanja = FakturBelanja::find($id);
		return view('pengeluarans.peralatan_detail', compact(
			 'fakturbelanja'
		));
	}
	
	public function belanjaBukanObatDetail($id){
		$peng = Pengeluaran::find($id);
		return view('pengeluarans.bukan_obat_detail', compact(
			 'peng'
		));
	}
	public function bagiHasilGigiPost(){
		$rules = [
		  "sumber_coa_id" => "required",
		  "nilai" => "required",
		  "bulan" => "required",
		  "petugas_id" => "required",
		  "tanggal_dibayar" => "required"
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

       $bulan = Yoga::blnPrep( Input::get('bulan') );


	   if ((int)strtotime( date('Y-m-d H:i:s') ) > (int)strtotime( date($bulan . '-t 23:59:59') ) ) {
			$timestamp = date($bulan . '-t 23:59:59');
	   } else {
			$timestamp = date('Y-m-d H:i:s');
	   }
	   $nilai = Yoga::clean( Input::get('nilai') );

		$gaji       = new BagiGigi;
		$gaji->petugas_id = Input::get('petugas_id');
		$gaji->nilai = $nilai;
	    $gaji->tanggal_mulai = $bulan . '-01';
	    $gaji->tanggal_akhir = date("Y-m-t", strtotime($bulan . '-01'));
		$gaji->tanggal_dibayar = Yoga::datePrep( Input::get('tanggal_dibayar') );
		$confirm = $gaji->save();

		if ($confirm) {
			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $gaji->id; // id referensi yang baru dibuat
			$jurnal->jurnalable_type = 'App\BagiGigi';
			$jurnal->coa_id          = 610001; // biaya operasional bagi hasil pelayanan dokter gigi
			$jurnal->debit           = 1;
			$jurnal->nilai           = $nilai;
			$jurnal->created_at = $timestamp;
			$jurnal->updated_at = $timestamp;
			$jurnal->save();
			
			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $gaji->id;// id referensi yang baru dibuat
			$jurnal->jurnalable_type = 'App\BagiGigi';
			$jurnal->coa_id          = Input::get('sumber_coa_id'); // Kas di tangan 110004, Kas di kasir 110000, 
			$jurnal->debit           = 0;
			$jurnal->nilai           = $nilai;
			$jurnal->created_at = $timestamp;
			$jurnal->updated_at = $timestamp;
			$jurnal->save();

			$pesan = Yoga::suksesFlash('Bagi Hasil Pelayanan Dokter Gigi sebesar <strong>' . Yoga::buatrp( $gaji->nilai ) . '</strong>, Telah berhasil diInput');
		} else {
			$pesan = Yoga::suksesFlash('Bagi Hasil Pelayanan Dokter Gagal diInput');
		}
		return redirect('pengeluarans/bagi_hasil_gigi')->withPesan($pesan);
	}
		
	private function convertArray($collection){
		$array = [];
		 foreach ($collection as $value) {
		 	$array[] = $value;
		 }
		return $array;
	}
	public function product(){
		$param = Input::get('q');
		
		$param = trim($param);


		$data = '%';
		$arr = str_split($param, 1);

		foreach ($arr as $value) {
			$data .= $value . '%';
		}

		$pasiens = Pasien::with('asuransi')->where('nama', 'like', $data)->take(10)->get();

		$data = [];

		foreach ($pasiens as $ps) {
			$data['items'][] = [
				 'id' => $ps->id,
				 'text' => $ps->nama,
				 'asuransi' => $ps->asuransi->nama,
				 'tanggal_lahir' => Yoga::updateDatePrep( $ps->tanggal_lahir ),
				 'bpjs' => $ps->bpjs_image
			];
		}

		return json_encode($data);


	}
	public function getBelanjaPeralatanObject(){
		$jurnal_umum_id = Input::get('jurnal_umum_id');
		$JurnalUmum = JurnalUmum::find($jurnal_umum_id);
		
		$jurnalable_type = explode('\\', $JurnalUmum->jurnalable_type)[1];
		$jurnalable_id = $JurnalUmum->jurnalable_id;

		if ( $jurnalable_type == 'Pengeluaran' ) {
			$object = Pengeluaran::find( $jurnalable_id );
			return dd( $object );

			//$fb = new FakturBelanja;
			//$fb->tanggal = $object->tanggal;
			//$fb->belanja_id = 4;
			//$fb->supplier_id = $object->supplier_id;
			//$fb->sumber_uang_id = $object->supplier_id;
			//$fb->petugas_id = $object->staf_id;
			//$fb->save();

			//BelanjaPeralatan::create([
				 //'faktur_belanja_id' => $fb->id,
				 //'staf_id' => $staf_id,
				 //'peralatan' => $t['peralatan'],
				 //'harga_satuan' => $t['nilai'],
				 //'jumlah' => $t['jumlah'],
				 //'masa_pakai' => $t['masa_pakai']
			//]);


			//$path_before = public_path() . DIRECTORY_SEPARATOR . 'img/lain/' . $object->faktur_image;
			//$ext = pathinfo($path_before, PATHINFO_EXTENSION);
			//$filename = 'faktur' . $fb->id . '.' . $ext;
			//$path_after = public_path() . DIRECTORY_SEPARATOR . 'img/alat/' . $filename;

			//$confirm = rename( 
				//$path_before,
				//$path_after
			//);

			//if ($confirm) {
				//$fb->faktur_image = $filename;
			//}

			//$fb->save();
		}
		return false;
	}
	public function parameterKasir(){
		
        $last_chekcout = CheckoutKasir::latest()->first();
        $uang_di_tangan = $last_chekcout->uang_di_tangan;
        $jurnal_umum_id_last_cehckout = $last_chekcout->jurnal_umum_id;
        $tanggal = $last_chekcout->created_at;
        $jurnal_umums = JurnalUmum::whereRaw("id >= $jurnal_umum_id_last_cehckout and jurnalable_type = 'App\\\Modal' and debit = 0 and (coa_id = 301000 or coa_id=110004) ")
									->get();
        $modal_awal = 0;
		$modal_ids = [];
        foreach ($jurnal_umums as $ju) {
		   $modal_awal +=  $ju->nilai;
		   $modal_ids[] = $ju->id;
        }
        $total_uang_masuk = JurnalUmum::where('id', '>', $jurnal_umum_id_last_cehckout)
                                ->where('coa_id', 110000) 
                                ->where('jurnalable_type', '!=', 'App\Modal')
                                ->where('debit', '1')
                                ->sum('nilai');

        $total_uang_keluar = JurnalUmum::where('id', '>', $jurnal_umum_id_last_cehckout)
                                ->where('coa_id', 110000) 
                                ->where('jurnalable_type', '!=', 'App\Modal')
                                ->where('jurnalable_type', '!=', 'App\CheckoutKasir')
                                ->where('debit', '0')
                                ->sum('nilai');

        $uang_di_kasir = $modal_awal + $total_uang_masuk - $total_uang_keluar;

		return [
			'uang_di_kasir' => $uang_di_kasir,
			'total_uang_keluar' => $total_uang_keluar,
			'total_uang_masuk' => $total_uang_masuk,
			'modal_awal' => $modal_awal,
			'uang_di_tangan' => $uang_di_tangan,
			'tanggal' => $tanggal,
			'modal_ids' => $modal_ids
		];
	}
	
}
