<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PesanKeluar;
use App\Models\PesanMasuk;

class Outbox extends Model
{
	protected $table = "outbox";
	public $timestamps = false;
}
