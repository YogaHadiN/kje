<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use App\Models\Tenant;
use App\Http\Controllers\RaksController;
use App\Models\User;
use App\Models\Formula;
use App\Models\Rak;
use App\Models\Merek;

class FormulaControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */

    public function test_create_view(){
        $user     = User::find(28);
        auth()->login($user);
        $response = $this->get('formulas/create');
        $response->assertStatus(200);
    }
        /**
         * @group failing
         */
    public function test_store(){
        // make a request with file


        $user     = User::find(28);
        auth()->login($user);

        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

        $merek                = $this->faker->name;
        $indikasi             = $this->faker->text;
        $kontraindikasi       = $this->faker->text;
        $efek_samping         = $this->faker->text;
        $harga_jual           = $this->faker->numerify('###');
        $harga_beli           = $this->faker->numerify('###');
        $kelas_obat_id = rand(1,3);
        $dijual_bebas         = rand(0,1);
        $boleh_dipuyer         = rand(0,1);
        $kode_rak               = $this->faker->numerify('###');
        $exp_date             = $this->faker->date('d-m-Y');
        $fornas               = rand(0,1);
        $sediaan              = rand(1, 12);
        $aturan_minum_id      = rand(1, 12);
        $alternatif_fornas    = null;
        $stok = $this->faker->numerify('##');
        $stok_minimal = $this->faker->numerify('##');
        $peringatan           = $this->faker->text;
        $ddlGenerik           = "";
        $signa_kg6_7          = "";
        $jumlah_kg6_7         = "";
        $jumlah_puyer_kg6_7   = "3";
        $jumlah_kg6_7_bpjs    = "";
        $signa_kg7_9          = "";
        $jumlah_kg7_9         = "";
        $jumlah_puyer_kg7_9   = "3";
        $jumlah_kg7_9_bpjs    = "";
        $signa_kg9_13         = "";
        $jumlah_kg9_13        = "";
        $jumlah_puyer_kg9_13  = "4";
        $jumlah_kg9_13_bpjs   = "";
        $signa_kg13_15        = "";
        $jumlah_kg13_15       = "";
        $jumlah_puyer_kg13_15 = "5";
        $jumlah_kg13_15_bpjs  = "";
        $signa_kg15_19        = "4";
        $jumlah_kg15_19       = "6";
        $jumlah_puyer_kg15_19 = "6";
        $jumlah_kg15_19_bpjs  = "4";
        $signa_kg19_23        = "4";
        $jumlah_kg19_23       = "6";
        $jumlah_puyer_kg19_23 = "7";
        $jumlah_kg19_23_bpjs  = "4";
        $signa_kg23_26        = "4";
        $jumlah_kg23_26       = "6";
        $jumlah_puyer_kg23_26 = "8";
        $jumlah_kg23_26_bpjs  = "4";
        $signa_kg26_30        = "12413";
        $jumlah_kg26_30       = "6";
        $jumlah_puyer_kg26_30 = "9";
        $jumlah_kg26_30_bpjs  = "4";
        $signa_kg30_37        = "12413";
        $jumlah_kg30_37       = "6";
        $jumlah_puyer_kg30_37 = "10";
        $jumlah_kg30_37_bpjs  = "4";
        $signa_kg37_45        = "1";
        $jumlah_kg37_45       = "10";
        $jumlah_puyer_kg37_45 = "11";
        $jumlah_kg37_45_bpjs  = "6";
        $signa_kg45_50        = "1";
        $jumlah_kg45_50       = "10";
        $jumlah_puyer_kg45_50 = "12";
        $jumlah_kg45_50_bpjs  = "6";
        $signa_kg50           = "1";
        $jumlah_kg50          = "10";
        $jumlah_puyer_kg50    = "12";
        $jumlah_kg50_bpjs     = "6";
        $json                 = '[{"generik_id":"811","bobot":"400 mg","generik":"Paracetamol"},{"generik_id":"12","bobot":"100 mg","generik":"Acrivastine"}]';

        /* sebelum kesini ke acting as dulu */
        /* key mapping l */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = File::create('nama.png', 100) */


        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
              "merek"                => $merek,
              "indikasi"             => $indikasi,
              "kontraindikasi"       => $kontraindikasi,
              "efek_samping"         => $efek_samping,
              "boleh_dipuyer"           => $boleh_dipuyer,
              "harga_jual"           => $harga_jual,
              "harga_beli"           => $harga_beli,
              "dijual_bebas"         => $dijual_bebas,
              "kode_rak"               => $kode_rak,
              "exp_date"             => $exp_date,
              "fornas"               => $fornas,
              "sediaan"              => $sediaan,
              "stok"              => $stok,
              "stok_minimal"              => $stok_minimal,
              "kelas_obat_id"              => $kelas_obat_id,
              "aturan_minum_id"      => $aturan_minum_id,
              "alternatif_fornas"    => $alternatif_fornas,
              "peringatan"           => $peringatan,
              "ddlGenerik"           => $ddlGenerik,
              "json"                 => $json,
              "signa_kg6_7"          => $signa_kg6_7,
              "jumlah_kg6_7"         => $jumlah_kg6_7,
              "jumlah_puyer_kg6_7"   => $jumlah_puyer_kg6_7,
              "jumlah_kg6_7_bpjs"    => $jumlah_kg6_7_bpjs,
              "signa_kg7_9"          => $signa_kg7_9,
              "jumlah_kg7_9"         => $jumlah_kg7_9,
              "jumlah_puyer_kg7_9"   => $jumlah_puyer_kg7_9,
              "jumlah_kg7_9_bpjs"    => $jumlah_kg7_9_bpjs,
              "signa_kg9_13"         => $signa_kg9_13,
              "jumlah_kg9_13"        => $jumlah_kg9_13,
              "jumlah_puyer_kg9_13"  => $jumlah_puyer_kg9_13,
              "jumlah_kg9_13_bpjs"   => $jumlah_kg9_13_bpjs,
              "signa_kg13_15"        => $signa_kg13_15,
              "jumlah_kg13_15"       => $jumlah_kg13_15,
              "jumlah_puyer_kg13_15" => $jumlah_puyer_kg13_15,
              "jumlah_kg13_15_bpjs"  => $jumlah_kg13_15_bpjs,
              "signa_kg15_19"        => $signa_kg15_19,
              "jumlah_kg15_19"       => $jumlah_kg15_19,
              "jumlah_puyer_kg15_19" => $jumlah_puyer_kg15_19,
              "jumlah_kg15_19_bpjs"  => $jumlah_kg15_19_bpjs,
              "signa_kg19_23"        => $signa_kg19_23,
              "jumlah_kg19_23"       => $jumlah_kg19_23,
              "jumlah_puyer_kg19_23" => $jumlah_puyer_kg19_23,
              "jumlah_kg19_23_bpjs"  => $jumlah_kg19_23_bpjs,
              "signa_kg23_26"        => $signa_kg23_26,
              "jumlah_kg23_26"       => $jumlah_kg23_26,
              "jumlah_puyer_kg23_26" => $jumlah_puyer_kg23_26,
              "jumlah_kg23_26_bpjs"  => $jumlah_kg23_26_bpjs,
              "signa_kg26_30"        => $signa_kg26_30,
              "jumlah_kg26_30"       => $jumlah_kg26_30,
              "jumlah_puyer_kg26_30" => $jumlah_puyer_kg26_30,
              "jumlah_kg26_30_bpjs"  => $jumlah_kg26_30_bpjs,
              "signa_kg30_37"        => $signa_kg30_37,
              "jumlah_kg30_37"       => $jumlah_kg30_37,
              "jumlah_puyer_kg30_37" => $jumlah_puyer_kg30_37,
              "jumlah_kg30_37_bpjs"  => $jumlah_kg30_37_bpjs,
              "signa_kg37_45"        => $signa_kg37_45,
              "jumlah_kg37_45"       => $jumlah_kg37_45,
              "jumlah_puyer_kg37_45" => $jumlah_puyer_kg37_45,
              "jumlah_kg37_45_bpjs"  => $jumlah_kg37_45_bpjs,
              "signa_kg45_50"        => $signa_kg45_50,
              "jumlah_kg45_50"       => $jumlah_kg45_50,
              "jumlah_puyer_kg45_50" => $jumlah_puyer_kg45_50,
              "jumlah_kg45_50_bpjs"  => $jumlah_kg45_50_bpjs,
              "signa_kg50"           => $signa_kg50,
              "jumlah_kg50"          => $jumlah_kg50,
              "jumlah_puyer_kg50"    => $jumlah_puyer_kg50,
              "jumlah_kg50_bpjs"     => $jumlah_kg50_bpjs,
        ];

        $response = $this->post('formulas', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */


        $formulas = Formula::query()
              ->where("indikasi", $indikasi)
              ->where("kontraindikasi", $kontraindikasi)
              ->where("efek_samping", $efek_samping)
              ->where("boleh_dipuyer", $boleh_dipuyer)
              ->where("dijual_bebas", $dijual_bebas)
              ->where("sediaan", $sediaan)
              ->where("aturan_minum_id", $aturan_minum_id)
              ->where("peringatan", $peringatan)
        ->get();
        $this->assertCount(1, $formulas);

        $formula = $formulas->first();

        /* dd([ */
        /*   "kelas_obat_id" => $kelas_obat_id, */
        /*   "exp_date"      => Carbon::createFromFormat('d-m-Y', $exp_date)->format('Y-m-d'), */
        /*   "kode_rak"      => $kode_rak, */
        /*   "fornas"        => $fornas, */
        /*   "harga_beli"    => $harga_beli, */
        /*   "harga_jual"    => $harga_jual, */
        /*   "stok"          => $stok, */
        /*   "stok_minimal"  => $stok_minimal, */
        /* ]); */
        $raks = Rak::where("formula_id", $formula->id)
          ->where("kelas_obat_id", $kelas_obat_id)
          ->where("exp_date", Carbon::createFromFormat('d-m-Y', $exp_date)->format('Y-m-d'))
          ->where("kode_rak", $kode_rak)
          ->where("fornas", $fornas)
          ->where("harga_beli", $harga_beli)
          ->where("harga_jual", $harga_jual)
          ->where("stok", $stok)
          ->where("stok_minimal", $stok_minimal)
        ->get();


        $this->assertCount(1, $raks);
        $rak = $raks->first();

        $rc          = new RaksController;
        $merekCustom = $rc->customMerek($formula, $merek);

        $mereks = Merek::query()
          ->where("merek", $merekCustom )
          ->where("rak_id", $rak->id)
        ->get();
        $this->assertCount(1, $mereks);

        $response->assertRedirect('mereks');
    }

    

    public function test_show(){
        $user     = User::find(28);
        auth()->login($user);
        $formula = Formula::factory()->create();
        $response = $this->get('formulas/' . $formula->id);
        $response->assertStatus(200);
    }

    /**
     * @group failing
     */
    public function test_edit(){
        $user     = User::find(28);
        auth()->login($user);
        $formula = Formula::first();
        $response = $this->get('formulas/' . $formula->id . '/edit');
        $response->assertStatus(200);
    }
    public function test_destroy(){
        $user     = User::find(28);
        auth()->login($user);
        $formula = Formula::factory()->create();
        $response = $this->delete('formulas/' . $formula->id);
        $response->assertRedirect('mereks');
        $this->assertDeleted($formula);
    }

    public function test_a_user_can_only_see_formula_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        Formula::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        Formula::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Formula::count());
    }

    /** @test */
    public function test_a_user_can_only_create_a_formula_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdFormula = Formula::factory()->create();

        $this->assertTrue($createdFormula->tenant_id == $user1->tenant_id);
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function createFormula()
    {


    }
    
}
