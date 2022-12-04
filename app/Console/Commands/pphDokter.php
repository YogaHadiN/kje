<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use DB;
use Log;
use App\Models\Pph21Dokter;
use App\Models\Staf;
use App\Http\Controllers\PengeluaransController;

class pphDokter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pph:dokter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perintah untuk generate pph dokter secara otomatis, pph akan generate secara otomatis setiap tanggal 2 setiap bulannya';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$bulanLalu = date("Y-m",strtotime("-1 month"));
		$bulan_kemarin = date("m",strtotime("-1 month"));
		$tahun_kemarin = date("Y",strtotime("-1 month"));
		$dokters = [];
		$query  = "SELECT px.staf_id as staf_id, ";
		$query .= "st.nama as nama, ";
		$query .= "st.menikah as menikah, ";
		$query .= "st.jenis_kelamin as jenis_kelamin, ";
		$query .= "st.kartu_keluarga as kartu_keluarga, ";
		$query .= "st.npwp as npwp, ";
		$query .= "st.jumlah_anak as jumlah_anak ";
		$query .= "FROM periksas as px ";
		$query .= "JOIN stafs as st on px.staf_id = st.id ";
		$query .= "WHERE px.created_at like '" .$bulanLalu."%' ";
        $tenant_id = is_null(session()->get('tenant_id')) ? 1 : session()->get('tenant_id');
		$query .= "AND px.tenant_id = " . $tenant_id . " ";
		$query .= "AND st.titel_id = 2 ";
		$query .= "AND st.gaji_tetap = 0 ";
		$query .= "GROUP BY px.staf_id ";

		$datas  = DB::select($query);

		$stafs  = [];
		$errors = [];
		$sukses = [];


		foreach ($datas as $d) {
			$catatan_pph_awal_tahun    = PPh21Dokter::where('tahun', $tahun_kemarin)
										->where('staf_id', $d->staf_id)
										->first();

			$menikah                   = $this->catatan_awal_tahun( $catatan_pph_awal_tahun, $d, 'menikah');
			$jumlah_anak               = $this->catatan_awal_tahun( $catatan_pph_awal_tahun, $d, 'jumlah_anak');
			$kartu_keluarga            = $this->catatan_awal_tahun( $catatan_pph_awal_tahun, $d, 'kartu_keluarga');
			$suami_bekerja             = $this->catatan_awal_tahun( $catatan_pph_awal_tahun, $d, 'suami_bekerja');

            $ada_penghasilan_lain  = null;

            $tenant_id = is_null(session()->get('tenant_id')) ? 1 : session()->get('tenant_id');
			if (is_null($ada_penghasilan_lain)) {
				$stafs[]                              = [
					'staf_id'                        => $d->staf_id,
					'bulan'                          => $bulan_kemarin,
					'tahun'                          => $tahun_kemarin,
					'jenis_kelamin'                  => $d->jenis_kelamin,
					'menikah'                        => $menikah,
					'npwp'                           => $d->npwp,
					'jumlah_anak'                    => $jumlah_anak,
					'pph21'                          => null,
					'potongan5persen_setahun'        => null,
					'potongan15persen_setahun'       => null,
					'potongan25persen_setahun'       => null,
					'potongan30persen_setahun'       => null,
					'penghasilan_bruto_setahun'      => null,
					'ptkp_dasar'                     => null,
					'penghasilan_kena_pajak_setahun' => null,
					'suami_bekerja'                  => $suami_bekerja,
					'tenant_id'                      => $tenant_id,
					'created_at'                     => date('Y-m-d H:i:s'),
					'updated_at'                     => date('Y-m-d H:i:s')
				];
			} else {
				$staf                                 = Staf::find($d->staf_id);
				$pph21                                = new PengeluaransController;
				$tanggal_potong                       = date('Y-m-t 23:59:59', strtotime("-1 month"));
				$pph21ini                             = $pph21->pph21dokter($staf, $tahun_kemarin, $tanggal_potong);
				$stafs[]                              = [
					'staf_id'                        => $d->staf_id,
					'bulan'                          => $bulan_kemarin,
					'tahun'                          => $tahun_kemarin,
					'jenis_kelamin'                  => $d->jenis_kelamin,
					'menikah'                        => $menikah,
					'npwp'                           => $d->npwp,
					'jumlah_anak'                    => $jumlah_anak,
					'pph21'                          => $pph21ini['pph21_kurang_bayar'],
					'potongan5persen_setahun'        => $pph21ini['potongan5persen'],
					'potongan15persen_setahun'       => $pph21ini['potongan15persen'],
					'potongan25persen_setahun'       => $pph21ini['potongan25persen'],
					'potongan30persen_setahun'       => $pph21ini['potongan30persen'],
					'penghasilan_bruto_setahun'      => $pph21ini['penghasilan_bruto_setahun'],
					'ptkp_dasar'                     => $pph21ini['ptkp_dasar'],
					'penghasilan_kena_pajak_setahun' => $pph21ini['ptkp_setahun'],
					'suami_bekerja'                  => $suami_bekerja,
					'tenant_id'                      => $tenant_id,
					'created_at'                     => date('Y-m-d H:i:s'),
					'updated_at'                     => date('Y-m-d H:i:s')
				];
			}
		}
		Pph21Dokter::insert($stafs);
    }
	private function catatan_awal_tahun($catatan_awal, $staf, $param){
		if (empty($catatan_awal->$param)) {
			return $staf->$param;
		} else {
			return $catatan_awal->$param;
		}
	}
}
