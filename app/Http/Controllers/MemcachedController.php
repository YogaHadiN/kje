<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use Illuminate\Contracts\Filesystem\Filesystem;
use Cache;
use Storage;
use App\Diagnosa;
use App\Tarif;
use App\Periksa;
use DB;
use App\Pengeluaran;
use App\Classes\Yoga;

class MemcachedController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * GET /memcached
	 *
	 * @return Reserikponse
	 */
	public function index()
	{
		$query = "alter table pengeluarans add column keterangan varchar(255) not null;";
		DB::statement($query);
		$query = "alter table pengeluarans drop column id;";
		DB::statement($query);
		$query = "alter table pengeluarans add column id int(11) auto_increment primary key;";
		DB::statement($query);
		$query = "alter table pengeluarans add column nilai int(11);";
		DB::statement($query);
		$query = "alter table pengeluarans add column supplier_id varchar(255);";
		DB::statement($query);
		$ids =[];
		foreach (Pengeluaran::all() as $pl) {
			$pl->nilai = (int)$pl->jumlah * (int) $pl->harga_satuan;
			$pl->supplier_id = $pl->fakturBelanja->supplier_id;
			$pl->keterangan = $pl->bukanObat->nama;
			$confirm = $pl->save();
			if ($confirm) {
				$ids[] = $pl->id;
			}
		}

		$query = "alter table pengeluarans drop column faktur_belanja_id;";
		DB::statement($query);
		$query = "alter table pengeluarans drop column jenis_pengeluaran_id;";
		DB::statement($query);
		$query = "alter table pengeluarans drop column harga_satuan;";
		DB::statement($query);
		$query = "alter table pengeluarans drop column jumlah;";
		DB::statement($query);
		$query = "alter table pengeluarans drop column bukan_obat_id;";
		DB::statement($query);
		//---------------- pendapatan
		//
		$query = "alter table pendapatans change keterangan `sumber_uang` varchar(255);";
		DB::statement($query);
		$query = "alter table pendapatans change biaya `nilai` int(11);";
		DB::statement($query);
		$query = "alter table pendapatans change pendapatan `keterangan` varchar(255);";
		DB::statement($query);
		$query = "alter table pendapatans drop column nota_jual_id;";
		DB::statement($query);
		$query = "delete from polis where id = 'kandungan';";
		DB::statement($query);
		$query = "update antrian_periksas set poli='anc' where poli='kandungan';";
		DB::statement($query);
		//---------------- pembelians
		//
		$query = "alter table pembelians drop column id";
		DB::statement($query);
		$query = "alter table pembelians add column id int(11) auto_increment primary key";
		DB::statement($query);
		$query = "alter table jenis_tarifs modify coa_id int(11) not null";
		DB::statement($query);

		return dd($ids);
    }



	public function data() {

		if (\Cache::has('pasien')) {
			return \Cache::get('pasien');
		} else {
			return 'Cache sudah expired';
		}

	}

}
