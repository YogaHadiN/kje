<?php

namespace App\Models;

use App\Models\Classes\Yoga;
use Carbon\Carbon;
use DB;
use Image;
use Storage;

use Illuminate\Database\Eloquent\Model;

class Periksa extends Model{
    public $incrementing = false; 
    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';
	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];


	protected $dates = ['created_at'];

	protected $guarded = [];

	public function asuransi(){
		return $this->belongsTo('App\Models\Asuransi');
	}
	public function diagnosa(){
		return $this->belongsTo('App\Models\Diagnosa');
	}

	public function klaim_gdp_bpjs(){
		return $this->hasOne('App\Models\KlaimGdpBpjs');
	}

	public function getGdpBpjsAttribute(){
        /* dd(  json_decode($this->transaksi,true)  ); */
        if ( $this->asuransi_id == '32' ) { //BPJS
            foreach (  json_decode($this->transaksi,true)   as $trx) {
                if ( $trx['jenis_tarif_id'] == '116' ) {
                    return $trx['keterangan_tindakan'];
                }
            }
        }
        return 0;
	}

    public function pasien(){
        return $this->belongsTo('App\Models\Pasien');
    }
    public function staf(){
        return $this->belongsTo('App\Models\Staf');      
    }
    public function jenisTarif(){

        return $this->belongsTo('App\Models\JenisTarif');      
    }
    public function merek(){
        return $this->belongsTo('App\Models\Merek');      
    }

    public function rujukan(){
        return $this->hasOne('App\Models\Rujukan');
    }
    public function usg(){
        return $this->hasOne('App\Models\Usg');
    }
    public function terapii(){
        return $this->hasMany('App\Models\Terapi');
    }
    public function transaksii(){
        return $this->hasMany('App\Models\TransaksiPeriksa');
    }
    public function registerAnc(){
        return $this->hasOne('App\Models\RegisterAnc');
    }
    public function suratSakit(){
        return $this->hasOne('App\Models\SuratSakit');
    }
    /* public function getSistolikAttribute($value) { */
    /*     $tanggal = Carbon::parse($this->tanggal); */
    /*     if ( */
    /*         $value >= '140' && // jika tekanan darah lebih sama dengan  140 */
    /*         $this->prolanis_ht == 1 && // dan pasien terhitung sebagai denominator prolanis hipertensi */
    /*         $this->asuransi_id == '32' && // dengan pemeriksaan asuransi BPJS */
    /*         $tanggal->diffInDays() < 4 // jika masih kurang dari 3 hari */ 
    /*     ){ */
    /*         return '130'; */
    /*     } else { */
    /*        return $value; */
    /*     } */
    /* } */
    /* public function getDiastolikAttribute($value) { */
    /*     $tanggal = Carbon::parse($this->tanggal); */
    /*     if ( */
    /*         $value >= '80' && */
    /*         $this->prolanis_ht == 1 && // dan pasien terhitung sebagai denominator prolanis hipertensi */
    /*         $this->asuransi_id == '32' && // dengan pemeriksaan asuransi BPJS */
    /*         $tanggal->diffInDays() < 4 // jika masih kurang dari 3 hari */ 
    /*     ) { */
    /*         return '70'; */
    /*     } else { */
    /*         return $value; */
    /*     } */
    /* } */
    public function getTerapiHtmlAttribute(){
        $puyer   = false;
        $add     = false;
        $terapis = $this->terapii;
        $terapi  = json_encode($terapis);

        if($terapi != ""){
                $MyArray = $terapis;
            } else {
                $MyArray = [];
            }
            $tempFirst = '<table width="100%" class="tabelTerapi">';
            $temp = $tempFirst;
          if (count($MyArray) > 0){

            for ($i = 0; $i < count($MyArray) - 1; $i++) {

                if (substr($MyArray[$i]->signa, 0, 5) == "Puyer" && $puyer == false ) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]->merek_id . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]->merek->merek . '</a></td>';
                    $temp .= '<td> No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr>';

                    if ($MyArray[$i]->signa == $MyArray[$i + 1]->signa) {
                       $puyer = true;
                    } else {
                       $puyer = false;
                    }


                } else if (substr($MyArray[$i]->signa, 0, 5) == "Puyer" && $puyer == true) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]->merek_id . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]->merek->merek . '</a></td>';
                    $temp .= '<td> No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr>';

                    if ($MyArray[$i]->signa == $MyArray[$i + 1]->signa) {
                        $puyer = true;
                    } else {
                       $puyer = false;
                    }

                } else if ($MyArray[$i]->merek_id == -1 || $MyArray[$i]->merek_id == -3) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap class="merek">Buat Menjadi ' . $MyArray[$i]->jumlah . ' puyer ' . $MyArray[$i]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;"  nowrap>' . $MyArray[$i]->aturan_minum . '</td>';
                    $temp .= '</tr>';

                   $puyer = false;

                } else if (substr($MyArray[$i]->signa, 0, 3) == "Add" && $add == false) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]->merek_id . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]->merek->merek . '</a></td>';
                    $temp .= '<td> fls No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr>';
                    $temp .= '<tr>';
                    $temp .= '<td style="text-align:center;" colspan="3">ADD</td>';
                    $temp .= '</tr>';

                    $add = true;


                } else if (substr($MyArray[$i]->signa, 0, 3) == "Add" && $add == true) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]->merek_id . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]->merek->merek . '</a></td>';
                    $temp .= '<td> No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr>';

                    if ($MyArray[$i]->signa == $MyArray[$i + 1]->signa) {
                        $add = true;
                    } else {
                        $add = false;
                    }

                } else if ($MyArray[$i]->merek_id == -2) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap>S Masukkan ke dalam sirup ' . $MyArray[$i]->signa . ' </td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>Dihabiskan</td>';
                    $temp .= '</tr>';

                   $puyer = false;

                } else {
                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]->merek_id . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]->merek->merek . '</a></td>';
                    $temp .= '<td> No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr><tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap> S ' . $MyArray[$i]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>' . $MyArray[$i]->aturan_minum . '</td>';
                    $temp .= '</tr>';
                }
            }

          

                $a = count($MyArray) - 1;


                if ($MyArray[$a]->merek_id == -1 || $MyArray[$a]->merek_id == -3) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap class="merek">Buat Menjadi ' . $MyArray[$a]->jumlah . ' puyer ' . $MyArray[$a]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>' . $MyArray[$a]->aturan_minum . '</td>';

                   $puyer = false;

                } else if ($MyArray[$a]->merek_id == -2) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap>S Masukkan ke dalam sirup ' . $MyArray[$a]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>Dihabiskan</td>';

                    $add = false;
                } else if (substr($MyArray[$a]->signa, 0, 3) == "Add" && $add == false) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]->merek_id . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]->merek->merek . '</a></td>';
                    $temp .= '<td nowrap> fls No : ' . $MyArray[$a]->jumlah . '</td>';
                    $temp .= '</tr>';
                    $temp .= '<tr>';
                    $temp .= '<td  style="text-align:center;" colspan="3">ADD</td>';

                    $add = true;


                } else if (substr($MyArray[$a]->signa, 0, 3) == "Add" && $add == true) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]->merek_id . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]->merek->merek . '</a></td>';
                    $temp .= '<td> No : ' . $MyArray[$a]->jumlah . '</td>';


                } else if (substr($MyArray[$a]->signa, 0, 5) == "Puyer" && $puyer == false) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]->merek_id . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]->merek->merek . '</a></td>';
                    $temp .= '<td> No : ' . $MyArray[$a]->jumlah . '</td>';

                } else if (substr($MyArray[$a]->signa, 0, 5) == "Puyer" && $puyer == true) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]->merek_id . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]->merek->merek . '</a></td>';
                    $temp .= '<td> No : ' . $MyArray[$a]->jumlah . '</td>';

                } else {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]->merek_id . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]->merek->merek . '</a></td>';
                    $temp .= '<td> No : ' . $MyArray[$a]->jumlah . '</td>';
                    $temp .= '</tr><tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap> S ' . $MyArray[$a]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>' . $MyArray[$a]->aturan_minum . '</td>';
                }
             }
            $temp .= '</tr></table>';


                if (trim($temp) == $tempFirst . '</tr></table>') {
                    return nl2br(html_entity_decode($this->terapi));
                } elseif ($temp !='[]') {
                    return $temp;
                }

    }
    public function getTerapiHtmllAttribute(){
        $puyer = false;
        $add = false;

        $terapi = json_encode($this->terapii);

        if($terapi != ""){
                $MyArray = $this->terapii;
            } else {
                $MyArray = [];
            }
            $temp = '<table width="100%" class="tabelTerapi2 table table-condensed">';
          if (count($MyArray) > 0){

            for ($i = 0; $i < count($MyArray) - 1; $i++) {

                if (substr($MyArray[$i]->signa, 0, 5) == "Puyer" && $puyer == false ) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$i]->merek->merek. ' <strong>[  ' . $MyArray[$i]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr>';

                    if ($MyArray[$i]->signa == $MyArray[$i + 1]->signa) {
                       $puyer = true;
                    } else {
                       $puyer = false;
                    }


                } else if (substr($MyArray[$i]->signa, 0, 5) == "Puyer" && $puyer == true) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$i]->merek->merek. ' <strong>[  ' . $MyArray[$i]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr>';

                    if ($MyArray[$i]->signa == $MyArray[$i + 1]->signa) {
                        $puyer = true;
                    } else {
                       $puyer = false;
                    }

                } else if ($MyArray[$i]->merek_id == -1 || $MyArray[$i]->merek_id == -3) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap class="merek">Buat Menjadi ' . $MyArray[$i]->jumlah . ' puyer ' . $MyArray[$i]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;"  nowrap>' . $MyArray[$i]->aturan_minum . '</td>';
                    $temp .= '</tr>';

                   $puyer = false;

                } else if (substr($MyArray[$i]->signa, 0, 3) == "Add" && $add == false) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$i]->merek->merek. ' <strong>[  ' . $MyArray[$i]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> fls No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr>';
                    $temp .= '<tr>';
                    $temp .= '<td style="text-align:center;" colspan="3">ADD</td>';
                    $temp .= '</tr>';

                    $add = true;


                } else if (substr($MyArray[$i]->signa, 0, 3) == "Add" && $add == true) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$i]->merek->merek. ' <strong>[  ' . $MyArray[$i]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr>';

                    if ($MyArray[$i]->signa == $MyArray[$i + 1]->signa) {
                        $add = true;
                    } else {
                        $add = false;
                    }

                } else if ($MyArray[$i]->merek_id == -2) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap>S Masukkan ke dalam sirup ' . $MyArray[$i]->signa . ' </td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>Dihabiskan</td>';
                    $temp .= '</tr>';

                   $puyer = false;

                } else {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$i]->merek->merek. ' <strong>[  ' . $MyArray[$i]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr><tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap> S ' . $MyArray[$i]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>' . $MyArray[$i]->aturan_minum . '</td>';
                    $temp .= '</tr>';
                }
            }

                $a = count($MyArray) - 1;
                if ($MyArray[$a]->merek_id == -1 || $MyArray[$a]->merek_id == -3) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap class="merek">Buat Menjadi ' . $MyArray[$a]->jumlah . ' puyer ' . $MyArray[$a]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>' . $MyArray[$a]->aturan_minum . '</td>';

                   $puyer = false;

                } else if ($MyArray[$a]->merek_id == -2) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap >S Masukkan ke dalam sirup ' . $MyArray[$a]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>Dihabiskan</td>';

                    $add = false;
                } else if (substr($MyArray[$a]->signa, 0, 3) == "Add" && $add == false) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$a]->merek->merek. ' <strong>[  ' . $MyArray[$a]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> fls No : ' . $MyArray[$a]->jumlah . '</td>';
                    $temp .= '</tr>';
                    $temp .= '<tr>';
                    $temp .= '<td  style="text-align:center;" colspan="3">ADD</td>';

                    $add = true;


                } else if (substr($MyArray[$a]->signa, 0, 3) == "Add" && $add == true) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$a]->merek->merek. ' <strong>[  ' . $MyArray[$a]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> No : ' . $MyArray[$a]->jumlah . '</td>';


                } else if (substr($MyArray[$a]->signa, 0, 5) == "Puyer" && $puyer == false) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$a]->merek->merek. ' <strong>[  ' . $MyArray[$a]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> No : ' . $MyArray[$a]->jumlah . '</td>';

                } else if (substr($MyArray[$a]->signa, 0, 5) == "Puyer" && $puyer == true) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$a]->merek->merek. ' <strong>[  ' . $MyArray[$a]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> No : ' . $MyArray[$a]->jumlah . '</td>';

                } else {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$a]->merek->merek. ' <strong>[  ' . $MyArray[$a]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> No : ' . $MyArray[$a]->jumlah . '</td>';
                    $temp .= '</tr><tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap> S ' . $MyArray[$a]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>' . $MyArray[$a]->aturan_minum . '</td>';
                }
             }
            $temp .= '</tr></table>';

                if (trim($temp) != '<table width="100%" class="tabelTerapi2 table table-condensed"></tr></table>') {
                    if ($temp != '[]') {
                        return $temp;
                    }
                } else {
                    return nl2br(html_entity_decode($this->terapi));
                }

    }
    public function getTerapiHtmlllAttribute(){
        $puyer = false;
        $add = false;

        $terapi = json_encode($this->terapii);

        if($terapi != ""){
                $MyArray = $this->terapii;
            } else {
                $MyArray = [];
            }
            $temp = '<table width="100%" class="tabelTerapi table table-condensed">';
          if (count($MyArray) > 0){

            for ($i = 0; $i < count($MyArray) - 1; $i++) {
                $MyArray[$i]->merek->rak_id = Merek::find($MyArray[$i]->merek_id)->rak_id;

                if (substr($MyArray[$i]->signa, 0, 5) == "Puyer" && $puyer == false ) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$i]->merek->merek. ' <strong>[  ' . $MyArray[$i]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr>';

                    if ($MyArray[$i]->signa == $MyArray[$i + 1]->signa) {
                       $puyer = true;
                    } else {
                       $puyer = false;
                    }


                } else if (substr($MyArray[$i]->signa, 0, 5) == "Puyer" && $puyer == true) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$i]->merek->merek. ' <strong>[  ' . $MyArray[$i]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr>';

                    if ($MyArray[$i]->signa == $MyArray[$i + 1]->signa) {
                        $puyer = true;
                    } else {
                       $puyer = false;
                    }

                } else if ($MyArray[$i]->merek_id == -1 || $MyArray[$i]->merek_id == -3) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap class="merek">Buat Menjadi ' . $MyArray[$i]->jumlah . ' puyer ' . $MyArray[$i]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;"  nowrap>' . $MyArray[$i]->aturan_minum . '</td>';
                    $temp .= '</tr>';

                   $puyer = false;

                } else if (substr($MyArray[$i]->signa, 0, 3) == "Add" && $add == false) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$i]->merek->merek. ' <strong>[  ' . $MyArray[$i]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> fls No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr>';
                    $temp .= '<tr>';
                    $temp .= '<td style="text-align:center;" colspan="3">ADD</td>';
                    $temp .= '</tr>';

                    $add = true;


                } else if (substr($MyArray[$i]->signa, 0, 3) == "Add" && $add == true) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$i]->merek->merek. ' <strong>[  ' . $MyArray[$i]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr>';

                    if ($MyArray[$i]->signa == $MyArray[$i + 1]->signa) {
                        $add = true;
                    } else {
                        $add = false;
                    }

                } else if ($MyArray[$i]->merek_id == -2) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap>S Masukkan ke dalam sirup ' . $MyArray[$i]->signa . ' </td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>Dihabiskan</td>';
                    $temp .= '</tr>';

                   $puyer = false;

                } else {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$i]->merek->merek. ' <strong>[  ' . $MyArray[$i]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr><tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap> S ' . $MyArray[$i]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>' . $MyArray[$i]->aturan_minum . '</td>';
                    $temp .= '</tr>';
                }
            }

                $a = count($MyArray) - 1;
                $MyArray[$a]->merek->rak_id = Merek::find($MyArray[$a]->merek_id)->rak_id;


                if ($MyArray[$a]->merek_id == -1 || $MyArray[$a]->merek_id == -3) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap class="merek">Buat Menjadi ' . $MyArray[$a]->jumlah . ' puyer ' . $MyArray[$a]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>' . $MyArray[$a]->aturan_minum . '</td>';

                   $puyer = false;

                } else if ($MyArray[$a]->merek_id == -2) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap>S Masukkan ke dalam sirup ' . $MyArray[$a]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>Dihabiskan</td>';

                    $add = false;
                } else if (substr($MyArray[$a]->signa, 0, 3) == "Add" && $add == false) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$a]->merek->merek. ' <strong>[  ' . $MyArray[$a]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> fls No : ' . $MyArray[$a]->jumlah . '</td>';
                    $temp .= '</tr>';
                    $temp .= '<tr>';
                    $temp .= '<td  style="text-align:center;" colspan="3">ADD</td>';

                    $add = true;


                } else if (substr($MyArray[$a]->signa, 0, 3) == "Add" && $add == true) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$a]->merek->merek. ' <strong>[  ' . $MyArray[$a]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> No : ' . $MyArray[$a]->jumlah . '</td>';


                } else if (substr($MyArray[$a]->signa, 0, 5) == "Puyer" && $puyer == false) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$a]->merek->merek. ' <strong>[  ' . $MyArray[$a]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> No : ' . $MyArray[$a]->jumlah . '</td>';

                } else if (substr($MyArray[$a]->signa, 0, 5) == "Puyer" && $puyer == true) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$a]->merek->merek. ' <strong>[  ' . $MyArray[$a]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> No : ' . $MyArray[$a]->jumlah . '</td>';

                } else {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td style="width:150px;text-align:left;" nowrap>' . $MyArray[$a]->merek->merek. ' <strong>[  ' . $MyArray[$a]->merek->rak_id. '  ]</strong></td>';
                    $temp .= '<td> No : ' . $MyArray[$a]->jumlah . '</td>';
                    $temp .= '</tr><tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap> S ' . $MyArray[$a]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>' . $MyArray[$a]->aturan_minum . '</td>';
                }
             }
            $temp .= '</tr></table>';

                if (trim($temp) != '<table width="100%" class="tabelTerapi table table-condensed"></tr></table>') {
                    if ($temp != '[]') {
                        return $temp;
                    }
                } else {
                    return nl2br(html_entity_decode($this->terapi));
                }

    }

    public function getTindakanHtmlAttribute(){

        $transaksi = $this->transaksii;
        $temp = '';
        $total = 0;

        // return $transaksi;
        foreach ($transaksi as $k => $trans) {

            // if($trans['jenis_tarif'] == 'BHP'){
            //     $temp .= '<tr>';
            //     $temp .= '<td>' . 'Bahan Habis Pakai' . '</td>';
            //     $temp .= '<td>:</td>';
            //     $temp .= '<td class="uang">' . 'Rp. ' . number_format( $trans['biaya'] , 2 , "," , "." )  . '</td>';
            //     $temp .= '</tr>';
            // } else {
            $temp .= '<tr>';
            $temp .= '<td>' . $trans->jenisTarif->jenis_tarif . '</td>';
            $temp .= '<td>:</td>';
            $temp .= '<td class="uang">' . 'Rp. ' . number_format( $trans->biaya , 2 , "," , "." )  . '</td>';
            $temp .= '</tr>';
            // }

            $total += $trans['biaya'];
        }

        return $temp;

    }
    public function getTotalTransaksiAttribute(){

        $transaksi = $this->transaksii;
        $total = 0;

        // return $transaksi;
        foreach ($transaksi as $k => $trans) {

            $total += $trans['biaya'];
        }

        return 'Rp. ' .  number_format( $total, 2 , "," , "." );


    }
    public function getResepKuitansiAttribute(){

        // return $this->transaksi;
        
        $terapi = $this->terapii;

        $temp = '';
        foreach ($terapi as $trp) {
            $temp .= $trp['merek'] . ' ' . $trp['jumlah'] . ' pcs, ';
        }
        return $temp;
    }

    public function getTerapiArrayAttribute(){

        // return $this->transaksi;
        
        if($this->terapi != ''){
            return $this->terapii;
        } else {
            return [];
        }

    }
    public function getTdAttribute(){

        $periksa_awal = $this->periksa_awal;
        
        if($periksa_awal != '[]'){
            $arr = json_decode($periksa_awal, true);

            return $arr['tekanan_darah'];
        } else {
            return '';
        }
    }
    public function getBbAttribute(){

        $periksa_awal = $this->periksa_awal;
        
        if($periksa_awal != '[]'){
            $arr = json_decode($periksa_awal, true);

            return $arr['berat_badan'];
        } else {
            return '';
        }
    }
    public function getTbAttribute(){

        $periksa_awal = $this->periksa_awal;
        
        if($periksa_awal != '[]'){
            $arr = json_decode($periksa_awal, true);

            return $arr['tinggi_badan'];
        } else {
            return '';
        }
    }
    public function getShAttribute(){

        $periksa_awal = $this->periksa_awal;
        
        if($periksa_awal != '[]'){
            $arr = json_decode($periksa_awal, true);

            return $arr['suhu'];
        } else {
            return '';
        }

    }

    public function getTerapiInlineAttribute(){

        $array =  $this->terapii;
        $temp = '<table class="noBorder tabelTerapi" width="100%">';
        foreach ($array as $key => $arr) {
            $temp .= '<tr>';
            $temp .= '<td>' . $arr->merek->merek . '</td>';
            $temp .= '<td>' . $arr->jumlah . '</td>';
            $temp .= '<td>' . $arr->signa . '</td>';
            $temp .= '</tr>';
        }
        $temp .= '</table>';

        return $temp;

    }


    protected $morphClass = 'App\Models\Periksa';
    public function promos(){
        return $this->morphMany('App\Models\Promo', 'promoable');
    }

    public function antars(){
        return $this->morphMany('App\Models\PengantarPasien', 'antarable');
    }

    public function gambars(){
        return $this->morphMany('App\Models\GambarPeriksa', 'gambarable');
    }


	public function antrian(){

        return $this->morphOne(Antrian::class, 'antriable');
	}

    public function jurnals(){
        return $this->morphMany(JurnalUmum::class, 'jurnalable');
    }
    public function getKetjurnalAttribute(){
        $pasien = $this->pasien->nama;
        $diagnosis = $this->diagnosa->diagnosa .' - ' . $this->diagnosa->icd10->diagnosaICD;
        $pembayaran = $this->asuransi->nama;
        $pemeriksa = $this->staf->nama;
        $poli = $this->poli;

        return 'Pasien ' . $pasien . ', diagnosa : ' . $diagnosis . ', pembayaran : ' . $pembayaran . ', Pemeriksa : ' . $pemeriksa . ' Poli: ' . $poli;

    }

    public function dispenses(){
        return $this->morphMany('App\Models\Dipensing', 'dispensable');
    }

    public function getTerapiModalAttribute(){
        $terapis = $this->terapii;
        $biaya = 0;
        foreach ($terapis as $k => $terapi) {
            $biaya += $terapi->harga_beli_satuan * $terapi->jumlah;
        }
        return $biaya;

    }
    public function getTerapiBrutoAttribute(){
        $terapis = $this->terapii;
        $biaya = 0;
        foreach ($terapis as $k => $terapi) {
            $biaya += $terapi->harga_jual_satuan * $terapi->jumlah;
        }
        return $biaya;

    }
    public function getTerapiUntungAttribute(){
                $terapis = $this->terapii;
        $biaya = 0;
        foreach ($terapis as $k => $terapi) {
            $biaya += $terapi->harga_jual_satuan * $terapi->jumlah;
        }

        foreach ($terapis as $k => $terapi) {
            $biaya -= $terapi->harga_beli_satuan * $terapi->jumlah;
        }

        return $biaya;
        
    }

    public function getListbhpAttribute(){
        $transaksis = $this->transaksii;
        $temp = '';
        foreach ($transaksis as $k => $v) {
            $temp .= $v->listbhp . '<br />'; 
        }
        if (!empty($temp)) {
            return $temp;
        }
    }

    public function getTerapiHtmllllAttribute(){
        $puyer = false;
        $add = false;

        $terapis = $this->terapii;
        $terapi = json_encode($terapis);

        // return $terapi;

        if($terapi != ""){
                $MyArray = $this->terapii;
            } else {
                $MyArray = [];
            }
            $tempFirst = '<table class="tabelTerapi">';
            $temp = $tempFirst;
          if (count($MyArray) > 0){

            for ($i = 0; $i < count($MyArray) - 1; $i++) {

                $MyArray[$i]->merek->rak_id = Merek::find($MyArray[$i]->merek_id)->rak_id;

                if (substr($MyArray[$i]->signa, 0, 5) == "Puyer" && $puyer == false ) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" >' . $MyArray[$i]->merek->merek . '</td>';
                    $temp .= '<td> No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr>';

                    if ($MyArray[$i]->signa == $MyArray[$i + 1]->signa) {
                       $puyer = true;
                    } else {
                       $puyer = false;
                    }


                } else if (substr($MyArray[$i]->signa, 0, 5) == "Puyer" && $puyer == true) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" >' . $MyArray[$i]->merek->merek . '</td>';
                    $temp .= '<td> No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr>';

                    if ($MyArray[$i]->signa == $MyArray[$i + 1]->signa) {
                        $puyer = true;
                    } else {
                       $puyer = false;
                    }

                } else if ($MyArray[$i]->merek_id == -1 || $MyArray[$i]->merek_id == -3) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap class="merek">Buat Menjadi ' . $MyArray[$i]->jumlah . ' puyer ' . $MyArray[$i]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;"  nowrap>' . $MyArray[$i]->aturan_minum . '</td>';
                    $temp .= '</tr>';

                   $puyer = false;

                } else if (substr($MyArray[$i]->signa, 0, 3) == "Add" && $add == false) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" >' . $MyArray[$i]->merek->merek . '</td>';
                    $temp .= '<td> fls No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr>';
                    $temp .= '<tr>';
                    $temp .= '<td style="text-align:center;" colspan="3">ADD</td>';
                    $temp .= '</tr>';

                    $add = true;


                } else if (substr($MyArray[$i]->signa, 0, 3) == "Add" && $add == true) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" >' . $MyArray[$i]->merek->merek . '</td>';
                    $temp .= '<td> No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr>';

                    if ($MyArray[$i]->signa == $MyArray[$i + 1]->signa) {
                        $add = true;
                    } else {
                        $add = false;
                    }

                } else if ($MyArray[$i]->merek_id == -2) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap>S Masukkan ke dalam sirup ' . $MyArray[$i]->signa . ' </td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>Dihabiskan</td>';
                    $temp .= '</tr>';

                   $puyer = false;

                } else {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" >' . $MyArray[$i]->merek->merek . '</td>';
                    $temp .= '<td> No : ' . $MyArray[$i]->jumlah . '</td>';
                    $temp .= '</tr><tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap> S ' . $MyArray[$i]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>' . $MyArray[$i]->aturan_minum . '</td>';
                    $temp .= '</tr>';
                }
            }

          

                $a = count($MyArray) - 1;
                $MyArray[$a]->merek->rak_id = Merek::find($MyArray[$a]->merek_id)->rak_id;


                if ($MyArray[$a]->merek_id == -1 || $MyArray[$a]->merek_id == -3) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap class="merek">Buat Menjadi ' . $MyArray[$a]->jumlah . ' puyer ' . $MyArray[$a]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>' . $MyArray[$a]->aturan_minum . '</td>';

                   $puyer = false;

                } else if ($MyArray[$a]->merek_id == -2) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap>S Masukkan ke dalam sirup ' . $MyArray[$a]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>Dihabiskan</td>';

                    $add = false;
                } else if (substr($MyArray[$a]->signa, 0, 3) == "Add" && $add == false) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" >' . $MyArray[$i]->merek->merek . '</td>';
                    $temp .= '<td nowrap> fls No : ' . $MyArray[$a]->jumlah . '</td>';
                    $temp .= '</tr>';
                    $temp .= '<tr>';
                    $temp .= '<td  style="text-align:center;" colspan="3">ADD</td>';

                    $add = true;


                } else if (substr($MyArray[$a]->signa, 0, 3) == "Add" && $add == true) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" >' . $MyArray[$i]->merek->merek . '</td>';
                    $temp .= '<td> No : ' . $MyArray[$a]->jumlah . '</td>';


                } else if (substr($MyArray[$a]->signa, 0, 5) == "Puyer" && $puyer == false) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" >' . $MyArray[$i]->merek->merek . '</td>';
                    $temp .= '<td> No : ' . $MyArray[$a]->jumlah . '</td>';

                } else if (substr($MyArray[$a]->signa, 0, 5) == "Puyer" && $puyer == true) {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" >' . $MyArray[$i]->merek->merek . '</td>';
                    $temp .= '<td> No : ' . $MyArray[$a]->jumlah . '</td>';

                } else {

                    $temp .= '<tr>';
                    $temp .= '<td style="width:15px">R/</td>';
                    $temp .= '<td nowrap style="text-align:left; width:150px" >' . $MyArray[$i]->merek->merek . '</td>';
                    $temp .= '<td> No : ' . $MyArray[$a]->jumlah . '</td>';
                    $temp .= '</tr><tr>';
                    $temp .= '<td style="width:15px"></td>';
                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap> S ' . $MyArray[$a]->signa . '</td>';
                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>' . $MyArray[$a]->aturan_minum . '</td>';
                }
             }
            $temp .= '</tr></table>';

			if (trim($temp) == $tempFirst . '<tr></tr></table>') {
				return nl2br(html_entity_decode($this->terapi));
			} elseif ($temp !='[]') {
				return $temp;
			}
    }
    public function resepLuar(){
         return $this->hasOne('App\Models\ResepLuar');
    }

	public function getInfostatusAttribute(){
		$temp = Yoga::updateDatePrep($this->tanggal) . '<br />' .
			'Umur : <br /> <strong>'. Yoga::datediff($this->pasien->tanggal_lahir, $this->tanggal) .
			'</strong><br /><br /> Pemeriksa : <br />';
		if($this->staf){
			$temp .= '<strong>' .$this->staf->nama . '</strong> <br /><br />';
		}
		$temp .= 'Pembayaran : <br /> <strong>';
		$temp .= $this->asuransi->nama;
		$temp .= '</strong><br /><br />';
		$temp .= $this->id;
		return $temp;
	}
	public function getStatusAttribute(){
		$temp = '<strong>Anamnesa :';
		$temp .= $this->id;
		$temp .= '</strong> <br>';
		$temp .= $this->anamnesa;
		$temp .= '<br> <strong>Pemeriksaan Fisik, Penunjang dan Tindakan :</strong> <br>';
		$temp .= $this->pemeriksaan_fisik; 
		$temp .= '<br>';
		$temp .= $this->pemeriksaan_penunjang;
		$temp .= 	'<br> <strong>Diagnosa :</strong> <br>';
		if($this->diagnosa_id != ''){
			 $temp .=  $this->diagnosa->diagnosa . ' - ' . $this->diagnosa->icd10->diagnosaICD;
			 $temp .=  '<br> <strong>ICD : </strong> ';
			 $temp .=  $this->diagnosa->icd10_id ;
			 $temp .=  '<strong> Admedika </strong>: ';
			 $temp .=  $this->diagnosa->icd10->admedika;
		} else {
			 $temp .=  $this->keterangan_diagnosa;
		}
		$temp .=  '<br><br>';

		if($this->usg){
			$temp .= '<a href="'. url("usgs/" . $this->id) . '" class="btn btn-primary">Hasil USG</a>';
		}
		if($this->registerAnc){
			$temp .= '<a href="'.  url("ancs/" . $this->id) .'" class="btn btn-info">Hasil ANC</a>';
		}
		$temp .= '<br>';
		if($this->suratSakit){
		    $temp .= '<hr> <div class="alert alert-success">';
			$temp .= App\Models\Classes\Yoga::suratSakit($this);
			$temp .= 	'</div>';
		}

		return $temp;

                      
	}
	public function getStatusterapiAttribute(){
		$temp = $this->terapi_html;
		if($this->rujukan){
			$temp .= '<hr>';
			$temp .= '<div class="alert alert-warning"> dirujuk ke ';
			$temp .= $this->rujukan->tujuanRujuk->tujuan_rujuk ;
			$temp .= '<br> karena ';
			$temp .= $this->rujukan->complication;
			$temp .= '<br>';
			if($this->asuransi_id == '32'){
				$temp .= '<a href="'.url('rujukans/' . $this->id ).'" class="btn btn-success">Lihat Rujukan</a>';
			}else {
				$temp .= '<a href="'.url('pdfs/status/' . $this->id ).'" target="_blank" class="btn btn-success">Lihat Rujukan</a>';
			}
			$temp .= '</div>';
		}
		return $temp;
	}
	public function getDiagnosahtmlAttribute(){
		return $this->diagnosa->diagnosa . ' - ' . $this->diagnosa->icd10->diagnosaICD . ' (' . $this->diagnosa->icd10_id . ')';
	}
	public function poliIni($tanggal, $asuransi_id){
		$polis=[];

        $query = "SELECT *,";
        $query .= " p.id as periksa_id, ";
        $query .= "ps.nama as nama_pasien, ";
        $query .= "asu.nama as nama_asuransi, ";
        $query .= "p.id as periksa_id, ";
        $query .= "p.poli as poli ";
        $query .= "FROM periksas as p ";
        $query .= "LEFT OUTER JOIN pasiens as ps on ps.id = p.pasien_id ";
        $query .= "LEFT OUTER JOIN asuransis as asu on asu.id = p.asuransi_id ";
        $query .= "where p.tanggal like '{$tanggal}' ";
        $query .= "AND p.asuransi_id like '{$asuransi_id}'";

		$periksas = DB::select($query);
		$poli_id = [];
		foreach ($periksas as $periksa) {
			$poli_id[] = $periksa->poli;
		}
		$polis = array_unique($poli_id, SORT_REGULAR);
		sort( $polis );
		return [
			'polis' =>$polis,
			'periksas' =>$periksas
		];
	}
	

	public function imageUpload($file, $id, $k){


			$extension = $file->getClientOriginalExtension();

			$filename =	 $id . '-' . $k .  '_'. time() .  '.' . $extension;
			//menyimpan estetika_image ke folder public/img
			$destination_path = 'img/estetika/';
			/* $destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/estetika'; */
			// Mengambil file yang di upload
            //
			Storage::disk('s3')->put($destination_path. $filename, file_get_contents($file));
			/* $file->save($destination_path . '/' . $filename); */
			return $filename;

	}
	public function kontrol(){
		return $this->hasOne('App\Models\Kontrol');
	}
	public function getHutangDokterAttribute(){


		$jurnals = $this->jurnals;
		$hutang_dokter = 0;
		foreach ($jurnals as $j) {
			if ($j->coa_id == 200001) {
				$hutang_dokter = $j->nilai;
				break;
			}
		}
		return $hutang_dokter;

	}
	public function getTerbilangAttribute(){
		$terbilang = 0;
		$transaksis = $this->transaksi; 
		$transaksis = json_decode($transaksis, true);

		foreach ($transaksis as $transaksi) {
			$terbilang += $transaksi['biaya'];
		}

		$terbilang = ucwords(Yoga::terbilang($terbilang)) . ' Rupiah';
		return $terbilang;
	}
	public function getStrukAttribute(){
        $transaksis       = $this->transaksii;
        $total_biaya      = 0;
        $dibayar_asuransi = 0;
        $dibayar_pasien   = 0;
        $pembayaran       = 0;
        $kembalian        = 0;
        $bhp              = 0;

        foreach ($transaksis as $trx) {
            if ($trx->jenis_tarif_id != 147 && $trx->jenis_tarif_id != 148) {
                $total_biaya += $trx->biaya;
            }
            if ($trx->jenis_tarif_id == 147) {
                $pembayaran = $trx->biaya;
            }
            if ($trx->jenis_tarif_id == 148) {
                $kembalian = $trx->biaya;
            }
            if ($trx->jenis_tarif_id == 149) {
                $dibayar_asuransi = $trx->biaya;
            }
            if ($trx->jenis_tarif_id == 150) {
                $dibayar_pasien = $trx->biaya;
            }
            if ($trx->jenis_tarif_id == 140) {
                $bhp = $trx->biaya;
            }
        }
        $trxa = json_encode($transaksis);
        $trxa = json_decode($trxa, true);
        foreach ($trxa as $k=>$trx) {
            if ($trx['jenis_tarif_id'] == 9) {
                $trxa[$k]['biaya'] = Yoga::buatrp($trx['biaya'] + $bhp);
                $trxa[$k]['jenis_tarif'] = $transaksis[$k]->jenisTarif->jenis_tarif;

            }else if($trx['jenis_tarif_id'] == 140){
                unset($trxa[$k]);
            } else {
                $trxa[$k]['biaya'] = Yoga::buatrp($trx['biaya']);
                $trxa[$k]['jenis_tarif'] = $transaksis[$k]->jenisTarif->jenis_tarif;
            }
        }

		return [
			'total_biaya'      => Yoga::buatrp( $total_biaya ),
			'dibayar_asuransi' => Yoga::buatrp( $dibayar_asuransi ),
			'dibayar_pasien'   => Yoga::buatrp( $dibayar_pasien ),
			'pembayaran'       => Yoga::buatrp( $pembayaran ),
			'kembalian'        => Yoga::buatrp( $kembalian ),
			'bhp'        => $bhp
		];
	}
	public function getTrxaAttribute(){
		$transaksis = $this->transaksii;
        $trxa = json_encode($transaksis);
        $trxa = json_decode($trxa, true);
		$bhp = $this->struk['bhp'];
        foreach ($trxa as $k=>$trx) {
            if ($trx['jenis_tarif_id'] == 9) {
                $trxa[$k]['biaya'] = Yoga::buatrp($trx['biaya'] + $bhp);
                $trxa[$k]['jenis_tarif'] = $transaksis[$k]->jenisTarif->jenis_tarif;

            }else if($trx['jenis_tarif_id'] == 140){
                unset($trxa[$k]);
            } else {
                $trxa[$k]['biaya'] = Yoga::buatrp($trx['biaya']);
                $trxa[$k]['jenis_tarif'] = $transaksis[$k]->jenisTarif->jenis_tarif;
            }
        }
		return $trxa;
	}
	public function pembayarans(){
		return $this->hasMany('App\Models\PiutangDibayar');
	}
	
    public function berkas(){
        return $this->morphMany('App\Models\Berkas', 'berkasable');
    }

	public function getNomorAsuransiAttribute(){
        if ( $this->asuransi_id != '0' ) {
            return $this->pasien->nomor_asuransi;
        }
	}

	public function getSudahDibayarAttribute(){
        $pembayarans = $this->pembayarans;
        $sudah_dibayar = 0;
        foreach ($pembayarans as $p) {
            $sudah_dibayar += $p->pembayaran;
        }
        return $sudah_dibayar;
	}

	public function getAdaHasilRapidAntigenAttribute(){
        $transaksi = $this->transaksi;
        foreach (json_decode($transaksi, true) as $trx) {
            if ($trx['jenis_tarif_id'] == '404') {
                return true;
                break;
            }
        }
        return false;
	}
	public function getAdaHasilRapidAntibodiAttribute(){
        $transaksi = $this->transaksi;
        foreach (json_decode($transaksi, true) as $trx) {
            if ($trx['jenis_tarif_id'] == '403') {
                return true;
                break;
            }
        }
        return false;
	}

	public function getPesertaBpjsRppt(){
        if (
            $this->asuransi_id == '32' &&
            ($this->prolanis_ht || $this->prolanis_dm)
        ) {
            return true;
        }
        return false;
	}
	public function getButuhKelengkapanDokumenAttribute(){
        if (
            $this->prolanis_dm ||
            $this->asuransi_id == '96' ||
            $this->asuransi_id == '3' ||
            $this->asuransi_id == '114' ||
            $this->asuransi_id == '144' ||
            $this->asuransi_id == '151' ||
            $this->asuransi->tipe_asuransi == '3' //asuransi admedika
        ) { 
            return true;
        }
        return false;
	}
}
