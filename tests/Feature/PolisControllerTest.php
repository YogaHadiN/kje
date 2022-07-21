<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\AntrianPeriksa;
use App\Models\User;
use App\Models\Poli;
use Illuminate\Http\Testing\File;
use Storage;

class PolisControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */

    public function test_poli(){
        /* dd( \DB::select("SELECT DATE('now','-30 days');") ); */
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);
        \App\Models\Asuransi::factory()->create([
            'tipe_asuransi_id' => 5
        ]);
        $antrian_periksa = AntrianPeriksa::factory()->create();
        $response = $this->get('poli/' . $antrian_periksa->id);
        $response->assertStatus(200);
    }
}
