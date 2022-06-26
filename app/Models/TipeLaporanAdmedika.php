<?php


namespace App\Models;

use App\Traits\BelongsToTenant; 
use Illuminate\Database\Eloquent\Model;

class TipeLaporanAdmedika extends Model{
    use BelongsToTenant;
	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

}
