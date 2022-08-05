<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pasien;
use App\Http\Controllers\WablasController;
use DB;
use Log;

class undangProlanisDMTiapSabtu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:prolanis_dm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Undang Prolanis DM tiap hari sabtu agar bisa periksa gula darah rutin tiap bulan';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public $jangan_puasa_pasien_ids;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // cari semua pasien yang prolanis DM dan belum berobat bulan ini
        $query  = "SELECT * ";
        $query .= "FROM pasiens ";
		$query .= "WHERE (no_telp like '+628%' ";
		$query .= "OR no_telp like '08%') ";
		$query .= "AND no_telp not like '%/%' ";
		$query .= "AND CHAR_LENGTH(no_telp) >9 ";
        $query .= "AND prolanis_dm = 1 ";
        $query .= "AND sudah_kontak_bulan_ini = 0 ";
        $tenant_id = is_null(session()->get('tenant_id')) ? 1 : session()->get('tenant_id');
		$query .= "AND tenant_id = " . $tenant_id  . " ";
        $query .= "AND meninggal = 0 ";
        $pasiens = DB::select($query);

        $data   = [];
        $notelp = [];
        $this->jangan_puasa_pasien_ids = $this->pasien_ids_gula_darah_rendah($pasiens);

        foreach ($pasiens as $pasien) {
            $data[] = $this->templatePesan($pasien);
        }
        /* $data[] = $this->templatePesan( $pasiens[0]); */
        $wa = new WablasController;
        $wa->bulkSend($data);
    }

    /**
     * undocumented function
     *
     * @return void
     */
    public function templatePesan($pasien)
    {
        $message = 'Selamat siang. Maaf mengganggu. Kami dari Klinik Jati Elok. Izin mengingatkan bahwa peserta BPJS atas nama ';
        $message .= PHP_EOL;
        $message .= PHP_EOL;
        $message .=  ucwords($pasien->nama);
        $message .= PHP_EOL;
        $message .= PHP_EOL;
        $message .= 'Untuk melakukan pemeriksaan rutin Gula Darah di Klinik Jati Elok bulan ini. ';
        $message .= PHP_EOL;
        $message .= 'Biaya pemeriksaan tersebut sudah ditanggung oleh BPJS kesehatan. ';
        $message .= PHP_EOL;
        $message .= PHP_EOL;

        if ( in_array( $pasien->id, $this->jangan_puasa_pasien_ids)) {
            $message .= '*Mengingat gula darah bapak / ibu bulan kemarin cenderung normal, Mohon agar makan dahulu sebelum pemeriksaan.* ';
        } else {
            $message .= 'Persiapan pemeriksaan mohon agar tidak makan dan minum kecuali air putih selama 8-10 jam.';
        }

        $message .= PHP_EOL;
        $message .= PHP_EOL;
        $message .= 'Izin menanyakan kira-kira bapak / ibu berkenan untuk periksa hari ini atau besok?';
        $message .= PHP_EOL;
        $message .= 'Mohon konfirmasinya.';
        $message .= PHP_EOL;
        $message .= PHP_EOL;
        $message .= 'Jika menurut anda pesan ini dirasa mengganggu, silahkan klik link di bawah ini';
        $message .= PHP_EOL;
        $message .= PHP_EOL;
        $message .= 'https://www.klinikjatielok.com/eksklusi/' . encrypt_string($pasien->id);
        $message .= PHP_EOL;
        $message .= PHP_EOL;
        $message .= 'Terima kasih';

        Log::info('terkirim wa ke '. $pasien->nama . '-' . $pasien->no_telp . ' undangan prolanis dm');
        $no_telp = $pasien->no_telp;
        /* $no_telp = '081381912803'; */
        return [
            'phone'    => $no_telp,
            'message'  => $message,
            'secret'   => false, // or true
            'priority' => false, // or true
        ];
    }

    /**
     * undocumented function
     *
     * @return void
     */
    private function pasien_ids_gula_darah_rendah($pasiens)
    {
        $pasien_ids = [];
        foreach ($pasiens as $pasien) {
            $pasien_ids[] = $pasien->id;
        }

        $query  = "SELECT ";
        $query .= "prx.pasien_id as pasien_id, ";
        $query .= "trp.keterangan_pemeriksaan as keterangan_pemeriksaan ";
        $query .= "FROM transaksi_periksas as trp ";
        $query .= "JOIN periksas as prx on prx.id = trp.periksa_id ";
        $query .= "JOIN jenis_tarifs as jtf on jtf.id = trp.jenis_tarif_id ";
        $query .= "AND jtf.jenis_tarif = 'Gula Darah' "; // Gula Darah
        $tenant_id = is_null(session()->get('tenant_id')) ? 1 : session()->get('tenant_id');
		$query .= "AND trp.tenant_id = " . $tenant_id  . " ";
        $query .= "AND trp.keterangan_pemeriksaan REGEXP '^[0-9]+$' ";  // keterangan_pemeriksaan berbentuk number
        $query .= "AND prx.pasien_id in "; 
        $query .= "( "; 
        foreach ($pasien_ids as $k => $id) {
            if ($k) {
                $query .= ",'" . $id . "'";
            } else {
                $query .= "'" . $id . "'";
            }
        }
        $query .= ") "; 
        $query .= "ORDER BY prx.pasien_id, trp.keterangan_pemeriksaan * 1 asc "; 
        $data = DB::select($query);

        $data_gula_tertinggi_per_pasien = [];

        foreach ($data as $d) {
            $data_gula_tertinggi_per_pasien[$d->pasien_id] = $d->keterangan_pemeriksaan;
        }

        $data_pasien_id_gula_normal = [];

        foreach ($data_gula_tertinggi_per_pasien as $k => $d) {
            if ( $d < 131 ) {
                $data_pasien_id_gula_normal[] = $k;
            }
        }
        return $data_pasien_id_gula_normal;
    }
}
