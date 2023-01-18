<?php


namespace App\Http\Controllers;

use Input;
use DB;
use Image;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\PengeluaransController;
use App\Http\Controllers\AsuransisController;
use App\Models\Staf;
use Storage;
use App\Models\Pph21Dokter;
use App\Models\Classes\Yoga;
use Illuminate\Validation\Rule;

class StafsController extends Controller
{
	public $input_alamat_domisili;
	public $input_alamat_ktp;
	public $input_email;
	public $input_titel_id;
	public $input_ktp;
	public $input_jenis_kelamin;
	public $input_nama;
	public $input_no_hp;
	public $input_no_telp;
	public $input_str;
	public $input_menikah;
	public $input_jumlah_anak;
	public $input_npwp;
	public $input_sip;
	public $input_nomor_rekening;
	public $input_bank;
	public $input_tanggal_lahir;
	public $input_tanggal_lulus;
	public $input_tanggal_mulai;
	public $input_universitas_asal;
    public $rules ;
    public function __construct() {
		$this->input_nama             = Input::get('nama');
		$this->input_tanggal_lahir    = Input::get('tanggal_lahir');
		$this->input_tanggal_lulus    = Input::get('tanggal_lulus');
		$this->input_tanggal_mulai    = Input::get('tanggal_mulai');
		$this->input_alamat_domisili  = Input::get('alamat_domisili');
		$this->input_alamat_ktp       = Input::get('alamat_ktp');
		$this->input_email            = Input::get('email');
		$this->input_titel_id            = Input::get('titel_id');
		$this->input_ktp              = Input::get('ktp');
		$this->input_jenis_kelamin    = Input::get('jenis_kelamin');
		$this->input_no_hp            = Input::get('no_hp');
		$this->input_no_telp          = Input::get('no_telp');
		$this->input_str              = Input::get('str');
		$this->input_menikah          = Input::get('menikah');
		$this->input_jumlah_anak      = Input::get('jumlah_anak');
		$this->input_npwp             = Input::get('npwp');
		$this->input_sip              = Input::get('sip');
		$this->input_nomor_rekening   = Input::get('nomor_rekening');
		$this->input_bank             = Input::get('bank');
		$this->input_universitas_asal = Input::get('universitas_asal');





        $this->middleware('super', ['only' => ['delete']]);
        /* $this->middleware('admin', ['only' => ['update']]); */
    }

	/**
	 * Display a listing of stafs
	 *
	 * @return Response
	 */
	public function index()
	{
		$stafs = Staf::all();
		return view('stafs.index', compact('stafs'));
	}

	/**
	 * Show the form for creating a new staf
	 *
	 * @return Response
	 */

	public function create()
	{
		return view('stafs.create');
	}

	/**
	 * Store a newly created staf in storage.
	 *s
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make(Input::all(), $this->rules());
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$staf     = new Staf;
		$staf     = $this->inputData($staf);


		return redirect('stafs')->withPesan(Yoga::suksesFlash('Staf baru <strong>' . $staf->nama . '</strong> Berhasil <strong>Dimasukkan</strong>'));
	}

	/**
	 * Display the specified staf.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$staf = Staf::findOrFail($id);
		return view('stafs.show', compact('staf'));
	}

	/**
	 * Show the form for editing the specified staf.
	 *
	 * @param  int  $id
     * @return Response
	 */
	public function edit($id)
	{
		$cs = new CustomController;
		$warna = $cs->warna;
		$staf = Staf::find($id);
		return view('stafs.edit', compact(
			'warna',
			'staf'
		));
	}

	/**
	 * Update the specified staf in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$staf = Staf::find($id);
		$validator = \Validator::make(Input::all(), $this->rules($staf));
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$staf = $this->inputData($staf);
		return redirect('stafs')->withPesan(Yoga::suksesFlash('Staf <strong>' . $staf->nama . '</strong> Berhasil <strong>Diubah</strong>'));
	}

	/**
	 * Remove the specified staf from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$staf = Staf::find($id);
		$nama = $staf->nama;
		if (!$staf->delete()) {
			return redirect()->back();
		}

		return redirect('stafs')->withPesan(Yoga::suksesFlash('Staf <strong>' . $nama . '</strong> Berhasil <strong>Dihapus</strong>'));
	}


	private function imageUpload($pre, $fieldName, $staf){

		if(Input::hasFile($fieldName)) {

			$upload_cover = Input::file($fieldName);
			//
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();
			//
			//membuat nama file random + extension
			$filename =	 $pre . $staf->id . '_' . time() . '.' . $extension;
			//
			//menyimpan bpjs_image ke folder public/img
			$destination_path =  'img/staf/';
			/* $destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/staf/'; */

			// Mengambil file yang di upload
			/* $upload_cover->save($destination_path . '/' . $filename); */
			
			Storage::disk('s3')->put($destination_path. $filename, file_get_contents($upload_cover));
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return 'img/staf/'. $filename;
			
		} else {
			return $staf->$fieldName;
		}

	}

	public function formPph21(){
			return view('stafs.formPph21', compact(
			));
	}
	public function cetakPph21(){
		return view('stafs.formPph21', compact(
		));
	}
	public function pph21DokterUmum(){

		$pphs = Pph21Dokter::latest()->paginate(20);
		return view('stafs.pphdokter', compact('pphs') );

	}
	public function pph21dokterPost($id, $staf_id){
		$ada_penghasilan_lain = Input::get('ada_penghasilan_lain');
		$staf                 = Staf::find($staf_id);;
		$peng                 = new PengeluaransController;
		$tanggal_potong       = date('Y-m-t 23:59:59', strtotime("-1 month"));
		$tahun_kemarin        = date("Y",strtotime("-1 month"));

		$pph                                 = Pph21Dokter::find($id);
		$perhitunganPph_ini                  = $peng->pph21dokter($staf, $tahun_kemarin, $tanggal_potong, $ada_penghasilan_lain);
		$pph->pph21                          = $perhitunganPph_ini['pph21_kurang_bayar'];
		$pph->ptkp_dasar                     = $perhitunganPph_ini['ptkp_dasar'];
		$pph->potongan5persen_setahun        = $perhitunganPph_ini['potongan5persen'];
		$pph->potongan15persen_setahun       = $perhitunganPph_ini['potongan15persen'];
		$pph->potongan25persen_setahun       = $perhitunganPph_ini['potongan25persen'];
		$pph->potongan30persen_setahun       = $perhitunganPph_ini['potongan30persen'];
		$pph->penghasilan_bruto_setahun      = $perhitunganPph_ini['penghasilan_bruto_setahun'];
		$pph->penghasilan_kena_pajak_setahun = $perhitunganPph_ini['ptkp_setahun'];
		$pph->ada_penghasilan_lain           = $ada_penghasilan_lain;
		$confirm                             = $pph->save();

		$pesan = Yoga::suksesFlash('');
		return redirect()->back()->withPesan($pesan);
		
	}
	public function inputData($staf){
		/* dd( $this->input_tanggal_lahir ); */
		$staf->alamat_domisili  = $this->input_alamat_domisili;
		$staf->alamat_ktp       = $this->input_alamat_ktp;
		$staf->email            = $this->input_email;
		$staf->titel_id         = $this->input_titel_id;
		$staf->ktp              = $this->input_ktp;
		$staf->jenis_kelamin    = $this->input_jenis_kelamin;
		$staf->nama             = $this->input_nama;;
		$staf->no_hp            = $this->input_no_hp;
		$staf->no_telp          = $this->input_no_telp;
		$staf->str              = $this->input_str;
		$staf->menikah          = $this->input_menikah;
		$staf->jumlah_anak      = $this->input_jumlah_anak;
		$staf->npwp             = $this->input_npwp;
		$staf->sip              = $this->input_sip;
		$staf->sip_expiry_date  = Input::get('sip_expiry_date');
		$staf->str_expiry_date  = Input::get('str_expiry_date');
		$staf->nomor_rekening   = $this->input_nomor_rekening  ;
		$staf->bank             = $this->input_bank            ;
		$staf->tanggal_lahir    = Input::get('tanggal_lahir');
		$staf->tanggal_lulus    = Input::get('tanggal_lulus');
		$staf->tanggal_mulai    = Input::get('tanggal_mulai');
		$staf->universitas_asal = $this->input_universitas_asal;

		$staf->save();

		$staf->image                      = $this->imageUpload('image', 'image', $staf);
		$staf->ktp_image                  = $this->imageUpload('ktp', 'ktp_image', $staf);
		$staf->str_image                  = $this->imageUpload('str', 'str_image', $staf);
		$staf->sip_image                  = $this->imageUpload('sip', 'sip_image', $staf);
		$staf->ijazah_image               = $this->imageUpload('ijazah', 'ijazah_image', $staf);
		$staf->bukti_registrasi_kki_image = $this->imageUpload('bukti_registrasi_kki', 'bukti_registrasi_kki_image', $staf);
		$staf->gambar_npwp                = $this->imageUpload('npwp', 'gambar_npwp', $staf);
		$staf->kartu_keluarga             = $this->imageUpload('kk', 'kartu_keluarga', $staf);

		$staf->save();

        if ( session()->has('warning_biru') ) {
            $warning_biru = session()->get('warning_biru');
            if (isset( $warning_biru[$staf->id] ) ) {
                unset( $warning_biru[$staf->id] );
            }
        }
		return $staf;
	}

	public function uploadBerkas($id){
		$asu                  = new AsuransisController;
		$asu->input_id        = $id;
		$asu->berkasable_type = 'App\\Models\\Staf';
		$asu->input_folder    = 'staf';
		return $asu->uploadBerkas();
	}
	public function hapusBerkas(){
		$asu                  = new AsuransisController;
		return $asu->hapusBerkas();
	}
	public function jumlahPasien($id){
		$query  = "Select ";
		$query .= "count(id) as jumlah, ";
		$query .= "year(tanggal) as tahun ";
		$query .= "FROM periksas as prx ";
		$query .= "WHERE staf_id = {$id} ";
		$query .= "AND tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "GROUP BY YEAR(tanggal) asc ";
		$jumlah = DB::select($query);
		$staf = Staf::find( $id );
		$tahun = true;
		return view('stafs.jumlah', compact(
			'jumlah',
			'staf',
		));
	}

	public function jumlahPasienPerTahun($id, $tahun){
		$jumlah = $this->jumlahPasienTahunan($id, $tahun);
		$staf   = Staf::find( $id );
		return view('stafs.jumlah', compact(
			'jumlah',
			'staf',
			'tahun'
		));
	}

	/**
	* undocumented function
	*
	* @return void
	*/
	public function jumlahPasienTahunan($id, $tahun)
	{
		$query  = "Select ";
		$query .= "count(id) as jumlah, ";
		$query .= "tanggal as tanggal ";
		$query .= "FROM periksas as prx ";
		$query .= "WHERE staf_id = {$id} ";
		$query .= "AND tanggal like '{$tahun}%' ";
		$query .= "AND prx.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "GROUP BY tanggal";
		return DB::select($query);
	}
    public function rules( $staf = null ){
        $ignore_id = is_null($staf) ? '' : ','.$staf->id;
        return [
            'nama'            => 'required|unique:stafs,nama'. $ignore_id,
            'alamat_domisili' => 'required',
            'jenis_kelamin'   => 'required',
            'ktp'             => 'required',
            'menikah'         => 'required',
            'jumlah_anak'     => 'required',
            'tanggal_lahir'   => 'required|date_format:d-m-Y',
            'tanggal_lulus'   => 'date_format:d-m-Y',
            'tanggal_mulai'   => 'date_format:d-m-Y',
            'str_expiry_date' => [ 
                Rule::requiredIf( 
                    !empty( 
                        Input::get('str_image') || 
                        ( !is_null($staf) && !empty($staf->str_image) ) 
                    ) 
                ), 'date_format:d-m-Y'],
            'ktp'             => [ 
                Rule::requiredIf( 
                    !empty( 
                        Input::get('ktp_image') || 
                        ( !is_null($staf) && !empty($staf->ktp_image) ) 
                    ) 
                )],
            'sip_expiry_date' => [
                Rule::requiredIf( 
                    !empty( 
                        Input::get('sip_image') || 
                        ( !is_null($staf) && !empty($staf->sip_image) ) 
                    ) 
                ), 'date_format:d-m-Y'
            ],
            'str'             => Rule::requiredIf( !empty( Input::get('str_image') || ( !is_null($staf) && !empty($staf->str_image) ) ) ),
            'sip'             => Rule::requiredIf( !empty( Input::get('sip_image') || ( !is_null($staf) && !empty($staf->sip_image) ) ) ),
            'no_telp'         => 'required'
        ];
    }
    public function recoveryIndexSortByDiagnosa($staf_id){
        $data = $this->queryRecoveryIndexByStafDanDiagnosaId($staf_id, null);
        $staf = Staf::find( $staf_id );
        return view('stafs.ri', compact(
            'data',
            'staf'
        ));
    }
    public function recoveryIndexByDiagnosa($staf_id, $diagnosa_id){
        $data = $this->queryRecoveryIndexByStafDanDiagnosaId( $staf_id ,$diagnosa_id );
        $staf = Staf::find( $staf_id );
        return view('stafs.riByDiagnosa', compact(
            'data',
            'staf'
        ));
    }

    /**
     * undocumented function
     *
     * @return void
     */
    private function queryRecoveryIndexByStafDanDiagnosaId( $staf_id, $diagnosa_id )
    {
        $query  = "SELECT  ";
        if ( !is_null( $diagnosa_id ) ) {
            $query .= "prx.tanggal as tanggal, ";
            $query .= "prx.id as periksa_id, ";
            $query .= "prx.pasien_id as pasien_id, ";
            $query .= "psn.nama as nama_pasien, ";
            $query .= "asu.nama as pembayaran, ";
            $query .= "dgn.diagnosa as diagnosa, ";
            $query .= "ant.informasi_terapi_gagal as keluhan ";
        } else {
            $query .= "dgn.diagnosa as diagnosa, ";
            $query .= "dgn.id as diagnosa_id, ";
            $query .= "count( prx.diagnosa_id ) as jumlah ";
        }
        $query .= "FROM antrians as ant ";
        $query .= "JOIN periksas as prx on prx.id = ant.antriable_id and ant.antriable_type = 'App\\\Models\\\Periksa' ";
        $query .= "JOIN diagnosas as dgn on dgn.id = prx.diagnosa_id ";
        $query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
        $query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
        $query .= "WHERE prx.staf_id = {$staf_id} ";
        if ( !is_null( $diagnosa_id ) ) {
            $query .= "AND prx.diagnosa_id = {$diagnosa_id} ";
        }
        $query .= "AND ant.recovery_index_id = 1 ";
        if ( is_null( $diagnosa_id ) ) {
            $query .= "GROUP BY prx.diagnosa_id ";
        }
        if ( is_null( $diagnosa_id ) ) {
            $query .= "ORDER BY count( prx.diagnosa_id ) desc";
        } else {
            $query .= "ORDER BY prx.tanggal desc";
        }
        return DB::select($query);
    }
    
    
    

	
}
