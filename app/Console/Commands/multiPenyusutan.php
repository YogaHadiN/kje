<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Log;
use App\Models\RingkasanPenyusutan;
use App\Models\FakturBelanja;
use App\Models\BelanjaPeralatan;
use App\Models\Penyusutan;
use App\Models\Pengeluaran;
use App\Models\JurnalUmum;
use App\Models\InputHarta;
use App\Models\BahanBangunan;

class multiPenyusutan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:multiPenyusutan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Buat ulang semua penyusutan';

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

		//$peralatans                   = BelanjaPeralatan::with('fakturBelanja')->whereRaw('id between 4 and 34')->get();
		//$last_faktur_belanja_id       = FakturBelanja::orderBy('id', 'desc')->first()->id;
		//$peralatan_by_faktur_belanjas = [];
		//foreach ($peralatans as $p) {
			//$peralatan_by_faktur_belanjas[ $p->faktur_belanja_id ][] = $p;
		//}


		//foreach ($peralatan_by_faktur_belanjas as $k => $peralatans) {
			//$last_faktur_belanja_id++;
			//$faktur_belanja_ids[]                     = $k;
			//$nilai                                    = 0;
			//foreach ($peralatans as $p) {
				//$bahan_bangunans[]                    = [
					//'tanggal_renovasi_selesai'       => '2016-11-01 00:00:00',
					//'tanggal_terakhir_dikonfirmasi'  => '2016-11-01 00:00:00',
					//'bangunan_permanen'              => 1,
					//'keterangan'                     => $p->peralatan,
					//'faktur_belanja_id'              => $last_faktur_belanja_id,
					//'harga_satuan'                   => $p->harga_satuan,
					//'jumlah'                         => $p->jumlah,
					//'masa_pakai'                         => 20,
					//'created_at'                     => $p->fakturBelanja->tanggal,
					//'updated_at'                     => $p->fakturBelanja->tanggal
				//];
				//$nilai                               += $p->harga_satuan * $p->jumlah;
			//}
			//$faktur_image = $p->fakturBelanja->faktur_image;
			//$path                                     = '/var/www/kje/public/img/alat/' . $faktur_image;
			//if (file_exists($path) && is_file($path)) {
				//$faktur_image                             = 'faktur' . $last_pengeluaran_id . pathinfo($path)['extension'];
				//$newPath                              = '/var/www/kje/public/img/belanja/lain/'.$faktur_image;
				//copy($path, $newPath);
			//} else {
				//$faktur_image = null;
			//}

			//$faktur_belanjas[]           = [
				//'id'             => $last_faktur_belanja_id,
				//'tanggal'        => $p->fakturBelanja->tanggal,
				//'supplier_id'    => $p->fakturBelanja->supplier_id,
				//'submit'         => 1,
				//'nomor_faktur'   => $p->fakturBelanja->nomor_faktur,
				//'belanja_id'     => 6,
				//'created_at'     => $p->fakturBelanja->tanggal->format('Y-m-d H:i:s'),
				//'updated_at'     => $p->fakturBelanja->tanggal->format('Y-m-d H:i:s'),
				//'sumber_uang_id' => $p->fakturBelanja->sumber_uang_id,
				//'faktur_image'   => $faktur_image,
				//'petugas_id'     => $p->fakturBelanja->petugas_id,
				//'diskon'         => $p->fakturBelanja->diskon
			//];
			//$jurnals[] = [
				//'jurnalable_id'   => $last_faktur_belanja_id,
				//'jurnalable_type' => 'App\FakturBelanja',
				//'debit'           => 1,
				//'coa_id'          => '120010', // Belanja Peralatan Bahan Bangunan
				//'nilai'           => $nilai,
				//'created_at'      => $p->fakturBelanja->tanggal->format('Y-m-d H:i:s'),
				//'updated_at'      => $p->fakturBelanja->tanggal->format('Y-m-d H:i:s')
			//];
			//$jurnals[] = [
				//'jurnalable_id'   => $last_faktur_belanja_id,
				//'jurnalable_type' => 'App\FakturBelanja',
				//'debit'           => 0,
				//'coa_id'          => $p->fakturBelanja->sumber_uang_id,
				//'nilai'           => $nilai,
				//'created_at'      => $p->fakturBelanja->tanggal->format('Y-m-d H:i:s'),
				//'updated_at'      => $p->fakturBelanja->tanggal->format('Y-m-d H:i:s')
			//];
		//}
		//JurnalUmum::where('jurnalable_type', 'App\FakturBelanja')->whereIn('jurnalable_id', $faktur_belanja_ids)->delete();
		//FakturBelanja::destroy($faktur_belanja_ids);
		//FakturBelanja::insert($faktur_belanjas);
		//BahanBangunan::insert($bahan_bangunans);
		//BelanjaPeralatan::whereRaw('id between 4 and 34')->delete();
		//
		//
		//
		//



		Penyusutan::truncate();
		RingkasanPenyusutan::truncate();
		JurnalUmum::where('jurnalable_type', 'App\Models\RingkasanPenyusutan')->delete();


		$faktur_belanja_ids = [];
		$faktur_belanjas    = [];
		$jurnals            = [];
		$bahan_bangunans    = [];

		//penyusutan

		$query    = "SELECT tanggal from belanja_peralatans as bp ";
		$query   .= "JOIN faktur_belanjas as fb on fb.id = bp.faktur_belanja_id ";
		$query   .= "ORDER BY tanggal limit 1";
        $tenant_id = is_null(session()->get('tenant_id')) ? 1 : session()->get('tenant_id');
		$query   .= "AND tenant_id = " . $tenant_id . " ";
		$tanggal  = DB::select($query)[0]->tanggal;
		try {
			$tanggal_beli      = InputHarta::orderBy('tanggal_beli', 'desc')->firstOrFail()->tanggal_beli;
		} catch (\Exception $e) {
			$tanggal_beli      = null;
		}

		try {
			$tanggal_renovasi  = BahanBangunan::orderBy('tanggal_renovasi_selesai', 'desc')->firstOrFail()->tanggal_renovasi_selesai;
		} catch (\Exception $e) {
			$tanggal_renovasi  = null;
		}

		$tanggal = [
			$tanggal,
			$tanggal_beli,
			$tanggal_renovasi
		];

		$tanggal                     = min($tanggal);
		$tanggal                     = date('Y-m-01', strtotime($tanggal));
		$awal_tanggal_ini            = date('Y-m-01');
		$array_months                = [];
		$penyusutans                 = [];
		$ringkasanPenyusutan         = [];

		try {
			$last_ringkasan_penyustan_id = RingkasanPenyusutan::orderBy('id', 'desc')->firstOrFail()->id;
		} catch (\Exception $e) {
			$last_ringkasan_penyustan_id = 0;
		}

		$susutkan = new JadwalPenyusutan;
		for ($i = 0; $tanggal < $awal_tanggal_ini; $i++) {
			$tanggal_input = date('Y-m-t', strtotime($tanggal));
			$arrays        = $susutkan->kumpulkanArray(
				$last_ringkasan_penyustan_id,
				$penyusutans,
				$ringkasanPenyusutan,
				$jurnals,
				$tanggal_input
			);
			$array_months[] = $tanggal_input;
			$tanggal                     = date('Y-m-d', strtotime( "+1 month", strtotime( $tanggal ) )) ;
			$jurnals                     = $arrays['jurnals'];
			$penyusutans                 = $arrays['penyusutans'];
			$ringkasanPenyusutan         = $arrays['ringkasanPenyusutan'];
			$last_ringkasan_penyustan_id = $arrays['last_ringkasan_penyustan_id'];

		}
		foreach (array_chunk($ringkasanPenyusutan,1000) as $t)  
		{
			RingkasanPenyusutan::insert($t);
		}
		foreach (array_chunk($penyusutans,1000) as $t)  
		{
			Penyusutan::insert($t);
		}
		foreach (array_chunk($jurnals,1000) as $t)  
		{
			JurnalUmum::insert($t);
		}

    }
}
