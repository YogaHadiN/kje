<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use Arr;
use App\Models\Tenant;
use App\Models\User;
use App\Models\KirimBerkas;
use Illuminate\Http\Testing\File;
use Storage;

class KirimBerkasControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $response = $this->get('kirim_berkas');
        $response->assertStatus(200);
    }

    public function test_create_view(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $response = $this->get('kirim_berkas/create');
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

        $nama               = $this->faker->name;
        $tanggal            = $this->faker->date('d-m-Y');
        $alamat             = $this->faker->address;
        $stafs            = \App\Models\Staf::factory(2)->create();
        $role_pengirimans = \App\Models\RolePengiriman::factory(2)->create();

        $staf_id = [];
        $role_pengiriman_id = [];
        foreach ($stafs as $k => $staf) {
            $staf_id[] = $staf->id;
            $role_pengiriman_id[] = $role_pengirimans[$k];
        }

		/* $query .= "FROM periksas as px "; */
		/* $query .= "JOIN pasiens as ps on ps.id = px.pasien_id "; */
		/* $query .= "LEFT JOIN piutang_dibayars as pd on pd.periksa_id = px.id "; */
		/* $query .= "JOIN asuransis as asu on asu.id = px.asuransi_id "; */
		/* $query .= "LEFT JOIN invoices as inv on inv.id = px.invoice_id "; */
		/* $query .= "LEFT JOIN kirim_berkas as ks on ks.id = inv.kirim_berkas_id "; */

        $piutang_tercatat = [];

        for ($i = 0; $i < 40; $i++) {
            $pasien   = \App\Models\Pasien::factory()->create();
            $asuransi = \App\Models\Asuransi::factory()->create();

            $periksa  = \App\Models\Periksa::factory()->create([
                'pasien_id'   => $pasien,
                'asuransi_id' => $asuransi,
                'piutang'     => 100000,
                'tunai'       => 0
            ]);
            $piutang_tercatat[] = [
                'piutang_id'    => $periksa->id,
                'piutang'       => $periksa->piutang,
                'sudah_dibayar' => 0,
                'periksa_id'    => $periksa->id,
                'nama_pasien'   => $pasien->nama,
                'tanggal_kirim' => null,
                'nama_asuransi' => $asuransi->nama
            ];
        }

        $piutang_tercatat = json_encode($piutang_tercatat);
        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
                "nama"               => $nama,
                "tanggal"            => $tanggal,
                "alamat"             => $alamat,
                "staf_id"           => $staf_id,
                "role_pengiriman_id" => $role_pengiriman_id,
                "piutang_tercatat"   => $piutang_tercatat,
        ];

        $response = $this->post('kirim_berkas', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $kirim_berkass = KirimBerkas::query()
                ->where("alamat", $alamat)
            ->get();

            if ( !$kirim_berkass->count() ) {
                $kirim_berkass = KirimBerkas::all();
                $kirim_berkas_array = [];
                foreach ($kirim_berkass as $a) {
                    $kirim_berkas_array[] = [
                        "alamat"  => $a->alamat,
                        "tanggal" => $a->tanggal->format('Y-m-d')
                    ];
                }
                dd(  [
                        "tanggal" => Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d'),
                        "alamat"  => $alamat
                    ],
                    $kirim_berkas_array
                );
            }
        $this->assertCount(1, $kirim_berkass);
        $response->assertRedirect('kirim_berkas');
    }

    public function test_cariPiutang(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        for ($i = 0; $i < 40; $i++) {
            $pasien   = \App\Models\Pasien::factory()->create();
            $asuransi = \App\Models\Asuransi::factory()->create();

            $periksa  = \App\Models\Periksa::factory()->create([
                'pasien_id'   => $pasien,
                'asuransi_id' => $asuransi,
                'piutang'     => 100000,
                'tunai'       => 0
            ]);
            $piutang_tercatat[] = [
                'piutang_id'    => $periksa->id,
                'piutang'       => $periksa->piutang,
                'sudah_dibayar' => 0,
                'periksa_id'    => $periksa->id,
                'nama_pasien'   => $pasien->nama,
                'tanggal_kirim' => null,
                'nama_asuransi' => $asuransi->nama
            ];
        }

        $response = $this->get("kirim_berkas/cari/piutang?" . Arr::query([
            'bulan' => date('m'),
            'tahun' => date('Y')
        ]));

        $response->assertStatus(200);
    }

    public function test_edit(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);

        auth()->login($user);
        $kirim_berkas = KirimBerkas::factory()->create();
        $response = $this->get("kirim_berkas/" . $kirim_berkas->id . "/edit");
        $response->assertStatus(200);
    }

    public function test_inputNota(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);

        auth()->login($user);
        $kirim_berkas = KirimBerkas::factory()->create();
        $response = $this->get("kirim_berkas/" . $kirim_berkas->id. "/inputNota");
        $response->assertStatus(302);
    }

    public function test_a_user_can_only_see_kirim_berkas_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        KirimBerkas::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        KirimBerkas::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, KirimBerkas::count());
    }

    public function test_a_user_can_only_create_a_kirim_berkas_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdKirimBerkas = KirimBerkas::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdKirimBerkas->tenant_id == $user1->tenant_id);
    }
}


/* Route::get('kirim_berkas/{id}/inputNota', [\App\Http\Controllers\KirimBerkasController::class, 'inputNota']); */
/* Route::post('kirim_berkas/{id}/inputNota', [\App\Http\Controllers\KirimBerkasController::class, 'inputNotaPost']); */
/* Route::put('kirim_berkas/{id}', [\App\Http\Controllers\KirimBerkasController::class, 'update']); */
/* Route::delete('kirim_berkas/{id}', [\App\Http\Controllers\KirimBerkasController::class, 'destroy']); */
