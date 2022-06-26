<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use App\Models\PesanKeluar;
use App\Models\PesanMasuk;

class Outbox extends Model
{
    use BelongsToTenant;
	protected $table = "outbox";
	public $timestamps = false;
}
