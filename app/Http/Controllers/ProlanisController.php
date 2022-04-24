<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Pasien;
use App\Models\Prolanis;
use App\Models\VerifikasiProlanis;
use App\Models\Classes\Yoga;
use DB;
use Input;

class ProlanisController extends Controller
{
	public function index(){
		$prolanis   = Yoga::prolanis();
		$hipertensi = Pasien::find( $prolanis['pasien_ht'] );
		$dm         = Pasien::with('periksa.transaksii')->whereIn('id', $prolanis['pasien_dm'] )->get();
        return view('prolanis.index', compact(
            'hipertensi',
            'dm'
        ));
	}

	public function verifikasi($date){
		$prolanis                    = Prolanis::with('pasienProlanis.pasien')->where('periode', $date)->get();
		$verifikasi_prolanis_options = VerifikasiProlanis::pluck('verifikasi_prolanis', 'id');

		$prolanisDm = [];
		$prolanisHt = [];

		$pasienDm   = [];
		$pasienHt   = [];

		$pasiens    = Pasien::whereRaw('prolanis_dm = 1 or prolanis_ht = 1')
						->WhereRaw('verifikasi_prolanis_dm_id = 1 or verifikasi_prolanis_ht_id = 1')
						->orderBy('nama')
						->get();

		foreach ($pasiens as $p) {
			if ($p->prolanis_dm && $p->verifikasi_prolanis_dm_id == 1) {
				$pasienDm[] = $p;
			}
			if ($p->prolanis_ht && $p->verifikasi_prolanis_ht_id == 1) {
				$pasienHt[] = $p;
			}
		}

		foreach ($prolanis as $p) {
			if ( str_contains($p['prolanis'] ,"Diabetes")) {
				$prolanisDm[] = $p;
			}
			if ( str_contains($p['prolanis'] ,"Hypertensi")) {
				$prolanisHt[] = $p;
			}
		}
		return view('prolanis/verifikasi', compact(
			'prolanisDm',
			'prolanisHt',
			'pasienDm',
			'pasienHt',
			'verifikasi_prolanis_options'
		));
	}
	
	public function terdaftar(){
		
		$prolanis = Prolanis::all();
		return view('prolanis.terdaftar', compact('prolanis'));
	}
	public function create($id){
		$pasien = Pasien::find($id);
		$golongan_prolanis = $this->golonganProlanis();
		return view('prolanis.create', compact(
			'pasien',
			'golongan_prolanis'
		));
	}

	public function store(){
		$rules = [
			'pasien_id' => 'required',
			'golongan_prolanis_id' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$p       = new Prolanis;
		$p->pasien_id   = Input::get('pasien_id');
		$p->golongan_prolanis_id   = Input::get('golongan_prolanis_id');
		$confirm = $p->save();
		if( Input::get('golongan_prolanis_id') == '1' ){
			$golonganProlanis = 'Hipertensi';
		} else {
			$golonganProlanis = 'Diabetes Mellitus';
		}
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Pasien BERHASIL mendapat status <strong>Prolanis Golongan ' . $golonganProlanis .  '</strong> ');
		} else {
			$pesan = Yoga::gagalFlash('Pasien GAGAL mendapat status <strong>Prolanis Golongan ' . $golonganProlanis .  '</strong> ');
		}

		return redirect('pasiens/' . Input::get('pasien_id') . '/edit')->withPesan($pesan);
		
	}
	public function edit($id){
		$prolanis = Prolanis::find($id);
		$pasien = $prolanis->pasien;
		$golongan_prolanis = $this->golonganProlanis();

		return view('prolanis.edit', compact(
			'prolanis',
			'pasien',
			'golongan_prolanis'
		));
		
	}

	public function update($id){
		$rules = [
			'pasien_id' => 'required',
			'golongan_prolanis_id' => 'required'

		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$p       = Prolanis::find($id);
		$p->golongan_prolanis_id   = Input::get('golongan_prolanis_id');
		$confirm = $p->save();
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Prolanis pasien BERHASIL diubah');
		} else {
			$pesan = Yoga::gagalFlash('Prolanis pasien GAGAL diubah');
		}
		return redirect('pasiens/' . $p->pasien_id . '/edit')->withPesan($pesan);
	}
	

	private function golonganProlanis(){
		return [
			null => ' - pilih - ',
			'1' => 'Hipertensi',
			'2' => 'Diabetes Mellitus'
		] ;
	}

	public function destroy($id){
		$prolanis = Prolanis::find($id);
		$pasien = $prolanis->pasien;
		if ( $prolanis->delete() ) {
			$pesan = Yoga::suksesFlash('Prolanis ' . $pasien->nama . ' BERHASIL dihapus');
		}else {
			$pesan = Yoga::gagalFlash('Prolanis ' . $pasien->nama . ' GAGAL dihapus');
		}
		return redirect('pasiens/' . $pasien->id . '/edit')->withPesan($pesan);
	}
	public function ajaxMeninggal(){
		$meninggal                    = Input::get('meninggal');
		$pasien_id                    = Input::get('pasien_id');
		$kategori_prolanis            = Input::get('kategori_prolanis');
		$pasien                       = Pasien::find( $pasien_id );
		$verifikasi_kategori_prolanis = 'verifikasi_prolanis_'.$kategori_prolanis.'_id';

		if ($pasien->$verifikasi_kategori_prolanis != 1) {
			return $this->ajaxData(0, $pasien, $verifikasi_kategori_prolanis);
		}

		$pasien->meninggal              = $meninggal;
		$pasien->prolanis_dm            = 0;
		$pasien->prolanis_ht            = 0;
		$pasien->$verifikasi_kategori_prolanis = 3;
		$pasien->save();

		return $this->ajaxData(1, $pasien, $verifikasi_kategori_prolanis);
;
	}
	public function ajaxVerifikasi(){
		$pasien_id         = Input::get('pasien_id');
		$verifikasi        = Input::get('verifikasi');
		$kategori_prolanis = Input::get('kategori_prolanis');
		$pasien            = Pasien::find( $pasien_id );
		$verifikasi_kategori_prolanis = 'verifikasi_prolanis_'.$kategori_prolanis.'_id';
		if ($pasien->$verifikasi_kategori_prolanis != 1) {
			return $this->ajaxData(0, $pasien, $verifikasi_kategori_prolanis);
		}
		$column                                = 'prolanis_' . $kategori_prolanis;
		$pasien->$column                       = 1;
		$pasien->$verifikasi_kategori_prolanis = $verifikasi;
		$pasien->save();
		return $this->ajaxData(1, $pasien, $verifikasi_kategori_prolanis);
	}
	public function ajaxPenangguhan(){
		$penangguhan       = Input::get('penangguhan');
		$pasien_id         = Input::get('pasien_id');
		$kategori_prolanis = Input::get('kategori_prolanis');
		$pasien            = Pasien::find( $pasien_id );
		$verifikasi_kategori_prolanis = 'verifikasi_prolanis_'.$kategori_prolanis.'_id';
		if ($pasien->$verifikasi_kategori_prolanis != 1) {
			return $this->ajaxData(0, $pasien, $verifikasi_kategori_prolanis);
		}
		$pasien->penangguhan_pembayaran_bpjs  = $penangguhan;
		$pasien->$verifikasi_kategori_prolanis       = 3;
		$pasien->save();
		return $this->ajaxData(1, $pasien, $verifikasi_kategori_prolanis);
	}

	/**
	* undocumented function
	*
	* @return void
	*/
	private function ajaxData($response, $pasien, $verifikasi_kategori_prolanis)
	{
		return [
			'response'                    => $response,
			'meninggal'                   => $pasien->meninggal,
			'verifikasi_prolanis_id'      => $pasien->$verifikasi_kategori_prolanis,
			'penangguhan_pembayaran_bpjs' => $pasien->penangguhan_pembayaran_bpjs
		];
	}
	
}
