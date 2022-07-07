<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use Input;
use Arr;
use Auth;
use Carbon\Carbon;
use App\Models\Classes\Yoga;
use DB;
use App\Http\Controllers\AsuransisController;
use App\Http\Controllers\PdfsController;
use App\Http\Controllers\PasiensController;
use App\Http\Requests;
use App\Models\AkunBank;
use App\Models\DenominatorBpjs;
use App\Models\PesertaBpjsPerbulan;
use App\Models\Config;
use App\Models\Asuransi;
use App\Models\AntrianPeriksa;
use App\Models\Periksa;
use App\Models\BayarDokter;
use App\Models\BayarGaji;
use App\Models\TransaksiPeriksa;
use App\Models\PembayaranAsuransi;
use App\Models\Staf;
use App\Models\JurnalUmum;
use App\Models\NotaJual;
use App\Models\Coa;
use App\Models\FakturBelanja;
use App\Models\SmsBpjs;
use App\Models\PcareSubmit;
use App\Models\PengantarPasien;
use App\Models\Terapi;
use App\Models\SmsKontak;
use App\Models\SmsGagal;
use App\Models\AntrianPoli;
use App\Models\JenisTarif;
use App\Models\KunjunganSakit;
use App\Models\TipeLaporanAdmedika;
use App\Models\TipeLaporanKasir;
use App\Models\Rak;
use App\Models\Pendapatan;
use App\Models\User;
class LaporansControllerTest extends TestCase
{
	public function test_index_displays_view(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('stafs');
        $response->assertStatus(200);
	}
    public function test_bpjsTidakTerpakai(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/bpjs_tidak_terpakai/' . date('m-Y'));
        $response->assertStatus(200);
    }
    public function test_pengantar(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/pengantar');
        $response->assertStatus(200);
    }
    public function test_harian(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/harian?' . Arr::query([
                'asuransi_id' => 32,
                'tanggal'     => date('d-m-Y')
        ]));
        $response->assertStatus(200);
    }
    public function test_haridet(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/haridet?' . Arr::query([
                'asuransi_id' => 32,
                'tanggal'     => date('d-m-Y')
        ]));
        $response->assertStatus(200);
    }
    public function test_harikas(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/harikas?' . Arr::query([
                'asuransi_id' => 32,
                'tanggal'     => date('d-m-Y')
        ]));
        $response->assertStatus(200);
    }
    public function test_bulanan(){

        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/bulanan?' . Arr::query([
                'asuransi_id' => 32,
                'bulanTahun'     => date('m-Y')
        ]));
        $response->assertStatus(200);
    }
    public function test_tanggal(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/tanggal?' . Arr::query([
                'asuransi_id' => 32,
                'bulanTahun'     => date('m-Y')
        ]));
        $response->assertStatus(200);
    }
    public function test_detbulan(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/detbulan?' . Arr::query([
                'asuransi_id' => '%',
                'bulanTahun'     => date('m-Y')
        ]));
        $response->assertStatus(200);
    }

    public function test_penyakit(){

        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/penyakit?' . Arr::query([
                'asuransi_id' => '%',
                'mulai'     => date('01-m-Y'),
                'akhir'     => date('t-m-Y')
        ]));
        $response->assertStatus(200);
    }

    public function test_status(){

        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/penyakit?' . Arr::query([
                'staf_id' => '11',
                'mulai'     => date('01-m-Y'),
                'akhir'     => date('t-m-Y')
        ]));
        $response->assertStatus(200);
    }

	public function test_points(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/points?' . Arr::query([
                'mulai'     => date('01-m-Y'),
                'akhir'     => date('t-m-Y')
        ]));
        $response->assertStatus(200);
    }

    public function test_pendapatan(){
        $user     = User::find(28);
		auth()->login($user);

        $response = $this->post('laporans/pendapatan' ,[
                'mulai'     => date('01-m-Y'),
                'akhir'     => date('t-m-Y')
        ]);
        $response->assertStatus(200);
    }

    public function test_rujukankebidanan(){
        $user     = User::find(28);

		auth()->login($user);

        $response = $this->get('laporans/rujukankebidanan?'. Arr::query([
                'mulai'     => date('01-m-Y'),
                'akhir'     => date('t-m-Y')
        ]));
        $response->assertStatus(200);
    }

    public function test_bayardokter(){
        $user     = User::find(28);

		auth()->login($user);

        $response = $this->get('laporans/bayardokter?'. Arr::query([
                'id'    => 16,
                'mulai' => date('01-m-Y'),
                'akhir' => date('t-m-Y')
        ]));
        $response->assertStatus(200);
    }

    public function test_no_asisten(){
        $user     = User::find(28);

		auth()->login($user);

        $response = $this->get('laporans/no_asisten?'. Arr::query([
                'bulanTahun'     => date('m-Y')
        ]));
        $response->assertStatus(200);
    }

    public function test_gigiBulanan(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/gigi?'. Arr::query([
                'bulanTahun'     => date('m-Y')
        ]));
        $response->assertStatus(200);
    }

    public function test_anc(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/anc?'. Arr::query([
                'bulanTahun'     => date('m-Y')
        ]));
        $response->assertStatus(200);
    }

    public function test_kb(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/kb?'. Arr::query([
                'bulanTahun'     => date('m-Y')
        ]));
        $response->assertStatus(200);
    }

    public function test_jumlahPasien(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/jumlahPasien?'. Arr::query([
                'bulanTahun'     => date('m-Y')
        ]));
        $response->assertStatus(200);
    }

    public function test_jumlahIspa(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/jumlahIspa?'. Arr::query([
                'asuransi_id' => '%',
                'mulai'     => date('01-m-Y'),
                'akhir'     => date('t-m-Y')
        ]));
        $response->assertStatus(200);
    }

    public function test_JumlahDiare(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/jumlahDiare?'. Arr::query([
                'asuransi_id' => '%',
                'mulai'     => date('01-m-Y'),
                'akhir'     => date('t-m-Y')
        ]));
        $response->assertStatus(200);
    }
    public function test_hariandanjam(){
        $user     = User::find(28);
		auth()->login($user);

        $response = $this->get('laporans/hariandanjam?'. Arr::query([
                'tanggal_awal'     => date('01-m-Y'),
                'tanggal_akhir'     => date('t-m-Y')
        ]));
        $response->assertStatus(200);
    }
    public function test_smsBpjs(){
        $user     = User::find(28);
		auth()->login($user);

        $response = $this->get('laporans/sms/bpjs?'. Arr::query([
                'bulanTahun'     => date('m-Y')
        ]));
        $response->assertStatus(200);
    }
    public function test_dispensingBpjs(){
        $user     = User::find(28);
		auth()->login($user);

        $response = $this->post('laporans/dispensing/bpjs/dokter', [
            'mulai'     => date('m-Y')
        ]);
        $response->assertStatus(200);
    }
    public function test_jumlahPenyakitTBCTahunan(){
        $user     = User::find(28);
		auth()->login($user);

        $response = $this->get('laporans/jumlahPenyakitTBCTahunan?'. Arr::query([
                'tahun'     => date('Y')
        ]));
        $response->assertStatus(200);

    }
    public function test_jumlahPenyakitDM_HT(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/jumlahPenyakit_DM_HT?'. Arr::query([
                'bulanTahun'     => date('m-Y')
        ]));
        $response->assertStatus(200);
    }
    public function test_angkaKontakBelumTerpenuhi(){

        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/angka_kontak_belum_terpenuhi');
        $response->assertStatus(200);

    }
    public function test_angkaKontakBpjs(){

        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/angka_kontak_bpjs');
        $response->assertStatus(200);


    }
	public function test_PengantarPasienBpjs(){

        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/pengantar_pasien');
        $response->assertStatus(200);


    }
	public function test_KunjunganSakitBpjs(){

        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/kunjungan_sakit');
        $response->assertStatus(200);


    }
    public function test_angkaKontakBpjsBulanIni(){
        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/angka_kontak_bpjs_bulan_ini');
        $response->assertStatus(200);
    }
    public function cariTransaksi(){

        $user     = User::find(28);
		auth()->login($user);
        $response = $this->get('laporans/cari_transaksi');
        $response->assertStatus(200);

    }
    /* public function payment($id) */
    /* public function paymentpost() */
}
