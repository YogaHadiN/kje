<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\AntrianPeriksa;
use App\Models\JenisAntrian;

class RuangPeriksaControllerTest extends TestCase
{
    
        use WithFaker, RefreshDatabase;

        public function test_index_displays_view()
        {
            $user     = User::factory()->create(['role_id' => 6]);
            auth()->login($user);
            $jenis_antrian = JenisAntrian::factory()->create();
            $response = $this->get('ruangperiksa/' . $jenis_antrian->id);
            $this->withoutExceptionHandling();
            $response->assertStatus(200);
        }

        /**
         * @test
         */
}
