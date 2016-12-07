<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\FakturBelanja;
use App\Pengeluaran;
use App\User;
use DB;
use App\Supplier;
use App\Dispensing;
use App\Pembelian;
use App\JurnalUmum;
use App\Classes\Yoga;


class FakturBelanjasController extends Controller
{


	/**
	 * Display a listing of the resource.
	 * GET /fakturbelanjas
	 *
	 * @return Response
	 */
	public function index()
	{
		$fakturbelanjas = FakturBelanja::where('submit', '0')->get();
		$stafs = Yoga::staflist();
		$suppliers = Yoga::supplierList();
		return view('fakturbelanjas.index', compact('fakturbelanjas', 'stafs', 'suppliers'));
	}
	public function obat(){
		$query  = "SELECT pb.faktur_belanja_id as faktur_belanja_id, ";
		$query .= "fb.nomor_faktur as nomor_faktur, ";
		$query .= "fb.tanggal as tanggal, ";
		$query .= "sp.nama as nama_supplier, ";
		$query .= "co.coa as sumber_uang, ";
		$query .= "st.nama as nama_staf, ";
		$query .= "sum(pb.harga_beli * pb.jumlah) as total ";
		$query .= "FROM pembelians as pb ";
		$query .= "JOIN faktur_belanjas as fb on fb.id = pb.faktur_belanja_id ";
		$query .= "JOIN stafs as st on st.id = fb.petugas_id ";
		$query .= "JOIN suppliers as sp on sp.id = fb.supplier_id ";
		$query .= "JOIN coas as co on co.id = fb.sumber_uang_id ";
		$query .= "GROUP BY pb.faktur_belanja_id ";
		$query .= "ORDER BY fb.tanggal desc;";
		$fakturbelanjas = DB::select($query);
		//$fakturbelanjas = FakturBelanja::with('staf', 'supplier', 'belanja', 'pembelian.coa')
								//->where('belanja_id', 1)
								//->orderBy('tanggal', 'desc')
								//->get();
		return view('fakturbelanjas.cari', compact('fakturbelanjas'));
	}

	public function store(){
		$rules = [
			'tanggal' => 'required',
			'nomor_faktur' => 'required',
			'belanja_id' => 'required',
			'supplier_id' => 'required',
		];
		$validator = \Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$count = FakturBelanja::where('supplier_id', Input::get('supplier_id'))
					->where('nomor_faktur', Input::get('nomor_faktur'))
					->where('tanggal', Yoga::datePrep(Input::get('tanggal')))
					->first();
		if (count($count) > 0 && $count->belanja_id == 1) {
			$faktur = $count;
			$faktur->submit = '0';
			$faktur->save();
		} else {
			$faktur = new FakturBelanja;
			$faktur->tanggal = Yoga::datePrep(Input::get('tanggal'));
			$faktur->nomor_faktur = Input::get('nomor_faktur');
			$faktur->belanja_id = Input::get('belanja_id');
			$faktur->supplier_id = Input::get('supplier_id');
			$faktur->save();
		}
		return redirect('fakturbelanjas')->withPesan(Yoga::suksesFlash('<strong>Faktur Baru</strong> berhasil dibuat'));
	}


	public function destroy($id){
		$faktur = FakturBelanja::find($id);
		$supplier = $faktur->supplier->nama;
		if ($faktur->belanja_id == 1 && $faktur->pembelian->count() > 0 ) {
			$dispensable_ids = [];
			foreach ($faktur->pembelian as $v) {
				$rak = $v->merek->rak;
				$rak->stok = $rak->stok - $v->jumlah;
				$confirm = $rak->save();
				if ($confirm) {
					if (Dispensing::where('dispensable_type', 'App\Pembelian')->where('dispensable_id', $v->id)->first() != null) {
						$dispensable_ids[] = Dispensing::where('dispensable_type', 'App\Pembelian')->where('dispensable_id', $v->id)->first()->id;
					}	
				}
			}
			Pembelian::where('faktur_belanja_id', $id)->delete();
			Dispensing::destroy($dispensable_ids);
		} else if ($faktur->belanja_id == 3 && $faktur->pengeluaran->count() > 0) {
			$faktur->pengeluaran()->delete();
		}
		JurnalUmum::where('jurnalable_type', 'App\FakturBelanja')->where('jurnalable_id', $id)->delete();
		$confirm = $faktur->delete();
		if ($confirm) {
			return redirect('fakturbelanjas')->withPesan(Yoga::suksesFlash('Faktur Belanja di <strong>' . $supplier . '</strong> berhasil dihapus'));
		} else {
			return redirect('fakturbelanjas')->withPesan(Yoga::gagalFlash('Faktur Belanja di <strong>' . $supplier . '</strong> gagal dihapus'));
		}
	}
	public function alat(){
		$fakturbelanjas = FakturBelanja::with('staf', 'supplier', 'belanja', 'belanjaPeralatan')->where('belanja_id', 4)->latest()->get();
		return view('fakturbelanjas.alat', compact('fakturbelanjas'));
	}
	
}
