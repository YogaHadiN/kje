<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Moota;
use Log;
use Carbon\Carbon;
use App\Models\Rekening;
use App\Models\Invoice;
use App\Models\AkunBank;
use App\Models\Asuransi;
use App\Http\Controllers\PendapatansController;

class cekMutasi extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cek:mutasi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi Mandiri dengan sistem dengan transaksi bulan ini';

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

		$pendapatan = new PendapatansController;

		$banks       = Moota::banks();
		$kata_kuncis = $this->kata_kuncis();
		$timestamp = date('Y-m-d H:i:s');
		
		foreach ($banks['data'] as $bank) {
			$bank_id = $bank->bank_id;
			$newBank = AkunBank::findOrNew($bank_id);
			if ( !$newBank->id ) {
				$newBank->id             = $bank_id;
				$newBank->nomor_rekening = $bank->account_number;
				$newBank->akun           = $bank->bank_type;
				$newBank->save();
			}
			$mutasis = Moota::mutation( $newBank->id )->month()->toArray();
			$insertMutasi = [];
			foreach ($mutasis['data'] as $mutasi) {
				if ( $mutasi->type == 'CR' ) {
					$debet = 0;
				} else {
					$debet = 1;
				}
				$newRekening = Rekening::findOrNew($mutasi->mutation_id);
				if ( !$newRekening->id ) {
					$insertMutasi[] = [
						'id'           => $mutasi->mutation_id,
						'akun_bank_id' => $newBank->id,
						'tanggal'      => $mutasi->created_at,
						'deskripsi'    => $mutasi->description,
						'nilai'        => $mutasi->amount,
						'saldo_akhir'  => $mutasi->balance,
						'debet'        => $debet,
						'created_at'   => $timestamp,
						'updated_at'   => $timestamp
					];

					if (!$debet) {
						$pendapatan->input_dibayar           = $mutasi->amount;
						$pendapatan->input_staf_id           = 16;
						$pendapatan->input_tanggal_dibayar   = Carbon::createFromFormat('Y-m-d H:i:s', $mutasi->created_at)->format('d-m-Y');
						$pendapatan->input_coa_id            = 110001;
						$pendapatan->input_rekening_id       = $mutasi->mutation_id;
						$this->checkIfMatchKeyWord($kata_kuncis, $mutasi->description, $mutasi->amount, $pendapatan);
					}
				}
			}
			Rekening::insert($insertMutasi);
		}
		Log::info('==================================================================================================================================');
		Log::info('Cek Mutasi Selesai');
		Log::info('==================================================================================================================================');
    }
	public function kata_kuncis(){
		$asuransis = Asuransi::whereNotNull('kata_kunci')->get();

		$kata_kuncis = [];
		foreach ($asuransis as $asu) {
			if (!empty($asu->kata_kunci)) {
				$kata_kuncis[] = [
					'asuransi_id' => $asu->id,
					'kata_kunci'  => $asu->kata_kunci
				];
			}
		}
		return $kata_kuncis;
	}
	private function checkIfMatchKeyWord($kata_kuncis, $description, $nilai, $pendapatan){
		foreach ($kata_kuncis as $kk) {
			$kata_kunci = $kk['kata_kunci'];
			$asuransi_id = $kk['asuransi_id'];
			if (strpos($description, $kata_kunci )) { // jika ditemukan deskripsi sesuai dengan kata kunci
				$invoices = $pendapatan->invoicesQuery($asuransi_id, $nilai);
				if (count($invoices)) {
					$inv_id = $invoices[0]->invoice_id;

					$inv = Invoice::with('periksa')->where('id',$inv_id)->first();
					$pendapatan->input_asuransi_id       = $kk['asuransi_id'];
					$pendapatan->input_invoice_id        = [$inv_id];
					$pendapatan->input_mulai             = $inv->tanggal_mulai;
					$pendapatan->input_temp              = $this->tempInput($inv);
					$pendapatan->input_akhir             = $inv->tanggal_akhir;
					$pendapatan->input_catatan_container = '[]';

					$pendapatan->inputData(); //validasi dan input pembayaran asuransi secara otomatis ke sistem bila kata kunci cocok dan ditemukan invoice dengan jumlah yang sesuai
					Log::info('============================================');
					Log::info('Otomatis pembayaran asuransi masuk ke sistem');
					Log::info('============================================');
				} else {
					$this->sendEmailToProviderAskingPaymentDetail($asuransi_id); // Jika match keyword tapi tidak ada invoice yang jumalhnya sesuai, tanyakan detail kepada asuransi
				}
			}
		}

	}
	private function tempInput($inv){
		$periksas = $inv->periksa;
		$data              = [];
		foreach ($periksa as $pa) 
			$data[] = [
				'piutang_id'       => $pa->id,
				'periksa_id'       => $pa->id,
				'pasien_id'        => $pa->pasien_id,
				'nama_pasien'      => $pa->pasien->nama,
				'tunai'            => $pa->tunai,
				'piutang'          => $pa->piutang,
				'pembayaran'       => $pa->sudah_dibayar,
				'total_pembayaran' => null,
				'akan_dibayar'     => $pa->piutang - $pa->sudah_dibayar,
				'tanggal'          => $pa->tanggal,
				'sudah_dibayar'    => $pa->sudah_dibayar
			];
		return json_encode($data);
	}
	private function sendEmailToProviderAskingPaymentDetail($asuransi_id){
		Log::info('============================================');
		Log::info('Kirim email ke provider Tanyakan detail pembayaran');
		Log::info('============================================');
	}
}
