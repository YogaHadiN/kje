<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
*/





Route::get('queue', function(){
	dispatch(new \App\Jobs\compressImage );
});
Route::get('/', 'AuthController@index');
Route::get('login', 'AuthController@index')->name('login');
Route::get('logout', 'AuthController@logout');
Route::post('login', 'AuthController@login');
Route::get('jangan', 'PolisController@jangan');


Route::get('antrians', 'AntriansController@create');
Route::post('antrians/print', 'AntriansController@store');

Route::get('fasilitas/antrian_pasien', 'FasilitasController@antrian_pasien'); //antrian pasien
Route::put('fasilitas/konfirmasi', 'FasilitasController@konfirmasi'); //antrian pasien
Route::get('fasilitas/antrian_pasien/{poli}', 'FasilitasController@input_tgl_lahir'); //antrian pasien
Route::post('fasilitas/antrian_pasien/{poli}/tanggal', 'FasilitasController@post_tgl_lahir'); //antrian pasien
Route::get('fasilitas/antrian_pasien/{poli}/tanggal/{pasien_id}', 'FasilitasController@cari_pasien'); //cari_pasien
Route::post('fasilitas/antrian_pasien/{poli}/tanggal/{pasien_id}', 'FasilitasController@cari_asuransi'); //cari_pasien
Route::get('fasilitas/antrian_pasien/{poli}/{tanggal_lahir}', 'FasilitasController@post_tgl_lahir'); //antrian pasien
Route::get('fasilitas/input_telp', 'FasilitasController@input_telp'); //antrian pasien
Route::get('fasilitas/survey', 'FasilitasController@survey'); //survey kepuasan pelanggan
Route::post('fasilitas/antrian_pasien/{poli}/tanggal/{pasien_id}/{asuransi_id}', 'FasilitasController@submit_antrian'); //cari_pasien
Route::delete('fasilitas/antrianpolis/destroy', 'FasilitasController@antrianPoliDestroy'); //cari_pasien
Route::delete('fasilitas/antrianperiksa/destroy', 'FasilitasController@antrianPeriksaDestroy'); //cari_pasien


Route::get('facebook', 'FacebookController@facebook');
Route::get('callback', 'FacebookController@callback');
Route::get('facebook/unverified', 'FacebookController@unverified');
Route::get('facebook/list', 'FacebookController@list');
Route::get('facebook/verification/{id}', 'FacebookController@verification');
Route::get('facebook/verified/{id}/{pasien_id}', 'FacebookController@verified');
Route::post('facebook', 'FacebookController@daftarkan');
Route::post('facebook/registered', 'FacebookController@daftarkanRegistered');
Route::post('facebook/verified/{fb_id}/{id}', 'FacebookController@postVerified');
Route::get('facebook/{id}/edit', 'FacebookController@edit');
Route::get('facebook/terdaftar/di_antrian_poli/{pasien_id}', 'FacebookController@registerTerdaftar');
Route::post('facebook/{id}/edit', 'FacebookController@update');
Route::delete('facebook/{id}', 'FacebookController@destroy');
Route::delete('facebook/{id}/delete', 'FacebookController@destroyOnApp');
Route::get('facebook/terdaftar/unverified/{id}/edit', 'FacebookController@terdaftarUnverifiedEdit');
Route::post('facebook/terdaftar/unverified/{id}/update', 'FacebookController@terdaftarUnverifiedUpdate');
Route::get('facebook/terdaftar/unverified/{id}', 'FacebookController@terdaftarUnverified');
Route::get('facebook/home', 'FacebookController@home');
Route::get('facebook/{id}', 'FacebookController@show');
Route::get('facebook/input_pasien_baru/{id}', 'FacebookController@inputPasienBaru');
Route::post('facebook/input_pasien_baru/{id}', 'FacebookController@postPasienBaru');
Route::delete('facebook/antrian_polis/{id}', 'FacebookController@destroyAntrianPoli');



Route::get('phpinfo', 'PhpController@index');
Route::get('periksa/{id}/images', 'ImagesController@create');
Route::post('periksa/{id}/images', 'ImagesController@store');
Route::get('periksa/{id}/images/edit', 'ImagesController@edit');
Route::put('periksa/{id}/images', 'ImagesController@update');
Route::get('images/result', 'ImagesController@result');

Route::get('antrianperiksa/{id}/images', 'ImagesAntrianPeriksaController@create');
Route::post('antrianperiksa/{id}/images', 'ImagesAntrianPeriksaController@store');
Route::get('antrianperiksa/{id}/images/edit', 'ImagesAntrianPeriksaController@edit');
Route::put('antrianperiksa/{id}/images', 'ImagesAntrianPeriksaController@update');

    Route::resource('users', 'UsersController');
	Route::get('test/sms', function(){
		App\Classes\Yoga::sms('085721012351', 'test aja disini');
	});


  	Route::group(['middleware' => 'auth'], function(){



		Route::get('testaja',function(){
			return date('t');
		});

			Route::get('diagnosa/tidakdirujuk', 'TidakdirujukController@index');
			Route::get('memcached', 'MemcachedController@index');
			Route::get('memcached/data', 'MemcachedController@data');
			Route::get('perujuks/kecil', function(){
				$files = [
					'file1.jpg',
					'file2.jpg',
					'file3.jpg',
				];



			});

			Route::post('suppliers/ajax/ceknotalama', 'SuppliersAjaxController@ceknotalama');
			Route::post('suppliers/ajax/create', 'SuppliersAjaxController@create');
			Route::get('suppliers/belanja_obat', 'SupplierBelanjasController@belanja_obat');
			Route::get('suppliers/belanja_bukan_obat', 'SupplierBelanjasController@belanja_bukan_obat');
			Route::get('pasien_coba', 'PasiensCobaController@index');
			Route::get('antrian_pasien', 'SupplierBelanjasController@belanja_obat');
			Route::get('suppliers/belanja_bukan_obat', 'SupplierBelanjasController@belanja_bukan_obat');
			Route::get('antrianpolis/ajax/getGolonganProlanis', 'AntrianPolisAjaxController@getProlanis');
			Route::get('antrianpolis/pengantar/create/{id}', 'PengantarsController@pengantar');
			Route::get('antrianpolis/pengantar/{id}/edit', 'PengantarsController@pengantarEdit');
			Route::post('antrianpolis/get/kartubpjs', 'PengantarsController@kartubpjs');
			Route::post('antrianpolis/pengantar/create', 'PengantarsController@pengantarPost');
			Route::get('antrianpolis/pengantar/pasien/create', 'PengantarsController@createPasien');
			Route::post('antrianpolis/pengantar/pasien/create', 'PengantarsController@storePasien');
			Route::post('antrianpolis/pengantar/pasien/create/ajax', 'PengantarsController@storePasienAjax');
			Route::post('antrianpolis/pengantar/{id}/edit', 'PengantarsController@pengantarUpdate');
			Route::get('antrianperiksas/pengantar/{id}/edit', 'PengantarsController@antrianperiksasEdit');
			Route::post('antrianperiksas/pengantar/{id}/edit', 'PengantarsController@antrianperiksasUpdate');
			Route::get('antriankasirs/pengantar/{id}/edit', 'PengantarsController@antriankasirsEdit');
			Route::post('antriankasirs/pengantar/{id}/edit', 'PengantarsController@antriankasirsUpdate');
			Route::post('laporans/pengantar', 'PengantarsController@submitPcare');
			Route::post('laporans/kunjungansakit', 'PengantarsController@postKunjunganSakit');
			Route::get('laporans/periksa/pengantar/{id}/edit', 'PengantarsController@editPengantarPeriksa');
			Route::post('laporans/periksa/pengantar/{id}', 'PengantarsController@updatePengantarPeriksa');


			Route::get('periksas/{id}/edit/transaksiPeriksa', 'PeriksaCustomController@editTransaksiPeriksa');
			Route::post('periksas/{id}/update/transaksiPeriksa', 'PeriksaCustomController@updateTransaksiPeriksa');
			Route::post('periksas/{id}/update/tunai', 'PeriksaCustomController@updateTunai');
			Route::post('periksas/{id}/update/piutang', 'PeriksaCustomController@updatePiutang');


			// dari menu users
			Route::resource('pasiens', 'PasiensController');
			Route::resource('asuransis', 'AsuransisController');
			Route::resource('diagnosas', 'DiagnosasController');
			Route::resource('suppliers', 'SuppliersController');
			Route::resource('periksas', 'PeriksasController');
			Route::resource('stafs', 'StafsController');
			Route::resource('formulas', 'FormulasController');
			Route::resource('raks', 'RaksController');
			Route::resource('mereks', 'MereksController');
			Route::resource('tarifs', 'TarifsController');
			Route::resource('komposisis', 'KomposisisController');
			Route::resource('antriankasirs', 'AntrianKasirsController');
			Route::resource('antrianpolis', 'AntrianPolisController');
			Route::resource('transaksis', 'TransaksisController');
			Route::resource('antrianperiksas', 'AntrianPeriksasController');


			Route::get('stafs/{id}/gaji', 'StafsCustomController@gaji');
			Route::get('qrcode', 'QrCodeController@index');

			Route::get('kontrols/create/{periksa_id}', 'KontrolsController@create');
			Route::post('kontrols', 'KontrolsController@store');
			Route::get('kontrols/{periksa_id}/edit', 'KontrolsController@edit');
			Route::put('kontrols/{id}', 'KontrolsController@update');
			Route::delete('kontrols/{id}', 'KontrolsController@destroy');

			Route::get('generiks', 'GeneriksController@index');
			Route::get('generiks/create', 'GeneriksController@create');
			Route::post('generiks', 'GeneriksController@store');
			Route::delete('generiks/{id}', 'GeneriksController@destroy');

			Route::get('sediaans', 'SediaansController@index');
			Route::get('sediaans/create', 'SediaansController@create');
			Route::post('sediaans', 'SediaansController@store');
			Route::delete('sediaans/{id}', 'SediaansController@destroy');

			Route::get('dispensings', 'DispensingsController@index');
			Route::get('dispensings/{rak_id}/{tanggal}', 'DispensingsController@perTanggal');

			Route::get('asuransis/riwayat/{id}', 'AsuransisExtraController@riwayat');

			Route::get('coas', 'CoasController@index');
			Route::get('coas/create', 'CoasController@create');
			Route::post('coas', 'CoasController@store');
			Route::get('coas/{id}/edit', 'CoasController@edit');
			Route::put('coas/{id}', 'CoasController@update');
			Route::post('coas/cek_coa_sama', 'CoasController@cekCoaSama');
			Route::post('/coas/cek_coa_sama_edit', 'CoasController@cekCoaSamaEdit');

			Route::post('coas/{id}', 'CoasController@update');

			Route::get('rumahsakits', 'RumahSakitsController@index'); //penjualan obat tanpa resep
			Route::get('rumahsakits/create', 'RumahSakitsController@create'); //form membuat rumah sakit baru
			Route::get('rumahsakits/{id}', 'RumahSakitsController@show'); //penjualan obat tanpa resep
			Route::put('rumahsakits/{id}', 'RumahSakitsController@update'); //penjualan obat tanpa resep
			Route::post('rumahsakits', 'RumahSakitsController@store'); //penjualan obat tanpa resep

			Route::get('rayons/create', 'RayonsController@create'); //form membuat rumah sakit baru
			Route::post('rayons', 'RayonsController@store'); //form membuat rumah sakit baru
			Route::get('bayardokters', 'BayarDoktersController@index'); //penjualan obat tanpa resep

			Route::get('penjualans', 'PenjualansController@index'); //penjualan obat tanpa resep
			Route::get('penjualans/obat_buat_karyawan', 'PenjualansController@obat_buat_karyawan'); //penjualan obat tanpa resep
			Route::post('penjualans/obat_buat_karyawan', 'PenjualansController@obat_buat_karyawan_post'); //penjualan obat tanpa resep
			Route::post('penjualans', 'PenjualansController@indexPost'); //penjualan obat tanpa resep

			Route::get('pembelians', 'PembeliansController@index');
			Route::get('stafs/{id}/terapi', 'CustomController@terapi');
			Route::post('pembelians', 'PembeliansController@store');
			Route::get('pembelians/riwayat', 'PembeliansController@riwayat');
			Route::get('pembelians/show/{id}', 'PembeliansController@show');
			Route::get('pembelians/{faktur_beli_id}', 'PembeliansController@create');
			Route::get('pembelians/{faktur_beli_id}/edit', 'PembeliansController@edit');
			Route::post('pembelians/{id}', 'PembeliansController@update');

			Route::get('ranaps', 'RanapsController@index');

			Route::get('pengeluarans/service_acs', 'ServiceAcsController@create');
			Route::get('pengeluarans/service_acs/{id}', 'ServiceAcsController@show');
			Route::post('pengeluarans/service_acs', 'ServiceAcsController@store');


			Route::post('pengeluarans/list', 'PengeluaransController@lists');
			Route::get('pengeluarans/belanja_bukan_obat/detail/{id}', 'PengeluaransController@belanjaBukanObatDetail');
			Route::get('pengeluarans/data', 'PengeluaransController@data');
			Route::get('pengeluarans/show/{id}', 'PengeluaransController@show');
			Route::post('pengeluarans', 'PengeluaransController@store');
            Route::get('pengeluarans/bayardoker', 'PengeluaransController@bayar');
            Route::get('pengeluarans/nota_z', 'PengeluaransController@nota_z');
            Route::get('pengeluarans/nota_z/detail/{id}', 'PengeluaransController@notaz_detail');
            route::post('pengeluarans/nota_z', 'PengeluaransController@notaz_post');
            Route::get('pengeluarans/rc', 'PengeluaransController@erce');
            Route::post('pengeluarans/rc', 'PengeluaransController@erce_post');
			Route::post('pengeluarans/ketkeluar', 'PengeluaransController@ketkeluar');
			Route::get('pengeluarans/belanjaPeralatan/getObject/belanjaPeralatan', 'PengeluaransController@getBelanjaPeralatanObject');


			Route::get('ajax/products', 'PengeluaransController@product');


			Route::get('pengeluarans/bayardoker/{id}', 'PengeluaransController@bayardokter');
			Route::get('pengeluarans/bayardokter/bayar', 'PengeluaransController@dokterbayar');
			Route::post('pengeluarans/bayardokter/bayar', 'PengeluaransController@dokterdibayar');

			Route::get('pengeluarans/checkout/{id}', 'PengeluaransController@show_checkout');
			Route::post('pengeluarans/confirm_staf', 'PengeluaransController@confirm_staf');

			Route::get('pengeluarans/bayar_gaji_karyawan', 'PengeluaransController@bayar_gaji_karyawan');
			Route::post('pengeluarans/bayar_gaji_karyawan', 'PengeluaransController@bayar_gaji');
			Route::post('pengeluarans/bayar_gaji_karyawan/{staf_id}', 'PengeluaransController@bayar_gaji');

			Route::get('pengeluarans/bayar_bonus_karyawan', 'PengeluaransController@bayar_bonus_karyawan');
			Route::get('pengeluarans/bayar_bonus_karyawan/{staf_id}', 'PengeluaransController@bayar_bonus_show');
			Route::post('pengeluarans/bayar_bonus_karyawan/{staf_id}', 'PengeluaransController@bayar_bonus');

			Route::get('pengeluarans/bagi_hasil_gigi', 'PengeluaransController@bagiHasilGigi');
			Route::post('pengeluarans/bagi_hasil_gigi', 'PengeluaransController@bagiHasilGigiPost');

			Route::get('pengeluarans/gaji_dokter_gigi', 'PengeluaransController@gajiDokterGigi');
			Route::post('pengeluarans/gaji_dokter_gigi/bayar', 'PengeluaransController@gajiDokterGigiBayar');
			Route::get('pengeluarans/peralatans', 'PengeluaransController@peralatans');
			Route::get('pengeluarans/peralatans/detail/{id}', 'PengeluaransController@peralatan_detail');
			Route::get('pengeluarans/belanja/peralatan', 'PengeluaransController@belanjaPeralatan');
			Route::post('pengeluarans/belanja/peralatan/bayar', 'PengeluaransController@belanjaPeralatanBayar');
			Route::get('pengeluarans/{id}', 'PengeluaransController@index');

			Route::get('belanjalist', 'BelanjaListsController@index');
			Route::get('prolanis', 'ProlanisController@index');
			Route::post('prolanis', 'ProlanisController@store');
			Route::get('prolanis/terdaftar', 'ProlanisController@terdaftar');
			Route::get('prolanis/create/{id}', 'ProlanisController@create');
			Route::get('prolanis/{id}/edit', 'ProlanisController@edit');
			Route::put('prolanis/{id}', 'ProlanisController@update');
			Route::post('prolanis/destroy/{id}', 'ProlanisController@destroy');

			Route::get('fakturbelanjas', 'FakturBelanjasController@index');
			Route::get('fakturbelanjas/obat', 'FakturBelanjasController@obat');
			Route::get('fakturbelanjas/alat', 'FakturBelanjasController@alat');
			Route::get('fakturbelanjas/serviceAc', 'FakturBelanjasController@serviceAc');
			Route::post('fakturbelanjas', 'FakturBelanjasController@store');
			Route::get('fakturbelanjas/{id}', 'FakturBelanjasController@destroy');


			Route::get('nota_juals', 'NotaJualsController@index');
			Route::get('nota_juals/{id}', 'NotaJualsController@show');

			Route::get('sops/{icd10}/{diagnosa_id}/{asuransi_id}/{berat_badan_id}', 'SopsController@index');
			Route::post('sops', 'SopsController@store');

			//membuat rak baru berdasarkan formula_id
			Route::get('create/raks/{id}', 'CustomController@create_rak');
			Route::get('mereks/buyhistory/{id}', 'CustomController@buyhistory');

			//membuat merek baru berdasyararkan merek_id
			Route::get('create/mereks/{id}', 'CustomController@create_merek');

			
			Route::get('jurnal_umums', 'JurnalUmumsController@index');
			Route::get('jurnal_umums/show', 'JurnalUmumsController@show');
			Route::get('jurnal_umums/coa', 'JurnalUmumsController@coa');
			Route::post('jurnal_umums/coa', 'JurnalUmumsController@coaPost');
			Route::get('jurnal_umums/coa_list', 'JurnalUmumsController@coa_list');
			Route::get('jurnal_umums/coa_keterangan', 'JurnalUmumsController@coa_keterangan');
			Route::post('jurnal_umums/coa_entry', 'JurnalUmumsController@coa_entry');
			Route::get('jurnal_umums/hapus/jurnals', 'JurnalUmumsController@hapus_jurnals');
			Route::get('jurnal_umums/{id}/edit', 'JurnalUmumsController@edit');
			Route::put('jurnal_umums/{id}', 'JurnalUmumsController@update');


			Route::get('buku_besars', 'BukuBesarsController@index');
			Route::get('buku_besars/show', 'BukuBesarsController@show');

			Route::get('laporan_laba_rugis', 'LaporanLabaRugisController@index');
			Route::get('laporan_laba_rugis/show', 'LaporanLabaRugisController@show');

			Route::get('laporan_arus_kass', 'LaporanArusKassController@index');
			Route::get('laporan_arus_kass/show', 'LaporanArusKassController@show');

			Route::get('laporan_neracas', 'LaporanNeracasController@index');
			Route::get('laporan_neracas/show', 'LaporanNeracasController@show');

			Route::get('neraca_saldos', 'NeracaSaldosController@index');
			Route::get('neraca_saldos/show', 'NeracaSaldosController@show');

			
			Route::get('perbaikantrxs', 'PerbaikantrxsController@index');
			Route::get('perbaikantrxs/show', 'PerbaikantrxsController@show');

			Route::get('perbaikanreseps/show', 'PerbaikanresepsController@show');

			//membuat merek baru berdasarkan merek_id
			Route::post('kasir/submit', 'KasirBaseController@kasir_submit');

			//update tarif berdasarkan tarif_id
			Route::post('update/tarifs/', 'CustomController@updtrf');

			Route::post('monitor/avail', 'CustomController@mon_avail');
			Route::post('monitor/survey', 'CustomController@survey_available');

			//ajax untuk survey pasien
			Route::post('update/surveys/send_id', 'CustomController@send_id');

			//update tarif berdasarkan tarif_id
			Route::post('update/kembali/{id}', 'CustomController@kembali');
			Route::post('update/kembali2/{id}', 'CustomController@kembali2');
			Route::post('update/kembali3/{id}', 'CustomController@kembali3');


			//masuk survey
			Route::get('update/surveys/{id}', 'CustomController@survey');
			Route::post('update/surveys', 'CustomController@survey_post');
			Route::post('update/surveys/conf', 'CustomController@confirmed');

			// controller untuk monitor pasien

			Route::get('monitors/index', 'MonitorsController@index');
			Route::post('monitors/puas', 'MonitorsController@puas');
			Route::post('monitors/biasa', 'MonitorsController@biasa');
			Route::post('monitors/kecewa', 'MonitorsController@kecewa');
			Route::post('monitors/buatIdPeriksaNol', 'MonitorsController@buatIdPeriksaNol');


			Route::get('obat/stokmin', 'ObatsController@index');

			//update tarif berdasarkan tarif_id
			Route::post('delete/faktur_belis', 'CustomController@del_fak_beli');

			Route::get('suratsakits/create/{id}', 'SuratSakitsController@create');
			Route::get('suratsakits/{id}/edit', 'SuratSakitsController@edit');
			Route::post('suratsakits', 'SuratSakitsController@store');
			Route::put('suratsakits/{id}', 'SuratSakitsController@update');
			Route::get('suratsakits/delete/{id}', 'SuratSakitsController@destroy');

			Route::get('rujukans/create/{id}', 'RujukansController@create');
			Route::get('rujukans/{id}/edit', 'RujukansController@edit');
			Route::get('rujukans', 'RujukansController@index');
			Route::post('rujukans', 'RujukansController@store');
			Route::put('rujukans/{id}', 'RujukansController@update');
			Route::get('rujukans/show', 'RujukansController@show');
			Route::get('rujukans/{id}', 'RujukansController@ini');
			Route::get('rujukans/delete/{id}', 'RujukansController@destroy');


			Route::get('perujuks', 'PerujuksController@index');
			Route::get('perujuks/create', 'PerujuksController@create');
			Route::post('perujuks/ajax/create', 'PerujuksController@ajaxcreate');
			Route::get('perujuks/{id}/edit', 'PerujuksController@edit');
			Route::post('perujuks', 'PerujuksController@store');
			Route::put('perujuks/{id}', 'PerujuksController@update');
			Route::delete('perujuks/{id}', 'PerujuksController@destroy');

			Route::get('pendapatans', 'PendapatansController@index');
			Route::post('pendapatans/pembayaran/asuransi', 'PendapatansController@asuransi_bayar');
			Route::get('pendapatans/create', 'PendapatansController@create');
			Route::post('pendapatans/index', 'PendapatansController@store');
			Route::get('pendapatans/pembayaran/asuransi', 'PendapatansController@pembayaran_asuransi');
			Route::get('pengeluarans/pembayaran_asuransi/show ', 'PendapatansController@lihat_pembayaran_asuransi');
			Route::get('pendapatans/pembayaran_bpjs ', 'PendapatansController@pembayaran_bpjs');
			Route::post('pendapatans/pembayaran_bpjs', 'PendapatansController@pembayaran_bpjs_post');
			Route::get('pendapatans/pembayaran/asuransi/show/{id}', 'PendapatansController@pembayaran_asuransi_show');
			Route::post('rujuajax/rs', 'RujukansAjaxController@rs');
			Route::post('rujuajax/rschange', 'RujukansAjaxController@rschange');
			Route::post('rujuajax/tujurujuk', 'RujukansAjaxController@tujurujuk');
			Route::post('anc/registerhamil', 'AncController@registerhamil');
			Route::post('anc/perujx', 'AncController@perujx');
			Route::post('anc/uk', 'AncController@uk');


			Route::post('poli/ajax/ibusafe', 'PoliAjaxController@ibusafe');
			Route::post('poli/ajax/pregsafe', 'PoliAjaxController@pregsafe');
			Route::post('poli/ajax/sopterapi', 'PoliAjaxController@sopterapi');
			Route::post('poli/ajax/diagcha', 'PoliAjaxController@diagcha');
			Route::post('poli/ajax/indiag', 'PoliAjaxController@indiag');
			Route::post('poli/ajax/insigna', 'PoliAjaxController@insigna');
			Route::post('poli/ajax/selectsigna', 'PoliAjaxController@selectsigna');
			Route::post('poli/ajax/selectatur', 'PoliAjaxController@selectatur');
			Route::post('poli/ajax/inatur', 'PoliAjaxController@inatur');
			Route::post('poli/ajax/ajxobat', 'PoliAjaxController@ajxobat');
			Route::get('poli/ajax/diag', 'PoliAjaxController@diag');
			Route::post('poli/ajax/pilih', 'PoliAjaxController@pilih');
			Route::post('poli/ajax/kkchange', 'PoliAjaxController@kkchange');
			Route::post('poli/ajax/asuridchange', 'PoliAjaxController@asuridchange');
			Route::post('poli/ajax/bhp_tindakan', 'PoliAjaxController@bhp_tindakan');



			Route::get('DdlMerek/alloption', 'DdlMerekController@alloption');
			Route::get('DdlMerek/alloption2', 'DdlMerekController@alloption2');
			Route::get('DdlMerek/optionpuyer', 'DdlMerekController@optionpuyer');
			Route::get('DdlMerek/optionsyrup', 'DdlMerekController@optionsyrup');

			Route::post('laporans/ajax/filter', 'LaporansAjaxController@filter');


			Route::post('antrianperiksas/ajax/cekada', 'AntrianPeriksasAjaxController@cekada');

			Route::post('pembelians/ajax/formulabyid', 'PembeliansAjaxController@formulabyid');
			Route::post('pembelians/ajax/rakbyid', 'PembeliansAjaxController@rakbyid');

			Route::post('mereks/ajax/ajaxmerek', 'MereksAjaxController@ajaxmerek');

			Route::post('raks/ajax/ajaxrak', 'RaksAjaxController@ajaxrak');

			Route::post('formulas/ajax/ajaxformula', 'FormulasAjaxController@ajaxformula');

			Route::get('poli/{id}', 'PolisController@poli');


			Route::get('kasir/{id}', 'KasirBaseController@kasir');
			Route::post('kasir/onchange', 'KasirBaseController@onchange');
			Route::post('kasir/changemerek', 'KasirBaseController@changemerek');
			Route::post('kasir/updatejumlah', 'KasirBaseController@updatejumlah');

			Route::get('pasiens/ajax/ajaxpasiens', 'PasiensAjaxController@ajaxpasiens');
			Route::post('pasiens/ajax/ajaxpasien', 'PasiensAjaxController@ajaxpasien');
			Route::post('pasiens/ajax/create', 'PasiensAjaxController@create');
			Route::post('pasiens/ajax/cekbpjskontrol', 'PasiensAjaxController@cekbpjskontrol');
			Route::post('pasiens/ajax/confirm_staf', 'PasiensAjaxController@confirm_staf');
			Route::get('pasiens/ajax/cari', 'PasiensAjaxController@cariPasien');
			Route::post('pasiens/ajax/cekantrian/tanggal', 'PasiensAjaxController@cekAntrianPerTanggal');

			Route::get('survey', 'KasirsController@index');
			Route::get('kasirs/saldo', 'KasirsController@saldo');
			Route::post('kasirs/saldo', 'KasirsController@saldoPost');

			Route::get('usgs/{id}', 'UsgsController@show');
			Route::get('ancs/{id}', 'AncsController@show');


			Route::get('ruangperiksa', 'RuangPeriksaController@index');
			Route::get('ruangperiksa/umum', 'RuangPeriksaController@umum');
			Route::get('ruangperiksa/kandungan', 'RuangPeriksaController@kandungan');
			Route::get('ruangperiksa/anc', 'RuangPeriksaController@anc');
			Route::get('ruangperiksa/suntikkb', 'RuangPeriksaController@suntikkb');
			Route::get('ruangperiksa/estetika', 'RuangPeriksaController@estetika');
			Route::get('ruangperiksa/usg', 'RuangPeriksaController@usg');
			Route::get('ruangperiksa/usgabdomen', 'RuangPeriksaController@usgabdomen');
			Route::get('ruangperiksa/gigi', 'RuangPeriksaController@gigi');
			Route::get('ruangperiksa/darurat', 'RuangPeriksaController@darurat');


			Route::get('laporans', 'LaporansController@index');
			Route::get('laporans/pengantar', 'LaporansController@pengantar');
			Route::get('laporans/harian', 'LaporansController@harian');
			Route::get('laporans/haridet', 'LaporansController@haridet');
			Route::get('laporans/harikas', 'LaporansController@harikas');
			Route::get('laporans/bulanan', 'LaporansController@bulanan');
			Route::get('laporans/tanggal', 'LaporansController@tanggal');
			Route::get('laporans/detbulan', 'LaporansController@detbulan');
			Route::get('laporans/payment/{id}', 'LaporansController@payment');
			Route::get('laporans/penyakit', 'LaporansController@penyakit');
			Route::get('laporans/status', 'LaporansController@status');
			Route::get('laporans/points', 'LaporansController@points');
			Route::get('laporans/rujukankebidanan', 'LaporansController@rujukankebidanan');
            Route::get('laporans/bayardokter', 'LaporansController@bayardokter');
			Route::post('laporans/pendapatan', 'LaporansController@pendapatan');
			Route::post('laporans/payment', 'LaporansController@paymentpost');
            Route::get('laporans/pembayaran/dokter', 'LaporansController@pembayarandokter');
            Route::get('laporans/no_asisten', 'LaporansController@no_asisten');
            Route::get('laporans/gigi', 'LaporansController@gigiBulanan');
            Route::get('laporans/anc', 'LaporansController@anc');
            Route::get('laporans/kb', 'LaporansController@kb');
            Route::get('laporans/jumlahPasien', 'LaporansController@jumlahPasien');
            Route::get('laporans/jumlahIspa', 'LaporansController@jumlahIspa');
            Route::get('laporans/jumlahDiare', 'LaporansController@jumlahDiare');
			Route::get('laporans/hariandanjam', 'LaporansController@hariandanjam');
			Route::get('laporans/asuransi/detail/{asuransi_id}/{tanggal}', 'LaporansController@asuransi_detail');
			Route::get('laporans/contoh', 'LaporansController@contoh');
			Route::get('laporans/bpjs_tidak_terpakai', 'LaporansController@bpjsTidakTerpakai');
			Route::get('laporans/sms/bpjs', 'LaporansController@smsBpjs');


			Route::get('pdfs/status/{periksa_id}', 'PdfsController@status');
			Route::get('pdfs/status/a4/{periksa_id}', 'PdfsController@status_a4');
			Route::get('pdfs/dispensing/{rak_id}/{mulai}/{akhir}', 'PdfsController@dispensing');
			Route::get('pdfs/kuitansi/{periksa_id}', 'PdfsController@kuitansi');
			Route::get('pdfs/struk/{periksa_id}', 'PdfsController@struk');
			Route::get('pdfs/jasadokter/{bayar_dokter_id}', 'PdfsController@jasa_dokter');
			Route::get('pdfs/pembelian/{faktur_belanja_id}', 'PdfsController@pembelian');
			Route::get('pdfs/penjualan/{nota_jual_id}', 'PdfsController@penjualan');
			Route::get('pdfs/pendapatan/{nota_jual_id}', 'PdfsController@pendapatan');
			Route::get('pdfs/pembayaran_asuransi/{pembayaran_asuransi_id}', 'PdfsController@pembayaran_asuransi');
			Route::get('pdfs/notaz/{checkout_kasir_id}', 'PdfsController@notaz');
			Route::get('pdfs/rc/{modal_id}', 'PdfsController@rc');
			Route::get('pdfs/bayar_gaji_karyawan/{bayar_gaji_id}', 'PdfsController@bayar_gaji_karyawan');
			Route::get('pdfs/ns/{no_sale_id}', 'PdfsController@ns');
			Route::get('pdfs/pengeluaran/{id}', 'PdfsController@pengeluaran');
			Route::get('pdfs/formulir/usg/{id}/{asuransi_id}', 'PdfsController@formUsg');
			Route::get('pdfs/merek', 'PdfsController@merek');
			Route::get('pdfs/laporan_laba_rugi/{bulan}/{tahun}', 'PdfsController@laporanLabaRugi');
			Route::get('pdfs/laporan_neraca', 'PdfsController@laporanNeraca');
			Route::get('pdfs/jurnal_umum/{bulan}/{tahun}', 'PdfsController@jurnalUmum');
			Route::get('pdfs/buku_besar/{bulan}/{tahun}/{coa_id}', 'PdfsController@jurnalUmum');
			Route::get('pdfs/this', 'PdfsController@this');



			Route::get('no_sales', 'NoSalesController@index');
			Route::post('no_sales', 'NoSalesController@store');

			Route::get('stokopnames', 'StokOpnamesController@index');
			Route::post('stokopnames', 'StokOpnamesController@store');
			Route::post('stokopnames/awal', 'StokOpnamesController@awal');
			Route::post('stokopnames/change', 'StokOpnamesController@change');
			Route::post('stokopnames/destroy', 'StokOpnamesController@destroy');


			Route::get('terapis/{periksa_id}', 'TerapisController@index');
			Route::post('test/test', 'CustomController@test_post');

			Route::get('test/test', 'CustomController@test');
			Route::post('test/getmereks', 'CustomController@getmereks');

			Route::get('sms', 'SmsController@sms');
			Route::post('sms', 'SmsController@smsPost');
			Route::get('sms/angkakontak', 'SmsController@angkakontak');
			Route::get('sms/kontak/ulangi', 'SmsController@kontakulangi');
			Route::get('sms/kontak/anulir_no_telp/{id}', 'SmsController@kontakanulir');
			Route::get('sms/kontak/hapus/{id}', 'SmsController@kontakhapus');
			Route::get('sms/gagal/ulangi', 'SmsController@gagalulangi');
			Route::get('sms/gagal/anulir_no_telp/{id}', 'SmsController@gagalanulir');
			Route::get('sms/gagal/hapus/{id}', 'SmsController@gagalhapus');
			Route::post('laporans/sms/kontak/action', 'SmsController@smsKontakPost');
			Route::post('laporans/sms/gagal/action', 'SmsController@smsGagalPost');
			Route::post('laporans/sms/masuk/action', 'SmsController@smsMasukPost');


			Route::get('configs', 'ConfigsController@index');
			Route::post('configs/update', 'ConfigsController@update');

			Route::get('gammu/inbox', 'GammuController@inbox');
			Route::get('gammu/outbox', 'GammuController@outbox');

			Route::get('gammu/pesanMasuk', 'GammuController@pesanMasuk');
			Route::get('gammu/pesanKeluar', 'GammuController@pesanKeluar');

			Route::get('gammu/sentitems', 'GammuController@sentitems');

			Route::get('gammu/create/sms', 'GammuController@createSms');
			Route::post('gammu/send/sms', 'GammuController@sendSms');
			Route::get('gammu/reply/{SenderNumber}', 'GammuController@reply');
			Route::delete('gammu/{id}/delete', 'GammuController@destroy');

			Route::get('master/ajax/antrianTerakhir', 'MasterController@antrianTerakhir');

			Route::get('discounts', 'DiscountsController@index');
			Route::post('discounts', 'DiscountsController@store');
			Route::get('discounts/create', 'DiscountsController@create');
			Route::get('discounts/{id}/edit', 'DiscountsController@edit');
			Route::get('discounts/{id}/delete', 'DiscountsController@delete');
			Route::put('discounts/{id}', 'DiscountsController@update');
			Route::get('promo/kecantikan/ktp/pertahun', 'DiscountsController@promoKtpPertahun');
			Route::post('promo/kecantikan/ktp/pertahun', 'DiscountsController@promoKtpPertahunPost');

			Route::get('acs', 'AcsController@index');
			Route::get('acs/create', 'AcsController@create');
			Route::get('acs/{id}/edit', 'AcsController@edit');
			Route::put('acs/{id}', 'AcsController@update');
			Route::delete('acs/{id}', 'AcsController@destroy');
			Route::post('acs', 'AcsController@store');

  	});




	




		
