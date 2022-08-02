<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\BelongsToTenant; 
use Illuminate\Database\Eloquent\Model;

class TipeLaporanAdmedika extends Model{
    use BelongsToTenant, HasFactory;
	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

}
