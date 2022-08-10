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

        $response = $this->post('penjualans', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $penjualans = Penjualan::query()
                ->where("nama", $nama)
        ->get();

            /* if ( !$penjualans->count() ) { */
            /*     $penjualans = Penjualan::all(); */
            /*     $penjualan_array = []; */
            /*     foreach ($penjualans as $a) { */
            /*         $penjualan_array[] = [ */
            /*             "nama"             => $a->nama, */
            /*         ]; */
            /*     } */
            /*     dd(  [ */
            /*             "nama"             => $nama, */
            /*         ], */
            /*         $penjualan_array */
            /*     ); */
            /* } */

        $this->assertCount(1, $penjualans);

        $penjualan = $penjualans->first();

        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $this->checkForUploadedFile($nama, $model->nama); */

        checkForUploadedFile($image, $penjualan->image);

        $response->assertRedirect('penjualans');
    }
    public function test_show(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $penjualan = Penjualan::factory()->create();
        $response = $this->get('penjualans/' . $penjualan->id);
        $response->assertStatus(200);
    }
    public function test_edit(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $penjualan = Penjualan::factory()->create();
        $response = $this->get('penjualans/' . $penjualan->id . '/edit');
        $response->assertStatus(200);
    }
    public function test_destroy(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $penjualan = Penjualan::factory()->create();
        $response = $this->delete('penjualans/' . $penjualan->id);
        $response->assertRedirect('penjualans');
        $this->assertDeleted($penjualan);
    }

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
