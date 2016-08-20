<?php



namespace App\Http\Controllers;

use Input;
use App\Http\Requests;


use App\Classes\Yoga;
use App\Periksa;
use App\Pasien;
use App\Asuransi;
use App\Staf;

class PasiensController extends Controller
{

   /**
    * Buat construct untuk middleware super, jadi hanya bisa di lakukan oleh Pak Yoga
    *
    */
   public function __construct()
    {
        $this->middleware('super', ['only' => 'delete']);
    }

	/**
	 * Display a listing of pasiens
	 *
	 * @return Response
	 */
	public function index()	{
			$statusPernikahan = array( null => '- Status Pernikahan -',
									'Pernah' => 'Pernah Menikah',
									'Belum' => 'Belum Menikah'
									);
				$panggilan = array(
					null => '-Panggilan-',
					'Tn' => 'Tn (Laki dewasa)',
					'Ny' => 'Ny (Wanita Dewasa Menikah)',
					'Nn' => 'Nn (Wanita Dewasa Belum Menikah)',
					'An' => 'An (Anak-anak diatas 3 tahun)',
					'By' => 'By (Anak2 dibawah 3 tahun)'
					);
				$asuransi = Yoga::asuransiList();
				$jenis_peserta = array(

					null => ' - pilih asuransi -',  
		            "P" => 'Peserta',
		            "S" => 'Suami',
		            "I" => 'Istri',
		            "A" => 'Anak'

					);
				$staf = Yoga::stafList();
				$poli = Yoga::poliList();
				return view('pasiens.index')
					->withAsuransi($asuransi)
					->with('statusPernikahan', $statusPernikahan)
					->with('panggilan', $panggilan)
					->withJenis_peserta($jenis_peserta)
					->withStaf($staf)
					->withPoli($poli);
		
	}

	/**
	 * Store a newly created pasien in storage.
	 *
	 * @return Response
	 */
	

	/**
	 * Display the specified pasien.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$periksas = Periksa::where('pasien_id', $id)->orderBy('tanggal', 'desc')->paginate(10);
		if($periksas->count() > 0){
			return view('pasiens.show', compact('periksas'));
		}else {
			return redirect('pasiens')->withPesan(Yoga::gagalFlash('Tidak ada Riwayat Untuk Ditampilkan'));
		}
	}

	/**
	 * Show the form for editing the specified pasien.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$pasien = Pasien::find($id);

		$statusPernikahan = array( null => '- Status Pernikahan -',
									'Pernah' => 'Pernah Menikah',
									'Belum' => 'Belum Menikah'
									);


				$panggilan = array(
					null => '-Panggilan-',
					'Tn' => 'Tn',
					'Ny' => 'Ny',
					'Nn' => 'Nn',
					'An' => 'An',
					'By' => 'By'
					);

				$asuransi = array('0' => '- Pilih Asuransi -') + Asuransi::lists('nama', 'id')->all();

				$jenis_peserta = array(

					null => ' - pilih asuransi -',  
		            "P" => 'Peserta',
		            "S" => 'Suami',
		            "I" => 'Istri',
		            "A" => 'Anak'

					);
				$staf = array('0' => '- Pilih Staf -') + Staf::lists('nama', 'id')->all();

				$poli = Yoga::poliList();
				// return dd($asuransi);
				return view('pasiens.edit')
					->withPasien($pasien)
					->withAsuransi($asuransi)
					->with('statusPernikahan', $statusPernikahan)
					->with('panggilan', $panggilan)
					->withJenis_peserta($jenis_peserta)
					->withStaf($staf)
					->withPoli($poli);
	}

	/**
	 * Update the specified pasien in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$pasien = Pasien::findOrFail($id);
		$validator = \Validator::make($data = Input::all(), Pasien::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
			$pn = new Pasien;

			$pasien                 = Pasien::find($id);
			$pasien->alamat         = Input::get('alamat');
			$pasien->asuransi_id    = Input::get('asuransi_id');
			$pasien->sex            = Input::get('sex');
			$pasien->jenis_peserta  = Input::get('jenis_peserta');
			$pasien->nama_ayah      = Input::get('nama_ayah');
			$pasien->nama_ibu       = Input::get('nama_ibu');
			$pasien->nama           = Input::get('nama');
			$pasien->nama_peserta   = Input::get('nama_peserta');
			$pasien->nomor_asuransi = Input::get('nomor_asuransi');
			$pasien->no_telp        = Input::get('no_telp');
			if (!empty(Input::get('image'))) {
				$pasien->image      	= Yoga::inputImageIfNotEmpty(Input::get('image'), $id);
			}
			if (Input::hasFile('bpjs_image')) {
				$pasien->bpjs_image     = $pn->imageUpload('bpjs','bpjs_image', $id);
			}
			if (Input::hasFile('ktp_image')) {
				$pasien->ktp_image      = $pn->imageUpload('ktp', 'ktp_image', $id);
			}
			$pasien->tanggal_lahir   = Yoga::datePrep(Input::get('tanggal_lahir'));
			$pasien->save();



		return \Redirect::route('pasiens.index')->withPesan(Yoga::suksesFlash('Data pasien <strong>' . $pasien->id . ' - ' . $pasien->nama . '</strong> berhasil dirubah'));
	}
	/**
	 * Remove the specified pasien from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$pasien = Pasien::find($id);
		if (!Pasien::destroy($id)) return redirect()->back();
		$pesan = Yoga::suksesFlash('Pasien ' . $id . ' - ' . $pasien->nama . ' berhasil dihapus');
		return \Redirect::route('pasiens.index')->withPesan($pesan);
	}
	

}
