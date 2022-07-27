<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\Pasien;
use Carbon\Carbon;
use App\Models\Staf;
use App\Models\Poli;
use App\Models\AntrianPeriksa;
use App\Models\AntrianPoli;
use App\Models\User;
use App\Models\Fasilitas;
use Illuminate\Http\Testing\File;
use Storage;
class FasilitasControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_antrian_pasien(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);

        \App\Models\AntrianPeriksa::factory(30)->create();

        $response = $this->get('fasilitas/antrian_pasien');
        $response->assertStatus(200);
    }
    public function test_antrianAjax(){
        $user     = User::factory()->create([
                        'role_id' => 6
                    ]);
        auth()->login($user);

        $jenis_antrian = \App\Models\JenisAntrian::factory()->create();
        \App\Models\Antrian::factory(10)->create([
            'jenis_antrian_id' => $jenis_antrian
        ]);
        $response = $this->get('fasilitas/antrian_pasien/ajax/' . $jenis_antrian->id);
    }

    public function test_getTambahAntrian(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $jenis_antrian = \App\Models\JenisAntrian::factory()->create();
        \App\Models\Antrian::factory(10)->create([
            'jenis_antrian_id' => $jenis_antrian
        ]);
        $response = $this->get("fasilitas/antrian_pasien/tambah/" . $jenis_antrian->id);
        $response->assertRedirect('/');
        $this->followRedirects($response)
            ->assertSee('Berhasil ditambahkan');
    }

    public function test_input_telp(){
        $response = $this->get('fasilitas/input_telp');
        $response->assertStatus(200);
    }
    public function test_survey_kepuasan_pelanggan(){
        $response = $this->get('fasilitas/survey');
        $response->assertStatus(200);
    }

    /**
     * 
     */
    public function test_store_antrian_poli(){

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

        $antrian = \App\Models\Antrian::factory()->create();
        $response = $this->post('antrians/antrianpolis/' . $antrian->id, $inputAll);

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

    public function test_create_pasien(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);

        \App\Models\AntrianPeriksa::factory(30)->create();
        \App\Models\Poli::factory()->create([
            'poli' => 'Poli Gawat Darurat'
        ]);


        $antrian = \App\Models\Antrian::factory()->create();
        $jenis_antrian = $antrian->jenis_antrian;

        \App\Models\PoliAntrian::factory(5)->create([
            'jenis_antrian_id' => $jenis_antrian
        ]);
        $response = $this->get('antrians/'. $antrian->id .'/pasiens/create');
        $response->assertStatus(200);
    }
    public function test_list_antrian(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);

        \App\Models\AntrianPeriksa::factory(30)->create();
        \App\Models\Poli::factory()->create([
            'poli' => 'Poli Gawat Darurat'
        ]);

        $antrian = \App\Models\Antrian::factory()->create();
        $jenis_antrian = $antrian->jenis_antrian;

        \App\Models\PoliAntrian::factory(5)->create([
            'jenis_antrian_id' => $jenis_antrian
        ]);
        $response = $this->get('antrians');
        $response->assertStatus(200);
    }

    public function test_antrianPoliDestroy()
    {
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);

        $pasien = \App\Models\Pasien::factory()->create();

        $antrianPoli = \App\Models\AntrianPoli::factory()->create([
            'pasien_id' => $pasien
        ]);

        $antrian = \App\Models\Antrian::factory()->create([
            'antriable_id' => $antrianPoli,
            'antriable_type' => 'App\\Models\\AntrianPoli',
        ]);

        $response = $this->delete('fasilitas/antrianpolis/destroy', [
            'pasien_id' => $pasien->id,
            'id' => $antrian->id
        ]);

        $response->assertRedirect('/');
        $this->assertDeleted($antrianPoli);
    }

    public function test_antrianPeriksaDestroy()
    {
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);

        $pasien = \App\Models\Pasien::factory()->create();

        $staf = \App\Models\Staf::factory()->create();
        $antrianPeriksa = \App\Models\AntrianPeriksa::factory()->create([
            'pasien_id' => $pasien,
            'staf_id'   => $staf
        ]);

        $antrian = \App\Models\Antrian::factory()->create([
            'antriable_id'   => $antrianPeriksa,
            'antriable_type' => 'App\\Models\\AntrianPeriksa',
        ]);




        /* dd( AntrianPeriksa::all() ); */

        $response = $this->delete('fasilitas/antrianperiksa/destroy', [
            'pasien_id'    => $pasien->id,
            'id'           => $antrian->id,
            'alasan_kabur' => $this->faker->text,
            'staf_id'      => $staf->id
        ]);

        /* dd( AntrianPeriksa::all() ); */

        $response->assertRedirect('/');
        $this->assertDeleted($antrianPeriksa);
    }


    /**
     * 
     */
    public function test_submit_antrian(){
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


        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $poli     = \App\Models\Poli::factory()->create();
        $pasien   = \App\Models\Pasien::factory()->create();
        $asuransi = \App\Models\Asuransi::factory()->create();

        $inputAll = [
                "poli"     => $poli->id,
                "pasien"   => $pasien->id,
                "asuransi" => $asuransi->id,
        ];

        $response = $this->post("fasilitas/antrian_pasien/". $poli->id . "/tanggal/" . $pasien->id . "/" . $asuransi->id);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $antrians = AntrianPoli::query()
                ->where("pasien_id", $pasien->id)
                ->where("asuransi_id", $asuransi->id)
                ->where("poli_id", $poli->id)
        ->get();

            /* if ( !$asuransis->count() ) { */
            /*     $antrians = Antrian::all(); */
            /*     $antrian_array = []; */
            /*     foreach ($antrians as $a) { */
            /*         $antrian_array[] = [ */
            /*             "nama"             => $a->nama, */
            /*         ]; */
            /*     } */
            /*     dd(  [ */
            /*             "nama"             => $nama, */
            /*         ], */
            /*         $asu_array */
            /*     ); */
            /* } */

        $this->assertCount(1, $antrians);

        $response->assertRedirect('fasilitas/antrian_pasien');
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

        \App\Models\Asuransi::factory()->create([
            'tipe_asuransi_id' => 5
        ]);

        $poli = \App\Models\Poli::factory()->create([
            'poli' => 'Poli Gawat Darurat'
        ]);

        $antrian = \App\Models\Antrian::factory()->create();

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
          $antrian_id                 = $antrian->id;
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
          'antrian_id'                  => $antrian_id,
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

}

/* Route::get('fasilitas/antrian_pasien/{poli}', [\App\Http\Controllers\FasilitasController::class, 'input_tgl_lahir']); //antrian pasien */
/* Route::get('fasilitas/antrian_pasien/{poli}/{tanggal_lahir}', [\App\Http\Controllers\FasilitasController::class, 'post_tgl_lahir']); //antrian pasien */

/* Route::post('fasilitas/antrian_pasien/{poli}/tanggal/{pasien_id}', [\App\Http\Controllers\FasilitasController::class, 'cari_asuransi']); //cari_pasien */

/* Route::put('fasilitas/konfirmasi', [\App\Http\Controllers\FasilitasController::class, 'konfirmasi']); //antrian pasien */
