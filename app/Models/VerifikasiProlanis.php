<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BelongsToTenant; 
use Illuminate\Database\Eloquent\Model;

class VerifikasiProlanis extends Model
{
    use BelongsToTenant, HasFactory;
    use HasFactory;
}
