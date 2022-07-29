<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Pembelian;
use Illuminate\Http\Testing\File;
use Storage;

class PembeliansControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $response = $this->get('pembelians');
        $response->assertStatus(200);
    }

    public function test_show(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $pembelian = \App\Models\Pembelian::factory()->create();
        $response = $this->get('pembelians/show/'. $pembelian->id);
        $response->assertStatus(200);
    }
    public function test_create(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $pembelian     = \App\Models\Pembelian::factory()->create();
        $fakturBelanja = \App\Models\FakturBelanja::factory()->create();
        $pembelians    = \App\Models\Pembelian::factory(6)->create([
            'faktur_belanja_id' => $fakturBelanja->id
        ]);

        $response = $this->get('pembelians/'. $fakturBelanja->id);
        $response->assertStatus(200);
    }
    /**
     * @group failing
     */
/* Route::get('pembelians/{faktur_beli_id}/edit', [\App\Http\Controllers\PembeliansController::class, 'edit']); */
    public function test_edit(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $pembelian     = \App\Models\Pembelian::factory()->create();
        $fakturBelanja = \App\Models\FakturBelanja::factory()->create();
        $pembelians    = \App\Models\Pembelian::factory(6)->create([
            'faktur_belanja_id' => $fakturBelanja->id
        ]);

        $response = $this->get('pembelians/' . $fakturBelanja->id. '/edit');
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

        $response = $this->post('model_singulars', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $model_singulars = Pembelian::query()
                ->where("nama", $nama)
        ->get();

            /* if ( !$asuransis->count() ) { */
            /*     $model_singulars = Pembelian::all(); */
            /*     $model_singular_array = []; */
            /*     foreach ($model_singulars as $a) { */
            /*         $model_singular_array[] = [ */
            /*             "nama"             => $a->nama, */
            /*         ]; */
            /*     } */
            /*     dd(  [ */
            /*             "nama"             => $nama, */
            /*         ], */
            /*         $asu_array */
            /*     ); */
            /* } */

        $this->assertCount(1, $model_singulars);

        $model_singular = $model_singulars->first();

        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $this->checkForUploadedFile($nama, $model->nama); */

        checkForUploadedFile($image, $model_singular->image);

        $response->assertRedirect('model_singulars');
    }
    public function test_destroy(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $model_singular = Pembelian::factory()->create();
        $response = $this->delete('model_singulars/' . $model_singular->id);
        $response->assertRedirect('model_singulars');
        $this->assertDeleted($model_singular);
    }

    public function test_a_user_can_only_see_model_singular_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        Pembelian::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        Pembelian::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Pembelian::count());
    }

    /** @test */
    public function test_a_user_can_only_create_a_model_singular_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdPembelian = Pembelian::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdPembelian->tenant_id == $user1->tenant_id);
    }
}
/* Route::post('pembelians/ajax', [\App\Http\Controllers\PembeliansController::class, 'ajax']); */
/* Route::post('pembelians', [\App\Http\Controllers\PembeliansController::class, 'store']); */
/* Route::post('pembelians/{id}', [\App\Http\Controllers\PembeliansController::class, 'update']); */
/* Route::post('pembelians/cari/ajax', [\App\Http\Controllers\PembeliansController::class, 'cariObat']); */
