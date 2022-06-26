<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AntrianApotek;
use App\Models\AntrianPeriksa;
use App\Models\Antrian;
use App\Models\PengantarPasien;
use Input;
use App\Models\Classes\Yoga;
use DB;

class AntrianApotekController extends Controller
{
    public function index(){
        $antrianapoteks = AntrianApotek::with('periksa.pasien', 'periksa.asuransi', 'antrian.jenis_antrian')->get();
        /* dd( $antrianapoteks ); */
        return view('antrianapoteks.index', compact(
            'antrianapoteks'
        ));
    }
    public function create(){
        return view('antrianapoteks.create');
    }
    public function edit($id){
        $antrianapotek = AntrianApotek::find($id);
        return view('antrianapoteks.edit', compact('antrianapotek'));
    }
    public function store(Request $request){
        dd( Input::all() );
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $antrianapotek = new AntrianApotek;
        $antrianapotek = $this->processData($antrianapotek);

        $pesan = Yoga::suksesFlash('AntrianApotek baru berhasil dibuat');
        return redirect('antrianapoteks')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $antrianapotek = AntrianApotek::find($id);
        $antrianapotek = $this->processData($antrianapotek);

        $pesan = Yoga::suksesFlash('AntrianApotek berhasil diupdate');
        return redirect('antrianapoteks')->withPesan($pesan);
    }
    public function destroy($id){
        AntrianApotek::destroy($id);
        $pesan = Yoga::suksesFlash('AntrianApotek berhasil dihapus');
        return redirect('antrianapoteks')->withPesan($pesan);
    }

    public function processData($antrianapotek){
        dd( 'processData belum diatur' );
        $antrianapotek = $this->antrianapotek;
        $antrianapotek->save();

        return $antrianapotek;
    }
    public function import(){
        return 'Not Yet Handled';
        $file      = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files', $file_name);
        $results   = Excel::load('files/' . $file_name, function($reader){
            $reader->all();
        })->get();
        $antrianapoteks     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $antrianapoteks[] = [

                // Do insert here

							'tenant_id'  => session()->get('tenant_id'),
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        AntrianApotek::insert($antrianapoteks);
        $pesan = Yoga::suksesFlash('Import Data Berhasil');
        return redirect()->back()->withPesan($pesan);
    }
    private function valid( $data ){
        dd( 'validasi belum diatur' );
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'data'           => 'required',
        ];
        $validator = \Validator::make($data, $rules, $messages);
        
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
    }
    public function kembali($id){
        $antrianapotek = AntrianApotek::with( 'periksa.pasien' )->where('id', $id)->first();
		if (!is_null($antrianapotek)) {

            $periksa = $antrianapotek->periksa;

			$antrian              = new AntrianPeriksa;
			$antrian->poli        = $periksa->poli;
			$antrian->periksa_id  = $periksa->periksa_id;
			$antrian->staf_id     = $periksa->staf_id;
			$antrian->asuransi_id = $periksa->asuransi_id;
			$antrian->asisten_id  = $periksa->asisten_id;
			$antrian->pasien_id   = $periksa->pasien_id;
			$antrian->jam         = $periksa->jam;
			$antrian->tanggal     = $periksa->tanggal;
			$antrian->save();

			$periksa->antrian_periksa_id = $antrian->id;
			$periksa->save();

			Antrian::where('antriable_id', $antrianapotek->id)
				->where('antriable_type', 'App\Models\AntrianApotek')
				->update([
					'antriable_id'   => $antrian->id,
					'antriable_type' => 'App\Models\AntrianPeriksa'
				]);

			PengantarPasien::where('antarable_id', $antrianapotek->id)
				->where('antarable_type', 'App\ModelsModels\\AntrianApotek')
				->update([
					'antarable_id'   => $antrian->id,
					'antarable_type' => 'App\Models\AntrianPeriksa'
				]);

			$nama = $antrianapotek->periksa->pasien_id . '-' . $antrianapotek->periksa->pasien->nama;
			$antrianapotek->delete();
			$pesan = Yoga::suksesFlash('Pasien <strong>' . $nama . '</strong> Berhasil dikembalikan ke antrian apotek');
			return redirect()->back()->withPesan($pesan);
		} else {
			$pesan = Yoga::gagalFlash('Pasien sudah ada tidak ada di antrian poli ' . $antrian->poli);
			return redirect()->back()->withPesan($pesan);
		}
    }
}
