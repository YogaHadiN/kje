<?php

namespace App\Http\Controllers;

use Input;
use Auth;
use Excel;

use App\Models\PesertaBpjsPerbulan;
use App\Models\UpdateRpptPeserta;
use App\Models\Classes\Yoga;
use App\Models\Pasien;
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
        $peserta_bpjs_perbulans = PesertaBpjsPerbulan::latest()->get();
        return view('peserta_bpjs_perbulans.index', compact(
            'peserta_bpjs_perbulans'
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
        $import = new PesertaBpjsPerbulanImport;
        $import->bulanTahun = Input::get('tahun') . '-' . Input::get('bulan');

        Excel::import($import, Input::file('nama_file'));

        $data                        = $import->data;
        $ht                          = $data['ht'];
        $dm                          = $data['dm'];
        $this->jumlah_dm             = $import->riwayat_dm;
        $this->jumlah_ht             = $import->riwayat_ht;
        $this->bulanTahun            = $import->bulanTahun;
        $this->riwayat_dm_pasien_ids = $import->riwayat_dm_pasien_ids;
        $this->riwayat_ht_pasien_ids = $import->riwayat_ht_pasien_ids;

        $this->resetPasienPeriksa();
        $this->updatePasienPeriksa();
        $bulanTahun = Input::get('tahun') . '-' . Input::get('bulan');

        /* $ids = []; */
        /* foreach ($ht as $h) { */
        /*     foreach ($h['pasiens'] as $p) { */
        /*         $ids[] = $p->id; */
        /*     } */
        /* } */
        /* foreach ($dm as $h) { */
        /*     foreach ($h['pasiens'] as $p) { */
        /*         $ids[] = $p->id; */
        /*     } */
        /* } */

        /* $periksa_ids = []; */
        /* $periksas = Periksa::where('tanggal', 'like', $this->bulanTahun. '%')->whereIn('pasien_id', $ids)->get(); */
        /* foreach ($periksas as $prx) { */
        /*     $periksa_ids[] = $prx->pasien->nama; */
        /* } */
        /* dd( $periksa_ids ); */


        $nama_file  = $this->fileUpload('nama_file');
        $jumlah_dm  = $this->jumlah_dm;
        $jumlah_ht  = $this->jumlah_ht;
        return view('peserta_bpjs_perbulans.edit_data_pasien', compact(
            'nama_file',
            'jumlah_dm',
            'jumlah_ht',
            'ht',
            'bulanTahun',
            'dm'
        ));

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
