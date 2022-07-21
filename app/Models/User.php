<?php

namespace App\Models;

use App\Models\Classes\Yoga;
use App\Traits\BelongsToTenant; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use BelongsToTenant, HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getPeranAttribute(){

        if($this->role_id == '1'){
           return 'Dokter';
        }elseif($this->role_id == '2'){
            return 'Kasir';
        }elseif($this->role_id == '3'){
            return 'Bidan';
        }elseif($this->role_id == '4'){
            return 'Admin';
        }elseif($this->role_id == '5'){
            return 'Dokter Gigi';
        }elseif($this->role_id == '6'){
            return 'Super Admin';
        }
    }

    public function getKeaktifanAttribute(){
        if($this->aktif == 1){
            return Yoga::sukses('Aktif');
        }else{
            return Yoga::gagal('Tidak Aktif');
        }
    }
}
