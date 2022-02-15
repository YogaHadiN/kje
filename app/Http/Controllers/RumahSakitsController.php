<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use App\Models\RumahSakit;
use App\Models\Fasilitas;
use App\Models\BpjsCenter;
use App\Models\JenisRumahSakit;
use App\Models\Rayon;
use App\Models\Classes\Yoga;

class RumahSakitsController extends Controller
{

	/**
	 * Display a listing of rumahsakits
	 *
	 * @return Response
	 */
	public function index()
	{
		$rumahsakits = Rumahsakit::all();
		return view('rumahsakits.index', compact('rumahsakits'));
	}

	/**
	 * Show the form for creating a new rumahsakit
	 *
	 * @return Response
	 */
	public function create()
	{
		$termasukBpjsOptions = [
			null => '- Pilih -',
			0 => 'Tidak Melayani',
			1 => 'Melayani'
		];

		$jenisRumahSakitOptions = array(null => '- Pilih Staf -') + JenisRumahSakit::pluck('jenis_rumah_sakit', 'id')->all();
		$tipeRumahSakitOptions = [
			null => '- Pilih -',
			'A' => 'A',
			'B' => 'B',
			'C' => 'C',
			'D' => 'D'
		];
		$rayonOptions = array(null => '- Pilih Rayon -') + Rayon::pluck('rayon', 'id')->all();

		return view('rumahsakits.create', compact('jenisRumahSakitOptions','termasukBpjsOptions', 'tipeRumahSakitOptions', 'rayonOptions'));
	}

	/**
	 * Store a newly created rumahsakit in storage.
	 
	 * return Response
	 */
	public function store()
	{

		$rules = [
		  "nama" => "required",
		  "alamat" => "required",
		  "jenis_rumah_sakit" => "required",
		  "tipe_rumah_sakit" => "required",
		  "rayon_id" => "required",
		  "bpjs" => "required"
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}


		$rs       = new RumahSakit;
		$rs->nama = Input::get('nama');
		$rs->alamat = Input::get('alamat');
		$rs->jenis_rumah_sakit = Input::get('jenis_rumah_sakit');
		$rs->tipe_rumah_sakit = Input::get('tipe_rumah_sakit');
		$rs->kode_pos = Input::get('kode_pos');
		$rs->telepon = Input::get('telepon');
		$rs->fax = Input::get('fax');
		$rs->email = Input::get('email');
		$rs->rayon_id = Input::get('rayon_id');
		$rs->bpjs = Input::get('bpjs');
		$confirm = $rs->save();

		if ($confirm) {
			$pesan = Yoga::suksesFlash('Input Rumah Sakit '. $rs->id . ' - ' . $rs->nama . ' <strong>BERHASIL</strong>');
		}else {
			$pesan = Yoga::gagalFlash('Input Rumah Sakit '. $rs->id . ' - ' . $rs->nama . ' <strong>GAGAL</strong>');
		}
		return redirect('rumahsakits')->withPesan($pesan);
	}

	/**
	 * Display the specified rumahsakit.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$rumahsakit = Rumahsakit::findOrFail($id);

		return view('rumahsakits.show', compact('rumahsakit'));
	}

	/**
	 * Show the form for editing the specified rumahsakit.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$rumahsakit = Rumahsakit::find($id);

		return view('rumahsakits.edit', compact('rumahsakit'));
	}

	/**
	 * Update the specified rumahsakit in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        
		$rules = [
			'nama' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
       //Perintah untuk menghapus SPESIALISASI 
        $spesialis = Input::get('spesialis');
        $bpjscenter = Input::get('bpjscenter');

		$rs = RumahSakit::find($id);
		$rs->nama = Input::get('nama');
		$rs->alamat = Input::get('alamat');
		$rs->telepon = Input::get('telepon');
		$rs->save();

        $spesialis = json_decode($spesialis, true);
        $bpjscenter = json_decode($bpjscenter, true);
        $spesialis_awal = $rs->tujuanRujuk;
        $delete_tujuan_rujuk = [];
        foreach ($spesialis_awal as $sp) {
            $kosong = true;
            foreach ($spesialis as $s) {
                if ($sp->id == $s['id']) {
                    $kosong = false;
                    break;
                }
            }
            if ($kosong) {
               $delete_tujuan_rujuk[] = $sp->id; 
            }    
        }
        Fasilitas::where('rumah_sakit_id', $id)->whereIn('tujuan_rujuk_id', $delete_tujuan_rujuk)->delete();

        // create spesialis kalo tidak ada
        foreach ($spesialis as $sp) {
            $kosong = true;
            foreach ($spesialis_awal as $s) {
                if ($s->id == $sp['id']) {
                   $kosong = false; 
                   break;
                }
            }
            if ($kosong) {
                $f = new Fasilitas;
                $f->tujuan_rujuk_id = $sp['id'];
                $f->rumah_sakit_id = $id;
                $f->save();
            }
        }

       //menghapus BPJS center yang dihapus 
        $bpjscenter_awal = $rs->bpjsCenter;
        $delete_bpjscenter = [];
        foreach ($bpjscenter as $b) {
                if ($b['id'] == null) {
                    $bp = new BpjsCenter;
                    $bp->nama = $b['nama'];
                    $bp->telp = $b['telp'];
                    $bp->rumah_sakit_id = $id;
                    $bp->save();
                }else{
                    $bp = BpjsCenter::find($b['id']);
                    $bp->nama = $b['nama'];
                    $bp->telp = $b['telp'];
                    $bp->save();
                }
            }
        
        foreach ($bpjscenter_awal as $bp) {
            $kosong = true;
            foreach ($bpjscenter as $b) {
                if ($bp->id == $b['id']) {
                    $kosong = false;
                    break;
                }
            }
            if ($kosong) {
                $delete_bpjscenter[] = $bp->id;
            }
        }
        BpjsCenter::destroy($delete_bpjscenter);

        $pesan = Yoga::suksesFlash('Update ' . $rs->id . ' - ' . $rs->nama . ' berhasil');
        return redirect('rumahsakits')->withPesan($pesan);
	}

	/**
	 * Remove the specified rumahsakit from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$confirm = Rumahsakit::destroy($id);
        if ($confirm) {
            $pesan = Yoga::suksesFlash('Rumah Sakit Berhasil Dihapus');
        } else {
            $pesan = Yoga::gagalFlash('Rumah Sakit Gagal Dihapus');
        }

		return redirect('rumahsakits/'. $id)->withPesan($pesan);
	}

}
