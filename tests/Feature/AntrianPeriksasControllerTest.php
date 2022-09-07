<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Http\Controllers\AntrianPeriksasController;
use App\Models\AntrianPoli;
use App\Models\AntrianPeriksa;
use Illuminate\Http\Testing\File;
use Storage;
use Carbon\Carbon;
class AntrianPeriksasControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    /**
     * 
     */
        /**
         * @group failing
         */
    private function store_template($inputAll){
        Storage::fake('s3');
        // make a request with file

        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */
        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */


        $antrianpoli = $inputAll['antrianpoli'];
        $response = $this->post('antrianperiksas/' . $antrianpoli->id, $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $antrianperiksas = AntrianPeriksa::query()
                ->where("asuransi_id", $antrianpoli->asuransi_id)
                ->where("poli_id", $antrianpoli->poli_id)
                ->where("pasien_id", $antrianpoli->pasien_id)
                ->where("staf_id", $antrianpoli->staf_id)
                ->where("tanggal", $antrianpoli->tanggal)
                ->where("jam", $antrianpoli->jam)
                ->where("hamil", $inputAll['hamil'])
                ->where("tinggi_badan", $inputAll['tinggi_badan'])
                ->where("suhu", $inputAll['suhu'])
                ->where("berat_badan", $inputAll['berat_badan'])
                ->where("asisten_id", $inputAll['asisten_id'])
                ->where("kecelakaan_kerja", $inputAll['kecelakaan_kerja'])
                /* ->where("bukan_peserta", $bukan_peserta) */
                ->where("sistolik", $inputAll['sistolik'])
                ->where("diastolik", $inputAll['diastolik'])
                ->where("gds", $inputAll['gds'])

                /* ->where("menyusui", $menyusui) */
                /* ->where("riwayat_alergi_obat", $riwayat_alergi_obat) */
                /* ->where("tekanan_darah", $tekanan_darah) */
                /* ->where("periksa_awal", $periksa_awal) */
                /* ->where("keterangan", $keterangan) */
                /* ->where("dipanggil", $dipanggil) */
        ->get();
        $this->assertCount(1, $antrianperiksas);
        return $response;
        
    }
    public function test_store(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        $antrianpoli = \App\Models\AntrianPoli::factory()->create();

        $response = $this->store_template([
            'antrianpoli'                 => $antrianpoli,
            'sex'                         => rand(0,1),
            'peserta_klinik'              => rand(0,1),
            'verifikasi_wajah'            => "on",
            'previous_complaint_resolved' => rand(0,1),
            'verifikasi_alergi_obat'      => "on",
            'sistolik'                    => $this->faker->numerify('###'),
            'diastolik'                   => $this->faker->numerify('##'),
            'berat_badan'                 => $this->faker->numerify('##'),
            'suhu'                        => $this->faker->numerify('##'),
            'tinggi_badan'                => $this->faker->numerify('##'),
            'kecelakaan_kerja'            => rand(0,1),
            'hamil'                       => rand(0,1),
            'menyusui'                    => rand(0,1),
            'gds'                         => $this->faker->numerify('##'),
            'asisten_id'                  => \App\Models\Staf::factory()->create()->id,
        ]);
        $response->assertRedirect('antrianpolis');
    }

        /**
         * @group failing
         */

    public function test_store_if_bpjs_prolanis_dm_and_no_gds_input_available(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $pasien = \App\Models\Pasien::factory()->create([
            'prolanis_dm' => 1,
        ]);

        $antrianpoli = \App\Models\AntrianPoli::factory()->create([
            'pasien_id' => $pasien->id
        ]);

        $response = $this->store_template([
            'antrianpoli'                 => $antrianpoli,
            'sex'                         => rand(0,1),
            'peserta_klinik'              => rand(0,1),
            'verifikasi_wajah'            => "on",
            'previous_complaint_resolved' => rand(0,1),
            'verifikasi_alergi_obat'      => "on",
            'sistolik'                    => $this->faker->numerify('###'),
            'diastolik'                   => $this->faker->numerify('##'),
            'berat_badan'                 => $this->faker->numerify('##'),
            'suhu'                        => $this->faker->numerify('##'),
            'tinggi_badan'                => $this->faker->numerify('##'),
            'kecelakaan_kerja'            => rand(0,1),
            'hamil'                       => rand(0,1),
            'menyusui'                    => rand(0,1),
            'gds'                         => null,
            'asisten_id'                  => \App\Models\Staf::factory()->create()->id,
        ]);
        $response->assertSessionHasErrors('gds');
    }

    /**
     * 
     */
    public function test_destroy(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $antrianperiksa = AntrianPeriksa::factory()->create();
        $apc = new AntrianPeriksasController;
        $response = $this->delete('antrianperiksas/' . $antrianperiksa->id);
        $response->assertRedirect('ruangperiksa/' . $apc->getJenisAntrianId($antrianperiksa));
        $this->assertDeleted($antrianperiksa);
    }

        /**
         * @group failing
         */
    public function test_create(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);
        $antrianpoli = \App\Models\AntrianPoli::factory()->create();
        $response = $this->get('antrianperiksas/create/' . $antrianpoli->id );
        $response->assertStatus(200);
    }

    /**
     * 
     */
    public function test_a_user_can_only_see_antrianperiksa_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        AntrianPeriksa::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        AntrianPeriksa::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, AntrianPeriksa::count());
    }

    /**
     * 
     */
    public function test_a_user_can_only_create_a_antrianperiksa_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdAntrianPeriksa = AntrianPeriksa::factory()->create();

        $this->assertTrue($createdAntrianPeriksa->tenant_id == $user1->tenant_id);
    }
}
