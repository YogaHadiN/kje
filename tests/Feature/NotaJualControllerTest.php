<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\JurnalUmum;
use App\Models\User;
use App\Models\NotaJual;
use Illuminate\Http\Testing\File;
use Storage;

class NotaJualControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index(){
            $user     = User::factory()->create([
                'role_id' => 6
            ]);
        
        auth()->login($user);
        $response = $this->get('nota_juals');
        $response->assertStatus(200);
    }
    public function test_show(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        $nota_jual = \App\Models\NotaJual::factory()->create();
        \App\Models\JurnalUmum::factory()->create([
            'jurnalable_id'   => $nota_jual->id,
            'jurnalable_type' => 'App\Models\NotaJual',
            'debit'           => '1'
        ]);

        $response = $this->get('nota_juals/' . $nota_jual->id);
        $response->assertStatus(200);
    }
    public function test_edit(){
        $user     = User::factory()->create([
                        'role_id' => 6
                    ]);
        auth()->login($user);
        $nota_jual = NotaJual::factory()->create();
        $response = $this->get("nota_juals/" . $nota_jual->id. "/edit");
        $response->assertStatus(200);
    }
    public function test_a_user_can_only_see_nota_jual_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        NotaJual::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        NotaJual::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, NotaJual::count());
    }

    public function test_a_user_can_only_create_a_nota_jual_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdNotaJual = NotaJual::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdNotaJual->tenant_id == $user1->tenant_id);
    }
}
