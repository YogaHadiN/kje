<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Pembelian;
use Illuminate\Http\Testing\File;
use Storage;

class PembeliansAjaxControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_formulabyid(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $formula = \App\Models\Formula::factory()->create();
        $response = $this->post('pembelians/ajax/formulabyid', [
            'formula_id' => $formula->id
        ]);
        $response->assertStatus(200);
    }
    public function test_rakbyid(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $rak = \App\Models\Rak::factory()->create();

        $response = $this->post('pembelians/ajax/rakbyid', [
            'rak_id' => $rak->id
        ]);
        $response->assertStatus(200);
    }
}
/* Route::post('pembelians/ajax/formulabyid', [\App\Http\Controllers\PembeliansAjaxController::class, 'formulabyid']); */
/* Route::post('pembelians/ajax/rakbyid', [\App\Http\Controllers\PembeliansAjaxController::class, 'rakbyid']); */

