<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Icd10 extends Model{
    use HasFactory;
    // if your key name is not 'id'
    // you can also set this to null if you don't have a primary key
    protected $primaryKey = 'id';

    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';
    // Add your validation rules here
    public static $rules = [
            // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $guarded = [];


    public function diagnosa(){
            return $this->hasMany('App\Models\Diagnosa');
    }

}
