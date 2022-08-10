<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Penjualan;
use Illuminate\Http\Testing\File;
use Storage;

class PenjualansControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index(){
            $user     = User::factory()->create([
                'role_id' => 6
            ]);
        
        auth()->login($user);
        $response = $this->get('penjualans');
        $response->assertStatus(200);
    }
    public function test_obat_buat_karyawan(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $response = $this->get('penjualans/obat_buat_karyawan');
        $response->assertStatus(200);
    }

    /**
     * @group failing
     */

    public function test_a_user_can_only_see_penjualan_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        Penjualan::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        Penjualan::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Penjualan::count());
    }

    /** @test */
    public function test_a_user_can_only_create_a_penjualan_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdPenjualan = Penjualan::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdPenjualan->tenant_id == $user1->tenant_id);
    }
}
/* Route::post('penjualans/obat_buat_karyawan', [\App\Http\Controllers\PenjualansController::class, 'obat_buat_karyawan_post']); //penjualan obat tanpa resep */
/* Route::post('penjualans', [\App\Http\Controllers\PenjualansController::class, 'indexPost']); //penjualan obat tanpa resep */
