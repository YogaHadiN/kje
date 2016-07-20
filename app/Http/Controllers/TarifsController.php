<?php



namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use App\Classes\Yoga;

use App\Tarif;
use App\Merek;
use App\Asuransi;
use App\JenisTarif;

class TarifsController extends Controller
{

	/**
	 * Display a listing of tarifs
	 *
	 * @return Response
	 */
	public function index()
	{
		$tarifs = Tarif::with('jenisTarif.bhp.merek')->where('asuransi_id', '0')->get();

		$tipeTindakans = [
			'1' => 'Non Paket',
			'2' => 'Paket dengan Obat',
			'3' => 'Paket Jasa Dokter'
		];

		$mereks = Merek::with('rak.formula.komposisi.generik')->get();
		return view('tarifs.index', compact('tarifs', 'tipeTindakans', 'mereks'));
	}

	/**
	 * Show the form for creating a new tarif
	 *
	 * @return Response
	 */

	/**
	 * Store a newly created tarif in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Input::ajax()){

			$rules = [];
			$validator = \Validator::make($data = Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator)->withInput();
			}
			//coa_id didapatkan dari coa_id dari JenisTarif yang memiiki nilai paling besar lalu ditambah 1;
			$coa_id = (int) JenisTarif::orderBy('coa_id', 'desc')->first()->id + 1;
			//simpan JenisTarif baru;
			$jenis_tarif = new JenisTarif;
			$jenis_tarif->jenis_tarif = Input::get('jenis_tarif');
			$jenis_tarif->tipe_laporan_admedika_id = Input::get('tipe_laporan_admedika_id');
			$jenis_tarif->tipe_laporan_kasir_id = Input::get('tipe_laporan_kasir_id');
			$jenis_tarif->coa_id = $coa_id;
			$confirm = $jenis_tarif->save();

			//masukkan tarif2 menurut asuransinya.. 
			$asuransis = Asuransi::all();
			$asur = [];
			$timestamps = date('Y-m-d H:i:s');
			foreach ($asuransis as $asuransi) {
				$asur[] = [
					'biaya' =>  Input::get('biaya'), 
					'asuransi_id' =>  $asuransi->id, 
					'jenis_tarif_id' =>  $jenis_tarif->id, 
					'tipe_tindakan_id' =>  Input::get('tipe_tindakan_id'), 
					'jasa_dokter' =>  Input::get('jasa_dokter'), 
					'bhp_items' =>  Input::get('bhp_items'), 
					'created_at' =>  $timestamps, 
					'updated_at' =>  $timestamps
				];
			}
			$confirm = Tarif::insert($asur);
			if($confirm){
                $kembali = [
                    'id' => Tarif::latest()->first()->id,
                    'jenis_tarif_id' =>  $jenis_tarif->id
                ];
				return json_encode($kembali);
			} else {
				return '0';
			}

		}
	}

	/**
	 * Display the specified tarif.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tarif = Tarif::findOrFail($id);

		return view('tarifs.show', compact('tarif'));
	}

	/**
	 * Show the form for editing the specified tarif.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tarif = Tarif::find($id);

		return view('tarifs.edit', compact('tarif'));
	}

	/**
	 * Update the specified tarif in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{	

		// $jt = JenisTarif::findOrFail($id);
		// $jt->jenis_tarif = Input::get('jenis_tarif');
		// $jt->save();

		// $tarif = Tarif::where('jenis_tarif_id', $id)->where('asuransi_id', '0')->first();
		// $tarif->bahan_habis_pakai = Input::get('bahan_habis_pakai');
		// $tarif->biaya = Input::get('biaya');
		// $tarif->dibayar_asuransi = Input::get('biaya');
		// $tarif->tipe_tindakan_id = Input::get('tipe_tindakan_id');
		// $tarif->jasa_dokter = Input::get('jasa_dokter');
		// $tarif->save();


		$data = [
		Input::get('jenis_tarif'),
		Input::get('bahan_habis_pakai'),
		Input::get('biaya'),
		Input::get('biaya'),
		Input::get('tipe_tindakan_id'),
		Input::get('jasa_dokter')
		];

		return json_encode($data);

	}

	/**
	 * Remove the specified tarif from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		// hapus semua tarif yang memiliki jenis tarif yang sama
		// hapus tarif berlaku untuk semua asuransi 

		// return Tarif::find($id);
		// return $id;
		$jenis_tarif_id = Tarif::find($id)->jenis_tarif_id;
		// return $jenis_tarif_id;
		Tarif::where('jenis_tarif_id', $jenis_tarif_id)->delete();
		//jenis tarif nya dihapus juga
		$jf = JenisTarif::find($jenis_tarif_id);
		$jf->delete();


		return \Redirect::route('tarifs.index')->withPesan(Yoga::suksesFlash('Jenis tarif <strong>' .$jenis_tarif_id.  ' - ' .$jf->jenis_tarif. '</strong> berhasil <strong>dihapus</strong>'));
	}

}
