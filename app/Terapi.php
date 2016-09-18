<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Terapi extends Model{
	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function merek(){

		return $this->belongsTo('App\Merek');
	}
	public function periksa(){

		return $this->belongsTo('App\Periksa');
	}

	public function getMerekJualAttribute(){
		$id = $this->id;
		$merek_id = $this->merek_id;
		$formula_id = $this->merekk->rak->formula_id;
		$rak_id = $this->merekk->rak_id;
		$harga_jual = $this->merekk->rak->harga_jual;

		$data = [
			'id' => $id,
			'merek_id' => $merek_id,
			'rak_id' => $rak_id,
			'formula_id' => $formula_id,
			'harga_jual' => $harga_jual
		];

		return json_encode($data);

	}

    protected $morphClass = 'App\Terapi';
    public function dispens(){
        return $this->morphMany('App\Dispensing', 'dispensable');
    }



}
