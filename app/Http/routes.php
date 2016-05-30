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
		
  		Route::get('name/name', function(){
			return 'yoga';
		});

		Route::get('bb/bb', function(){
			// $periksas = DB::select("select * from periksas where berat_badan is null");
			$periksas = DB::select("select * from periksas where pemeriksaan_fisik like '%kg%' and berat_badan is null");
			// return count($periksas);
				$i = 0;
				$a = 0;
				$x = 0;
			$temp = '';
			$temp2 = '';
			foreach ($periksas as $k => $periksa) {
				$a++;
				$pemeriksaan_fisik = $periksa->pemeriksaan_fisik;
				$arr = preg_split('/\s+/', $pemeriksaan_fisik);
				// $temp .= $pemeriksaan_fisik . '<br />';
				foreach ($arr as $key => $ar) {
					if (preg_match('/kg/',strtolower($ar))) {
						$prx = Periksa::find($periksa->id);
						if ($key > 0) {
							$prx->berat_badan = (int)preg_replace("/[^0-9,.]/", "", str_replace(',', '.', $arr[$key -1]));
						} else{
							$prx->berat_badan = '0';
						}
						$prx->save();
					}
				}
			}
			return 'jumlah = '. $i  . 'dari = ' .$a. 'yang lebih dari 50 kg ada = ' .$x .'<br /><br />' . $temp2 .'<br /><br />' . $temp;
		});
			Route::get('test/test', function(){
				$asuransi_id = '3';
				$periksas = Periksa::where('asuransi_id', $asuransi_id)->where('tanggal', 'like', date('Y-m') . '%')->get();
				$plafon = 0;
				$totalDigunakan = 0;
				$tunai = 0;

				foreach ($periksas as $key => $periksa) {
					$terapis = Terapi::where('periksa_id', $periksa->id)->get();
					foreach ($terapis as $key => $terapi) {
						$totalDigunakan += $terapi->merek->rak->harga_jual * $terapi->jumlah * $periksa->asuransi->kali_obat;
					}
					$tunai = $periksa->tunai;
					$plafon += Tarif::where('asuransi_id', $asuransi_id)->where('jenis_tarif_id', '9')->first()->biaya;
				}
				return 'totalDigunakan = ' . $totalDigunakan .
				 'plafon = ' . $plafon .
				 'tunai = ' . $tunai;

			});
			Route::get('sesuaikan/query', function(){
				$periksas = Periksa::where('created_at', '>', '0000-00-00 00:00:00')->get();
				foreach ($periksas as $k => $periksa) {
					$tr_json = $periksa->transaksi;
					$tr_arr = json_decode($tr_json,true);
					foreach ($tr_arr as $k => $tr) {
						$jenis_tarif_id = JenisTarif::where('jenis_tarif', $tr['jenis_tarif'])->first()->id;
						$tr_arr[$k]['jenis_tarif_id'] = $jenis_tarif_id;
					}

					$periksa->transaksi = json_encode($tr_arr);
					$periksa->save();
				}
			});
			// insert terapi saat baru mulai pakai laravel sudah dilakukan
			Route::get('terapi/terapi', function(){
				$periksas = Periksa::where('created_at', '>', '0000-00-00 00:00:00')->get();
				$periksa_array = [];
				foreach ($periksas as $k => $periksa) {
					if (Terapi::where('periksa_id', $periksa->id)->count() == 0) {
						$periksa_array[] = $periksa;
					}
				}
				foreach ($periksa_array as $k => $periksa) {
					$terapi_json = $periksa['terapi'];
					$terapi_arr = json_decode($terapi_json,true);
					if ($terapi_arr !='' && count($terapi_arr) != 0) {
						foreach ($terapi_arr as $k => $terapi) {
							if (isset($terapi['merek_id'])) {
								$t = new Terapi;
								$t->merek_id = $terapi['merek_id'];
								$t->signa = $terapi['signa'];
								$t->aturan_minum = $terapi['aturan_minum'];
								$t->jumlah = $terapi['jumlah'];
								$t->harga_beli_satuan = Merek::find($terapi['merek_id'])->rak->harga_beli;
								$t->harga_jual_satuan = Merek::find($terapi['merek_id'])->rak->harga_jual * $periksa->asuransi->kali_obat;
								$t->periksa_id = $periksa['id'];
								$t->created_at = $periksa['created_at'];
								$t->updated_at = $periksa['updated_at'];
								$t->save();
							}
						}
					}
				}
			});

			//insert tabel periksa kolom terapi terapijson agar lebih mudah mengurutkan sejak dimulai laravel sudah dilakukan
			Route::get('terapi3/terapi3', function(){
				$periksas = DB::select("SELECT id, terapi FROM periksas where created_at > '0000-00-00 00:00:00'");
				$inserted = 0;
				foreach ($periksas as $key => $periksa) {
					$terapi = $periksa->terapi;
					$terapi = json_decode($terapi, true);
					$terapi_baru = [];
					$prx = Periksa::find($periksa->id);
					if ($terapi != '') {
						foreach ($terapi as $k => $trp) {
							if (isset($trp['merek_id'])) {
								$merek_id     = $trp['merek_id'];
								$formula_id   = Merek::find($merek_id)->rak->formula_id;
								$signa        = $trp['signa'];
								$jumlah       = $trp['jumlah'];

								$terapi_baru[] = [
									'formula_id' => $formula_id,
									'signa'      => $signa,
									'jumlah'     => $jumlah
								];
							}
						}
						array_multisort($terapi_baru);
						$prx->terapi = json_encode($terapi_baru);
						$confirm = $prx->save();
						if ($confirm) {
							$inserted++;
						}
					}
				}
				return $inserted . ' updated';
			});

			//memasukkan terapi json terbaru ke kolom terapi tabel periksa untuk memudahkan pengurutan sebelum pakai laravel sesudah pakai aplikasi sendiri
			//belum dikerjakan
			Route::get('terapi4/terapi4', function(){
				$periksas = DB::select("SELECT id, terapi FROM periksas where created_at = '0000-00-00 00:00:00' and id in (select periksa_id from terapis)");
				foreach ($periksas as $key => $periksa) {
					$terapi = Terapi::where('periksa_id', $periksa->id)->get();
					// return var_dump(Periksa::find($periksa->id));
					$terapi_baru = [];
					$prx = Periksa::find($periksa->id);
						foreach ($terapi as $k => $trp) {
							$merek_id     = $trp['merek_id'];
							$formula_id   = Merek::find($merek_id)->rak->formula_id;
							$signa        = $trp['signa'];
							$jumlah       = $trp['jumlah'];

							$terapi_baru[] = [
								'formula_id' => $formula_id,
								'signa'      => $signa,
								'jumlah'     => $jumlah
							];
						}
						array_multisort($terapi_baru);
						// return $terapi_baru;
						$prx->terapi = json_encode($terapi_baru);
						$prx->save();
				}

			});
			//insert terapis saat bikin punya sendiri
			////belum dikerjakan


			Route::get('terapi2/terapi2', function(){
				$updated = 0;
				$periksas = Periksa::where('id', '>=', '150810001')->get();
				foreach($periksas as $periksa){
					if (Terapi::where('periksa_id', $periksa->id)->count() == 0) {
						$terapis = DB::select("select asu.kali_obat as kali_obat, t.merek_id as merek_id, m.merek, s.signa, am.aturan_minum, t.jumlah, t.periksa_id as periksa_id from terapi as t join mereks as m on m.id = t.merek_id join signas as s on s.id = t.signa join aturan_minums as am on am.id = t.aturan_minum join periksas as px on px.id = t.periksa_id join asuransis as asu on asu.id = px.asuransi_id where periksa_id = '{$periksa->id}' order by t.id;");
						foreach ($terapis as $k => $terapi) {
							$t = new Terapi;
							$t->merek_id = $terapi->merek_id;
							$t->signa = $terapi->signa;
							$t->aturan_minum = $terapi->aturan_minum;
							$t->harga_beli_satuan = Merek::find($terapi->merek_id)->rak->harga_beli;
							$t->harga_jual_satuan = Merek::find($terapi->merek_id)->rak->harga_jual * $terapi->kali_obat;
							$t->jumlah = $terapi->jumlah;
							$t->periksa_id = $terapi->periksa_id;
							$confirm = $t->save();
							if ($confirm) {
								$updated++;
							}
						}
					}
				}

				return $updated . ' data inserted';

			});
			//insert ke tabel transaksi dari tabel yang ada transaksi json nya
			////belum dilakukan
			Route::get('transaksi/transaksi', function(){
				$periksas = Periksa::where('created_at', '>', '0000-00-00 00:00:00')->get();
				foreach ($periksas as $k => $periksa) {
					if (TransaksiPeriksa::where('periksa_id', $periksa->id)->count() == 0) {
						$terapi_json = $periksa->transaksi;
						$terapi_arr = json_decode($terapi_json,true);
						foreach ($terapi_arr as $k => $terapi) {
							$t = new TransaksiPeriksa;
							$t->periksa_id = $periksa->id;
							if (isset($terapi['jenis_tarif_id'])) {
								$t->jenis_tarif_id = $terapi['jenis_tarif_id'];
							} else {
								return $periksa->id;
							}
							$t->biaya = $terapi['biaya'];
							$t->created_at = $periksa->created_at;
							$t->updated_at = $periksa->updated_at;
							$t->save();
						}
					}
				}
			});
    Route::resource('users', 'UsersController');
  	Route::group(['middleware' => 'auth'], function(){



			Route::get('diagnosa/tidakdirujuk', 'TidakdirujukController@index');
			Route::get('memcached', 'MemcachedController@index');
			Route::get('memcached/data', 'MemcachedController@data');
			Route::get('perujuks/kecil', function(){
				return View::make('perujuks.kecil');
			});


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
			Route::get('pengeluarans/{id}', 'PengeluaransController@index');
			Route::post('pengeluarans/ketkeluar', 'PengeluaransController@ketkeluar');

			Route::get('pengeluarans/bayardoker/{id}', 'PengeluaransController@bayardokter');
			Route::get('pengeluarans/bayardokter/bayar', 'PengeluaransController@dokterbayar');
			Route::post('pengeluarans/bayardokter/bayar', 'PengeluaransController@dokterdibayar');


			Route::post('fasilitas/destroy', 'FasilitasController@destroy'); //penjualan obat tanpa resep
			Route::post('fasilitas/update_tujuan_rujuk', 'FasilitasController@update'); //penjualan obat tanpa resep

			Route::get('cek/cek', function(){
				return View::make('antrianpolis.oke');
			});


			Route::get('fakturbelanjas', 'FakturBelanjasController@index');
			Route::get('fakturbelanjas/cari', 'FakturBelanjasController@cari');
			Route::post('fakturbelanjas', 'FakturBelanjasController@store');
			Route::get('fakturbelanjas/{id}', 'FakturBelanjasController@destroy');

			Route::get('sops/{icd10}/{diagnosa_id}/{asuransi_id}/{berat_badan_id}', 'SopsController@index');
			Route::post('sops', 'SopsController@store');

			//membuat rak baru berdasarkan formula_id
			Route::get('create/raks/{id}', 'CustomController@create_rak');
			Route::get('mereks/buyhistory/{id}', 'CustomController@buyhistory');

			//membuat merek baru berdasarkan merek_id
			Route::get('create/mereks/{id}', 'CustomController@create_merek');

			
			Route::get('jurnal_umums', 'JurnalUmumsController@index');
			Route::get('jurnal_umums/coa', 'JurnalUmumsController@coa');
			Route::post('jurnal_umums/coa', 'JurnalUmumsController@coaPost');


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

			Route::get('pendapatans/create', 'PendapatansController@create');
			Route::post('pendapatans/index', 'PendapatansController@store');

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

			Route::get('pdfs/status/{periksa_id}', 'PdfsController@status');
			Route::get('pdfs/kuitansi/{periksa_id}', 'PdfsController@kuitansi');

			Route::get('stokopnames', 'StokOpnamesController@index');
			Route::post('stokopnames', 'StokOpnamesController@store');
			Route::post('stokopnames/awal', 'StokOpnamesController@awal');
			Route::post('stokopnames/change', 'StokOpnamesController@change');
			Route::post('stokopnames/destroy', 'StokOpnamesController@destroy');

			Route::post('suppliers/ajax/ceknotalama', 'SuppliersAjaxController@ceknotalama');

			Route::get('terapis/{periksa_id}', 'TerapisController@index');

  	});



	




		
