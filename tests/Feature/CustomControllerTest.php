<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Http\Controllers\CustomController;
use App\Models\Classes\Yoga;
use App\Models\Tarif;
use App\Models\JenisTarif;
use App\Models\TransaksiPeriksa;
use App\Models\JurnalUmum;
use App\Models\User;
use App\Models\Dispensing;
use App\Models\Periksa;
use Illuminate\Http\Testing\File;
use Storage;

class CustomControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public $periksa;
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
        $this->periksa = \App\Models\Periksa::factory()->create();

        /* dd( Tarif::count() ); */
        $sebelum = [];
        foreach ($jenis_tarifs as $jt) {
            $sebelum[] = [
                'jenis_tarif_id' => $jt->id,
                'jenis_tarif'    => $jt->jenis_tarif,
                'biaya'          => $this->faker->numerify('###')
            ];
            \App\Models\Tarif::factory()->create([
                'asuransi_id' => $this->periksa->asuransi_id,
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


        $this->periksa->transaksi = json_encode($sebelum);
        $this->periksa->periksa_awal = json_encode([
            'tekanan_darah'	=> '120/80 mmHg',
            'berat_badan'	=>	'2400',
            'suhu'	=>	'38',
            'tinggi_badan'	=>'178'
        ]);
        $this->periksa->save();
        $periksa_id = $this->periksa->id;
        \App\Models\AntrianKasir::factory()->create([
            'periksa_id' => $periksa_id
        ]);
        
        \App\Models\Poli::factory()->create([
            'poli' => 'Poli Estetika'
        ]);

        $coa_110000 = \App\Models\Coa::factory()->create([ 'kode_coa' => 110000 ]);
        $coa_50201 = \App\Models\Coa::factory()->create([ 'kode_coa' => 50201 ]);
        $coa_50202 = \App\Models\Coa::factory()->create([ 'kode_coa' => 50202 ]);
        $coa_50204 = \App\Models\Coa::factory()->create([ 'kode_coa' => 50204 ]);
        $coa_50205 = \App\Models\Coa::factory()->create([ 'kode_coa' => 50205 ]);
        $coa_200002 = \App\Models\Coa::factory()->create([ 'kode_coa' => 200002 ]);
        $coa_200001 = \App\Models\Coa::factory()->create([ 'kode_coa' => 200001 ]);
        $coa_112000 = \App\Models\Coa::factory()->create([ 'kode_coa' => 112000 ]);

        \App\Models\Terapi::factory(5)->create([
            'periksa_id' => $periksa_id
        ]);

        $jt_gula_darah = \App\Models\JenisTarif::factory()->create([
            'jenis_tarif' => 'Gula Darah'
        ]);

        $jt_diskon = \App\Models\JenisTarif::factory()->create([
            'jenis_tarif' => 'Diskon'
        ]);
    
        $this->withoutExceptionHandling();

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

        $this->periksa = $periksas->first();

        foreach ($this->periksa->terapii as $t) {
            $dispensings = Dispensing::query()
                ->where('dispensable_id', $t->id )
                ->where('dispensable_type',  "App\\Models\\Terapi" )
                ->where('merek_id', $t->merek_id)
                ->where('keluar', $t->jumlah)
                ->where('tanggal', $this->periksa->tanggal)
            ->get();
            $this->assertCount(1, $dispensings);
        }

        if ($this->periksa->tunai>0) {
            $this->test_jurnal( 'Kas di tangan', $coa_110000, 1, $this->periksa->tunai);
        }

        if ($this->periksa->piutang>0) {
            $jurnal_umums = JurnalUmum::query()
                ->where('jurnalable_type', "App\\Models\\Periksa"  )
                ->where('jurnalable_id',  $this->periksa->id)
                ->where('coa_id', $this->periksa->asuransi->coa_id)
                ->where('nilai', $this->periksa->piutang)
                ->where('debit', 1)
            ->get();
            $this->assertCount(1, $jurnal_umums);
        }

        $jt_diskon = \App\Models\JenisTarif::factory()->create([
            'jenis_tarif'=> 'Diskon'
        ]);

        $hutang_asisten_tindakan = 0;
        $feeDokter               = 0;
        $cc                      = new CustomController;
        foreach (json_decode($this->periksa->transaksi, true) as $tr) {
            if ($tr['jenis_tarif_id'] != $jt_diskon->id) {
                $jenis_tarif = JenisTarif::find($tr['jenis_tarif_id']);
                $jurnal_umums = JurnalUmum::query()
                    ->where('jurnalable_type', "App\\Models\\Periksa"  )
                    ->where('jurnalable_id',  $this->periksa->id)
                    ->where('coa_id',  $jenis_tarif->coa_id )
                    ->where('nilai', $tr['biaya'])
                    ->where('debit', 0)
                ->get();
                $this->assertCount(1, $jurnal_umums);
            }
            if ($jenis_tarif->dengan_asisten == '1') {
                $hutang_asisten_tindakan += $cc->biayaJasa($tr['jenis_tarif_id'], $tr['biaya']);
            }

            if ( !($tr['jenis_tarif_id'] ==  $jt_gula_darah->id || $tr['biaya'] == 0) ) {
                $feeDokter += Tarif::where('asuransi_id', $this->periksa->asuransi_id)->where('jenis_tarif_id', $tr['jenis_tarif_id'])->first()->jasa_dokter;
            }

            $transaksi_periksas = TransaksiPeriksa::query()
                    ->where('periksa_id', $this->periksa->id)
                    ->where('jenis_tarif_id', $tr['jenis_tarif_id'])
                    ->where('biaya', $tr['biaya'])
                    ->where('keterangan_pemeriksaan' , null)
            ->get();
            $this->assertCount(1, $transaksi_periksas);
        }

        if ($hutang_asisten_tindakan > 0) {
            $this->test_jurnal( 'Biaya Bonus Jasa Tindakan Asisten Dokter', $coa_50205, 1, $hutang_asisten_tindakan );
            $this->test_jurnal( 'Hutang Kepada Asisten Dokter', $coa_200002, 0, $hutang_asisten_tindakan);
        }
        if ($feeDokter > 0 && $this->periksa->staf->gaji_tetap == 0 ) {
            $this->test_jurnal( 'Beban Jasa Dokter', $coa_50201, 1, $feeDokter);
            $this->test_jurnal( 'Hutang Kepada dokter', $coa_200001, 0, $feeDokter);
        }

        $biayaProduksiObat = 0;
        foreach ($this->periksa->terapii as $terapi) {
            $biayaProduksiObat += $terapi->harga_beli_satuan * $terapi->jumlah;
        }
        if ($biayaProduksiObat > 0) {
            $this->test_jurnal( 'Biaya Produksi : Obat', $coa_50204, 1, $biayaProduksiObat);
            $this->test_jurnal( 'Persediaan Obat', $coa_112000, 0, $biayaProduksiObat);
        }

        $this->test_jurnal( 'Biaya Produksi : Bonus per pasien', $coa_50202, 1, 1530);
        $this->test_jurnal( 'Hutang Kepada Asisten Dokter', $coa_200002, 0, 1530);






            
        $response->assertRedirect('antriankasirs');
    }

    private function test_jurnal($coa, $coa_object, $debit, $nilai)
    {
        $jurnal_umums = JurnalUmum::query()
            ->where('jurnalable_type', "App\\Models\\Periksa"  )
            ->where('jurnalable_id',  $this->periksa->id)
            ->where('coa_id', $coa_object->id)
            ->where('nilai', $nilai)
            ->where('debit', $debit)->get();
        $this->assertCount(1, $jurnal_umums);
    }
}
