<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BelongsToTenant; 
use DB;
use App\Models\BahanHabisPakai;
use App\Models\Asuransi;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model{
    use BelongsToTenant, HasFactory;
	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [ 'id' ];

	public function jenisTarif(){

		return $this->belongsTo('App\Models\JenisTarif');

	}
	public function asuransi(){

		return $this->belongsTo('App\Models\Asuransi');

	}

	public function tipeTindakan(){

		return $this->belongsTo('App\Models\TipeTindakan');

	}

	public function getJenisTarifListAttribute(){
		return $this->jenisTarif->jenis_tarif;
	}

	public function getJenisbpjsAttribute(){
        if($this->biaya > 0){
		    return $this->jenisTarif->jenis_tarif . ' (TIDAK DITANGGUNG BPJS)';
        } else {
		    return $this->jenisTarif->jenis_tarif;
        }
	}

	public function getTarifJualAttribute(){

		$tarif_id = $this->id;
		$jenis_tarif_id = $this->jenis_tarif_id;
		$biaya = $this->biaya;

		$data = [
			'tarif_id' => $tarif_id,
			'jenis_tarif_id' => $jenis_tarif_id,
			'biaya' => $biaya
		];

		return json_encode($data);
	}
    public static function queryTarif($asuransi_id, $jenis_tarif){
        $query  = "SELECT ";
        $query .= "trf.biaya as biaya, ";
        $query .= "trf.jenis_tarif_id as jenis_tarif_id, ";
        $query .= "jtf.jenis_tarif as jenis_tarif ";
        $query .= "FROM tarifs as trf ";
        $query .= "JOIN jenis_tarifs as jtf on jtf.id = trf.jenis_tarif_id ";
        $query .= "WHERE jtf.jenis_tarif = '{$jenis_tarif}' ";
        $query .= "AND trf.asuransi_id = {$asuransi_id} ";
        $query .= "AND trf.tenant_id = " .session()->get('tenant_id'). ";";

        return DB::select($query)[0];
    }
    public static function listByAsuransi($asuransi_id){
        $query  = "SELECT ";
        $query .= "trf.id as id, ";
        $query .= "trf.biaya as biaya, ";
        $query .= "jtf.jenis_tarif as jenis_tarif ";
        $query .= "FROM tarifs as trf ";
        $query .= "JOIN jenis_tarifs as jtf on jtf.id = trf.jenis_tarif_id ";
        $query .= "WHERE jtf.jenis_tarif not like 'Biaya Obat'";
        $query .= "AND jtf.jenis_tarif not like 'Jasa Dokter'";
        $query .= "AND jtf.jenis_tarif not like 'Diskon' ";
        $query .= "AND trf.asuransi_id = {$asuransi_id} ";
        $query .= "AND trf.tenant_id = " .session()->get('tenant_id'). ";";
        $data = DB::select($query);

		$tindakans   = [null => '- Pilih -'];
        $is_bpjs = Asuransi::find($asuransi_id)->tipe_asuransi_id == 5 ;
        foreach ($data as $d) {
            if ( $is_bpjs && $d->biaya > 0 ) {
                $tindakans[ $d->id ] = $d->jenis_tarif . ' (TIDAK DITANGGUNG BPJS)';
            } else {
                $tindakans[ $d->id ] = $d->jenis_tarif;
            }
        }
        return $tindakans;
    }
}
