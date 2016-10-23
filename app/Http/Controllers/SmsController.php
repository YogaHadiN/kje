<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Input;
use App\Sms;
use App\Classes\Yoga;
use twilio\rest\client;
use twilio\exceptions\twilioexception;
class SmsController extends Controller
{

	public function sms(){
		//return env('TWILLIO_NUMBER');
		return view('sms.index', compact(''));
	}
	public function smsPost(){
		$rules = [
			'nomor' => 'required',
			'pesan' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		
		return Sms::sendSms( Input::get('nomor'), Input::get('pesan'));
	}
	public function smsBpjs($id){
		Sms::smsBpjs(Pasien::find($id), 'okelah kalau begitu');
	}
	

}



    
