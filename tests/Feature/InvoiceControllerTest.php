<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Http\Testing\File;
use Storage;

class InvoiceControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);

        \App\Models\Asuransi::factory(20)->create();
        $response = $this->get('invoices');
        $response->assertStatus(200);
    }

    public function test_show(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $asuransi = \App\Models\Asuransi::factory()->create();
        $invoice = Invoice::factory()->create();
        $periksa = \App\Models\Periksa::factory()->create([
            'asuransi_id' => $asuransi,
            'invoice_id' => $invoice
        ]);
        $response = $this->get('invoices/' . $invoice->id);
        $response->assertStatus(200);
    }

    public function test_a_user_can_only_see_invoice_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        Invoice::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        Invoice::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Invoice::count());
    }

    /** @test */
    public function test_a_user_can_only_create_a_invoice_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdInvoice = Invoice::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdInvoice->tenant_id == $user1->tenant_id);
    }
}

/* public function getData() */
/* public function upload_verivication($id) */
/* public function pendingReceivedVerification() */
/* public function queryPendingReceivedVerification() */
