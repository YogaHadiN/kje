<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Outbox;
use App\Pengeluaran;
use App\FakturBelanja;
use App\Periksa;
use DB;
use Mail;
use Input;

class testcommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
		 $confirm = Mail::send('email.error', [
			 'url'    => Input::url(),
			 'method' => Input::method(),
			 'error'  => 'dfasdfalkjhsadkfjhasdlkfdaslkjhfasljkflasjfhlajhsflkasjhfdljk'
		 ], function($m){
			  $m->from('admin@mailgun.org', 'Yoga Hadi Nugroho');
			  $m->to('yoga_email@yahoo.com', 'Yoga Hadi Nugroho');
			  $m->subject('Error from KJE');
		 });
		 return dd( $confirm );
	}
}
