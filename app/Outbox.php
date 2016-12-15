<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PesanKeluar;
use App\PesanMasuk;

class Outbox extends Model
{
	protected $table = "outbox";
	public $timestamps = false;
}
