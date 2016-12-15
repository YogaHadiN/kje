<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;
use Twilio\Exceptions\Twilioexception;
use App\Classes\Yoga;
use App\Outbox;

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
	public static function sendBlast($array, $message){ // $array = array dari nomor telepon2, $message = isi pesan yang di sms
		// Step 2: set our AccountSid and AuthToken from https://twilio.com/console
		$AccountSid =env('TWILLIO_ACCOUNT_SID');
		$AuthToken =env('TWILLIO_AUTH_TOKEN');
		// Step 3: instantiate a new Twilio Rest Client
		$client = new Client($AccountSid, $AuthToken);
		// Step 4: make an array of people we know, to send them a message. 
		// Feel free to change/add your own phone number and name here.
		foreach ($array as $no) {
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
		}
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
	public function formatSmsNumber($number) {
		$split = str_split($number);
		$num = '+62';
		if ( $split[0] == '0' ) {
			foreach ($split as $k => $sp) {
				if ($k > 0) {
					$num .= $sp;
				}
			}
		} else if( $split[0] == '8' ||  $split[0] == '2'  ){
		    $num = '+62' . $number;
		}
		return $num;
	}

	public function smsMesabot(){
		
	}

	public function smsZenziva(){
		
	}

	public static function send($telepon, $message){
		// Script http API SMS Reguler Zenziva
		$userkey=env('ZENZIVA_USERKEY'); // userkey lihat di zenziva

		$passkey=env('ZENZIVA_PASSKEY'); // set passkey di zenziva

		$url = 'https://reguler.zenziva.net/apps/smsapi.php';$curlHandle = curl_init();

		curl_setopt($curlHandle, CURLOPT_URL, $url);

		curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'userkey='.$userkey.'&passkey='.$passkey.'&nohp='.$telepon.'&pesan='.urlencode($message));

		curl_setopt($curlHandle, CURLOPT_HEADER, 0);

		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);

		curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);

		curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);

		curl_setopt($curlHandle, CURLOPT_POST, 1);

		$results = curl_exec($curlHandle);

		curl_close($curlHandle);
		return $results;
	}

	public static function gammuSurvey($telepon, $message, $periksa_id){
		$o						= new Outbox;
		$o->DestinationNumber   = $telepon;
		$o->TextDecoded			= $message;
		$o->CreatorID			= 'gammu';
		$confirm = $o->save();
		if ($confirm) {
			\Log::info('kirim '. $telepon . ' dengan pesan : ' . $message);

			$pk					= new PesanKeluar;
			$pk->periksa_id     = $periksa_id;
			$pk->pesan			= $message;
			$pk->outbox_id		= $o->id;
			$pk->save();
			
			return $confirm;
		}
		return false;
	}

	public static function gammuSend($telepon, $message){
		$o						= new Outbox;
		$o->DestinationNumber   = $telepon;
		$o->TextDecoded			= $message;
		$o->CreatorID			= 'gammu';
		return $o->save();
	}
}
