<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\RumahSakit;
use App\Fasilitas;
use App\BpjsCenter;
use App\Classes\Yoga;

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
		return view('rumahsakits.create');
	}

	/**
	 * Store a newly created rumahsakit in storage.
	 *
	 * return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Rumahsakit::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Rumahsakit::create($data);

		return \Redirect::route('rumahsakits.index');
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
        
       //Perintah untuk menghapus SPESIALISASI 
        $spesialis = Input::get('spesialis');
        $bpjscenter = Input::get('bpjscenter');

        $spesialis = json_decode($spesialis, true);
        $bpjscenter = json_decode($bpjscenter, true);
        $spesialis_awal = RumahSakit::find($id)->tujuanRujuk;
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
        $bpjscenter_awal = RumahSakit::find($id)->bpjsCenter;
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

        $pesan = Yoga::suksesFlash('Update berhasil');
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
