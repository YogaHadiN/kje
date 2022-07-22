<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Rekening;
use Illuminate\Http\Testing\File;
use Storage;
use Arr;

class RekeningControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $akun_bank = \App\Models\AkunBank::factory()->create();
        \App\Models\Coa::factory()->create([
            'kode_coa' => 110004
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' => 400045
        ]);

        \App\Models\Rekening::factory(30)->create([
            'akun_bank_id' => $akun_bank
        ]);


        $response = $this->get('rekening_bank/' .$akun_bank->id);
        $response->assertStatus(200);
    }
    /**
     * @group failing
     */
    public function test_search(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        $akun_bank = \App\Models\AkunBank::factory()->create();

        \App\Models\Coa::factory()->create([
            'kode_coa' => 110004
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' => 400045
        ]);

        \App\Models\Rekening::factory(30)->create([
            'akun_bank_id' => $akun_bank
        ]);

        $name = $this->faker->name;
        $date = $this->faker->date('Y-m-d');
        \App\Models\Rekening::factory(30)->create([
            'akun_bank_id' => $akun_bank,
            'tanggal'      => $date,
            'deskripsi'    => $name,
            'pembayaran_asuransi_id'    => null,
        ]);

        $tanggal         = $date;
        $displayed_rows  = 1;
        $key             = 0;
        $deskripsi       = $name;
        $akun_bank_id    = $akun_bank->id;
        $pembayaran_null = 1;

        $response = $this->get('rekening_bank/search?' . Arr::query([
            'tanggal'         => $tanggal,
            'displayed_rows'  => $displayed_rows,
            'key'             => $key,
            'deskripsi'       => $deskripsi,
            'akun_bank_id'    => $akun_bank_id,
            'pembayaran_null' => $pembayaran_null,
        ]));

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'deskripsi' => $deskripsi,
            ]);
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

        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
                "id"                        => $id,
        ];

        $response = $this->post('rekenings', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $rekenings = Rekening::query()
                ->where("nama", $nama)
        ->get();

            /* if ( !$asuransis->count() ) { */
            /*     $rekenings = Rekening::all(); */
            /*     $rekening_array = []; */
            /*     foreach ($rekenings as $a) { */
            /*         $rekening_array[] = [ */
            /*             "nama"             => $a->nama, */
            /*         ]; */
            /*     } */
            /*     dd(  [ */
            /*             "nama"             => $nama, */
            /*         ], */
            /*         $asu_array */
            /*     ); */
            /* } */

        $this->assertCount(1, $rekenings);

        $rekening = $rekenings->first();

        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $this->checkForUploadedFile($nama, $model->nama); */

        checkForUploadedFile($image, $rekening->image);

        $response->assertRedirect('rekenings');
    }
    public function test_show(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $rekening = Rekening::factory()->create();
        $response = $this->get('rekenings/' . $rekening->id);
        $response->assertStatus(200);
    }
    public function test_edit(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $rekening = Rekening::factory()->create();
        $response = $this->get('rekenings/' . $rekening->id . '/edit');
        $response->assertStatus(200);
    }
    public function test_destroy(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $rekening = Rekening::factory()->create();
        $response = $this->delete('rekenings/' . $rekening->id);
        $response->assertRedirect('rekenings');
        $this->assertDeleted($rekening);
    }

    public function test_a_user_can_only_see_rekening_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
            Rekening::factory()->create([
                'tenant_id' => $tenant1,
            ]);
        }

        for ($x = 0; $x < 11; $x++) {
            Rekening::factory()->create([
                'tenant_id' => $tenant2,
            ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Rekening::count());
    }

    public function test_a_user_can_only_create_a_rekening_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdRekening = Rekening::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdRekening->tenant_id == $user1->tenant_id);
    }
}

/* public function ignore($id) */
/* public function ignoredList() */
/* public function ignoredListAjax() */
/* public function show($rekening_id) */
/* public function unignore($id) */
/* public function importCreate() */
/* public function importPost() */

