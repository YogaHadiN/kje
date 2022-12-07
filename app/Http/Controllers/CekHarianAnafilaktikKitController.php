<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use App\Models\Ruangan;
use App\Models\Classes\Yoga;
use App\Models\CekHarianAnafilaktikKit;

class CekHarianAnafilaktikKitController extends Controller
{
    public function create($ruangan_id){
        $ruangan = Ruangan::find($ruangan_id);
        return view('cek_harian_anafilaktik_kits.create', compact('ruangan'));
    }
    public function store($ruangan_id){
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'jumlah_epinefrin_inj'             => ['required', 'numeric'],
            'jumlah_epinefrin_inj_image'       => ['required','mimes:jpeg,jpg,png,gif'. 'max:10000' ],
            'jumlah_dexamethasone_inj'         => ['required', 'numeric'],
            'jumlah_dexamethasone_inj_image'   => ['required','mimes:jpeg,jpg,png,gif'. 'max:10000' ],
            'jumlah_ranitidine_inj'            => ['required', 'numeric'],
            'jumlah_ranitidine_inj_image'      => ['required','mimes:jpeg,jpg,png,gif'. 'max:10000' ],
            'jumlah_diphenhydramine_inj'       => ['required', 'numeric'],
            'jumlah_diphenhydramine_inj_image' => ['required','mimes:jpeg,jpg,png,gif'. 'max:10000' ],
            'jumlah_spuit_3cc'                 => ['required', 'numeric'],
            'jumlah_spuit_3cc_image'           => ['required','mimes:jpeg,jpg,png,gif'. 'max:10000' ],
        ];

        $validator = \Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        $cek_harian_anafilaktik_kit = new CekHarianAnafilaktikKit;
        $cek_harian_anafilaktik_kit = $this->inputData($cek_harian_anafilaktik_kit, $ruangan_id);

        $pesan = Yoga::suksesFlash('Cek List Harian Berhasil Dibuat');
        return redirect('cek_list_harians/' . $ruangan_id )->withPesan($pesan);
    }

    /**
     * undocumented function
     *
     * @return void
     */
    private function inputData($cek_harian_anafilaktik_kit,$ruangan_id){

        $cek_harian_anafilaktik_kit->jumlah_epinefrin_inj       = Input::get('jumlah_epinefrin_inj');
        $cek_harian_anafilaktik_kit->jumlah_dexamethasone_inj   = Input::get('jumlah_dexamethasone_inj');
        $cek_harian_anafilaktik_kit->jumlah_ranitidine_inj      = Input::get('jumlah_ranitidine_inj');
        $cek_harian_anafilaktik_kit->jumlah_diphenhydramine_inj = Input::get('jumlah_diphenhydramine_inj');
        $cek_harian_anafilaktik_kit->jumlah_spuit_3cc           = Input::get('jumlah_spuit_3cc');
        $cek_harian_anafilaktik_kit->ruangan_id                 = $ruangan_id;
        $cek_harian_anafilaktik_kit->save();

        $cek_harian_anafilaktik_kit->jumlah_epinefrin_inj_image       =
            uploadFile(
                'jumlah_epinefrin_inj', 
                'jumlah_epinefrin_inj_image', 
                $cek_harian_anafilaktik_kit->id, 
                'cek_harian_anafilaktik_kit'
            );
        $cek_harian_anafilaktik_kit->jumlah_dexamethasone_inj_image   =
            uploadFile(
                'jumlah_dexamethasone_inj', 
                'jumlah_dexamethasone_inj_image', 
                $cek_harian_anafilaktik_kit->id, 
                'cek_harian_anafilaktik_kit'
            );
        $cek_harian_anafilaktik_kit->jumlah_ranitidine_inj_image      =
            uploadFile(
                'jumlah_ranitidine_inj', 
                'jumlah_ranitidine_inj_image', 
                $cek_harian_anafilaktik_kit->id, 
                'cek_harian_anafilaktik_kit'
            );
        $cek_harian_anafilaktik_kit->jumlah_diphenhydramine_inj_image =
            uploadFile(
                'jumlah_diphenhydramine_inj', 
                'jumlah_diphenhydramine_inj_image', 
                $cek_harian_anafilaktik_kit->id, 
                'cek_harian_anafilaktik_kit'
            );
        $cek_harian_anafilaktik_kit->jumlah_spuit_3cc_image           =
            uploadFile(
                'jumlah_spuit_3cc', 
                'jumlah_spuit_3cc_image', 
                $cek_harian_anafilaktik_kit->id, 
                'cek_harian_anafilaktik_kit'
            );

        $cek_harian_anafilaktik_kit->save();
        return $cek_harian_anafilaktik_kit;
    }

    public function edit($id){
        $cek_harian_anafilaktik_kit = CekHarianAnafilaktikKit::find($id);
        $ruangan = $cek_harian_anafilaktik_kit->ruangan;



        return view('cek_harian_anafilaktik_kits.edit', compact(
            'ruangan',
            'cek_harian_anafilaktik_kit'
        ));
    }

    public function update($id){
        /* dd(Input::all()); */ 
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'jumlah_epinefrin_inj'             => ['required', 'numeric'],
            'jumlah_epinefrin_inj_image'       => ['required','mimes:jpeg,jpg,png,gif'. 'max:10000' ],
            'jumlah_dexamethasone_inj'         => ['required', 'numeric'],
            'jumlah_dexamethasone_inj_image'   => ['required','mimes:jpeg,jpg,png,gif'. 'max:10000' ],
            'jumlah_ranitidine_inj'            => ['required', 'numeric'],
            'jumlah_ranitidine_inj_image'      => ['required','mimes:jpeg,jpg,png,gif'. 'max:10000' ],
            'jumlah_diphenhydramine_inj'       => ['required', 'numeric'],
            'jumlah_diphenhydramine_inj_image' => ['required','mimes:jpeg,jpg,png,gif'. 'max:10000' ],
            'jumlah_spuit_3cc'                 => ['required', 'numeric'],
            'jumlah_spuit_3cc_image'           => ['required','mimes:jpeg,jpg,png,gif'. 'max:10000' ],
        ];

        $validator = \Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        $cek_harian_anafilaktik_kit = CekHarianAnafilaktikKit::find($id);
        $cek_harian_anafilaktik_kit = $this->inputData($cek_harian_anafilaktik_kit, $cek_harian_anafilaktik_kit->ruangan_id);

        $pesan = Yoga::suksesFlash('Cek List Harian Berhasil Dibuat');
        return redirect('cek_list_harians/' . $cek_harian_anafilaktik_kit->ruangan_id )->withPesan($pesan);
    }
}
