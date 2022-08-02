<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\SuratSakit;
use Illuminate\Http\Testing\File;
use Storage;
use Carbon\Carbon;

class SuratSakitsControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_create_view(){
        $user     = User::factory()->create([
                        'role_id' => 6
                    ]);
        auth()->login($user);
        $periksa  = \App\Models\Periksa::factory()->create();
        $poli     = \App\Models\Poli::factory()->create();
        $response = $this->get('suratsakits/create/'. $periksa->id.'/' . $poli->id);
        $response->assertStatus(200);
    }
    public function test_edit(){
        $user     = User::factory()->create([
                        'role_id' => 6
                    ]);
        auth()->login($user);
        $periksa  = \App\Models\Periksa::factory()->create();
        $surat_sakit = \App\Models\SuratSakit::factory()->create([
            'periksa_id' => $periksa->id
        ]);
        $poli     = \App\Models\Poli::factory()->create();
        $response = $this->get('suratsakits/'. $surat_sakit->id.'/edit/' . $poli->id);
        $response->assertStatus(200);
    }
    public function test_show(){
        $user     = User::factory()->create([
                        'role_id' => 6
                    ]);
        auth()->login($user);
        $periksa  = \App\Models\Periksa::factory()->create();
        $surat_sakit = \App\Models\SuratSakit::factory()->create([
            'periksa_id' => $periksa->id
        ]);
        $poli     = \App\Models\Poli::factory()->create();
        $response = $this->get('suratsakits/show/' . $surat_sakit->id);
        $response->assertStatus(200);
    }
    /**
     * 
     */
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

        $periksa_id    = \App\Models\Periksa::factory()->create()->id;
        $tanggal_mulai = $this->faker->date('d-m-Y');
        $hari          = rand(1,2);

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
            "periksa_id"    => $periksa_id,
            "tanggal_mulai" => $tanggal_mulai,
            "hari"          => $hari,
        ];

        $poli     = \App\Models\Poli::factory()->create();

        $response = $this->post('suratsakits/' . $poli->id, $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $surat_sakits = SuratSakit::query()
            ->where("periksa_id", $periksa_id)
            ->where("tanggal_mulai", Carbon::createFromFormat('d-m-Y', $tanggal_mulai)->format('Y-m-d'))
            ->where("hari", $hari)
        ->get();

            if ( !$surat_sakits->count() ) {
                $surat_sakits = SuratSakit::all();
                $surat_sakit_array = [];
                foreach ($surat_sakits as $a) {
                    /* key mapping n */
                    /* dari bentuk '->where("tanggal_mulai", Carbon::createFromFormat('d-m-Y', $tanggal_mulai)->format('Y-m-d')) ' */	
                    /* KE BENTUK */	
                    /* "tanggal_mulai" => $a->tanggal_mulai, */
                    $surat_sakit_array[] = [
                        "periksa_id"    => $a->periksa_id,
                        "tanggal_mulai" => $a->tanggal_mulai,
                        "hari"          => $a->hari,
                    ];
                }
                    /* key mapping m */
                    /* dari bentuk '->where("tanggal_mulai", Carbon::createFromFormat('d-m-Y', $tanggal_mulai)->format('Y-m-d')) ' */	
                    /* KE BENTUK */	
                    /* "tanggal_mulai" => Carbon::createFromFormat('d-m-Y', $tanggal_mulai)->format('Y-m-d'), */
                dd(  [
                        "periksa_id"    => $periksa_id,
                        "tanggal_mulai" => Carbon::createFromFormat('d-m-Y', $tanggal_mulai)->format('Y-m-d'),
                        "hari"          => $hari,
                    ],
                    $surat_sakit_array
                );
            }

        $this->assertCount(1, $surat_sakits);

        $response->assertRedirect('ruangperiksa/5');
    }

    /**
     * 
     */

/* Route::put('suratsakits/{id}/{poli}', [\App\Http\Controllers\SuratSakitsController::class, 'update']); */
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

        $periksa_id    = \App\Models\Periksa::factory()->create()->id;
        $tanggal_mulai = $this->faker->date('d-m-Y');
        $hari          = rand(1,2);

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
            "periksa_id"    => $periksa_id,
            "tanggal_mulai" => $tanggal_mulai,
            "hari"          => $hari,
        ];

        $poli     = \App\Models\Poli::factory()->create();

        $surat_sakit = \App\Models\SuratSakit::factory()->create();
        $response = $this->put('suratsakits/'. $surat_sakit->id. '/'. $poli->id, $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $surat_sakits = SuratSakit::query()
            ->where("periksa_id", $periksa_id)
            ->where("tanggal_mulai", Carbon::createFromFormat('d-m-Y', $tanggal_mulai)->format('Y-m-d'))
            ->where("hari", $hari)
        ->get();

            if ( !$surat_sakits->count() ) {
                $surat_sakits = SuratSakit::all();
                $surat_sakit_array = [];
                foreach ($surat_sakits as $a) {
                    /* key mapping n */
                    /* dari bentuk '->where("tanggal_mulai", Carbon::createFromFormat('d-m-Y', $tanggal_mulai)->format('Y-m-d')) ' */	
                    /* KE BENTUK */	
                    /* "tanggal_mulai" => $a->tanggal_mulai, */
                    $surat_sakit_array[] = [
                        "periksa_id"    => $a->periksa_id,
                        "tanggal_mulai" => $a->tanggal_mulai,
                        "hari"          => $a->hari,
                    ];
                }
                    /* key mapping m */
                    /* dari bentuk '->where("tanggal_mulai", Carbon::createFromFormat('d-m-Y', $tanggal_mulai)->format('Y-m-d')) ' */	
                    /* KE BENTUK */	
                    /* "tanggal_mulai" => Carbon::createFromFormat('d-m-Y', $tanggal_mulai)->format('Y-m-d'), */
                dd(  [
                        "periksa_id"    => $periksa_id,
                        "tanggal_mulai" => Carbon::createFromFormat('d-m-Y', $tanggal_mulai)->format('Y-m-d'),
                        "hari"          => $hari,
                    ],
                    $surat_sakit_array
                );
            }

        $this->assertCount(1, $surat_sakits);

        $response->assertRedirect('ruangperiksa/5');
    }
    public function test_destroy(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $surat_sakit = SuratSakit::factory()->create();
        $poli        = \App\Models\Poli::factory()->create();
        $response    = $this->get('suratsakits/delete/'. $surat_sakit->id.'/' . $poli->id);
        $response->assertRedirect('ruangperiksa/5');
        $this->assertDeleted($surat_sakit);
    }

    public function test_a_user_can_only_see_surat_sakit_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        SuratSakit::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        SuratSakit::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, SuratSakit::count());
    }

    /** @test */
    public function test_a_user_can_only_create_a_surat_sakit_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdSuratSakit = SuratSakit::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdSuratSakit->tenant_id == $user1->tenant_id);
    }
}
