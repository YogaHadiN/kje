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

        $namaPasien       = $this->faker->name;
        $pasien_id        = \App\Models\Pasien::factory()->create()->id;
        $tanggal          = $this->faker->date('d-m-Y');
        $antrian_poli_id  = \App\Models\AntrianPoli::factory()->create()->id;
        $antrian          = $this->faker->word;
        $pengantar        = $this->faker->word;
        $prolanis_dm      = $this->faker->word;
        $prolanis_ht      = $this->faker->word;
        $no_telp          = $this->faker->word;
        $asuransi_id      = \App\Models\Asuransi::factory()->create()->id;
        $jam              = $this->faker->date("H:i:s");
        $bukan_peserta    = $this->faker->word;
        $staf_id          = \App\Models\Staf::factory()->create()->id;
        $poli_id          = \App\Models\Poli::factory()->create()->id;
        $sistolik         = $this->faker->word;
        $diastolik        = $this->faker->word;
        $berat_badan      = $this->faker->word;
        $suhu             = $this->faker->word;
        $tinggi_badan     = $this->faker->word;
        $kecelakaan_kerja = $this->faker->word;
        $asisten_id       = \App\Models\Staf::factory()->create()->id;
        $hamil            = $this->faker->word;
        $G                = $this->faker->word;
        $P                = $this->faker->word;
        $A                = $this->faker->word;
        $GPA              = $this->faker->word;
        $hpht             = $this->faker->date('d-m-Y');
        $umur_kehamilan   = $this->faker->word;
        $perujuk_id       = \App\Models\Perujuk::factory()->create()->id;
        $gds              = $this->faker->word;

        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
            'namaPasien'       => $namaPasien,
            'pasien_id'        => $pasien_id,
            'tanggal'          => $tanggal,
            'antrian_poli_id'  => $antrian_poli_id,
            'antrian'          => $antrian,
            'pengantar'        => $pengantar,
            'prolanis_dm'      => $prolanis_dm,
            'prolanis_ht'      => $prolanis_ht,
            'no_telp'          => $no_telp,
            'asuransi_id'      => $asuransi_id,
            'jam'              => $jam,
            'bukan_peserta'    => $bukan_peserta,
            'staf_id'          => $staf_id,
            'poli_id'          => $poli_id,
            'sistolik'         => $sistolik,
            'diastolik'        => $diastolik,
            'berat_badan'      => $berat_badan,
            'suhu'             => $suhu,
            'tinggi_badan'     => $tinggi_badan,
            'kecelakaan_kerja' => $kecelakaan_kerja,
            'asisten_id'       => $asisten_id,
            'hamil'            => $hamil,
            'G'                => $G,
            'P'                => $P,
            'A'                => $A,
            'GPA'              => $GPA,
            'hpht'             => $hpht,
            'umur_kehamilan'   => $umur_kehamilan,
            'perujuk_id'       => $perujuk_id,
            'gds'              => $gds,
        ];

        $response = $this->post('antrianperiksas', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $antrianperiksas = AntrianPeriksa::query()
                ->where("asuransi_id", $asuransi_id)
                ->where("poli_id", $poli_id)
                ->where("pasien_id", $pasien_id)
                ->where("staf_id", $staf_id)
                ->where("tanggal", Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d'))
                ->where("jam", $jam)
                ->where("hamil", $hamil)
                ->where("tinggi_badan", $tinggi_badan)
                ->where("suhu", $suhu)
                ->where("berat_badan", $berat_badan)
                ->where("perujuk_id", $perujuk_id)
                ->where("asisten_id", $asisten_id)
                ->where("g", $G)
                ->where("p", $P)
                ->where("a", $A)
                ->where("hpht", Carbon::createFromFormat('d-m-Y', $hpht)->format('Y-m-d'))
                ->where("kecelakaan_kerja", $kecelakaan_kerja)
                /* ->where("bukan_peserta", $bukan_peserta) */
                ->where("sistolik", $sistolik)
                ->where("diastolik", $diastolik)
                ->where("gds", $gds)

                /* ->where("menyusui", $menyusui) */
                /* ->where("riwayat_alergi_obat", $riwayat_alergi_obat) */
                /* ->where("tekanan_darah", $tekanan_darah) */
                /* ->where("periksa_awal", $periksa_awal) */
                /* ->where("keterangan", $keterangan) */
                /* ->where("dipanggil", $dipanggil) */
        ->get();
        $this->assertCount(1, $antrianperiksas);
        $response->assertRedirect('antrianpolis');
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
        $antrian_poli_id = \App\Models\AntrianPoli::factory()->create()->id;
        auth()->login($user);
        $response = $this->get('antrianperiksas/create/' . $antrian_poli_id );
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
