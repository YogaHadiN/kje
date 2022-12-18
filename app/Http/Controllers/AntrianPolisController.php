<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use Illuminate\Http\Request;
use Bitly;
use Carbon\Carbon;
use Storage;
use App\Http\Controllers\AntrianPeriksasController;
use App\Http\Controllers\WablasController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\PasiensController;
use App\Events\FormSubmitted;
use App\Models\Antrian;
use App\Models\JenisAntrian;
use App\Models\Staf;
use App\Models\WhatsappRegistration;
use App\Models\Sms;
use App\Models\Asuransi;
use App\Models\AntrianPeriksa;
use App\Models\Promo;
use App\Models\Periksa;
use App\Models\Perujuk;
use App\Models\Pasien;
use App\Models\AntrianPoli;
use App\Models\Complain;
use App\Models\Kabur;
use App\Models\Classes\Yoga;
use DB;

class AntrianPolisController extends Controller
{
	public $input_pasien_id;
	public $input_antrian;
	public $input_asuransi_id;
	public $input_poli_id;
	public $input_staf_id;
	public $input_tanggal;
	public $input_jam;
	public $input_pasien;
	public $input_kecelakaan_kerja;
	public $input_self_register;
	public $input_bukan_peserta;
	public $input_antrian_id;
    public $asuransi_is_bpjs;

	public function __construct() {
		$this->input_pasien_id     = Input::get('pasien_id');
		$this->input_asuransi_id   = Input::get('asuransi_id');
		$this->input_poli_id       = Input::get('poli_id');
		$this->input_staf_id       = Input::get('staf_id');
		$this->input_tanggal       = Yoga::datePrep( Input::get('tanggal') );
		$this->input_bukan_peserta = Input::get('bukan_peserta');
        $this->input_antrian = null;
        /* $this->middleware('nomorAntrianUnik', ['only' => ['store']]); */
    }
	/**
	 * Display a listing of antrianpolis
	 *
	 * @return Response
	 */
	public function index()
	{
		$asu = array(null => '- Pilih Asuransi -') + Asuransi::pluck('nama', 'id')->all();
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
		$perujuks_list = [null => ' - pilih perujuk -'] + Perujuk::pluck('nama', 'id')->all();

		$antrianpolis  = AntrianPoli::with('pasien', 'asuransi', 'antars', 'antrian')
								->where('submitted', 0)
								->get();

		$perjanjian = [];
		$staf = Yoga::stafList();
		foreach ($antrianpolis as $p) {
			$perjanjian[$p->tanggal->format('d-m-Y')][] = $p;
		}

		foreach ($antrianpolis as $a) {
			if (empty( $a->pasien->tanggal_lahir )) {
				dd( $a->pasien->tanggal_lahir );
			}
		}

        /* dd( $antrianpolis->first()->pasien->nama ); */
		return view('antrianpolis.index')
			->withAntrianpolis($antrianpolis)
			->with('perujuks_list', $perujuks_list)
			->withUsg($usg)
			->withAsu($asu)
			->withStaf($staf)
			->withPeserta($peserta)
			->withPerjanjian($perjanjian);
	}

	/**
	 * Store a newly created antrianpoli in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $this->pasien_id        = Input::get('pasien_id');
        return $this->prosesData();
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
		$antrianpoli = AntrianPoli::find($id);
		$pasien_id   = $antrianpoli->pasien_id;
		$nama        = $antrianpoli->pasien->nama;

		$kabur            = new Kabur;
		$kabur->pasien_id = $pasien_id;
		$kabur->alasan    = Input::get('alasan_kabur');
		$conf             = $kabur->save();

		if ($conf) {
			$antrianpoli->delete();
		}
		return \Redirect::route('antrianpolis.index')->withPesan(Yoga::suksesFlash('pasien <strong>' .$pasien_id . ' -  ' . $nama .'</strong> berhasil dihapus dari Antrian'));
	}

    protected $morphClass = 'App\Models\AntrianPoli';
    public function promos(){
        return $this->morphMany('App\Models\Promo', 'jurnalable');
    }

	public function sendWaAntrian($totalAntrian, $ap){

		$tanggal            = $ap->tanggal;
		$antrian            = $ap->antrian;
		$no_telp            = $ap->pasien->no_telp;
		$no_telp_string     = $no_telp;
		$antrian_pasien_ini = array_search($antrian, $totalAntrian['antrians']) +1;
		/* if ( gethostname() == 'Yogas-Mac' ) { */
		$no_telp = '081381912803';
		/* } */
		$sisa_antrian =   $antrian_pasien_ini - $totalAntrian['antrian_saat_ini'] ;

		$text = 'Pasien Yth. Nomor Antrian Anda adalah \n\n *' . $antrian_pasien_ini ;
	    $text .=	'* \n\nAntrian yang diperiksa saat ini adalah\n\n *' . $totalAntrian['antrian_saat_ini'];
		$text .= '* \n\nSaat ini (' . date('d M y H:i:s'). ') Masih ada\n\n *';
		$text .= $sisa_antrian . ' antrian lagi*\n\n';
		$text .= 'Sebelum giliran anda dipanggil. ';
		$text .= 'Mohon agar dapat membuka link berikut untuk mengetahui antrian terakhir secara berkala: \n\n';
		$text .= Bitly::getUrl('http://45.76.186.44/antrianperiksa/' . $ap->id);
		/* $text .= '\n\n.'; */
		/* $text .= $no_telp_string; */
		/* $text .= '\n\n.'; */
		/* $text .= '\nBapak/Ibu dapat menunggu antrian periksa di rumah, dan datang kembali ke klinik saat antrian sudah dekat, untuk mencegah menunggu terlalu lama, dan mencegah penularan penyakit. Terima kasih'; */
		/* $text .= 'Sistem akan mengirimkan whatsapp untuk mengingatkan anda jika tersisa 5 antrian lagi dan 1 antrian lagi sebelum anda dipanggil. Terima kasih' ; */

		Sms::send($no_telp, $text);

	}
	public function totalAntrian($ap){
		/* $tanggal = $ap->tanggal; */
		/* $antrian = $ap->antrian; */
		/* $no_telp = $ap->pasien->no_telp; */
		/* $antrians = []; */
		/* $apx_per_tanggal = AntrianPeriksa::where('tanggal',  $tanggal) */
		/* 								->whereIn('poli', ['umum', 'sks', 'luka']) */
		/* 								->get(); */
		/* $apl_per_tanggal = AntrianPoli::where('tanggal',  $tanggal) */
		/* 								->whereIn('poli', ['umum', 'sks', 'luka']) */
		/* 								->get(); */
		/* $px_per_tanggal = Periksa::where('tanggal',  $tanggal) */
		/* 								->whereIn('poli', ['umum', 'sks', 'luka']) */
		/* 								->orderBy('antrian', 'desc') */
		/* 								->get(); */

		/* foreach ($apx_per_tanggal as $apx) { */
		/* 	$antrians[$apx->pasien_id] = $apx->antrian; */
		/* } */

		/* foreach ($apl_per_tanggal as $apx) { */
		/* 	$antrians[$apx->pasien_id] = $apx->antrian; */
		/* } */
		/* foreach ($px_per_tanggal as $apx) { */
		/* 	$antrians[$apx->pasien_id] = $apx->antrian; */
		/* } */

		/* sort($antrians); */
		/* if ( $px_per_tanggal->count() >2 ) { */
		/* 	$antrian_saat_ini   = array_search($px_per_tanggal->first()->antrian, $antrians); */
		/* } else { */
		/* 	$antrian_saat_ini   = 0; */
		/* } */

		/* $result = compact( */
		/* 	'antrians', */
		/* 	'antrian_saat_ini' */
		/* ); */
		/* return $result; */
	}
	public function inputDataAntrianPoli(){
		$ap                            = new AntrianPoli;
		$ap->asuransi_id               = $this->input_asuransi_id;
		$ap->pasien_id                 = $this->input_pasien_id;
		$ap->poli_id                   = $this->input_poli_id;
		$ap->staf_id                   = $this->input_staf_id;
		if ( $this->asuransi_is_bpjs ) {
			$ap->bukan_peserta         = $this->input_bukan_peserta;
		}
        $ap->jam                       = !is_null( $this->input_antrian ) ? $this->input_antrian->created_at->format("H:i:s") : date("H:i:s");
		$ap->tanggal                   = $this->input_tanggal;
		$ap->save();


		return $ap;
	}

	public function arahkanAntrianPoli($ap){

		$pesan = Yoga::suksesFlash('<strong>' . $ap->pasien->id . ' - ' . $ap->pasien->nama . '</strong> Berhasil masuk antrian Nurse Station Dan <strong>Komplain berhasil didokumentasikan</strong>');

        if (
            !is_null( $ap ) &&
            $ap->poli->poli == 'Poli USG Kebidanan' 
        ) {
			return redirect('antrianpolis')
				->withPrint($ap)
				->withPesan($pesan);
		}
		return redirect('antrianpolis')
			->withPesan($pesan);
	}

	public function arahkanAntrianPeriksa($ap){
        $pesan = Yoga::suksesFlash('<strong>' .$ap->pasien->id . ' - ' . $ap->pasien->nama . '</strong> berhasil masuk antrian periksa');
        if (
            !is_null( $ap ) &&
            $ap->poli->poli == 'Poli USG Kebidanan' 
        ) {
			return redirect('pasiens')
				->withPrint($ap)
				->withPesan($pesan);
		}
		return redirect('pasiens')
			->withPesan($pesan);
	}
	public function updateJumlahAntrian($panggil_pasien, $ruangan){
		event(new FormSubmitted($panggil_pasien, $ruangan));
	}
    /**
     * undocumented function
     *
     * @return void
     */
    private function inputAntrianPeriksa()
    {
        $apx                         = new AntrianPeriksasController;
        $apx->input_jam              = date('H:i:s');
        $apx->input_hamil            = 0;
        $apx->input_pasien            = $this->input_pasien;
        $apx->input_pasien_id            = $this->input_pasien_id;
        $apx->input_poli_id          = Input::get('poli_id');
        $apx->input_kecelakaan_kerja = 0;
        if ( $this->input_antrian ) {
            $apx->input_antrian_id       = $this->input_antrian->id;
        }
        $apx->input_asisten_id       = Staf::owner()->id;
        return $apx->inputData();
    }
    public function updateAntrianDanKirimWa($ap){
        if ( !is_null($this->input_antrian) ) {
            $this->input_antrian->antriable_id             = $ap->id;
            $this->input_antrian->antriable_type           = get_class($ap);
            $this->input_antrian->nama                     = $ap->pasien->nama;
            $this->input_antrian->tanggal_lahir            = $ap->pasien->tanggal_lahir;
            $this->input_antrian->registrasi_pembayaran_id = $ap->asuransi->registrasi_pembayaran_id;
            $this->input_antrian->save();


            if (!is_null($this->input_antrian->whatsapp_registration)) {
                $registering_confirmation = $this->input_antrian->whatsapp_registration->registering_confirmation;
                $this->input_antrian->whatsapp_registration->delete();
                if ($registering_confirmation) {
                    $message = "Nomor antrian *" . $this->input_antrian->nomor_antrian . "* ";
                    $message .= "Berhasil kami daftarkan";
                    $message .= PHP_EOL;
                    $message .= PHP_EOL;
                    $message .= ucwords($ap->pasien->nama);
                    $message .= PHP_EOL;
                    $message .= PHP_EOL;
                    $message .= "Pembayaran : " . $ap->asuransi->nama;
                    $message .= PHP_EOL;
                    $message .= "Tanggal Lahir : " . Carbon::parse($ap->pasien->tanggal_lahir)->format('d M Y');
                    $message .= PHP_EOL;
                    $message .= PHP_EOL;
                    $message .= "Silahkan menunggu untuk dilayani";

                    $wablas = new WablasController;
                    $wablas->sendSingle( $this->input_antrian->no_telp, $message );
                }
            } 
        }
    }

    public function daftarkanAntrian($antrian_id){
        $pasien  = new PasiensController;
        $fs = new FasilitasController;
		$antrian = Antrian::with('jenis_antrian.poli_antrian.poli', 'pasien.asuransi')->where('id', $antrian_id )->first();

        $pasien->dataIndexPasien['poli'] = $fs->populatePoli( $antrian );
        $pasien->dataIndexPasien['antrian'] = $antrian;
		$pasien->dataIndexPasien['nama_pasien_bpjs']          = $antrian->pasien->nama;
		$pasien->dataIndexPasien['pasien_id_bpjs']            = $antrian->pasien_id;
		$pasien->dataIndexPasien['tanggal_lahir_pasien_bpjs'] = $antrian->pasien->tanggal_lahir;
		$pasien->dataIndexPasien['asuransi_id_bpjs']          = $antrian->pasien->asuransi_id;
		$pasien->dataIndexPasien['nama_asuransi_bpjs']        = $antrian->pasien->asuransi->nama;;
		$pasien->dataIndexPasien['image_bpjs']                = $antrian->pasien->image_bpjs;
		$pasien->dataIndexPasien['prolanis_dm_bpjs']          = $antrian->pasien->prolanis_dm;
		$pasien->dataIndexPasien['prolanis_ht_bpjs']          = $antrian->pasien->prolanis_ht;;
        $asuransi_biaya_pribadi = Asuransi::BiayaPribadi();
        $pasien->dataIndexPasien['asuransi_list'] = [
            $asuransi_biaya_pribadi->id => $asuransi_biaya_pribadi->nama,
            $antrian->pasien->asuransi_id => $antrian->pasien->asuransi->nama
        ];
        $pasien->dataIndexPasien['pasien'] = Pasien::find($antrian->pasien_id);
        $pasien->populateDataIndexPasien();
        $pasien->dataIndexPasien['antrian'] = $antrian;
        return view('antrianpolis.create', $pasien->dataIndexPasien );
    }
    public function prosesData(){
		DB::beginTransaction();
		try {
            $this->asuransi_is_bpjs = !empty( $this->input_asuransi_id ) ? Asuransi::find($this->input_asuransi_id)->tipe_asuransi_id == 5: false;
			$this->input_pasien           = Pasien::find( $this->input_pasien_id );

			/* Jika pasien belum difoto, arahkan ke search pasien */
			if (
				empty($this->input_pasien->image)
			) {
				$pesan = Yoga::gagalFlash('Gambar <strong>Foto pasien</strong> harus dimasukkan terlebih dahulu');
				return redirect('pasiens/' . $this->pasien_id . '/edit')
					->withPesan($pesan);
			}
			/* Jika pasien memiliki KTP dan nomor ktp belum diisi */
			if (
				!is_null( $this->input_pasien->ktp_image )  	// jika ktp_image tidak null
				&& !empty( $this->input_pasien->ktp_image ) 	// jika ktp_image tidak empty
				&& Storage::disk('s3')->exists( $this->input_pasien->ktp_image )  // ditemukan di database
				&& (empty($this->input_pasien->nomor_ktp) || is_null($this->input_pasien->nomor_ktp))  // dan nomor ktp masih kogong
			) {
				$pesan = Yoga::gagalFlash('Nomor KTP harus diisi terlebih dahulu sebelum dilanjutkan, gunakan foto KTP'); // Nomor KTP harus diisi
				return redirect('pasiens/' . $this->pasien_id . '/edit')->withPesan($pesan);
			}

			/* Jika pasien berusia kurang dari 15 tahun dan terakhir di update lebih dari satu tahun yang lalu, update foto pasien */
			if (
				$this->input_pasien->usia < 15 && // jika usia pasien kurang dari 15 tahun
				Carbon::now()->subYears(1)->greaterThan( $this->input_pasien->updated_at )
			) {
				$pesan = Yoga::gagalFlash('Gambar <strong>Foto pasien</strong> harus di update dengan yang terbaru karena sudah lewat 1 tahun');
				return redirect('pasiens/' . $this->pasien_id . '/edit')
					->withPesan($pesan);
			}

			/* Jika pasien berusia lebih dari 15 tahun dan terakhir di update lebih dari 5 tahun yang lalu, update foto pasien */
			if (
				$this->input_pasien->usia > 15 && // jika usia pasien lebih dari 15 tahun
				Carbon::now()->subYears(5)->greaterThan( $this->input_pasien->updated_at ) // dan lebih dari 5 tahun yang lalu diupdate
			) {
				$pesan = Yoga::gagalFlash('Gambar <strong>Foto pasien</strong> harus di update dengan yang terbaru karena sudah lewat 5 tahun');
				return redirect('pasiens/' . $this->pasien_id . '/edit')
					->withPesan($pesan);
			}

			/* Jika pasien BPJS dan usia lebih dari 18 tahun namun tidak membawa KTP */
			if (
				$this->asuransi_is_bpjs && // pasien bpjs
				(empty($this->input_pasien->ktp_image) && $this->input_pasien->usia >= 18) // jika usia > 18 tahun tapi tidak bawa KTP
			) {
				$pesan = Yoga::gagalFlash('Gambar <strong>gambar KTP pasien (bila DEWASA) </strong> untuk peserta asuransi harus dimasukkan terlebih dahulu');
				return redirect('pasiens/' . $this->pasien_id . '/edit')
					->withPesan($pesan);
			}

			/* Jika pasien BPJS dan usia lebih dari 18 tahun namun tidak membawa KTP */
			if (
				$this->asuransi_is_bpjs && // pasien bpjs
				(empty($this->input_pasien->nomor_asuransi_bpjs) && is_null($this->input_pasien->nomor_asuransi_bpjs)) // jika usia > 18 tahun tapi tidak bawa KTP
			) {
				$pesan = Yoga::gagalFlash('Nomor Asuransi BPJS harus diisi');
				return redirect('pasiens/' . $this->pasien_id . '/edit')
					->withPesan($pesan);
			}

			/* Jika pasien BPJS dan tidak membawa kartu BPJS */
			if (
				$this->asuransi_is_bpjs && // pasien bpjs
				empty($this->input_pasien->bpjs_image) //jika kartu bpjs masih kosong
			) {
				$pesan = Yoga::gagalFlash('Gambar <strong>Kartu BPJS</strong> untuk peserta asuransi harus dimasukkan terlebih dahulu');
				return redirect('pasiens/' . $this->pasien_id . '/edit')
					->withPesan($pesan);
			}

			$rules = [
				'tanggal'     => 'required',
				'asuransi_id' => 'required',
				'poli_id'     => 'required'
			];
			
			$validator = \Validator::make(Input::all(), $rules);
			
			if ($validator->fails())
			{
				return \Redirect::back()->withErrors($validator)->withInput();
			}

			//cek jika antrian sudah tidak ada, maka jangan dilanjutkan
			//
			//
            $this->input_antrian = !is_null($this->input_antrian_id) ? Antrian::with('whatsapp_registration')->where( 'id',$this->input_antrian_id )->first() : null;

			if (
				!is_null($this->input_antrian_id) &&
				is_null( $this->input_antrian )
			) {
				$pesan = Yoga::gagalFlash('Antrian tidak ditemukan, mungkin tidak sengaja terhapus');
				return redirect('antrians')->withPesan($pesan);
			}
			//jika pasien memilih poli rapid test gak usah masuk nurse station
			//
			//

            $nursestation_available = \Auth::user()->tenant->nursestation_availability;
            $ap = null;
            if (
                (!is_null($this->input_antrian) &&( $this->input_antrian->jenis_antrian_id == 7 || $this->input_antrian->jenis_antrian_id == 8)) ||
                !\Auth::user()->tenant->nursestation_availability
            ) {
                $ap = $this->inputAntrianPeriksa();
            } else {
                $ap = $this->inputDataAntrianPoli();
            }

            $this->updateAntrianDanKirimWa($ap);
            // hapus jika ada whatsapp registration

			$this->updateJumlahAntrian(false, null);
			DB::commit();
            if ( get_class($ap) == "App\Models\AntrianPeriksa") {
                return $this->arahkanAntrianPeriksa($ap);
            } else {
                return $this->arahkanAntrianPoli($ap);
            }
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
    }
    public function daftarkanPost($id){
        $antrian               = Antrian::find( $id );
        $this->input_pasien_id = $antrian->pasien_id;
        $this->input_antrian_id = $antrian->id;
        return $this->prosesData();
    }
    
    
}
