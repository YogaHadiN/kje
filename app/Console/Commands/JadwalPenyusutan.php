<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\BelanjaPeralatan;
use App\Models\BahanBangunan;
use App\Models\RingkasanPenyusutan;
use App\Models\Penyusutan;
use App\Models\InputHarta;
use App\Models\JurnalUmum;
use DB;
use Log;

class JadwalPenyusutan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:penyusutan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Penyusutan Peralatan';

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
		Log::info('JadwalPenyusutan');
		Log::info('Saat ini ' . date('Y-m-d H:i:s'));
		Log::info('Seharusnya muncul tiap akhir bulan jam 15:00');

		// Penyusutan berasal dari 3 table
		// I. Belanja Peralatan (dimana peralatan ini bisa langsung dipakai setelah dibeli)
		// II. Input Harta ( Harta yang bernilai besar dan bersertifikat misal : rumah / tanah )
		// III. Bahan Bangunan ( Yang bisa dihitunng adalah bahan bangunan yang renovasi nya sudah selesai )


		// 
		// I. Belanja Peralatan (dimana peralatan ini bisa langsung dipakai setelah dibeli)
		//
	

		$penyusutans                = [];
		$ringkasanPenyusutan        = [];
		$jurnals                    = [];
		try {
			$last_ringkasan_penyustan_id = RingkasanPenyusutan::orderBy('id', 'desc')->firstOrFail()->id;
		} catch (\Exception $e) {
			$last_ringkasan_penyustan_id = 0;
		}
		$arrays = $this->kumpulkanArray($last_ringkasan_penyustan_id, $penyusutans, $ringkasanPenyusutan, $jurnals,date('Y-m-t'));
		$ringkasanPenyusutan = $arrays['ringkasanPenyusutan'];
		$penyusutans         = $arrays['penyusutans'];
		$jurnals             = $arrays['jurnals'];
		RingkasanPenyusutan::insert($ringkasanPenyusutan);
		Penyusutan::insert($penyusutans);
		JurnalUmum::insert($jurnals);
    }
	public function kumpulkanArray(
		$last_ringkasan_penyustan_id,
	   	$penyusutans,
	   	$ringkasanPenyusutan,
	   	$jurnals,
		$tanggal // kenapa yang ini error ya? kalau baris ini dihilangkan everything okay ERROR : Constant expression contains invalid operations
	){
		$query  = "SELECT ";
		$query .= "bp.id as belanja_peralatan_id, ";
		$query .= "bp.peralatan as peralatan, ";
		$query .= "bp.harga_satuan as harga_satuan, ";
		$query .= "bp.jumlah as jumlah, ";
		$query .= "bp.masa_pakai as masa_pakai ";
		$query .= "FROM belanja_peralatans as bp ";
		$query .= "JOIN faktur_belanjas as fb on fb.id = bp.faktur_belanja_id ";
		$query .= "WHERE tanggal <= '{$tanggal}'";
		$query .= "AND tanggal >= '2017-12-01 00:00:00'";

		$peralatans = DB::select($query);

		$total_penyusutan_peralatan = 0;
		$timestamp                  = date('Y-m-d 23:59:59', strtotime($tanggal));

		$last_ringkasan_penyustan_id++;
		$ringkasanPenyusutan = $this->addRingkasanPenyusutanArray($ringkasanPenyusutan, $timestamp, $last_ringkasan_penyustan_id, 'Peralatan');
		foreach ($peralatans as $p) {
			//
			// 1. Hitung dlu semua penyusutan untuk barang ini
			//
			$sudah_disusutkan = 0;
			$susuts = Penyusutan::where('susutable_type', 'App\Models\BelanjaPeralatan')
								->where('susutable_id', $p->belanja_peralatan_id)
								->get();
			foreach ($susuts as $s) {
				$sudah_disusutkan += $s->nilai;
			}

			//
			// 2. hitung selisih antara harga perolehan dengan yang sudah disusutkan
			//
			
			$harga_perolehan                     = $p->harga_satuan * $p->jumlah ;
			$selisih_perolehan_dengan_penyusutan = $harga_perolehan - $sudah_disusutkan;
			if ( $selisih_perolehan_dengan_penyusutan > 0 ) {

				//
				//3. apabila selisih lebih dari 0, maka hitung penyusutan, lalu masukkan ke dalam array penyusutan
				//
				
				$nilai                          = $this->hitungPenyusutan($harga_perolehan, $p->masa_pakai, $selisih_perolehan_dengan_penyusutan);
				$keterangan                     = 'Penyusutan ' . $p->peralatan . ' bulan ' . date('M y', strtotime($tanggal)) . ' sebanyak ' . $p->jumlah . ' pcs';
				$penyusutans[]                  = [
					 'created_at'              => $timestamp,
					 'updated_at'              => $timestamp,
					 'keterangan'              => $keterangan,
					 'susutable_id'            => $p->belanja_peralatan_id,
					 'susutable_type'          => 'App\Models\BelanjaPeralatan',
					 'ringkasan_penyusutan_id' => $last_ringkasan_penyustan_id,
					 'nilai'                   => $nilai,
				];
				$total_penyusutan_peralatan += $nilai;
			}
		}
		//
		// 4. Masukkan ke dalam jurnal umum
		//
		
		$jurnals = $this->addJurnalPenyusutan($jurnals, $timestamp, $last_ringkasan_penyustan_id, $total_penyusutan_peralatan, 120002);

		//
		// II. Input Harta ( Harta yang bernilai besar dan bersertifikat misal : rumah / tanah )
		//
		$hartas = InputHarta::with('susuts')
			->whereRaw("tanggal_beli <= '" . $tanggal. "' and (tanggal_dijual >= '". $tanggal . "' or tanggal_dijual is null)")
			->where('tax_amnesty', 0)
			->where('created_at', '>=', '2017-12-01 00:00:00')
			->get();
			/* ->toSql(); */


		
		
		foreach ($hartas as $harta) {
			$bayarPenyusutan = $this->penyusutan($harta);
			$last_ringkasan_penyustan_id++;
			/* if ( $harta->coa_penyusutan_id == '120018' && $tanggal == '2019-10-30'	) { */
			$rekam = $this->rekamPenyusutan(
				$harta->harta, 
				$harta->id, 
				$last_ringkasan_penyustan_id, 
				$bayarPenyusutan,  // nilai penyusutan
				'Penyusutan ' . $harta->harta, // keterangan penyusutan
				$timestamp, // timestamp
				$harta->coa_penyusutan_id, // Akumulasi Penyusutan Peralatan, // coa_id akumulasi penyusutan
				$ringkasanPenyusutan, // array ringkasanPenyusutan
				$penyusutans, // array penyusutans
				$jurnals// array jurnal_umum
			);
			$jurnals             = $rekam['jurnals'];
			$ringkasanPenyusutan = $rekam['ringkasanPenyusutan'];
			$penyusutans         = $rekam['penyusutans'];
		}

		//
		// III. Bahan Bangunan ( Yang bisa dihitunng adalah bahan bangunan yang renovasi nya sudah selesai )
		//
		
		$bahans           = BahanBangunan::with('susuts')
							->where('tanggal_renovasi_selesai', '<=', $tanggal)
							->where('created_at', '>=', '2017-12-01 00:00:00')
							->get();
		$total_penyusutan = $this->penyusutanBahanBangunan($bahans);
		$total_penyusutan_bahan_bangunan = 0;
		if ($total_penyusutan > 0) {
			$last_ringkasan_penyustan_id++;
			$ringkasanPenyusutan = $this->addRingkasanPenyusutanArray($ringkasanPenyusutan, $timestamp, $last_ringkasan_penyustan_id, 'Bahan Bangunan');
			foreach ($bahans as $b) {
				$harga_perolehan = $b->harga_satuan * $b->jumlah;
				if ($b->bangunan_permanen) {
					$masa_pakai = 20;
				} else {
					$masa_pakai = 10;
				}
				$sudah_disusutkan = 0;
				foreach ($b->susuts as $a) {
					$sudah_disusutkan += $a->nilai;
				}
				$selisih_perolehan_dengan_penyusutan = $harga_perolehan - $sudah_disusutkan;
				if ($selisih_perolehan_dengan_penyusutan > 0) {
					$nilai                          = $this->hitungPenyusutan($harga_perolehan, $masa_pakai, $selisih_perolehan_dengan_penyusutan);
					$keterangan                     = 'Penyusutan ' . $b->keterangan;
					$penyusutans[]                  = [
						 'created_at'              => $timestamp,
						 'updated_at'              => $timestamp,
						 'keterangan'              => $keterangan,
						 'susutable_id'            => $b->id,
						 'susutable_type'          => 'App\Models\BahanBangunan',
						 'ringkasan_penyusutan_id' => $last_ringkasan_penyustan_id,
						 'nilai'                   => $nilai,
					];
					$total_penyusutan_bahan_bangunan += $nilai;
				}
			}
		}
		$jurnals = 	$this->addJurnalPenyusutan($jurnals, $timestamp, $last_ringkasan_penyustan_id, $total_penyusutan_bahan_bangunan, 120003);

		return compact(
			'ringkasanPenyusutan',
			'last_ringkasan_penyustan_id',
			'penyusutans',
			'jurnals'
		);
	}
	private function penyusutan($harta){
		$penyusutanPerBulan      = $harta->harga / ( $harta->masa_pakai * 12 );
		$penyusutans             = $harta->susuts;
		$penyusutanTerbayar      = 0;
		foreach ($penyusutans as $p) {
			$penyusutanTerbayar += $p->nilai;
		}
		$hargaSaatIni            = $harta->harga - $penyusutanTerbayar;
		return min([ $hargaSaatIni, $penyusutanPerBulan ]);
	}
	public function rekamPenyusutan(
		$keterangan, 
		$susutable_id, 
		$last_ringkasan_penyustan_id, 
		$total_penyusutan,  // nilai penyusutan
		$keteranganPenyusutan, // keterangan penyusutan
		$timestamp, // timestamp
		$coa_id_akumulasi_penyusutan, // coa_id akumulasi penyusutan
		$ringkasanPenyusutan, // array ringkasanPenyusutan
		$penyusutans, // array penyusutans
		$jurnals// array jurnal_umum
	){
		if ($total_penyusutan > 0) {
			$ringkasanPenyusutan = $this->addRingkasanPenyusutanArray($ringkasanPenyusutan, $timestamp, $last_ringkasan_penyustan_id, $keterangan);
			$penyusutans[]                      = [
				'nilai'                    => $total_penyusutan,
				'keterangan'               => $keteranganPenyusutan,
				'ringkasan_penyusutan_id' => $last_ringkasan_penyustan_id,
				'susutable_id'             => $susutable_id,
				'susutable_type'           => 'App\Models\InputHarta',
				'created_at'               => $timestamp,
				'updated_at'               => $timestamp
			];
			$jurnals[] = [
				'jurnalable_id'   => $last_ringkasan_penyustan_id,
				'jurnalable_type' => 'App\Models\RingkasanPenyusutan',
				'coa_id'          => 612312, //Biaya Penyusutan
				'debit'           => 1,
				'nilai'           => $total_penyusutan,
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp
			];
			$jurnals[] = [
				'jurnalable_id'   => $last_ringkasan_penyustan_id,
				'jurnalable_type' => 'App\Models\RingkasanPenyusutan',
				'coa_id'          => $coa_id_akumulasi_penyusutan, // Akumulasi Penyusutan Peralatan
				'debit'           => 0,
				'nilai'           => $total_penyusutan,
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp
			];
		}
		return [
			'ringkasanPenyusutan' => $ringkasanPenyusutan,
			'penyusutans' => $penyusutans,
			'jurnals'     => $jurnals,
		];
	}
	public function penyusutanBahanBangunan($bahans){
		$total_penyusutan                       = 0;
		foreach ($bahans as $b) {
			$total_penyusutan_per_item = 0;
			foreach ($b->susuts as $a) {
				$total_penyusutan_per_item += $a->nilai;
			}
			$harga_per_item = $b->harga_satuan * $b->jumlah;
			if ($harga_per_item - $total_penyusutan_per_item > 0) {
				if ($b->bangunan_permanen) {
					$masa_pakai                 = 20;
				} else {
					$masa_pakai                 = 10;
				}
				$penyusutan                     = $harga_per_item / ( 12 * $masa_pakai ); // penyusutan nilainya selalu dibagi 20 tahun untuk bahan bangunan
				$harga_sisa_setelah_penyusutan  = $harga_per_item - $b->penyusutan;
				$total_penyusutan              += min([$penyusutan, $harga_sisa_setelah_penyusutan ]);
			}
		}
		return $total_penyusutan;
	}
	private function hitungPenyusutan($harga_perolehan, $masa_pakai, $selisih_perolehan_dengan_penyusutan){
		try {
			$yang_harusnya_disusutkan = ceil($harga_perolehan / ( 12 * $masa_pakai ));
		} catch (\Exception $e) {
			dd($harga_perolehan, $masa_pakai, $selisih_perolehan_dengan_penyusutan);
		}
		return min([ $yang_harusnya_disusutkan, $selisih_perolehan_dengan_penyusutan ]);
	}
	private function addRingkasanPenyusutanArray($ringkasanPenyusutan, $timestamp, $id, $keterangan = 'Peralatan'){
		$ringkasanPenyusutan[] = [
			 'id'         => $id,
			 'keterangan' => 'Penyusutan ' . $keterangan . ' bulan ' . date('M y', strtotime($timestamp)),
			 'created_at' => $timestamp,
			 'updated_at' => $timestamp
		];
		return $ringkasanPenyusutan;
	}
	private function addJurnalPenyusutan($jurnals, $timestamp, $last_ringkasan_penyustan_id, $total_penyusutan_peralatan, $coa_id_penyusutan){
		if ($total_penyusutan_peralatan > 0) {
			$jurnals[] = [
				'jurnalable_id'   => $last_ringkasan_penyustan_id,
				'jurnalable_type' => 'App\Models\RingkasanPenyusutan',
				'coa_id'          => 612312, //Biaya Penyusutan
				'debit'           => 1,
				'nilai'           => $total_penyusutan_peralatan,
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp
			];
			$jurnals[] = [
				'jurnalable_id'   => $last_ringkasan_penyustan_id,
				'jurnalable_type' => 'App\Models\RingkasanPenyusutan',
				'coa_id'          => $coa_id_penyusutan, // Akumulasi Penyusutan Peralatan
				'debit'           => 0,
				'nilai'           => $total_penyusutan_peralatan,
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp
			];
		}
		return $jurnals;
	}
}


