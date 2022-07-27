<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\Coa;
use App\Models\User;
use App\Models\JurnalUmum;
use Illuminate\Http\Testing\File;
use Storage;
use Arr;
class JurnalUmumControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_show(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $periksa = \App\Models\Periksa::factory()->create();
        \App\Models\JurnalUmum::factory(30)->create([
            'jurnalable_type' => 'App\\Models\\Periksa',
            'jurnalable_id' => $periksa->id
        ]);
        $response = $this->get('jurnal_umums/show?' . Arr::query([
            'bulan' => date('m'),
            'tahun' => date('Y')
        ]));
        $response->assertStatus(200);
    }

    public function test_penyusutan(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $response = $this->get('jurnal_umums/penyusutan');
        $response->assertStatus(200);
    }

    /**
     * 
     */
    public function test_coa(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);


        Coa::factory()->create([
            'kode_coa' => 120001,
            'coa' =>  'Belanja Peralatan'
        ]);
        Coa::factory()->create([
            'kode_coa' => 112001,
            'coa' =>  'Persediaan Pulsa Go Pay'
        ]);
        Coa::factory()->create([
            'kode_coa' => 612345,
            'coa' =>  'Biaya Operasional Gojek'
        ]);
        Coa::factory()->create([
            'kode_coa' => 120010,
            'coa' =>  'Peralatan Bahan Bangunan'
        ]);
        $response = $this->get('jurnal_umums/coa');
        $response->assertStatus(200);
    }
    public function test_a_user_can_only_see_jurnal_umum_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
            JurnalUmum::factory()->create([
                'tenant_id' => $tenant1,
            ]);
        }

        for ($x = 0; $x < 11; $x++) {
            JurnalUmum::factory()->create([
                'tenant_id' => $tenant2,
            ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, JurnalUmum::count());
    }

    /** @test */
    public function test_a_user_can_only_create_a_jurnal_umum_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdJurnalUmum = JurnalUmum::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdJurnalUmum->tenant_id == $user1->tenant_id);
    }
}
    /* Route::post('jurnal_umums/coa', [\App\Http\Controllers\JurnalUmumsController::class, 'coaPost']); */
    /* Route::get('jurnal_umums/coa_list', [\App\Http\Controllers\JurnalUmumsController::class, 'coa_list']); */
    /* Route::get('jurnal_umums/coa_keterangan', [\App\Http\Controllers\JurnalUmumsController::class, 'coa_keterangan']); */
    /* Route::post('jurnal_umums/coa_entry', [\App\Http\Controllers\JurnalUmumsController::class, 'coa_entry']); */
    /* Route::get('jurnal_umums/hapus/jurnals', [\App\Http\Controllers\JurnalUmumsController::class, 'hapus_jurnals']); */
    /* Route::get('jurnal_umums/{id}/edit', [\App\Http\Controllers\JurnalUmumsController::class, 'edit']); */
    /* Route::put('jurnal_umums/{id}', [\App\Http\Controllers\JurnalUmumsController::class, 'update']); */
    /* Route::get('jurnal_umums/omset_pajak', [\App\Http\Controllers\JurnalUmumsController::class, 'omset_pajak']); */
    /* Route::post('jurnal_umums/manual', [\App\Http\Controllers\JurnalUmumsController::class, 'inputManualPost']); */
    /* Route::get('jurnal_umums/manual', [\App\Http\Controllers\JurnalUmumsController::class, 'inputManual']); */

    /* Route::get('peralatans/konfirmasi', [\App\Http\Controllers\JurnalUmumsController::class, 'peralatan']); */
    /* Route::post('peralatans/konfirmasi', [\App\Http\Controllers\JurnalUmumsController::class, 'postPeralatan']); */
    /* Route::get('service_ac/konfirmasi', [\App\Http\Controllers\JurnalUmumsController::class, 'serviceAc']); */
    /* Route::post('service_ac/konfirmasi', [\App\Http\Controllers\JurnalUmumsController::class, 'postServiceAc']); */

	/* public function coaPost() */
	/* public function edit($id) */
	/* public function destroy($id) */
    /* public function coa_list() */
    /* public function coa_keterangan() */
    /* public function coa_entry() */
    /* public function hapus_jurnals() */
	/* public function update($id) */
	/* public function inputManual() */
	/* public function inputManualPost() */
	/* public function penyusutan() */
	/* public function peralatan() */
	/* public function postPeralatan() */
	/* public function serviceAc() */
	/* public function postServiceAc() */
	/* public function queryKonfirmasiServiceAc() */
	/* public function queryKonfirmasiPeralatan() */
	/* public function queryRenovasiBulanIni($bulanIni, $count = true) */
	/* public function queryKonfirmasi($coa_id) */
	/* public function omset_pajak() */
