<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\AntrianPeriksa;

class RuangPeriksaControllerTest extends TestCase
{
    
        use WithFaker;

        /**
         * @test
         */
        public function test_index_displays_view()
        {
            $user     = User::find(28);
            auth()->login($user);
            $response = $this->get('ruangperiksa/1');
            $response->assertStatus(200);
        }

        /**
         * @test
         */
}
