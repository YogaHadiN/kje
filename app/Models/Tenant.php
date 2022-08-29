<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Asuransi;
use App\Models\Formula;
use App\Models\JenisTarif;
use App\Models\Coa;
use App\Models\Rak;
use App\Models\Merek;

class Tenant extends Model
{
    use HasFactory;
    public static function boot(){
        parent::boot();
        self::created(function($tenant){

        });
    }
    public static function boot(){
        parent::boot();
        self::created(function($model){
            $asuransis = Asuransi::where('tenant_id', 1)
                                ->where('master_template', 1)
                                ->get();
            foreach ($asuransis as $asuransi) {
                $newAsuransi = $asuransi->replicate();
                $newAsuransi->push();
                $newAsuransi->tenant_id = $model->id;
                $newAsuransi->save();

            }
            $jenis_tarifs = JenisTarif::where('tenant_id', 1)
                                ->where('master_template', 1)
                                ->get();
            foreach ($jenis_tarifs as $jenis_tarif) {
                $newJT = $jenis_tarif->replicate();
                $newJT->push();
                $newJT->tenant_id = $model->id;
                $newJT->save();

            }
            $coas = Coa::where('tenant_id', 1)
                        ->where('master_template', 1)
                        ->get();
            foreach ($coas as $coa) {
                $newCoa = $coa->replicate();
                $newCoa->push();
                $newCoa->tenant_id = $model->id;
                $newCoa->save();
            }
            foreach (Formula::all() as $formula) {
                $newFormula = $formula->replicate();
                $newFormula->push();
                $newFormula->tenant_id = $model->tenant_id;
                $newFormula->save()
            }

            foreach (Rak::all() as $rak) {
                $newRak = $rak->replicate();
                $newRak->push();
                $newRak->tenant_id = $model->tenant_id;
                $newRak->save()
            }

            foreach (Merek::all() as $merek) {
                $newMerek = $merek->replicate();
                $newMerek->push();
                $newMerek->tenant_id = $model->tenant_id;
                $newMerek->save()
            }
        });
    }
}
