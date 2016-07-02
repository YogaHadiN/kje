<?php

namespace App;

use App\Classes\Yoga;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getPeranAttribute(){

        if($this->role == '1'){
           return 'Dokter';
        }elseif($this->role == '2'){
            return 'Kasir';
        }elseif($this->role == '3'){
            return 'Bidan';
        }elseif($this->role == '4'){
            return 'Admin';
        }elseif($this->role == '5'){
            return 'Dokter Gigi';
        }elseif($this->role == '6'){
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
