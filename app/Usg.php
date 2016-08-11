<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usg extends Model
{
	public $incrementing = false; 

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function perujuk(){
		return $this->belongsTo('App\Perujuk');
	}
	



	public function getBpdwAttribute(){
		$bpd = $this->bpd;
		$bpd_a = explode(' ', $bpd);
		$bpd_w = substr($bpd_a[0], 0, -1);
		$bpd_d = substr($bpd_a[1], 0, -1);

		if (empty($this->bpd)) {
			$bpd_w = null;
		}
		return $bpd_w;
	}

	public function getBpddAttribute(){
		$bpd = $this->bpd;
		$bpd_a = explode(' ', $bpd);
		$bpd_w = substr($bpd_a[0], 0, -1);
		$bpd_d = substr($bpd_a[1], 0, -1);


		if (empty($this->bpd)) {
			$bpd_d = null;
		}

		return $bpd_d;
	}

	public function getAcwAttribute(){
		$ac = $this->ac;
		$ac_a = explode(' ', $ac);
		$ac_w = substr($ac_a[0], 0, -1);
		$ac_d = substr($ac_a[1], 0, -1);


		if (empty($this->ac)) {
			$ac_w = null;
		}

		return $ac_w;
	}

	public function getAcdAttribute(){
		$ac = $this->ac;
		$ac_a = explode(' ', $ac);
		$ac_w = substr($ac_a[0], 0, -1);
		$ac_d = substr($ac_a[1], 0, -1);

		if (empty($this->ac)) {
			$ac_d = null;
		}

		return $ac_d;
	}

	public function getFlwAttribute(){
		$fl = $this->fl;
		$fl_a = explode(' ', $fl);
		$fl_w = substr($fl_a[0], 0, -1);
		$fl_d = substr($fl_a[1], 0, -1);


		if (empty($this->fl)) {
			$fl_w = null;
		}

		return $fl_w;
	}

	public function getFldAttribute(){
		$fl = $this->fl;
		$fl_a = explode(' ', $fl);
		$fl_w = substr($fl_a[0], 0, -1);
		$fl_d = substr($fl_a[1], 0, -1);
		return $fl_d;
	}
	public function getEfwdAttribute(){
		$fl = $this->efw;
		$fl_a = explode(' ', $fl);

		if (empty($this->fl)) {
			$fl_d = null;
		}

		return $fl_a[0];
	}

	public function getHcwAttribute(){
		$fl = $this->hc;
		if ($fl) {
			$fl_a = explode(' ', $fl);
			$fl_w = substr($fl_a[0], 0, -1);
			$fl_d = substr($fl_a[1], 0, -1);


			if (empty($this->fl)) {
				$fl_w = null;
			}

			return $fl_w;
		}
	
		return null;
	}

	public function getHcdAttribute(){
		$fl = $this->hc;
		if ($fl) {
			$fl_a = explode(' ', $fl);
			$fl_w = substr($fl_a[0], 0, -1);
			$fl_d = substr($fl_a[1], 0, -1);


			if (empty($this->fl)) {
				$fl_d = null;
			}

			return $fl_d;
		}
	
		return null;
	}

}
