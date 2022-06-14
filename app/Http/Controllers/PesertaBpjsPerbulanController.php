<?php

namespace App\Http\Controllers;

use Input;
use Auth;
use Excel;

use App\Models\PesertaBpjsPerbulan;
use App\Models\UpdateRpptPeserta;
use App\Models\Classes\Yoga;
use App\Models\Pasien;
use App\Models\Prolanis;
use App\Models\Periksa;
use App\Rules\ExceRule;
use App\Imports\PesertaBpjsPerbulanImport;
use DB;
use Storage;
use Illuminate\Http\Request;

class PesertaBpjsPerbulanController extends Controller
{
    public $jumlah_dm;
    public $jumlah_ht;
    public $bulanTahun;
    public $nama_file;
    public $riwayat_dm_pasien_ids;
    public $riwayat_ht_pasien_ids;
    /**
     * @param 
     */
    public function __construct()
    {
        $this->jumlah_dm  = Input::get('jumlah_dm');
        $this->jumlah_ht  = Input::get('jumlah_ht');
        $this->bulanTahun = Input::get('bulanTahun');
        $this->nama_file  = Input::get('nama_file');
    }
    
    public function index(){

        $query  = "SELECT ";
        $query .= "id, ";
        $query .= "periode, ";
        $query .= "sum( case when `prolanis` LIKE '%Diabetes Mellitus%' then 1 else 0 end ) as jumlah_dm,";
        $query .= "sum( case when `prolanis` LIKE '%Hypertensi%' then 1 else 0 end ) as jumlah_ht, ";
        $query .= "sum(case when verifikasi_prolanis_dm_id LIKE '1' OR verifikasi_prolanis_ht_id LIKE '1' then 1 else 0 end) as unverified ";
        $query .= "FROM (SELECT ";
        $query .= "pro.id as id, ";
        $query .= "pro.periode as periode, ";
        $query .= "psn.verifikasi_prolanis_ht_id as verifikasi_prolanis_ht_id, ";
        $query .= "psn.verifikasi_prolanis_dm_id as verifikasi_prolanis_dm_id, ";
        $query .= "pro.prolanis as prolanis ";
        $query .= "FROM pasien_prolanis as ppr ";
        $query .= "JOIN prolanis as pro on pro.id = ppr.prolanis_id ";
        $query .= "JOIN pasiens as psn on psn.id = ppr.pasien_id ";
        $query .= "GROUP BY pro.id) t ";
        $query .= "GROUP By periode ";
        $query .= "ORDER BY id desc ";
        $prolanis = DB::select($query);
        return view('peserta_bpjs_perbulans.index', compact(
            'prolanis'
        ));
    }
    public function create(){
        return view('peserta_bpjs_perbulans.create');
    }
    public function edit($id){
        $peserta_bpjs_perbulan = PesertaBpjsPerbulan::find($id);
        return view('peserta_bpjs_perbulans.edit', compact('peserta_bpjs_perbulan'));
    }

    public function editDataPasien(Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }

		DB::statement('Update pasiens set penangguhan_pembayaran_bpjs = 0;');
		DB::statement('Update pasiens set verifikasi_prolanis_dm_id = 1;'); //verifikasi_prolanis 1 = "belum"
		DB::statement('Update pasiens set verifikasi_prolanis_ht_id = 1;'); //verifikasi_prolanis 1 = "belum"

        $import             = new PesertaBpjsPerbulanImport;
        $import->bulanTahun = Input::get('tahun') . '-' . Input::get('bulan');
        Excel::import($import, Input::file('nama_file'));
        foreach ($import->data as $d) {
            $prolanis                = new Prolanis;
            $prolanis->nama          = $d['nama'];
            $prolanis->jenis_kelamin = $d['jenis_kelamin'];
            $prolanis->usia          = $d['usia'];
            $prolanis->no            = $d['no'];
            $prolanis->alamat        = $d['alamat'];
            $prolanis->prb           = $d['prb'];
            $prolanis->prolanis      = $d['prolanis'];
            $prolanis->club_prolanis = $d['club_prolanis'];
            $prolanis->periode       = $d['periode'];
            try {
                $prolanis->save();
            } catch (\Exception $e) {
                dd( $d );
            }
            $prolanis->pasienProlanis()->createMany($d['pasien_ids']);
        }
        $pesan = Yoga::suksesFlash('Data prolanis berhasil dimasukkan');
        return redirect()->back()->withPesan($pesan);
    }
    public function store(Request $request){
        $peserta_bpjs_perbulan = new PesertaBpjsPerbulan;
        $peserta_bpjs_perbulan = $this->processData($peserta_bpjs_perbulan);

        $pesan = Yoga::suksesFlash('PesertaBpjsPerbulan baru berhasil dibuat');
        return redirect('peserta_bpjs_perbulans')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $peserta_bpjs_perbulan = PesertaBpjsPerbulan::find($id);
        $peserta_bpjs_perbulan = $this->processData($peserta_bpjs_perbulan);

        $pesan = Yoga::suksesFlash('PesertaBpjsPerbulan berhasil diupdate');
        return redirect('peserta_bpjs_perbulans')->withPesan($pesan);
    }
    public function destroy($id){
        PesertaBpjsPerbulan::destroy($id);
        $pesan = Yoga::suksesFlash('PesertaBpjsPerbulan berhasil dihapus');
        return redirect('peserta_bpjs_perbulans')->withPesan($pesan);
    }

    public function processData($peserta_bpjs_perbulan){

        $peserta_bpjs_perbulan->nama_file  = $this->nama_file;
        $peserta_bpjs_perbulan->bulanTahun = $this->bulanTahun . '-01';
        $peserta_bpjs_perbulan->jumlah_dm  = $this->jumlah_dm;
        $peserta_bpjs_perbulan->jumlah_ht  = $this->jumlah_ht;
        $peserta_bpjs_perbulan->save();

        return $peserta_bpjs_perbulan;
    }
    public function import(){
        return 'Not Yet Handled';
        $file      = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files', $file_name);
        $results   = Excel::load('files/' . $file_name, function($reader){
            $reader->all();
        })->get();
        $peserta_bpjs_perbulans     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $peserta_bpjs_perbulans[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        PesertaBpjsPerbulan::insert($peserta_bpjs_perbulans);
        $pesan = Yoga::suksesFlash('Import Data Berhasil');
        return redirect()->back()->withPesan($pesan);
    }
    private function valid( $data ){
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'nama_file'           =>[
                'required',
                new ExceRule( Input::file('nama_file') )
            ]
        ];
        $validator = \Validator::make($data, $rules, $messages);
        
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function fileUpload($fieldName)
    {
		if(Input::hasFile($fieldName)) {

			$upload_cover = Input::file($fieldName);
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			//membuat nama file random + extension
			$filename =	 'file_'. time() . '_' . Auth::id() . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			$destination_path =  'peserta_bpjs/';
			/* $destination_path = public_path() . DIRECTORY_SEPARATOR . 'peserta_bpjs/'; */

			// Mengambil file yang di upload
			/* $upload_cover->move($destination_path , $filename); */
			Storage::disk('s3')->put($destination_path. $filename, file_get_contents($upload_cover));
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return $filename;
			
		}
    }
    public function updateDataPasien(){
        $id         = Input::get('id');
        $nama       = Input::get('nama');
        $bulanTahun = Input::get('bulanTahun');
        $nama_tab   = Input::get('nama_tab');
        $sex        = strtolower(Input::get('jenis_kelamin')) == 'laki-laki' ? '1' : '0';


        if ( !empty($id) ) {
            $pasien       = Pasien::find($id);
            $nama_sebelum = $pasien->nama;
            $pasien->nama = $nama ;

            if ( $bulanTahun == date('Y-m') ) {
                if ( $nama_tab           == 'ht' ) {
                    $pasien->prolanis_ht  = 1;
                }
                if ( $nama_tab           == 'dm' ) {
                    $pasien->prolanis_dm  = 1;
                }
            }
            $pasien->save();
            $update_rppt_peserta               = new UpdateRpptPeserta;
            $update_rppt_peserta->pasien_id    = $pasien->id ;
            $update_rppt_peserta->nama_sebelum = $nama_sebelum ;
            $update_rppt_peserta->nama_sesudah = $pasien->nama ;
            $update_rppt_peserta->prolanis     = $nama_tab ;
            $update_rppt_peserta->save();

            $nama_prolanis = 'prolanis_' . $nama_tab;

            Periksa::where('pasien_id', $pasien->id)
                    ->where('tanggal', 'like', $bulanTahun . '%')
                    ->update([
                        $nama_prolanis => '1'
                    ]);
            if ( $pasien->save()) {
                return '1';
            } else {
                return '0';
            }
        } else {
            return '0';
        }
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function resetPasienPeriksa()
    {
        if ($this->bulanTahun == date('Y-m')) {
            DB::statement('Update pasiens set prolanis_dm = 0, prolanis_ht = 0;' );
        }
        DB::statement("Update periksas set prolanis_dm = 0, prolanis_ht = 0 where tanggal like '" . $this->bulanTahun . "';" );
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function updatePasienPeriksa()
    {
        if ($this->bulanTahun == date('Y-m')) {
            $pasien_dm = Pasien::whereIn('id', $this->riwayat_dm_pasien_ids)->update([
                'prolanis_dm' => 1
            ]);

            $pasiens_ht = Pasien::whereIn('id', $this->riwayat_ht_pasien_ids)->update([
                'prolanis_ht' => 1
            ]);
        }

        /* dd( '$this->bulanTahun' ,  $this->bulanTahun  ); */

        $periksa_ht = Periksa::where('tanggal', 'like', $this->bulanTahun . '%')->whereIn('pasien_id', $this->riwayat_ht_pasien_ids)->update([
            'prolanis_ht' => 1
        ]);

        $periksa_dm = Periksa::where('tanggal', 'like', $this->bulanTahun . '%')->whereIn('pasien_id', $this->riwayat_dm_pasien_ids)->update([
            'prolanis_dm' => 1
        ]);
    }
}
