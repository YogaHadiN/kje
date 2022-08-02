<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Pasien;
use App\Models\Staf;
use App\Models\Poli;
use Illuminate\Http\Testing\File;
use Storage;
use Carbon\Carbon;
class PasienControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;


    public $pasien;

    public function test_index(){

        $user     = User::factory()->create([
            'role_id' => 6
        ]);

        auth()->login($user);
        $poli = \App\Models\Poli::factory()->create([
            'poli' => 'Poli Gawat Darurat'
        ]);

        \App\Models\Asuransi::factory()->create([
            'tipe_asuransi_id' => 5
        ]);

        $response = $this->get('pasiens');
        $response->assertStatus(200);
    }
    public function test_create_view(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);

        auth()->login($user);
        \App\Models\Asuransi::factory()->create([
            'tipe_asuransi_id' => 5
        ]);
        $poli = \App\Models\Poli::factory()->create([
            'poli' => 'Poli Gawat Darurat'
        ]);
        $response = $this->get('pasiens/create');
        $response->assertStatus(200);
    }
    public function test_store(){
        Storage::fake('s3');
        // make a request with file
        
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);

        \App\Models\Asuransi::factory()->create([
            'tipe_asuransi_id' => 5
        ]);

        $poli = \App\Models\Poli::factory()->create([
            'poli' => 'Poli Gawat Darurat'
        ]);

        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

          $nama                        = $this->faker->name;
          $sex                         = 0;
          $tanggal_lahir               = $this->faker->date('d-m-Y');
          $nama_ibu                    = $this->faker->name;
          $nama_ayah                   = $this->faker->name;
          $no_telp                     = $this->faker->phoneNumber();
          $nomor_ktp                   = $this->faker->numerify('################');
          $asuransi_id                 = \App\Models\Asuransi::factory()->create()->id;
          $jenis_peserta_id            = \App\Models\JenisPeserta::factory()->create()->id;
          $nomor_asuransi              = $this->faker->numerify('################');
          $nama_peserta                = $this->faker->name;
          $nomor_asuransi_bpjs         = $this->faker->numerify('################');
          $alamat                      = $this->faker->address;
          $jangan_disms                = 0;
          $penangguhan_pembayaran_bpjs = 0;
          $meninggal                   = 0;
          $verifikasi_prolanis_dm_id   = 0;
          $verifikasi_prolanis_ht_id   = 0;
          $prolanis_dm                 = 0;
          $prolanis_ht                 = 0;
          $staf_id                     = Staf::factory()->create();
          $poli_id                     = \App\Models\Poli::factory()->create();
          $pasien_id                   = \App\Models\Pasien::factory()->create();
          $image                       = $this->faker->text;
          $ktp_image                   = $this->faker->text;
          $bpjs_image                  = $this->faker->text;
          $kartu_asuransi_image        = $this->faker->text;
          $prolanis_ht_flagging_image  = $this->faker->text;
          $prolanis_dm_flagging_image  = $this->faker->text;

        /* sebelum kesini ke acting as dulu */
        /* key mapping l */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = File::create('nama.png', 100) */

        $image                      = File::create('image.png', 100);
        $ktp_image                  = File::create('ktp_image.png', 100);
        $bpjs_image                 = File::create('bpjs_image.png', 100);
        $kartu_asuransi_image       = File::create('kartu_asuransi_image.png', 100);
        $prolanis_ht_flagging_image = File::create('prolanis_ht_flagging_image.png', 100);
        $prolanis_dm_flagging_image = File::create('prolanis_dm_flagging_image.png', 100);

        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
          "nama"                        => $nama,
          "sex"                         => $sex,
          "tanggal_lahir"               => $tanggal_lahir,
          "nama_ibu"                    => $nama_ibu,
          "nama_ayah"                   => $nama_ayah,
          "no_telp"                     => $no_telp,
          "nomor_ktp"                   => $nomor_ktp,
          "asuransi_id"                 => $asuransi_id,
          "jenis_peserta_id"            => $jenis_peserta_id,
          "nomor_asuransi"              => $nomor_asuransi,
          "nama_peserta"                => $nama_peserta,
          "nomor_asuransi_bpjs"         => $nomor_asuransi_bpjs,
          "alamat"                      => $alamat,
          "jangan_disms"                => $jangan_disms,
          "penangguhan_pembayaran_bpjs" => $penangguhan_pembayaran_bpjs,
          "meninggal"                   => $meninggal,
          "verifikasi_prolanis_dm_id"   => $verifikasi_prolanis_dm_id,
          "verifikasi_prolanis_ht_id"   => $verifikasi_prolanis_ht_id,
          "prolanis_dm"                 => $prolanis_dm,
          "prolanis_ht"                 => $prolanis_ht,
          "staf_id"                     => $staf_id,
          "poli_id"                     => $poli_id,
          "pasien_id"                   => $pasien_id,
          "image"                       => $image,
          "ktp_image"                   => $ktp_image,
          "bpjs_image"                  => $bpjs_image,
          "kartu_asuransi_image"        => $kartu_asuransi_image,
          "prolanis_ht_flagging_image"  => $prolanis_ht_flagging_image,
          "prolanis_dm_flagging_image"  => $prolanis_dm_flagging_image,
          'image'                       => $image,
          'ktp_image'                   => $ktp_image,
          'bpjs_image'                  => $bpjs_image,
          'kartu_asuransi_image'        => $kartu_asuransi_image,
          'prolanis_ht_flagging_image'  => $prolanis_ht_flagging_image,
          'prolanis_dm_flagging_image'  => $prolanis_dm_flagging_image,
        ];

        $response = $this->post('pasiens', $inputAll);

        $pasiens = Pasien::query()
            ->where("nama", $nama)
            ->where("nama_peserta", $nama_peserta)
            ->where("nomor_asuransi", $nomor_asuransi)
            ->where("asuransi_id", $asuransi_id)
            ->where("jenis_peserta_id", $jenis_peserta_id)
            ->where("sex", $sex)
            ->where("alamat", $alamat)
            ->where("tanggal_lahir", Carbon::createFromFormat('d-m-Y', $tanggal_lahir)->format('Y-m-d'))
            ->where("no_telp", $no_telp)
            ->where("nama_ayah", $nama_ayah)
            ->where("nama_ibu", $nama_ibu)
            ->where("nomor_asuransi_bpjs", $nomor_asuransi_bpjs)
            ->where("nomor_ktp", $nomor_ktp)
            ->where("jangan_disms", $jangan_disms)
            ->where("prolanis_ht", $prolanis_ht)
            ->where("prolanis_dm", $prolanis_dm)
            ->where("verifikasi_prolanis_dm_id", $verifikasi_prolanis_dm_id)
            ->where("verifikasi_prolanis_ht_id", $verifikasi_prolanis_ht_id)
            ->where("meninggal", $meninggal)
            ->where("penangguhan_pembayaran_bpjs", $penangguhan_pembayaran_bpjs)
        ->get();
        $this->assertCount(1, $pasiens);


        $pasien = $pasiens->first();
        $this->pasien = $pasien;

        checkForUploadedFile($image, $pasien->image);
        checkForUploadedFile($ktp_image, $pasien->ktp_image);
        checkForUploadedFile($bpjs_image, $pasien->bpjs_image);
        checkForUploadedFile($kartu_asuransi_image, $pasien->kartu_asuransi_image);
        checkForUploadedFile($prolanis_ht_flagging_image, $pasien->prolanis_ht_flagging_image);
        checkForUploadedFile($prolanis_dm_flagging_image, $pasien->prolanis_dm_flagging_image);

        $response->assertRedirect('antrianpolis');
    }
    /**
     * 
     */
    public function test_edit(){
        
        $user     = User::factory()->create([
            'role_id' => 6
        ]);

        auth()->login($user);
        $poli = \App\Models\Poli::factory()->create([
            'poli' => 'Poli Gawat Darurat'
        ]);
        \App\Models\Asuransi::factory()->create([
            'tipe_asuransi_id' => 5
        ]);
        $pasien = Pasien::factory()->create();
        $response = $this->get('pasiens/' . $pasien->id . '/edit');
        $response->assertStatus(200);
    }
    public function test_destroy(){
        
        $user     = User::factory()->create([
            'role_id' => 6
        ]);

        auth()->login($user);

        $poli = \App\Models\Poli::factory()->create([
            'poli' => 'Poli Gawat Darurat'
        ]);
        \App\Models\Asuransi::factory()->create([
            'tipe_asuransi_id' => 5
        ]);
        $pasien = Pasien::factory()->create();
        $response = $this->delete('pasiens/' . $pasien->id);
        $response->assertRedirect('pasiens');
        $this->assertDeleted($pasien);
    }

    public function test_a_user_can_only_see_pasien_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        Pasien::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        Pasien::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Pasien::count());
    }

    public function test_a_user_can_only_create_a_pasien_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdPasien = Pasien::factory()->create();

        $this->assertTrue($createdPasien->tenant_id == $user1->tenant_id);
    }
}
