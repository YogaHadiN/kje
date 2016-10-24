<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;
use Twilio\Exceptions\Twilioexception;
use App\Classes\Yoga;

class Sms extends Model
{
	public static function sendSms($no, $message){
	
		// Step 2: set our AccountSid and AuthToken from https://twilio.com/console
		$AccountSid =env('TWILLIO_ACCOUNT_SID');
		$AuthToken =env('TWILLIO_AUTH_TOKEN');
		// Step 3: instantiate a new Twilio Rest Client
		$client = new Client($AccountSid, $AuthToken);
		// Step 4: make an array of people we know, to send them a message. 
		// Feel free to change/add your own phone number and name here.
		$sms = $client->account->messages->create(
			// the number we are sending to - Any phone number
			$no,
			array(
				// Step 6: Change the 'From' number below to be a valid Twilio number 
				// that you've purchased
				'from' =>env('TWILLIO_NUMBER'), 
				// the sms body
				'body' => $message
			)
		);

		return $sms->sid;


		// Display a confirmation message on the screen
	}

	public static function smsBpjs($pasien, $message){
	
		// Step 2: set our AccountSid and AuthToken from https://twilio.com/console
		$AccountSid =env('TWILLIO_ACCOUNT_SID');
		$AuthToken =env('TWILLIO_AUTH_TOKEN');
		// Step 3: instantiate a new Twilio Rest Client
		$client = new Client($AccountSid, $AuthToken);
		// Step 4: make an array of people we know, to send them a message. 
		// Feel free to change/add your own phone number and name here.
		$sms_id = Yoga::customId('App\SmsBpjs');
		$callBackUrl = url('sms/report/' . $sms_id );
		$no = $pasien->no_telp;

		$length = strlen($no);
		$no_array[0] = substr($no, 0, 1);
		$no_array[1] = substr($no, 1, $length );
		if ($no_array[0] == '0') {
			$no = '+62' . $no_array[1];
		} else if ($no_array[0] == '+'){

		} else {
			$no = '+62' . $no;
		}

		$sms = $client->account->messages->create(
			// the number we are sending to - Any phone number
			$no,
			array(
				// Step 6: Change the 'From' number below to be a valid Twilio number 
				// that you've purchased
				'from' =>env('TWILLIO_NUMBER'), 
				// the sms body
				'body' => $message
			)
		);
		$sb					= new SmsBpjs;
		$sb->pasien_id   = $pasien->id;
		$sb->pesan   = $message;
		$sb->save();
		// Display a confirmation message on the screen
	}
	private function split_on($string, $num) {
	}
}
