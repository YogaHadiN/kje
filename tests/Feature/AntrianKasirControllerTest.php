<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\AntrianKasir;
use Illuminate\Http\Testing\File;
use Storage;

class AntrianKasirControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);
        $response = $this->get('antriankasirs');
        $response->assertStatus(200);
    }
    public function test_kembali(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);
        $ak = \App\Models\AntrianKasir::factory()->create();
        $response = $this->post('antriankasirs/kembali/'. $ak->id);
        $response->assertRedirect('/');
    }
    public function test_a_user_can_only_see_antriankasir_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        AntrianKasir::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        AntrianKasir::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, AntrianKasir::count());
    }
    public function test_a_user_can_only_create_a_antriankasir_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdAntrianKasir = AntrianKasir::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdAntrianKasir->tenant_id == $user1->tenant_id);
    }
}
