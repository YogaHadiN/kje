<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use App\Models\PesanKeluar;
use App\Models\PesanMasuk;

class Outbox extends Model
{
    use BelongsToTenant, HasFactory;
	protected $table = "outbox";
	public $timestamps = false;
}
