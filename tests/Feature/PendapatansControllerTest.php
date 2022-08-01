<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\JurnalUmum;
use App\Models\Classes\Yoga;
use App\Models\Pendapatan;
use Illuminate\Http\Testing\File;
use Storage;
use Arr;

class PendapatansControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_create_view(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>110000
        ]);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>110001
        ]);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>110003
        ]);

        $response = $this->get('pendapatans/create');
        $response->assertStatus(200);
    }

    public function test_pembayaran_asuransi(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>110000
        ]);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>110001
        ]);

        \App\Models\Coa::factory()->create([
            'kode_coa' =>110003
        ]);

        $response = $this->get('pendapatans/pembayaran/asuransi');
        $response->assertstatus(200);
    }
    public function test_pembayaran_asuransi_rekening(){
        $user     = user::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        \app\models\coa::factory()->create([
            'kode_coa' =>110000
        ]);

        \app\models\coa::factory()->create([
            'kode_coa' =>110001
        ]);

        \app\models\coa::factory()->create([
            'kode_coa' =>110003
        ]);

        $asuransi = \App\Models\Asuransi::factory()->create();
        $response = $this->get('pendapatans/pembayaran/asuransi/' . $asuransi->id);
        $response->assertstatus(200);
    }

    public function test_pembayaran_bpjs(){
        $user     = user::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        \app\models\Coa::factory()->create([
            'kode_coa' =>110000
        ]);

        \app\models\Coa::factory()->create([
            'kode_coa' =>110001
        ]);

        \app\models\Coa::factory()->create([
            'kode_coa' =>110003
        ]);

        $asuransi = \App\Models\Asuransi::factory()->create([
            'tipe_asuransi_id' => 5
        ]);
        $response = $this->get('pendapatans/pembayaran_bpjs');
        $response->assertstatus(200);
    }

    public function test_detailPA(){
        $user     = user::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        \app\models\Coa::factory()->create([
            'kode_coa' =>110000
        ]);

        \app\models\Coa::factory()->create([
            'kode_coa' =>110001
        ]);

        \app\models\Coa::factory()->create([
            'kode_coa' =>110003
        ]);

        $nota_jual = \App\Models\NotaJual::factory()->create();

        $pembayaran_asuransis = \App\Models\PembayaranAsuransi::factory(10)->create([
            'nota_jual_id' => $nota_jual->id
        ]);

        $invoices = \App\Models\Invoice::factory(20)->create();
        $id       = [];
        foreach ($invoices as $inv) {
            $id[] = $inv->id;
            \App\Models\Periksa::factory(10)->create([
                'invoice_id' => $inv->id
            ]);
        }
        $id = json_encode($id);
        $asuransi = \App\Models\Asuransi::factory()->create();
        $response = $this->get('pendapatans/pembayaran_show/detail/piutang_asuransis?' . Arr::query([
            'id' => $id
        ]));
        $response->assertstatus(200);
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

        $sumber_uang   = $this->faker->text;
        $coa_id        = \App\Models\Coa::factory()->create()->id;
        $staf_id       = \App\Models\Staf::factory()->create()->id;
        $tanggal       = $this->faker->date('d-m-Y');
        $nilai         = $this->faker->numerify('Rp. #.###.###');
        $keterangan    = $this->faker->text;
        $konfirmasikan = 1;

        /* sebelum kesini ke acting as dulu */
        /* key mapping l */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = File::create('nama.png', 100) */

        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
            "sumber_uang"   => $sumber_uang,
            "coa_id"        => $coa_id,
            "staf_id"       => $staf_id,
            "tanggal"       => $tanggal,
            "nilai"         => $nilai,
            "keterangan"    => $keterangan,
            "konfirmasikan" => $konfirmasikan,
        ];

        $response = $this->post('pendapatans/index', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $pendapatans = Pendapatan::query()
            ->where("sumber_uang", $sumber_uang)
            ->where("nilai", Yoga::clean($nilai))
            ->where("keterangan", $keterangan)
            ->where("staf_id", $staf_id)
        ->get();

        if ( !$pendapatans->count() ) {
            $pendapatans = Pendapatan::all();
            $pendapatan_array = [];
            foreach ($pendapatans as $a) {
                $pendapatan_array[] = [
                    "sumber_uang" => $a->sumber_uang,
                    "nilai"       => $a->nilai,
                    "keterangan"  => $a->keterangan,
                    "staf_id"     => $a->staf_id
                ];
            }
            dd(  [
                    "sumber_uang" => $sumber_uang,
                    "nilai"       => Yoga::clean($nilai),
                    "keterangan"  => $keterangan,
                    "staf_id"     => $staf_id,
                ],
                $pendapatan_array
            );
        }

        $this->assertCount(1, $pendapatans);

        $pendapatan = $pendapatans->first();

        $jurnal_umums = JurnalUmum::query()
			->where("jurnalable_id", $pendapatan->id)
			->where("jurnalable_type", 'App\Models\Pendapatan')
			->where("coa_id", $coa_id)
			->where("debit", 1)
			->where("nilai", Yoga::clean($nilai))
        ->get();

        if ( !$jurnal_umums->count() ) {
            $jurnal_umums = JurnalUmum::all();
            $jurnal_umum_array = [];
            foreach ($jurnal_umums as $a) {
                $jurnal_umum_array[] = [
                    "jurnalable_id"   => $a->jurnalable_id,
                    "jurnalable_type" => $a->jurnalable_type,
                    "coa_id"          => $a->coa_id,
                    "debit"           => $a->debit,
                    "nilai"           => $a->nilai,
                ];
            }
            dd(  [
                    "jurnalable_id"   => $pendapatan->id,
                    "jurnalable_type" => 'App\Models\Pendapatan',
                    "coa_id"          => $coa_id,
                    "debit"           => 1,
                    "nilai"           => Yoga::clean($nilai),
                ],
                $jurnal_umum_array
            );
        }

        $this->assertCount(1, $jurnal_umums);


        $jurnal_umums = JurnalUmum::query()
			->where("jurnalable_id", $pendapatan->id)
			->where("jurnalable_type", 'App\Models\Pendapatan')
			->where("debit", 0)
			->whereNull("coa_id")
			->where("nilai", Yoga::clean($nilai))
        ->get();

        if ( !$jurnal_umums->count() ) {
            $jurnal_umums = JurnalUmum::all();
            $jurnal_umum_array = [];
            foreach ($jurnal_umums as $a) {
                $jurnal_umum_array[] = [
                    "jurnalable_id"   => $a->jurnalable_id,
                    "jurnalable_type" => $a->jurnalable_type,
                    "coa_id"          => $a->coa_id,
                    "debit"           => $a->debit,
                    "nilai"           => $a->nilai,
                ];
            }
            dd(  [
                    "jurnalable_id"   => $pendapatan->id,
                    "jurnalable_type" => 'App\Models\Pendapatan',
                    "coa_id"          => null,
                    "debit"           => 0,
                    "nilai"           => Yoga::clean($nilai),
                ],
                $jurnal_umum_array
            );
        }

        $this->assertCount(1, $jurnal_umums);
        $response->assertRedirect('pendapatans/create');
    }
    public function test_delete_pembayaran_asuransi(){
        $user     = User::factory()->create([
                        'role_id' => 6
                    ]);
        auth()->login($user);
        $pembayaran_asuransi = \App\Models\PembayaranAsuransi::factory()->create();

        $pembayaran_asuransi_id = $pembayaran_asuransi->id;
        $inputAll = compact('pembayaran_asuransi_id');
        $response = $this->post("pendapatans/pembayaran/asuransi/delete", $inputAll);
        $this->assertDeleted($pembayaran_asuransi);
    }

    public function test_a_user_can_only_see_pendapatan_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        Pendapatan::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        Pendapatan::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Pendapatan::count());
    }

    /** @test */
    public function test_a_user_can_only_create_a_pendapatan_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdPendapatan = Pendapatan::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdPendapatan->tenant_id == $user1->tenant_id);
    }
}

/* Route::post('pengeluarans/pembayaran_asuransi/show/{id}', [\App\Http\Controllers\PendapatansController::class, 'lihat_pembayaran_asuransi_by_rekening']); */
/* Route::post('pengeluarans/pembayaran_asuransi/show ', [\App\Http\Controllers\PendapatansController::class, 'lihat_pembayaran_asuransi']); */
/* Route::post('pendapatans/pembayaran_bpjs', [\App\Http\Controllers\PendapatansController::class, 'pembayaran_bpjs_post']); */
/* Route::get('pendapatans/pembayaran_asuransi/cari_pembayaran', [\App\Http\Controllers\PendapatansController::class, 'cariPembayaran']); */
/* Route::get('pendapatans/pembayaran/asuransi/show/{id}', [\App\Http\Controllers\PendapatansController::class, 'pembayaran_asuransi_show']); */
/* Route::get('pendapatans/pembayaran_show/detail/piutang_asuransis', [\App\Http\Controllers\PendapatansController::class, 'detailPA']); */
/* Route::post('pendapatans/pembayaran/asuransi', [\App\Http\Controllers\PendapatansController::class, 'asuransi_bayar']); */
