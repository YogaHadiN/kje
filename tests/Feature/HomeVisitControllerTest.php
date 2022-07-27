<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\HomeVisit;
use Illuminate\Http\Testing\File;
use Storage;

class HomeVisitControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $response = $this->get('home_visits');
        $response->assertStatus(200);
    }

    public function test_create_view(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $response = $this->get('home_visits/create');
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

		$pasien_id   = \App\Models\Pasien::factory()->create()->id;
		$sistolik    = $this->faker->numerify('###');
		$diastolik   = $this->faker->numerify('##');
		$berat_badan = $this->faker->numerify('##');

        /* sebelum kesini ke acting as dulu */
        /* key mapping l */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = File::create('nama.png', 100) */

        $image                      = File::create('image.png', 100);

        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
            'pasien_id'   => $pasien_id,
            'sistolik'    => $sistolik,
            'diastolik'   => $diastolik,
            'image'       => $image,
            'berat_badan' => $berat_badan,
        ];

        $response = $this->post('home_visits', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $home_visits = HomeVisit::query()
            ->where("pasien_id", $pasien_id)
            ->where("sistolik", $sistolik)
            ->where("diastolik", $diastolik)
            ->where("berat_badan", $berat_badan)
        ->get();

            /* if ( !$asuransis->count() ) { */
            /*     $home_visits = HomeVisit::all(); */
            /*     $home_visit_array = []; */
            /*     foreach ($home_visits as $a) { */
            /*         $home_visit_array[] = [ */
            /*             "nama"             => $a->nama, */
            /*         ]; */
            /*     } */
            /*     dd(  [ */
            /*             "nama"             => $nama, */
            /*         ], */
            /*         $asu_array */
            /*     ); */
            /* } */

        $this->assertCount(1, $home_visits);

        $home_visit = $home_visits->first();

        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $this->checkForUploadedFile($nama, $model->nama); */

        checkForUploadedFile($home_visit, $home_visit->image);

        $response->assertRedirect('home_visits');
    }

    public function test_update(){
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

		$pasien_id   = \App\Models\Pasien::factory()->create()->id;
		$sistolik    = $this->faker->numerify('###');
		$diastolik   = $this->faker->numerify('##');
		$berat_badan = $this->faker->numerify('##');

        /* sebelum kesini ke acting as dulu */
        /* key mapping l */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = File::create('nama.png', 100) */

        $image                      = File::create('image.png', 100);

        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
            'pasien_id'   => $pasien_id,
            'sistolik'    => $sistolik,
            'diastolik'   => $diastolik,
            'image'       => $image,
            'berat_badan' => $berat_badan,
        ];

        $hv = \App\Models\HomeVisit::factory()->create();
        $response = $this->put('home_visits/' . $hv->id, $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $home_visits = HomeVisit::query()
            ->where("pasien_id", $pasien_id)
            ->where("sistolik", $sistolik)
            ->where("diastolik", $diastolik)
            ->where("berat_badan", $berat_badan)
        ->get();

            /* if ( !$asuransis->count() ) { */
            /*     $home_visits = HomeVisit::all(); */
            /*     $home_visit_array = []; */
            /*     foreach ($home_visits as $a) { */
            /*         $home_visit_array[] = [ */
            /*             "nama"             => $a->nama, */
            /*         ]; */
            /*     } */
            /*     dd(  [ */
            /*             "nama"             => $nama, */
            /*         ], */
            /*         $asu_array */
            /*     ); */
            /* } */

        $this->assertCount(1, $home_visits);

        $home_visit = $home_visits->first();

        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $this->checkForUploadedFile($nama, $model->nama); */

        checkForUploadedFile($home_visit, $home_visit->image);

        $response->assertRedirect('home_visits');
    }
    public function test_destroy(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $home_visit = HomeVisit::factory()->create();
        $response = $this->delete('home_visits/' . $home_visit->id);
        $response->assertRedirect('home_visits');
        $this->assertDeleted($home_visit);
    }

    public function test_a_user_can_only_see_home_visit_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        HomeVisit::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        HomeVisit::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, HomeVisit::count());
    }

    public function test_a_user_can_only_create_a_home_visit_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdHomeVisit = HomeVisit::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdHomeVisit->tenant_id == $user1->tenant_id);
    }
}
/* public function searchAjax() */
/* public function createPasien($id) */
/* public function edit($id) */
/* public function store() */
/* public function update($id) */
/* public function destroy($id) */

/* Route::get('/home_visits/ajax/angka_kontak_bpjs', [\App\Http\Controllers\HomeVisitController::class, 'searchAjax']); */
/* Route::get('home_visit/create/pasien/{id}', [\App\Http\Controllers\HomeVisitController::class, 'createPasien']); */
/* Route::resource('home_visits', \App\Http\Controllers\HomeVisitController::class); */
