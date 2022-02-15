<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper;
use Log;

class MutasiBankController extends Controller
{
	public function info(){
		// Get Account information
		$result = Helper::GetAccount();
		$data1 = json_decode($result);

		$date_from = '2020-02-01';
		$date_to = '2020-02-29';
		$acc_id = 1270;

		/// Get Account Statement
		$result = Helper::GetAccountStatement($acc_id,$date_from,$date_to);
		$data2 = json_decode($result);
		dd( compact(
				'data1', 'data2', 'date_to', 'date_from'
		));
	}
	public function mootaCallback(){
		Log::info('ini dipanggil');
		$notifications = json_decode( file_get_contents("php://input") );
		Log::info('=========================================================================');
		Log::info('notification yang ada:');
		Log::info($notifications);
		Log::info('=========================================================================');
		if(!is_array($notifications)) {
			$notifications = json_decode( $notifications );
		}
		if(count($notifications) > 0 ) {
			foreach( $notifications as $notification) {
				Log::info(json_encode($notification));
			}
		}
	}
	
	
}
