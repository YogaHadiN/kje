<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Kasir;
use Illuminate\Http\Testing\File;
use Storage;

class KasirBaseControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);
        $periksa = \App\Models\Periksa::factory()->create();
        \App\Models\AntrianApotek::factory()->create([
            'periksa_id' => $periksa
        ]);
        $response = $this->get('kasir/' .  $periksa->id);
        $response->assertStatus(200);
    }

    public function test_kasir_submit(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);

        $periksa = \App\Models\Periksa::factory()->create();

        \App\Models\AntrianApotek::factory()->create([
            'periksa_id' => $periksa
        ]);
        $transaksi_periksas = \App\Models\TransaksiPeriksa::factory(4)->create([
            'periksa_id' => $periksa
        ]);

        \App\Models\JenisTarif::factory()->create([
            'jenis_tarif' => 'Biaya Obat'
        ]);

        $prx_transaksi = [];
        foreach ($transaksi_periksas as $trp) {
            $prx_transaksi[] = [
                'jenis_tarif'    => $trp->jenisTarif->jenis_tarif,
                'biaya'          => $trp->biaya,
                'jenis_tarif_id' => $trp->jenis_tarif_id
            ];
        }

        $periksa->transaksi = json_encode( $prx_transaksi );
        $periksa->save();

        $terapis = \App\Models\Terapi::factory(5)->create([
            'periksa_id' => $periksa
        ]);

        $terapi1 = [];
        foreach ($terapis as $t) {
            $terapi1[] = [
                'id'                => $t->id,
                'merek_id'          => $t->merek_id,
                'jumlah'            => $t->jumlah,
                'harga_beli_satuan' => $t->harga_beli_satuan,
                'harga_jual_satuan' => $t->harga_jual_satuan
            ];
        }
        
        $terapi1 = json_encode($terapi1);
        $response = $this->post('kasir/submit', [
            'periksa_id' => $periksa->id,
            'terapi1'    => $terapi1,
            'terapi2'    => ''
        ]);
        $response->assertRedirect('antrianapoteks');
    }
}

	/**
	* @param $dependencies
	*/

	/* public function kasir_submit() */
	/* public function changeMerek() */
	/* public function updatejumlah() */


	/* Route::post('kasir/submit', [\App\Http\Controllers\KasirBaseController::class, 'kasir_submit']); */
	/* Route::get('kasir/{id}', [\App\Http\Controllers\KasirBaseController::class, 'kasir']); */
	/* Route::post('kasir/onchange', [\App\Http\Controllers\KasirBaseController::class, 'onchange']); */
	/* Route::post('kasir/changemerek', [\App\Http\Controllers\KasirBaseController::class, 'changemerek']); */
	/* Route::post('kasir/updatejumlah', [\App\Http\Controllers\KasirBaseController::class, 'updatejumlah']); */
