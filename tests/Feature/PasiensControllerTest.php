<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Testing\File;
use Storage;
use Carbon\Carbon;
use App\Models\Tenant;
use App\Models\Antrian;
use App\Models\User;
use App\Models\Pasien;
class PasiensControllerTest extends TestCase
{
    use WithFaker;
    public function test_index(){
        $user     = User::find(28);
        auth()->login($user);
        $response = $this->get('pasiens');
        $response->assertStatus(200);
    }
    public function test_create_view(){
        $user     = User::find(28);
        auth()->login($user);
        $response = $this->get('pasiens/create');
        $response->assertStatus(200);
    }
	public function test_store(){
        Storage::fake('s3');
        // make a request with file


        $user     = User::find(28);
        auth()->login($user);

        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

          $nama                        = $this->faker->name;
          $sex                         = rand(0,1);
          $tanggal_lahir               = $this->faker->date('d-m-Y');
          $nama_ibu                    = $this->faker->name;
          $nama_ayah                   = $this->faker->name;
          $no_telp                     = $this->faker->phoneNumber();
          $nomor_ktp                   = $this->faker->numerify('################');
          $asuransi_id                 = 32;
          $jenis_peserta_id               = rand(1,4);
          $nomor_asuransi              = $this->faker->numerify('################');
          $nama_peserta                = $this->faker->name;
          $nomor_asuransi_bpjs         = $this->faker->numerify('################');
          $alamat                      = $this->faker->address;
          $jangan_disms                = rand(0,1);
          $penangguhan_pembayaran_bpjs = rand(0,1);
          $meninggal                   = rand(0,1);
          $verifikasi_prolanis_dm_id   = rand(0,1);
          $verifikasi_prolanis_ht_id   = rand(0,1);
          $prolanis_dm                 = rand(0,1);
          $prolanis_ht                 = rand(0,1);
          $staf_id                     = 11;
          $poli_id                     = rand(1,4);
          $pasien_id                   = "";

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
              'image'                       => $image,
              'ktp_image'                   => $ktp_image,
              'bpjs_image'                  => $bpjs_image,
              'kartu_asuransi_image'        => $kartu_asuransi_image,
              'prolanis_ht_flagging_image'  => $prolanis_ht_flagging_image,
              'prolanis_dm_flagging_image'  => $prolanis_dm_flagging_image,
        ];

        $response = $this->post('pasiens', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $pasiens = Pasien::query()
              ->where("nama", $nama)
              ->where("sex", $sex)
              ->where("tanggal_lahir", Carbon::createFromFormat('d-m-Y', $tanggal_lahir)->format('Y-m-d'))
              ->where("nama_ibu", $nama_ibu)
              ->where("nama_ayah", $nama_ayah)
              ->where("no_telp", $no_telp)
              ->where("nomor_ktp", $nomor_ktp)
              ->where("asuransi_id", $asuransi_id)
              ->where("jenis_peserta_id", $jenis_peserta_id)
              ->where("nomor_asuransi", $nomor_asuransi)
              ->where("nama_peserta", $nama_peserta)
              ->where("nomor_asuransi_bpjs", $nomor_asuransi_bpjs)
              ->where("alamat", $alamat)
              ->where("jangan_disms", $jangan_disms)
              ->where("penangguhan_pembayaran_bpjs", $penangguhan_pembayaran_bpjs)
              ->where("meninggal", $meninggal)
              ->where("verifikasi_prolanis_dm_id", $verifikasi_prolanis_dm_id)
              ->where("verifikasi_prolanis_ht_id", $verifikasi_prolanis_ht_id)
              ->where("prolanis_dm", $prolanis_dm)
              ->where("prolanis_ht", $prolanis_ht)
            ->get();
        $this->assertCount(1, $pasiens);

        $pasien = $pasiens->first();

        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $this->checkForUploadedFile($nama, $model->nama); */

        checkForUploadedFile($image, $pasien->image);
        checkForUploadedFile($image, $pasien->image);
        checkForUploadedFile($ktp_image, $pasien->ktp_image);
        checkForUploadedFile($bpjs_image, $pasien->bpjs_image);
        checkForUploadedFile($kartu_asuransi_image, $pasien->kartu_asuransi_image);
        checkForUploadedFile($prolanis_ht_flagging_image, $pasien->prolanis_ht_flagging_image);
        checkForUploadedFile($prolanis_dm_flagging_image, $pasien->prolanis_dm_flagging_image);

        $response->assertRedirect('antrianpolis');
	}
    public function test_show(){
        $user     = User::find(28);
        auth()->login($user);
        $pasien = Pasien::factory()->create();
        $response = $this->get('pasiens/' . $pasien->id);
        $response->assertStatus(200);
    }
    public function test_edit(){
        $user     = User::find(28);
        auth()->login($user);
        $pasien = Pasien::factory()->create();
        $response = $this->get('pasiens/' . $pasien->id . '/edit');
        $response->assertStatus(200);
    }

    public function test_destroy(){
        $user     = User::find(28);
        auth()->login($user);
        $pasien = Pasien::factory()->create();
        $pasien->periksa()->delete();
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

    public function test_editAtAntrian(){

        $user     = User::find(28);
        auth()->login($user);

        $antrian = Antrian::factory()->create();
        $antrian->antriable_id = $antrian->id;
        $antrian->save();

        $pasien = Pasien::factory()->create();

        $route = 'antrians/proses/pasiens/' . $pasien->id. '/edit/' . $antrian->id;
        $response = $this->get($route);
        $response->assertStatus(200);
    }

    public function test_update(){
        Storage::fake('s3');
        // make a request with file


        $user     = User::find(28);
        auth()->login($user);

        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

          $nama                        = $this->faker->name;
          $sex                         = rand(0,1);
          $tanggal_lahir               = $this->faker->date('d-m-Y');
          $nama_ibu                    = $this->faker->name;
          $nama_ayah                   = $this->faker->name;
          $no_telp                     = $this->faker->phoneNumber();
          $nomor_ktp                   = $this->faker->numerify('################');
          $asuransi_id                 = 32;
          $jenis_peserta_id               = rand(1,4);
          $nomor_asuransi              = $this->faker->numerify('################');
          $nama_peserta                = $this->faker->name;
          $nomor_asuransi_bpjs         = $this->faker->numerify('################');
          $alamat                      = $this->faker->address;
          $jangan_disms                = rand(0,1);
          $penangguhan_pembayaran_bpjs = rand(0,1);
          $meninggal                   = rand(0,1);
          $verifikasi_prolanis_dm_id   = rand(0,1);
          $verifikasi_prolanis_ht_id   = rand(0,1);
          $prolanis_dm                 = rand(0,1);
          $prolanis_ht                 = rand(0,1);
          $staf_id                     = 11;
          $poli_id                     = rand(1,4);
          $pasien_id                   = "";

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
              'image'                       => $image,
              'ktp_image'                   => $ktp_image,
              'bpjs_image'                  => $bpjs_image,
              'kartu_asuransi_image'        => $kartu_asuransi_image,
              'prolanis_ht_flagging_image'  => $prolanis_ht_flagging_image,
              'prolanis_dm_flagging_image'  => $prolanis_dm_flagging_image,
        ];

        $editedPasien = Pasien::factory()->create();


        $response = $this->put('pasiens/' . $editedPasien->id , $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $pasiens = Pasien::query()
              ->where("nama", $nama)
              ->where("sex", $sex)
              ->where("tanggal_lahir", Carbon::createFromFormat('d-m-Y', $tanggal_lahir)->format('Y-m-d'))
              ->where("nama_ibu", $nama_ibu)
              ->where("nama_ayah", $nama_ayah)
              ->where("no_telp", $no_telp)
              ->where("nomor_ktp", $nomor_ktp)
              ->where("asuransi_id", $asuransi_id)
              ->where("jenis_peserta_id", $jenis_peserta_id)
              ->where("nomor_asuransi", $nomor_asuransi)
              ->where("nama_peserta", $nama_peserta)
              ->where("nomor_asuransi_bpjs", $nomor_asuransi_bpjs)
              ->where("alamat", $alamat)
              ->where("jangan_disms", $jangan_disms)
              ->where("penangguhan_pembayaran_bpjs", $penangguhan_pembayaran_bpjs)
              ->where("meninggal", $meninggal)
              ->where("verifikasi_prolanis_dm_id", $verifikasi_prolanis_dm_id)
              ->where("verifikasi_prolanis_ht_id", $verifikasi_prolanis_ht_id)
              ->where("prolanis_dm", $prolanis_dm)
              ->where("prolanis_ht", $prolanis_ht)
            ->get();
        $this->assertCount(1, $pasiens);

        $pasien = $pasiens->first();

        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $this->checkForUploadedFile($nama, $model->nama); */

        checkForUploadedFile($image, $pasien->image);
        checkForUploadedFile($image, $pasien->image);
        checkForUploadedFile($ktp_image, $pasien->ktp_image);
        checkForUploadedFile($bpjs_image, $pasien->bpjs_image);
        checkForUploadedFile($kartu_asuransi_image, $pasien->kartu_asuransi_image);
        checkForUploadedFile($prolanis_ht_flagging_image, $pasien->prolanis_ht_flagging_image);
        checkForUploadedFile($prolanis_dm_flagging_image, $pasien->prolanis_dm_flagging_image);

        $response->assertRedirect('pasiens');
    }

    /* public function test_alergi(){ */
    /*     $user     = User::find(28); */
    /*     auth()->login($user); */
    /*     $pasien = Pasien::factory()->create(); */
    /*     $response = $this->get('pasiens/' . $pasien->id . '/alergi'); */
    /*     $response->assertStatus(200); */
    /* } */

    /* public function test_alergiCreate(){ */
    /*     $user     = User::find(28); */
    /*     auth()->login($user); */
    /*     $pasien = Pasien::factory()->create(); */
    /*     $route ='pasiens/' . $pasien->id . '/alergi/create' ; */
    /*     dd( $route ); */
    /*     $response = $this->get($route); */

    /*     $response->assertStatus(200); */
    /* } */

    /* public function test_alergiDelete() */

    public function test_prolanisTerkendali(){
        $user     = User::find(28);
        auth()->login($user);
        $response = $this->get('prolanis_terkendali');
        $response->assertStatus(200);

    }


    public function test_prolanisTerkendaliPerBulan(){
        $user     = User::find(28);
        auth()->login($user);
        $response = $this->post('pasiens/prolanis_terkendali/per_bulan', [
            'bulan' => date('m'),
            'tahun' => date('Y')
        ]);

        $response->assertStatus(200);

    }
    public function test_denominatorDm(){
        $user     = User::find(28);
        auth()->login($user);
        $response = $this->get('prolanis/denominator_dm');
        $response->assertStatus(200);

    }
    public function test_denominatorHt(){
        $user     = User::find(28);
        auth()->login($user);
        $response = $this->get('prolanis/denominator_ht');
        $response->assertStatus(200);
    }
    public function test_transaksi(){
        $user     = User::find(28);
        auth()->login($user);
        $pasien = Pasien::factory()->create();
        $response = $this->get('pasiens/' . $pasien->id. '/transaksi');
        $response->assertStatus(200);
    }


    /* public function test_getTransaksi(){ */
    /*     $user     = User::find(28); */
    /*     auth()->login($user); */
    /*     $pasien        = Pasien::factory()->create(); */
    /*     $nama_asuransi = 'ksk'; */
    /*     $tanggal       = null; */
    /*     $piutang       = null; */
    /*     $tunai         = null; */
    /*     $response            = $this->get('pasiens/getTransaksi/'. $pasien->id . '?' .Arr::query([ */
    /*         'nama_asuransi' => $nama_asuransi, */
    /*         'tanggal'       => $tanggal, */
    /*         'piutang'       => $piutang, */
    /*         'tunai'         => $tunai */
    /*     ])); */

    /*     $response->assertStatus(200); */

    /* } */

    public function test_dobel(){
        $user     = User::find(28);
        auth()->login($user);
        $response = $this->get('pasien_dobel');
        $response->assertStatus(200);
    }
    public function test_riwayat_pemeriksaan_gula_darah(){
        $user     = User::find(28);
        auth()->login($user);
        $pasien = Pasien::factory()->create();
        $route = 'pasiens/riwayat/gula_darah/' . $pasien->id;
        $response = $this->get($route);
        $response->assertStatus(200);

    }
}
