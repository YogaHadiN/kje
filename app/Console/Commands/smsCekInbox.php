<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Inbox;

class smsCekInbox extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:cekInbox';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek Inbox sms tiap 5 menit sekali';

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
		$inbox = Inbox::where('processed', 'false')
						->get();
		$countInbox = $inbox->count();
		if ( $countInbox > 0 ) {
			$nomors = [];
			$deletes_ids = [];
			foreach ($inbox as $i) {
				$nomor = $i->SenderNumber;
				$nomor = str_replace('+62', '0', $nomor);
				$nomors[]= $nomor;
				$deletes_ids[] = $i->id;
			}
			return dd($nomors);
			$query  = "SELECT * FROM ";
			$query .= "periksas as px join ";
			$query .= "pasiens as ps on px.pasien_id = px.id ";
			$query .= "WHERE px.created_at between '" . date('Y-m-d',strtotime('-7 day',strtotime(date('Y-m-d')))) . " 00:00:00' and '" . date('Y-m-d H:i:s'). "'";
			$query .= "AND ps.no_telp in ('" . $nomors[0] . "'";
			foreach ($nomors as $k=>$n) {
				if ($k > 0) {
					$query .= ",'" . $n . "'";
				}
			}
			$query .= ");";
			return dd( $query );
			$inbox = DB::select($query);
		}
    }
}
