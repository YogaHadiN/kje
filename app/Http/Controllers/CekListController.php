<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CekList;
use Input;
use App\Models\Classes\Yoga;
use DB;
class CekListController extends Controller
{
    public function index(){
        $cek_lists = CekList::all();
        return view('cek_lists.index', compact(
            'cek_lists'
        ));
    }
    public function create(){
        return view('cek_lists.create');
    }
    public function edit($id){
        $cek_list = CekList::find($id);
        return view('cek_lists.edit', compact('cek_list'));
    }
    public function store(Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $cek_list = new CekList;
        $cek_list = $this->processData($cek_list);

        $pesan = Yoga::suksesFlash('CekList baru berhasil dibuat');
        return redirect('cek_lists')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $cek_list = CekList::find($id);
        $cek_list = $this->processData($cek_list);

        $pesan = Yoga::suksesFlash('CekList berhasil diupdate');
        return redirect('cek_lists')->withPesan($pesan);
    }
    public function destroy($id){
        CekList::destroy($id);
        $pesan = Yoga::suksesFlash('CekList berhasil dihapus');
        return redirect('cek_lists')->withPesan($pesan);
    }

    public function processData($cek_list){
        $cek_list->cek_list = Input::get('cek_list');
        $cek_list->save();

        return $cek_list;
    }
    public function import(){
        return 'Not Yet Handled';
        // run artisan : php artisan make:import CekListImport 
        // di dalam file import :
        // use App\Models\CekList;
        // use Illuminate\Support\Collection;
        // use Maatwebsite\Excel\Concerns\ToCollection;
        // use Maatwebsite\Excel\Concerns\WithHeadingRow;
        // class CekListImport implements ToCollection, WithHeadingRow
        // {
        // 
        //     public function collection(Collection $rows)
        //     {
        //         return $rows;
        //     }
        // }

        $rows = Excel::toArray(new CekListImport, Input::file('file'))[0];
        $cek_lists     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $cek_lists[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        CekList::insert($cek_lists);
        $pesan = Yoga::suksesFlash('Import Data Berhasil');
        return redirect()->back()->withPesan($pesan);
    }
    private function valid( $data ){
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'cek_list'           => 'required',
        ];
        $validator = \Validator::make($data, $rules, $messages);
        
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
    }
}
