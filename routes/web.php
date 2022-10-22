<?php

use Illuminate\Support\Facades\Route;
use App\Events\FormSubmitted;
use App\Mail\SendEmailMailable;
use App\Jobs\sendEmailJob;

Route::get('/', [\App\Http\Controllers\AuthController::class, 'index']);
Route::get('login', [\App\Http\Controllers\AuthController::class, 'index'])->name('login');
Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('rekening/mandiri', [\App\Http\Controllers\MutasiBankController::class, 'info']);
Route::post('moota/callback', [\App\Http\Controllers\MutasiBankController::class, 'mootaCallback']);
Route::post('woowa/webhook', [\App\Http\Controllers\WoowaController::class, 'webhook']);
Route::post('wablas/webhook', [\App\Http\Controllers\WablasController::class, 'webhook']);
Route::post('webhook', [\App\Http\Controllers\WablasController::class, 'webhook']);

Route::get('/send', [\App\Http\Controllers\MailController::class, 'index']);

Route::post('logging/javascript', function()
{
	\Log::error('Javascript error:' . json_encode(Input::all()));
});
Route::resource('antrians', \App\Http\Controllers\AntriansController::class);

Route::get('fasilitas/antrian_pasien', [\App\Http\Controllers\FasilitasController::class, 'antrian_pasien']); //antrian pasien
Route::put('fasilitas/konfirmasi', [\App\Http\Controllers\FasilitasController::class, 'konfirmasi']); //antrian pasien
Route::get('fasilitas/antrian_pasien/ajax/{id}', [\App\Http\Controllers\FasilitasController::class, 'antrianAjax']); //antrian pasien
Route::get('fasilitas/antrian_pasien/tambah/{id}', [\App\Http\Controllers\FasilitasController::class, 'getTambahAntrian']); //antrian pasien

Route::get('fasilitas/antrian_pasien/{poli}', [\App\Http\Controllers\FasilitasController::class, 'input_tgl_lahir']); //antrian pasien
Route::post('fasilitas/antrian_pasien/{poli}/tanggal', [\App\Http\Controllers\FasilitasController::class, 'post_tgl_lahir']); //antrian pasien
Route::post('fasilitas/antrian_pasien/{poli}/tanggal/{pasien_id}', [\App\Http\Controllers\FasilitasController::class, 'cari_asuransi']); //cari_pasien
Route::get('fasilitas/antrian_pasien/{poli}/{tanggal_lahir}', [\App\Http\Controllers\FasilitasController::class, 'post_tgl_lahir']); //antrian pasien
Route::get('fasilitas/input_telp', [\App\Http\Controllers\FasilitasController::class, 'input_telp']); //antrian pasien

Route::post('fasilitas/antrian_pasien/{poli}/tanggal/{pasien_id}/{asuransi_id}', [\App\Http\Controllers\FasilitasController::class, 'submit_antrian']); //cari_pasien
Route::delete('fasilitas/antrianpolis/destroy', [\App\Http\Controllers\FasilitasController::class, 'antrianPoliDestroy']); //cari_pasien
Route::delete('fasilitas/antrianperiksa/destroy', [\App\Http\Controllers\FasilitasController::class, 'antrianPeriksaDestroy']); //cari_pasien

Route::get('phpinfo', [\App\Http\Controllers\PhpController::class, 'index']);
Route::get('periksa/{id}/images', [\App\Http\Controllers\ImagesController::class, 'create']);
Route::post('periksa/{id}/images', [\App\Http\Controllers\ImagesController::class, 'store']);
Route::get('periksa/{id}/images/edit', [\App\Http\Controllers\ImagesController::class, 'edit']);
Route::put('periksa/{id}/images', [\App\Http\Controllers\ImagesController::class, 'update']);
Route::get('images/result', [\App\Http\Controllers\ImagesController::class, 'result']);

Route::get('antrianperiksa/{id}/images', [\App\Http\Controllers\ImagesAntrianPeriksaController::class, 'create']);
Route::post('antrianperiksa/{id}/images', [\App\Http\Controllers\ImagesAntrianPeriksaController::class, 'store']);
Route::get('antrianperiksa/{id}/images/edit', [\App\Http\Controllers\ImagesAntrianPeriksaController::class, 'edit']);
Route::put('antrianperiksa/{id}/images', [\App\Http\Controllers\ImagesAntrianPeriksaController::class, 'update']);
Route::resource('users', \App\Http\Controllers\UsersController::class);
Route::resource('pasien_rujuk_baliks', \App\Http\Controllers\PasienRujukBalikController::class);
Route::get('fasilitas/survey', [\App\Http\Controllers\FasilitasController::class, 'survey']); //survey kepuasan pelanggan

Route::group(['middleware' => 'auth'], function(){

    Route::resource('sent_emails', \App\Http\Controllers\SentEmailController::class);
    Route::get('invoices/inv/{id}', [\App\Http\Controllers\InvoiceController::class, 'test']);
    Route::get('invoices/getData', [\App\Http\Controllers\InvoiceController::class, 'getData']);
    Route::post('invoices/upload_verivication/{id}', [\App\Http\Controllers\InvoiceController::class, 'upload_verivication']);
    Route::get('invoices/pendingReceivedVerification', [\App\Http\Controllers\InvoiceController::class, 'pendingReceivedVerification']);
    Route::resource('invoices', \App\Http\Controllers\InvoiceController::class);
    Route::get('sertifikats/search', [\App\Http\Controllers\SertifikatController::class, 'search']);
    Route::resource('sertifikats', \App\Http\Controllers\SertifikatController::class);
	Route::get('antrians/proses/{id}', [\App\Http\Controllers\FasilitasController::class, 'prosesAntrian']); //antrian pasien
	Route::post('antrians/antrianpolis/{id}', [\App\Http\Controllers\FasilitasController::class, 'antrianPoliPost']); //antrian pasien
	Route::get('antrians/{id}/pasiens/create', [\App\Http\Controllers\FasilitasController::class, 'createPasien']); //antrian pasien
	Route::post('antrians/{id}/pasiens', [\App\Http\Controllers\FasilitasController::class, 'storePasien']); //antrian pasien
	Route::get('antrians', [\App\Http\Controllers\FasilitasController::class, 'listAntrian']);
	Route::delete('antrians/{id}', [\App\Http\Controllers\FasilitasController::class, 'deleteAntrian']);

	Route::post('peserta_bpjs_perbulans/editDataPasien', [\App\Http\Controllers\PesertaBpjsPerbulanController::class, 'editDataPasien']);
	Route::post('/peserta_bpjs_perbulans/update_data_pasien', [\App\Http\Controllers\PesertaBpjsPerbulanController::class, 'updateDataPasien']);


	/* Route::resource('peserta_bpjs_perbulans', \App\Http\Controllers\PesertaBpjsPerbulanController::class); */

	Route::post('antrian_kelengkapan_dokumens/{id}', [\App\Http\Controllers\AntrianKelengkapanDokumenController::class, 'proses']); //antrian pasien
	Route::resource('antrian_kelengkapan_dokumens', \App\Http\Controllers\AntrianKelengkapanDokumenController::class); //antrian pasien
	Route::resource('denominator_bpjs', \App\Http\Controllers\DenominatorBpjsController::class); //antrian pasien

	Route::get('antrianapoteks', [\App\Http\Controllers\AntrianApotekController::class, 'index']); //antrian pasien
	Route::post('antrianapoteks/kembali/{id}', [\App\Http\Controllers\AntrianApotekController::class, 'kembali']); //antrian pasien
	Route::get('antrianfarmasis', [\App\Http\Controllers\AntrianFarmasiController::class, 'index']); //antrian pasien
	Route::get('antrianfarmasis/{id}', [\App\Http\Controllers\AntrianFarmasiController::class, 'show']); //antrian pasien
	Route::post('antrianfarmasis/{id}/proses', [\App\Http\Controllers\AntrianFarmasiController::class, 'proses']); //antrian pasien
	Route::post('antrianfarmasis/kembali/{id}', [\App\Http\Controllers\AntrianFarmasiController::class, 'kembali']); //antrian pasien
	Route::delete('antrianfarmasis/{id}', [\App\Http\Controllers\AntrianFarmasiController::class, 'destroy']); //antrian pasien

	Route::get('transaksi/avail', [\App\Http\Controllers\RekeningController::class, 'available']);

	Route::get('cek_list_harians', [\App\Http\Controllers\CekListHariansController::class, 'index']);
	Route::get('cek_list_harian/obat', [\App\Http\Controllers\CekListHariansController::class, 'obat']);
	Route::post('cek_list_harian/obat', [\App\Http\Controllers\CekListHariansController::class, 'obatPost']);
	Route::get('cek_list_harian/pulsa', [\App\Http\Controllers\CekListHariansController::class, 'pulsa']);
	Route::post('cek_list_harian/pulsa', [\App\Http\Controllers\CekListHariansController::class, 'pulsaPost']);
	/* Route::get('cek_list_harian/listrik', [\App\Http\Controllers\CekListHariansController::class, 'listrik']); */
	/* Route::post('cek_list_harian/listrik', [\App\Http\Controllers\CekListHariansController::class, 'listrikPost']); */
	Route::post('test', [\App\Http\Controllers\TestController::class, 'post']);
	Route::get('test', [\App\Http\Controllers\TestController::class, 'index']);
	Route::get('test/pusher', [\App\Http\Controllers\TestController::class, 'pusher']);
	Route::post('test/ajax', [\App\Http\Controllers\TestController::class, 'ajax']);
	Route::get('test/test', [\App\Http\Controllers\TestController::class, 'test']);
	Route::get('diagnosa/tidakdirujuk', [\App\Http\Controllers\TidakdirujukController::class, 'index']);
	Route::post('suppliers/ajax/ceknotalama', [\App\Http\Controllers\SuppliersAjaxController::class, 'ceknotalama']);
	Route::post('suppliers/{id}/upload', [\App\Http\Controllers\SuppliersAjaxController::class, 'upload']);
	Route::post('suppliers/ajax/create', [\App\Http\Controllers\SuppliersAjaxController::class, 'create']);
	Route::get('suppliers/belanja_obat', [\App\Http\Controllers\SupplierBelanjasController::class, 'belanja_obat']);
	Route::get('suppliers/belanja_bukan_obat', [\App\Http\Controllers\SupplierBelanjasController::class, 'belanja_bukan_obat']);
	Route::get('antrian_pasien', [\App\Http\Controllers\SupplierBelanjasController::class, 'belanja_obat']);
	Route::get('suppliers/belanja_bukan_obat', [\App\Http\Controllers\SupplierBelanjasController::class, 'belanja_bukan_obat']);
	Route::get('antrianpolis/ajax/getGolonganProlanis', [\App\Http\Controllers\AntrianPolisAjaxController::class, 'getProlanis']);




	Route::get('{posisi_antrian}/pengantar/{id}', [\App\Http\Controllers\PengantarsController::class, 'pengantar']);
	Route::post('{posisi_antrian}/pengantar/{id}', [\App\Http\Controllers\PengantarsController::class, 'store']);
	Route::get('laporans/periksa/pengantar/{id}/edit', [\App\Http\Controllers\PengantarsController::class, 'editPengantarPeriksa']);
	Route::get('laporans/cari_transaksi', [\App\Http\Controllers\LaporansController::class, 'cariTransaksi']);
	Route::get('laporans/periksas/cari_transaksi', [\App\Http\Controllers\LaporansController::class, 'cariTransaksiAjax']);


	Route::post('antrianpolis/get/kartubpjs', [\App\Http\Controllers\PengantarsController::class, 'kartubpjs']);
	Route::post('antrianpolis/pengantar/create', [\App\Http\Controllers\PengantarsController::class, 'pengantarPost']);
	Route::post('antrianpolis/pengantar/pasien/create', [\App\Http\Controllers\PengantarsController::class, 'storePasien']);
	Route::post('antrianpolis/pengantar/pasien/create/ajax', [\App\Http\Controllers\PengantarsController::class, 'storePasienAjax']);
	Route::post('antrianpolis/pengantar/{id}/edit', [\App\Http\Controllers\PengantarsController::class, 'pengantarUpdate']);
	Route::put('{posisi_antrian}/pengantar/{id}/edit', [\App\Http\Controllers\PengantarsController::class, 'update']);
	Route::post( '/antrianperiksas/update/staf', [\App\Http\Controllers\AntrianPeriksasController::class, 'updateStaf']);
	Route::get( '/antrianperiksas/get/hubungan_keluarga_id', [\App\Http\Controllers\AntrianPeriksasController::class, 'getHubunganKeluargaId']);

	Route::post('antriankasirs/pengantar/{id}/edit', [\App\Http\Controllers\PengantarsController::class, 'antriankasirsUpdate']);
	Route::post('laporans/pengantar', [\App\Http\Controllers\PengantarsController::class, 'submitPcare']);
	Route::post('laporans/periksa/pengantar/{id}', [\App\Http\Controllers\PengantarsController::class, 'updatePengantarPeriksa']);




	Route::get('laporans/omset_estetik', [\App\Http\Controllers\LaporansController::class, 'omsetEstetik']);
	Route::get('laporans/jumlahPenyakitTBCTahunan', [\App\Http\Controllers\LaporansController::class, 'jumlahPenyakitTBCTahunan']);
	Route::get('laporans/bpjs/hipertensi', [\App\Http\Controllers\LaporanBpjsController::class, 'hipertensi']);
	Route::get('laporans/bpjs/dispensing_obat', [\App\Http\Controllers\LaporanBpjsController::class, 'dispensingObat']);
	Route::get('laporans/dispensing_obat_bpjs/get', [\App\Http\Controllers\LaporanBpjsController::class, 'dispensingObatGet']);
	Route::get('laporans/dispensing_obat_bpjs/{staf_id}', [\App\Http\Controllers\LaporanBpjsController::class, 'dispensingObatPerDokter']);



	Route::get('laporans/bpjs/dm', [\App\Http\Controllers\LaporanBpjsController::class, 'dm']);
	Route::get('laporans/bpjs/diagnosa', [\App\Http\Controllers\LaporanBpjsController::class, 'diagnosa']);
	Route::get('laporans/bpjs/data_kunjungan_prolanis_ht', [\App\Http\Controllers\LaporanBpjsController::class, 'dataKunjunganProlanisHT']);
	Route::get('laporans/bpjs/data_kunjungan_prolanis_dm', [\App\Http\Controllers\LaporanBpjsController::class, 'dataKunjunganProlanisDM']);

	Route::get(	'laporans/dm_berobat/{bulanTahun}', [\App\Http\Controllers\LaporanBpjsController::class, 'dmBerobat']);
	Route::get(	'laporans/dm_terkendali/{bulanTahun}', [\App\Http\Controllers\LaporanBpjsController::class, 'dmTerkendali']);
	Route::get(	'laporans/ht_berobat/{bulanTahun}', [\App\Http\Controllers\LaporanBpjsController::class, 'htBerobat']);
	Route::get(	'laporans/ht_terkendali/{bulanTahun}', [\App\Http\Controllers\LaporanBpjsController::class, 'htTerkendali']);




	Route::get('pdfs/bpjs/diagnosaRujukan', [\App\Http\Controllers\LaporanBpjsController::class, 'diagnosaPdf']);
	Route::get('pdfs/bpjs/hipertensi', [\App\Http\Controllers\LaporanBpjsController::class, 'hipertensiPdf']);


	Route::get('periksas/cari/by_asuransi/{asuransi_id}/{from}/{until}', [\App\Http\Controllers\PeriksasController::class, 'cariByAsuransiByPeriode']);
	Route::get('periksas/edit/transaksiPeriksa/get/coa_id', [\App\Http\Controllers\PeriksaCustomController::class, 'getCoaId']);
	Route::get('periksas/edit/transaksiPeriksa/get/coa_list', [\App\Http\Controllers\PeriksaCustomController::class, 'getCoaList']);

	Route::get('periksas/{id}/edit/transaksiPeriksa', [\App\Http\Controllers\PeriksaCustomController::class, 'editTransaksiPeriksa']);
	Route::get('periksas/{id}/edit/transaksiPeriksa', [\App\Http\Controllers\PeriksaCustomController::class, 'editTransaksiPeriksa']);
	Route::post('periksas/{id}/update/transaksiPeriksa', [\App\Http\Controllers\PeriksaCustomController::class, 'updateTransaksiPeriksa']);
	Route::post('periksas/{id}/update/tunai', [\App\Http\Controllers\PeriksaCustomController::class, 'updateTunai']);
	Route::post('periksas/{id}/update/piutang', [\App\Http\Controllers\PeriksaCustomController::class, 'updatePiutang']);
	Route::post('/periksas/{id}/upload', [\App\Http\Controllers\PeriksasController::class, 'uploadBerkas']);
	Route::post('/periksas/berkas/hapus', [\App\Http\Controllers\PeriksasController::class, 'hapusBerkas']);
	Route::post('periksas/kembali/{id}', [\App\Http\Controllers\PeriksasController::class, 'kembali']);
	Route::get('periksas/{id}/cek/jumlah/berkas', [\App\Http\Controllers\PeriksasController::class, 'jumlahBerkas']);
	Route::get('/periksas/cek_customer_survey_sudah_diisi', [\App\Http\Controllers\PeriksasController::class, 'cekCustomerServiceSudahDiisi']);

	Route::get( 'asuransis/get/coa_id' , [\App\Http\Controllers\AsuransisController::class, 'getAsuransiCoaId']);
	Route::get( 'asuransis/get/tipe_asuransi_id' , [\App\Http\Controllers\AsuransisController::class, 'getTipeAsuransiId']);
	Route::get( 'periksas/edit/transaksiPeriksa/process/refreshTunaiPiutang' , [\App\Http\Controllers\AsuransisController::class, 'refreshTunaiPiutang']);

	Route::put('asuransis/{id}/upload', [\App\Http\Controllers\AsuransisController::class, 'uploadBerkas']);
	Route::post('asuransis/berkas/hapus', [\App\Http\Controllers\AsuransisController::class, 'hapusBerkas']);


	Route::put('stafs/{id}/upload', [\App\Http\Controllers\StafsController::class, 'uploadBerkas']);
	Route::post('stafs/berkas/hapus', [\App\Http\Controllers\StafsController::class, 'hapusBerkas']);

	Route::get('backup', [\App\Http\Controllers\DatabaseController::class, 'index']);
	Route::get('copy_log_file', [\App\Http\Controllers\DatabaseController::class, 'copyLog']);
	Route::get('/asuransis/kata_kunci/unique_test', [\App\Http\Controllers\AsuransisController::class, 'kataKunciUnique']);
	Route::get('asuransis/get/tarifs/{id}', [\App\Http\Controllers\AsuransisController::class, 'searchTarifForCurrentAsuransi']);
	Route::get('asuransis/search', [\App\Http\Controllers\AsuransisController::class, 'searchAsuransi']);
	Route::resource('followup_tunggakans', \App\Http\Controllers\FollowupTunggakanController::class);
	Route::resource('followup_transaksis', \App\Http\Controllers\FollowupTransaksiController::class);

	Route::get('asuransis/{id}/tarifs', [\App\Http\Controllers\AsuransisController::class, 'getTarifForCurrentAsuransi']);

	Route::get('/asuransis/{asuransi_id}/tarifs/{tarif_id}', [\App\Http\Controllers\AsuransisController::class, 'editTarifForCurrentAsuransi']);
	Route::put('/asuransis/{asuransi_id}/tarifs/{tarif_id}', [\App\Http\Controllers\AsuransisController::class, 'updateTarifForCurrentAsuransi']);



	Route::put('antrianperiksas/{id}/editPoli', [\App\Http\Controllers\AntrianPeriksasController::class, 'editPoli']);


	// dari menu users
	Route::post('mereks/ajax/obat', [\App\Http\Controllers\MereksController::class, 'ajaxObat']);
	Route::get('/pasiens/cek/tanggal_lahir/sama', [\App\Http\Controllers\PasiensAjaxController::class, 'ajaxTanggalLahir']);
	Route::get('/pasiens/cek/nomor_bpjs/sama', [\App\Http\Controllers\PasiensAjaxController::class, 'cekNomorBpjsSama']);
	Route::get('pasiens/pacific_cross/2020', [\App\Http\Controllers\PasiensController::class, 'pc2020']);


	Route::get('antrianperiksas/create/{id}', [\App\Http\Controllers\AntrianPeriksasController::class, 'create']);
	Route::post('antrianperiksas/{id}', [\App\Http\Controllers\AntrianPeriksasController::class, 'store']);
	Route::post('antrianperiksas/delete/antrian_poli/{id}', [\App\Http\Controllers\AntrianPeriksasController::class, 'salahIdentifikasiPasien']);
	Route::post('antrianperiksas/update/foto_pasien', [\App\Http\Controllers\AntrianPeriksasController::class, 'updateFotoPasien']);


	Route::resource('antrianperiksas', \App\Http\Controllers\AntrianPeriksasController::class);
	Route::post('antriankasirs/kembali/{id}', [\App\Http\Controllers\AntrianKasirsController::class, 'kembali']);
	Route::resource('antriankasirs', \App\Http\Controllers\AntrianKasirsController::class);

	Route::resource('antrianpolis', \App\Http\Controllers\AntrianPolisController::class);

	Route::get('pasiens/{id}/alergi', [\App\Http\Controllers\PasiensController::class, 'alergi']);
	Route::get('pasiens/{id}/alergi/create', [\App\Http\Controllers\PasiensController::class, 'alergiCreate']);
	Route::get('stafs/{id}/gaji', [\App\Http\Controllers\StafsCustomController::class, 'gaji']);
	Route::get('qrcode', [\App\Http\Controllers\QrCodeController::class, 'index']);
	/* Route::get('qrcode/pdf', 'QrCodeController@inPdf'); */

	Route::get('kontrols/create/{periksa_id}', [\App\Http\Controllers\KontrolsController::class, 'create']);
	Route::post('kontrols', [\App\Http\Controllers\KontrolsController::class, 'store']);
	Route::get('kontrols/{periksa_id}/edit', [\App\Http\Controllers\KontrolsController::class, 'edit']);
	Route::put('kontrols/{id}', [\App\Http\Controllers\KontrolsController::class, 'update']);
	Route::delete('kontrols/{id}', [\App\Http\Controllers\KontrolsController::class, 'destroy']);

	Route::get('antrians/proses/pasiens/{id}/edit/{antrian_id}', [\App\Http\Controllers\PasiensController::class, 'editAtAntrian']);
	Route::get('prolanis_terkendali', [\App\Http\Controllers\PasiensController::class, 'prolanisTerkendali']);
	Route::post('pasiens/prolanis_terkendali/per_bulan', [\App\Http\Controllers\PasiensController::class, 'prolanisTerkendaliPerBulan']);
	Route::get('prolanis/denominator_dm', [\App\Http\Controllers\PasiensController::class, 'denominatorDm']);
	Route::get('prolanis/denominator_ht', [\App\Http\Controllers\PasiensController::class, 'denominatorHt']);

	Route::post('prolanis/verifikasi/ajax/meninggal', [\App\Http\Controllers\ProlanisController::class, 'ajaxMeninggal']);
	Route::post('prolanis/verifikasi/ajax/verifikasi', [\App\Http\Controllers\ProlanisController::class, 'ajaxVerifikasi']);
	Route::post('prolanis/verifikasi/ajax/penangguhan', [\App\Http\Controllers\ProlanisController::class, 'ajaxPenangguhan']);

	Route::get('pasiens/{id}/transaksi', [\App\Http\Controllers\PasiensController::class, 'transaksi']);
	Route::get('pasiens/getTransaksi/{id}', [\App\Http\Controllers\PasiensController::class, 'getTransaksi']);
	Route::get('pasien_dobel', [\App\Http\Controllers\PasiensController::class, 'dobel']);
	Route::get('pasiens/riwayat/gula_darah/{id}', [\App\Http\Controllers\PasiensController::class, 'riwayat_pemeriksaan_gula_darah']);
	Route::resource('pasiens', \App\Http\Controllers\PasiensController::class);
	Route::resource('periksas', \App\Http\Controllers\PeriksasController::class);

	Route::group(['middleware' =>[ 'admin']], function(){

        Route::get('document/search', [\App\Http\Controllers\DocumentController::class, 'search']);
        Route::post('document/ajax/delete', [\App\Http\Controllers\DocumentController::class, 'deleteAjax']);
        Route::resource('documents', \App\Http\Controllers\DocumentController::class);
		Route::delete('pengeluarans/{id}', [\App\Http\Controllers\PengeluaransController::class, 'destroy']);
		Route::get('rekening_bank/search', [\App\Http\Controllers\RekeningController::class, 'search']);
		Route::get('rekening_bank/ignore', [\App\Http\Controllers\RekeningController::class, 'ignoredList']);
		Route::post('rekening_bank/unignore/{id}', [\App\Http\Controllers\RekeningController::class, 'unignore']);
		Route::get('rekening_bank/{id}', [\App\Http\Controllers\RekeningController::class, 'index']);
		Route::post('rekening_bank/ignore/{id}', [\App\Http\Controllers\RekeningController::class, 'ignore']);
		Route::get('/rekening_bank/ignoredList/ajax', [\App\Http\Controllers\RekeningController::class, 'ignoredListAjax']);
		Route::get('rekenings/cek_id', [\App\Http\Controllers\RekeningController::class, 'cekId']);
		Route::get('rekenings/import', [\App\Http\Controllers\RekeningController::class, 'importCreate']);
		Route::post('rekenings/import', [\App\Http\Controllers\RekeningController::class, 'importPost']);
		Route::get('rekenings/{id}', [\App\Http\Controllers\RekeningController::class, 'show']);
		Route::get('jurnal_umums/show', [\App\Http\Controllers\JurnalUmumsController::class, 'show']);
		Route::get('jurnal_umums/penyusutan', [\App\Http\Controllers\JurnalUmumsController::class, 'penyusutan']);
		Route::get('jurnal_umums/coa', [\App\Http\Controllers\JurnalUmumsController::class, 'coa']);
		Route::get('jurnal_umums/omset_pajak', [\App\Http\Controllers\JurnalUmumsController::class, 'omset_pajak']);
		Route::get('jurnal_umums/manual', [\App\Http\Controllers\JurnalUmumsController::class, 'inputManual']);
		Route::post('jurnal_umums/manual', [\App\Http\Controllers\JurnalUmumsController::class, 'inputManualPost']);
		Route::post('jurnal_umums/coa', [\App\Http\Controllers\JurnalUmumsController::class, 'coaPost']);
		Route::get('jurnal_umums/coa_list', [\App\Http\Controllers\JurnalUmumsController::class, 'coa_list']);
		Route::get('jurnal_umums/coa_keterangan', [\App\Http\Controllers\JurnalUmumsController::class, 'coa_keterangan']);
		Route::post('jurnal_umums/coa_entry', [\App\Http\Controllers\JurnalUmumsController::class, 'coa_entry']);
		Route::get('jurnal_umums/hapus/jurnals', [\App\Http\Controllers\JurnalUmumsController::class, 'hapus_jurnals']);
		Route::get('jurnal_umums/{id}/edit', [\App\Http\Controllers\JurnalUmumsController::class, 'edit']);
		Route::put('jurnal_umums/{id}', [\App\Http\Controllers\JurnalUmumsController::class, 'update']);
		Route::get('laporan_laba_rugis', [\App\Http\Controllers\LaporanLabaRugisController::class, 'index']);
		Route::post('laporan_laba_rugis', [\App\Http\Controllers\LaporanLabaRugisController::class, 'show']);
		Route::get('laporan_laba_rugis/bikinan', [\App\Http\Controllers\LaporanLabaRugisController::class, 'bikinan']);
		Route::post('laporan_laba_rugis/bikinan', [\App\Http\Controllers\LaporanLabaRugisController::class, 'bikinanShow']);
		Route::get('laporan_laba_rugis/perBulan/{bulan}/{tahun}', [\App\Http\Controllers\LaporanLabaRugisController::class, 'perBulan']);
		Route::get('laporan_laba_rugis/perTahun/{tahun}', [\App\Http\Controllers\LaporanLabaRugisController::class, 'perTahun']);
		Route::get('laporan_laba_rugis/perBulan/{bulan}/{tahun}/bikinan', [\App\Http\Controllers\LaporanLabaRugisController::class, 'perBulanBikinan']);
		Route::get('laporan_laba_rugis/perTahun/{tahun}/bikinan', [\App\Http\Controllers\LaporanLabaRugisController::class, 'perTahunBikinan']);
		Route::get('laporan_arus_kass', [\App\Http\Controllers\LaporanArusKassController::class, 'index']);
		Route::get('laporan_arus_kass/show', [\App\Http\Controllers\LaporanArusKassController::class, 'show']);
		Route::get('laporan_neracas', [\App\Http\Controllers\LaporanNeracasController::class, 'index']);
		Route::post('laporan_neracas/show', [\App\Http\Controllers\LaporanNeracasController::class, 'show']);
		Route::get('laporan_neracas/indexBikinan', [\App\Http\Controllers\LaporanNeracasController::class, 'indexBikinan']);
		Route::post('laporan_neracas/showBikinan', [\App\Http\Controllers\LaporanNeracasController::class, 'showBikinan']);
		Route::get('neraca_saldos', [\App\Http\Controllers\NeracaSaldosController::class, 'index']);
		Route::get('neraca_saldos/show', [\App\Http\Controllers\NeracaSaldosController::class, 'show']);
		Route::get('pajaks/pph21s/{bulanTahun}', [\App\Http\Controllers\Pph21Controller::class, 'indexByMonth']);
		Route::resource('pajaks/pph21s', \App\Http\Controllers\Pph21Controller::class);
		Route::resource('pajaks/lapor_pajaks', \App\Http\Controllers\LaporPajakController::class);
		Route::get('/lapor_pajaks/get_periode_pajak', [\App\Http\Controllers\LaporPajakController::class, 'getPeriodePajak']);
		Route::get('pajaks/pph21s/{staf_id}/{bulanTahun}', [\App\Http\Controllers\Pph21Controller::class, 'pph21Detil']);
	});

		Route::get('stafs/{id}/jumlah_pasien', [\App\Http\Controllers\StafsController::class, 'jumlahPasien']);
		Route::get('stafs/{id}/jumlah_pasien/pertahun/{tahun}', [\App\Http\Controllers\StafsController::class, 'jumlahPasienPerTahun']);

		Route::resource('surats', \App\Http\Controllers\SuratController::class);
		Route::resource('pelamars', \App\Http\Controllers\PelamarsController::class);
		Route::resource('asuransis', \App\Http\Controllers\AsuransisController::class);
		Route::resource('diagnosas', \App\Http\Controllers\DiagnosasController::class);
		Route::resource('suppliers', \App\Http\Controllers\SuppliersController::class);
		Route::resource('stafs', \App\Http\Controllers\StafsController::class);
		Route::resource('formulas', \App\Http\Controllers\FormulasController::class);
		Route::resource('raks', \App\Http\Controllers\RaksController::class);
		Route::resource('mereks', \App\Http\Controllers\MereksController::class);
		Route::resource('tarifs', \App\Http\Controllers\TarifsController::class);
		Route::resource('komposisis', \App\Http\Controllers\KomposisisController::class);
		Route::resource('transaksis', \App\Http\Controllers\TransaksisController::class);
		Route::get('generiks', [\App\Http\Controllers\GeneriksController::class, 'index']);
		Route::get('generiks/create', [\App\Http\Controllers\GeneriksController::class, 'create']);
		Route::post('generiks', [\App\Http\Controllers\GeneriksController::class, 'store']);
		Route::delete('generiks/{id}', [\App\Http\Controllers\GeneriksController::class, 'destroy']);
		Route::get('sediaans', [\App\Http\Controllers\SediaansController::class, 'index']);
		Route::get('sediaans/create', [\App\Http\Controllers\SediaansController::class, 'create']);
		Route::post('sediaans', [\App\Http\Controllers\SediaansController::class, 'store']);
		Route::delete('sediaans/{id}', [\App\Http\Controllers\SediaansController::class, 'destroy']);
		Route::get('pembayaran_asuransis/{bulan}/{tahun}', [\App\Http\Controllers\PembayaranAsuransiController::class, 'perBulan']);
		Route::resource('pembayaran_asuransis', \App\Http\Controllers\PembayaranAsuransiController::class);
		Route::get('dispensings', [\App\Http\Controllers\DispensingsController::class, 'index']);
		Route::get('dispensings/{rak_id}/{tanggal}', [\App\Http\Controllers\DispensingsController::class, 'perTanggal']);

		Route::get('asuransis/riwayat/{id}', [\App\Http\Controllers\AsuransisExtraController::class, 'riwayat']);
		Route::get('asuransis/{id}/hutang/pembayaran', [\App\Http\Controllers\AsuransisController::class, 'riwayat']);
		Route::get('asuransis/riwayat/pembayaran/{id}', [\App\Http\Controllers\AsuransisController::class, 'riwayatPembayaran']);

		Route::get('asuransis/{id}/piutangBelumDibayar/{mulai}/{akhir}', [\App\Http\Controllers\AsuransisController::class, 'piutangBelumDibayar']);
		Route::get('asuransis/{id}/piutangAsuransi/SudahDibayar/{mulai}/{akhir}', [\App\Http\Controllers\AsuransisController::class, 'piutangAsuransiSudahDibayar']);
		Route::get('asuransis/{id}/piutangAsuransi/BelumDibayar/{mulai}/{akhir}', [\App\Http\Controllers\AsuransisController::class, 'piutangAsuransiBelumdibayar']);
		Route::get('asuransis/{id}/piutangAsuransi/Semua/{mulai}/{akhir}', [\App\Http\Controllers\AsuransisController::class, 'piutangAsuransi']);
		Route::get('rumahsakits', [\App\Http\Controllers\RumahSakitsController::class, 'index']); //penjualan obat tanpa resep
		Route::get('rumahsakits/create', [\App\Http\Controllers\RumahSakitsController::class, 'create']); //form membuat rumah sakit baru
		Route::get('rumahsakits/{id}', [\App\Http\Controllers\RumahSakitsController::class, 'show']); //penjualan obat tanpa resep
		Route::put('rumahsakits/{id}', [\App\Http\Controllers\RumahSakitsController::class, 'update']); //penjualan obat tanpa resep
		Route::post('rumahsakits', [\App\Http\Controllers\RumahSakitsController::class, 'store']); //penjualan obat tanpa resep

		Route::get('rayons/create', [\App\Http\Controllers\RayonsController::class, 'create']); //form membuat rumah sakit baru
		Route::post('rayons', [\App\Http\Controllers\RayonsController::class, 'store']); //form membuat rumah sakit baru
		Route::get('bayardokters', [\App\Http\Controllers\BayarDoktersController::class, 'index']); //penjualan obat tanpa resep
		Route::get('bayardokters/select/ajax', [\App\Http\Controllers\BayarDoktersController::class, 'selectAjax']); //penjualan obat tanpa resep


		Route::get('penjualans', [\App\Http\Controllers\PenjualansController::class, 'index']); //penjualan obat tanpa resep
		Route::get('penjualans/obat_buat_karyawan', [\App\Http\Controllers\PenjualansController::class, 'obat_buat_karyawan']); //penjualan obat tanpa resep
		Route::post('penjualans/obat_buat_karyawan', [\App\Http\Controllers\PenjualansController::class, 'obat_buat_karyawan_post']); //penjualan obat tanpa resep
		Route::post('pembelians/cari/ajax', [\App\Http\Controllers\PembeliansController::class, 'cariObat']);
		Route::post('penjualans', [\App\Http\Controllers\PenjualansController::class, 'indexPost']); //penjualan obat tanpa resep
		Route::post('pembelians/ajax/formulabyid', [\App\Http\Controllers\PembeliansAjaxController::class, 'formulabyid']);
		Route::post('pembelians/ajax/rakbyid', [\App\Http\Controllers\PembeliansAjaxController::class, 'rakbyid']);
		Route::get('pembelians', [\App\Http\Controllers\PembeliansController::class, 'index']);
		Route::post('pembelians/ajax', [\App\Http\Controllers\PembeliansController::class, 'ajax']);
		Route::post('pembelians', [\App\Http\Controllers\PembeliansController::class, 'store']);
		Route::get('pembelians/show/{id}', [\App\Http\Controllers\PembeliansController::class, 'show']);
		Route::get('pembelians/{faktur_beli_id}', [\App\Http\Controllers\PembeliansController::class, 'create']);
		Route::get('pembelians/{faktur_beli_id}/edit', [\App\Http\Controllers\PembeliansController::class, 'edit']);
		Route::post('pembelians/{id}', [\App\Http\Controllers\PembeliansController::class, 'update']);

		Route::get('coas/get/coa_name', [\App\Http\Controllers\CoasController::class, 'getCoaName']);
		Route::get('coas', [\App\Http\Controllers\CoasController::class, 'index']);
		Route::get('coas/create', [\App\Http\Controllers\CoasController::class, 'create']);
		Route::post('coas', [\App\Http\Controllers\CoasController::class, 'store']);
		Route::get('coas/{id}/edit', [\App\Http\Controllers\CoasController::class, 'edit']);
		Route::put('coas/{id}', [\App\Http\Controllers\CoasController::class, 'update']);
		Route::post('coas/cek_coa_sama', [\App\Http\Controllers\CoasController::class, 'cekCoaSama']);
		Route::post('/coas/cek_coa_sama_edit', [\App\Http\Controllers\CoasController::class, 'cekCoaSamaEdit']);

		Route::post('coas/{id}', [\App\Http\Controllers\CoasController::class, 'update']);
		Route::get('pengeluarans/service_acs', [\App\Http\Controllers\ServiceAcsController::class, 'create']);
		Route::get('pengeluarans/service_acs/{id}', [\App\Http\Controllers\ServiceAcsController::class, 'show']);
		Route::post('pengeluarans/service_acs', [\App\Http\Controllers\ServiceAcsController::class, 'store']);
		Route::get('pengeluarans/gojek', [\App\Http\Controllers\PengeluaransController::class, 'gojek']);

		Route::post('pengeluarans/list', [\App\Http\Controllers\PengeluaransController::class, 'lists']);
		Route::get('pengeluarans/belanja_bukan_obat/detail/{id}', [\App\Http\Controllers\PengeluaransController::class, 'belanjaBukanObatDetail']);
		Route::get('pengeluarans/data', [\App\Http\Controllers\PengeluaransController::class, 'data']);
		Route::post('pengeluarans/data/ajax', [\App\Http\Controllers\PengeluaransController::class, 'dataAjax']);

		Route::get('pengeluarans/show/{id}', [\App\Http\Controllers\PengeluaransController::class, 'show']);
		Route::post('pengeluarans', [\App\Http\Controllers\PengeluaransController::class, 'store']);
		Route::get('pengeluarans/nota_z', [\App\Http\Controllers\PengeluaransController::class, 'nota_z']);
		Route::get('pdfs/notaz/keluar_masuk/{id}', [\App\Http\Controllers\PengeluaransController::class, 'nota_z_keluar_masuk']);

		Route::get('pengeluarans/nota_z/detail/{id}', [\App\Http\Controllers\PengeluaransController::class, 'notaz_detail']);
		route::post('pengeluarans/nota_z', [\App\Http\Controllers\PengeluaransController::class, 'notaz_post']);
		Route::get('pengeluarans/rc', [\App\Http\Controllers\PengeluaransController::class, 'erce']);
		Route::post('pengeluarans/rc', [\App\Http\Controllers\PengeluaransController::class, 'erce_post']);
		Route::post('pengeluarans/ketkeluar', [\App\Http\Controllers\PengeluaransController::class, 'ketkeluar']);
		Route::get('pengeluarans/belanjaPeralatan/getObject/belanjaPeralatan', [\App\Http\Controllers\PengeluaransController::class, 'getBelanjaPeralatanObject']);
		Route::get('pengeluarans/input_harta', [\App\Http\Controllers\PengeluaransController::class, 'inputHarta']);
		Route::post('pengeluarans/input_harta', [\App\Http\Controllers\PengeluaransController::class, 'postInputHarta']);
		Route::get('pengeluarans/input_harta/show/{id}', [\App\Http\Controllers\PengeluaransController::class, 'showInputHarta']);
		/* Route::get('gopays', 'PengeluaransController@gopay'); */
		Route::post('pengeluarans/gojek/tambah/gopay', [\App\Http\Controllers\PengeluaransController::class, 'tambahGopay']);
		Route::post('pengeluarans/gojek/pakai', [\App\Http\Controllers\PengeluaransController::class, 'pakaiGopay']);


		Route::get('ajax/products', [\App\Http\Controllers\PengeluaransController::class, 'product']);

		Route::get('pengeluarans/bayardoker', [\App\Http\Controllers\BayarGajiController::class, 'bayar']);
		Route::get('pengeluarans/bayardoker/{id}', [\App\Http\Controllers\BayarGajiController::class, 'bayardokter']);
		Route::get('pengeluarans/bayardokter/bayar', [\App\Http\Controllers\BayarGajiController::class, 'dokterbayar']);
		Route::post('pengeluarans/bayardokter/bayar', [\App\Http\Controllers\BayarGajiController::class, 'dokterdibayar']);

		Route::get('pengeluarans/checkout/{id}', [\App\Http\Controllers\PengeluaransController::class, 'show_checkout']);
		Route::post('pengeluarans/confirm_staf', [\App\Http\Controllers\PengeluaransController::class, 'confirm_staf']);

		Route::get('pengeluarans/bayar_gaji_karyawan', [\App\Http\Controllers\BayarGajiController::class, 'bayar_gaji_karyawan']);
		Route::post('pengeluarans/bayar_gaji_karyawan', [\App\Http\Controllers\BayarGajiController::class, 'bayar_gaji']);
		Route::post('pengeluarans/bayar_gaji_karyawan/{staf_id}', [\App\Http\Controllers\BayarGajiController::class, 'bayar_gaji']);

		Route::post('pengeluarans/bayar_bonus_karyawan/{staf_id}', [\App\Http\Controllers\PengeluaransController::class, 'bayar_bonus']);

		Route::get('pengeluarans/bagi_hasil_gigi', [\App\Http\Controllers\PengeluaransController::class, 'bagiHasilGigi']);
		Route::post('pengeluarans/bagi_hasil_gigi', [\App\Http\Controllers\PengeluaransController::class, 'bagiHasilGigiPost']);
		Route::delete('pengeluarans/bagi_hasil_gigi/{id}', [\App\Http\Controllers\PengeluaransController::class, 'bagiHasilGigiDelete']);

		Route::get('pengeluarans/gaji_dokter_gigi', [\App\Http\Controllers\BayarGajiController::class, 'gajiDokterGigi']);

		Route::post('pengeluarans/gaji_dokter_gigi/bayar', [\App\Http\Controllers\BayarGajiController::class, 'gajiDokterGigiBayar']);
		Route::get('pengeluarans/gaji_dokter_gigi/edit/{id}', [\App\Http\Controllers\BayarGajiController::class, 'gajiDokterGigiEdit']);
		Route::put('pengeluarans/gaji_dokter_gigi/update/{id}', [\App\Http\Controllers\BayarGajiController::class, 'gajiDokterGigiUpdate']);
		Route::get('pengeluarans/peralatans', [\App\Http\Controllers\PengeluaransController::class, 'peralatans']);
		Route::get('pengeluarans/peralatans/golongan_peralatans/create', [\App\Http\Controllers\PengeluaransController::class, 'GolonganPeralatanCreate']);
		Route::post('pengeluarans/peralatans/golongan_peralatans/store', [\App\Http\Controllers\PengeluaransController::class, 'GolonganPeralatanPost']);

		Route::get('pengeluarans/peralatans/detail/{id}', [\App\Http\Controllers\PengeluaransController::class, 'peralatan_detail']);
		Route::get('pengeluarans/belanja/peralatan', [\App\Http\Controllers\PengeluaransController::class, 'belanjaPeralatan']);
		Route::post('pengeluarans/belanja/peralatan/bayar', [\App\Http\Controllers\PengeluaransController::class, 'belanjaPeralatanBayar']);
		Route::get('pengeluarans/{id}', [\App\Http\Controllers\PengeluaransController::class, 'index']);

		Route::get('belanjalist', [\App\Http\Controllers\BelanjaListsController::class, 'index']);

		Route::get('prolanis', [\App\Http\Controllers\PesertaBpjsPerbulanController::class, 'index']); 
		Route::delete('prolanis/{id}', [\App\Http\Controllers\PesertaBpjsPerbulanController::class, 'destroy']); 
		Route::get('prolanis/verifikasi/{date}', [\App\Http\Controllers\ProlanisController::class, 'verifikasi']); 


		Route::post('prolanis', [\App\Http\Controllers\ProlanisController::class, 'store']);
		Route::get('prolanis/terdaftar', [\App\Http\Controllers\ProlanisController::class, 'terdaftar']);
		Route::get('prolanis/create/{id}', [\App\Http\Controllers\ProlanisController::class, 'create']);
		Route::get('prolanis/{id}/edit', [\App\Http\Controllers\ProlanisController::class, 'edit']);
		Route::put('prolanis/{id}', [\App\Http\Controllers\ProlanisController::class, 'update']);
		Route::post('prolanis/destroy/{id}', [\App\Http\Controllers\ProlanisController::class, 'destroy']);

		Route::get('fakturbelanjas', [\App\Http\Controllers\FakturBelanjasController::class, 'index']);
		Route::get('fakturbelanjas/obat', [\App\Http\Controllers\FakturBelanjasController::class, 'obat']);
		Route::get('fakturbelanjas/alat', [\App\Http\Controllers\FakturBelanjasController::class, 'alat']);
		Route::get('fakturbelanjas/serviceAc', [\App\Http\Controllers\FakturBelanjasController::class, 'serviceAc']);
		Route::post('fakturbelanjas', [\App\Http\Controllers\FakturBelanjasController::class, 'store']);
		Route::post('faktur_belanjas/upload_bukti_transfer/{id}', [\App\Http\Controllers\FakturBelanjasController::class, 'uploadBuktiTransfer']);




		Route::get('nota_juals', [\App\Http\Controllers\NotaJualsController::class, 'index']);
		Route::get('nota_juals/{id}', [\App\Http\Controllers\NotaJualsController::class, 'show']);
		Route::get('nota_juals/{id}/edit', [\App\Http\Controllers\NotaJualsController::class, 'edit']);

		Route::get('sops/{icd10}/{diagnosa_id}/{asuransi_id}/{berat_badan_id}', [\App\Http\Controllers\SopsController::class, 'index']);
		Route::post('sops', [\App\Http\Controllers\SopsController::class, 'store']);

		//membuat rak baru berdasarkan formula_id
		Route::get('create/raks/{id}', [\App\Http\Controllers\CustomController::class, 'create_rak']);
		Route::get('mereks/buyhistory/{id}', [\App\Http\Controllers\CustomController::class, 'buyhistory']);

		//membuat merek baru berdasyararkan merek_id
		Route::get('create/mereks/{id}', [\App\Http\Controllers\CustomController::class, 'create_merek']);

		
		Route::get('peralatans/konfirmasi', [\App\Http\Controllers\JurnalUmumsController::class, 'peralatan']);
		Route::post('peralatans/konfirmasi', [\App\Http\Controllers\JurnalUmumsController::class, 'postPeralatan']);
		Route::get('service_ac/konfirmasi', [\App\Http\Controllers\JurnalUmumsController::class, 'serviceAc']);
		Route::post('service_ac/konfirmasi', [\App\Http\Controllers\JurnalUmumsController::class, 'postServiceAc']);


		Route::get('buku_besars', [\App\Http\Controllers\BukuBesarsController::class, 'index']);
		Route::get('buku_besars/show', [\App\Http\Controllers\BukuBesarsController::class, 'show']);
		
		Route::get('perbaikantrxs', [\App\Http\Controllers\PerbaikantrxsController::class, 'index']);
		Route::get('perbaikantrxs/show', [\App\Http\Controllers\PerbaikantrxsController::class, 'show']);

		Route::get('perbaikanreseps/show', [\App\Http\Controllers\PerbaikanresepsController::class, 'show']);

		Route::get('perujuks', [\App\Http\Controllers\PerujuksController::class, 'index']);
		Route::get('perujuks/create', [\App\Http\Controllers\PerujuksController::class, 'create']);
		Route::post('perujuks/ajax/create', [\App\Http\Controllers\PerujuksController::class, 'ajaxcreate']);
		Route::get('perujuks/{id}/edit', [\App\Http\Controllers\PerujuksController::class, 'edit']);
		Route::post('perujuks', [\App\Http\Controllers\PerujuksController::class, 'store']);
		Route::put('perujuks/{id}', [\App\Http\Controllers\PerujuksController::class, 'update']);
		Route::delete('perujuks/{id}', [\App\Http\Controllers\PerujuksController::class, 'destroy']);
		Route::get('pendapatans', [\App\Http\Controllers\PendapatansController::class, 'index']);
		Route::post('pendapatans/pembayaran/asuransi', [\App\Http\Controllers\PendapatansController::class, 'asuransi_bayar']);
		Route::get('pendapatans/create', [\App\Http\Controllers\PendapatansController::class, 'create']);
		Route::post('pendapatans/index', [\App\Http\Controllers\PendapatansController::class, 'store']);
		Route::get('pendapatans/pembayaran/asuransi', [\App\Http\Controllers\PendapatansController::class, 'pembayaran_asuransi']);
		Route::post('pendapatans/pembayaran/asuransi/delete', [\App\Http\Controllers\PendapatansController::class, 'delete_pembayaran_asuransi']);
 
		Route::get('pendapatans/pembayaran_asuransi/cari_pembayaran', [\App\Http\Controllers\PendapatansController::class, 'cariPembayaran']);
		Route::get('pendapatans/pembayaran/asuransi/{id}', [\App\Http\Controllers\PendapatansController::class, 'pembayaran_asuransi_rekening']);
		Route::get('pengeluarans/pembayaran_asuransi/show ', [\App\Http\Controllers\PendapatansController::class, 'lihat_pembayaran_asuransi']);

		Route::get('pengeluarans/pembayaran_asuransi/show/{id}', [\App\Http\Controllers\PendapatansController::class, 'lihat_pembayaran_asuransi_by_rekening']);
		Route::get('pendapatans/pembayaran_bpjs ', [\App\Http\Controllers\PendapatansController::class, 'pembayaran_bpjs']);
		Route::post('pendapatans/pembayaran_bpjs', [\App\Http\Controllers\PendapatansController::class, 'pembayaran_bpjs_post']);
		Route::get('pendapatans/pembayaran/asuransi/show/{id}', [\App\Http\Controllers\PendapatansController::class, 'pembayaran_asuransi_show']);
		Route::post('pendapatans/pembayaran/asuransis/riwayatHutang', [\App\Http\Controllers\AsuransisController::class, 'riwayatHutangByParameterGrouped']);
		Route::post('pendapatans/pembayaran/asuransis/riwayatHutang/bulanan', [\App\Http\Controllers\AsuransisController::class, 'riwayatHutangByParameterGroupedBulanan']);
		Route::get('pendapatans/pembayaran_show/detail/piutang_asuransis', [\App\Http\Controllers\PendapatansController::class, 'detailPA']);


		Route::get('laporans', [\App\Http\Controllers\LaporansController::class, 'index']);

		Route::post('laporans/dispensing/bpjs/dokter', [\App\Http\Controllers\LaporansController::class, 'dispensingBpjs']);
		Route::get('laporans/angka_kontak_belum_terpenuhi', [\App\Http\Controllers\LaporansController::class, 'angkaKontakBelumTerpenuhi']);
		Route::get('laporans/angka_kontak_bpjs_bulan_ini', [\App\Http\Controllers\LaporansController::class, 'angkaKontakBpjsBulanIni']);
		Route::get('laporans/angka_kontak_bpjs', [\App\Http\Controllers\LaporansController::class, 'angkaKontakBpjs']);
		Route::get('laporans/kunjungan_sakit', [\App\Http\Controllers\LaporansController::class, 'KunjunganSakitBpjs']);

		Route::get('laporans/pengantar', [\App\Http\Controllers\LaporansController::class, 'pengantar']);
		Route::get('laporans/harian', [\App\Http\Controllers\LaporansController::class, 'harian']);
		Route::post('laporans/harian/update_asuransi', [\App\Http\Controllers\LaporansController::class, 'updateAsuransi']);

		Route::get('laporans/haridet', [\App\Http\Controllers\LaporansController::class, 'haridet']);
		Route::get('laporans/harikas', [\App\Http\Controllers\LaporansController::class, 'harikas']);
		Route::get('laporans/bulanan', [\App\Http\Controllers\LaporansController::class, 'bulanan']);
		Route::get('laporans/tanggal', [\App\Http\Controllers\LaporansController::class, 'tanggal']);
		Route::get('laporans/detbulan', [\App\Http\Controllers\LaporansController::class, 'detbulan']);
		Route::get('laporans/payment/{id}', [\App\Http\Controllers\LaporansController::class, 'payment']);
		Route::get('laporans/penyakit', [\App\Http\Controllers\LaporansController::class, 'penyakit']);
		Route::get('laporans/status', [\App\Http\Controllers\LaporansController::class, 'status']);
		Route::get('laporans/points', [\App\Http\Controllers\LaporansController::class, 'points']);
		Route::get('laporans/rujukankebidanan', [\App\Http\Controllers\LaporansController::class, 'rujukankebidanan']);
		Route::get('laporans/bayardokter', [\App\Http\Controllers\LaporansController::class, 'bayardokter']);
		Route::post('laporans/pendapatan', [\App\Http\Controllers\LaporansController::class, 'pendapatan']);
		Route::post('laporans/payment', [\App\Http\Controllers\LaporansController::class, 'paymentpost']);
		Route::get('laporans/pembayaran/dokter', [\App\Http\Controllers\LaporansController::class, 'pembayarandokter']);
		Route::get('laporans/no_asisten', [\App\Http\Controllers\LaporansController::class, 'no_asisten']);
		Route::get('laporans/gigi', [\App\Http\Controllers\LaporansController::class, 'gigiBulanan']);
		Route::get('laporans/anc', [\App\Http\Controllers\LaporansController::class, 'anc']);
		Route::get('laporans/kb', [\App\Http\Controllers\LaporansController::class, 'kb']);
		Route::get('laporans/jumlahPasien', [\App\Http\Controllers\LaporansController::class, 'jumlahPasien']);
		Route::get('laporans/jumlahIspa', [\App\Http\Controllers\LaporansController::class, 'jumlahIspa']);
		Route::get('laporans/jumlahDiare', [\App\Http\Controllers\LaporansController::class, 'jumlahDiare']);
		Route::get('laporans/hariandanjam', [\App\Http\Controllers\LaporansController::class, 'hariandanjam']);
		Route::get('laporans/bpjs_tidak_terpakai/{bulanTahun}', [\App\Http\Controllers\LaporansController::class, 'bpjsTidakTerpakai']);
		Route::get('laporans/sms/bpjs', [\App\Http\Controllers\LaporansController::class, 'smsBpjs']);

		Route::get('pajaks/amortisasi', [\App\Http\Controllers\PajaksController::class, 'amortisasi']);
		Route::post('pajaks/amortisasiPost', [\App\Http\Controllers\PajaksController::class, 'amortisasiPost']);
		Route::get('pajaks/peredaran_bruto', [\App\Http\Controllers\PajaksController::class, 'peredaranBruto']);
		Route::post('pajaks/peredaran_bruto', [\App\Http\Controllers\PajaksController::class, 'peredaranBrutoPost']);
		Route::get('pajaks/peredaran_bruto/bikinan', [\App\Http\Controllers\PajaksController::class, 'peredaranBrutoBikinan']);
		Route::post('pajaks/peredaran_bruto/bikinan', [\App\Http\Controllers\PajaksController::class, 'peredaranBrutoBikinanPost']);

		Route::get('kirim_berkas', [\App\Http\Controllers\KirimBerkasController::class, 'index']);
		Route::get('kirim_berkas/create', [\App\Http\Controllers\KirimBerkasController::class, 'create']);
		Route::post('kirim_berkas', [\App\Http\Controllers\KirimBerkasController::class, 'store']);
		Route::get('kirim_berkas/cari/piutang', [\App\Http\Controllers\KirimBerkasController::class, 'cariPiutang']);
		Route::get('kirim_berkas/{id}/edit', [\App\Http\Controllers\KirimBerkasController::class, 'edit']);
		Route::get('kirim_berkas/{id}/inputNota', [\App\Http\Controllers\KirimBerkasController::class, 'inputNota']);
		Route::post('kirim_berkas/{id}/inputNota', [\App\Http\Controllers\KirimBerkasController::class, 'inputNotaPost']);
		Route::put('kirim_berkas/{id}', [\App\Http\Controllers\KirimBerkasController::class, 'update']);
		Route::delete('kirim_berkas/{id}', [\App\Http\Controllers\KirimBerkasController::class, 'destroy']);
        Route::get('ranaps', [\App\Http\Controllers\RanapsController::class, 'index']);

	//membuat merek baru berdasarkan merek_id
	Route::post('kasir/submit', [\App\Http\Controllers\KasirBaseController::class, 'kasir_submit']);
	Route::get('kasir/keluar_masuk_kasir', [\App\Http\Controllers\KasirsController::class, 'keluar_masuk_kasir']);

	//update tarif berdasarkan tarif_id
	Route::post('update/tarifs/', [\App\Http\Controllers\CustomController::class, 'updtrf']);

	Route::post('monitor/avail', [\App\Http\Controllers\CustomController::class, 'mon_avail']);
	Route::post('monitor/survey', [\App\Http\Controllers\CustomController::class, 'survey_available']);

	//ajax untuk survey pasien
	Route::post('update/surveys/send_id', [\App\Http\Controllers\CustomController::class, 'send_id']);
	Route::get('/survey/kepuasan/pelanggan', [\App\Http\Controllers\PeriksasController::class, 'surveyKepuasan']);


	//update tarif berdasarkan tarif_id
	Route::post('update/kembali/{id}', [\App\Http\Controllers\CustomController::class, 'kembali']);
	Route::post('update/kembali2/{id}', [\App\Http\Controllers\CustomController::class, 'kembali2']);
	Route::post('update/kembali3/{id}', [\App\Http\Controllers\CustomController::class, 'kembali3']);


	//masuk survey
	Route::get('update/surveys/{id}', [\App\Http\Controllers\CustomController::class, 'survey']);
	Route::post('update/surveys', [\App\Http\Controllers\CustomController::class, 'survey_post']);
	Route::post('update/surveys/conf', [\App\Http\Controllers\CustomController::class, 'confirmed']);

	// controller untuk monitor pasien

	Route::get('monitors/index', [\App\Http\Controllers\MonitorsController::class, 'index']);
	Route::post('monitors/puas', [\App\Http\Controllers\MonitorsController::class, 'puas']);
	Route::post('monitors/biasa', [\App\Http\Controllers\MonitorsController::class, 'biasa']);
	Route::post('monitors/kecewa', [\App\Http\Controllers\MonitorsController::class, 'kecewa']);
	Route::post('monitors/buatIdPeriksaNol', [\App\Http\Controllers\MonitorsController::class, 'buatIdPeriksaNol']);

	Route::get('piutang_dibayars/{id}/edit', [\App\Http\Controllers\PiutangDibayarController::class, 'edit']);
	Route::put('piutang_dibayars/{id}', [\App\Http\Controllers\PiutangDibayarController::class, 'update']);

	Route::get('obat/stokmin', [\App\Http\Controllers\ObatsController::class, 'index']);
	Route::get('obat/fast_moving', [\App\Http\Controllers\ObatsController::class, 'fast_moving']);
	Route::get("obat/fast_moving/ajax", [\App\Http\Controllers\ObatsController::class, 'fast_moving_ajax']);

	//update tarif berdasarkan tarif_id
	Route::post('delete/faktur_belis', [\App\Http\Controllers\CustomController::class, 'del_fak_beli']);

	Route::get('suratsakits/create/{id}/{poli}', [\App\Http\Controllers\SuratSakitsController::class, 'create']);
	Route::get('suratsakits/{id}/edit/{poli}', [\App\Http\Controllers\SuratSakitsController::class, 'edit']);
	Route::get('suratsakits/show/{id}', [\App\Http\Controllers\SuratSakitsController::class, 'show']);
	Route::post('suratsakits/{poli}', [\App\Http\Controllers\SuratSakitsController::class, 'store']);
	Route::put('suratsakits/{id}/{poli}', [\App\Http\Controllers\SuratSakitsController::class, 'update']);
	Route::get('suratsakits/delete/{id}/{poli}', [\App\Http\Controllers\SuratSakitsController::class, 'destroy']);

	Route::get('rujukans/create/{id}/{poli}', [\App\Http\Controllers\RujukansController::class, 'create']);
	Route::get('rujukans/{id}/edit/{poli}', [\App\Http\Controllers\RujukansController::class, 'edit']);
	Route::get('rujukans', [\App\Http\Controllers\RujukansController::class, 'index']);
	Route::post('rujukans/{poli}', [\App\Http\Controllers\RujukansController::class, 'store']);
	Route::put('rujukans/{id}/{poli}', [\App\Http\Controllers\RujukansController::class, 'update']);
	Route::get('rujukans/show', [\App\Http\Controllers\RujukansController::class, 'show']);
	Route::get('rujukans/{id}', [\App\Http\Controllers\RujukansController::class, 'ini']);
	Route::get('rujukans/delete/{id}/{poli}', [\App\Http\Controllers\RujukansController::class, 'destroy']);

	Route::post('rujuajax/rs', [\App\Http\Controllers\RujukansAjaxController::class, 'rs']);
	Route::post('rujuajax/rschange', [\App\Http\Controllers\RujukansAjaxController::class, 'rschange']);
	Route::post('rujuajax/tujurujuk', [\App\Http\Controllers\RujukansAjaxController::class, 'tujurujuk']);
	Route::post('anc/registerhamil', [\App\Http\Controllers\AncController::class, 'registerhamil']);
	Route::post('anc/perujx', [\App\Http\Controllers\AncController::class, 'perujx']);
	Route::post('anc/uk', [\App\Http\Controllers\AncController::class, 'uk']);

	Route::post('poli/ajax/ibusafe', [\App\Http\Controllers\PoliAjaxController::class, 'ibusafe']);
	Route::post('poli/ajax/pregsafe', [\App\Http\Controllers\PoliAjaxController::class, 'pregsafe']);
	Route::post('poli/ajax/sopterapi', [\App\Http\Controllers\PoliAjaxController::class, 'sopterapi']);
	Route::post('poli/ajax/diagcha', [\App\Http\Controllers\PoliAjaxController::class, 'diagcha']);
	Route::post('poli/ajax/indiag', [\App\Http\Controllers\PoliAjaxController::class, 'indiag']);
	Route::post('poli/ajax/insigna', [\App\Http\Controllers\PoliAjaxController::class, 'insigna']);
	Route::post('poli/ajax/selectsigna', [\App\Http\Controllers\PoliAjaxController::class, 'selectsigna']);
	Route::post('poli/ajax/selectatur', [\App\Http\Controllers\PoliAjaxController::class, 'selectatur']);
	Route::post('poli/ajax/inatur', [\App\Http\Controllers\PoliAjaxController::class, 'inatur']);
	Route::post('poli/ajax/ajxobat', [\App\Http\Controllers\PoliAjaxController::class, 'ajxobat']);
	Route::get('poli/ajax/diag', [\App\Http\Controllers\PoliAjaxController::class, 'diag']);
	Route::post('poli/ajax/pilih', [\App\Http\Controllers\PoliAjaxController::class, 'pilih']);
	Route::post('poli/ajax/kkchange', [\App\Http\Controllers\PoliAjaxController::class, 'kkchange']);
	Route::post('poli/ajax/asuridchange', [\App\Http\Controllers\PoliAjaxController::class, 'asuridchange']);
	Route::post('poli/ajax/bhp_tindakan', [\App\Http\Controllers\PoliAjaxController::class, 'bhp_tindakan']);
	Route::post('poli/ajax/ambil_gambar', [\App\Http\Controllers\PoliAjaxController::class, 'ambil_gambar']);
	Route::post('poli/{id}/alergies', [\App\Http\Controllers\PoliAjaxController::class, 'alergiPost']);
	Route::post('poli/ajax/alergies/delete', [\App\Http\Controllers\PoliAjaxController::class, 'alergiDelete']);
	Route::get('poli/ajax/alergi/prevent', [\App\Http\Controllers\PoliAjaxController::class, 'alergiPrevent']);
	Route::get( "get/tipe_asuransi_id/from/asuransi_id", [\App\Http\Controllers\PoliAjaxController::class, 'getTipeAsuransiId']);


	Route::get('DdlMerek/alloption', [\App\Http\Controllers\DdlMerekController::class, 'alloption']);
	Route::get('DdlMerek/alloption2', [\App\Http\Controllers\DdlMerekController::class, 'alloption2']);
	Route::get('DdlMerek/optionpuyer', [\App\Http\Controllers\DdlMerekController::class, 'optionpuyer']);
	Route::get('DdlMerek/optionsyrup', [\App\Http\Controllers\DdlMerekController::class, 'optionsyrup']);

	Route::post('laporans/ajax/filter', [\App\Http\Controllers\LaporansAjaxController::class, 'filter']);

	Route::post('antrianperiksas/ajax/cekada', [\App\Http\Controllers\AntrianPeriksasAjaxController::class, 'cekada']);


	Route::post('mereks/ajax/ajaxmerek', [\App\Http\Controllers\MereksAjaxController::class, 'ajaxmerek']);

	Route::post('raks/ajax/ajaxrak', [\App\Http\Controllers\RaksAjaxController::class, 'ajaxrak']);

	Route::post('formulas/ajax/ajaxformula', [\App\Http\Controllers\FormulasAjaxController::class, 'ajaxformula']);

	Route::get('poli/{id}', [\App\Http\Controllers\PolisController::class, 'poli']);
	Route::get('poli/ajax/panggil_pasien', [\App\Http\Controllers\PolisController::class, 'panggilPasienAjax']);

	Route::get('kasir/{id}', [\App\Http\Controllers\KasirBaseController::class, 'kasir']);
	Route::post('kasir/onchange', [\App\Http\Controllers\KasirBaseController::class, 'onchange']);
	Route::post('kasir/changemerek', [\App\Http\Controllers\KasirBaseController::class, 'changemerek']);
	Route::post('kasir/updatejumlah', [\App\Http\Controllers\KasirBaseController::class, 'updatejumlah']);

	Route::get('pasiens/ajax/ajaxpasiens', [\App\Http\Controllers\PasiensAjaxController::class, 'ajaxpasiens']);
	Route::post('pasiens/ajax/ajaxpasien', [\App\Http\Controllers\PasiensAjaxController::class, 'ajaxpasien']);
	Route::post('pasiens/ajax/create', [\App\Http\Controllers\PasiensAjaxController::class, 'create']);
	Route::post('pasiens/ajax/cekbpjskontrol', [\App\Http\Controllers\PasiensAjaxController::class, 'cekbpjskontrol']);
	Route::post('pasiens/ajax/confirm_staf', [\App\Http\Controllers\PasiensAjaxController::class, 'confirm_staf']);
	Route::get('pasiens/ajax/cari', [\App\Http\Controllers\PasiensAjaxController::class, 'cariPasien']);
	Route::post('pasiens/ajax/cekantrian/tanggal', [\App\Http\Controllers\PasiensAjaxController::class, 'cekAntrianPerTanggal']);
	Route::get('pasiens/ajax/cekPromo', [\App\Http\Controllers\PasiensAjaxController::class, 'cekPromo']);
	Route::get('pasiens/ajax/status_cel_gds_bulan_ini', [\App\Http\Controllers\PasiensAjaxController::class, 'statusCekGDSBulanIni']);
	Route::get('pasiens/ajax/cari/pasien', [\App\Http\Controllers\PasiensMergeController::class, 'cariPasien']);
	Route::post('pasiens/ajax/cari/pasien', [\App\Http\Controllers\PasiensMergeController::class, 'cariPasienPost']);


	Route::get('pasiens/gabungkan/pasien/ganda', [\App\Http\Controllers\PasiensMergeController::class, 'index']);
	Route::get('pasiens/gabungkan/pasien/ganda/select', [\App\Http\Controllers\PasiensMergeController::class, 'searchPasien']);


	Route::get('kasirs/saldo', [\App\Http\Controllers\KasirsController::class, 'saldo']);
	Route::post('kasirs/saldo', [\App\Http\Controllers\KasirsController::class, 'saldoPost']);

	Route::get('usgs/{id}', [\App\Http\Controllers\UsgsController::class, 'show']);
	Route::get('ancs/{id}', [\App\Http\Controllers\AncsController::class, 'show']);


	Route::get('ruangperiksa/{jenis_antrian_id}', [\App\Http\Controllers\RuangPeriksaController::class, 'index']);
	Route::post('ruangperiksa/ruangan', [\App\Http\Controllers\RuangPeriksaController::class, 'ruangan']);


	Route::get('/home_visits/ajax/angka_kontak_bpjs', [\App\Http\Controllers\HomeVisitController::class, 'searchAjax']);
	Route::get('home_visit/create/pasien/{id}', [\App\Http\Controllers\HomeVisitController::class, 'createPasien']);

	Route::resource('home_visits', \App\Http\Controllers\HomeVisitController::class);
	Route::resource('setor_tunais', \App\Http\Controllers\SetorTunaiController::class);

    Route::get('stafs/{id}/jumlah_pasien/pertahun/{tahun}/pdf', [\App\Http\Controllers\PdfsController::class, 'jumlahPasienPerTahun']);
	Route::get('pdfs/amortisasi/{tahun}', [\App\Http\Controllers\PdfsController::class, 'amortisasi']);
	Route::get('pdfs/peredaranBruto/{tahun}', [\App\Http\Controllers\PdfsController::class, 'peredaranBruto']);
	Route::get('pdfs/status/{periksa_id}', [\App\Http\Controllers\PdfsController::class, 'status']);
	Route::get('pdfs/label_obat/{periksa_id}', [\App\Http\Controllers\PdfsController::class, 'label_obat']);
	Route::get('pdfs/bagi_hasil_gigi/{id}', [\App\Http\Controllers\PdfsController::class, 'bagiHasilGigi']);
	Route::get('pdfs/status/a4/{periksa_id}', [\App\Http\Controllers\PdfsController::class, 'status_a4']);
	Route::get('pdfs/dispensing/{rak_id}/{mulai}/{akhir}', [\App\Http\Controllers\PdfsController::class, 'dispensing']);
	Route::get('pdfs/kuitansi/{periksa_id}', [\App\Http\Controllers\PdfsController::class, 'kuitansi']);
	Route::get('pdfs/struk/{periksa_id}', [\App\Http\Controllers\PdfsController::class, 'struk']);
	Route::get('pdfs/pembelian/{faktur_belanja_id}', [\App\Http\Controllers\PdfsController::class, 'pembelian']);
	Route::get('pdfs/penjualan/{nota_jual_id}', [\App\Http\Controllers\PdfsController::class, 'penjualan']);
	Route::get('pdfs/pendapatan/{nota_jual_id}', [\App\Http\Controllers\PdfsController::class, 'pendapatan']);
	Route::get('pdfs/pembayaran_asuransi/{pembayaran_asuransi_id}', [\App\Http\Controllers\PdfsController::class, 'pembayaran_asuransi']);
	Route::get('pdfs/notaz/{checkout_kasir_id}', [\App\Http\Controllers\PdfsController::class, 'notaz']);
	Route::get('pdfs/rc/{modal_id}', [\App\Http\Controllers\PdfsController::class, 'rc']);
	Route::get('pdfs/bayar_gaji_karyawan/{bayar_gaji_id}', [\App\Http\Controllers\PdfsController::class, 'bayar_gaji_karyawan']);
	Route::get('pdfs/ns/{no_sale_id}', [\App\Http\Controllers\PdfsController::class, 'ns']);
	Route::get('pdfs/pengeluaran/{id}', [\App\Http\Controllers\PdfsController::class, 'pengeluaran']);
	Route::get('pdfs/formulir/usg/{id}/{asuransi_id}', [\App\Http\Controllers\PdfsController::class, 'formUsg']);
	Route::get('pdfs/merek', [\App\Http\Controllers\PdfsController::class, 'merek']);
	Route::get('pdfs/laporan_laba_rugi/{tahun_awal}/{tanggal_akhir}', [\App\Http\Controllers\PdfsController::class, 'laporanLabaRugi']);
	Route::get('pdfs/laporan_laba_rugi/bikinan/{tahun_awal}/{tanggal_akhir}', [\App\Http\Controllers\PdfsController::class, 'laporanLabaRugiBikinan']);
	Route::get('pdfs/laporan_neraca/{tahun}', [\App\Http\Controllers\PdfsController::class, 'laporanNeraca']);
	Route::get('pdfs/jurnal_umum/{bulan}/{tahun}', [\App\Http\Controllers\PdfsController::class, 'jurnalUmum']);
	Route::get('pdfs/buku_besar/{bulan}/{tahun}/{coa_id}', [\App\Http\Controllers\PdfsController::class, 'jurnalUmum']);
	Route::get('pdfs/kuitansiPerBulan/{bulan}/{tahun}', [\App\Http\Controllers\PdfsController::class, 'kuitansiPerBulan']);
	Route::get('pdfs/struk/perbulan/{bulan}/{tahun}', [\App\Http\Controllers\PdfsController::class, 'strukPerBulan']);
	Route::get('pdfs/struk/pertanggal/{tahun}/{bulan}/{tanggal}', [\App\Http\Controllers\PdfsController::class, 'strukPerTanggal']);
	Route::get('pdfs/piutang/belum_dibayar/{id}/{mulai}/{akhir}', [\App\Http\Controllers\PdfsController::class, 'piutangAsuransiBelumDibayar']);
	Route::get('pdfs/piutang/sudah_dibayar/{id}/{mulai}/{akhir}', [\App\Http\Controllers\PdfsController::class, 'piutangAsuransiSudahDibayar']);
	Route::get('pdfs/piutang/semua/{id}/{mulai}/{akhir}', [\App\Http\Controllers\PdfsController::class, 'piutangAsuransi']);
	Route::get('pdfs/kirim_berkas/{id}', [\App\Http\Controllers\PdfsController::class, 'kirim_berkas']);
	Route::get('pdfs/antrian/{id}', [\App\Http\Controllers\PdfsController::class, 'antrian']);
	Route::get('pdfs/prolanis_hipertensi_perbulan/{bulanTahun}', [\App\Http\Controllers\PdfsController::class, 'prolanisHipertensiPerBulan']);
	Route::get('pdfs/prolanis_dm_perbulan/{bulanTahun}', [\App\Http\Controllers\PdfsController::class, 'prolanisDmPerBulan']);
	Route::get('pdfs/rapid/antigen/{periksa_id}', [\App\Http\Controllers\PdfsController::class, 'hasilAntigen']);
	Route::get('pdfs/rapid/antibodi/{periksa_id}', [\App\Http\Controllers\PdfsController::class, 'hasilAntibodi']);


	Route::get('no_sales', [\App\Http\Controllers\NoSalesController::class, 'index']);
	Route::post('no_sales', [\App\Http\Controllers\NoSalesController::class, 'store']);

	Route::get('stokopnames', [\App\Http\Controllers\StokOpnamesController::class, 'index']);
	Route::post('stokopnames', [\App\Http\Controllers\StokOpnamesController::class, 'store']);
	Route::post('stokopnames/awal', [\App\Http\Controllers\StokOpnamesController::class, 'awal']);
	Route::post('stokopnames/change', [\App\Http\Controllers\StokOpnamesController::class, 'change']);
	Route::post('stokopnames/destroy', [\App\Http\Controllers\StokOpnamesController::class, 'destroy']);


	Route::get('terapis/{periksa_id}', [\App\Http\Controllers\TerapisController::class, 'index']);
	Route::post('test/getmereks', [\App\Http\Controllers\CustomController::class, 'getmereks']);

	Route::get('sms', [\App\Http\Controllers\SmsController::class, 'sms']);
	Route::post('sms', [\App\Http\Controllers\SmsController::class, 'smsPost']);
	Route::get('sms/angkakontak', [\App\Http\Controllers\SmsController::class, 'angkakontak']);
	Route::get('sms/kontak/ulangi', [\App\Http\Controllers\SmsController::class, 'kontakulangi']);
	Route::get('sms/kontak/anulir_no_telp/{id}', [\App\Http\Controllers\SmsController::class, 'kontakanulir']);
	Route::get('sms/kontak/hapus/{id}', [\App\Http\Controllers\SmsController::class, 'kontakhapus']);
	Route::get('sms/gagal/ulangi', [\App\Http\Controllers\SmsController::class, 'gagalulangi']);
	Route::get('sms/gagal/anulir_no_telp/{id}', [\App\Http\Controllers\SmsController::class, 'gagalanulir']);
	Route::get('sms/gagal/hapus/{id}', [\App\Http\Controllers\SmsController::class, 'gagalhapus']);
	Route::post('laporans/sms/kontak/action', [\App\Http\Controllers\SmsController::class, 'smsKontakPost']);
	Route::post('laporans/sms/gagal/action', [\App\Http\Controllers\SmsController::class, 'smsGagalPost']);
	Route::post('laporans/sms/masuk/action', [\App\Http\Controllers\SmsController::class, 'smsMasukPost']);


	Route::resource('configs', \App\Http\Controllers\ConfigsController::class);

	Route::get('gammu/inbox', [\App\Http\Controllers\GammuController::class, 'inbox']);
	Route::get('gammu/outbox', [\App\Http\Controllers\GammuController::class, 'outbox']);

	Route::get('gammu/pesanMasuk', [\App\Http\Controllers\GammuController::class, 'pesanMasuk']);
	Route::get('gammu/pesanKeluar', [\App\Http\Controllers\GammuController::class, 'pesanKeluar']);

	Route::get('gammu/sentitems', [\App\Http\Controllers\GammuController::class, 'sentitems']);

	Route::get('gammu/create/sms', [\App\Http\Controllers\GammuController::class, 'createSms']);
	Route::post('gammu/send/sms', [\App\Http\Controllers\GammuController::class, 'sendSms']);
	Route::get('gammu/reply/{SenderNumber}', [\App\Http\Controllers\GammuController::class, 'reply']);
	Route::delete('gammu/{id}/delete', [\App\Http\Controllers\GammuController::class, 'destroy']);

	Route::get('master/ajax/antrianTerakhir', [\App\Http\Controllers\MasterController::class, 'antrianTerakhir']);

	Route::get('discounts', [\App\Http\Controllers\DiscountsController::class, 'index']);
	Route::post('discounts', [\App\Http\Controllers\DiscountsController::class, 'store']);
	Route::get('discounts/create', [\App\Http\Controllers\DiscountsController::class, 'create']);
	Route::get('discounts/{id}/edit', [\App\Http\Controllers\DiscountsController::class, 'edit']);
	Route::get('discounts/{id}/delete', [\App\Http\Controllers\DiscountsController::class, 'delete']);
	Route::put('discounts/{id}', [\App\Http\Controllers\DiscountsController::class, 'update']);
	Route::get('promo/kecantikan/ktp/pertahun', [\App\Http\Controllers\DiscountsController::class, 'promoKtpPertahun']);
	Route::post('promo/kecantikan/ktp/pertahun', [\App\Http\Controllers\DiscountsController::class, 'promoKtpPertahunPost']);

	Route::get('acs', [\App\Http\Controllers\AcsController::class, 'index']);
	Route::get('acs/create', [\App\Http\Controllers\AcsController::class, 'create']);
	Route::get('acs/{id}/edit', [\App\Http\Controllers\AcsController::class, 'edit']);
	Route::put('acs/{id}', [\App\Http\Controllers\AcsController::class, 'update']);
	Route::delete('acs/{id}', [\App\Http\Controllers\AcsController::class, 'destroy']);
	Route::post('acs', [\App\Http\Controllers\AcsController::class, 'store']);
	Route::get('hutang_asuransi/{year}', [\App\Http\Controllers\AsuransisController::class, 'hutang']);
	Route::get('hutang_asuransi/{bulan}/{tahun}', [\App\Http\Controllers\AsuransisController::class, 'hutangPerBulan']);
	Route::get('tunggakan_asuransi/{year}', [\App\Http\Controllers\AsuransisController::class, 'tunggakan']);

	Route::get('bahan_bangunans/konfirmasi/{bulan}/{tahun}', [\App\Http\Controllers\BahanBangunansController::class, 'konfirmasi']);
	Route::get('bahan_bangunans/ikhtisarkan', [\App\Http\Controllers\BahanBangunansController::class, 'ikhtisarkan']);
	Route::post('bahan_bangunans/ikhtisarkan', [\App\Http\Controllers\BahanBangunansController::class, 'ikhtisarkanPost']);
	Route::post('bahan_bangunans/konfirmasi/{bulan}/{tahun}', [\App\Http\Controllers\BahanBangunansController::class, 'konfirmasiPost']);
	Route::get('stafs/{id}/terapi', [\App\Http\Controllers\CustomController::class, 'terapi']);

	Route::get('laporans/pengantar_pasien', [\App\Http\Controllers\LaporansController::class, 'PengantarPasienBpjs']);
	Route::get('pasiens/ajax/angka_kontak_bpjs', [\App\Http\Controllers\AngkaKontakController::class, 'searchAjax']);
	Route::get('/pasiens/ajax/kunjungan_sakit_bpjs', [\App\Http\Controllers\KunjunganSakitController::class, 'searchAjax']);
	Route::get('/pasiens/ajax/kunjungan_sehat_bpjs', [\App\Http\Controllers\KunjunganSehatController::class, 'searchAjax']);
	Route::get('/pasiens/ajax/angka_kontak_bpjs_bulan_ini', [\App\Http\Controllers\AngkaKontakBpjsBulanIniController::class, 'searchAjax']);



});
