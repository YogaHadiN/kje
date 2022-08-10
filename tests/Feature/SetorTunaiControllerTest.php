<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\Classes\Yoga;
use Carbon\Carbon;
use App\Models\User;
use App\Models\SetorTunai;
use Illuminate\Http\Testing\File;
use Storage;

class SetorTunaiControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);

        $setor_tunai = \App\Models\SetorTunai::factory()->create();
        $response    = $this->get('setor_tunais');
        $response->assertStatus(200);
        $response->assertSee( $setor_tunai->staf->nama );
    }
    public function test_create_view(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $response = $this->get('setor_tunais/create');
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

        $tanggal    = $this->faker->date('d-m-Y');
        $staf_id    = \App\Models\Staf::factory()->create()->id;
        $coa_id     = \App\Models\Coa::factory()->create()->id;
        $nominal    = $this->faker->numerify('Rp. #.###.###');
        $nota_image = $this->faker->text;

        /* sebelum kesini ke acting as dulu */
        /* key mapping l */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = File::create('nama.png', 100) */

        $nota_image                      = File::create('nota_image.png', 100);

        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = compact(
            "tanggal",
            "staf_id",
            "coa_id",
            "nominal",
            "nota_image"
        );

        \App\Models\Coa::factory()->create([
            'kode_coa' => 110000
        ]);

        $response = $this->post('setor_tunais', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $setor_tunais = SetorTunai::query()
            ->where("tanggal", Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d'))
            ->where("staf_id", $staf_id)
            ->where("coa_id", $coa_id)
            ->where("nominal", Yoga::clean($nominal))
        ->get();

        if ( !$setor_tunais->count() ) {
            $setor_tunais = SetorTunai::all();
            $setor_tunai_array = [];
            foreach ($setor_tunais as $a) {
                $setor_tunai_array[] = [
                    "tanggal" => $a->tanggal,
                    "staf_id" => $a->staf_id,
                    "coa_id" => $a->coa_id,
                    "nominal" => $a->nominal,
                ];
            }
            dd(  [
                    "tanggal" => $tanggal,
                    "staf_id" => $staf_id,
                    "coa_id" => $coa_id,
                    "nominal" => $nominal,
                ],
                $setor_tunai_array
            );
        }

        $this->assertCount(1, $setor_tunais);

        $setor_tunai = $setor_tunais->first();

        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $this->checkForUploadedFile($nama, $model->nama); */

        checkForUploadedFile($nota_image, $setor_tunai->nota_image);

        $response->assertRedirect('setor_tunais');
    }
    public function test_update(){
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

        $tanggal    = $this->faker->date('d-m-Y');
        $staf_id    = \App\Models\Staf::factory()->create()->id;
        $coa_id     = \App\Models\Coa::factory()->create()->id;
        $nominal    = $this->faker->numerify('Rp. #.###.###');
        $nota_image = $this->faker->text;

        /* sebelum kesini ke acting as dulu */
        /* key mapping l */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = File::create('nama.png', 100) */

        $nota_image                      = File::create('nota_image.png', 100);

        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = compact(
            "tanggal",
            "staf_id",
            "coa_id",
            "nominal",
            "nota_image"
        );

        \App\Models\Coa::factory()->create([
            'kode_coa' => 110000
        ]);

        $setor_tunai = \App\Models\SetorTunai::factory()->create();
        $response = $this->put('setor_tunais/'. $setor_tunai->id, $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $setor_tunais = SetorTunai::query()
            ->where("tanggal", Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d'))
            ->where("staf_id", $staf_id)
            ->where("coa_id", $coa_id)
            ->where("nominal", Yoga::clean($nominal))
        ->get();

        if ( !$setor_tunais->count() ) {
            $setor_tunais = SetorTunai::all();
            $setor_tunai_array = [];
            foreach ($setor_tunais as $a) {
                $setor_tunai_array[] = [
                    "tanggal" => $a->tanggal,
                    "staf_id" => $a->staf_id,
                    "coa_id" => $a->coa_id,
                    "nominal" => $a->nominal,
                ];
            }
            dd(  [
                    "tanggal" => $tanggal,
                    "staf_id" => $staf_id,
                    "coa_id" => $coa_id,
                    "nominal" => $nominal,
                ],
                $setor_tunai_array
            );
        }

        $this->assertCount(1, $setor_tunais);

        $setor_tunai = $setor_tunais->first();

        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $this->checkForUploadedFile($nama, $model->nama); */

        checkForUploadedFile($nota_image, $setor_tunai->nota_image);

        $response->assertRedirect('setor_tunais');
    }
    public function test_edit(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $setor_tunai = SetorTunai::factory()->create();
        $response = $this->get('setor_tunais/' . $setor_tunai->id . '/edit');
        $response->assertStatus(200);
    }
    public function test_destroy(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $setor_tunai = SetorTunai::factory()->create();
        $response = $this->delete('setor_tunais/' . $setor_tunai->id);
        $response->assertRedirect('setor_tunais');
        $this->assertDeleted($setor_tunai);
    }

    public function test_a_user_can_only_see_setor_tunai_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        SetorTunai::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        SetorTunai::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, SetorTunai::count());
    }

    /** @test */
    public function test_a_user_can_only_create_a_setor_tunai_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdSetorTunai = SetorTunai::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdSetorTunai->tenant_id == $user1->tenant_id);
    }
}
