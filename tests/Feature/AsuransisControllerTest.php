<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\CoasTableSeeder;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\Tarif;
use App\Http\Controllers\AsuransisController;
use App\Models\User;
use App\Models\Asuransi;
use Carbon\Carbon;

class AsuransisControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */

    public function test_index(){

        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);
        $response = $this->get('asuransis');
        $response->assertStatus(200);
    }
    /**
     * 
     */
    public function test_create_view(){



        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);

        $biaya_pribadi = Asuransi::factory()->create([
            'nama' => 'Biaya Pribadi'
        ]);

        /* dd( Asuransi::where('nama', 'Biaya Pribadi')->first() ); */
        Tarif::factory(10)->create([
            'asuransi_id' => $biaya_pribadi
        ]);
        $response = $this->get('asuransis/create');
        $response->assertStatus(200);
    }

    /**
     * 
     */
    public function test_store(){
        // make a request with file
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);

        $biaya_pribadi = Asuransi::factory()->create([
            'nama' => 'Biaya Pribadi'
        ]);

        /* dd( Asuransi::where('nama', 'Biaya Pribadi')->first() ); */
        Tarif::factory(10)->create([
            'asuransi_id' => $biaya_pribadi
        ]);

        $this->seed(CoasTableSeeder::class);
        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

        $nama             = $this->faker->name;
        $alamat           = $this->faker->address;
        $kata_kunci       = $this->faker->text;
        $kali_obat        = rand(1,2);
        $tipe_asuransi_id = \App\Models\TipeAsuransi::factory()->create()->id;
        $tanggal_berakhir = $this->faker->date('d-m-Y');


        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama" => "Asu"*/	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $asu = new AsuransisController;

        $inputAll = [
            "nama"             => $nama,
            "alamat"           => $alamat,
            "kata_kunci"       => $kata_kunci,
            "kali_obat"        => $kali_obat,
            "telpon"           => [ $this->faker->phoneNumber() ],
            "tipe_asuransi_id" => $tipe_asuransi_id,
            "tanggal_berakhir" => $tanggal_berakhir,
            "pic" => [
                0 => $this->faker->name,
                1 => $this->faker->name
            ],
            "hp_pic" => [
                0 => $this->faker->phoneNumber(),
                1 => $this->faker->phoneNumber(),
            ],
            "email" => [
                0 => $this->faker->email,
                1 => $this->faker->email,
            ],
            "aktif" => rand(0,1),
            "tarifs" => json_encode($asu->tarifTemp()['tarif'])
        ];

        $response = $this->post('asuransis', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $asuransis = Asuransi::query()
            ->where("nama", $nama)
            ->where("alamat", $alamat)
            ->where("kata_kunci", $kata_kunci)
            ->where("kali_obat", $kali_obat)
            ->where("tipe_asuransi_id", $tipe_asuransi_id)
            ->where("tanggal_berakhir", Carbon::createFromFormat('d-m-Y', $tanggal_berakhir)->format('Y-m-d'))
        ->get();
        $this->assertCount(1, $asuransis);

        $asuransi = $asuransis->first();

        $response->assertRedirect('asuransis');
    }

    public function test_edit(){
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);
        $asuransi = Asuransi::factory()->create();
        $response = $this->get('asuransis/' . $asuransi->id . '/edit');
        $response->assertStatus(200);
    }

    public function test_destroy(){
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);
        $asuransi = Asuransi::factory()->create();
        $response = $this->delete('asuransis/' . $asuransi->id);
        $response->assertRedirect('asuransis');
        $this->assertDeleted($asuransi);
    }

    public function test_a_user_can_only_see_asuransi_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
            Asuransi::factory()->create([
                        'tenant_id' => $tenant1,
            ]);
        }

        for ($x = 0; $x < 11; $x++) {
            Asuransi::factory()->create([
                        'tenant_id' => $tenant2,
            ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Asuransi::count());
    }

    public function test_a_user_can_only_create_a_asuransi_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdAsuransi = Asuransi::factory()->create();

        $this->assertTrue($createdAsuransi->tenant_id == $user1->tenant_id);
    }
    /**
     * 
     */
    public function test_update(){
        // make a request with file


        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);

        $biaya_pribadi = Asuransi::factory()->create([
            'nama' => 'Biaya Pribadi'
        ]);

        /* dd( Asuransi::where('nama', 'Biaya Pribadi')->first() ); */
        Tarif::factory(10)->create([
            'asuransi_id' => $biaya_pribadi
        ]);
        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

        $nama             = $this->faker->name;
        $alamat           = $this->faker->address;
        $kata_kunci       = $this->faker->text;
        $kali_obat        = rand(1,2);
        $tipe_asuransi_id    = \App\Models\TipeAsuransi::factory()->create()->id;
        $tanggal_berakhir = $this->faker->date('d-m-Y');


        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama" => "Asu"*/	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $asu = new AsuransisController;

        $inputAll = [
            "nama"             => $nama,
            "alamat"           => $alamat,
            "kata_kunci"       => $kata_kunci,
            "kali_obat"        => $kali_obat,
            "telpon"           => [ $this->faker->phoneNumber() ],
            "tipe_asuransi_id"    => $tipe_asuransi_id,
            "tanggal_berakhir" => $tanggal_berakhir,
            "pic" => [
                0 => $this->faker->name,
                1 => $this->faker->name
            ],
            "hp_pic" => [
                0 => $this->faker->phoneNumber(),
                1 => $this->faker->phoneNumber(),
            ],
            "email" => [
                0 => $this->faker->email,
                1 => $this->faker->email,
            ],
            "aktif" => rand(0,1),
            "tarifs" => json_encode($asu->tarifTemp()['tarif'])
        ];

        $updatingAsuransi = Asuransi::factory()->create();
        $response = $this->put('asuransis/' . $updatingAsuransi->id, $inputAll);

        $asuransis = Asuransi::query()
            ->where("nama", $nama)
            ->where("alamat", $alamat)
            ->where("kata_kunci", $kata_kunci)
            ->where("kali_obat", $kali_obat)
            ->where("tipe_asuransi_id", $tipe_asuransi_id)
            ->where("tanggal_berakhir", Carbon::createFromFormat('d-m-Y', $tanggal_berakhir)->format('Y-m-d'))
        ->get();

        /* if ( !$asuransis->count() ) { */
        /*     $updatingAsuransi->fresh(); */
        /*     $asuransis = Asuransi::all(); */
        /*     $asu_array = []; */
        /*     foreach ($asuransis as $a) { */
        /*         $asu_array[] = [ */
        /*             "nama"             => $a->nama, */
        /*             "alamat"           => $a->alamat, */
        /*             "kata_kunci"       => $a->kata_kunci, */
        /*             "kali_obat"        => $a->kali_obat, */
        /*             "tipe_asuransi_id" => $a->tipe_asuransi_id, */
        /*             "tanggal_berakhir" => $a->tanggal_berakhir, */
        /*         ]; */
        /*     } */
        /*     dd(  [ */
        /*             "nama"             => $nama, */
        /*             "alamat"           => $alamat, */
        /*             "kata_kunci"       => $kata_kunci, */
        /*             "kali_obat"        => $kali_obat, */
        /*             "tipe_asuransi_id" => $tipe_asuransi_id, */
        /*             "tanggal_berakhir" => Carbon::createFromFormat('d-m-Y', $tanggal_berakhir)->format('Y-m-d'), */
        /*         ], */
        /*         $asu_array */
        /*     ); */
        /* } */
        $this->assertCount(1, $asuransis);

        $asuransi = $asuransis->first();

        $response->assertRedirect('asuransis');
    }

    public function test_riwayat(){
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);
        $asuransi = Asuransi::factory()->create();
        $response = $this->get('asuransis/riwayat/' . $asuransi->id);
        $response->assertStatus(200);
    }

    public function test_hutangPerBulan(){
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);
        $response = $this->get('hutang_asuransi/' . date('m'). '/' . date('Y'));
        $response->assertStatus(200);
    }
    public function test_hutang(){
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);
        $response = $this->get('hutang_asuransi/' . date('Y'));
        $response->assertStatus(200);
    }
    public function test_piutangAsuransiSudahDibayar(){
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);
        $asuransi = Asuransi::factory()->create();
        $response = $this->get('asuransis/' . $asuransi->id . '/piutangAsuransi/SudahDibayar/'. date('Y-m-01') .'/' . date('Y-m-t'));
        $response->assertStatus(200);
    }
    public function test_piutangAsuransiBelumDibayar(){
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);
        $asuransi = Asuransi::factory()->create();
        $response = $this->get('asuransis/'. $asuransi->id .'/piutangAsuransi/BelumDibayar/'. date('Y-m-01') .'/' . date('Y-m-t'));
        $response->assertStatus(200);
    }
    public function test_piutangAsuransi(){
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);
        $asuransi = Asuransi::factory()->create();
        $response = $this->get('asuransis/' . $asuransi->id .'/piutangAsuransi/Semua/'. date('Y-m-01') .'/' . date('Y-m-t'));
        $response->assertStatus(200);
    }
    public function test_tunggakan(){
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);
        $response = $this->get('tunggakan_asuransi/' . date('Y'));
        $response->assertStatus(200);
    }
}
