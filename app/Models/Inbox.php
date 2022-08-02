<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Inbox extends Model
{
    use BelongsToTenant, HasFactory;
	public $timestamps = false;
	protected $table = 'inbox';
}
