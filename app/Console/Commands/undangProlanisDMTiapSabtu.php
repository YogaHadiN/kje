<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pasien;
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
        $query .= "AND sudah_kontak_bulan_ini = 0;";
        $pasiens = DB::select($query);

        $data   = [];
        $notelp = [];
        foreach ($pasiens as $pasien) {
            $message = 'Selamat siang. Maaf mengganggu. Kami dari Klinik Jati Elok. Izin mengingatkan bahwa peserta BPJS atas nama ';
            $message .= PHP_EOL;
            $message .= PHP_EOL;
            $message .= '%' . ucfirst($pasien->nama) . '% ' ;
            $message .= PHP_EOL;
            $message .= PHP_EOL;
            $message .= 'untuk melakukan pemeriksaan rutin Gula Darah di Klinik Jati Elok setiap bulannya. ';
            $message .= PHP_EOL;
            $message .= 'Izin menanyakan kira-kira bapak / ibu berkenan untuk periksa hari ini atau besok?';
            $message .= PHP_EOL;
            $message .= 'Mohon konfirmasinya. Terima kasih';
            $message .= PHP_EOL;
            $message .= PHP_EOL;
            $message .= 'Jika menurut anda pesan ini dirasa mengganggu, silahkan klik link di bawah ini. Terima kasih';
            $message .= PHP_EOL;
            $message .= 'https:/www.klinikjatielok.com/eksklusi/' . bcrypt($pasien->id);

            $notelp[] = $pasien->no_telp;
            $data[] = [
                'phone'    => $pasien->no_telp,
                'message'  => $message,
                'secret'   => false, // or true
                'priority' => false, // or true
            ];
        }

    }
}
