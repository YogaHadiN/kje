<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Formula;
use Illuminate\Http\Testing\File;
use Storage;

class FormulaAjaxControllerTest extends TestCase
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
        $response = $this->get('formulas');
        $response->assertStatus(200);
    }
    public function test_create_view(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $response = $this->get('formulas/create');
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

          $nama                        = $this->faker->name;

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
                "nama"                        => $nama,
        ];

        $response = $this->post('formulas', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $formulas = Formula::query()
                ->where("nama", $nama)
        ->get();

            /* if ( !$asuransis->count() ) { */
            /*     $formulas = Formula::all(); */
            /*     $formula_array = []; */
            /*     foreach ($formulas as $a) { */
            /*         $formula_array[] = [ */
            /*             "nama"             => $a->nama, */
            /*         ]; */
            /*     } */
            /*     dd(  [ */
            /*             "nama"             => $nama, */
            /*         ], */
            /*         $asu_array */
            /*     ); */
            /* } */

        $this->assertCount(1, $formulas);

        $formula = $formulas->first();

        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $this->checkForUploadedFile($nama, $model->nama); */

        checkForUploadedFile($image, $formula->image);

        $response->assertRedirect('formulas');
    }
    public function test_show(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $formula = Formula::factory()->create();
        $response = $this->get('formulas/' . $formula->id);
        $response->assertStatus(200);
    }
    public function test_edit(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $formula = Formula::factory()->create();
        $response = $this->get('formulas/' . $formula->id . '/edit');
        $response->assertStatus(200);
    }
    public function test_destroy(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $formula = Formula::factory()->create();
        $response = $this->delete('formulas/' . $formula->id);
        $response->assertRedirect('formulas');
        $this->assertDeleted($formula);
    }

    public function test_a_user_can_only_see_formula_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        Formula::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        Formula::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Formula::count());
    }

    /** @test */
    public function test_a_user_can_only_create_a_formula_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdFormula = Formula::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdFormula->tenant_id == $user1->tenant_id);
    }
}
