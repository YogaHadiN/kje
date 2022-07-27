<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CekMutasi19TerakhirTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    public function test_mutasi_moota()
    {
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);

        \App\Models\Coa::factory()->create([
            'kode_coa' => 110004
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' => 400045
        ]);

        $this->artisan('cek:mutasi20terakhir');
    }
}
