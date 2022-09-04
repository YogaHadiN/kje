<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Asuransi;
use App\Models\Formula;
use App\Models\RumahSakit;
use App\Models\JenisTarif;
use App\Models\Coa;
use App\Models\Rak;
use App\Models\Merek;
use Hash;

class Tenant extends Model
{
    use HasFactory;
    public static function boot(){
        parent::boot();
        self::created(function($tenant){
            $asuransis = Asuransi::where('tenant_id', 1)
                                ->where('master_template', 1)
                                ->get();
            foreach ($asuransis as $asuransi) {
                $newAsuransi = $asuransi->replicate();
                $newAsuransi->push();
                $newAsuransi->tenant_id = $tenant->id;
                $newAsuransi->save();

            }
            $jenis_tarifs = JenisTarif::where('tenant_id', 1)
                                ->where('master_template', 1)
                                ->get();
            foreach ($jenis_tarifs as $jenis_tarif) {
                $newJT = $jenis_tarif->replicate();
                $newJT->tenant_id = $tenant->id;
                $newJT->save();

                foreach ($jenis_tarif->tarif as $tarif) {
                    $newTarif = $tarif->replicate();
                    $newTarif->jenis_tarif_id = $newJT->id;
                    $newTarif->tenant_id = $tenant->id;
                    $newTarif->save();
                }
            }
            $coas = Coa::where('tenant_id', 1)
                        ->where('master_template', 1)
                        ->get();
            foreach ($coas as $coa) {
                $newCoa = $coa->replicate();
                $newCoa->push();
                $newCoa->tenant_id = $tenant->id;
                $newCoa->save();
            }
            foreach (Formula::where('tenant_id', 1)->get() as $formula) {
                $newFormula = $formula->replicate();
                $newFormula->push();
                $newFormula->tenant_id = $tenant->id;
                $newFormula->save();
                $komposisis = $formula->komposisi;
                foreach ($komposisis as $k) {
                    $newKomposisi = $k->replicate();
                    $newKomposisi->formula_id = $newFormula->id;
                    $newKomposisi->save();
                }
                foreach ($formula->dose as $dose) {
                    $newDose = $dose->replicate();
                    $newDose->formula_id = $newFormula->id;
                    $newDose->save();
                }
                
            }
            foreach (Rak::where('tenant_id', 1)->get() as $rak) {
                $newRak = $rak->replicate();
                $newRak->push();
                $newRak->tenant_id = $tenant->id;
                $newRak->save();
            }

        });
    }
}
