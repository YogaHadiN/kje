<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Sms;

class smsDonnaruko extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:donnaruko';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SMS donna penyewa ruko ciputat';

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
     * @return mixed
     */
    public function handle()
    {
		$pesan = "Siang dok, mengingatkan skr sdh 2 bulan sblm ms sewa habis.apa mau perpanjang sewa ruko? bls di 081381912803";
		Sms::send('081282098500', $pesan);
		Sms::send('081381912803', $pesan);
    }
}
