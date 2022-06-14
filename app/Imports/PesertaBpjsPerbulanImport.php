<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Pasien;
use App\Models\Periksa;
use DB;
use Carbon\Carbon;


class PesertaBpjsPerbulanImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
    * @param Collection $collection
    */
    public $data;
    public $nama;
    public $tanggal;
    public $bulanTahun;
    public $tanggal_lahir_dms;
    public $tanggal_lahir_hts;
    public $pasiens_dms;
    public $pasiens_hts;
    public $ht_terkonfirmasi;
    public $dm_terkonfirmasi;
    public $riwayat_dm;
    public $riwayat_ht;
    public $riwayat_dm_pasien_ids;
    public $riwayat_ht_pasien_ids;
    public $elemenKe;


    /**
     * @param 
     */
    public function __construct()
    {
        $this->tanggal_lahir_dms     = [];
        $this->tanggal_lahir_hts     = [];
        $this->ht_terkonfirmasi      = [];
        $this->dm_terkonfirmasi      = [];
        $this->riwayat_dm_pasien_ids = [];
        $this->riwayat_dm_pasien_ids = [];
        $this->riwayat_dm            = 0;
        $this->riwayat_ht            = 0;
        $this->elemen_riwayat_dm_ke  = 0;
        $this->elemen_riwayat_ht_ke  = 0;
    }
    
    public function collection(Collection $collection) {
        $timestamp       = date('Y-m-d H:i:s');
        $firstdayofmonth = $this->bulanTahun . '-01';
        foreach ($collection as $c) {
            if (
                !is_null($c['prolanis']) ||
                !is_null($c['prb'])
            ) {
                if (
                    str_contains($c['prolanis'] ,"Diabetes")
                    /* || str_contains($c['prb'] ,"Diabetes") */
                   || str_contains($c['prolanis'] ,"Hypertensi")
                    /* || str_contains($c['prb'] ,"Hypertensi") */
                ) {
                    $data = $this->query($firstdayofmonth, $c['nama'], $c['usia']);
                    $this->data[] = [
                        "nama"          => $c['nama'],
                        "jenis_kelamin" => $c['jenis_kelamin'],
                        "usia"          => $c['usia'],
                        "no"            => $c['no'],
                        "alamat"        => $c['alamat'],
                        /* "prb"           => $c['prb'], */
                        "prolanis"      => $c['prolanis'],
                        /* "club_prolanis" => $c['club_prolanis'], */
                        "periode"       => $firstdayofmonth,
                        'created_at'    => $timestamp,
                        'updated_at'    => $timestamp
                    ];
                    $pasien_ids = [];
                    foreach ($data as $d) {
                        $pasien_ids[] = [
                            'pasien_id' => $d->id
                        ];
                    }

                    $this->data[count($this->data) -1]['pasien_ids'] = $pasien_ids;
                }
            }
        }
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function kumpulkanRppt($c, $pasiens, $riwayat, $prolanis)
    {
        $elemen_ke = 'elemen_' . $riwayat . '_ke';
        $this->$elemen_ke++;
        $this->validateDate($c['tanggal_lahir'], $this->$elemen_ke);
        if ( !empty( $c[$riwayat]   ) ) {
            $this->$riwayat++;
            $pasien_filtered  = [];
            $harus_konfirmasi = true;
            foreach ($pasiens as $p) {
                if ( $p->tanggal_lahir->format('Y-m-d') ==  $this->excelToDate( $c['tanggal_lahir'] )  ) {
                    if (str_contains($this->normalisasiString($p->nama), $this->normalisasiString($c['nama']))) {
                        $harus_konfirmasi         = false;
                        $nama_pasien_ids          = $riwayat . '_pasien_ids';
                        $this->$nama_pasien_ids[] = $p->id;

                        if ( $prolanis == 'prolanis_dm' ) {
                            $this->dm_terkonfirmasi[] = $c;
                        }
                        if ( $prolanis == 'prolanis_ht' ) {
                            $this->ht_terkonfirmasi[] = $c;
                        }
                        break;
                    } else {
                        $pasien_filtered[] = $p;
                    }
                }
            }
            if ($harus_konfirmasi && count($pasien_filtered)) {
                $htdm = $riwayat == 'riwayat_dm' ? 'dm' : 'ht';
                $prolanis = [
                    'data_bpjs' => [
                        'nama'          => $c['nama'],
                        'alamat'        => $c['alamat'],
                        'jenis_kelamin' => $c['jenis_kelamin'],
                        'rppt'          => $htdm,
                        'tanggal_lahir' => $this->excelToDate( $c['tanggal_lahir'] )
                    ],
                    'pasiens' => $pasien_filtered
                ];
                return $prolanis;
            } else {
                return false;
            }
        }
    }
    /**
     * undocumented function
     *
     * @return void
     */
    /**
     * undocumented function
     *
     * @return void
     */
    private function excelToDate($date)
    {
       return Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
    }
    /**
     * undocumented function
     *
     * @return void
     */
    /**
     * undocumented function
     *
     * @return void
     */
    private function normalisasiString($param)
    {
        return str_replace('.', '', str_replace(' ', '', strtolower($param)));
    }
    public function rules(): array
    {
        return [
            /* 'tanggal_lahir' => 'date_format:d-m-Y' */ 
        ];
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function validateDate($date, $elemen_ke ) {
        try {
            Carbon::createFromFormat('d-m-Y', $date);
        } catch (\Exception $e) {
            dd('Tanggal lahir pada baris ke ' . $elemen_ke . ' Tidak benar harusnya format dd-mm-yyyy, contoh : 19-07-1993');
        }
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function query($firstdayofmonth, $nama, $usia) {


        $nama             = preg_replace('/([*.])\1+/', '$1', $nama);
        $nama             = str_replace('\'', '', $nama   );
        $nama             = str_replace(' ', '', $nama   );
        $nama             = str_replace('.', '', $nama   );
        $nama             = str_replace('*', '%', $nama   );

        $query            = "SELECT ";
        $query           .= "id, ";
        $query           .= "nama, ";
        $query           .= "alamat, ";
        $query           .= "nomor_asuransi_bpjs, ";
        $query           .= "TIMESTAMPDIFF(YEAR, tanggal_lahir, '{$firstdayofmonth}') ";
        $query           .= "FROM pasiens as psn ";
        $query           .= "WHERE ";
        $query           .= 'REPLACE(REPLACE(REPLACE(nama, "\'\'", ""), ".", ""), " ", "") like "' .$nama. '" ';
        $query           .= "AND TIMESTAMPDIFF(YEAR, tanggal_lahir, '{$firstdayofmonth}') = {$usia} ";
        $query           .= "AND nomor_asuransi_bpjs not like '' ";
        $query           .= "AND nomor_asuransi_bpjs is not null ";
        $query           .= "AND meninggal = 0 ";
        $query           .= "ORDER BY prolanis_dm, prolanis_ht desc ";

        $this->nama[] = $nama;


        return DB::select($query);
    }
}
