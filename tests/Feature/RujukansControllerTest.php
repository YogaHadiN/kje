<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\RumahSakit;
use App\Models\User;
use App\Models\Rujukan;
use Illuminate\Http\Testing\File;
use Storage;

class RujukansControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index(){
            $user     = User::factory()->create([
                'role_id' => 6
            ]);
        
        auth()->login($user);
        $response = $this->get('rujukans');
        $response->assertStatus(200);
    }
    public function test_create_view(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $periksa  = \App\Models\Periksa::factory()->create();
        $poli     = \App\Models\Poli::factory()->create();
        $response = $this->get('rujukans/create/'. $periksa->id.'/'. $poli->id);
        $response->assertStatus(200);
    }

    public function test_ini(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $periksa  = \App\Models\Periksa::factory()->create();
        $poli     = \App\Models\Poli::factory()->create();

        $response = $this->get('rujukans/' . $periksa->id);
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

        $periksa_id           = \App\Models\Periksa::factory()->create()->id;
        $pasien_id            = \App\Models\Pasien::factory()->create()->id;
        $hamil_id             = 0;
        $G                    = "";
        $P                    = "";
        $A                    = "";
        $GPA                  = "";
        $hpht                 = "";
        $tujuan_rujuk_id      = \App\Models\TujuanRujuk::factory()->create()->id;
        $jenis_rumah_sakit_id = \App\Models\JenisRumahSakit::factory()->create()->id;
        $rumah_sakit          = \App\Models\RumahSakit::factory()->create()->nama;
        $diagnosa_id          = \App\Models\Diagnosa::factory()->create()->id;
        $time                 = $this->faker->word;
        $age                  = $this->faker->word;
        $comorbidity          = $this->faker->word;
        $complication         = $this->faker->word;

        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
            "periksa_id"           => $periksa_id,
            "pasien_id"            => $pasien_id,
            "hamil_id"             => $hamil_id,
            "G"                    => $G,
            "P"                    => $P,
            "A"                    => $A,
            "GPA"                  => $GPA,
            "hpht"                 => $hpht,
            "tujuan_rujuk_id"      => $tujuan_rujuk_id,
            "jenis_rumah_sakit_id" => $jenis_rumah_sakit_id,
            "rumah_sakit"          => $rumah_sakit,
            "diagnosa_id"          => $diagnosa_id,
            "time"                 => $time,
            "age"                  => $age,
            "comorbidity"          => $comorbidity,
            "complication"         => $complication,
        ];

        $poli = \App\Models\Poli::factory()->create();

        $response = $this->post('rujukans/' . $poli->id, $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */




        $rujukans = Rujukan::query()
            ->where("periksa_id", $periksa_id)
            ->where("tujuan_rujuk_id", $tujuan_rujuk_id)
            ->where("rumah_sakit_id", RumahSakit::where('nama', $rumah_sakit)->first()->id)
            ->where("complication", $complication)
            ->where("time", $time)
            ->where("age", $age)
            ->where("comorbidity", $comorbidity)
            ->where("diagnosa_id", $diagnosa_id)
        ->get();

        if ( !$rujukans->count() ) {
            $rujukans = Rujukan::all();
            $rujukan_array = [];
            foreach ($rujukans as $a) {
                $rujukan_array[] = [
                    "periksa_id"      => $a->periksa_id,
                    "tujuan_rujuk_id" => $a->tujuan_rujuk_id,
                    "rumah_sakit_id"  => $a->rumah_sakit_id,
                    "complication"    => $a->complication,
                    "time"            => $a->time,
                    "age"             => $a->age,
                    "comorbidity"     => $a->comorbidity,
                    "diagnosa_id"     => $a->diagnosa_id,
                ];
            }
            dd(  [
                    "periksa_id"      => $periksa_id,
                    "tujuan_rujuk_id" => $tujuan_rujuk_id,
                    "rumah_sakit_id"  => RumahSakit::where('nama', $rumah_sakit)->first()->id,
                    "complication"    => $complication,
                    "time"            => $time,
                    "age"             => $age,
                    "comorbidity"     => $comorbidity,
                    "diagnosa_id"     => $diagnosa_id,
                ],
                $rujukan_array
            );
        }
        $this->assertCount(1, $rujukans);

        $response->assertRedirect('ruangperiksa/5');
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

        $periksa_id           = \App\Models\Periksa::factory()->create()->id;
        $pasien_id            = \App\Models\Pasien::factory()->create()->id;
        $hamil_id             = 0;
        $G                    = "";
        $P                    = "";
        $A                    = "";
        $GPA                  = "";
        $hpht                 = "";
        $tujuan_rujuk_id      = \App\Models\TujuanRujuk::factory()->create()->id;
        $jenis_rumah_sakit_id = \App\Models\JenisRumahSakit::factory()->create()->id;
        $rumah_sakit          = \App\Models\RumahSakit::factory()->create()->nama;
        $diagnosa_id          = \App\Models\Diagnosa::factory()->create()->id;
        $time                 = $this->faker->word;
        $age                  = $this->faker->word;
        $comorbidity          = $this->faker->word;
        $complication         = $this->faker->word;

        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
            "periksa_id"           => $periksa_id,
            "pasien_id"            => $pasien_id,
            "hamil_id"             => $hamil_id,
            "G"                    => $G,
            "P"                    => $P,
            "A"                    => $A,
            "GPA"                  => $GPA,
            "hpht"                 => $hpht,
            "tujuan_rujuk_id"      => $tujuan_rujuk_id,
            "jenis_rumah_sakit_id" => $jenis_rumah_sakit_id,
            "rumah_sakit"          => $rumah_sakit,
            "diagnosa_id"          => $diagnosa_id,
            "time"                 => $time,
            "age"                  => $age,
            "comorbidity"          => $comorbidity,
            "complication"         => $complication,
        ];

        $poli = \App\Models\Poli::factory()->create();

        $rujukan = \App\Models\Rujukan::factory()->create();

        $response = $this->put('rujukans/' . $rujukan->id. '/'. $poli->id, $inputAll);


        $rujukans = Rujukan::query()
            ->where("periksa_id", $periksa_id)
            ->where("tujuan_rujuk_id", $tujuan_rujuk_id)
            ->where("rumah_sakit_id", RumahSakit::where('nama', $rumah_sakit)->first()->id)
            ->where("complication", $complication)
            ->where("time", $time)
            ->where("age", $age)
            ->where("comorbidity", $comorbidity)
            ->where("diagnosa_id", $diagnosa_id)
        ->get();

        if ( !$rujukans->count() ) {
            $rujukans = Rujukan::all();
            $rujukan_array = [];
            foreach ($rujukans as $a) {
                $rujukan_array[] = [
                    "periksa_id"      => $a->periksa_id,
                    "tujuan_rujuk_id" => $a->tujuan_rujuk_id,
                    "rumah_sakit_id"  => $a->rumah_sakit_id,
                    "complication"    => $a->complication,
                    "time"            => $a->time,
                    "age"             => $a->age,
                    "comorbidity"     => $a->comorbidity,
                    "diagnosa_id"     => $a->diagnosa_id,
                ];
            }
            dd(  [
                    "periksa_id"      => $periksa_id,
                    "tujuan_rujuk_id" => $tujuan_rujuk_id,
                    "rumah_sakit_id"  => RumahSakit::where('nama', $rumah_sakit)->first()->id,
                    "complication"    => $complication,
                    "time"            => $time,
                    "age"             => $age,
                    "comorbidity"     => $comorbidity,
                    "diagnosa_id"     => $diagnosa_id,
                ],
                $rujukan_array
            );
        }
        $this->assertCount(1, $rujukans);

        $response->assertRedirect('ruangperiksa/5');
    }

    public function test_show(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $rujukan = Rujukan::factory()->create();
        $response = $this->get('rujukans/show');
        $response->assertStatus(200);
    }
    public function test_edit(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $rujukan = \App\Models\Rujukan::factory()->create();
        $poli = \App\Models\Poli::factory()->create();
        $response = $this->get('rujukans/'. $rujukan->id.'/edit/'. $poli->id);
        $response->assertStatus(200);
    }
    /**
     * 
     */
    public function test_destroy(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $rujukan = Rujukan::factory()->create();
        $poli = \App\Models\Poli::factory()->create();
        $response = $this->get('rujukans/delete/' .$rujukan->id. '/' . $poli->id);
        $response->assertRedirect('ruangperiksa/5');
        $this->assertDeleted($rujukan);
    }

    public function test_a_user_can_only_see_rujukan_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        Rujukan::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        Rujukan::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Rujukan::count());
    }

    /** @test */
    public function test_a_user_can_only_create_a_rujukan_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdRujukan = Rujukan::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdRujukan->tenant_id == $user1->tenant_id);
    }
}
