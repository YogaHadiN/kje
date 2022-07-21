<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Http\Controllers\RaksController;
use App\Models\User;
use App\Models\Rak;
use App\Models\Merek;
use App\Models\Formula;
use Carbon\Carbon;
class RakControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_create_view(){
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);
        $formula = Formula::factory()->create();
        $response = $this->get('create/raks/' . $formula->id);
        $response->assertStatus(200);
    }
    public function test_store(){
        // make a request with file


        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);

        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

        $formula       = Formula::factory()->create();
        $formula_id    = $formula->id;
        $merek         = $this->faker->name;
        $kode_rak      = $this->faker->numerify('##');
        $kelas_obat_id = rand(1,3);
        $exp_date      = $this->faker->date('d-m-Y');
        $fornas        = rand(0,1);
        $harga_beli    = $this->faker->numerify('###');
        $harga_jual    = $this->faker->numerify('###');
        $stok          = $this->faker->numerify('###');
        $stok_minimal  = $this->faker->numerify('###');


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
          "formula_id"    => $formula_id,
          "merek"         => $merek,
          "kode_rak"      => $kode_rak,
          "kelas_obat_id" => $kelas_obat_id,
          "exp_date"      => $exp_date,
          "fornas"        => $fornas,
          "harga_beli"    => $harga_beli,
          "harga_jual"    => $harga_jual,
          "stok"          => $stok,
          "stok_minimal"  => $stok_minimal,
        ];

        $this->withoutExceptionHandling();
        $response = $this->post('raks', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $exp_date = Carbon::createFromFormat('d-m-Y', $exp_date)->format('Y-m-d');

        $raks = Rak::where("formula_id", $formula_id)
          ->where("kelas_obat_id", $kelas_obat_id)
          ->where("exp_date", $exp_date)
          ->where("kode_rak", $kode_rak)
          ->where("fornas", $fornas)
          ->where("harga_beli", $harga_beli)
          ->where("harga_jual", $harga_jual)
          ->where("stok", $stok)
          ->where("stok_minimal", $stok_minimal)
        ->get();

        $this->assertCount(1, $raks);

        $rak = $raks->first();
        $rc = new RaksController;
        $mereks = Merek::query()
          ->where("merek", $rc->customMerek($formula, $merek))
          ->where("rak_id", $rak->id)
        ->get();

        $this->assertCount(1, $raks);

        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $this->checkForUploadedFile($nama, $model->nama); */


        $response->assertRedirect('mereks');
    }

    /**
     * 
     */
    public function test_update(){
        // make a request with file


        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);

        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

        $formula       = Formula::factory()->create();
        $formula_id    = $formula->id;
        $merek         = $this->faker->name;
        $kode_rak      = $this->faker->numerify('##');
        $kelas_obat_id = rand(1,3);
        $exp_date      = $this->faker->date('d-m-Y');
        $fornas        = rand(0,1);
        $harga_beli    = $this->faker->numerify('###');
        $harga_jual    = $this->faker->numerify('###');
        $stok          = $this->faker->numerify('###');
        $stok_minimal  = $this->faker->numerify('###');


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
          "formula_id"    => $formula_id,
          "merek"         => $merek,
          "kode_rak"      => $kode_rak,
          "kelas_obat_id" => $kelas_obat_id,
          "exp_date"      => $exp_date,
          "fornas"        => $fornas,
          "harga_beli"    => $harga_beli,
          "harga_jual"    => $harga_jual,
          "stok"          => $stok,
          "stok_minimal"  => $stok_minimal,
        ];

        $this->withoutExceptionHandling();

        $rak = Rak::factory()->create([
            'formula_id' => $formula
        ]);
        $response = $this->put('raks/' . $rak->id, $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $exp_date = Carbon::createFromFormat('d-m-Y', $exp_date)->format('Y-m-d');

        $raks = Rak::where("formula_id", $formula_id)
          ->where("kelas_obat_id", $kelas_obat_id)
          ->where("exp_date", $exp_date)
          ->where("kode_rak", $kode_rak)
          ->where("fornas", $fornas)
          ->where("harga_beli", $harga_beli)
          ->where("harga_jual", $harga_jual)
          ->where("stok", $stok)
          ->where("stok_minimal", $stok_minimal)
        ->get();
        /* dd([ */
        /*         "formula_id" => $formula_id, */
        /*       "kelas_obat_id" => $kelas_obat_id, */
        /*       "exp_date" => $exp_date, */
        /*       "kode_rak" => $kode_rak, */
        /*       "fornas" => $fornas, */
        /*       "harga_beli" => $harga_beli, */
        /*       "harga_jual" => $harga_jual, */
        /*       "stok" => $stok, */
        /*       "stok_minimal" => $stok_minimal, */
        /* ]); */

        $this->assertCount(1, $raks);

        $rak = $raks->first();
        $rc = new RaksController;
        $mereks = Merek::query()
          ->where("merek", $rc->customMerek($formula, $merek))
          ->where("rak_id", $rak->id)
        ->get();

        $this->assertCount(1, $raks);

        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $this->checkForUploadedFile($nama, $model->nama); */


        $response->assertRedirect('mereks');
    }
    public function test_edit(){
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);
        $rak = Rak::factory()->create();
        $response = $this->get('raks/' . $rak->id . '/edit');
        $response->assertStatus(200);
    }
    public function test_destroy(){
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);
        $rak = Rak::factory()->create();
        $response = $this->delete('raks/' . $rak->id);
        $response->assertRedirect('mereks');
        $this->assertDeleted($rak);
    }
    /**
     * 
     */
    public function test_a_user_can_only_see_rak_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        Rak::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        Rak::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Rak::count());
    }

        /**
         * 
         */
    public function test_a_user_can_only_create_a_rak_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdRak = Rak::factory()->create();

        $this->assertTrue($createdRak->tenant_id == $user1->tenant_id);
    }
}
