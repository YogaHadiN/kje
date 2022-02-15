<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Session;
use App\Models\Classes\Yoga;
use App\Models\Terapi;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\BahanHabisPakai;
use App\Models\Dispensing;
use DB;

class Formula extends Model{
	public static function boot(){
		parent::boot();
		self::deleting(function($formula){

			$merek_ids = [];
			foreach ($formula->rak as $rak) {
				foreach ($rak->merek as $merek) {
					$merek_ids[] = $merek->id;
				}
			}

			$fx = new Formula;

			if ($fx->cekMerekSudahDigunakan($merek_ids)) {

				$query  = "SELECT merek ";
				$query .= "FROM mereks as mr ";
				$query .= "LEFT JOIN raks as rk on rk.id = mr.rak_id ";
				$query .= "LEFT JOIN formulas as fx on fx.id = rk.formula_id ";
				$query .= "WHERE fx.id = '" . $formula->id . "' ";
				$query .= "AND mr.id in ";
				$query .= "(Select merek_id from terapis)";
				$mereks = DB::select($query);
				$pesan = 'Tidak bisa menghapus karena ';
				$pesan .= '<ul>';
				foreach ($mereks as $merek) {
					$pesan .= '<li>' . $merek->merek . '</li>';
				}
				$pesan .= '</ul>';
				$pesan .= 'sudah pernah digunakan, rubah FORMULA ' . $formula->id . ' bila perlu!';
				Session::flash('pesan', Yoga::gagalFlash($pesan));
				return false;
			}
			
		});

		self::deleted(function($formula){
			$raks = $formula->rak;
			$bahawans = [];
			foreach ($raks as $rak) {
				$mereks = Merek::where('rak_id', $rak->id)->get();
				foreach ($mereks as $merek) {
					$bawahans[$rak->id][] = $merek->merek;
				}
				Merek::where('rak_id', $rak->id)->delete();
			}
			Rak::where('formula_id', $formula->id)->delete();
			$pesan = 'Formula <strong>' . $formula->id . '</strong> BERHASIL dihapus';
			foreach ($bawahans as $k => $v) {
				$pesan .= '<ul>';
				$pesan .= '<li> Rak ' . $k . ' BERHASIL dihapus, merek yang menaunginya : ';
				$pesan .= '<ul>';
				foreach ($v as $merk) {
					$pesan .= '<li>' . $merk . '</li>';
				}
				$pesan .= '<li>BERHASIL dihapus</li>';
				$pesan .= '</ul>';
				$pesan .= '</li>';
				$pesan .= '</ul>';
			}
			Session::flash('pesan', Yoga::suksesFlash($pesan));
			return true;
		});
	}

	public $incrementing = false; 
    protected $keyType = 'string';

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function dose(){
		return $this->hasMany('App\Models\Dose');
	}
	public function aturanMinum(){
		return $this->belongsTo('App\Models\AturanMinum');
	}

	public function komposisi(){
		return $this->hasMany('App\Models\Komposisi');
	}

	public function rak(){
		return $this->hasMany('App\Models\Rak');
	}

	public function existing_komposisi($id){
		return DB::select("select * from komposisis as k left outer join generiks as g on g.id = k.generik_id where formula_id = $id");
	}

	public function getEndfixAttribute(){
		$sumKomposisi = $this->komposisi->count();
		$sediaan = $this->sediaan;

		if($sumKomposisi == 1){
			$bobot = $this->komposisi->first()->bobot;
			$endfix = $sediaan . ' ' . $bobot;
		} else {
			$endfix = $sediaan;
		}

		return $endfix;
	}

	public function getMerekBanyakAttribute(){
		$raks = $this->rak;
		$data = [];
		foreach ($raks as $key => $rak) {
			foreach ($rak->merek as $key => $mer) {
				$data[] = $mer->id;
			}
		}
		return $data;
	}
	public function cekMerekSudahDigunakan($merek_ids){
		if (
				Terapi::whereIn('merek_id', $merek_ids)->count() ||
				Pembelian::whereIn('merek_id', $merek_ids)->count() ||
				Penjualan::whereIn('merek_id', $merek_ids)->count() ||
				BahanHabisPakai::whereIn('merek_id', $merek_ids)->count() ||
				Dispensing::whereIn('merek_id', $merek_ids)->count()
		) {
			return true;
		}
		return false;
	}
}
