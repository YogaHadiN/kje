<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Woowa extends Model
{
	public static function send($no, $message){
		$key= env('WOOWA_KEY'); //this is demo key please change with your own key
		$url='http://116.203.92.59/api/send_message';
		$data = array(
		  "phone_no"=> $no,
		  "key"		=>$key,
		  "message"	=> $message
		);
		$data_string = json_encode($data);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 360);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		  'Content-Type: application/json',
		  'Content-Length: ' . strlen($data_string))
		);
		echo $res=curl_exec($ch);
		curl_close($ch);
	}
	
}
