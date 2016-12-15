<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use App\Asuransi;
use App\Perujuk;
use App\Pasien;
use App\AntrianPoli;
use App\Complain;
use App\Kabur;
use App\Classes\Yoga;

class AntrianPolisController extends Controller
{

	/**
	 * Display a listing of antrianpolis
	 *
	 * @return Response
	 */
	public function index()
	{
		$asu = array(null => '- Pilih Asuransi -') + Asuransi::lists('nama', 'id')->all();
		$jenis_peserta = array(
			null => ' - pilih asuransi -',  
			"P"  => 'Peserta',
			"S"  => 'Suami',
			"I"  => 'Istri',
			"A"  => 'Anak'
		);
		$usg = array(
			null => ' - pilih -',  
			0    => 'Bukan USG',
			1    => 'USG'
		);

		$peserta = [ null => '- Pilih -', '0' => 'Peserta Klinik', '1' => 'Bukan Peserta Klinik'];
		$perujuks_list = [null => ' - pilih perujuk -'] + Perujuk::lists('nama', 'id')->all();
		$staf          = Yoga::stafList();
		$antrianpolis  = AntrianPoli::with('pasien', 'asuransi', 'antars')
								->where('tanggal', '<=', date('Y-m-d'))
								->orderBy('antrian', 'asc')->get();
		$perjanjian  = AntrianPoli::with('pasien', 'asuransi', 'antars')
								->where('tanggal', '>', date('Y-m-d'))
								->orderBy('tanggal', 'asc')->get();

		return view('antrianpolis.index')
			->withAntrianpolis($antrianpolis)
			->withPerujuks_list($perujuks_list)
			->withUsg($usg)
			->withAsu($asu)
			->withPeserta($peserta)
			->withPerjanjian($perjanjian)
			->withStaf($staf);
	}

	/**
	 * Show the form for creating a new antrianpoli
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('antrianpolis.create');
	}

	/**
	 * Store a newly created antrianpoli in storage.
	 *
	 * @return Response
	 */
	public function store()
	{



		if (empty(Pasien::find(Input::get('pasien_id'))->image) && Input::get('asuransi_id') == '32') {
			return redirect('pasiens/' . Input::get('pasien_id') . '/edit')->withCek('Gambar <strong>Foto pasien (bila anak2) atau gambar KTP pasien (bila DEWASA) </strong> harus dimasukkan terlebih dahulu');
		}

		$rules = [
			'tanggal' => 'required',
			'pasien_id' => 'required',
			'poli' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$antrian_poli_id = Yoga::customId('App\AntrianPoli');
		$ap              = new Antrianpoli;
		$ap->antrian     = Input::get('antrian');
		$ap->asuransi_id = Input::get('asuransi_id');
		$ap->pasien_id   = Input::get('pasien_id');
		$ap->poli        = Input::get('poli');
		$ap->staf_id     = Input::get('staf_id');
		if ( Input::get('poli') == '32' ) {
			$ap->bukan_peserta  = Input::get('bukan_peserta');
		}
		$ap->jam         = date("H:i:s");
		$ap->tanggal     = Yoga::datePrep( Input::get('tanggal') );
		$ap->id          = $antrian_poli_id;
		$ap->save();

		$pasien = Pasien::find(Input::get('pasien_id'));

		$conf = false;
		if(Input::get('staf_id_complain') != ''){
			$complain = new Complain;
			$complain->pasien_id = Input::get('pasien_id');
			$complain->tanggal = date('Y-m-d');
			$complain->staf_id = Input::get('staf_id_complain');
			$complain->complain = Input::get('complain');
			$conf = $complain->save();

		}


		if ($conf) {
			$pesan = '<strong>' . $pasien->id . ' - ' . $pasien->nama . '</strong> Berhasil masuk antrian Nurse Station Dan <strong>Komplain berhasil didokumentasikan</strong>';
		} else {
			$pesan = '<strong>' . $pasien->id . ' - ' . $pasien->nama . '</strong> Berhasil masuk antrian Nurse Station';
		}

		if (Input::get('asuransi_id') == '32') {
			return redirect('antrianpolis/pengantar/create/' . $ap->id)->withPesan(Yoga::suksesFlash('Harap Isi dulu pengantar pasien sebagai data kunjungan sehat'));
		}
		if ( $ap->poli == 'usg' ) {
			return redirect('antrianpolis')
				->withPrint($ap)
				->withPesan(Yoga::suksesFlash($pesan));
		}

		return redirect('antrianpolis')
			->withPesan(Yoga::suksesFlash($pesan));
	}

	/**
	 * Display the specified antrianpoli.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$antrianpoli = AntrianPoli::findOrFail($id);

		return view('antrianpolis.show', compact('antrianpoli'));
	}

	/**
	 * Show the form for editing the specified antrianpoli.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$antrianpoli = AntrianPoli::find($id);

		return view('antrianpolis.edit', compact('antrianpoli'));
	}

	/**
	 * Update the specified antrianpoli in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$antrianpoli = AntrianPoli::findOrFail($id);

		$antrianpoli->update($data);

		return \Redirect::route('antrianpolis.index');
	}

	/**
	 * Remove the specified antrianpoli from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return dd( Input::all() );

		$antrianpoli = AntrianPoli::find($id);
		$pasien_id = $antrianpoli->pasien_id;
		$nama = $antrianpoli->pasien->nama;

		$kabur            = new Kabur;
		$kabur->pasien_id = $pasien_id;
		$kabur->alasan    = Input::get('alasan_kabur');
		$conf             = $kabur->save();

		if ($conf) {
			$antrianpoli->delete();
		}



		return \Redirect::route('antrianpolis.index')->withPesan(Yoga::suksesFlash('pasien <strong>' .$pasien_id . ' -  ' . $nama .'</strong> berhasil dihapus dari Antrian'));
	}

}
