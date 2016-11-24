<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Periksa;
use App\Classes\Yoga;
use App\Merek;
use App\Pasien;
use App\RegisterHamil;
use App\AntrianPeriksa;
use App\Asuransi;
use App\Terapi;
use App\Staf;
use App\Usg;
use App\RegisterAnc;
use App\GambarPeriksa;
use App\PengantarPasien;
use App\Tarif;

class PeriksasController extends Controller
{

	/**
	 * Display a listing of periksas
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$periksas = Periksa::all();

		return view('periksas.index', compact('periksas'));
	}

	/**
	 * Show the form for creating a new periksa
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('periksas.create');
	}

	/**
	 * Store a newly created periksa in storage.
	 * 	
	 * @return Response
	 */
	public function store()
	{

		$rules = [
		  "kecelakaan_kerja" => "required",
		  "asuransi_id" => "required",
		  "hamil" => "required",
		  "staf_id" => "required",
		  "kali_obat" => "required",
		  "pasien_id" => "required",
		  "jam" => "required",
		  "jam_periksa" => "required",
		  "tanggal" => "required",
		  "poli" => "required",
		  "adatindakan" => "required",
		  "asisten_id" => "required",
		  "antrian_id" => "required",
		  "anamnesa" => "required",
		  "diagnosa_id" => "required"
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		if( AntrianPeriksa::find( Input::get('antrian_id') ) == null ){
			$pesan = Yoga::gagalFlash('Pasien sudah tidak ada di antrianperiksa, mungkin sudah dimasukkan atau buatlah antrian yang baru');
			return redirect('ruangperiksa/' , Input::get('poli'))->withPesan($pesan);
		}
		// return var_dump(json_decode(Input::get('terapi'), true));
		//Pada tahap ini ada beberapa yang perlu ditambahkan
		//BHP (Bahan Habis Pakai) ditambahkan dalam json transaksis bila tindakan tidak kosong
		//Biaya Obat ditambahkan ke dalam komponen transaksis bila terapis tidak kosonsg
		//Jasa dokter ditambahkan ke transaksis
		//Resep disesuaikan menurut formula dengan harga obat sesuai dengan jenis asuransi nya.
		//
		$periksa_id = Yoga::customId('App\Periksa');
		$periksa = new Periksa;


		//Bila asuransi adalah BPJS dan staf belum notified, maka buat notified = 1, supaya tidak muncul peringatan berulang2
		//
		//

		if ( Input::get('asuransi_id') == '32' && Input::get('notified') == '0' ) {
			$st       = Staf::find( Input::get('staf_id') );
			$st->notified   = '1';
			$st->save();
		}

		//Buat collection tabel asuransi
		$asuransi = Asuransi::find(Input::get('asuransi_id'));
		

		//UBAH RESEP MENURUT JENIS ASURANSI
		//sebelum terapi dimasukkan ke dalam periksa, obat harus disesuaikan dahulu, menurut asuransi nya.
		// untuk asuransi BPJS, obat akan dikonversi ke dalam merek yang paling murah yang memiliki formula yang sama
		// untuk asuransi admedika, obat akan dikonversi ke dalam merek paling mahal dalam formula yang sama
		 // return var_dump(json_decode(Input::get('terapi'), true));
		
		$terapis = $this->sesuaikanResep(Input::get('terapi'), $asuransi);



		//sesuaikan Transaksi
		$transaksis = $this->sesuaikanTransaksi(Input::get('transaksi'), $asuransi, $terapis);

		//INPUT TRANSAKSI JAM MALAM
		//JIKA PASIEN DATANG > JAM 10 MALAM, untuk pasien umum dan admedika, maka ditambah 10 ribu untuk jam malam
		if ((Input::get('jam') > '22:00:00' || Input::get('jam') < '06:00:00') && ($asuransi->id == 0 || $asuransi->tipe_asuransi == '3')) {
			//tambahkan komponen jam malam sebesar 10 ribu
			$plus = [
				'jenis_tarif_id' => '120',
				'jenis_tarif' => 'Jam Malam',
				'biaya' => 10000
			];
			array_push($transaksis, $plus);
		}

		// INPUT DATA PERIKSA FINAL!!!!!
		$periksa->id 					= $periksa_id;
		$periksa->anamnesa 				= Input::get('anamnesa');
		$periksa->asuransi_id 			= $asuransi->id;
		$periksa->diagnosa_id 			= Input::get('diagnosa_id');
		$periksa->pasien_id 			= Input::get('pasien_id');
		$periksa->berat_badan  			= Input::get('berat_badan');
		$periksa->poli  				= Input::get('poli');
		$periksa->staf_id 				= Input::get('staf_id');
		$periksa->asisten_id 			= Input::get('asisten_id');
		$periksa->periksa_awal 			= Input::get('periksa_awal');
		$periksa->jam 					= Input::get('jam');
		$periksa->jam_resep 			= date('H:i:s');
		$periksa->keterangan_diagnosa 	= Input::get('keterangan_diagnosa');
		$periksa->lewat_poli 			= '1';
		$periksa->lewat_kasir 			= '0';
		$periksa->lewat_kasir2 			= '0';
		$periksa->antrian_periksa_id	= Input::get('antrian_id');
		$periksa->resepluar 			= Input::get('resepluar');
		$periksa->pemeriksaan_fisik 	= Input::get('pemeriksaan_fisik');
		$periksa->pemeriksaan_penunjang = Input::get('pemeriksaan_penunjang');
		$periksa->tanggal 				= Input::get('tanggal');
		$periksa->terapi 				= $this->terapisBaru($terapis);
		$periksa->antrian 				= Input::get('antrian');
		$periksa->jam_periksa 			= Input::get('jam_periksa');
		$periksa->jam_selesai_periksa 	= date('H:i:s');
		$periksa->keterangan 			= Input::get('keterangan_periksa');
		$periksa->transaksi 			= json_encode($transaksis);
		$confirm = $periksa->save();

		//MASUKKAN periksa_id ke PENGANTAR
		//
		//



		//JIKA ADA FOTO ESTETIKA MASUKKAN GAMBAR ESTETIKA
		//
		//
		

		if ( Input::hasFile('foto_estetika') ) {
			if (count( Input::file('foto_estetika') ) > 0 ) {
				$timestamp = date('Y-m-d H:i:s');
				$files = Input::file('foto_estetika');
				foreach ($files as $k=>$file) {

					$filename = $periksa->imageUpload($file, $periksa_id, $k); 
					$data[] = [
						 'nama'		  => $filename,
						 'keterangan' => Input::get('keterangan_gambar')[$k],
						 'periksa_id' => $periksa_id,
						 'created_at' => $timestamp,
						 'updated_at' => $timestamp
					];

				}
				GambarPeriksa::insert($data);
			}
		}

		//INPUT DATA UNTUK TERAPI
		//
		// return $terapis;
		foreach (json_decode($terapis, true) as $k => $t) {
			$terapi                    = new Terapi;
			$terapi->merek_id          = $t['merek_id'];
			$terapi->signa             = $t['signa'];
			$terapi->aturan_minum      = $t['aturan_minum'];
			$terapi->jumlah            = $t['jumlah'];
			$terapi->periksa_id        = $t['jumlah'];
			$terapi->periksa_id        = $periksa_id;
			$terapi->harga_beli_satuan = Merek::find($t['merek_id'])->rak->harga_beli;
			$terapi->harga_jual_satuan = Yoga::hargaJualSatuan($asuransi, $t['merek_id']);
			$terapi->save();
		}

	if(Input::get('poli') == 'usg'){
		$usg_id = Yoga::customId('App\Usg');
		
		$usg                 = new Usg;
		$usg->id             = $usg_id;
		$usg->periksa_id     = $periksa_id;
		$usg->perujuk_id     = Input::get('perujuk_id');
		$usg->hpht           = Yoga::datePrep(Input::get('hpht'));
		$usg->umur_kehamilan = Input::get('umur_kehamilan');
		$usg->gpa            = Input::get('gpa');
		$usg->bpd            = Input::get('BPD_w') . 'w ' . Input::get('BPD_d') . 'd';
		$usg->hc             = Input::get('HC_w') . 'w ' . Input::get('HC_d') . 'd';
		$usg->ltp            = Input::get('LTP');
		$usg->djj            = Input::get('FHR');
		$usg->ac             = Input::get('AC_w') . 'w ' . Input::get('AC_d') . 'd';
		$usg->efw            = Input::get('EFW') . ' gr';
		$usg->fl             = Input::get('FL_w') . 'w ' . Input::get('FL_d') . 'd';
		$usg->bpd_mm             = Input::get('BPD_mm');
		$usg->ac_mm             = Input::get('AC_mm');
		$usg->FL_mm             = Input::get('FL_mm');
		$usg->HC_mm             = Input::get('HC_mm');
		$usg->sex            = Input::get('Sex');
		$usg->ica            = Input::get('total_afi');
		$usg->plasenta       = Input::get('Plasenta');
		$usg->presentasi     = Input::get('presentasi');
		$usg->kesimpulan     = Input::get('kesimpulan');
		$usg->saran          = Input::get('saran');
		$usg->save();

		$pasien = Pasien::find(Input::get('pasien_id'));
		$pasien->riwayat_kehamilan_sebelumnya = Input::get('riwayat_kehamilan_sebelumnya');
		$pasien->save();

	}
	if (Input::get('poli') == 'anc' || Input::get('poli') == 'usg') {
		if (RegisterHamil::where('g', Input::get('G'))->where('pasien_id', Input::get('pasien_id'))->count() < 1) {
			$hamil                                = new RegisterHamil;
			$hamil->pasien_id                     = Input::get('pasien_id');
			$hamil->nama_suami                    = Input::get('nama_suami');
			$hamil->tb                            = Input::get('tb');
			$hamil->buku_id                       = Input::get('buku');
			$hamil->golongan_darah                = Input::get('golongan_darah');
			$hamil->tinggi_badan                  = Input::get('tb');
			$hamil->bb_sebelum_hamil              = Input::get('bb_sebelum_hamil');
			$hamil->g                             = Input::get('G');
			$hamil->p                             = Input::get('P');
			$hamil->a                             = Input::get('A');
			$hamil->riwayat_persalinan_sebelumnya = Input::get('riwayat_kehamilan');
			$hamil->hpht                          = Yoga::datePrep(Input::get('hpht'));
			$hamil->status_imunisasi_tt_id        = Input::get('status_imunisasi_tt_id');
			$hamil->rencana_penolong              = Input::get('rencana_penolong');
			$hamil->jumlah_janin                  = Input::get('jumlah_janin');
			$hamil->rencana_tempat                = Input::get('rencana_tempat');
			$hamil->rencana_pendamping            = Input::get('rencana_pendamping');
			$hamil->rencana_transportasi          = Input::get('rencana_transportasi');
			$hamil->rencana_pendonor              = Input::get('rencana_pendonor');
			$hamil->tanggal_lahir_anak_terakhir   = Yoga::datePrep(Input::get('tanggal_lahir_anak_terakhir'));
			$hamil->save();
		} else {
			$hamil                                = RegisterHamil::where('g', Input::get('G'))->where('pasien_id', Input::get('pasien_id'))->first();
			$hamil->pasien_id                     = Input::get('pasien_id');
			$hamil->nama_suami                    = Input::get('nama_suami');
			$hamil->tb                            = Input::get('tb');
			$hamil->buku_id                       = Input::get('buku');
			$hamil->golongan_darah                = Input::get('golongan_darah');
			$hamil->tinggi_badan                  = Input::get('tb');
			$hamil->bb_sebelum_hamil              = Input::get('bb_sebelum_hamil');
			$hamil->g                             = Input::get('G');
			$hamil->p                             = Input::get('P');
			$hamil->a                             = Input::get('A');
			$hamil->riwayat_persalinan_sebelumnya = Input::get('riwayat_kehamilan');
			$hamil->jumlah_janin                  = Input::get('jumlah_janin');
			$hamil->status_imunisasi_tt_id        = Input::get('status_imunisasi_tt_id');
			$hamil->hpht                          = Yoga::datePrep(Input::get('hpht'));
			$hamil->rencana_penolong              = Input::get('rencana_penolong');
			$hamil->rencana_tempat                = Input::get('rencana_tempat');
			$hamil->rencana_pendamping            = Input::get('rencana_pendamping');
			$hamil->rencana_transportasi          = Input::get('rencana_transportasi');
			$hamil->tanggal_lahir_anak_terakhir   = Yoga::datePrep(Input::get('tanggal_lahir_anak_terakhir'));
			$hamil->rencana_pendonor              = Input::get('rencana_pendonor');
			$hamil->save();
		}
		$anc                           = new RegisterAnc;
		$anc->periksa_id               = $periksa_id;
		$anc->register_hamil_id        = $hamil->id;
		$anc->td                       = Input::get('td');
		$anc->tfu                      = Input::get('tfu');
		$anc->lila                     = Input::get('lila');
		$anc->bb                       = Input::get('bb');
		$anc->refleks_patela_id        = Input::get('refleks_patela');
		$anc->djj                      = Input::get('djj');
		$anc->kepala_terhadap_pap_id   = Input::get('kepala_terhadap_pap_id');
		$anc->presentasi_id            = Input::get('presentasi_id');
		$anc->catat_di_kia             = Input::get('catat_di_kia');
		$anc->inj_tt                   = Input::get('inj_tt');
		$anc->fe_tablet                = Input::get('fe_tablet');
		$anc->periksa_hb               = Input::get('periksa_hb');
		$anc->protein_urin             = Input::get('protein_urin');
		$anc->gula_darah               = Input::get('gula_darah');
		$anc->thalasemia               = Input::get('thalasemia');
		$anc->sifilis                  = Input::get('sifilis');
		$anc->hbsag                    = Input::get('hbsag');
		$anc->pmtct_konseling          = Input::get('pmtct_konseling');
		$anc->pmtct_periksa_darah      = Input::get('pmtct_periksa_darah');
		$anc->pmtct_serologi           = Input::get('pmtct_serologi');
		$anc->pmtct_arv                = Input::get('pmtct_arv');
		$anc->malaria_periksa_darah    = Input::get('malaria_periksa_darah');
		$anc->malaria_positif          = Input::get('malaria_positif');
		$anc->malaria_dikasih_obat     = Input::get('malaria_dikasih_obat');
		$anc->malaria_dikasih_kelambu  = Input::get('malaria_dikasih_kelambu');
		$anc->tbc_periksa_dahak        = Input::get('tbc_periksa_dahak');
		$anc->tbc_positif              = Input::get('tbc_positif');
		$anc->tbc_dikasih_obat         = Input::get('tbc_dikasih_obat');
		$anc->komplikasi_hdk           = Input::get('komplikasi_hdk');
		$anc->komplikasi_abortus       = Input::get('komplikasi_abortus');
		$anc->komplikasi_perdarahan    = Input::get('komplikasi_perdarahan');
		$anc->komplikasi_infeksi       = Input::get('komplikasi_infeksi');
		$anc->komplikasi_kpd           = Input::get('komplikasi_kpd');
		$anc->komplikasi_lain_lain     = Input::get('komplikasi_lain_lain');
		$anc->rujukan_tiba_masih_hidup = Input::get('rujukan_tiba_masih_hidup');
		$anc->rujukan_tiba_meninggal   = Input::get('rujukan_tiba_meninggal');
		$anc->rujukan_puskesmas        = '2';
		$anc->rujukan_RB               = '2';
		$anc->rujukan_RSIA_RSB         = '2';
		$anc->rujukan_RS               = '2';
		$anc->rujukan_lain             = '2';
		$anc->rujukan_tiba_masih_hidup = '1';
		$anc->rujukan_tiba_meninggal   = '1';
		$anc->save();
	}
		$antrian_id = Input::get('antrian_id');
		if($confirm ){
			AntrianPeriksa::destroy( $antrian_id );
		}

		//UPDATE pengantar tambahkan periksa_id
		//
		//
	
		PengantarPasien::where('antarable_id', $antrian_id)
			->where('antarable_type', 'App\AntrianPeriksa')
			->update([
				'antarable_id' => $periksa_id,
				'antarable_type' => 'App\Periksa'
			]);


		$pasien = Pasien::find(Input::get('pasien_id'));
		$poli = Input::get('poli');
		if ($poli == 'sks' || $poli == 'luka') {
			$poli = 'umum';
		} else if ($poli == 'KB 1 Bulan' || $poli == 'KB 3 Bulan' ){
			$poli='kandungan';
		}
		return redirect('ruangperiksa/' . $poli)->withPesan(Yoga::suksesFlash('<strong>' . $pasien->id . ' - ' . $pasien->nama . '</strong> Selesai Diperiksa' ));
	}

	/**
	 * Display the specified periksa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{	
		$periksa = Periksa::find($id);
		return view('periksas.show', compact('periksa'));
	}

	/**
	 * Show the form for editing the specified periksa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$periksa = Periksa::find($id);
		if (isset($periksa->gambarPeriksa)) {
			$periksa->gambarPeriksa->delete();
		}
		return view('periksas.edit', compact('periksa'));
	}

	/**
	 * Update the specified periksa in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$periksa = Periksa::find($id);

		//Buat collection tabel asuransi
		//
		$asuransi = Asuransi::find(Input::get('asuransi_id'));

		//UBAH RESEP MENURUT JENIS ASURANSI
		//sebelum terapi dimasukkan ke dalam periksa, obat harus disesuaikan dahulu, menurut asuransi nya.
		// untuk asuransi BPJS, obat akan dikonversi ke dalam merek yang paling murah yang memiliki formula yang sama
		// untuk asuransi admedika, obat akan dikonversi ke dalam merek paling mahal dalam formula yang sama
		$terapis = $this->sesuaikanResep(Input::get('terapi'), $asuransi);

		//sesuaikan Transaksi
		$transaksis = $this->sesuaikanTransaksi(Input::get('transaksi'), $asuransi, $terapis);
	
		// INPUT DATA PERIKSA FINAL!!!!!
        
		$periksa->anamnesa 				= Input::get('anamnesa');
		$periksa->asuransi_id 			= $asuransi->id;
		$periksa->diagnosa_id 			= Input::get('diagnosa_id');
		$periksa->berat_badan  			= Input::get('berat_badan');
		$periksa->staf_id 				= Input::get('staf_id');
		$periksa->jam_resep 			= date('H:i:s');
		$periksa->keterangan_diagnosa 	= Input::get('keterangan_diagnosa');
		$periksa->lewat_poli 			= '1';
		$periksa->antrian_periksa_id	= Input::get('antrian_id');
		$periksa->lewat_kasir 			= '0';
		$periksa->lewat_kasir2 			= '0';
		$periksa->resepluar 			= Input::get('resepluar');
		$periksa->pemeriksaan_fisik 	= Input::get('pemeriksaan_fisik');
		$periksa->pemeriksaan_penunjang = Input::get('pemeriksaan_penunjang');
		$periksa->terapi 				= $this->terapisBaru($terapis);
		$periksa->transaksi 			= json_encode($transaksis);
		$periksa->jam_selesai_periksa	= date('H:i:s');
		$confirm = $periksa->save();
		$terapis = json_decode($terapis, true);


		if ( Input::hasFile('foto_estetika') ) {
			if (count( Input::file('foto_estetika') ) > 0 ) {
				$timestamp = date('Y-m-d H:i:s');
				$files = Input::file('foto_estetika');

				foreach ($files as $k=>$file) {
					if ( $file != null ) {
						if (empty(  Input::get('id_estetika')[$k] )) {
							$filename = $this->imageUpload($file, $id, $k); 
							$data[] = [
								 'nama'   => $filename,
								 'keterangan' => Input::get('keterangan_gambar')[$k],
								 'periksa_id' => $id,
								 'created_at' => $timestamp,
								 'updated_at' => $timestamp
							];
						}
					}
				}
				GambarPeriksa::insert($data);
			}
		}

		$terapiEx = Terapi::where('periksa_id', $id)->get();

		$hapus = true;
		foreach ($terapiEx as $k => $tEx) {
			foreach ($terapis as $key => $value) {
				if (isset($value['id'])) {
					if ($tEx['id'] == $value['id'] ) {
						$hapus = false;
					}
				}
			}
			if ($hapus) {
				Terapi::destroy($tEx['id']);
			}
			$hapus = true;
		}
		foreach ($terapis as $k => $t) {
			if (!isset($t['id'])) {
				$terapiBaru = new Terapi;
				$terapiBaru->merek_id = $t['merek_id'];
				$terapiBaru->signa = $t['signa'];
				$terapiBaru->aturan_minum = $t['aturan_minum'];
				$terapiBaru->jumlah = $t['jumlah'];
				$terapiBaru->periksa_id = $id;
				$terapiBaru->harga_beli_satuan = Merek::find($t['merek_id'])->rak->harga_beli;
				$terapiBaru->harga_jual_satuan = Yoga::hargaJualSatuan($asuransi, $t['merek_id']);;
				$terapiBaru->save();
			}
		}

	if(Input::get('poli') == 'usg'){
		
		$usg                 = Usg::where('periksa_id', $id)->first();
		$usg->perujuk_id     = Input::get('perujuk_id');
		$usg->hpht           = Yoga::datePrep(Input::get('hpht'));
		$usg->umur_kehamilan = Input::get('umur_kehamilan');
		$usg->gpa            = Input::get('gpa');
		$usg->bpd            = Input::get('BPD_w') . 'w ' . Input::get('BPD_d') . 'd';
		$usg->ltp            = Input::get('LTP');
		$usg->djj            = Input::get('FHR');
		$usg->ac             = Input::get('AC_w') . 'w ' . Input::get('AC_d') . 'd';
		$usg->hc             = Input::get('HC_w') . 'w ' . Input::get('HC_d') . 'd';
		$usg->efw            = Input::get('EFW') . ' gr';
		$usg->bpd_mm             = Input::get('BPD_mm');
		$usg->ac_mm             = Input::get('AC_mm');
		$usg->hc_mm             = Input::get('HC_mm');
		$usg->FL_mm             = Input::get('FL_mm');
		$usg->fl             = Input::get('FL_w') . 'w ' . Input::get('FL_d') . 'd';
		$usg->sex            = Input::get('Sex');
		$usg->ica            = Input::get('total_afi');
		$usg->plasenta       = Input::get('Plasenta');
		$usg->presentasi     = Input::get('presentasi');
		$usg->kesimpulan     = Input::get('kesimpulan');
		$usg->saran          = Input::get('saran');
		$usg->save();

		$pasien = Pasien::find(Input::get('pasien_id'));
		$pasien->riwayat_kehamilan_sebelumnya = Input::get('riwayat_kehamilan_sebelumnya');
		$pasien->save();

	}

	if (Input::get('poli') == 'anc' || Input::get('poli') == 'usg') {

		if (RegisterHamil::where('g', Input::get('G'))->where('pasien_id', Input::get('pasien_id'))->count() < 1) {
			
			$hamil                                = new RegisterHamil;
			$hamil->pasien_id                     = Input::get('pasien_id');
			$hamil->nama_suami                    = Input::get('nama_suami');
			$hamil->tb                            = Input::get('tb');
			$hamil->buku_id                       = Input::get('buku');
			$hamil->golongan_darah                = Input::get('golongan_darah');
			$hamil->tinggi_badan                  = Input::get('tb');
			$hamil->bb_sebelum_hamil              = Input::get('bb_sebelum_hamil');
			$hamil->g                             = Input::get('G');
			$hamil->p                             = Input::get('P');
			$hamil->a                             = Input::get('A');
			$hamil->riwayat_persalinan_sebelumnya = Input::get('riwayat_kehamilan');
			$hamil->hpht                          = Yoga::datePrep(Input::get('hpht'));
			$hamil->status_imunisasi_tt_id        = Input::get('status_imunisasi_tt_id');
			$hamil->rencana_penolong              = Input::get('rencana_penolong');
			$hamil->jumlah_janin                  = Input::get('jumlah_janin');
			$hamil->rencana_tempat                = Input::get('rencana_tempat');
			$hamil->rencana_pendamping            = Input::get('rencana_pendamping');
			$hamil->rencana_transportasi          = Input::get('rencana_transportasi');
			$hamil->rencana_pendonor              = Input::get('rencana_pendonor');
			$hamil->tanggal_lahir_anak_terakhir   = Yoga::datePrep(Input::get('tanggal_lahir_anak_terakhir'));
			$hamil->save();
		} else {

			$hamil                                = RegisterHamil::where('g', Input::get('G'))->where('pasien_id', Input::get('pasien_id'))->first();
			$hamil->pasien_id                     = Input::get('pasien_id');
			$hamil->nama_suami                    = Input::get('nama_suami');
			$hamil->tb                            = Input::get('tb');
			$hamil->buku_id                       = Input::get('buku');
			$hamil->golongan_darah                = Input::get('golongan_darah');
			$hamil->tinggi_badan                  = Input::get('tb');
			$hamil->bb_sebelum_hamil              = Input::get('bb_sebelum_hamil');
			$hamil->g                             = Input::get('G');
			$hamil->p                             = Input::get('P');
			$hamil->a                             = Input::get('A');
			$hamil->riwayat_persalinan_sebelumnya = Input::get('riwayat_kehamilan');
			$hamil->jumlah_janin                  = Input::get('jumlah_janin');
			$hamil->status_imunisasi_tt_id        = Input::get('status_imunisasi_tt_id');
			$hamil->hpht                          = Yoga::datePrep(Input::get('hpht'));
			$hamil->rencana_penolong              = Input::get('rencana_penolong');
			$hamil->rencana_tempat                = Input::get('rencana_tempat');
			$hamil->rencana_pendamping            = Input::get('rencana_pendamping');
			$hamil->rencana_transportasi          = Input::get('rencana_transportasi');
			$hamil->tanggal_lahir_anak_terakhir   = Yoga::datePrep(Input::get('tanggal_lahir_anak_terakhir'));
			$hamil->rencana_pendonor              = Input::get('rencana_pendonor');
			$hamil->save();
		}

		$anc                           = RegisterAnc::where('periksa_id', $id)->first();
		$anc->register_hamil_id        = $hamil->id;
		$anc->td                       = Input::get('td');
		$anc->tfu                      = Input::get('tfu');
		$anc->lila                     = Input::get('lila');
		$anc->bb                       = Input::get('bb');
		$anc->refleks_patela_id        = Input::get('refleks_patela');
		$anc->djj                      = Input::get('djj');
		$anc->kepala_terhadap_pap_id   = Input::get('kepala_terhadap_pap_id');
		$anc->presentasi_id            = Input::get('presentasi_id');
		$anc->catat_di_kia             = Input::get('catat_di_kia');
		$anc->inj_tt                   = Input::get('inj_tt');
		$anc->fe_tablet                = Input::get('fe_tablet');
		$anc->periksa_hb               = Input::get('periksa_hb');
		$anc->protein_urin             = Input::get('protein_urin');
		$anc->gula_darah               = Input::get('gula_darah');
		$anc->thalasemia               = Input::get('thalasemia');
		$anc->sifilis                  = Input::get('sifilis');
		$anc->hbsag                    = Input::get('hbsag');
		$anc->pmtct_konseling          = Input::get('pmtct_konseling');
		$anc->pmtct_periksa_darah      = Input::get('pmtct_periksa_darah');
		$anc->pmtct_serologi           = Input::get('pmtct_serologi');
		$anc->pmtct_arv                = Input::get('pmtct_arv');
		$anc->malaria_periksa_darah    = Input::get('malaria_periksa_darah');
		$anc->malaria_positif          = Input::get('malaria_positif');
		$anc->malaria_dikasih_obat     = Input::get('malaria_dikasih_obat');
		$anc->malaria_dikasih_kelambu  = Input::get('malaria_dikasih_kelambu');
		$anc->tbc_periksa_dahak        = Input::get('tbc_periksa_dahak');
		$anc->tbc_positif              = Input::get('tbc_positif');
		$anc->tbc_dikasih_obat         = Input::get('tbc_dikasih_obat');
		$anc->komplikasi_hdk           = Input::get('komplikasi_hdk');
		$anc->komplikasi_abortus       = Input::get('komplikasi_abortus');
		$anc->komplikasi_perdarahan    = Input::get('komplikasi_perdarahan');
		$anc->komplikasi_infeksi       = Input::get('komplikasi_infeksi');
		$anc->komplikasi_kpd           = Input::get('komplikasi_kpd');
		$anc->komplikasi_lain_lain     = Input::get('komplikasi_lain_lain');
		$anc->rujukan_tiba_masih_hidup = Input::get('rujukan_tiba_masih_hidup');
		$anc->rujukan_tiba_meninggal   = Input::get('rujukan_tiba_meninggal');
		$anc->rujukan_puskesmas        = '2';
		$anc->rujukan_RB               = '2';
		$anc->rujukan_RSIA_RSB         = '2';
		$anc->rujukan_RS               = '2';
		$anc->rujukan_lain             = '2';
		$anc->rujukan_tiba_masih_hidup = '1';
		$anc->rujukan_tiba_meninggal   = '1';
		$anc->save();
	}


		$antrian_id = Input::get('antrianperiksa_id');
		PengantarPasien::where('antarable_id', $antrian_id)
			->where('antarable_type', 'App\AntrianPeriksa')
			->update([
				'antarable_id' => $id,
				'antarable_type' => 'App\Periksa'
			]);

		if($confirm){
			AntrianPeriksa::destroy($antrian_id);
		}
		$pasien = Pasien::find(Input::get('pasien_id'));
		return redirect('ruangperiksa/' . Input::get('poli'))->withPesan(Yoga::suksesFlash('<strong>' . $pasien->id . ' - ' . $pasien->nama . '</strong> Selesai Diperiksa' ));
	}

	/**
	 * Remove the specified periksa from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Periksa::destroy($id);

		Terapi::where('periksa_id', $id)->delete();

		return \Redirect::route('periksas.index');
	}

	private function terapisBaru($terapis)
	{
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

	private function bhp($transaksi){
		$transaksis = json_decode($transaksi, true);
		if(!empty($transaksi) && $transaksi != '[]'){
			$transaksis[] = [
				"jenis_tarif_id" => '140',
				"jenis_tarif" => 'BHP',
				"biaya"	=> '0'
			];
		} else {
			$transaksis = [];
		}
		return $transaksis;
	}


	private function sesuaikanResep($terapis, $asuransi){
		if($asuransi->id == '32' || $asuransi->tipe_asuransi == '4') { // asuransi_id 32 = BPJS atau tipe_asuransi 4 == flat
			if ($terapis != '' && $terapis != '[]') {
				$terapis = Yoga::sesuaikanResep($terapis, 'asc');
				// return $terapis;
			}
		} elseif($asuransi->tipe_asuransi == '3'){ //tipe_asuransi 1 = admedika
			if ($terapis != '' && $terapis != '[]') {
				$terapis = Yoga::sesuaikanResep($terapis, 'desc');
			}
        } else {
			if ($terapis != '' && $terapis != '[]') {
				$terapis = Yoga::sesuaikanResepPasienUmum($terapis);
			}
        }
		return $terapis;
	}

	private function inputJasaDokter($transaksis, $asuransi){
		$paket_tindakan = false;
		foreach ($transaksis as $key => $trx) {
			$tipe_tindakan_id = Tarif::where('asuransi_id', $asuransi->id)->where('jenis_tarif_id', $trx['jenis_tarif_id'])->first()->tipe_tindakan_id;
			if ($tipe_tindakan_id != 1) {
				$paket_tindakan = true;
				break;
			}
		}
		if (!$paket_tindakan) {  // jika tidak ada transaksi paket tindakan, masukkan komponen transaksi jasa dokter

			$tarif = Tarif::where('jenis_tarif_id', '1')->where('asuransi_id', $asuransi->id)->first();
			// masukkan komponen jasa dokter di transaksi
			$plus = [
				'jenis_tarif_id' => $tarif->jenis_tarif_id,
				'jenis_tarif'    => $tarif->jenisTarif->jenis_tarif,
				'biaya'          => $tarif->biaya
			];

			array_unshift($transaksis, $plus);
		}
		return $transaksis;
	}

	public function sesuaikanTransaksi($transaksi, $asuransi, $terapis){
		// INPUT TRANSAKSI BHP
		// Jika input transaksi tidak kosong DAN input transaksi tidak sama dengan json kosng,
		// maka buat transaksi BHP dengan nilai 0 yang akan dimasukkan belakangan
		$transaksis = $this->bhp($transaksi);
		// INPUT TRANSAKSI OBAT
		//Jika terapi tidak kosong, maka hitung biaya obat
		$plafonFlat = Yoga::dispensingObatBulanIni($asuransi)['plafon'];
		// return $plafonFlat;
		// return $plafon;
		$transaksis = Yoga::kaliObat($transaksis, $terapis, $asuransi, $plafonFlat);
		//INPUT TRANSAKSI JASA DOKTER
		//jenis tarif id = 1 adalah jasa dokter
		//jika ada tindakan surat keterangan sehat, maka jasa dokter adalah 0
		return $this->inputJasaDokter($transaksis, $asuransi);
	}


}
