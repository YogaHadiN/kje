<?php


namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use App\Asuransi;
use App\Tarif;
use App\Coa;
use App\Classes\Yoga;
use DB;


class AsuransisController extends Controller
{

   public function __construct()
    {
        $this->middleware('super', ['only' => 'delete']);
    }
	/**
	 * Display a listing of asuransis
	 *
	 * @return Response
	 */
	public function index()
	{
		$asuransis = Asuransi::where('id', '>', 0)->get();

		$asur = [];

		foreach ($asuransis as $key => $asu) {
			$asur[] = [
				'belum' => $asu->belum,
				'id' => $asu->id,
				'nama' => $asu->nama,
				'alamat' => $asu->alamat,
				'pic' => $asu->pic,
				'hp_pic' => $asu->hp_pic
			];
		}
		
		usort($asur, function($a,$b){return $b['belum']-$a['belum'];});
		$asuransis = $asur;

		return view('asuransis.index', compact('asuransis'));
	}

	/**
	 * Show the form for creating a new asuransi
	 *
	 * @return Response
	 */
	public function create()
	{	
		$tarifs = Tarif::where('asuransi_id', '0')->get()	;
		return view('asuransis.create', compact('tarifs'));
	}

	/**
	 * Store a newly created asuransi in storage.
	 *
	 * @return Response
	 */
	public function store()
	{


		$asuransi_id = Yoga::customId('App\Asuransi');
		$asuransi = new Asuransi;
		$asuransi->id = $asuransi_id;
		$asuransi->alamat = Input::get('alamat');
		$asuransi->tipe_asuransi = Input::get('tipe_asuransi');
		$asuransi->nama = ucwords(strtolower(Input::get('nama')));
		$asuransi->hp_pic = Input::get('hp_pic');
		$asuransi->no_telp = Input::get('no_telp');
		$asuransi->email = Input::get('email');
		$asuransi->pic = Input::get('pic');
		$asuransi->kali_obat = 1.25;
		$asuransi->tanggal_berakhir = Yoga::datePrep(Input::get('tanggal_berakhir'));
		$asuransi->umum = Yoga::cleanArrayJson(Input::get('umum'));
		$asuransi->gigi = Yoga::cleanArrayJson(Input::get('gigi'));
		$asuransi->rujukan = Yoga::cleanArrayJson(Input::get('rujukan'));
		$asuransi->penagihan = Yoga::cleanArrayJson(Input::get('penagihan'));

		$coa_id = (int)Coa::where('id', 'like', '111%')->orderBy('id', 'desc')->first()->id + 1;
		$coa       = new Coa;
		$coa->id   = $coa_id;
		$coa->kelompok_coa_id   = '11';
		$coa->coa   = 'Piutang Asuransi ' . $asuransi->nama;
		$coa->save();

		$asuransi->coa_id = $coa_id;
		$asuransi->save();

		$tarifs = Input::get('tarifs');
		$tarifs = json_decode($tarifs, true);

		$data = [];

		foreach ($tarifs as $tarif_pribadi) {
			$data [] = [
				'biaya' => $tarif_pribadi['biaya'], 
				'asuransi_id' => $asuransi_id,
				'jenis_tarif_id' => $tarif_pribadi['jenis_tarif_id'],
				'tipe_tindakan_id' => $tarif_pribadi['tipe_tindakan_id'],
				'bhp_items' => $tarif_pribadi['bhp_items'],
				'jasa_dokter' => $tarif_pribadi['jasa_dokter'],
				'jasa_dokter_tanpa_sip' => $tarif_pribadi['jasa_dokter']
			];
		}



		Tarif::insert($data);
		return \Redirect::route('asuransis.index')->withPesan(Yoga::suksesFlash('<strong>Asuransi ' . ucwords(strtolower(Input::get('nama')))  .'</strong> berhasil dibuat'));
	}

	/**
	 * Display the specified asuransi.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$asuransi = Asuransi::findOrFail($id);

		return view('asuransis.show', compact('asuransi'));
	}

	/**
	 * Show the form for editing the specified asuransi.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$asuransi = Asuransi::find($id);
		$tarifs = Tarif::where('asuransi_id', $id)->get();
		return view('asuransis.edit', compact(
			'asuransi', 
			'tarifs'
		));
	}

	/**
	 * Update the specified asuransi in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$asuransi = Asuransi::findOrFail($id);


		Yoga::cleanArrayJson(Input::get('umum'));

		$asuransi = Asuransi::find($id);
		$asuransi->alamat = Input::get('alamat');
		$asuransi->tipe_asuransi = Input::get('tipe_asuransi');
		$asuransi->nama = Input::get('nama');
		$asuransi->hp_pic = Input::get('hp_pic');
		$asuransi->no_telp = Input::get('no_telp');
		$asuransi->kali_obat = Input::get('kali_obat');
		$asuransi->email = Input::get('email');
		$asuransi->pic = Input::get('pic');
		$asuransi->gigi = Yoga::cleanArrayJson(Input::get('gigi'));
		$asuransi->umum = Yoga::cleanArrayJson(Input::get('umum'));
		$asuransi->penagihan = Yoga::cleanArrayJson(Input::get('penagihan'));
		$asuransi->rujukan = Yoga::cleanArrayJson(Input::get('rujukan'));
		$asuransi->tanggal_berakhir = Yoga::datePrep(Input::get('tanggal_berakhir'));
		$asuransi->save();


		if ( $id == '32' ) {
			$query = "update stafs set notified=0;";
			DB::statement($query);

		}

		$tarifs = Input::get('tarifs');

		$tarifs = json_decode($tarifs, true);

		foreach ($tarifs as $tarif) {
			$tf = Tarif::find($tarif['id']);
			$tf->biaya = $tarif['biaya'];
			$tf->jasa_dokter = $tarif['jasa_dokter'];
			$tf->tipe_tindakan_id = $tarif['tipe_tindakan_id'];
			$confirm = $tf->save();

			if (!$confirm) {
				return 'update gagal';
			}
		}
		return \Redirect::route('asuransis.index')->withPesan(Yoga::suksesFlash('<strong>Asuransi ' . Input::get('nama') . '</strong> berhasil diubah'));
	}

	/**
	 * Remove the specified asuransi from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{	
		$nama = Asuransi::find($id)->nama;
		Asuransi::find($id)->delete();
		Tarif::where('asuransi_id', $id)->delete();


		return \Redirect::route('asuransis.index')->withPesan(Yoga::suksesFlash('<strong>Asuransi ' . $nama . '</strong> berhasil dihapus'));
	}

	public function riwayat($id){
		$periksas = Periksa::where('asuransi_id', $id)->orderBy('created_at', 'desc')->paginate(20);
		return view('asuransis.riwayat', compact('periksas'));
	}

}
