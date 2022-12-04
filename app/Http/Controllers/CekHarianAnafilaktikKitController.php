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
        /* dd(Input::all()); */ 
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'jumlah_epinefrin_inj'         => ['required', 'numeric'],
            'jumlah_dexamethasone_inj'     => ['required', 'numeric'],
            'jumlah_ranitidine_inj'        => ['required', 'numeric'],
            'jumlah_diphenhydramine_inj'   => ['required', 'numeric'],
            'jumlah_spuit_3cc'             => ['required', 'numeric'],
            'oksigen_bisa_dipakai'         => ['required', 'numeric'],
            'jumlah_gudel_anak'            => ['required', 'numeric'],
            'jumlah_gudel_dewasa'          => ['required', 'numeric'],
            'jumlah_infus_set'             => ['required', 'numeric'],
            'jumlah_nacl'                  => ['required', 'numeric'],
            'jumlah_tiang_Infus'           => ['required', 'numeric'],
            'image_anafilaktik_kit_tembok' => ['nullable','mimes:jpeg,jpg,png,gif'. 'max:10000' ],
            'image_anafilaktik_kit_box'    => ['nullable','mimes:jpeg,jpg,png,gif'. 'max:10000' ]
        ];

        $validator = \Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        $cek_harian_anafilaktik_kit = $this->inputData($ruangan_id);

        $pesan = Yoga::suksesFlash('Cek List Harian Berhasil Dibuat');
        return redirect('cek_list_harians/' . $ruangan_id )->withPesan($pesan);
    }

    /**
     * undocumented function
     *
     * @return void
     */
    private function inputData($ruangan_id){
        $cek_harian_anafilaktik_kit                             = new CekHarianAnafilaktikKit;
        $cek_harian_anafilaktik_kit->jumlah_epinefrin_inj       = Input::get('jumlah_epinefrin_inj');
        $cek_harian_anafilaktik_kit->jumlah_dexamethasone_inj   = Input::get('jumlah_dexamethasone_inj');
        $cek_harian_anafilaktik_kit->jumlah_ranitidine_inj      = Input::get('jumlah_ranitidine_inj');
        $cek_harian_anafilaktik_kit->jumlah_diphenhydramine_inj = Input::get('jumlah_diphenhydramine_inj');
        $cek_harian_anafilaktik_kit->jumlah_spuit_3cc           = Input::get('jumlah_spuit_3cc');
        $cek_harian_anafilaktik_kit->oksigen_bisa_dipakai       = Input::get('oksigen_bisa_dipakai');
        $cek_harian_anafilaktik_kit->jumlah_gudel_anak          = Input::get('jumlah_gudel_anak');
        $cek_harian_anafilaktik_kit->jumlah_gudel_dewasa        = Input::get('jumlah_gudel_dewasa');
        $cek_harian_anafilaktik_kit->jumlah_infus_set           = Input::get('jumlah_infus_set');
        $cek_harian_anafilaktik_kit->jumlah_nacl                = Input::get('jumlah_nacl');
        $cek_harian_anafilaktik_kit->jumlah_tiang_Infus         = Input::get('jumlah_tiang_Infus');
        $cek_harian_anafilaktik_kit->ruangan_id                 = $ruangan_id
        $cek_harian_anafilaktik_kit->save();

        $cek_harian_anafilaktik_kit->image_anafilaktik_kit_tembok = uploadFile('anafilaktik_kit_tembok', 'image_anafilaktik_kit_tembok', $cek_harian_anafilaktik_kit->id, 'cek_harian_anafilaktik_kit/tembok');
        $cek_harian_anafilaktik_kit->image_anafilaktik_kit_box    = uploadFile('anafilaktik_kit_box', 'image_anafilaktik_kit_box', $cek_harian_anafilaktik_kit->id, 'cek_harian_anafilaktik_kit/box');
        $cek_harian_anafilaktik_kit->save();

        return $cek_harian_anafilaktik_kit;
    }
}
