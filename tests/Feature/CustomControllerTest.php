<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Http\Controllers\CustomController;
use App\Models\Classes\Yoga;
use App\Models\Tarif;
use App\Models\JurnalUmum;
use App\Models\User;
use App\Models\Dispensing;
use App\Models\TransaksiPeriksa;
use App\Models\Periksa;
use Illuminate\Http\Testing\File;
use Storage;

class CustomControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @group failing
     */
    public function test_survey(){
        $user     = User::factory()->create([
            'role_id' => 6
        ]);
        auth()->login($user);
        $periksa = \App\Models\Periksa::factory()->create();
        $jenis_tarifs = \App\Models\JenisTarif::factory(3)->create();
        $transaksis = [];
        foreach ($jenis_tarifs as $jt) {
            $transaksis[] = [
                'jenis_tarif_id' => $jt->id,
                'jenis_tarif'    => $jt->jenis_tarif,
                'biaya'          => $this->faker->numerify('###')
            ];
        }

        $periksa->transaksi = json_encode($transaksis);
        $periksa->save();

        $antrian_kasir = \App\Models\AntrianKasir::factory()->create([
            'periksa_id' => $periksa
        ]);
        $response = $this->get('update/surveys/' . $periksa->id);
        $response->assertStatus(200);
    }
    /**
     * @group failing
     */
    public function test_survey_post(){
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

        $jenis_tarifs = \App\Models\JenisTarif::factory(3)->create();
        $periksa = \App\Models\Periksa::factory()->create();

        /* dd( Tarif::count() ); */
        $sebelum = [];
        foreach ($jenis_tarifs as $jt) {
            $sebelum[] = [
                'jenis_tarif_id' => $jt->id,
                'jenis_tarif'    => $jt->jenis_tarif,
                'biaya'          => $this->faker->numerify('###')
            ];
            \App\Models\Tarif::factory()->create([
                'asuransi_id' => $periksa->asuransi_id,
                'jenis_tarif_id' => $jt->id
            ]);
        }

        $sebelum = json_encode($sebelum);
        $nama_file        = "";
        $slcTindakan      = "";
        $dibayar_asuransi = $this->faker->numerify('Rp. ##.###');
        $dibayar_pasien   = $this->faker->numerify('Rp. ##.###');
        $pembayaran       = $this->faker->numerify('Rp. ##.###');
        $kembalian        = $this->faker->numerify('Rp. ##.###');
        $tarif = $sebelum;


        $periksa->transaksi = json_encode($sebelum);
        $periksa->periksa_awal = json_encode([
            'tekanan_darah'	=> '120/80 mmHg',
            'berat_badan'	=>	'2400',
            'suhu'	=>	'38',
            'tinggi_badan'	=>'178'
        ]);
        $periksa->save();
        $periksa_id = $periksa->id;
        \App\Models\AntrianKasir::factory()->create([
            'periksa_id' => $periksa_id
        ]);
        
        \App\Models\Poli::factory()->create([
            'poli' => 'Poli Estetika'
        ]);

        \App\Models\Coa::factory()->create([ 'kode_coa' => 110000 ]);
        \App\Models\Coa::factory()->create([ 'kode_coa' => 50201 ]);
        \App\Models\Coa::factory()->create([ 'kode_coa' => 50202 ]);
        \App\Models\Coa::factory()->create([ 'kode_coa' => 50204 ]);
        \App\Models\Coa::factory()->create([ 'kode_coa' => 50205 ]);
        \App\Models\Coa::factory()->create([ 'kode_coa' => 200002 ]);
        \App\Models\Coa::factory()->create([ 'kode_coa' => 200001 ]);
        \App\Models\Coa::factory()->create([ 'kode_coa' => 112000 ]);

        \App\Models\Terapi::factory(5)->create([
            'periksa_id' => $periksa_id
        ]);

    

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
            "nama_file"        => $nama_file,
            "slcTindakan"      => $slcTindakan,
            "dibayar_asuransi" => $dibayar_asuransi,
            "dibayar_pasien"   => $dibayar_pasien,
            "pembayaran"       => $pembayaran,
            "kembalian"        => $kembalian,
            "sebelum"          => $sebelum,
            "tarif"            => $tarif,
            "periksa_id"       => $periksa_id,
        ];

        $response = $this->post('update/surveys', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        foreach (json_decode($sebelum, true) as $jt) {
            $transaksi_periksa = TransaksiPeriksa::query()
                ->where("periksa_id", $periksa_id)
                ->where("jenis_tarif_id", $jt['jenis_tarif_id'])
                ->where("biaya", $jt['biaya'])
            ->get();
            $this->assertCount(1, $transaksi_periksa);
        }

        $periksas = Periksa::query()
                        ->where("tunai", Yoga::clean($dibayar_pasien))
                        ->where("piutang", Yoga::clean($dibayar_asuransi))
                        ->where("pembayaran", Yoga::clean($pembayaran))
                        ->where("kembalian", Yoga::clean($kembalian))
                    ->get();
        $this->assertCount(1, $periksas);

        foreach ($periksa->terapii as $t) {
            $dispensings = Dispensing::query()
                ->where('dispensable_id', $t->id )
                ->where('dispensable_type',  "App\\Models\\Terapi" )
                ->where('merek_id', $t->merek_id)
                ->where('keluar', $t->jumlah)
                ->where('tanggal', $periksa->tanggal)
            ->get();
            $this->assertCount(1, $dispensings);
        }

        if ($periksa->tunai>0) {
            $this->test_jurnal( 'Kas di tangan', 110000, 1);
        }

        if ($periksa->piutang>0) {
            $jurnal_umums = JurnalUmum::query()
                ->where('jurnalable_type', "App\\Models\\Periksa"  )
                ->where('jurnalable_id',  $periksa->id)
                ->where('coa_id', $periksa->asuransi->coa_id)
                ->where('nilai', $periksa->piutang)
                ->where('debit', 1)
            ->get();
            $this->assertCount(1, $jurnal_umums);
        }

        $coa_diskon = \App\Models\Coa::factory()->create([
            'coa'=> 'Diskon'
        ]);

        $hutang_asisten_tindakan = 0;
        $jasa_dokter             = 0;
        $cc                      = new CustomController;
        foreach (json_decode($periksa->transaksi, true) as $tr) {
            if ($tr->coa_id != $coa_diskon->id) {
                $jenis_tarif = JenisTarif::find($tr->jenis_tarif_id);
                $jurnal_umums = JurnalUmum::query()
                    ->where('jurnalable_type', "App\\Models\\Periksa"  )
                    ->where('jurnalable_id',  $periksa->id)
                    ->where('coa_id',  $jenis_tarif->coa_id )
                    ->where('nilai', $tr['biaya'])
                    ->where('debit', 0)
                ->get();
                $this->assertCount(1, $jurnal_umums);
            }
            if ($jenis_tarif->dengan_asisten) {
                $hutang_asisten_tindakan += $cc->biayaJasa($transaksi['jenis_tarif_id'], $transaksi['biaya']);
            }
            if ( !($tr['jenis_tarif_id'] ==  $jt_gula_darah->id || $transaksi['biaya'] == 0) ) {
                $feeDokter += \App\Models\Tarif::factory()->create([
                    'asuransi_id' => $periksa->id,
                    'jenis_tarif_id' => $tr['jenis_tarif_id']
                ])->jasa_dokter;
            }
        }

        if ($hutang_asisten_tindakan > 0) {
            $this->test_jurnal( 'Biaya Bonus Jasa Tindakan Asisten Dokter', 50205, 1)
            $this->test_jurnal( 'Hutang Kepada Asisten Dokter', 200002, 0)
        }
        if ($feeDokter > 0 && $periksa->staf->gaji_tetap == 0 ) {
            $this->test_jurnal( 'Beban Jasa Dokter', 50201, 1)
            $this->test_jurnal( 'Hutang Kepada dokter', 200001, 1)
        }

        $biayaProduksiObat = 0;
        foreach ($periksa->terapii as $terapi) {
            $biayaProduksiObat += $terapi->harga_beli_satuan * $terapi->jumlah;
        }
        if ($biayaProduksiObat > 0) {
            $this->test_jurnal( 'Biaya Produksi : Obat', 50204, 1)
            $this->test_jurnal( 'Persediaan Obat', 112000, 0)
        }

        $this->test_jurnal( 'Biaya Produksi : Bonus per pasien', 50202, 1)
        $this->test_jurnal( 'Hutang Kepada Asisten Dokter', 200002, 0)
            
        $response->assertRedirect('antriankasirs');
    }

    private function test_jurnal($coa, $kode_coa, $debit)
    {
        $coa_id = \App\Models\Coa::factory()->create([
            'coa'      => $coa,
            'kode_coa' => $kode_coa
        ])->id;
        $jurnal_umums = JurnalUmum::query()
            ->where('jurnalable_type', "App\\Models\\Periksa"  )
            ->where('jurnalable_id',  $periksa->id)
            ->where('coa_id', $coa_id)
            ->where('nilai', $periksa->tunai)
            ->where('debit', $debit)
        ->get();
        $this->assertCount(1, $jurnal_umums);
    }
}
