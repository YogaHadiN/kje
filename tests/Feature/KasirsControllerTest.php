<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Saldo;
use Illuminate\Http\Testing\File;
use Storage;

class KasirsControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_saldo(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);
        $response = $this->get('kasirs/saldo');
        $response->assertStatus(200);

    }

    public function test_saldoPost(){
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

        $saldo   = $this->faker->numerify('Rp. ###.###');
        $staf_id = \App\Models\Staf::factory()->create()->id;

        \App\Models\CheckoutKasir::factory()->create();
        \App\Models\Coa::factory()->create([
            'kode_coa' => 110000
        ]);

        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
            "saldo"   => $saldo,
            "staf_id" => $staf_id,
        ];

        $response = $this->post('kasirs/saldo', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $kasirs = Saldo::query()
                ->where("staf_id", $staf_id)
        ->get();

            if ( !$kasirs->count() ) {
                $kasirs = Saldo::all();
                $kasir_array = [];
                foreach ($kasirs as $a) {
                    $kasir_array[] = [
                        "staf_id"             => $a->staf_id,
                    ];
                }
                dd(  [
                        "staf_id"             => $staf_id,
                    ],
                    $kasir_array
                );
            }

        $this->assertCount(1, $kasirs);
        $response->assertRedirect('/');
    }
    /**
     * 
     */
    public function test_keluar_masuk_kasir(){
        $user     = User::factory()->create([
                        'role_id' => 6
                    ]);
        auth()->login($user);
        \App\Models\CheckoutKasir::factory()->create();
        \App\Models\Coa::factory()->create([
            'kode_coa' => 110000
        ]);
        $response = $this->get("kasir/keluar_masuk_kasir");
        $response->assertStatus(200);
    }

    public function test_a_user_can_only_see_saldo_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        Saldo::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        Saldo::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Saldo::count());
    }

    /** @test */
    public function test_a_user_can_only_create_a_saldo_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdKasir = Saldo::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdKasir->tenant_id == $user1->tenant_id);
    }
}

/* Route::get('kasir/keluar_masuk_kasir', [\App\Http\Controllers\KasirsController::class, 'keluar_masuk_kasir']); */
/* public function pasienPertamaBelumDikirim() */
/* public function keluar_masuk_kasir() */
