<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\Coa;
use App\Models\User;
use App\Models\Pdf;
use Illuminate\Http\Testing\File;
use Storage;

class PdfsControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    public function test_jumlahPasienPerTahun(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $staf    = \App\Models\Staf::factory()->create();
        $periksa = \App\Models\Periksa::factory(30)->create([
            'staf_id' => $staf->id
        ]);
        $response = $this->get('stafs/'. $staf->id .'/jumlah_pasien/pertahun/'. date('Y').'/pdf');

        $response->assertStatus(200);
    }

    public function test_amortisasi(){
        $user     = User::factory()->create([
                    'role_id' => 6
                ]);
        auth()->login($user);
        $response = $this->get('pdfs/amortisasi/'. date('Y'));
        $response->assertStatus(200);
    }

    public function test_peredaranBruto(){
        $user     = User::factory()->create([
                    'role_id' => 6
                ]);
        auth()->login($user);
        \App\Models\Coa::factory()->create([
            'kode_coa' => 70100
        ]);
        $response = $this->get('pdfs/peredaranBruto/'. date('Y'));
        $response->assertStatus(200);
    }

    public function test_status(){
        $user     = User::factory()->create([
                    'role_id' => 6
                ]);
        auth()->login($user);
        \App\Models\Asuransi::factory()->create([
            'tipe_asuransi_id' => 5
        ]);
        $periksa             = \App\Models\Periksa::factory()->create();
        $cut                 = new CustomControllerTest;
        $periksa->transaksi = $cut->transaksis($periksa->asuransi_id);
        $periksa->save();
        $response            = $this->get('pdfs/status/' . $periksa->id);
        $response->assertStatus(200);
    }

    public function test_label_obat(){
        $user     = User::factory()->create([
                    'role_id' => 6
                ]);
        auth()->login($user);
        $periksa = \App\Models\Periksa::factory()->create();
        $response = $this->get('pdfs/label_obat/'. $periksa->id);
        $response->assertStatus(200);
    }

    public function test_bagiHasilGigi(){
        $user     = User::factory()->create([
                    'role_id' => 6
                ]);
        auth()->login($user);
        $id = \App\Models\BagiGigi::factory()->create()->id;
        $response = $this->get('pdfs/bagi_hasil_gigi/' . $id);
        $response->assertStatus(200);
    }

    public function test_status_a4(){
        $user     = User::factory()->create([
                    'role_id' => 6
                ]);
        auth()->login($user);
        $periksa = \App\Models\Periksa::factory()->create();
        \App\Models\Asuransi::factory()->create([
            'tipe_asuransi_id' => 5
        ]);
        $cut                 = new CustomControllerTest;
        $periksa->transaksi = $cut->transaksis($periksa->asuransi_id);
        $periksa->save();
        $response = $this->get('pdfs/status/a4/' . $periksa->id);
        $response->assertStatus(200);
    }
    public function test_dispensing(){

        $user     = User::factory()->create([
                    'role_id' => 6
                ]);
        auth()->login($user);

        $merek = \App\Models\Merek::factory()->create();
        $response = $this->get('pdfs/dispensing/'. $merek->id.'/'. date('Y-m-t'). '/' . date('Y-m-01'));
        $response->assertStatus(200);
    }

    public function test_kuitansi(){

        $user     = User::factory()->create([
                    'role_id' => 6
                ]);
        auth()->login($user);

        $periksa = \App\Models\Periksa::factory()->create();
        $cut                 = new CustomControllerTest;
        $periksa->transaksi = $cut->transaksis($periksa->asuransi_id);
        $periksa->save();
        $response = $this->get('pdfs/kuitansi/' . $periksa->id);
        $response->assertStatus(200);
    }

    public function test_struk(){

        $user     = User::factory()->create([
                    'role_id' => 6
                ]);
        auth()->login($user);

        $periksa = \App\Models\Periksa::factory()->create();

        $response = $this->get('pdfs/struk/' . $periksa->id);
        $response->assertStatus(200);
    }

    public function test_pembelian(){

        $user     = User::factory()->create([
                    'role_id' => 6
                ]);
        auth()->login($user);

        $faktur_belanja = \App\Models\FakturBelanja::factory()->create();
        $response = $this->get('pdfs/pembelian/' . $faktur_belanja->id);
        $response->assertStatus(200);
    }

    public function test_penjualan(){
        $user     = User::factory()->create([
                    'role_id' => 6
                ]);
        auth()->login($user);

        $nota_jual = \App\Models\NotaJual::factory()->create();
        $nota_jual->jurnals()->create([
            'debit' => 1,
            'nilai' => $this->faker->numerify('###')
        ]);
        $response = $this->get('pdfs/penjualan/'. $nota_jual->id);
        $response->assertStatus(200);
    }

    public function test_pendapatan(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);
        $pendapatan = \App\Models\Pendapatan::factory()->create();
        $response = $this->get('pdfs/pendapatan/'. $pendapatan->id);
        $response->assertStatus(200);
    }
    public function test_pembayaran_asuransi(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $pembayaran_asuransi = \App\Models\PembayaranAsuransi::factory()->create();
        $response = $this->get('pdfs/pembayaran_asuransi/' . $pembayaran_asuransi->id);
        $response->assertStatus(200);
    }
    public function test_rc(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $modal = \App\Models\Modal::factory()->create();
        $response = $this->get('pdfs/rc/' . $modal->id);
        $response->assertStatus(200);
    }

    public function test_ns(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
            
        auth()->login($user);
        $no_sale = \App\Models\NoSale::factory()->create();
        $response = $this->get('pdfs/ns/' . $no_sale->id);
        $response->assertStatus(200);
    }
    public function test_pengeluaran(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);
        $pengeluaran = \App\Models\Pengeluaran::factory()->create();
        $response = $this->get('pdfs/pengeluaran/' . $pengeluaran->id);
        $response->assertStatus(200);
    }
    public function test_formUsg(){

        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $asuransi = \App\Models\Asuransi::factory()->create();
        $pasien = \App\Models\Pasien::factory()->create();
        $response = $this->get('pdfs/formulir/usg/' . $pasien->id . '/' . $asuransi->id);
        $response->assertStatus(200);
    }
    public function test_merek(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $response = $this->get('pdfs/merek');
        $response->assertStatus(200);
    }

    public function test_laporanLabaRugi(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $response = $this->get('pdfs/laporan_laba_rugi/'. date('Y-m-01').'/' . date('Y-m-t'));
        $response->assertStatus(200);
    }
    public function test_laporanLabaRugiBikinan(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $response = $this->get('pdfs/laporan_laba_rugi/bikinan/'. date('Y-m-01').'/' . date('Y-m-t'));
        $response->assertStatus(200);
    }
    public function test_laporanNeraca(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $response = $this->get('pdfs/laporan_neraca/' . date('d-m-Y'));
        $response->assertStatus(200);
    }

    public function test_jurnalUmum(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $response = $this->get('pdfs/jurnal_umum/'. date('m').'/'. date('Y'));
        $response->assertStatus(200);
    }
    public function test_jurnalUmumCoa(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $coa = \App\Models\Coa::factory()->create();
        $response = $this->get('pdfs/buku_besar/'. date('m').'/'. date('Y').'/'. $coa->id);
        $response->assertStatus(200);
    }

    public function test_piutangAsuransiBelumDibayar(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $asuransi = \App\Models\Asuransi::factory()->create();
        $response = $this->get('pdfs/piutang/belum_dibayar/'. $asuransi->id .'/'. date('Y-m-01').'/'. date('Y-m-t'));
        $response->assertStatus(200);
    }
    public function test_piutangAsuransiSudahDibayar(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $asuransi = \App\Models\Asuransi::factory()->create();
        $response = $this->get('pdfs/piutang/sudah_dibayar/'. $asuransi->id .'/'. date('Y-m-01').'/'. date('Y-m-t'));
        $response->assertStatus(200);
    }
    public function test_piutangAsuransi(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $asuransi = \App\Models\Asuransi::factory()->create();
        $response = $this->get('pdfs/piutang/semua/'. $asuransi->id .'/'. date('Y-m-01').'/'. date('Y-m-t'));
        $response->assertStatus(200);
    }
    public function test_kirim_berkas(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $kirim_berkas = \App\Models\KirimBerkas::factory()->create();
        $response = $this->get('pdfs/kirim_berkas/'. $kirim_berkas->id);
        $response->assertStatus(200);
    }
    public function test_antrian(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $antrian = \App\Models\Antrian::factory()->create();
        $response = $this->get('pdfs/antrian/'. $antrian->id);
        $response->assertStatus(200);
    }
    /* public function test_prolanisHipertensiPerBulan(){ */
    /*     $user     = User::factory()->create([ */
    /*         'role_id' => 6 */
    /*     ]); */

        
    /*     auth()->login($user); */

    /*     $coa_11 = Coa::factory()->create([ */
    /*         'kelompok_coa_id' => 11 */
    /*     ]); */
    /*     \App\Models\JurnalUmum::factory(10)->create([ */
    /*         'coa_id' => $coa_11 */
    /*     ]); */
    /*     $coa_12 = Coa::factory()->create([ */
    /*         'kelompok_coa_id' => 12 */
    /*     ]); */
    /*     \App\Models\JurnalUmum::factory(10)->create([ */
    /*         'coa_id' => $coa_12 */
    /*     ]); */
    /*     $coa_2 = Coa::factory()->create([ */
    /*         'kelompok_coa_id' => 2 */
    /*     ]); */
    /*     \App\Models\JurnalUmum::factory(10)->create([ */
    /*         'coa_id' => $coa_2 */
    /*     ]); */
    /*     $coa_3 = Coa::factory()->create([ */
    /*         'kelompok_coa_id' => 3 */
    /*     ]); */
    /*     \App\Models\JurnalUmum::factory(10)->create([ */
    /*         'coa_id' => $coa_2 */
    /*     ]); */
    /*     $response = $this->get('pdfs/prolanis_hipertensi_perbulan/'. date('Y-m')); */
    /*     $response->assertStatus(200); */
    /* } */
}
/* Route::get('pdfs/prolanis_hipertensi_perbulan/{bulanTahun}', [\App\Http\Controllers\PdfsController::class, 'prolanisHipertensiPerBulan']); */
/* Route::get('pdfs/prolanis_dm_perbulan/{bulanTahun}', [\App\Http\Controllers\PdfsController::class, 'prolanisDmPerBulan']); */
/* Route::get('pdfs/rapid/antigen/{periksa_id}', [\App\Http\Controllers\PdfsController::class, 'hasilAntigen']); */
/* Route::get('pdfs/rapid/antibodi/{periksa_id}', [\App\Http\Controllers\PdfsController::class, 'hasilAntibodi']); */


/* Route::get('pdfs/notaz/{checkout_kasir_id}', [\App\Http\Controllers\PdfsController::class, 'notaz']); */
/* Route::get('pdfs/bayar_gaji_karyawan/{bayar_gaji_id}', [\App\Http\Controllers\PdfsController::class, 'bayar_gaji_karyawan']); */
/* Route::get('pdfs/struk/pertanggal/{tahun}/{bulan}/{tanggal}', [\App\Http\Controllers\PdfsController::class, 'strukPerTanggal']); */
