<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
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

/* Route::get('pdfs/amortisasi/{tahun}', [\App\Http\Controllers\PdfsController::class, 'amortisasi']); */
    /**
     * @group failing
     */
    public function test_amortisasi(){
        $user     = User::factory()->create([
                    'role_id' => 6
                ]);
        auth()->login($user);
        $response = $this->get('pdfs/amortisasi/'. date('Y'));
        $response->assertStatus(200);
    }

    public function test_store(){
        Storage::fake('s3');
        // make a request with file


        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

          $nama                        = $this->faker->name;

        /* sebelum kesini ke acting as dulu */
        /* key mapping l */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = File::create('nama.png', 100) */

        $image                      = File::create('image.png', 100);

        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
                "nama"                        => $nama,
        ];

        $response = $this->post('pdfs', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $pdfs = Pdf::query()
                ->where("nama", $nama)
        ->get();

            /* if ( !$asuransis->count() ) { */
            /*     $pdfs = Pdf::all(); */
            /*     $pdf_array = []; */
            /*     foreach ($pdfs as $a) { */
            /*         $pdf_array[] = [ */
            /*             "nama"             => $a->nama, */
            /*         ]; */
            /*     } */
            /*     dd(  [ */
            /*             "nama"             => $nama, */
            /*         ], */
            /*         $asu_array */
            /*     ); */
            /* } */

        $this->assertCount(1, $pdfs);

        $pdf = $pdfs->first();

        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $this->checkForUploadedFile($nama, $model->nama); */

        checkForUploadedFile($image, $pdf->image);

        $response->assertRedirect('pdfs');
    }
    public function test_show(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $pdf = Pdf::factory()->create();
        $response = $this->get('pdfs/' . $pdf->id);
        $response->assertStatus(200);
    }
    public function test_edit(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $pdf = Pdf::factory()->create();
        $response = $this->get('pdfs/' . $pdf->id . '/edit');
        $response->assertStatus(200);
    }
    public function test_destroy(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $pdf = Pdf::factory()->create();
        $response = $this->delete('pdfs/' . $pdf->id);
        $response->assertRedirect('pdfs');
        $this->assertDeleted($pdf);
    }

    public function test_a_user_can_only_see_pdf_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        Pdf::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        Pdf::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Pdf::count());
    }

    /** @test */
    public function test_a_user_can_only_create_a_pdf_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdPdf = Pdf::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdPdf->tenant_id == $user1->tenant_id);
    }
}

/* Route::get('pdfs/peredaranBruto/{tahun}', [\App\Http\Controllers\PdfsController::class, 'peredaranBruto']); */
/* Route::get('pdfs/status/{periksa_id}', [\App\Http\Controllers\PdfsController::class, 'status']); */
/* Route::get('pdfs/label_obat/{periksa_id}', [\App\Http\Controllers\PdfsController::class, 'label_obat']); */
/* Route::get('pdfs/bagi_hasil_gigi/{id}', [\App\Http\Controllers\PdfsController::class, 'bagiHasilGigi']); */
/* Route::get('pdfs/status/a4/{periksa_id}', [\App\Http\Controllers\PdfsController::class, 'status_a4']); */
/* Route::get('pdfs/dispensing/{rak_id}/{mulai}/{akhir}', [\App\Http\Controllers\PdfsController::class, 'dispensing']); */
/* Route::get('pdfs/kuitansi/{periksa_id}', [\App\Http\Controllers\PdfsController::class, 'kuitansi']); */
/* Route::get('pdfs/struk/{periksa_id}', [\App\Http\Controllers\PdfsController::class, 'struk']); */
/* Route::get('pdfs/jasadokter/{bayar_dokter_id}', [\App\Http\Controllers\PdfsController::class, 'jasa_dokter']); */
/* Route::get('pdfs/pembelian/{faktur_belanja_id}', [\App\Http\Controllers\PdfsController::class, 'pembelian']); */
/* Route::get('pdfs/penjualan/{nota_jual_id}', [\App\Http\Controllers\PdfsController::class, 'penjualan']); */
/* Route::get('pdfs/pendapatan/{nota_jual_id}', [\App\Http\Controllers\PdfsController::class, 'pendapatan']); */
/* Route::get('pdfs/pembayaran_asuransi/{pembayaran_asuransi_id}', [\App\Http\Controllers\PdfsController::class, 'pembayaran_asuransi']); */
/* Route::get('pdfs/notaz/{checkout_kasir_id}', [\App\Http\Controllers\PdfsController::class, 'notaz']); */
/* Route::get('pdfs/rc/{modal_id}', [\App\Http\Controllers\PdfsController::class, 'rc']); */
/* Route::get('pdfs/bayar_gaji_karyawan/{bayar_gaji_id}', [\App\Http\Controllers\PdfsController::class, 'bayar_gaji_karyawan']); */
/* Route::get('pdfs/ns/{no_sale_id}', [\App\Http\Controllers\PdfsController::class, 'ns']); */
/* Route::get('pdfs/pengeluaran/{id}', [\App\Http\Controllers\PdfsController::class, 'pengeluaran']); */
/* Route::get('pdfs/formulir/usg/{id}/{asuransi_id}', [\App\Http\Controllers\PdfsController::class, 'formUsg']); */
/* Route::get('pdfs/merek', [\App\Http\Controllers\PdfsController::class, 'merek']); */
/* Route::get('pdfs/laporan_laba_rugi/{tahun_awal}/{tanggal_akhir}', [\App\Http\Controllers\PdfsController::class, 'laporanLabaRugi']); */
/* Route::get('pdfs/laporan_laba_rugi/bikinan/{tahun_awal}/{tanggal_akhir}', [\App\Http\Controllers\PdfsController::class, 'laporanLabaRugiBikinan']); */
/* Route::get('pdfs/laporan_neraca/{tahun}', [\App\Http\Controllers\PdfsController::class, 'laporanNeraca']); */
/* Route::get('pdfs/jurnal_umum/{bulan}/{tahun}', [\App\Http\Controllers\PdfsController::class, 'jurnalUmum']); */
/* Route::get('pdfs/buku_besar/{bulan}/{tahun}/{coa_id}', [\App\Http\Controllers\PdfsController::class, 'jurnalUmum']); */
/* Route::get('pdfs/kuitansiPerBulan/{bulan}/{tahun}', [\App\Http\Controllers\PdfsController::class, 'kuitansiPerBulan']); */
/* Route::get('pdfs/struk/perbulan/{bulan}/{tahun}', [\App\Http\Controllers\PdfsController::class, 'strukPerBulan']); */
/* Route::get('pdfs/struk/pertanggal/{tahun}/{bulan}/{tanggal}', [\App\Http\Controllers\PdfsController::class, 'strukPerTanggal']); */
/* Route::get('pdfs/piutang/belum_dibayar/{id}/{mulai}/{akhir}', [\App\Http\Controllers\PdfsController::class, 'piutangAsuransiBelumDibayar']); */
/* Route::get('pdfs/piutang/sudah_dibayar/{id}/{mulai}/{akhir}', [\App\Http\Controllers\PdfsController::class, 'piutangAsuransiSudahDibayar']); */
/* Route::get('pdfs/piutang/semua/{id}/{mulai}/{akhir}', [\App\Http\Controllers\PdfsController::class, 'piutangAsuransi']); */
/* Route::get('pdfs/kirim_berkas/{id}', [\App\Http\Controllers\PdfsController::class, 'kirim_berkas']); */
/* Route::get('pdfs/antrian/{id}', [\App\Http\Controllers\PdfsController::class, 'antrian']); */
/* Route::get('pdfs/prolanis_hipertensi_perbulan/{bulanTahun}', [\App\Http\Controllers\PdfsController::class, 'prolanisHipertensiPerBulan']); */
/* Route::get('pdfs/prolanis_dm_perbulan/{bulanTahun}', [\App\Http\Controllers\PdfsController::class, 'prolanisDmPerBulan']); */
/* Route::get('pdfs/rapid/antigen/{periksa_id}', [\App\Http\Controllers\PdfsController::class, 'hasilAntigen']); */
/* Route::get('pdfs/rapid/antibodi/{periksa_id}', [\App\Http\Controllers\PdfsController::class, 'hasilAntibodi']); */
