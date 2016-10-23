<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Sms;

class AngkaKontak extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:kontak';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirimkan sms ke peserta bpjs untuk meningkatkan angka kontak';

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
		Sms::sendSms('+6281381912803', ' are you ready?');
        //
    }
}
