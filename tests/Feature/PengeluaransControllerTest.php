<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Pengeluaran;
use Illuminate\Http\Testing\File;
use Storage;

class PengeluaransControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $faktur_belanja = \App\Models\FakturBelanja::factory()->create();
        $response = $this->get('pengeluarans/' . $faktur_belanja->id);
        $response->assertStatus(200);
    }
    public function test_show(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $pengeluaran = \App\Models\Pengeluaran::factory()->create();
        $response = $this->get('pengeluarans/show/' . $pengeluaran->id);
        $response->assertStatus(200);
    }
    public function test_data(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $pengeluaran = \App\Models\Pengeluaran::factory()->create();
        $response = $this->get('pengeluarans/data');
        $response->assertStatus(200);
    }
    public function test_erce(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>301000
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' =>110004
        ]);

        $pengeluaran = \App\Models\Pengeluaran::factory()->create();
        $response = $this->get('pengeluarans/rc');
        $response->assertStatus(200);
    }

    public function test_nota_z(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>301000
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' =>110004
        ]);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>110000
        ]);
        \App\Models\CheckoutKasir::factory()->create();
        $pengeluaran = \App\Models\Pengeluaran::factory()->create();
        $response = $this->get('pengeluarans/nota_z');
        $response->assertStatus(200);
    }
    public function test_gojek(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>301000
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' =>110004
        ]);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>110000
        ]);
        \App\Models\CheckoutKasir::factory()->create();
        $pengeluaran = \App\Models\Pengeluaran::factory()->create();
        $response = $this->get('pengeluarans/gojek');
        $response->assertStatus(200);
    }
    public function test_inputHarta(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>301000
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' =>110004
        ]);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>110000
        ]);
        \App\Models\CheckoutKasir::factory()->create();
        $pengeluaran = \App\Models\Pengeluaran::factory()->create();
        $response = $this->get('pengeluarans/input_harta');
        $response->assertStatus(200);
    }

    public function test_peralatans(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>301000
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' =>110004
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' =>110000
        ]);
        \App\Models\CheckoutKasir::factory()->create();
        $pengeluaran = \App\Models\Pengeluaran::factory()->create();
        $response = $this->get('pengeluarans/peralatans');
        $response->assertStatus(200);
    }
    public function test_belanjaPeralatan(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>301000
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' =>110004
        ]);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>110000
        ]);
        \App\Models\CheckoutKasir::factory()->create();
        $pengeluaran = \App\Models\Pengeluaran::factory()->create();
        $response = $this->get('pengeluarans/belanja/peralatan');
        $response->assertStatus(200);
    }
    public function test_bagiHasilGigi(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>301000
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' =>110004
        ]);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>110000
        ]);
        \App\Models\CheckoutKasir::factory()->create();
        $pengeluaran = \App\Models\Pengeluaran::factory()->create();
        $response = $this->get('pengeluarans/bagi_hasil_gigi');
        $response->assertStatus(200);
    }
    public function test_GolonganPeralatanCreate(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>301000
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' =>110004
        ]);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>110000
        ]);
        \App\Models\CheckoutKasir::factory()->create();
        $pengeluaran = \App\Models\Pengeluaran::factory()->create();
        $response = $this->get('pengeluarans/peralatans/golongan_peralatans/create');
        $response->assertStatus(200);
    }
    public function test_product(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>301000
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' =>110004
        ]);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>110000
        ]);
        \App\Models\CheckoutKasir::factory()->create();
        $pengeluaran = \App\Models\Pengeluaran::factory()->create();
        $response = $this->get('ajax/products');
        $response->assertStatus(200);
    }
    public function test_belanjaBukanObatDetail(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>301000
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' =>110004
        ]);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>110000
        ]);
        $pengeluaran = \App\Models\Pengeluaran::factory()->create();
        $faktur_belanja = \App\Models\FakturBelanja::factory()->create();
        $response = $this->get('pengeluarans/belanja_bukan_obat/detail/' . $faktur_belanja->id);
        $response->assertStatus(200);
    }
    public function test_peralatan_detail(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>301000
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' =>110004
        ]);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>110000
        ]);
        $pengeluaran = \App\Models\Pengeluaran::factory()->create();
        $faktur_belanja = \App\Models\FakturBelanja::factory()->create();
        $staf = \App\Models\Staf::factory()->create();
        $response = $this->get('pengeluarans/peralatans/detail/' . $pengeluaran->id);
        $response->assertStatus(200);
    }
    public function test_a_user_can_only_see_pengeluaran_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        Pengeluaran::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        Pengeluaran::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Pengeluaran::count());
    }

    public function test_a_user_can_only_create_a_pengeluaran_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdPengeluaran = Pengeluaran::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdPengeluaran->tenant_id == $user1->tenant_id);
    }
}
/* Route::get('pdfs/notaz/keluar_masuk/{id}', [\App\Http\Controllers\PengeluaransController::class, 'nota_z_keluar_masuk']); */
/* Route::get('pengeluarans/nota_z/detail/{id}', [\App\Http\Controllers\PengeluaransController::class, 'notaz_detail']); */
/* Route::get('pengeluarans/input_harta/show/{id}', [\App\Http\Controllers\PengeluaransController::class, 'showInputHarta']); */
/* Route::post('pengeluarans/list', [\App\Http\Controllers\PengeluaransController::class, 'lists']); */
/* Route::post('pengeluarans/data/ajax', [\App\Http\Controllers\PengeluaransController::class, 'dataAjax']); */
/* Route::post('pengeluarans', [\App\Http\Controllers\PengeluaransController::class, 'store']); */
/* route::post('pengeluarans/nota_z', [\App\Http\Controllers\PengeluaransController::class, 'notaz_post']); */
/* Route::post('pengeluarans/rc', [\App\Http\Controllers\PengeluaransController::class, 'erce_post']); */
/* Route::post('pengeluarans/ketkeluar', [\App\Http\Controllers\PengeluaransController::class, 'ketkeluar']); */
/* Route::post('pengeluarans/input_harta', [\App\Http\Controllers\PengeluaransController::class, 'postInputHarta']); */
/* Route::post('pengeluarans/gojek/tambah/gopay', [\App\Http\Controllers\PengeluaransController::class, 'tambahGopay']); */
/* Route::post('pengeluarans/gojek/pakai', [\App\Http\Controllers\PengeluaransController::class, 'pakaiGopay']); */
/* Route::post('pengeluarans/confirm_staf', [\App\Http\Controllers\PengeluaransController::class, 'confirm_staf']); */
/* Route::post('pengeluarans/bayar_bonus_karyawan/{staf_id}', [\App\Http\Controllers\PengeluaransController::class, 'bayar_bonus']); */
/* Route::post('pengeluarans/bagi_hasil_gigi', [\App\Http\Controllers\PengeluaransController::class, 'bagiHasilGigiPost']); */
/* Route::delete('pengeluarans/bagi_hasil_gigi/{id}', [\App\Http\Controllers\PengeluaransController::class, 'bagiHasilGigiDelete']); */
/* Route::post('pengeluarans/peralatans/golongan_peralatans/store', [\App\Http\Controllers\PengeluaransController::class, 'GolonganPeralatanPost']); */
/* Route::post('pengeluarans/belanja/peralatan/bayar', [\App\Http\Controllers\PengeluaransController::class, 'belanjaPeralatanBayar']); */
/* Route::delete('pengeluarans/{id}', [\App\Http\Controllers\PengeluaransController::class, 'destroy']); */
/* Route::get('pengeluarans/checkout/{id}', [\App\Http\Controllers\PengeluaransController::class, 'show_checkout']); */
/* Route::get('pengeluarans/belanjaPeralatan/getObject/belanjaPeralatan', [\App\Http\Controllers\PengeluaransController::class, 'getBelanjaPeralatanObject']); */
