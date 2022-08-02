<?php

namespace Tests\Feature;

use Log;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Classes\Yoga;
use App\Models\Staf;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
 

class StafsControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * 
     */
    public function test_index_displays_view()
    {
        $user     = User::factory()->create([
            'role_id' => 6
        ]);

        auth()->login($user);
        $response = $this->get('stafs');
        $response->assertStatus(200);
    }


    /**
     * @test
     */
    /**
     * 
     */
    public function test_create_displays_view()
    {
        
        $user     = User::factory()->create([
            'role_id' => 6
        ]);

        auth()->login($user);
        $response = $this->get('stafs/create');
        $response->assertStatus(200);
    }


    public function test_store_saves_and_redirects()
    {
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

        $nama             = $this->faker->name;
        $alamat_domisili  = $this->faker->address;
        $tanggal_lahir    = $this->faker->date('d-m-Y');
        $ktp              = $this->faker->numerify('################');
        $email            = $this->faker->email;
        $no_telp          = $this->faker->phoneNumber();
        $alamat_ktp       = $this->faker->address;
        $str              = $this->faker->numerify('################');;
        $universitas_asal = $this->faker->name;
        $titel            = "dr";
        $no_hp            = $this->faker->phoneNumber();
        $tanggal_lulus    = $this->faker->date('d-m-Y');
        $tanggal_mulai    = $this->faker->date('d-m-Y');
        $menikah          = "1";
        $jumlah_anak      = "1";
        $npwp             = $this->faker->numerify('################');;
        $jenis_kelamin    = "1";
        $sip              = $this->faker->numerify('################');;
        $nomor_rekening   = $this->faker->numerify('################');;
        $bank             = $this->faker->text;


        /* sebelum kesini ke acting as dulu */
        /* key mapping l */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = File::create('nama.png', 100) */
        $image          = File::create('image1.png', 100);
        $ktp_image      = File::create('image2.png', 100);
        $str_image      = File::create('image3.png', 100);
        $sip_image      = File::create('image4.png', 100);
        $gambar_npwp    = File::create('image5.png', 100);
        $kartu_keluarga = File::create('image6.png', 100);


        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */
        $response = $this->post('stafs', [
            "nama"             => $nama,
            "alamat_domisili"  => $alamat_domisili,
            "tanggal_lahir"    => $tanggal_lahir,
            "ktp"              => $ktp,
            "email"            => $email,
            "no_telp"          => $no_telp,
            "alamat_ktp"       => $alamat_ktp,
            "str"              => $str,
            "universitas_asal" => $universitas_asal,
            "titel"            => $titel,
            "no_hp"            => $no_hp,
            "tanggal_lulus"    => $tanggal_lulus,
            "tanggal_mulai"    => $tanggal_mulai,
            "menikah"          => $menikah,
            "jumlah_anak"      => $jumlah_anak,
            "npwp"             => $npwp,
            "jenis_kelamin"    => $jenis_kelamin,
            "sip"              => $sip,
            "nomor_rekening"   => $nomor_rekening,
            "bank"             => $bank,
            "image"            => $image,
            "ktp_image"        => $ktp_image,
            "str_image"        => $str_image,
            "sip_image"        => $sip_image,
            "gambar_npwp"      => $gambar_npwp,
            "kartu_keluarga"   => $kartu_keluarga,
        ]);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        /* dd( $tanggal_lahir, Carbon::createFromFormat('d-m-Y', $tanggal_lahir)->format('Y-m-d') ); */
        $stafs = Staf::query()
            ->where("nama", $nama)
            ->where("alamat_domisili", $alamat_domisili)
            ->where("tanggal_lahir", 'like', Carbon::createFromFormat('d-m-Y', $tanggal_lahir)->format('Y-m-d') . '%')
            ->where("ktp", $ktp)
            ->where("email", $email)
            ->where("no_telp", $no_telp)
            ->where("alamat_ktp", $alamat_ktp)
            ->where("str", $str)
            ->where("universitas_asal", $universitas_asal)
            ->where("titel", $titel)
            ->where("no_hp", $no_hp)
            ->where("tanggal_lulus", 'like',  Carbon::createFromFormat('d-m-Y', $tanggal_lulus)->format('Y-m-d') . '%')
            ->where("tanggal_mulai", 'like',  Carbon::createFromFormat('d-m-Y', $tanggal_mulai)->format('Y-m-d') . '%')
            ->where("menikah", $menikah)
            ->where("jumlah_anak", $jumlah_anak)
            ->where("npwp", $npwp)
            ->where("jenis_kelamin", $jenis_kelamin)
            ->where("sip", $sip)
            ->where("nomor_rekening", $nomor_rekening)
            ->where("bank", $bank)
            ->get();
        /* dd( Staf::first()->tanggal_lahir->format('d-m-Y') , $tanggal_lahir ); */
        /* dd( Staf::first() ); */
        $this->assertCount(1, $stafs);
        $staf = $stafs->first();

        /* dd( Staf::all() ); */
        
        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* checkForUploadedFile($nama, $model->nama); */

        checkForUploadedFile($image, $staf->image);
        checkForUploadedFile($ktp_image, $staf->ktp_image);
        checkForUploadedFile($str_image, $staf->str_image);
        checkForUploadedFile($sip_image, $staf->sip_image);
        checkForUploadedFile($gambar_npwp, $staf->gambar_npwp);
        checkForUploadedFile($kartu_keluarga, $staf->kartu_keluarga);

        $response->assertRedirect('stafs');
    }


    /**
     * 
     */
    public function test_edit_displays_view()
    {
        $user     = User::factory()->create([
            'role_id' => 6
        ]);

        auth()->login($user);
        $staf     = Staf::factory()->create();

        $response = $this->get('stafs/' . $staf->id . '/edit');
        $response->assertStatus(200);
    }

    /**
     * 
     */
    public function test_update_redirects()
    {
        

        Storage::fake('s3');
 
        // make a request with file
 
        $user     = User::factory()->create([
            'role_id' => 6
        ]);

        /* key mapping j */
        $nama             = $this->faker->name;
        $alamat_domisili  = $this->faker->address;
        $tanggal_lahir    = $this->faker->date('d-m-Y');
        $ktp              = $this->faker->numerify('################');
        $email            = $this->faker->email;
        $no_telp          = $this->faker->phoneNumber();
        $alamat_ktp       = $this->faker->address;
        $str              = $this->faker->numerify('################');;
        $universitas_asal = $this->faker->name;
        $titel            = "dr";
        $no_hp            = $this->faker->phoneNumber();
        $tanggal_lulus    = $this->faker->date('d-m-Y');
        $tanggal_mulai    = $this->faker->date('d-m-Y');
        $menikah          = "1";
        $jumlah_anak      = "1";
        $npwp             = $this->faker->numerify('################');;
        $jenis_kelamin    = "1";
        $sip              = $this->faker->numerify('################');;
        $nomor_rekening   = $this->faker->numerify('################');;
        $bank             = $this->faker->word;

        $image          = File::create('image1.png', 100);
        $ktp_image      = File::create('image2.png', 100);
        $str_image      = File::create('image3.png', 100);
        $sip_image      = File::create('image4.png', 100);
        $gambar_npwp    = File::create('image5.png', 100);
        $kartu_keluarga = File::create('image6.png', 100);

        $this->withoutExceptionHandling();

        /* key mapping k */
        $staf     = Staf::factory()->create();

        $response = $this->actingAs($user)->put('stafs/' . $staf->id, [
            "nama"             => $nama,
            "alamat_domisili"  => $alamat_domisili,
            "tanggal_lahir"    => $tanggal_lahir,
            "ktp"              => $ktp,
            "email"            => $email,
            "no_telp"          => $no_telp,
            "alamat_ktp"       => $alamat_ktp,
            "str"              => $str,
            "universitas_asal" => $universitas_asal,
            "titel"            => $titel,
            "no_hp"            => $no_hp,
            "tanggal_lulus"    => $tanggal_lulus,
            "tanggal_mulai"    => $tanggal_mulai,
            "menikah"          => $menikah,
            "jumlah_anak"      => $jumlah_anak,
            "npwp"             => $npwp,
            "jenis_kelamin"    => $jenis_kelamin,
            "sip"              => $sip,
            "nomor_rekening"   => $nomor_rekening,
            "bank"             => $bank,
            "image"            => $image,
            "ktp_image"        => $ktp_image,
            "str_image"        => $str_image,
            "sip_image"        => $sip_image,
            "gambar_npwp"      => $gambar_npwp,
            "kartu_keluarga"   => $kartu_keluarga,
        ]);

        /* key mapping l */
        $stafs = Staf::query()
            ->where("nama", $nama)
            ->where("alamat_domisili", $alamat_domisili)
            ->where("tanggal_lahir", 'like',  Carbon::createFromFormat('d-m-Y', $tanggal_lahir)->format('Y-m-d') . '%')
            ->where("ktp", $ktp)
            ->where("email", $email)
            ->where("no_telp", $no_telp)
            ->where("alamat_ktp", $alamat_ktp)
            ->where("str", $str)
            ->where("universitas_asal", $universitas_asal)
            ->where("titel", $titel)
            ->where("no_hp", $no_hp)
            ->where("tanggal_lulus", 'like',  Carbon::createFromFormat('d-m-Y', $tanggal_lulus)->format('Y-m-d') . '%')
            ->where("tanggal_mulai", 'like',  Carbon::createFromFormat('d-m-Y', $tanggal_mulai)->format('Y-m-d') . '%')
            ->where("menikah", $menikah)
            ->where("jumlah_anak", $jumlah_anak)
            ->where("npwp", $npwp)
            ->where("jenis_kelamin", $jenis_kelamin)
            ->where("sip", $sip)
            ->where("nomor_rekening", $nomor_rekening)
            ->where("bank", $bank)
            ->get();
        $this->assertCount(1, $stafs);
        
        // report was created and file was stored
        $staf = $stafs->first();

        checkForUploadedFile($image, $staf->image);
        checkForUploadedFile($ktp_image, $staf->ktp_image);
        checkForUploadedFile($str_image, $staf->str_image);
        checkForUploadedFile($sip_image, $staf->sip_image);
        checkForUploadedFile($gambar_npwp, $staf->gambar_npwp);
        checkForUploadedFile($kartu_keluarga, $staf->kartu_keluarga);

        $response->assertRedirect('stafs');
    }

    /**
     * @test
     */
    /**
     * 
     */
    public function test_destroy_deletes_and_redirects()
    {
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);
        $staf     = Staf::factory()->create();
        $response = $this->actingAs($user)->delete('stafs/' . $staf->id);

        $response->assertRedirect('stafs');
        $this->assertDeleted($staf);
    }



    public function test_a_user_can_only_see_stafs_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
            Staf::factory()->create([
                'tenant_id' => $tenant1,
            ]);
        }

        for ($x = 0; $x < 11; $x++) {
            Staf::factory()->create([
                'tenant_id' => $tenant2,
            ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Staf::count());
    }

    public function test_a_user_can_only_create_a_staf_in_his_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdUser = User::factory()->create();

        $this->assertTrue($createdUser->tenant_id == $user1->tenant_id);
    }

    public function test_a_user_can_only_create_a_staf()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdUser = User::factory()->make();
        $createdUser->tenant_id = $tenant2->id;
        $createdUser->save();

        $this->assertTrue($createdUser->tenant_id == $user1->tenant_id);
    }
    
}


