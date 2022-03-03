<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Moota;
use Log;
use Carbon\Carbon;
use DB;
use App\Models\Rekening;
use App\Models\Invoice;
use App\Http\Controllers\PendapatansController;
use App\Models\AkunBank;
use App\Models\Periksa;

class cekMutasi19Terakhir extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cek:mutasi20terakhir';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek 20 transaksi terakhir';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
		$this->input_periksas = [];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

	public $amount;
	public $created_at;
	public $mutation_id;
	public $input_periksas;
    public function handle()
    {
		//define semua bank yang ada
		//
		Log::info('==================================================================================================================================');
		Log::info('Cek Mutasi Dilakukan');
		Log::info('==================================================================================================================================');

		$banks                = Moota::banks();
		$mutation_ids         = [];
		$desc                 = [];
		$checked_transaction  = [];
		$inserted_description = [];
		$timestamp            = date('Y-m-d H:i:s');
		$insertMutasi         = [];
		foreach ($banks['data'] as $bank) {
			$bank_id = $bank->bank_id;
			$newBank = AkunBank::firstOrCreate([
				'id' => $bank_id
			],[
				'id'             => $bank_id,
				'nomor_rekening' => $bank->account_number,
				'akun'           => $bank->bank_type
			]);
			$mutasis = Moota::mutation( $newBank->id )->latest(19)->toArray();
			$insertKredit = [];
			foreach ($mutasis as $mutasi) {
				if ( $mutasi->type == 'CR' ) {
					$debet = 0;
				} else {
					$debet = 1;
				}

				$mutation_ids[] = $mutasi->mutation_id;
				$newRekening    = Rekening::find($mutasi->mutation_id);
				if ( !isset( $newRekening->id ) ) {

					$pembayaran_asuransi_id = null;

					// cari kata asuransi yang cocok kata kunci nya sesuai deskripsi mutasi
					//

					if ($debet == 0) {
						$desc[] = $mutasi->description;

						$query  = "select ";
						$query .= "invoice_id, ";
						$query .= "sum(piutang) - sum(sudah_dibayar) as sisa ";
						$query .= "FROM (";
						$query .= "select ";
						$query .= "prx.piutang as piutang, ";
						$query .= "prx.invoice_id as invoice_id, ";
						$query .= "COALESCE(SUM(pdb.pembayaran),0) as sudah_dibayar ";
						$query .= "from periksas as prx ";
						$query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
						$query .= "JOIN invoices as inv on inv.id = prx.invoice_id ";
						$query .= "JOIN kirim_berkas as krm on krm.id = inv.kirim_berkas_id ";
						$query .= "LEFT JOIN piutang_dibayars as pdb on pdb.periksa_id = prx.id ";
						$query .= "WHERE INSTR('{$mutasi->description}' , asu.kata_kunci ) ";
						$query .= "AND kata_kunci not like '' ";
						$query .= "AND krm.tanggal < '{$mutasi->created_at}' ";
						$query .= "AND krm.tanggal >= '" . date("Y-m-d", strtotime("-6 months")). "' ";
						$query .= "group by prx.id ";
						$query .= ") bl ";
						$query .= "group by invoice_id ";
						$query .= "HAVING sisa = {$mutasi->amount} ";
						$data   = DB::select($query);

						$inserted_description[] = $mutasi->description;

						$this->amount      = $mutasi->amount;
						$this->created_at  = $mutasi->created_at;
						$this->mutation_id = $mutasi->mutation_id;
						$description = $mutasi->description;

						if (
							count($data) == 1 //jika ditemukan 1 data
						) {
							$data                   = $data[0];
							$invoice_id             = $data->invoice_id;
							$pembayaran_asuransi_id = $this->validatePembayaran($invoice_id);
						} else if(
							str_contains( $description, ' INV/')	//deskripsi mengandung INV/
						){
							$invoice_description = $this->getInvoiceFromDescription($description);
							$invoices             = Invoice::where('id', 'like', $invoice_description . '%')->get();
							if (
								$invoices->count() == 1 && //jika ditemukan 1 data
								$invoices->first()->detail['total_tagihan'] == $this->amount // jumlah tagihannya sama
							) {
								$invoice_id             = $invoices->first()->id;
								$pembayaran_asuransi_id = $this->validatePembayaran($invoices->first()->id);
							}
						} else {
							$query  = "SELECT * ";
							$query .= "FROM asuransis asu ";
							$query .= "WHERE INSTR('{$description}' , asu.kata_kunci ) ";
							$query .= "AND kata_kunci not like '' ";
							$matched_insurance = DB::select($query);

							if (count($matched_insurance) > 0) {
								//email masing2 asuransi
								//wa masing2 pic asuransi pada jam dan hari kerja
							}
						}
					}
					$insertMutasi[] = [
						'id'                     => $mutasi->mutation_id,
						'akun_bank_id'           => $newBank->id,
						'tanggal'                => $mutasi->created_at,
						'pembayaran_asuransi_id' => $pembayaran_asuransi_id,
						'deskripsi'              => $mutasi->description,
						'nilai'                  => $mutasi->amount,
						'saldo_akhir'            => $mutasi->balance,
						'debet'                  => $debet
					];
				}
			}
		}
		Rekening::insert($insertMutasi);
		Log::info('==================================================================================================================================');
		Log::info('Cek Mutasi Selesai');
		Log::info('==================================================================================================================================');
    }
	/**
	* undocumented function
	*
	* @return void
	*/
	private function getInvoiceFromDescription($description)
	{
		$words = explode(' ', $description);
		foreach ($words as $word) {
			if (str_contains( $word, 'INV/')) {
				return $word;
			}
		}
		return '';
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function validatePembayaran($invoice_id) {
		$periksas    = Periksa::with('asuransi', 'pembayarans')
								->where('invoice_id', $invoice_id)
								->orderBy('tanggal', 'asc')
								->get();
		$piutang_dibayars = [];

		$pend = new PendapatansController;
		$pend->input_dibayar           = $this->amount;
		$pend->input_mulai             = $periksas->first()->tanggal;
		$pend->input_staf_id           = 16;
		$pend->input_akhir             = $periksas->last()->tanggal;
		$pend->input_tanggal_dibayar   = Carbon::parse($this->created_at)->format('d-m-Y');
		$pend->input_asuransi_id       = $periksas->first()->asuransi_id;
		$pend->input_coa_id_asuransi   = $periksas->first()->asuransi->coa_id;
		$pend->input_coa_id            = '110001';
		$pend->input_catatan_container = 'Done by system';
		$pend->input_rekening_id       = $this->mutation_id;
		$pend->input_invoice_id        = [$invoice_id];
		$pend->input_temp              = [];
		foreach ($periksas as $prx){
			$akan_dibayar = $prx->piutang - $prx->sudah_dibayar;
			$pend->input_temp[] =  [ 
				'piutang_id'   => $prx->id,
				'periksa_id'   => $prx->id,
				'pasien_id'    => $prx->pasien_id,
				'tunai'        => $prx->tunai,
				'invoice_id'   => $prx->invoice_id,
				'piutang'      => $prx->piutang,
				'tanggal'      => $prx->tanggal,
				'pembayaran'   => $prx->sudah_dibayar,
				'akan_dibayar' => $akan_dibayar
			];
		}
		$pend->input_temp       = json_encode($pend->input_temp);
		$this->input_periksas[] = $pend;
		$pb                     = $pend->inputData();
		$pembayaran_asuransi_id = $pb['pb']->id;
		return $pembayaran_asuransi_id;
	}
}
