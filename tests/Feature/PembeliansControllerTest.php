<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\Merek;
use App\Models\User;
use App\Models\JurnalUmum;
use App\Models\Classes\Yoga;
use App\Models\Pembelian;
use App\Models\Dispensing;
use App\Models\Rak;
use App\Models\FakturBelanja;
use Carbon\Carbon;
use Illuminate\Http\Testing\File;
use Storage;

class PembeliansControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        
        auth()->login($user);
        $response = $this->get('pembelians');
        $response->assertStatus(200);
    }

    public function test_show(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $pembelian = \App\Models\Pembelian::factory()->create();
        $response = $this->get('pembelians/show/'. $pembelian->id);
        $response->assertStatus(200);
    }
    public function test_create(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $pembelian     = \App\Models\Pembelian::factory()->create();
        $fakturBelanja = \App\Models\FakturBelanja::factory()->create();
        $pembelians    = \App\Models\Pembelian::factory(6)->create([
            'faktur_belanja_id' => $fakturBelanja->id
        ]);

        $response = $this->get('pembelians/'. $fakturBelanja->id);
        $response->assertStatus(200);
    }
    public function test_edit(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $pembelian     = \App\Models\Pembelian::factory()->create();
        $fakturBelanja = \App\Models\FakturBelanja::factory()->create();
        $pembelians    = \App\Models\Pembelian::factory(6)->create([
            'faktur_belanja_id' => $fakturBelanja->id
        ]);


        \App\Models\Coa::factory()->create([
            'kode_coa' =>110000 
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' =>110004
        ]);

        $response = $this->get('pembelians/' . $fakturBelanja->id. '/edit');
        $response->assertStatus(200);
    }

    /**
     * 
     */
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

        \App\Models\Coa::factory()->create([
            'kode_coa' => 110000
        ]);
       $coa_112000 = \App\Models\Coa::factory()->create([
            'kode_coa' => 112000
        ]);
        \App\Models\Coa::factory()->create([
            'kode_coa' => 50204
        ]);

        $nama         = $this->faker->name;
        $belanja_id   = 1;
        $supplier_id  = \App\Models\Supplier::factory()->create()->id;
        $sumber_uang = \App\Models\Coa::factory()->create([
                            'kode_coa' => 110004
                        ])->id;
        $nomor_faktur = $this->faker->numerify('#########');
        $tanggal      = $this->faker->date('d-m-Y');
        $staf_id      = \App\Models\Staf::factory()->create()->id;
        $diskon       = $this->faker->numerify('Rp. 0');
        $class_rak    = 2;
        $faktur_image = File::create('image.png', 100);
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

        /* "tempBeli" => "[{"merek":"Lanamol tablet 500 mg","merek_id":32,"harga_beli":"242","harga_jual":"800","harga_berubah":0,"exp_date":"26-08-2027","jumlah":"100"} */

        $merek = \App\Models\Merek::factory()->create();


        $tempBeli = [];

        $mereks = \App\Models\Merek::factory(20)->create();
        foreach ($mereks as $merek) {
            $tempBeli[] = [
                'merek'         => $merek->merek,
                'rak_id'      => $merek->rak_id,
                'merek_id'      => $merek->id,
                'harga_beli'    => $merek->rak->harga_beli,
                'harga_jual'    => $merek->rak->harga_beli,
                'harga_berubah' => 0,
                'exp_date'      => $this->faker->date('d-m-Y'),
                'jumlah'        => $this->faker->numerify('###')
            ];
        }

        $inputAll = [
            "belanja_id"   => $belanja_id,
            "supplier_id"  => $supplier_id,
            "sumber_uang"  => $sumber_uang,
            "nomor_faktur" => $nomor_faktur,
            "tanggal"      => $tanggal,
            "staf_id"      => $staf_id,
            "diskon"       => $diskon,
            "class_rak"    => $class_rak,
            "tempBeli"     => json_encode($tempBeli),
            "faktur_image" => $faktur_image,
        ];
        $response = $this->post('pembelians', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $faktur_belanjas = FakturBelanja::query()
                ->where("nomor_faktur", $nomor_faktur)
                ->where("belanja_id", $belanja_id)
                ->where("supplier_id", $supplier_id)
                ->where("sumber_uang_id", $sumber_uang)
                ->where("petugas_id", $staf_id)
                ->where("diskon", Yoga::clean($diskon))
        ->get();

        if ( !$faktur_belanjas->count() ) {
            $faktur_belanjas = FakturBelanja::all();
            $faktur_belanja_array = [];
            foreach ($faktur_belanjas as $a) {
                $faktur_belanja_array[] = [
                    "nomor_faktur"   => $a->nomor_faktur,
                    "belanja_id"     => $a->belanja_id,
                    "supplier_id"    => $a->supplier_id,
                    "sumber_uang_id" => $a->sumber_uang_id,
                    "staf_id"        => $a->petugas_id,
                    "diskon"         => $a->diskon,
                ];
            }
            dd(  [
                    "nomor_faktur" => $nomor_faktur,
                    "belanja_id"   => $belanja_id,
                    "supplier_id"  => $supplier_id,
                    "sumber_uang"  => $sumber_uang,
                    "staf_id"      => $staf_id,
                    "diskon"       => Yoga::clean($diskon),
                ],
                $faktur_belanja_array, 'ok'
            );
        }
        $this->assertCount(1, $faktur_belanjas);

        $total_pembelian    = 0;
        $merek_updated_ids = [];
        $rak_ids = [];
        foreach ($tempBeli as $tB) {
            $merek_updated_ids[] = $tB['merek_id'];
            $rak_ids[] = Merek::find($tB['merek_id'])->rak_id;
            $total_pembelian += $tB['harga_beli']* $tB['jumlah'];

            $raks = Rak::query()
                ->where("id", $tB["rak_id"])
                ->where("harga_beli", $tB["harga_beli"])
                ->where("harga_jual", $tB["harga_jual"])
                /* ->where("jumlah", $tB["jumlah"]) */
            ->get();

            if ( !$raks->count() ) {
                $raks = Rak::all();
                $rak_array = [];
                foreach ($raks as $a) {
                    $rak_array[] = [
                        "rak_id"   => $a->id,
                        "harga_beli" => $a->harga_beli,
                        "harga_jual" => $a->harga_jual,
                    ];
                }
                dd(  [
                        "rak_id"   => $tB['rak_id'],
                        "harga_beli" => $tB["harga_beli"],
                        "harga_jual" => $tB["harga_jual"],
                    ],
                    $rak_array, 'Gak Oke nih'
                );
            }
            $this->assertCount(1, $raks);


            $pembelians = Pembelian::query()
                    ->where('harga_beli',$tB['harga_beli'])
                    ->where('harga_jual',$tB['harga_jual'])
                    ->where('merek_id',$tB['merek_id'])
                    ->where('harga_naik',$tB['harga_berubah'])
                    ->where('jumlah',$tB['jumlah'])
            ->get();

            $this->assertCount(1, $pembelians);

            if ( !$pembelians->count() ) {
                $pembelians = Pembelian::all();
                $pembelian_array = [];
                foreach ($pembelians as $a) {
                    $pembelian_array[] = [
                        "harga_beli" => $a->harga_beli,
                        "harga_jual" => $a->harga_jual,
                        "merek_id"   => $a->merek_id,
                        "harga_naik" => $a->harga_naik,
                        "jumlah"     => $a->jumlah,
                    ];
                    $merek_ids[] = $a->merek_id;
                }
                dd(  [
                        "harga_beli" => $tB["harga_beli"],
                        "harga_jual" => $tB["harga_jual"],
                        "merek_id"   => $tB["merek_id"],
                        "harga_naik" => $tB["harga_naik"],
                        "jumlah"     => $tB["jumlah"],
                    ],
                    $pembelian_array, 'Gak Oke nih'
                );
            }

            $dispensings = Dispensing::query()
                    ->where('merek_id',$tB['merek_id'])
                    ->where('masuk',$tB['jumlah'])
            ->get();

            if ( !$dispensings->count() ) {
                $dispensings = Dispensing::all();
                $dispensing_array = [];
                foreach ($dispensings as $a) {
                    $dispensing_array[] = [
                        'merek_id' => $a->merek_id,
                        'masuk'    => $a->masuk,
                    ];
                }
                dd(  [
                        'merek_id' => $tB['merek_id'],
                        'masuk'    => $tB['jumlah'],
                    ],
                    $dispensing_array, 'Gak Oke nih'
                );
            }
            $this->assertCount(1, $dispensings);
        }
        $merek_updated = Merek::whereIn('id', $merek_updated_ids)->count();
        $merek_updated_is_default = Merek::whereIn('id', $merek_updated_ids)->where('default',1)->count();
        $this->assertEquals($merek_updated, $merek_updated_is_default);

        foreach (Rak::whereIn('id', $rak_ids)->get() as $rak) {
            $jumlah_default = 0;
            foreach ($rak->merek as $mrk) {
                if ($mrk->default) {
                    $jumlah_default++;
                }
            }
            $this->assertEquals(1, $jumlah_default);
        }

        $pembelian = $pembelians->first();


        $jurnal_umums = JurnalUmum::query()
            ->where("jurnalable_id", $faktur_belanjas->first()->id)
            ->where("debit", 1)
            ->where("nilai", $total_pembelian)
            ->where("coa_id", $coa_112000->id)
            ->where("jurnalable_type", 'App\Models\FakturBelanja')
        ->get();

        if ( !$jurnal_umums->count() ) {
            $jurnal_umums = JurnalUmum::all();
            $jurnal_umum_array = [];
            foreach ($jurnal_umums as $a) {
                $jurnal_umum_array[] = [
                    "jurnalable_id"   => $a->jurnalable_id,
                    "debit"           => $a->debit,
                    "nilai"           => $a->nilai,
                    "coa_id"          => $a->coa_id,
                    "jurnalable_type" => $a->jurnalable_type,
                ];
            }
            dd(  [
                    "jurnalable_id"   => $faktur_belanjas->first()->id,
                    "debit"           => 1,
                    "nilai"           => $total_pembelian,
                    "coa_id"          => $coa_112000->id,
                    "jurnalable_type" => 'App\Models\FakturBelanja',
                ],
                $jurnal_umum_array, 'Gak Oke nih'
            );
        }

        $this->assertCount(1, $jurnal_umums);

        $jurnal_umums = JurnalUmum::query()
            ->where("jurnalable_id", $faktur_belanjas->first()->id)
            ->where("debit", 0)
            ->where("nilai", $total_pembelian)
            ->where("coa_id", $sumber_uang)
            ->where("jurnalable_type", 'App\\Models\\FakturBelanja')
        ->get();

        if ( !$jurnal_umums->count() ) {
            $jurnal_umums = JurnalUmum::all();
            $jurnal_umum_array = [];
            foreach ($jurnal_umums as $a) {
                $jurnal_umum_array[] = [
                    "jurnalable_id"   => $a->jurnalable_id,
                    "debit"           => $a->debit,
                    "nilai"           => $a->nilai,
                    "coa_id"          => $a->coa_id,
                    "jurnalable_type" => $a->jurnalable_type,
                ];
            }
            dd(  [
                    "jurnalable_id"   => $faktur_belanjas->first()->id,
                    "debit"           => 0,
                    "nilai"           => $total_pembelian,
                    "coa_id"          => $sumber_uang,
                    "jurnalable_type" => 'App\\Models\\FakturBelanja',
                ],
                $jurnal_umum_array, 'Gak Oke nih'
            );
        }

        $this->assertCount(1, $jurnal_umums);


        $response->assertRedirect('fakturbelanjas/obat');
    }

    public function test_a_user_can_only_see_model_singular_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        Pembelian::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        Pembelian::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Pembelian::count());
    }

    /** @test */
    public function test_a_user_can_only_create_a_model_singular_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdPembelian = Pembelian::factory()->create([
            'tenant_id' => $tenant2,
        ]);

        $this->assertTrue($createdPembelian->tenant_id == $user1->tenant_id);
    }
}
/* Route::post('pembelians/ajax', [\App\Http\Controllers\PembeliansController::class, 'ajax']); */
/* Route::post('pembelians/{id}', [\App\Http\Controllers\PembeliansController::class, 'update']); */
/* Route::post('pembelians/cari/ajax', [\App\Http\Controllers\PembeliansController::class, 'cariObat']); */
