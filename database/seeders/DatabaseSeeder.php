<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Tenant;
use App\Models\KategoriCekList;
use App\Models\FrekuensiCek;
use App\Models\Coa;
use App\Models\Modal;
use App\Models\Limit;
use App\Models\JurnalUmum;
use App\Models\JenisTarif;
use App\Models\CekList;
use App\Models\RecoveryIndex;
use App\Models\WaktuHadir;
use App\Models\OdontogramAbbreviation;
use App\Models\TaksonomiGigi;
use App\Models\PermukaanGigi;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        OdontogramAbbreviation::create([
            'abbreviation' => 'Sou',
            'extension' => 'Gigi sehat, normal, tanpa kelainan'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Non',
            'extension' => 'Gigi tidak ada /tidak diketahui'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Une',
            'extension' => 'Un-erupted'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Pre',
            'extension' => 'Partial erupted'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Imv',
            'extension' => 'Impacted visible'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Ano',
            'extension' => 'Anomali'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Dia',
            'extension' => 'Diastema'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Att',
            'extension' => 'Atrisi'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Abr',
            'extension' => 'Abrasi'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Car',
            'extension' => 'Caries/karies'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Cfr',
            'extension' => 'Crown fraktur/fraktur mahkota'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Nvt',
            'extension' => 'Gigi non vital'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Rrx',
            'extension' => 'Sisa akar'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Mis',
            'extension' => 'Gigi hilang'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Amf',
            'extension' => 'Amalgam filling'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Gif',
            'extension' => 'Gic/silica'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Cof',
            'extension' => 'Composite filling'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Fis',
            'extension' => 'Fissure sealent'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Inl',
            'extension' => 'Inlay'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Onl',
            'extension' => 'Onlay'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Fmc',
            'extension' => 'Full metal crown'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Poc',
            'extension' => 'Porcelain crown'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Mpc',
            'extension' => 'Metal porcelain crown'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Gmc',
            'extension' => 'Gold metal crown'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Rct',
            'extension' => 'Root canal treatment/perawatan saluranakar'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Ipx',
            'extension' => 'Implant'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Meb',
            'extension' => 'Metal bridge'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Pob',
            'extension' => 'Porcelain bridge'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Pon',
            'extension' => 'Pontic'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Abu',
            'extension' => 'Gigi abutment'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Prd',
            'extension' => 'Partial denture'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Fld',
            'extension' => 'Full denture'
        ]);
        OdontogramAbbreviation::create([
            'abbreviation' => 'Acr',
            'extension' => 'Acrylic'
        ]);

        PermukaanGigi::create([
            'abbreviation' => 'M',
            'extension' => 'MESIAL'
        ]);
        PermukaanGigi::create([
            'abbreviation' => 'O',
            'extension' => 'OKLUSAL'
        ]);
        PermukaanGigi::create([
            'abbreviation' => 'D',
            'extension' => 'DISTAL'
        ]);
        PermukaanGigi::create([
            'abbreviation' => 'V',
            'extension' => 'VESTIBULAR/BUKAL/LABIAL'
        ]);
        PermukaanGigi::create([
            'abbreviation' => 'L',
            'extension' => 'LINGUAL/PALATAL'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '11'
            ,'taksonomi_gigi_anak' => '51'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '12'
            ,'taksonomi_gigi_anak' => '52'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '13'
            ,'taksonomi_gigi_anak' => '53'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '14'
            ,'taksonomi_gigi_anak' => '54'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '15'
            ,'taksonomi_gigi_anak' => '55'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '16'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '17'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '18'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '21'
            ,'taksonomi_gigi_anak' => '61'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '22'
            ,'taksonomi_gigi_anak' => '62'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '23'
            ,'taksonomi_gigi_anak' => '63'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '24'
            ,'taksonomi_gigi_anak' => '64'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '25'
            ,'taksonomi_gigi_anak' => '65'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '26'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '27'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '28'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '31'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '32'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '33'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '34'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '35'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '36'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '37'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '38'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '41'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '42'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '43'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '44'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '45'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '46'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '47'
        ]);
        TaksonomiGigi::create([
            'taksonomi_gigi' => '48'
        ]);

    }
}

