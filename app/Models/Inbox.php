<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Inbox extends Model
{
    use BelongsToTenant;
	protected $table = 'inbox';
}
