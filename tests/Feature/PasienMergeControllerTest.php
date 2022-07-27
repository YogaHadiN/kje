<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Pasien;
use Illuminate\Http\Testing\File;
use Arr;

class PasienMergeControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $staf = \App\Models\Staf::factory()->create();

        $periksa = \App\Models\Periksa::factory()->create([
            'staf_id' => $staf->id
        ]);
        $response = $this->get('stafs/'. $staf->id. '/jumlah_pasien/pertahun/' . date('Y') . '/pdf');
        $response->assertStatus(200);
    }

    /**
     * @group failing
     */
    public function test_cariPasien(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);

        $pasien = \App\Models\Pasien::factory()->create();
        $response = $this->get('pasiens/ajax/cari/pasien?' . Arr::query([
            'pasien_id' => $pasien->id
        ]));
        $response
            ->assertstatus(200)
            ->assertjsonfragment([
                'nama' => $pasien->nama,
            ]);
    }
    /**
     * @group failing
     */
    /* public function test_store(){ */
    /*     // make a request with file */


    /*     $user     = User::factory()->create([ */
    /*             'role_id' => 6 */
    /*         ]); */
    /*     auth()->login($user); */

    /*     /1* sebelum kesini ke acting as dulu *1/ */
    /*     /1* key mapping j *1/ */
    /*     /1* dari bentuk '"nama"  => $nama,' *1/ */	
    /*     /1* KE BENTUK *1/ */	
    /*     /1* $nama = $this->faker->text *1/ */

    /*       $nama                        = $this->faker->name; */

    /*     /1* sebelum kesini ke acting as dulu *1/ */
    /*     /1* key mapping l *1/ */
    /*     /1* dari bentuk '"nama"  => $nama,' *1/ */	
    /*     /1* KE BENTUK *1/ */	
    /*     /1* $nama = File::create('nama.png', 100) *1/ */

    /*     $image                      = File::create('image.png', 100); */

    /*     $this->withoutExceptionHandling(); */

    /*     /1* key mapping k *1/ */
    /*     /1* dari bentuk "nama	varchar(255)	NO		NULL" *1/ */	
    /*     /1* KE BENTUK *1/ */	
    /*     /1* "nama" => $nama, *1/ */


    /*     $pasiens = \App\Models\Pasien::factory(2)->create(); */

    /*     $inputAll = [ */
    /*             "tempArray"                        => json_encode($pasiens), */
    /*     ]; */

    /*     $response = $this->post('pasiens/ajax/cari/pasien', $inputAll); */

    /*     /1* key mapping h *1/ */
    /*     /1* dari bentuk '"nama"  => $nama,' *1/ */	
    /*     /1* KE BENTUK *1/ */	
    /*     /1* ->where("nama", $nama) *1/ */

    /*     $pasien = $pasiens->latest()->first(); */

    /*     $pasiens = Pasien::query() */
    /*             ->where("nama", $pasien->nama) */
    /*     ->get(); */

    /*         /1* if ( !$asuransis->count() ) { *1/ */
    /*         /1*     $pasiens = Pasien::all(); *1/ */
    /*         /1*     $pasien_array = []; *1/ */
    /*         /1*     foreach ($pasiens as $a) { *1/ */
    /*         /1*         $pasien_array[] = [ *1/ */
    /*         /1*             "nama"             => $a->nama, *1/ */
    /*         /1*         ]; *1/ */
    /*         /1*     } *1/ */
    /*         /1*     dd(  [ *1/ */
    /*         /1*             "nama"             => $nama, *1/ */
    /*         /1*         ], *1/ */
    /*         /1*         $asu_array *1/ */
    /*         /1*     ); *1/ */
    /*         /1* } *1/ */

    /*     $this->assertCount(1, $pasiens); */

    /*     $response->assertRedirect('pasiens/gabungkan/pasien/ganda'); */
    /* } */
}

/* Route::post('pasiens/ajax/cari/pasien', [\App\Http\Controllers\PasiensMergeController::class, 'cariPasienPost']); */
