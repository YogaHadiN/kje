<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\PeriksasController;
use Carbon\Carbon;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Periksa;
use Illuminate\Http\Testing\File;
use Storage;
class PeriksasControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @group failing
     */
    public function test_store(){

        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        $jumlahPeriksaSebelumnya = Periksa::count();


        $jt_jasa_dokter = \App\Models\JenisTarif::factory()->create([
            'jenis_tarif' => 'Jasa Dokter'
        ]);

        $jt_biaya_obat = \App\Models\JenisTarif::factory()->create([
            'jenis_tarif' => 'Biaya Obat'
        ]);

        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

        $asuransi = \App\Models\Asuransi::factory()->create();
        $tr_jasa_dokter = \App\Models\Tarif::factory()->create([
            'asuransi_id' => $asuransi->id,
            'jenis_tarif_id' => $jt_jasa_dokter->id
        ]);

        $tr_biaya_obat = \App\Models\Tarif::factory()->create([
            'asuransi_id' => $asuransi->id,
            'jenis_tarif_id' => $jt_biaya_obat->id
        ]);

        $kecelakaan_kerja            = rand(0,1);
        $asuransi_id                 = $asuransi->id;
        $hamil                       = rand(0,1);
        $staf_id                     = \App\Models\Staf::factory()->create()->id;
        $kali_obat                   = 1;
        $pasien = \App\Models\Pasien::factory()->create();
        $pasien_id                   = $pasien->id;
        $jam                         = $this->faker->date('H:i:s');
        $notified                    = rand(0,1);
        $jam_periksa                 = $this->faker->date('H:i:s');
        $tanggal                     = $this->faker->date('Y-m-d');
        $bukan_peserta               = rand(0,1);
        $poli_id                     = \App\Models\Poli::factory()->create()->id;
        $adatindakan                 = rand(0,1);
        $asisten_id                  = \App\Models\Staf::factory()->create()->id;
        $periksa_awal                = $this->faker->word;
        $antrian_periksa_id          = \App\Models\AntrianPeriksa::factory()->create()->id;
        $antrian_id                  = \App\Models\Antrian::factory()->create()->id;
        $keterangan_periksa          = '';
        $dibantu                     = 1;
        $berat_badan                 = "";
        $anamnesa                    = $this->faker->sentence;
        $sistolik                    = $this->faker->numerify('###');
        $diastolik                   = $this->faker->numerify('###');
        $pemeriksaan_fisik           = $this->faker->sentence;
        $pemeriksaan_penunjang       = $this->faker->sentence;
        $diagnosa_id                 = \App\Models\Diagnosa::factory()->create()->id;
        $keterangan_diagnosa         = "";
        $presentasi                  = $this->faker->sentence;
        $BPD_w                       = "";
        $BPD_d                       = "";
        $BPD_mm                      = "";
        $HC_w                        = "";
        $HC_d                        = "";
        $HC_mm                       = "";
        $LTP                         = "";
        $FHR                         = "";
        $AC_w                        = "";
        $AC_d                        = "";
        $AC_mm                       = "";
        $EFW                         = "";
        $FL_w                        = "";
        $FL_d                        = "";
        $FL_mm                       = "";
        $Sex                         = $this->faker->sentence;
        $Plasenta                    = "fundus grade 2 -3 tidak menutupi jalan lahir";
        $total_afi                   = "0 cm";
        $kesimpulan                  = "Janin presentasi kepala tunggal hidup intrauterine, denyut jantung janin normal  x/mnt,  lilitan tali pusat, perikiraan berat janin  gr, umur kehamilan menurut  ?";
        $saran                       = "periksa lagi 4 minggu lagi";
        $ddlNamaObat                 = "";
        $ddlsigna                    = "";
        $ddlAturanMinum              = "";
        $transaksi                   = "[]";
        $resepluar                   = "";
        $G                           = "";
        $P                           = "";
        $A                           = "";
        $GPA                         = "";
        $hpht                        = "";
        $uk                          = "";
        $tb                          = "";
        $jumlah_janin                = "";
        $nama_suami                  = "";
        $bb_sebelum_hamil            = "";
        $tanggal_lahir_anak_terakhir = "";
        $golongan_darah              = "";
        $rencana_penolong            = "";
        $rencana_tempat              = "";
        $rencana_pendamping          = "";
        $rencana_transportasi        = "";
        $rencana_pendonor            = "";
        $inputBeratLahir             = "";
        $inputTahunLahir             = "";
        $riwayat_kehamilan           = "";
        $td                          = "120/80";
        $bb                          = "";
        $tfu                         = "";
        $lila                        = "";
        $refleks_patela              = "6";
        $djj                         = "";
        $kepala_terhadap_pap_id      = "7";
        $presentasi_id               = "2";
        $perujuk_id                  = "";
        $catat_di_kia                = "1";
        $inj_tt                      = "2";
        $fe_tablet                   = "2";
        $periksa_hb                  = "2";
        $protein_urin                = "2";
        $gula_darah                  = "2";
        $thalasemia                  = "2";
        $sifilis                     = "2";
        $hbsag                       = "2";
        $komplikasi_hdk              = "2";
        $komplikasi_abortus          = "2";
        $komplikasi_perdarahan       = "2";
        $komplikasi_infeksi          = "2";
        $komplikasi_kpd              = "2";
        $komplikasi_lain_lain        = "";
        $pmtct_konseling             = "2";
        $pmtct_periksa_darah         = "2";
        $pmtct_serologi              = "2";
        $pmtct_arv                   = "2";
        $malaria_periksa_darah       = "2";
        $malaria_positif             = "2";
        $malaria_dikasih_obat        = "2";
        $malaria_dikasih_kelambu     = "2";
        $tbc_periksa_dahak           = "2";
        $tbc_positif                 = "2";
        $tbc_dikasih_obat            = "2";
        $terapi                      = '[]';


        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
            "kecelakaan_kerja"            => $kecelakaan_kerja,
            "asuransi_id"                 => $asuransi_id,
            "hamil"                       => $hamil,
            "staf_id"                     => $staf_id,
            "kali_obat"                   => $kali_obat,
            "pasien_id"                   => $pasien_id,
            "jam"                         => $jam,
            "notified"                    => $notified,
            "jam_periksa"                 => $jam_periksa,
            "tanggal"                     => $tanggal,
            "bukan_peserta"               => $bukan_peserta,
            "poli_id"                     => $poli_id,
            "adatindakan"                 => $adatindakan,
            "asisten_id"                  => $asisten_id,
            "periksa_awal"                => $periksa_awal,
            "antrian_periksa_id"          => $antrian_periksa_id,
            "antrian_id"                  => $antrian_id,
            "keterangan_periksa"          => $keterangan_periksa,
            "dibantu"                     => $dibantu,
            "berat_badan"                 => $berat_badan,
            "anamnesa"                    => $anamnesa,
            "sistolik"                    => $sistolik,
            "diastolik"                   => $diastolik,
            "pemeriksaan_fisik"           => $pemeriksaan_fisik,
            "pemeriksaan_penunjang"       => $pemeriksaan_penunjang,
            "diagnosa_id"                 => $diagnosa_id,
            "keterangan_diagnosa"         => $keterangan_diagnosa,
            "presentasi"                  => $presentasi,
            "BPD_w"                       => $BPD_w,
            "BPD_d"                       => $BPD_d,
            "BPD_mm"                      => $BPD_mm,
            "HC_w"                        => $HC_w,
            "HC_d"                        => $HC_d,
            "HC_mm"                       => $HC_mm,
            "LTP"                         => $LTP,
            "FHR"                         => $FHR,
            "AC_w"                        => $AC_w,
            "AC_d"                        => $AC_d,
            "AC_mm"                       => $AC_mm,
            "EFW"                         => $EFW,
            "FL_w"                        => $FL_w,
            "FL_d"                        => $FL_d,
            "FL_mm"                       => $FL_mm,
            "Sex"                         => $Sex,
            "Plasenta"                    => $Plasenta,
            "total_afi"                   => $total_afi,
            "kesimpulan"                  => $kesimpulan,
            "saran"                       => $saran,
            "ddlNamaObat"                 => $ddlNamaObat,
            "ddlsigna"                    => $ddlsigna,
            "ddlAturanMinum"              => $ddlAturanMinum,
            "terapi"                      => $terapi,
            "transaksi"                   => $transaksi,
            "resepluar"                   => $resepluar,
            "G"                           => $G,
            "P"                           => $P,
            "A"                           => $A,
            "GPA"                         => $GPA,
            "hpht"                        => $hpht,
            "uk"                          => $uk,
            "tb"                          => $tb,
            "jumlah_janin"                => $jumlah_janin,
            "nama_suami"                  => $nama_suami,
            "bb_sebelum_hamil"            => $bb_sebelum_hamil,
            "tanggal_lahir_anak_terakhir" => $tanggal_lahir_anak_terakhir,
            "golongan_darah"              => $golongan_darah,
            "rencana_penolong"            => $rencana_penolong,
            "rencana_tempat"              => $rencana_tempat,
            "rencana_pendamping"          => $rencana_pendamping,
            "rencana_transportasi"        => $rencana_transportasi,
            "rencana_pendonor"            => $rencana_pendonor,
            "inputBeratLahir"             => $inputBeratLahir,
            "inputTahunLahir"             => $inputTahunLahir,
            "riwayat_kehamilan"           => $riwayat_kehamilan,
            "td"                          => $td,
            "bb"                          => $bb,
            "tfu"                         => $tfu,
            "lila"                        => $lila,
            "refleks_patela"              => $refleks_patela,
            "djj"                         => $djj,
            "kepala_terhadap_pap_id"      => $kepala_terhadap_pap_id,
            "presentasi_id"               => $presentasi_id,
            "perujuk_id"                  => $perujuk_id,
            "catat_di_kia"                => $catat_di_kia,
            "inj_tt"                      => $inj_tt,
            "fe_tablet"                   => $fe_tablet,
            "periksa_hb"                  => $periksa_hb,
            "protein_urin"                => $protein_urin,
            "gula_darah"                  => $gula_darah,
            "thalasemia"                  => $thalasemia,
            "sifilis"                     => $sifilis,
            "hbsag"                       => $hbsag,
            "komplikasi_hdk"              => $komplikasi_hdk,
            "komplikasi_abortus"          => $komplikasi_abortus,
            "komplikasi_perdarahan"       => $komplikasi_perdarahan,
            "komplikasi_infeksi"          => $komplikasi_infeksi,
            "komplikasi_kpd"              => $komplikasi_kpd,
            "komplikasi_lain_lain"        => $komplikasi_lain_lain,
            "pmtct_konseling"             => $pmtct_konseling,
            "pmtct_periksa_darah"         => $pmtct_periksa_darah,
            "pmtct_serologi"              => $pmtct_serologi,
            "pmtct_arv"                   => $pmtct_arv,
            "malaria_periksa_darah"       => $malaria_periksa_darah,
            "malaria_positif"             => $malaria_positif,
            "malaria_dikasih_obat"        => $malaria_dikasih_obat,
            "malaria_dikasih_kelambu"     => $malaria_dikasih_kelambu,
            "tbc_periksa_dahak"           => $tbc_periksa_dahak,
            "tbc_positif"                 => $tbc_positif,
            "tbc_dikasih_obat"            => $tbc_dikasih_obat,
        ];

        $response = $this->post('periksas', $inputAll);

        $periksa = Periksa::first();
        /* dd( */
        /*     [ */
        /*         'periksa first' => [ */
        /*         "tanggal"               => $periksa->tanggal, */
        /*         "asuransi_id"           => $periksa->asuransi_id, */
        /*         "pasien_id"             => $periksa->pasien_id, */
        /*         "staf_id"               => $periksa->staf_id, */
        /*         "anamnesa"              => $periksa->anamnesa, */
        /*         "pemeriksaan_fisik"     => $periksa->pemeriksaan_fisik, */
        /*         "pemeriksaan_penunjang" => $periksa->pemeriksaan_penunjang, */
        /*         "diagnosa_id"           => $periksa->diagnosa_id, */
        /*         "keterangan_diagnosa"   => $periksa->keterangan_diagnosa, */
        /*         "terapi"                => $periksa->terapi, */
        /*         "poli_id"               => $periksa->poli_id, */
        /*         "jam"                   => $periksa->jam, */
        /*         "berat_badan"           => $periksa->berat_badan, */
        /*         "asisten_id"            => $periksa->asisten_id, */
        /*         "periksa_awal"          => $periksa->periksa_awal, */
        /*         "kecelakaan_kerja"      => $periksa->kecelakaan_kerja, */
        /*         "resepluar"             => $periksa->resepluar, */
        /*         "nomor_asuransi"        => $periksa->nomor_asuransi, */
        /*         "antrian_periksa_id"    => $periksa->antrian_periksa_id, */
        /*         "sistolik"              => $periksa->sistolik, */
        /*         "diastolik"             => $periksa->diastolik, */
        /*         "prolanis_dm"           => $periksa->prolanis_dm, */
        /*         "prolanis_ht"           => $periksa->prolanis_ht, */
        /*     ] , */
        /*    'periksa' => [ */
        /*         "tanggal"               => $tanggal, */
        /*         "asuransi_id"           => $asuransi_id, */
        /*         "pasien_id"             => $pasien_id, */
        /*         "staf_id"               => $staf_id, */
        /*         "anamnesa"              => $anamnesa, */
        /*         "pemeriksaan_fisik"     => $pemeriksaan_fisik, */
        /*         "pemeriksaan_penunjang" => $pemeriksaan_penunjang, */
        /*         "diagnosa_id"           => $diagnosa_id, */
        /*         "keterangan_diagnosa"   => $keterangan_diagnosa, */
        /*         "terapi"                => $terapi, */
        /*         "poli_id"               => $poli_id, */
        /*         "jam"                   => $jam, */
        /*         "berat_badan"           => $berat_badan, */
        /*         "asisten_id"            => $asisten_id, */
        /*         "periksa_awal"          => $periksa_awal, */
        /*         "kecelakaan_kerja"      => $kecelakaan_kerja, */
        /*         "resepluar"             => $resepluar, */
        /*         "nomor_asuransi"        => $pasien->nomor_asuransi, */
        /*         "antrian_periksa_id"    => $antrian_periksa_id, */
        /*         "sistolik"              => $sistolik, */
        /*         "diastolik"             => $diastolik, */
        /*         "prolanis_dm"           => $pasien->prolanis_dm, */
        /*         "prolanis_ht"           => $pasien->prolanis_ht, */
        /*    ] */
        /* ]); */

        $periksas = Periksa::query()
                ->where("tanggal", $tanggal)
                ->where("asuransi_id", $asuransi_id)
                ->where("pasien_id", $pasien_id)
                ->where("staf_id", $staf_id)
                ->where("anamnesa", $anamnesa)
                ->where("pemeriksaan_fisik", $pemeriksaan_fisik)
                ->where("pemeriksaan_penunjang", $pemeriksaan_penunjang)
                ->where("diagnosa_id", $diagnosa_id)
                ->where("keterangan_diagnosa", $keterangan_diagnosa)
                ->where("terapi", $terapi)
                ->where("poli_id", $poli_id)
                ->where("jam", $jam)
                ->where("berat_badan", $berat_badan)
                ->where("asisten_id", $asisten_id)
                ->where("periksa_awal", $periksa_awal)
                ->where("kecelakaan_kerja", $kecelakaan_kerja)
                ->where("resepluar", $resepluar)
                ->where("nomor_asuransi", $pasien->nomor_asuransi)
                ->where("antrian_periksa_id", $antrian_periksa_id)
                ->where("sistolik", $sistolik)
                ->where("diastolik", $diastolik)
                ->where("prolanis_dm", $pasien->prolanis_dm)
                ->where("prolanis_ht", $pasien->prolanis_ht)
        ->get();
        $this->assertCount(1, $periksas);
        $periksa = $periksas->first();
        // report was created and file was stored
        $pc = new PeriksasController;
        $response->assertRedirect('ruangperiksa/' . $pc->ruang_periksa(null));
    }

    /**
     * @group failing
     */
    public function test_update(){

        $user     = User::factory()->create([
                        'role_id' => 6
                    ]);
        auth()->login($user);

        $jumlahPeriksaSebelumnya = Periksa::count();


        $jt_jasa_dokter = \App\Models\JenisTarif::factory()->create([
            'jenis_tarif' => 'Jasa Dokter'
        ]);

        $jt_biaya_obat = \App\Models\JenisTarif::factory()->create([
            'jenis_tarif' => 'Biaya Obat'
        ]);

        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

        $asuransi = \App\Models\Asuransi::factory()->create();
        $tr_jasa_dokter = \App\Models\Tarif::factory()->create([
            'asuransi_id' => $asuransi->id,
            'jenis_tarif_id' => $jt_jasa_dokter->id
        ]);

        $tr_biaya_obat = \App\Models\Tarif::factory()->create([
            'asuransi_id' => $asuransi->id,
            'jenis_tarif_id' => $jt_biaya_obat->id
        ]);

        $kecelakaan_kerja            = rand(0,1);
        $asuransi_id                 = $asuransi->id;
        $hamil                       = rand(0,1);
        $staf_id                     = \App\Models\Staf::factory()->create()->id;
        $kali_obat                   = 1;
        $pasien = \App\Models\Pasien::factory()->create();
        $pasien_id                   = $pasien->id;
        $jam                         = $this->faker->date('H:i:s');
        $notified                    = rand(0,1);
        $jam_periksa                 = $this->faker->date('H:i:s');
        $tanggal                     = $this->faker->date('Y-m-d');
        $bukan_peserta               = rand(0,1);
        $poli_id                     = \App\Models\Poli::factory()->create()->id;
        $adatindakan                 = rand(0,1);
        $asisten_id                  = \App\Models\Staf::factory()->create()->id;
        $periksa_awal                = $this->faker->word;
        $antrian_periksa_id          = \App\Models\AntrianPeriksa::factory()->create()->id;
        $antrian_id                  = \App\Models\Antrian::factory()->create()->id;
        $keterangan_periksa          = '';
        $dibantu                     = 1;
        $berat_badan                 = "";
        $anamnesa                    = $this->faker->sentence;
        $sistolik                    = $this->faker->numerify('###');
        $diastolik                   = $this->faker->numerify('###');
        $pemeriksaan_fisik           = $this->faker->sentence;
        $pemeriksaan_penunjang       = $this->faker->sentence;
        $diagnosa_id                 = \App\Models\Diagnosa::factory()->create()->id;
        $keterangan_diagnosa         = "";
        $presentasi                  = $this->faker->sentence;
        $BPD_w                       = "";
        $BPD_d                       = "";
        $BPD_mm                      = "";
        $HC_w                        = "";
        $HC_d                        = "";
        $HC_mm                       = "";
        $LTP                         = "";
        $FHR                         = "";
        $AC_w                        = "";
        $AC_d                        = "";
        $AC_mm                       = "";
        $EFW                         = "";
        $FL_w                        = "";
        $FL_d                        = "";
        $FL_mm                       = "";
        $Sex                         = $this->faker->sentence;
        $Plasenta                    = "fundus grade 2 -3 tidak menutupi jalan lahir";
        $total_afi                   = "0 cm";
        $kesimpulan                  = "Janin presentasi kepala tunggal hidup intrauterine, denyut jantung janin normal  x/mnt,  lilitan tali pusat, perikiraan berat janin  gr, umur kehamilan menurut  ?";
        $saran                       = "periksa lagi 4 minggu lagi";
        $ddlNamaObat                 = "";
        $ddlsigna                    = "";
        $ddlAturanMinum              = "";
        $transaksi                   = "[]";
        $resepluar                   = "";
        $G                           = "";
        $P                           = "";
        $A                           = "";
        $GPA                         = "";
        $hpht                        = "";
        $uk                          = "";
        $tb                          = "";
        $jumlah_janin                = "";
        $nama_suami                  = "";
        $bb_sebelum_hamil            = "";
        $tanggal_lahir_anak_terakhir = "";
        $golongan_darah              = "";
        $rencana_penolong            = "";
        $rencana_tempat              = "";
        $rencana_pendamping          = "";
        $rencana_transportasi        = "";
        $rencana_pendonor            = "";
        $inputBeratLahir             = "";
        $inputTahunLahir             = "";
        $riwayat_kehamilan           = "";
        $td                          = "120/80";
        $bb                          = "";
        $tfu                         = "";
        $lila                        = "";
        $refleks_patela              = "6";
        $djj                         = "";
        $kepala_terhadap_pap_id      = "7";
        $presentasi_id               = "2";
        $perujuk_id                  = "";
        $catat_di_kia                = "1";
        $inj_tt                      = "2";
        $fe_tablet                   = "2";
        $periksa_hb                  = "2";
        $protein_urin                = "2";
        $gula_darah                  = "2";
        $thalasemia                  = "2";
        $sifilis                     = "2";
        $hbsag                       = "2";
        $komplikasi_hdk              = "2";
        $komplikasi_abortus          = "2";
        $komplikasi_perdarahan       = "2";
        $komplikasi_infeksi          = "2";
        $komplikasi_kpd              = "2";
        $komplikasi_lain_lain        = "";
        $pmtct_konseling             = "2";
        $pmtct_periksa_darah         = "2";
        $pmtct_serologi              = "2";
        $pmtct_arv                   = "2";
        $malaria_periksa_darah       = "2";
        $malaria_positif             = "2";
        $malaria_dikasih_obat        = "2";
        $malaria_dikasih_kelambu     = "2";
        $tbc_periksa_dahak           = "2";
        $tbc_positif                 = "2";
        $tbc_dikasih_obat            = "2";
        $terapi                      = '[]';


        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
            "kecelakaan_kerja"            => $kecelakaan_kerja,
            "asuransi_id"                 => $asuransi_id,
            "hamil"                       => $hamil,
            "staf_id"                     => $staf_id,
            "kali_obat"                   => $kali_obat,
            "pasien_id"                   => $pasien_id,
            "jam"                         => $jam,
            "notified"                    => $notified,
            "jam_periksa"                 => $jam_periksa,
            "tanggal"                     => $tanggal,
            "bukan_peserta"               => $bukan_peserta,
            "poli_id"                     => $poli_id,
            "adatindakan"                 => $adatindakan,
            "asisten_id"                  => $asisten_id,
            "periksa_awal"                => $periksa_awal,
            "antrian_periksa_id"          => $antrian_periksa_id,
            "antrian_id"                  => $antrian_id,
            "keterangan_periksa"          => $keterangan_periksa,
            "dibantu"                     => $dibantu,
            "berat_badan"                 => $berat_badan,
            "anamnesa"                    => $anamnesa,
            "sistolik"                    => $sistolik,
            "diastolik"                   => $diastolik,
            "pemeriksaan_fisik"           => $pemeriksaan_fisik,
            "pemeriksaan_penunjang"       => $pemeriksaan_penunjang,
            "diagnosa_id"                 => $diagnosa_id,
            "keterangan_diagnosa"         => $keterangan_diagnosa,
            "presentasi"                  => $presentasi,
            "BPD_w"                       => $BPD_w,
            "BPD_d"                       => $BPD_d,
            "BPD_mm"                      => $BPD_mm,
            "HC_w"                        => $HC_w,
            "HC_d"                        => $HC_d,
            "HC_mm"                       => $HC_mm,
            "LTP"                         => $LTP,
            "FHR"                         => $FHR,
            "AC_w"                        => $AC_w,
            "AC_d"                        => $AC_d,
            "AC_mm"                       => $AC_mm,
            "EFW"                         => $EFW,
            "FL_w"                        => $FL_w,
            "FL_d"                        => $FL_d,
            "FL_mm"                       => $FL_mm,
            "Sex"                         => $Sex,
            "Plasenta"                    => $Plasenta,
            "total_afi"                   => $total_afi,
            "kesimpulan"                  => $kesimpulan,
            "saran"                       => $saran,
            "ddlNamaObat"                 => $ddlNamaObat,
            "ddlsigna"                    => $ddlsigna,
            "ddlAturanMinum"              => $ddlAturanMinum,
            "terapi"                      => $terapi,
            "transaksi"                   => $transaksi,
            "resepluar"                   => $resepluar,
            "G"                           => $G,
            "P"                           => $P,
            "A"                           => $A,
            "GPA"                         => $GPA,
            "hpht"                        => $hpht,
            "uk"                          => $uk,
            "tb"                          => $tb,
            "jumlah_janin"                => $jumlah_janin,
            "nama_suami"                  => $nama_suami,
            "bb_sebelum_hamil"            => $bb_sebelum_hamil,
            "tanggal_lahir_anak_terakhir" => $tanggal_lahir_anak_terakhir,
            "golongan_darah"              => $golongan_darah,
            "rencana_penolong"            => $rencana_penolong,
            "rencana_tempat"              => $rencana_tempat,
            "rencana_pendamping"          => $rencana_pendamping,
            "rencana_transportasi"        => $rencana_transportasi,
            "rencana_pendonor"            => $rencana_pendonor,
            "inputBeratLahir"             => $inputBeratLahir,
            "inputTahunLahir"             => $inputTahunLahir,
            "riwayat_kehamilan"           => $riwayat_kehamilan,
            "td"                          => $td,
            "bb"                          => $bb,
            "tfu"                         => $tfu,
            "lila"                        => $lila,
            "refleks_patela"              => $refleks_patela,
            "djj"                         => $djj,
            "kepala_terhadap_pap_id"      => $kepala_terhadap_pap_id,
            "presentasi_id"               => $presentasi_id,
            "perujuk_id"                  => $perujuk_id,
            "catat_di_kia"                => $catat_di_kia,
            "inj_tt"                      => $inj_tt,
            "fe_tablet"                   => $fe_tablet,
            "periksa_hb"                  => $periksa_hb,
            "protein_urin"                => $protein_urin,
            "gula_darah"                  => $gula_darah,
            "thalasemia"                  => $thalasemia,
            "sifilis"                     => $sifilis,
            "hbsag"                       => $hbsag,
            "komplikasi_hdk"              => $komplikasi_hdk,
            "komplikasi_abortus"          => $komplikasi_abortus,
            "komplikasi_perdarahan"       => $komplikasi_perdarahan,
            "komplikasi_infeksi"          => $komplikasi_infeksi,
            "komplikasi_kpd"              => $komplikasi_kpd,
            "komplikasi_lain_lain"        => $komplikasi_lain_lain,
            "pmtct_konseling"             => $pmtct_konseling,
            "pmtct_periksa_darah"         => $pmtct_periksa_darah,
            "pmtct_serologi"              => $pmtct_serologi,
            "pmtct_arv"                   => $pmtct_arv,
            "malaria_periksa_darah"       => $malaria_periksa_darah,
            "malaria_positif"             => $malaria_positif,
            "malaria_dikasih_obat"        => $malaria_dikasih_obat,
            "malaria_dikasih_kelambu"     => $malaria_dikasih_kelambu,
            "tbc_periksa_dahak"           => $tbc_periksa_dahak,
            "tbc_positif"                 => $tbc_positif,
            "tbc_dikasih_obat"            => $tbc_dikasih_obat,
        ];

        $periksa = \App\Models\Periksa::factory()->create();
        $response = $this->put('periksas/' . $periksa->id , $inputAll);

        $periksa = Periksa::first();
        /* dd( */
        /*     [ */
        /*         'periksa first' => [ */
        /*         "tanggal"               => $periksa->tanggal, */
        /*         "asuransi_id"           => $periksa->asuransi_id, */
        /*         "pasien_id"             => $periksa->pasien_id, */
        /*         "staf_id"               => $periksa->staf_id, */
        /*         "anamnesa"              => $periksa->anamnesa, */
        /*         "pemeriksaan_fisik"     => $periksa->pemeriksaan_fisik, */
        /*         "pemeriksaan_penunjang" => $periksa->pemeriksaan_penunjang, */
        /*         "diagnosa_id"           => $periksa->diagnosa_id, */
        /*         "keterangan_diagnosa"   => $periksa->keterangan_diagnosa, */
        /*         "terapi"                => $periksa->terapi, */
        /*         "poli_id"               => $periksa->poli_id, */
        /*         "jam"                   => $periksa->jam, */
        /*         "berat_badan"           => $periksa->berat_badan, */
        /*         "asisten_id"            => $periksa->asisten_id, */
        /*         "periksa_awal"          => $periksa->periksa_awal, */
        /*         "kecelakaan_kerja"      => $periksa->kecelakaan_kerja, */
        /*         "resepluar"             => $periksa->resepluar, */
        /*         "nomor_asuransi"        => $periksa->nomor_asuransi, */
        /*         "antrian_periksa_id"    => $periksa->antrian_periksa_id, */
        /*         "sistolik"              => $periksa->sistolik, */
        /*         "diastolik"             => $periksa->diastolik, */
        /*         "prolanis_dm"           => $periksa->prolanis_dm, */
        /*         "prolanis_ht"           => $periksa->prolanis_ht, */
        /*     ] , */
        /*    'periksa' => [ */
        /*         "tanggal"               => $tanggal, */
        /*         "asuransi_id"           => $asuransi_id, */
        /*         "pasien_id"             => $pasien_id, */
        /*         "staf_id"               => $staf_id, */
        /*         "anamnesa"              => $anamnesa, */
        /*         "pemeriksaan_fisik"     => $pemeriksaan_fisik, */
        /*         "pemeriksaan_penunjang" => $pemeriksaan_penunjang, */
        /*         "diagnosa_id"           => $diagnosa_id, */
        /*         "keterangan_diagnosa"   => $keterangan_diagnosa, */
        /*         "terapi"                => $terapi, */
        /*         "poli_id"               => $poli_id, */
        /*         "jam"                   => $jam, */
        /*         "berat_badan"           => $berat_badan, */
        /*         "asisten_id"            => $asisten_id, */
        /*         "periksa_awal"          => $periksa_awal, */
        /*         "kecelakaan_kerja"      => $kecelakaan_kerja, */
        /*         "resepluar"             => $resepluar, */
        /*         "nomor_asuransi"        => $pasien->nomor_asuransi, */
        /*         "antrian_periksa_id"    => $antrian_periksa_id, */
        /*         "sistolik"              => $sistolik, */
        /*         "diastolik"             => $diastolik, */
        /*         "prolanis_dm"           => $pasien->prolanis_dm, */
        /*         "prolanis_ht"           => $pasien->prolanis_ht, */
        /*    ] */
        /* ]); */

        $periksas = Periksa::query()
                ->where("tanggal", $tanggal)
                ->where("asuransi_id", $asuransi_id)
                ->where("pasien_id", $pasien_id)
                ->where("staf_id", $staf_id)
                ->where("anamnesa", $anamnesa)
                ->where("pemeriksaan_fisik", $pemeriksaan_fisik)
                ->where("pemeriksaan_penunjang", $pemeriksaan_penunjang)
                ->where("diagnosa_id", $diagnosa_id)
                ->where("keterangan_diagnosa", $keterangan_diagnosa)
                ->where("terapi", $terapi)
                ->where("poli_id", $poli_id)
                ->where("jam", $jam)
                ->where("berat_badan", $berat_badan)
                ->where("asisten_id", $asisten_id)
                ->where("periksa_awal", $periksa_awal)
                ->where("kecelakaan_kerja", $kecelakaan_kerja)
                ->where("resepluar", $resepluar)
                ->where("nomor_asuransi", $pasien->nomor_asuransi)
                ->where("antrian_periksa_id", $antrian_periksa_id)
                ->where("sistolik", $sistolik)
                ->where("diastolik", $diastolik)
                ->where("prolanis_dm", $pasien->prolanis_dm)
                ->where("prolanis_ht", $pasien->prolanis_ht)
        ->get();
        $this->assertCount(1, $periksas);
        $periksa = $periksas->first();
        // report was created and file was stored
        $pc = new PeriksasController;
        $response->assertRedirect('ruangperiksa/' . $pc->ruang_periksa(null));
    }

    public function test_store(){
        $user     = User::factory()->create([
                        'role_id' => 6
                    ]);

        auth()->login($user);

        $jumlahPeriksaSebelumnya = Periksa::count();

        $jt_jasa_dokter = \App\Models\JenisTarif::factory()->create([
            'jenis_tarif' => 'Jasa Dokter'
        ]);

        $jt_biaya_obat = \App\Models\JenisTarif::factory()->create([
            'jenis_tarif' => 'Biaya Obat'
        ]);

        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

        $asuransi       = \App\Models\Asuransi::factory()->create();
        $tr_jasa_dokter = \App\Models\Tarif::factory()->create([
            'asuransi_id'    => $asuransi->id,
            'jenis_tarif_id' => $jt_jasa_dokter->id
        ]);

        $tr_biaya_obat = \App\Models\Tarif::factory()->create([
            'asuransi_id' => $asuransi->id,
            'jenis_tarif_id' => $jt_biaya_obat->id
        ]);

        $kecelakaan_kerja            = rand(0,1);
        $asuransi_id                 = $asuransi->id;
        $hamil                       = rand(0,1);
        $staf_id                     = \App\Models\Staf::factory()->create()->id;
        $kali_obat                   = 1;
        $pasien = \App\Models\Pasien::factory()->create();
        $pasien_id                   = $pasien->id;
        $jam                         = $this->faker->date('H:i:s');
        $notified                    = rand(0,1);
        $jam_periksa                 = $this->faker->date('H:i:s');
        $tanggal                     = $this->faker->date('Y-m-d');
        $bukan_peserta               = rand(0,1);
        $poli_id                     = \App\Models\Poli::factory()->create()->id;
        $adatindakan                 = rand(0,1);
        $asisten_id                  = \App\Models\Staf::factory()->create()->id;
        $periksa_awal                = $this->faker->word;
        $antrian_periksa_id          = \App\Models\AntrianPeriksa::factory()->create()->id;
        $antrian_id                  = \App\Models\Antrian::factory()->create()->id;
        $keterangan_periksa          = '';
        $dibantu                     = 1;
        $berat_badan                 = "";
        $anamnesa                    = $this->faker->sentence;
        $sistolik                    = $this->faker->numerify('###');
        $diastolik                   = $this->faker->numerify('###');
        $pemeriksaan_fisik           = $this->faker->sentence;
        $pemeriksaan_penunjang       = $this->faker->sentence;
        $diagnosa_id                 = \App\Models\Diagnosa::factory()->create()->id;
        $keterangan_diagnosa         = "";
        $presentasi                  = $this->faker->sentence;
        $BPD_w                       = "";
        $BPD_d                       = "";
        $BPD_mm                      = "";
        $HC_w                        = "";
        $HC_d                        = "";
        $HC_mm                       = "";
        $LTP                         = "";
        $FHR                         = "";
        $AC_w                        = "";
        $AC_d                        = "";
        $AC_mm                       = "";
        $EFW                         = "";
        $FL_w                        = "";
        $FL_d                        = "";
        $FL_mm                       = "";
        $Sex                         = $this->faker->sentence;
        $Plasenta                    = "fundus grade 2 -3 tidak menutupi jalan lahir";
        $total_afi                   = "0 cm";
        $kesimpulan                  = "Janin presentasi kepala tunggal hidup intrauterine, denyut jantung janin normal  x/mnt,  lilitan tali pusat, perikiraan berat janin  gr, umur kehamilan menurut  ?";
        $saran                       = "periksa lagi 4 minggu lagi";
        $ddlNamaObat                 = "";
        $ddlsigna                    = "";
        $ddlAturanMinum              = "";
        $transaksi                   = "[]";
        $resepluar                   = "";
        $G                           = "";
        $P                           = "";
        $A                           = "";
        $GPA                         = "";
        $hpht                        = "";
        $uk                          = "";
        $tb                          = "";
        $jumlah_janin                = "";
        $nama_suami                  = "";
        $bb_sebelum_hamil            = "";
        $tanggal_lahir_anak_terakhir = "";
        $golongan_darah              = "";
        $rencana_penolong            = "";
        $rencana_tempat              = "";
        $rencana_pendamping          = "";
        $rencana_transportasi        = "";
        $rencana_pendonor            = "";
        $inputBeratLahir             = "";
        $inputTahunLahir             = "";
        $riwayat_kehamilan           = "";
        $td                          = "120/80";
        $bb                          = "";
        $tfu                         = "";
        $lila                        = "";
        $refleks_patela              = "6";
        $djj                         = "";
        $kepala_terhadap_pap_id      = "7";
        $presentasi_id               = "2";
        $perujuk_id                  = "";
        $catat_di_kia                = "1";
        $inj_tt                      = "2";
        $fe_tablet                   = "2";
        $periksa_hb                  = "2";
        $protein_urin                = "2";
        $gula_darah                  = "2";
        $thalasemia                  = "2";
        $sifilis                     = "2";
        $hbsag                       = "2";
        $komplikasi_hdk              = "2";
        $komplikasi_abortus          = "2";
        $komplikasi_perdarahan       = "2";
        $komplikasi_infeksi          = "2";
        $komplikasi_kpd              = "2";
        $komplikasi_lain_lain        = "";
        $pmtct_konseling             = "2";
        $pmtct_periksa_darah         = "2";
        $pmtct_serologi              = "2";
        $pmtct_arv                   = "2";
        $malaria_periksa_darah       = "2";
        $malaria_positif             = "2";
        $malaria_dikasih_obat        = "2";
        $malaria_dikasih_kelambu     = "2";
        $tbc_periksa_dahak           = "2";
        $tbc_positif                 = "2";
        $tbc_dikasih_obat            = "2";
        $terapi                      = '[]';


        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
            "kecelakaan_kerja"            => $kecelakaan_kerja,
            "asuransi_id"                 => $asuransi_id,
            "hamil"                       => $hamil,
            "staf_id"                     => $staf_id,
            "kali_obat"                   => $kali_obat,
            "pasien_id"                   => $pasien_id,
            "jam"                         => $jam,
            "notified"                    => $notified,
            "jam_periksa"                 => $jam_periksa,
            "tanggal"                     => $tanggal,
            "bukan_peserta"               => $bukan_peserta,
            "poli_id"                     => $poli_id,
            "adatindakan"                 => $adatindakan,
            "asisten_id"                  => $asisten_id,
            "periksa_awal"                => $periksa_awal,
            "antrian_periksa_id"          => $antrian_periksa_id,
            "antrian_id"                  => $antrian_id,
            "keterangan_periksa"          => $keterangan_periksa,
            "dibantu"                     => $dibantu,
            "berat_badan"                 => $berat_badan,
            "anamnesa"                    => $anamnesa,
            "sistolik"                    => $sistolik,
            "diastolik"                   => $diastolik,
            "pemeriksaan_fisik"           => $pemeriksaan_fisik,
            "pemeriksaan_penunjang"       => $pemeriksaan_penunjang,
            "diagnosa_id"                 => $diagnosa_id,
            "keterangan_diagnosa"         => $keterangan_diagnosa,
            "presentasi"                  => $presentasi,
            "BPD_w"                       => $BPD_w,
            "BPD_d"                       => $BPD_d,
            "BPD_mm"                      => $BPD_mm,
            "HC_w"                        => $HC_w,
            "HC_d"                        => $HC_d,
            "HC_mm"                       => $HC_mm,
            "LTP"                         => $LTP,
            "FHR"                         => $FHR,
            "AC_w"                        => $AC_w,
            "AC_d"                        => $AC_d,
            "AC_mm"                       => $AC_mm,
            "EFW"                         => $EFW,
            "FL_w"                        => $FL_w,
            "FL_d"                        => $FL_d,
            "FL_mm"                       => $FL_mm,
            "Sex"                         => $Sex,
            "Plasenta"                    => $Plasenta,
            "total_afi"                   => $total_afi,
            "kesimpulan"                  => $kesimpulan,
            "saran"                       => $saran,
            "ddlNamaObat"                 => $ddlNamaObat,
            "ddlsigna"                    => $ddlsigna,
            "ddlAturanMinum"              => $ddlAturanMinum,
            "terapi"                      => $terapi,
            "transaksi"                   => $transaksi,
            "resepluar"                   => $resepluar,
            "G"                           => $G,
            "P"                           => $P,
            "A"                           => $A,
            "GPA"                         => $GPA,
            "hpht"                        => $hpht,
            "uk"                          => $uk,
            "tb"                          => $tb,
            "jumlah_janin"                => $jumlah_janin,
            "nama_suami"                  => $nama_suami,
            "bb_sebelum_hamil"            => $bb_sebelum_hamil,
            "tanggal_lahir_anak_terakhir" => $tanggal_lahir_anak_terakhir,
            "golongan_darah"              => $golongan_darah,
            "rencana_penolong"            => $rencana_penolong,
            "rencana_tempat"              => $rencana_tempat,
            "rencana_pendamping"          => $rencana_pendamping,
            "rencana_transportasi"        => $rencana_transportasi,
            "rencana_pendonor"            => $rencana_pendonor,
            "inputBeratLahir"             => $inputBeratLahir,
            "inputTahunLahir"             => $inputTahunLahir,
            "riwayat_kehamilan"           => $riwayat_kehamilan,
            "td"                          => $td,
            "bb"                          => $bb,
            "tfu"                         => $tfu,
            "lila"                        => $lila,
            "refleks_patela"              => $refleks_patela,
            "djj"                         => $djj,
            "kepala_terhadap_pap_id"      => $kepala_terhadap_pap_id,
            "presentasi_id"               => $presentasi_id,
            "perujuk_id"                  => $perujuk_id,
            "catat_di_kia"                => $catat_di_kia,
            "inj_tt"                      => $inj_tt,
            "fe_tablet"                   => $fe_tablet,
            "periksa_hb"                  => $periksa_hb,
            "protein_urin"                => $protein_urin,
            "gula_darah"                  => $gula_darah,
            "thalasemia"                  => $thalasemia,
            "sifilis"                     => $sifilis,
            "hbsag"                       => $hbsag,
            "komplikasi_hdk"              => $komplikasi_hdk,
            "komplikasi_abortus"          => $komplikasi_abortus,
            "komplikasi_perdarahan"       => $komplikasi_perdarahan,
            "komplikasi_infeksi"          => $komplikasi_infeksi,
            "komplikasi_kpd"              => $komplikasi_kpd,
            "komplikasi_lain_lain"        => $komplikasi_lain_lain,
            "pmtct_konseling"             => $pmtct_konseling,
            "pmtct_periksa_darah"         => $pmtct_periksa_darah,
            "pmtct_serologi"              => $pmtct_serologi,
            "pmtct_arv"                   => $pmtct_arv,
            "malaria_periksa_darah"       => $malaria_periksa_darah,
            "malaria_positif"             => $malaria_positif,
            "malaria_dikasih_obat"        => $malaria_dikasih_obat,
            "malaria_dikasih_kelambu"     => $malaria_dikasih_kelambu,
            "tbc_periksa_dahak"           => $tbc_periksa_dahak,
            "tbc_positif"                 => $tbc_positif,
            "tbc_dikasih_obat"            => $tbc_dikasih_obat,
        ];

        $response = $this->post('periksas', $inputAll);

        $periksa = Periksa::first();
        /* dd( */
        /*     [ */
        /*         'periksa first' => [ */
        /*         "tanggal"               => $periksa->tanggal, */
        /*         "asuransi_id"           => $periksa->asuransi_id, */
        /*         "pasien_id"             => $periksa->pasien_id, */
        /*         "staf_id"               => $periksa->staf_id, */
        /*         "anamnesa"              => $periksa->anamnesa, */
        /*         "pemeriksaan_fisik"     => $periksa->pemeriksaan_fisik, */
        /*         "pemeriksaan_penunjang" => $periksa->pemeriksaan_penunjang, */
        /*         "diagnosa_id"           => $periksa->diagnosa_id, */
        /*         "keterangan_diagnosa"   => $periksa->keterangan_diagnosa, */
        /*         "terapi"                => $periksa->terapi, */
        /*         "poli_id"               => $periksa->poli_id, */
        /*         "jam"                   => $periksa->jam, */
        /*         "berat_badan"           => $periksa->berat_badan, */
        /*         "asisten_id"            => $periksa->asisten_id, */
        /*         "periksa_awal"          => $periksa->periksa_awal, */
        /*         "kecelakaan_kerja"      => $periksa->kecelakaan_kerja, */
        /*         "resepluar"             => $periksa->resepluar, */
        /*         "nomor_asuransi"        => $periksa->nomor_asuransi, */
        /*         "antrian_periksa_id"    => $periksa->antrian_periksa_id, */
        /*         "sistolik"              => $periksa->sistolik, */
        /*         "diastolik"             => $periksa->diastolik, */
        /*         "prolanis_dm"           => $periksa->prolanis_dm, */
        /*         "prolanis_ht"           => $periksa->prolanis_ht, */
        /*     ] , */
        /*    'periksa' => [ */
        /*         "tanggal"               => $tanggal, */
        /*         "asuransi_id"           => $asuransi_id, */
        /*         "pasien_id"             => $pasien_id, */
        /*         "staf_id"               => $staf_id, */
        /*         "anamnesa"              => $anamnesa, */
        /*         "pemeriksaan_fisik"     => $pemeriksaan_fisik, */
        /*         "pemeriksaan_penunjang" => $pemeriksaan_penunjang, */
        /*         "diagnosa_id"           => $diagnosa_id, */
        /*         "keterangan_diagnosa"   => $keterangan_diagnosa, */
        /*         "terapi"                => $terapi, */
        /*         "poli_id"               => $poli_id, */
        /*         "jam"                   => $jam, */
        /*         "berat_badan"           => $berat_badan, */
        /*         "asisten_id"            => $asisten_id, */
        /*         "periksa_awal"          => $periksa_awal, */
        /*         "kecelakaan_kerja"      => $kecelakaan_kerja, */
        /*         "resepluar"             => $resepluar, */
        /*         "nomor_asuransi"        => $pasien->nomor_asuransi, */
        /*         "antrian_periksa_id"    => $antrian_periksa_id, */
        /*         "sistolik"              => $sistolik, */
        /*         "diastolik"             => $diastolik, */
        /*         "prolanis_dm"           => $pasien->prolanis_dm, */
        /*         "prolanis_ht"           => $pasien->prolanis_ht, */
        /*    ] */
        /* ]); */

        $periksas = Periksa::query()
                ->where("tanggal", $tanggal)
                ->where("asuransi_id", $asuransi_id)
                ->where("pasien_id", $pasien_id)
                ->where("staf_id", $staf_id)
                ->where("anamnesa", $anamnesa)
                ->where("pemeriksaan_fisik", $pemeriksaan_fisik)
                ->where("pemeriksaan_penunjang", $pemeriksaan_penunjang)
                ->where("diagnosa_id", $diagnosa_id)
                ->where("keterangan_diagnosa", $keterangan_diagnosa)
                ->where("terapi", $terapi)
                ->where("poli_id", $poli_id)
                ->where("jam", $jam)
                ->where("berat_badan", $berat_badan)
                ->where("asisten_id", $asisten_id)
                ->where("periksa_awal", $periksa_awal)
                ->where("kecelakaan_kerja", $kecelakaan_kerja)
                ->where("resepluar", $resepluar)
                ->where("nomor_asuransi", $pasien->nomor_asuransi)
                ->where("antrian_periksa_id", $antrian_periksa_id)
                ->where("sistolik", $sistolik)
                ->where("diastolik", $diastolik)
                ->where("prolanis_dm", $pasien->prolanis_dm)
                ->where("prolanis_ht", $pasien->prolanis_ht)
        ->get();
        $this->assertCount(1, $periksas);
        $periksa = $periksas->first();
        // report was created and file was stored
        $pc = new PeriksasController;
        $response->assertRedirect('ruangperiksa/' . $pc->ruang_periksa(null));
    }

    /**
     * @group failing
     */
    public function test_update(){

        $user     = User::factory()->create([
                        'role_id' => 6
                    ]);
        auth()->login($user);

        $jumlahPeriksaSebelumnya = Periksa::count();


        $jt_jasa_dokter = \App\Models\JenisTarif::factory()->create([
            'jenis_tarif' => 'Jasa Dokter'
        ]);

        $jt_biaya_obat = \App\Models\JenisTarif::factory()->create([
            'jenis_tarif' => 'Biaya Obat'
        ]);

        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

        $asuransi = \App\Models\Asuransi::factory()->create();
        $tr_jasa_dokter = \App\Models\Tarif::factory()->create([
            'asuransi_id' => $asuransi->id,
            'jenis_tarif_id' => $jt_jasa_dokter->id
        ]);

        $tr_biaya_obat = \App\Models\Tarif::factory()->create([
            'asuransi_id' => $asuransi->id,
            'jenis_tarif_id' => $jt_biaya_obat->id
        ]);

        $kecelakaan_kerja            = rand(0,1);
        $asuransi_id                 = $asuransi->id;
        $hamil                       = rand(0,1);
        $staf_id                     = \App\Models\Staf::factory()->create()->id;
        $kali_obat                   = 1;
        $pasien = \App\Models\Pasien::factory()->create();
        $pasien_id                   = $pasien->id;
        $jam                         = $this->faker->date('H:i:s');
        $notified                    = rand(0,1);
        $jam_periksa                 = $this->faker->date('H:i:s');
        $tanggal                     = $this->faker->date('Y-m-d');
        $bukan_peserta               = rand(0,1);
        $poli_id                     = \App\Models\Poli::factory()->create()->id;
        $adatindakan                 = rand(0,1);
        $asisten_id                  = \App\Models\Staf::factory()->create()->id;
        $periksa_awal                = $this->faker->word;
        $antrian_periksa_id          = \App\Models\AntrianPeriksa::factory()->create()->id;
        $antrian_id                  = \App\Models\Antrian::factory()->create()->id;
        $keterangan_periksa          = '';
        $dibantu                     = 1;
        $berat_badan                 = "";
        $anamnesa                    = $this->faker->sentence;
        $sistolik                    = $this->faker->numerify('###');
        $diastolik                   = $this->faker->numerify('###');
        $pemeriksaan_fisik           = $this->faker->sentence;
        $pemeriksaan_penunjang       = $this->faker->sentence;
        $diagnosa_id                 = \App\Models\Diagnosa::factory()->create()->id;
        $keterangan_diagnosa         = "";
        $presentasi                  = $this->faker->sentence;
        $BPD_w                       = "";
        $BPD_d                       = "";
        $BPD_mm                      = "";
        $HC_w                        = "";
        $HC_d                        = "";
        $HC_mm                       = "";
        $LTP                         = "";
        $FHR                         = "";
        $AC_w                        = "";
        $AC_d                        = "";
        $AC_mm                       = "";
        $EFW                         = "";
        $FL_w                        = "";
        $FL_d                        = "";
        $FL_mm                       = "";
        $Sex                         = $this->faker->sentence;
        $Plasenta                    = "fundus grade 2 -3 tidak menutupi jalan lahir";
        $total_afi                   = "0 cm";
        $kesimpulan                  = "Janin presentasi kepala tunggal hidup intrauterine, denyut jantung janin normal  x/mnt,  lilitan tali pusat, perikiraan berat janin  gr, umur kehamilan menurut  ?";
        $saran                       = "periksa lagi 4 minggu lagi";
        $ddlNamaObat                 = "";
        $ddlsigna                    = "";
        $ddlAturanMinum              = "";
        $transaksi                   = "[]";
        $resepluar                   = "";
        $G                           = "";
        $P                           = "";
        $A                           = "";
        $GPA                         = "";
        $hpht                        = "";
        $uk                          = "";
        $tb                          = "";
        $jumlah_janin                = "";
        $nama_suami                  = "";
        $bb_sebelum_hamil            = "";
        $tanggal_lahir_anak_terakhir = "";
        $golongan_darah              = "";
        $rencana_penolong            = "";
        $rencana_tempat              = "";
        $rencana_pendamping          = "";
        $rencana_transportasi        = "";
        $rencana_pendonor            = "";
        $inputBeratLahir             = "";
        $inputTahunLahir             = "";
        $riwayat_kehamilan           = "";
        $td                          = "120/80";
        $bb                          = "";
        $tfu                         = "";
        $lila                        = "";
        $refleks_patela              = "6";
        $djj                         = "";
        $kepala_terhadap_pap_id      = "7";
        $presentasi_id               = "2";
        $perujuk_id                  = "";
        $catat_di_kia                = "1";
        $inj_tt                      = "2";
        $fe_tablet                   = "2";
        $periksa_hb                  = "2";
        $protein_urin                = "2";
        $gula_darah                  = "2";
        $thalasemia                  = "2";
        $sifilis                     = "2";
        $hbsag                       = "2";
        $komplikasi_hdk              = "2";
        $komplikasi_abortus          = "2";
        $komplikasi_perdarahan       = "2";
        $komplikasi_infeksi          = "2";
        $komplikasi_kpd              = "2";
        $komplikasi_lain_lain        = "";
        $pmtct_konseling             = "2";
        $pmtct_periksa_darah         = "2";
        $pmtct_serologi              = "2";
        $pmtct_arv                   = "2";
        $malaria_periksa_darah       = "2";
        $malaria_positif             = "2";
        $malaria_dikasih_obat        = "2";
        $malaria_dikasih_kelambu     = "2";
        $tbc_periksa_dahak           = "2";
        $tbc_positif                 = "2";
        $tbc_dikasih_obat            = "2";
        $terapi                      = '[]';


        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
            "kecelakaan_kerja"            => $kecelakaan_kerja,
            "asuransi_id"                 => $asuransi_id,
            "hamil"                       => $hamil,
            "staf_id"                     => $staf_id,
            "kali_obat"                   => $kali_obat,
            "pasien_id"                   => $pasien_id,
            "jam"                         => $jam,
            "notified"                    => $notified,
            "jam_periksa"                 => $jam_periksa,
            "tanggal"                     => $tanggal,
            "bukan_peserta"               => $bukan_peserta,
            "poli_id"                     => $poli_id,
            "adatindakan"                 => $adatindakan,
            "asisten_id"                  => $asisten_id,
            "periksa_awal"                => $periksa_awal,
            "antrian_periksa_id"          => $antrian_periksa_id,
            "antrian_id"                  => $antrian_id,
            "keterangan_periksa"          => $keterangan_periksa,
            "dibantu"                     => $dibantu,
            "berat_badan"                 => $berat_badan,
            "anamnesa"                    => $anamnesa,
            "sistolik"                    => $sistolik,
            "diastolik"                   => $diastolik,
            "pemeriksaan_fisik"           => $pemeriksaan_fisik,
            "pemeriksaan_penunjang"       => $pemeriksaan_penunjang,
            "diagnosa_id"                 => $diagnosa_id,
            "keterangan_diagnosa"         => $keterangan_diagnosa,
            "presentasi"                  => $presentasi,
            "BPD_w"                       => $BPD_w,
            "BPD_d"                       => $BPD_d,
            "BPD_mm"                      => $BPD_mm,
            "HC_w"                        => $HC_w,
            "HC_d"                        => $HC_d,
            "HC_mm"                       => $HC_mm,
            "LTP"                         => $LTP,
            "FHR"                         => $FHR,
            "AC_w"                        => $AC_w,
            "AC_d"                        => $AC_d,
            "AC_mm"                       => $AC_mm,
            "EFW"                         => $EFW,
            "FL_w"                        => $FL_w,
            "FL_d"                        => $FL_d,
            "FL_mm"                       => $FL_mm,
            "Sex"                         => $Sex,
            "Plasenta"                    => $Plasenta,
            "total_afi"                   => $total_afi,
            "kesimpulan"                  => $kesimpulan,
            "saran"                       => $saran,
            "ddlNamaObat"                 => $ddlNamaObat,
            "ddlsigna"                    => $ddlsigna,
            "ddlAturanMinum"              => $ddlAturanMinum,
            "terapi"                      => $terapi,
            "transaksi"                   => $transaksi,
            "resepluar"                   => $resepluar,
            "G"                           => $G,
            "P"                           => $P,
            "A"                           => $A,
            "GPA"                         => $GPA,
            "hpht"                        => $hpht,
            "uk"                          => $uk,
            "tb"                          => $tb,
            "jumlah_janin"                => $jumlah_janin,
            "nama_suami"                  => $nama_suami,
            "bb_sebelum_hamil"            => $bb_sebelum_hamil,
            "tanggal_lahir_anak_terakhir" => $tanggal_lahir_anak_terakhir,
            "golongan_darah"              => $golongan_darah,
            "rencana_penolong"            => $rencana_penolong,
            "rencana_tempat"              => $rencana_tempat,
            "rencana_pendamping"          => $rencana_pendamping,
            "rencana_transportasi"        => $rencana_transportasi,
            "rencana_pendonor"            => $rencana_pendonor,
            "inputBeratLahir"             => $inputBeratLahir,
            "inputTahunLahir"             => $inputTahunLahir,
            "riwayat_kehamilan"           => $riwayat_kehamilan,
            "td"                          => $td,
            "bb"                          => $bb,
            "tfu"                         => $tfu,
            "lila"                        => $lila,
            "refleks_patela"              => $refleks_patela,
            "djj"                         => $djj,
            "kepala_terhadap_pap_id"      => $kepala_terhadap_pap_id,
            "presentasi_id"               => $presentasi_id,
            "perujuk_id"                  => $perujuk_id,
            "catat_di_kia"                => $catat_di_kia,
            "inj_tt"                      => $inj_tt,
            "fe_tablet"                   => $fe_tablet,
            "periksa_hb"                  => $periksa_hb,
            "protein_urin"                => $protein_urin,
            "gula_darah"                  => $gula_darah,
            "thalasemia"                  => $thalasemia,
            "sifilis"                     => $sifilis,
            "hbsag"                       => $hbsag,
            "komplikasi_hdk"              => $komplikasi_hdk,
            "komplikasi_abortus"          => $komplikasi_abortus,
            "komplikasi_perdarahan"       => $komplikasi_perdarahan,
            "komplikasi_infeksi"          => $komplikasi_infeksi,
            "komplikasi_kpd"              => $komplikasi_kpd,
            "komplikasi_lain_lain"        => $komplikasi_lain_lain,
            "pmtct_konseling"             => $pmtct_konseling,
            "pmtct_periksa_darah"         => $pmtct_periksa_darah,
            "pmtct_serologi"              => $pmtct_serologi,
            "pmtct_arv"                   => $pmtct_arv,
            "malaria_periksa_darah"       => $malaria_periksa_darah,
            "malaria_positif"             => $malaria_positif,
            "malaria_dikasih_obat"        => $malaria_dikasih_obat,
            "malaria_dikasih_kelambu"     => $malaria_dikasih_kelambu,
            "tbc_periksa_dahak"           => $tbc_periksa_dahak,
            "tbc_positif"                 => $tbc_positif,
            "tbc_dikasih_obat"            => $tbc_dikasih_obat,
        ];

        $periksa = \App\Models\Periksa::factory()->create();
        $response = $this->put('periksas/' . $periksa->id , $inputAll);

        $periksa = Periksa::first();
        /* dd( */
        /*     [ */
        /*         'periksa first' => [ */
        /*         "tanggal"               => $periksa->tanggal, */
        /*         "asuransi_id"           => $periksa->asuransi_id, */
        /*         "pasien_id"             => $periksa->pasien_id, */
        /*         "staf_id"               => $periksa->staf_id, */
        /*         "anamnesa"              => $periksa->anamnesa, */
        /*         "pemeriksaan_fisik"     => $periksa->pemeriksaan_fisik, */
        /*         "pemeriksaan_penunjang" => $periksa->pemeriksaan_penunjang, */
        /*         "diagnosa_id"           => $periksa->diagnosa_id, */
        /*         "keterangan_diagnosa"   => $periksa->keterangan_diagnosa, */
        /*         "terapi"                => $periksa->terapi, */
        /*         "poli_id"               => $periksa->poli_id, */
        /*         "jam"                   => $periksa->jam, */
        /*         "berat_badan"           => $periksa->berat_badan, */
        /*         "asisten_id"            => $periksa->asisten_id, */
        /*         "periksa_awal"          => $periksa->periksa_awal, */
        /*         "kecelakaan_kerja"      => $periksa->kecelakaan_kerja, */
        /*         "resepluar"             => $periksa->resepluar, */
        /*         "nomor_asuransi"        => $periksa->nomor_asuransi, */
        /*         "antrian_periksa_id"    => $periksa->antrian_periksa_id, */
        /*         "sistolik"              => $periksa->sistolik, */
        /*         "diastolik"             => $periksa->diastolik, */
        /*         "prolanis_dm"           => $periksa->prolanis_dm, */
        /*         "prolanis_ht"           => $periksa->prolanis_ht, */
        /*     ] , */
        /*    'periksa' => [ */
        /*         "tanggal"               => $tanggal, */
        /*         "asuransi_id"           => $asuransi_id, */
        /*         "pasien_id"             => $pasien_id, */
        /*         "staf_id"               => $staf_id, */
        /*         "anamnesa"              => $anamnesa, */
        /*         "pemeriksaan_fisik"     => $pemeriksaan_fisik, */
        /*         "pemeriksaan_penunjang" => $pemeriksaan_penunjang, */
        /*         "diagnosa_id"           => $diagnosa_id, */
        /*         "keterangan_diagnosa"   => $keterangan_diagnosa, */
        /*         "terapi"                => $terapi, */
        /*         "poli_id"               => $poli_id, */
        /*         "jam"                   => $jam, */
        /*         "berat_badan"           => $berat_badan, */
        /*         "asisten_id"            => $asisten_id, */
        /*         "periksa_awal"          => $periksa_awal, */
        /*         "kecelakaan_kerja"      => $kecelakaan_kerja, */
        /*         "resepluar"             => $resepluar, */
        /*         "nomor_asuransi"        => $pasien->nomor_asuransi, */
        /*         "antrian_periksa_id"    => $antrian_periksa_id, */
        /*         "sistolik"              => $sistolik, */
        /*         "diastolik"             => $diastolik, */
        /*         "prolanis_dm"           => $pasien->prolanis_dm, */
        /*         "prolanis_ht"           => $pasien->prolanis_ht, */
        /*    ] */
        /* ]); */

        $periksas = Periksa::query()
                ->where("tanggal", $tanggal)
                ->where("asuransi_id", $asuransi_id)
                ->where("pasien_id", $pasien_id)
                ->where("staf_id", $staf_id)
                ->where("anamnesa", $anamnesa)
                ->where("pemeriksaan_fisik", $pemeriksaan_fisik)
                ->where("pemeriksaan_penunjang", $pemeriksaan_penunjang)
                ->where("diagnosa_id", $diagnosa_id)
                ->where("keterangan_diagnosa", $keterangan_diagnosa)
                ->where("terapi", $terapi)
                ->where("poli_id", $poli_id)
                ->where("jam", $jam)
                ->where("berat_badan", $berat_badan)
                ->where("asisten_id", $asisten_id)
                ->where("periksa_awal", $periksa_awal)
                ->where("kecelakaan_kerja", $kecelakaan_kerja)
                ->where("resepluar", $resepluar)
                ->where("nomor_asuransi", $pasien->nomor_asuransi)
                ->where("antrian_periksa_id", $antrian_periksa_id)
                ->where("sistolik", $sistolik)
                ->where("diastolik", $diastolik)
                ->where("prolanis_dm", $pasien->prolanis_dm)
                ->where("prolanis_ht", $pasien->prolanis_ht)
        ->get();
        $this->assertCount(1, $periksas);
        $periksa = $periksas->first();
        // report was created and file was stored
        $pc = new PeriksasController;
        $response->assertRedirect('ruangperiksa/' . $pc->ruang_periksa(null));
    }
    public function test_show(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $periksa = Periksa::factory()->create();

        $ct = new CustomControllerTest;
        $periksa->transaksi = $ct->transaksis($periksa->asuransi_id);
        $periksa->save();

        $response = $this->get('periksas/' . $periksa->id);
        $response->assertStatus(200);
    }

    /**
     * 
     */
    public function test_a_user_can_only_see_periksa_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();;

        $user1 = User::factory()->create([
        'tenant_id' => $tenant1,
        ]);

        for ($x = 0; $x < 10; $x++) {
        Periksa::factory()->create([
                        'tenant_id' => $tenant1,
        ]);
        }

        for ($x = 0; $x < 11; $x++) {
        Periksa::factory()->create([
                        'tenant_id' => $tenant2,
        ]);
        }

        auth()->login($user1);

        $this->assertEquals(10, Periksa::count());
    }

    public function test_a_user_can_only_create_a_periksa_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        auth()->login($user1);

        $createdPeriksa = Periksa::factory()->create();

        $this->assertTrue($createdPeriksa->tenant_id == $user1->tenant_id);
    }
}
/* array:111 [? */
/*   "_token" => "WPvl5iLu0fVaL6eZbIaYKVQzzmOYSYZRZQupNvVG" */
/*   "kecelakaan_kerja" => "1" */
/*   "asuransi_id" => "0" */
/*   "hamil" => "0" */
/*   "staf_id" => "11" */
/*   "kali_obat" => "1.25" */
/*   "pasien_id" => "63448" */
/*   "jam" => "18:01:30" */
/*   "notified" => "" */
/*   "jam_periksa" => "12:38:12" */
/*   "tanggal" => "2022-07-15" */
/*   "bukan_peserta" => "0" */
/*   "poli_id" => "13" */
/*   "adatindakan" => "0" */
/*   "asisten_id" => "11" */
/*   "periksa_awal" => "{"tekanan_darah":"120\/80 mmHg","berat_badan":"","suhu":"","tinggi_badan":""}" */
/*   "antrian_periksa_id" => "203281" */
/*   "antrian_id" => "92772" */
/*   "keterangan_periksa" => "" */
/*   "dibantu" => "1" */
/*   "antrian" => "{"id":92772,"created_at":"2022-07-15T11:01:30.000000Z","updated_at":"2022-07-15T11:02:00.000000Z","jenis_antrian_id":1,"url":null,"nomor":131,"antriable_id":203 ?" */
/*   "berat_badan" => "" */
/*   "anamnesa" => "batuk pilek demam 3 hari" */
/*   "sistolik" => "120" */
/*   "diastolik" => "80" */
/*   "pemeriksaan_fisik" => "" */
/*   "pemeriksaan_penunjang" => "" */
/*   "diagnosa_id" => "10" */
/*   "keterangan_diagnosa" => "" */
/*   "presentasi" => "kepala tunggal hidup intrauterine" */
/*   "BPD_w" => "" */
/*   "BPD_d" => "" */
/*   "BPD_mm" => "" */
/*   "HC_w" => "" */
/*   "HC_d" => "" */
/*   "HC_mm" => "" */
/*   "LTP" => "" */
/*   "FHR" => "" */
/*   "AC_w" => "" */
/*   "AC_d" => "" */
/*   "AC_mm" => "" */
/*   "EFW" => "" */
/*   "FL_w" => "" */
/*   "FL_d" => "" */
/*   "FL_mm" => "" */
/*   "Sex" => "tak dpt dinilai" */
/*   "Plasenta" => "fundus grade 2 -3 tidak menutupi jalan lahir" */
/*   "total_afi" => "0 cm" */
/*   "kesimpulan" => "Janin presentasi kepala tunggal hidup intrauterine, denyut jantung janin normal  x/mnt,  lilitan tali pusat, perikiraan berat janin  gr, umur kehamilan menurut  ?" */
/*   "saran" => "periksa lagi 4 minggu lagi" */
/*   "ddlNamaObat" => "" */
/*   "ddlsigna" => "" */
/*   "ddlAturanMinum" => "" */
/*   "terapi" => "[{"merek_id":56,"signa":"2 x 1","aturan_minum":"Dihabiskan","jumlah":8,"periksa_id":56577,"rak_id":118,"merek_obat":"Mecoquin tablet 500 mg","harga_jual_ini":11 ?" */
/*   "transaksi" => "[]" */
/*   "resepluar" => "" */
/*   "G" => "" */
/*   "P" => "" */
/*   "A" => "" */
/*   "GPA" => "" */
/*   "hpht" => "" */
/*   "uk" => "" */
/*   "tb" => "" */
/*   "jumlah_janin" => "" */
/*   "nama_suami" => "" */
/*   "bb_sebelum_hamil" => "" */
/*   "tanggal_lahir_anak_terakhir" => "" */
/*   "golongan_darah" => "" */
/*   "rencana_penolong" => "" */
/*   "rencana_tempat" => "" */
/*   "rencana_pendamping" => "" */
/*   "rencana_transportasi" => "" */
/*   "rencana_pendonor" => "" */
/*   "inputBeratLahir" => "" */
/*   "inputTahunLahir" => "" */
/*   "riwayat_kehamilan" => "[]" */
/*   "td" => "120/80" */
/*   "bb" => "" */
/*   "tfu" => "" */
/*   "lila" => "" */
/*   "refleks_patela" => "6" */
/*   "djj" => "" */
/*   "kepala_terhadap_pap_id" => "7" */
/*   "presentasi_id" => "2" */
/*   "perujuk_id" => "" */
/*   "catat_di_kia" => "1" */
/*   "inj_tt" => "2" */
/*   "fe_tablet" => "2" */
/*   "periksa_hb" => "2" */
/*   "protein_urin" => "2" */
/*   "gula_darah" => "2" */
/*   "thalasemia" => "2" */
/*   "sifilis" => "2" */
/*   "hbsag" => "2" */
/*   "komplikasi_hdk" => "2" */
/*   "komplikasi_abortus" => "2" */
/*   "komplikasi_perdarahan" => "2" */
/*   "komplikasi_infeksi" => "2" */
/*   "komplikasi_kpd" => "2" */
/*   "komplikasi_lain_lain" => "" */
/*   "pmtct_konseling" => "2" */
/*   "pmtct_periksa_darah" => "2" */
/*   "pmtct_serologi" => "2" */
/*   "pmtct_arv" => "2" */
/*   "malaria_periksa_darah" => "2" */
/*   "malaria_positif" => "2" */
/*   "malaria_dikasih_obat" => "2" */
/*   "malaria_dikasih_kelambu" => "2" */
/*   "tbc_periksa_dahak" => "2" */
/*   "tbc_positif" => "2" */
/*   "tbc_dikasih_obat" => "2" */
/* ] */
/* [ */
/*     { */
/*         "jumlah":"10", */
/*         "merek_id":"56", */
/*         "rak_id":"118", */
/*         "harga_jual_ini":1100, */
/*         "formula_id":"55", */
/*         "merek_obat":"Mecoquin tablet 500 mg", */
/*         "fornas":"1", */
/*         "signa":"3 x 1", */
/*         "aturan_minum":"Dihabiskan" */
/*     }, */
/*     { */
/*         "jumlah":"10", */
/*         "merek_id":"34", */
/*         "rak_id":"78", */
/*         "harga_jual_ini":1500, */
/*         "formula_id":"119", */
/*         "merek_obat":"Alpara tablet", */
/*         "fornas":"0", */
/*         "signa":"3 x 1", */
/*         "aturan_minum":"Batuk pilek demam" */
/*     } */
/* ] */ 
