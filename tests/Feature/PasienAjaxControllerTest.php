<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Pasien;
use Illuminate\Http\Testing\File;
use Storage;

class PasienAjaxControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_cariPasien(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $response = $this->get("pasiens/ajax/cari");
        $response->assertStatus(200);
    }
}

/* public function ajaxpasiens() */
/* public function ajaxpasien() */
/* public function create() */
/* public function cekbpjskontrol() */
/* public function confirm_staf() */
/* public function cekAntrianPerTanggal() */
/* public function cekPromo() */
/* public function dataPasien() */
/* public function pecah($nama) */
/* public function ajaxTanggalLahir() */
/* public function cekNomorBpjsSama() */
/* public function statusCekGDSBulanIni() */


/* Route::get('pasiens/ajax/ajaxpasiens', [\App\Http\Controllers\PasiensAjaxController::class, 'ajaxpasiens']); */
/* Route::post('pasiens/ajax/ajaxpasien', [\App\Http\Controllers\PasiensAjaxController::class, 'ajaxpasien']); */
/* Route::post('pasiens/ajax/create', [\App\Http\Controllers\PasiensAjaxController::class, 'create']); */
/* Route::post('pasiens/ajax/cekbpjskontrol', [\App\Http\Controllers\PasiensAjaxController::class, 'cekbpjskontrol']); */
/* Route::post('pasiens/ajax/confirm_staf', [\App\Http\Controllers\PasiensAjaxController::class, 'confirm_staf']); */
/* Route::post('pasiens/ajax/cekantrian/tanggal', [\App\Http\Controllers\PasiensAjaxController::class, 'cekAntrianPerTanggal']); */
/* Route::get('pasiens/ajax/cekPromo', [\App\Http\Controllers\PasiensAjaxController::class, 'cekPromo']); */
/* Route::get('pasiens/ajax/status_cel_gds_bulan_ini', [\App\Http\Controllers\PasiensAjaxController::class, 'statusCekGDSBulanIni']); */
