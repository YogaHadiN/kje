<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Testing\File;
use Storage;
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Tenant;
use App\Http\Controllers\PasiensController;
use App\Models\Pasien;
use App\Models\User;
use App\Models\Asuransi;
use App\Models\Poli;
use App\Models\Staf;
use App\Models\AntrianPoli;
class AntrianPolisControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        AntrianPoli::factory()->create();
        $response = $this->get('antrianpolis');
        $response->assertStatus(200);
    }
    public function test_redirect_to_edit_pasien_if_pasien_image_is_empty(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $poli = \App\Models\Poli::factory()->create([
            'poli' => 'Poli Gawat Darurat'
        ]);
        $pasien            = Pasien::factory()->create([
            'image' => null
        ]);
        \App\Models\Asuransi::factory()->create([
            'tipe_asuransi_id' => 5
        ]);
        $response = $this->storeTestTemplateBeforeTesting($pasien);
        $response->assertRedirect('pasiens/' . $pasien->id . '/edit');
           $this->followRedirects($response)
                ->assertSee('harus dimasukkan terlebih dahulu');
    }

    public function test_redirect_to_edit_pasien_if_ktp_image_exists_but_nomor_ktp_empty(){
        $user     = User::factory()->create([
                        'role_id' => 6
                    ]);
        auth()->login($user);

        $poli = \App\Models\Poli::factory()->create([
            'poli' => 'Poli Gawat Darurat'
        ]);

        $pasien            = Pasien::factory()->create([
            'nomor_ktp' => null,
            'tanggal_lahir' => Carbon::now()->subYears(20)
        ]);

        Storage::fake('s3'); //or any storage you need to fake
        $image          = File::create('image1.png', 100);

        \App\Models\Asuransi::factory()->create([
            'tipe_asuransi_id' => 5
        ]);
        $pc                = new PasiensController;
        $pasien->ktp_image = $pc->fileNameUploaded('ktp', $image, $pasien->id);;
        $pasien->save();


        $response = $this->storeTestTemplateBeforeTesting($pasien);

        $response->assertRedirect('pasiens/' . $pasien->id . '/edit');
           $this->followRedirects($response)
                ->assertSee('gunakan foto KTP');
    }

    public function test_redirect_to_edit_pasien_if_pasien_is_bpjs_aged_over_18_but_ktp_image_empty(){
        $user     = User::factory()->create([
                        'role_id' => 6
                    ]);

        auth()->login($user);

        $poli = \App\Models\Poli::factory()->create([
            'poli' => 'Poli Gawat Darurat'
        ]);

        $asuransi = \App\Models\Asuransi::factory()->create([
            'nama'             => 'BPJS',
            'tipe_asuransi_id' => 5
        ]);

        $pasien            = Pasien::factory()->create([
            'ktp_image'   => null,
            'asuransi_id' => $asuransi,
            'tanggal_lahir' => Carbon::now()->subYears(20)
        ]);

        Storage::fake('s3'); //or any storage you need to fake

        /* $image          = File::create('image1.png', 100); */

        /* $pc                = new PasiensController; */
        /* $pasien->ktp_image = $pc->fileNameUploaded('ktp', $image, $pasien->id);; */
        /* $pasien->save(); */

        $response = $this->storeTestTemplateBeforeTesting($pasien, $asuransi);

        $response->assertRedirect('pasiens/' . $pasien->id . '/edit');
           $this->followRedirects($response)
                ->assertSee('untuk peserta asuransi harus dimasukkan terlebih dahulu');
    }


    public function test_store(){

        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

          $nama              = $this->faker->name;
          $pasien_id         = \App\Models\Pasien::factory()->create()->id;
          $poli_id           = \App\Models\Poli::factory()->create()->id;
          $staf_id           = \App\Models\Staf::factory()->create()->id;
          $asuransi_id       = \App\Models\Asuransi::factory()->create()->id;
          $tanggal           = $this->faker->date('d-m-Y');
          $bukan_peserta     = rand(0,1);
          $pengantar_pasiens = "";

        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
            "nama"              => $nama,
            "pasien_id"         => $pasien_id,
            "poli_id"           => $poli_id,
            "staf_id"           => $staf_id,
            "asuransi_id"       => $asuransi_id,
            "tanggal"           => $tanggal,
            "bukan_peserta"     => $bukan_peserta,
            "pengantar_pasiens" => $pengantar_pasiens,
        ];

        $response = $this->post('antrianpolis', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $antrian_polis = AntrianPoli::query()
            ->where("pasien_id", $pasien_id)
            ->where("poli_id", $poli_id)
            ->where("staf_id", $staf_id)
            ->where("asuransi_id", $asuransi_id)
            /* ->where("tanggal", Carbon::createFromFormat('d-m-Y', $tanggal)) */
            /* ->where("bukan_peserta", $bukan_peserta) */
        ->get();

            if ( !$antrian_polis->count() ) {
                $antrian_polis = AntrianPoli::all();
                $antrian_poli_array = [];
                foreach ($antrian_polis as $a) {
                    $antrian_poli_array[] = [
                        "nama"              => $a->nama,
                        "pasien_id"         => $a->pasien_id,
                        "poli_id"           => $a->poli_id,
                        "staf_id"           => $a->staf_id,
                        "asuransi_id"       => $a->asuransi_id,
                        "tanggal"           => $a->tanggal,
                        "bukan_peserta"     => $a->bukan_peserta,
                        "pengantar_pasiens" => $a->pengantar_pasiens,
                    ];
                }
                dd(  [
                        "nama"             => $nama,
                        "pasien_id"         => $pasien_id,
                        "poli_id"           => $poli_id,
                        "staf_id"           => $staf_id,
                        "asuransi_id"       => $asuransi_id,
                        "tanggal"           => Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d'),
                        "bukan_peserta"     => $bukan_peserta,
                       "pengantar_pasiens" => $pengantar_pasiens,
                    ],
                    $antrian_poli_array
                );
            }

        $this->assertCount(1, $antrian_polis);

        $response->assertRedirect('antrianpolis');
    }

    public function test_destroy(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $antrian_poli = AntrianPoli::factory()->create();
        $response = $this->delete('antrianpolis/' . $antrian_poli->id, [
            'alasan_kabur' => $this->faker->text
        ]);
        $response->assertRedirect('antrianpolis');
        $this->assertDeleted($antrian_poli);
    }

        /**
         * 
         */
    public function test_a_user_can_only_see_antrian_poli_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        AntrianPoli::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        AntrianPoli::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, AntrianPoli::count());
    }

        /**
         * 
         */
    public function test_a_user_can_only_create_a_antrian_poli_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdAntrianPoli = AntrianPoli::factory()->create();

        $this->assertTrue($createdAntrianPoli->tenant_id == $user1->tenant_id);
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function storeTestTemplateBeforeTesting($pasien, $asuransi = null)
    {
        $nama              = $pasien->nama;
        $pasien_id         = $pasien->id;
        $poli_id           = Poli::factory()->create()->id;
        $staf_id           = Staf::factory()->create()->id;
        $asuransi_id       = is_null($asuransi) ? Asuransi::factory()->create()->id : $asuransi->id;
        $tanggal           = date('d-m-Y');
        $bukan_peserta     = 0;
        $pengantar_pasiens = '';

        /* sebelum kesini ke acting as dulu */
        /* key mapping l */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = File::create('nama.png', 100) */


        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
            "nama"              => $nama,
            "pasien_id"         => $pasien_id,
            "poli_id"           => $poli_id,
            "staf_id"           => $staf_id,
            "asuransi_id"       => $asuransi_id,
            "tanggal"           => $tanggal,
            "bukan_peserta"     => $bukan_peserta,
            "pengantar_pasiens" => $pengantar_pasiens,
        ];

        $this->withoutExceptionHandling();
        return $this->post('antrianpolis', $inputAll);
    }
    
}
