<?php


namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use App\Classes\Yoga;
use App\Perbaikantrx;
use App\Formula;
use App\Merek;
use App\Rak;
use App\KunjunganSakit;
use App\BahanHabisPakai;
use App\PengantarPasien;
use App\JenisTarif;
use App\PiutangAsuransi;
use App\Periksa;
use App\Rujukan;
use App\Pasien;
use App\AntrianPeriksa;
use App\Tarif;
use App\Monitor;
use App\Dispensing;
use App\Point;
use App\SmsJangan;
use App\TransaksiPeriksa;
use App\JurnalUmum;
use App\Fakturbeli;
use App\Pembelian;
use App\Receipt;
use DB;

class CustomController extends Controller
{
	public function create_rak($id)
	{
		$formula = Formula::find($id);
		$fornas = Yoga::fornas();
		$alternatif_fornas = array('0' => '- Pilih Merek -') + Merek::lists('merek', 'id')->all();

		return view('raks.create')
			->withFormula($formula)
			->withAlternatif_fornas($alternatif_fornas)
			->withFornas($fornas);
	}

	public function create_merek($id){
		$rak = Rak::find($id);

		return view('mereks.create')
				->withRak($rak);
	}

	public function updtrf(){

		$asuransi_id = Input::get('asuransi_id');
		$jenis_tarif_id = Input::get('jenis_tarif_id');
		$tarif = Tarif::where('jenis_tarif_id', $jenis_tarif_id)->where('asuransi_id', $asuransi_id)->first();

		$tarif->biaya = Input::get('biaya');
		$tarif->tipe_tindakan_id = Input::get('tipe_tindakan_id');
		$tarif->jasa_dokter = Input::get('jasa_dokter');
		$tarif->save();

		$input_bhps = [];
		$delete_bhps = [];

		$bhps = json_decode(Input::get('bhp_items'), true);
		$timestamps = date('Y-m-d H:i:s');
		foreach ($bhps as $bhp) {
			if (!isset($bhp['id'])) {
				$input_bhps[] = [
					'merek_id' => $bhp['merek_id'],
					'jumlah' => $bhp['jumlah'],
					'jenis_tarif_id' => $jenis_tarif_id,
					'created_at' => $timestamps,
					'updated_at' => $timestamps
				];
			}
		}

		foreach (JenisTarif::find($jenis_tarif_id)->bhp as $bp) {
			$hapus = true;
			foreach ($bhps as $bhp) {
				if (isset($bhp['id']) && $bp->id == $bhp['id']) {
					$hapus = false;
					break;
				}
			}
			if ($hapus) {
				$delete_bhps[] = $bp->id;
			}
		}
		BahanHabisPakai::destroy($delete_bhps);
		BahanHabisPakai::insert($input_bhps);

		$jt = JenisTarif::find($jenis_tarif_id);
		$jt->jenis_tarif = Input::get('jenis_tarif');
		$jt->tipe_laporan_admedika_id = Input::get('tipe_laporan_admedika_id');
		$jt->save();

		if($jt->save() && $tarif->save()){
            $kembali = [
                'id' => $tarif->id,
                'jenis_tarif_id' => $jt->id
            ];
			return $jenis_tarif_id;
		} else {
			return '0';
		}

	}

	public function kembali($id){

		 $periksa = Periksa::find($id);

		 $periksa->lewat_poli = '0';
		 $periksa->lewat_kasir = '0';
		 $periksa->save();

		 $antrian_periksa_id = Yoga::customId('App\AntrianPeriksa');

		$antrian = new AntrianPeriksa;
		$antrian->id = $antrian_periksa_id;
		$antrian->antrian = $periksa->antrian;
		$antrian->asuransi_id = $periksa->asuransi_id;
		$antrian->pasien_id = $periksa->pasien_id;
		$antrian->poli = $periksa->poli;
		$antrian->staf_id = $periksa->staf_id;
		$antrian->jam = $periksa->jam;
		$antrian->tanggal = $periksa->tanggal;
		$antrian->save();


		PengantarPasien::where('antarable_type', 'App\Periksa')
			->where('antarable_id', $id)
			->update([
			 'antarable_type' => 'App\AntrianPeriksa',
			 'antarable_id' => $antrian_periksa_id
		 ]);

		$pasien = Pasien::find($periksa->pasien_id);

		return redirect('antriankasirs')
		->withPesan(Yoga::suksesFlash('<strong>' . $pasien->id . ' - ' . $pasien->nama . ' </strong>Berhasil dikembalikan ke Ruang Periksa <strong>Poli ' . ucwords(strtolower($periksa->poli)) . '</strong>'));

	}
	public function kembali2($id){

		 $periksa = Periksa::find($id);

		 $periksa->lewat_poli = '0';
		 $periksa->lewat_kasir = '0';
		 $periksa->save();

		 if ($periksa->usg) {
		 	$usg = '1';
		 } else {
		 	$usg = '0';
		 }
		$antrian_id = Yoga::customId('App\AntrianPeriksa');

		$antrian = new AntrianPeriksa;
		$antrian->id = $antrian_id;
		$antrian->poli = $periksa->poli;
		$antrian->staf_id = $periksa->staf_id;
		$antrian->antrian = $periksa->antrian;
		$antrian->asuransi_id = $periksa->asuransi_id;
		$antrian->pasien_id = $periksa->pasien_id;
		$antrian->jam = $periksa->jam;
		$antrian->tanggal = $periksa->tanggal;
		$antrian->save();


		PengantarPasien::where('antarable_type', 'App\Periksa')
			->where('antarable_id', $id)
			->update([
			 'antarable_type' => 'App\AntrianPeriksa',
			 'antarable_id' => $antrian_id
		 ]);

		$pasien = Pasien::find($periksa->pasien_id);
        $poli = $periksa->poli;
		if ($poli == 'sks' || $poli == 'luka') {
			$poli = 'umum';
		} else if ($poli == 'KB 1 Bulan' || $poli == 'KB 3 Bulan' ){
			$poli='kandungan';
		}

		return redirect('ruangperiksa/' . $poli)
		->withPesan(Yoga::suksesFlash('<strong>' . $pasien->id . ' - ' . $pasien->nama . ' </strong>Berhasil dikembalikan ke Ruang Periksa <strong>Poli ' . ucwords(strtolower($periksa->poli)) . '</strong>'));

	}

	public function kembali3($id){

		 $periksa = Periksa::find($id);
		 $periksa->lewat_poli = '1';
		 $periksa->lewat_kasir = '0';
		 $periksa->lewat_kasir2 = '0';
		 $periksa->save();

		$pasien = Pasien::find($periksa->pasien_id);

		return redirect('antriankasirs')
		->withPesan(Yoga::suksesFlash('<strong>' . $pasien->id . ' - ' . $pasien->nama . ' </strong>Berhasil dikembalikan ke <strong>Apotek</strong>'));

	}

	public function survey($id){
        $periksa = Periksa::with('terapii.merek.rak')->where('id', $id)->first();
		$sudah = false;
		$periksaBulanIni = Periksa::where('pasien_id', $periksa->pasien_id)->where('tanggal', 'like', date('Y-m') . '%')->where('asuransi_id', '32')->where('id', '<', $id)->get();
		foreach ($periksaBulanIni as $prx) {
			if(preg_match('/Gula Darah/',$prx->pemeriksaan_penunjang)){
				$sudah = true;
				break;				
			}
		}
   		$tindakans = [null => '- Pilih -'] + Tarif::where('asuransi_id', $periksa->asuransi_id)->with('jenisTarif')->get()->lists('jenis_tarif_list', 'tarif_jual')->all();
   		$reseps = Yoga::masukLagi($periksa->terapii);
   		$biayatotal = Yoga::biayaObatTotal($periksa->transaksi);

		$monitor = Monitor::find(1);
        //$monitor->periksa_id = $periksa->id;
        //$monitor->save();

        $dibayar = null;
        if ( $periksa->asuransi->tipe_asuransi== '4') {
        	$jasa_dokter = Tarif::where('asuransi_id', $periksa->asuransi_id)->where('jenis_tarif_id', '1')->first()->biaya;
        	$obat = Tarif::where('asuransi_id', $periksa->asuransi_id)->where('jenis_tarif_id', '9')->first()->biaya;
        	$dibayar = $jasa_dokter + $obat;
        }
		return view('surveys.index')
		->withReseps($reseps)
		->withPeriksa($periksa)
		->withSudah($sudah)
		->withBiayatotal($biayatotal)
		->withDibayar($dibayar)
		->withMonitor($monitor)
		->withTindakans($tindakans);
	}
	public function survey_post(){
		$periksa_id = Input::get('periksa_id');	

        $periksa = Periksa::find( Input::get('periksa_id') );
        if ($periksa->lewat_kasir2 == '1') {
            return redirect('antriankasirs')->withPesan( Yoga::gagalFlash('Pasien atas nama <strong>' . $periksa->pasien->nama . '</strong> sudah pernah diinput sebelumnya <strong>TIDAK PERLU DIULANGI LAGI</strong>') );
        }
		$tarif         = Input::get('tarif');
		$sebelum       = Input::get('sebelum');
		$sebelum_array = json_decode($sebelum, true);
		$tarif_array   = json_decode($tarif, true);
		//HILANGKAN elemen BHP dari tarif
		foreach ($sebelum_array as $key => $value) {
			if ($value['jenis_tarif'] == 'BHP') {
				array_splice($sebelum_array, $key, 1);
			}
		}
		//HILANGKAN elemen BHP dari sebelum
		foreach ($tarif_array as $key => $value) {
			if ($value['jenis_tarif'] == 'BHP') {
				array_splice($tarif_array, $key, 1);
			}
		}
		$fix = false;
		//JIKA ADA KOREKSI DALAM transaksi, maka masukkan ke dalam tabel perbaikantrxs
		if (json_encode($sebelum_array) == json_encode($tarif_array)) {
		} else {
			$fix                   = true;
			$perbaikan             = new Perbaikantrx;
			$perbaikan->periksa_id =Input::get('periksa_id');
			$perbaikan->sebelum    =Input::get('sebelum');
			$perbaikan->save();
		}

		$dibayar_pasien   = Yoga::clean(Input::get('dibayar_pasien'));
		$dibayar_asuransi = Yoga::clean(Input::get('dibayar_asuransi'));
		$pembayaran = Yoga::clean(Input::get('pembayaran'));
		$kembalian = Yoga::clean(Input::get('kembalian'));

		$periksa->tunai           = $dibayar_pasien;
		$periksa->piutang         = $dibayar_asuransi;
		$periksa->pembayaran      = $pembayaran;
		$periksa->kembalian       = $kembalian;
		$periksa->transaksi       = $tarif;
		$periksa->nomor_asuransi  = $periksa->pasien->nomor_asuransi;

		if ($periksa->asuransi_id == 32 && !empty($periksa->keterangan)) {
			$periksa->keterangan = null;
		}
		//Jika pembayaran yang digunakan saat ini adalah bpjs dan pasien berada dalam list jangan sms, maka hapus list tersebut, karena
		//ternyata pasien tersebut sekarang aktif
		if ($periksa->asuransi_id == 32) {
			 $smsJangan = SmsJangan::where('pasien_id', $periksa->pasien_id)->get();
			if ($smsJangan->count() > 0) {
				$smsJangan->delete();
			}
		}

		$periksa->terapi          = $this->terapisBaru($periksa->terapii);
		$periksa->jam_terima_obat = date('H:i:s');
		if ($periksa->rujukan) {
			$ps = new Pasien;
			$rujukan = Rujukan::find($periksa->rujukan->id);
			if (Input::hasFile('image')) {
				$rujukan->image = $ps->imageUpload('rjk', 'image', Input::get('periksa_id') );
			}
			$rujukan->save();
		}
		$periksa->lewat_kasir2    = '1';
		$confirm             = $periksa->save();
		$resep = $periksa->terapii;
		$merek = Merek::all();
		foreach ($resep as $key => $value) {
			$rak_id = $merek->find($resep[$key]['merek_id'])->rak_id;
			$rak       = Rak::find($rak_id);
			$rak->stok = $rak->stok - $resep[$key]['jumlah'];
			$confirm   = $rak->save();
			if($confirm){
				$disp                   = new Dispensing;
				$disp->id               = Yoga::customId('App\Dispensing');
				$disp->rak_id           = $rak_id;
				$disp->keluar           = $resep[$key]['jumlah'];
				$disp->dispensable_id   = $value->id;
				$disp->dispensable_type = 'App\Terapi';
				$disp->tanggal          = Periksa::find($periksa_id)->tanggal;
				$disp->save();
			}
		}
		$mess = '';

		if ($confirm) {
			$terapis = $periksa->terapii;
			$biayaProduksiObat = 0;
			foreach ($terapis as $terapi) {
				$biayaProduksiObat += $terapi->harga_beli_satuan * $terapi->jumlah;
			}

            // Input jurnal umum kas di tangan bila tunai > 0
			if ($periksa->tunai>0) {
				$jurnal                  = new JurnalUmum;
				$jurnal->jurnalable_id   = $periksa->id;
				$jurnal->jurnalable_type = 'App\Periksa';
				$jurnal->coa_id          = 110000; // Kas di tangan
				$jurnal->debit           = 1;
				$jurnal->nilai           = $periksa->tunai;
				$jurnal->save();
			}

            // Input jurnal umum kas di tangan bila piutang > 0
			if ($periksa->piutang>0) {
				$jurnal                  = new JurnalUmum;
				$jurnal->jurnalable_id   = $periksa->id;
				$jurnal->jurnalable_type = 'App\Periksa';
				$jurnal->debit           = 1;
				$jurnal->coa_id          = $periksa->asuransi->coa_id; // Piutang berdasarkan masing2 asuransi
				$jurnal->nilai           = $periksa->piutang;
				$jurnal->save();

                $piutang = new PiutangAsuransi;
                $piutang->periksa_id = $periksa_id;
                $piutang->tunai = $periksa->tunai;
                $piutang->piutang = $periksa->piutang;
                $piutang->save();
			}

			$transaksis = $periksa->transaksi;
			$transaksis = json_decode($transaksis, true);
			$adaJasaDokter = false;
			$feeDokter = 0;

            $hutang_asisten_tindakan = 0;
			foreach ($transaksis as $k => $transaksi) {
                $adaBiaya = false;

				$trx                 = new TransaksiPeriksa;
				$trx->periksa_id     = $periksa_id;
				$trx->jenis_tarif_id = $transaksi['jenis_tarif_id'];
				$trx->biaya          = $transaksi['biaya'];
				$oke                 = $trx->save();

                if ( !($transaksi['jenis_tarif_id'] == '116' && $transaksi['biaya'] == 0) ) {
                    $feeDokter += Tarif::where('asuransi_id', $periksa->asuransi_id)->where('jenis_tarif_id', $transaksi['jenis_tarif_id'])->first()->jasa_dokter;
                }
				if ($oke) {
					if ($transaksi['biaya'] > 0) {
						$jurnal                  = new JurnalUmum;
						$jurnal->jurnalable_id   = $periksa->id;
						$jurnal->jurnalable_type = 'App\Periksa';
						$jurnal->coa_id          = $trx->jenisTarif->coa_id;
						$jurnal->debit           = 0;
						$jurnal->nilai           = $trx->biaya;
						$jurnal->save();

						$adaBiaya = true;
					}

					if (JenisTarif::find($transaksi['jenis_tarif_id'])->dengan_asisten == '1') {
                        $hutang_asisten_tindakan += $this->biayaJasa($transaksi['jenis_tarif_id'], $trx);
					}

				}
				foreach ($trx->jenisTarif->bahanHabisPakai as $key => $bhp) {

					$rak       = Rak::find($bhp->merek->rak_id);
					$rak->stok = $rak->stok - $bhp->jumlah;
					$rak->save();

					$d                   = new Dispensing;
					$d->id               = Yoga::customId('App\Dispensing');
					$d->rak_id           = $bhp->merek->rak_id;
					$d->keluar           = $bhp->jumlah;
					$d->dispensable_id   = $trx->id;
					$d->dispensable_type = 'App\TransaksiPeriksa';
					$d->tanggal          = Periksa::find($periksa_id)->tanggal;
					$d->save();
				}
                
                //Jika ada biaya untuk tindakan Nebulizer baik anak maupun dewasa, masukkan beban jasa dokter 
                if ($adaBiaya && ($transaksi['jenis_tarif_id'] == '102' || $transaksi['jenis_tarif_id'] == '103')) {
                    $feeDokter += 3000;
                }
			}

            //Masukkan pembayaran ke dalam Transaksi
            if ($hutang_asisten_tindakan > 0) {
                $jurnal                  = new JurnalUmum;
                $jurnal->jurnalable_id   = $periksa->id;
                $jurnal->jurnalable_type = 'App\Periksa';
                $jurnal->coa_id          = 50205; // Biaya Produksi : Bonus per pasien Jasa TIndakan untuk Asisten
                $jurnal->debit           = 1;
                $jurnal->nilai           = $hutang_asisten_tindakan;
                $jurnal->save();

                $jurnal                  = new JurnalUmum;
                $jurnal->jurnalable_id   = $periksa->id;
                $jurnal->jurnalable_type = 'App\Periksa';
                $jurnal->coa_id          = 200002; // Hutang Kepada Asisten Dokter
                $jurnal->debit           = 0;
                $jurnal->nilai           = $hutang_asisten_tindakan;
                $jurnal->save();
            }
			// Input hutang kepada dokter
			if ($feeDokter > 0) {
					$jurnal                  = new JurnalUmum;
					$jurnal->jurnalable_id   = $periksa->id;
					$jurnal->jurnalable_type = 'App\Periksa';
					$jurnal->coa_id          = 50201; //Beban Jasa Dokter
					$jurnal->debit           = 1;
					$jurnal->nilai           = $feeDokter;
					$jurnal->save();

					$jurnal                  = new JurnalUmum;
					$jurnal->jurnalable_id   = $periksa->id;
					$jurnal->jurnalable_type = 'App\Periksa';
					$jurnal->coa_id          = 200001; // Hutang Kepada dokter
					$jurnal->debit           = 0;
					$jurnal->nilai           = $feeDokter;
					$jurnal->save();
			}
			// Input Transaksi ini untuk pengurangan persediaan obat tiap transaksi pasien
			if ($biayaProduksiObat > 0) {
				
				$jurnal                  = new JurnalUmum;
				$jurnal->jurnalable_id   = $periksa->id;
				$jurnal->jurnalable_type = 'App\Periksa';
				$jurnal->coa_id          = 50204; // Biaya Produksi : Obat
				$jurnal->debit           = 1;
				$jurnal->nilai           = $biayaProduksiObat;
				$jurnal->save();

				$jurnal                  = new JurnalUmum;
				$jurnal->jurnalable_id   = $periksa->id;
				$jurnal->jurnalable_type = 'App\Periksa';
				$jurnal->coa_id          = 112000; // Persediaan Obat
				$jurnal->debit           = 0;
				$jurnal->nilai           = $biayaProduksiObat;
				$jurnal->save();
			}
			//INPUT points untuk tim bidan
			//jika tidak ada tekanan_dara, berat_badan, suhu, dan tingggi badan yang diisi, tidak ada point\
			if ($periksa->periksa_awal != '[]') {
				$arr = $periksa->periksa_awal;
				$arr = json_decode($arr, true);

				$tekanan_darah = $arr['tekanan_darah'];
				$berat_badan   = $arr['berat_badan'];
				$suhu          = $arr['suhu'];
				$tinggi_badan  = $arr['tinggi_badan'];
				$periksa_id    = $periksa->id;


				$pn = new Point;
				$pn->periksa_id 		= Yoga::returnNull($periksa_id);
				$pn->tekanan_darah 		= Yoga::returnNull($tekanan_darah);
				$pn->berat_badan 		= Yoga::returnNull($berat_badan);
				$pn->suhu 				= Yoga::returnNull($suhu);
				$pn->tinggi_badan 		= Yoga::returnNull($tinggi_badan);
				$adaPoin = $pn->save();

				if ($adaPoin) {
					
					$jurnal                  = new JurnalUmum;
					$jurnal->jurnalable_id   = $periksa->id;
					$jurnal->jurnalable_type = 'App\Periksa';
					$jurnal->coa_id          = 50202; // Biaya Produksi : Bonus per pasien
					$jurnal->debit           = 1;
					$jurnal->nilai           = 1530;
					$jurnal->save();

					$jurnal                  = new JurnalUmum;
					$jurnal->jurnalable_id   = $periksa->id;
					$jurnal->jurnalable_type = 'App\Periksa';
					$jurnal->coa_id          = 200002; // Hutang Kepada Asisten Dokter
					$jurnal->debit           = 0;
					$jurnal->nilai           = 1530;
					$jurnal->save();
				}
			}
        }
        if ( Input::get('dibayar_pasien') > 0 ) {
            $data = [
                'pembayaran' => Input::get('pembayaran'),
                'kembalian' => Input::get('kembalian')
            ];
            $receipt = new Receipt;
            $receipt->periksa_id = $periksa_id;
            $receipt->receipt = json_encode(data);
            $receipt->save();
        }

		if ($fix) {
			$mess =  '<strong> dan Perbaikan Sudah Didokumentasi </strong>';
		}

		if ( $periksa->asuransi_id != '32' && !empty(trim(  $periksa->pasien->nomor_asuransi_bpjs  )) ) {

				$countPeriksaPakaiBpjs = Periksa::where('pasien_id', $periksa->pasien_id)
					->where('asuransi_id', '32')
					->where('tanggal', 'like', date('Y-m') . '%')
					->count();

				$countAntarPakaiBpjs = PengantarPasien::where('pengantar_id', $periksa->pasien_id)
					->where('created_at', 'like', date('Y-m') . '%')
					->where('pcare_submit',1)
					->count();

				$query = "SELECT count(ks.id) as jumlah FROM kunjungan_sakits as ks join periksas as px on ks.periksa_id = px.id join pasiens as ps on ps.id = px.pasien_id ";
				$query .= "WHERE ks.created_at like '" . date('Y-m') . "%' ";
				$query .= "AND ks.pcare_submit = 1 ";
				$query .= "AND px.pasien_id = '" . $periksa->pasien_id . "';";

				$countKunjunganSakit = DB::select($query)[0]->jumlah;
				$hitung = $countPeriksaPakaiBpjs + $countAntarPakaiBpjs + $countKunjunganSakit;
				if ($hitung < 1) {
					$ks       = new KunjunganSakit;
					$ks->periksa_id   = $periksa_id;
					$ks->save();
				}
		}

		if($confirm){
            return redirect('antriankasirs')
                ->withPesan(Yoga::suksesFlash('Transaksi pasien <strong>' . $periksa->pasien_id . '-' . $periksa->pasien->nama . '</strong> telah selesai' . $mess))
                ->withPrint($periksa->id);
		} else {
			return redirect('antriankasirs')->withPesan(Yoga::suksesFlash('Transaksi pasien <strong>' . $periksa->pasien_id . '-' . $periksa->pasien->nama . '</strong> gagal dilakukan' . $mess));
		}
	}

	public function monitor($id){

		return view('monitor');
	}

	public function del_fak_beli(){
		$id = Input::get('id');

		$confirm = Fakturbeli::destroy($id);

		if ($confirm) {
			return '1';
		} else {
			return '0';
		}
	}

	public function send_id(){

		$periksa_id = Input::get('periksa_id');

		$monitor = Monitor::find('1');
		$monitor->periksa_id = $periksa_id;
		$confirm = $monitor->save();

		if($confirm){
			return '1';
		} else {
			return '0';
		}

	}
	public function confirmed(){

		$periksa_id = Input::get('periksa_id');

		$satisfaction_index = Periksa::find($periksa_id)->satisfaction_index;

		if($satisfaction_index != '0'){
			return '1';
		} else {
			return '0';
		}

	}

	public function mon_avail(){
		$periksa_id = Monitor::find(1)->periksa_id;
		if ($periksa_id == '0') {
			$nama = '';
		}else{
			$nama = Monitor::find(1)->periksa->pasien->nama;
		}

		$data = [
			'periksa_id' => $periksa_id,
			'nama' => $nama
		];

		return json_encode($data);
	}

	public function buyhistory($id){

		$query = "SELECT sp.nama as nama, sp.alamat as alamat, sp.no_telp as telepon, sp.hp_pic as hp, sp.pic as pic, fb.supplier_id as supplier_id, pb.harga_beli, max(fb.tanggal) as tanggal from pembelians as pb join faktur_belanjas as fb on fb.id = pb.faktur_belanja_id join suppliers as sp on sp.id = fb.supplier_id where merek_id='{$id}' group by supplier_id order by harga_beli asc;";
		$supplierprices = DB::select($query);

		$pembelians = Pembelian::where('merek_id', $id)->get();
		return view('mereks.buyhistory', compact('pembelians','supplierprices'));

	}


	public function terapi($id)
	{
		$query = "SELECT p.id as id, terapi, s.nama as staf, count(p.id) as jumlah from periksas as p join stafs as s on s.id= p.staf_id where staf_id='{$id}' and terapi not like '[]' and p.created_at > 0 group by terapi order by jumlah desc";
		$periksas = DB::select($query);
		return view('stafs.terapi', compact('periksas'));
		// return $faktur_belanja_id;
	}

	private function terapisBaru($terapis){
		$terapis_baru = [];
		$terapis = json_decode($terapis, true);
		foreach ($terapis as $k => $v) {
			$merek_id   = $v['merek_id'];
			$formula_id = Merek::find($merek_id)->rak->formula_id;
			$signa = $v['signa'];
			$jumlah = $v['jumlah'];

			$terapis_baru[] = [
				'formula_id' => $formula_id,
				'signa' => $signa,
				'jumlah' => $jumlah
			];
		}
		return json_encode($terapis_baru);
	}

	private function biayaJasa($jenis_tarif_id, $trx){
		if ($jenis_tarif_id == '104') {
			return 30000;
		} elseif($jenis_tarif_id == '105' || $jenis_tarif_id == '106'){
			return 35000;
		} elseif ($jenis_tarif_id == '102') {
			return 5000;
		} else {
			return $trx->biaya * 0.1;
		}
	}
    public function test(){
		return dd( (int)strtotime( date('Y-m-d H:i:s')) > (int)strtotime( date('2016-08-t 23:59:59') ) );
		return dd( (int)strtotime( date('2016-08-t 23:59:59') )> (int)strtotime( date('Y-m-d H:i:s')) );
		return (int)strtotime( date('Y-m-d H:i:s'));
		return dd( strtotime( date('Y-m-d H:i:s') ) > strtotime( date('2016-08-t H:i:s') ) );
		return dd( strtotime( date('Y-m-d H:i:s') ) < strtotime( date('2016-08-t H:i:s') ) );
		return dd( strtotime(  date('2016-08-t H:i:s') ) );
    }
    public function getmereks(){
        $qs = str_split( Input::get('q') );
        $temp = '';
        foreach ($qs as $q) {
            $temp .= $q . '%';
        }
        
        $query = "select min(mr.id) as merek_id, min(mr.merek) as merek, min(rk.fornas) as fornas, min(atu.aturan_minum) as aturan_minum, min(rk.stok) as stok from mereks as mr join raks as rk on rk.id = mr.rak_id join formulas as fr on fr.id = rk.formula_id join komposisis as kp on kp.formula_id = fr.id join generiks as gk on gk.id=kp.generik_id join aturan_minums as atu on atu.id = fr.aturan_minum_id where merek like '%$temp' or gk.generik like '%$temp' or atu.aturan_minum like '%$temp' group by mr.id limit 20;";
        $mereks = DB::select($query);
        $data = [];
        foreach ($mereks as $mrk) {
            $komposisis = Merek::find( $mrk->merek_id )->rak->formula->komposisi;
            $fornas_id = $mrk->fornas;
            if ($fornas_id == 1) {
                $fornas = 'fornas';
            } else {
                $fornas = 'non fornas';
            }
            $komposisi = '<ul>';
            foreach ($komposisis as $komp) {
                $komposisi .= '<li>' . $komp->generik->generik . ' ' . $komp->bobot . '</li>';
            }
            $komposisi .= '</ul>';
            $data[]= [
                 'id' => $mrk->merek_id,
                 'merek' => $mrk->merek,
                 'komposisi' => $komposisi,
                 'stok' => $mrk->stok,
                 'aturan_minum' => $mrk->aturan_minum,
                 'fornas' => $fornas
            ];
        }
         return json_encode($data);
    }
    public function test_post(){
         return 'this post';
    }
	public function survey_available(){
		$periksa_id = Monitor::find(1)->periksa_id;
		if ($periksa_id == '0') {
			return '0';
		}else{
			return '1';
		}

	}
	
}
