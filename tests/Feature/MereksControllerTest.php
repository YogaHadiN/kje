<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Merek;
use App\Models\Rak;
use App\Models\Formula;
use App\Http\Controllers\MereksController;
class MereksControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */

    /**
     * 
     */
    public function test_index(){
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);
        $response = $this->get('mereks');
        $response->assertStatus(200);
    }
    /**
     * 
     */
    public function test_create_view(){
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);
        $formula = Formula::factory()->create();
        $rak = Rak::factory()->create([
            'formula_id' => $formula
        ]);

        $response = $this->get('/create/mereks/' . $rak->id);
        $response->assertStatus(200);
    }
        /**
         * 
         */
    public function test_store(){
        // make a request with file


        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);

        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

          $merek = $this->faker->name;
          $rak_id = Rak::factory()->create()->id;
          $endfix = $this->faker->text;

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
          "merek"  => $merek,
          "rak_id" => $rak_id,
          "endfix" => $endfix
        ];

        $response = $this->post('mereks', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $mr = new MereksController;
        $merekCustom = $mr->merekCustom($merek, $endfix);
        $mereks = Merek::query()
          ->where("merek", $merekCustom )
          ->where("rak_id", $rak_id)
        ->get();
        $this->assertCount(1, $mereks);

        $merek = $mereks->first();

        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $this->checkForUploadedFile($nama, $model->nama); */

        /* checkForUploadedFile($image, $merek->image); */

        $response->assertRedirect('mereks');
    }
    /**
     * 
     */
    public function test_edit(){
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);
        $merek = $this->createMerek();
        $response = $this->get('mereks/' . $merek->id . '/edit');
        $response->assertStatus(200);
    }

    /**
     * 
     */
    public function test_destroy(){
        $user     = User::factory()->create(['role_id' => 6]);
        auth()->login($user);
        $merek = $this->createMerek();
        $response = $this->delete('mereks/' . $merek->id);
        $response->assertRedirect('mereks');
        $this->assertDeleted($merek);
    }

    public function test_a_user_can_only_see_merek_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
            $this->createMerekWithTenant($tenant1);
        }

        for ($x = 0; $x < 11; $x++) {
            $this->createMerekWithTenant($tenant2);
        }

        auth()->login($user1);

        $this->assertEquals(10, Merek::count());
    }

    /** @test */
    public function test_a_user_can_only_create_a_merek_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdMereks = $this->createMerek();

        $this->assertTrue($createdMereks->tenant_id == $user1->tenant_id);
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function createMerek($tenant_id = null)
    {
        $formula = Formula::factory()->create();
        $rak = Rak::factory()->create([
            'formula_id' => $formula
        ]);
        $merek = Merek::factory()->create([
            'rak_id' => $rak
        ]);
        return $merek;
    }

    private function createMerekWithTenant($tenant)
    {
        $formula = Formula::factory()->create([
            'tenant_id' => $tenant
        ]);
        $rak = Rak::factory()->create([
            'tenant_id' => $tenant,
            'formula_id' => $formula
        ]);
        $merek = Merek::factory()->create([
            'tenant_id' => $tenant,
            'rak_id' => $rak
        ]);
        return $merek;
    }

	/* public function ajaxObat() */
}
