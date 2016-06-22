<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



// DISINI SESSION BISA JALAN

Route::get('/', 'AuthController@index');
Route::get('login', 'AuthController@index')->name('login');
Route::get('logout', 'AuthController@logout');
Route::post('login', 'AuthController@login');
Route::get('jangan', 'PolisController@jangan');

Route::get('sesuaikan/sesuaikan', function(){


    $query = "select px.id from periksas as px join terapis as tr on tr.periksa_id = px.id where signa = 'Add' group by px.id;";
    $periksas = DB::select($query);
    $data = '';
    foreach ($periksas as $p) {
        $terapis = App\Terapi::where('periksa_id', $p->id)->get();
        $bayarAdd = 0;
        $syrupAdd = 0;
        $temp = '';
        foreach ($terapis as $terapi) {
            $formula_id = $terapi->merek->rak->formula_id;
            if ($terapi->signa == 'Add' &&
                (
                    $formula_id == '150803003' || //Decamox Syr
                    $formula_id == '150803008' || //Lostacef Syr
                    $formula_id == '150921001' || //cefixime syr
                    $formula_id == '150803006'  //Dionicol sy
                )
            ) {
                $syrupAdd = 1;
            }

            if (!$bayarAdd && $terapi->merek_id == -2 && $terapi->jumlah > 0) {
                $terapi->jumlah = 0;
                $terapi->save(); 
            } else if ($bayarAdd && $terapi->merek_id == -2 && $terapi->jumlah < 1) {
                $terapi->jumlah = 1;
                $terapi->save(); 
            }

            if ($syrupAdd && $terapi->signa != 'Add') {
                $syrupAdd = 0;
                $bayarAdd = 0;    
            } else if ($syrupAdd && $terapi->signa == 'Add' &&
                !(

                    $formula_id == '150803003' || //Decamox Syr
                    $formula_id == '150803008' || //Lostacef Syr
                    $formula_id == '150921001' || //cefixime syr
                    $formula_id == '150803006' || //Dionicol sy
                    $formula_id == '150806007' || //Decamox Syr
                    $formula_id == '150802040' || //Lostacef Syr
                    $formula_id == '150806005' || //cefixime syr
                    $terapi->merek_id == '-2' || //cefixime syr
                    $formula_id == '150803047'  //Dionicol sy
                )
            ) {
                $bayarAdd = 1;    
            }

            $temp .= $terapi->merek->merek . ' ' . $terapi->signa . ' '. $terapi->jumlah . ' '. $terapi->aturan_minum  . ' merek_id = ' . $terapi->merek_id . ' ' . $syrupAdd . ' ' . $bayarAdd . '<br />';
        }
        if($bayarAdd){
            $text = '<span style="color:red;">';
             $text .= 'Add di bayar';
             $text .= '</span>';
         } else {
            $text = '<span style="color:red;">';
             $text .= 'Add tidak di bayar';
             $text .= '</span>';
         }
         $data .= $temp . $text . '<br /><br />';
    }
    return $data;
});
Route::get('sesuaikan/cek', function(){
    $query = "select px.id from periksas as px join terapis as tr on tr.periksa_id = px.id where signa = 'Add' group by px.id limit 10;";
    $periksas = DB::select($query);
    $data = '';
    foreach ($periksas as $p) {
        $terapis = App\Terapi::where('periksa_id', $p->id)->get();
        $bayarAdd = 0;
        $syrupAdd = 0;
        $temp = '';
        foreach ($terapis as $terapi) {
        $temp .= $terapi->merek->merek . ' ' . $terapi->signa . ' '. $terapi->jumlah . ' '. $terapi->aturan_minum . '<br />';
        }
        $data .= $temp . '<br />';
    }
    return $data;
    return dd($data);
});
		
    Route::resource('users', 'UsersController');
  	Route::group(['middleware' => 'auth'], function(){



			Route::get('diagnosa/tidakdirujuk', 'TidakdirujukController@index');
			Route::get('memcached', 'MemcachedController@index');
			Route::get('memcached/data', 'MemcachedController@data');
			Route::get('perujuks/kecil', function(){
				return View::make('perujuks.kecil');
			});

			Route::post('suppliers/ajax/ceknotalama', 'SuppliersAjaxController@ceknotalama');
			Route::get('suppliers/belanja_obat', 'SupplierBelanjasController@belanja_obat');
			Route::get('suppliers/belanja_bukan_obat', 'SupplierBelanjasController@belanja_bukan_obat');

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
			Route::resource('dispensings', 'DispensingsController');
			Route::resource('antriankasirs', 'AntrianKasirsController');
			Route::resource('antrianpolis', 'AntrianPolisController');
			Route::resource('transaksis', 'TransaksisController');
			Route::resource('antrianperiksas', 'AntrianPeriksasController');

			Route::get('asuransis/riwayat/{id}', 'AsuransisExtraController@riwayat');

			Route::get('rumahsakits', 'RumahSakitsController@index'); //penjualan obat tanpa resep
			Route::get('rumahsakits/{id}', 'RumahSakitsController@show'); //penjualan obat tanpa resep
			Route::put('rumahsakits/{id}', 'RumahSakitsController@update'); //penjualan obat tanpa resep
			Route::post('rumahsakits', 'RumahSakitsController@destroy'); //penjualan obat tanpa resep

			Route::get('bayardokters', 'BayarDoktersController@index'); //penjualan obat tanpa resep

			Route::get('penjualans', 'PenjualansController@index'); //penjualan obat tanpa resep
			Route::post('penjualans', 'PenjualansController@indexPost'); //penjualan obat tanpa resep

			Route::get('pembelians', 'PembeliansController@index');
			Route::get('stafs/{id}/terapi', 'CustomController@terapi');
			Route::post('pembelians', 'PembeliansController@store');
			Route::get('pembelians/riwayat', 'PembeliansController@riwayat');
			Route::get('pembelians/show/{id}', 'PembeliansController@show');
			Route::get('pembelians/{faktur_beli_id}', 'PembeliansController@create');
			Route::get('pembelians/{faktur_beli_id}/edit', 'PembeliansController@edit');
			Route::post('pembelians/{id}', 'PembeliansController@update');


			Route::post('pengeluarans/list', 'PengeluaransController@lists');
			Route::get('pengeluarans/show/{id}', 'PengeluaransController@show');
			Route::post('pengeluarans', 'PengeluaransController@store');
            Route::get('pengeluarans/bayardoker', 'PengeluaransController@bayar');
            Route::get('pengeluarans/nota_z', 'PengeluaransController@nota_z');
            Route::get('pengeluarans/nota_z/detail/{id}', 'PengeluaransController@notaz_detail');
            Route::post('pengeluarans/nota_z', 'PengeluaransController@notaz_post');
            Route::get('pengeluarans/rc', 'PengeluaransController@erce');
            Route::post('pengeluarans/rc', 'PengeluaransController@erce_post');
			Route::post('pengeluarans/ketkeluar', 'PengeluaransController@ketkeluar');

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

			Route::get('pengeluarans/{id}', 'PengeluaransController@index');
			Route::post('fasilitas/destroy', 'FasilitasController@destroy'); //penjualan obat tanpa resep
			Route::post('fasilitas/update_tujuan_rujuk', 'FasilitasController@update'); //penjualan obat tanpa resep


			Route::get('fakturbelanjas', 'FakturBelanjasController@index');
			Route::get('fakturbelanjas/cari', 'FakturBelanjasController@cari');
			Route::post('fakturbelanjas', 'FakturBelanjasController@store');
			Route::get('fakturbelanjas/{id}', 'FakturBelanjasController@destroy');

			Route::get('nota_juals', 'NotaJualsController@index');
			Route::get('nota_juals/{id}', 'NotaJualsController@show');

			Route::get('sops/{icd10}/{diagnosa_id}/{asuransi_id}/{berat_badan_id}', 'SopsController@index');
			Route::post('sops', 'SopsController@store');

			//membuat rak baru berdasarkan formula_id
			Route::get('create/raks/{id}', 'CustomController@create_rak');
			Route::get('mereks/buyhistory/{id}', 'CustomController@buyhistory');

			//membuat merek baru berdasarkan merek_id
			Route::get('create/mereks/{id}', 'CustomController@create_merek');

			
			Route::get('jurnal_umums', 'JurnalUmumsController@index');
			Route::get('jurnal_umums/show', 'JurnalUmumsController@show');
			Route::get('jurnal_umums/coa', 'JurnalUmumsController@coa');
			Route::post('jurnal_umums/coa', 'JurnalUmumsController@coaPost');
			Route::get('jurnal_umums/coa_list', 'JurnalUmumsController@coa_list');
			Route::get('jurnal_umums/coa_keterangan', 'JurnalUmumsController@coa_keterangan');
			Route::post('jurnal_umums/coa_entry', 'JurnalUmumsController@coa_entry');


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
			

			Route::get('survey', 'KasirsController@index');


			Route::get('usgs/{id}', 'UsgsController@show');
			Route::get('ancs/{id}', 'AncsController@show');


			Route::get('ruangperiksa/umum', 'RuangPeriksaController@umum');
			Route::get('ruangperiksa/kandungan', 'RuangPeriksaController@kandungan');
			Route::get('ruangperiksa/anc', 'RuangPeriksaController@anc');
			Route::get('ruangperiksa/suntikkb', 'RuangPeriksaController@suntikkb');
			Route::get('ruangperiksa/usg', 'RuangPeriksaController@usg');
			Route::get('ruangperiksa/usgabdomen', 'RuangPeriksaController@usgabdomen');
			Route::get('ruangperiksa/gigi', 'RuangPeriksaController@gigi');
			Route::get('ruangperiksa/darurat', 'RuangPeriksaController@darurat');


			Route::get('laporans', 'LaporansController@index');
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

			Route::get('pdfs/status/{periksa_id}', 'PdfsController@status');
			Route::get('pdfs/kuitansi/{periksa_id}', 'PdfsController@kuitansi');
			Route::get('pdfs/struk/{periksa_id}', 'PdfsController@struk');
			Route::get('pdfs/jasadokter/{bayar_dokter_id}', 'PdfsController@jasa_dokter');
			Route::get('pdfs/pembelian/{faktur_belanja_id}', 'PdfsController@pembelian');
			Route::get('pdfs/penjualan/{nota_jual_id}', 'PdfsController@penjualan');
			Route::get('pdfs/pendapatan/{nota_jual_id}', 'PdfsController@pendapatan');
			Route::get('pdfs/pembayaran_asuransi/{pembayaran_asuransi_id}', 'PdfsController@pembayaran_asuransi');

			Route::get('stokopnames', 'StokOpnamesController@index');
			Route::post('stokopnames', 'StokOpnamesController@store');
			Route::post('stokopnames/awal', 'StokOpnamesController@awal');
			Route::post('stokopnames/change', 'StokOpnamesController@change');
			Route::post('stokopnames/destroy', 'StokOpnamesController@destroy');


			Route::get('terapis/{periksa_id}', 'TerapisController@index');
			Route::post('test/test', 'CustomController@test_post');

			Route::get('test/test', 'CustomController@test');
			Route::post('test/getmereks', 'CustomController@getmereks');
  	});



	




		
